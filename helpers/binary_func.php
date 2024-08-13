<?php
// get roi
function get_roi($roi, $amount, $date, $days, $status, $update_date){
	$total_roi  = ($roi/100)*$amount;
	$pdate = date('Y-m-d', strtotime($date));
	$date = date_create($pdate);
	$new_date = date_add($date,date_interval_create_from_date_string("1500 minutes"));
	$new_date = date_format($new_date,"Y-m-d h:i:s");
	$spent_days = floor(differenceInHours($new_date, date('Y-m-d h:i:s'))/24);
	if($status == 2){
	 return number_format($total_roi*$days, 4);      
	}
	elseif($status == 3){
	    $spent_days = floor(differenceInHours($new_date, $update_date)/24);
	    return number_format($total_roi*$spent_days, 4); 
	}
	elseif($status == 0){
	    return 0;
	}
	else{
	 return number_format($total_roi*$spent_days, 4);   
	}
}
// get remaining days
function get_roi_remain_days($conex, $plan_code, $date, $days, $status, $update_date){
	$pdate = date('Y-m-d', strtotime($date));
	$date = date_create($pdate);
	$new_date = date_add($date,date_interval_create_from_date_string("1500 minutes"));
	$new_date = date_format($new_date,"Y-m-d h:i:s");
	$spent_days = floor(differenceInHours($new_date, date('Y-m-d h:i:s'))/24);
	if($spent_days >= $days && $status == 1){
		$conex->query("UPDATE user_plans SET STATUS = 2 WHERE CODE = '$plan_code'");
		return 0;
	}
	elseif($status == 2){
		return 0;
	}
	elseif($status == 3){
	    return floor(differenceInHours($new_date, $update_date)/24);
	}
	elseif($status == 0){
		return $days;
	}
	else{
		return $days - $spent_days;
	}
}
// plan status
function plan_status($status){
	if($status == 0){
		return 'Inactive';
	}
	elseif($status == 1){
		return 'Active';
	}
	elseif($status == 2){
		return 'Expire';
	}
	elseif($status == 3){
		return '10x Expire';
	}
}
// my insert
function my_invest($conex, $user_code){
	$insQ = $conex->query("SELECT IFNULL(SUM(AMOUNT), 0) AMOUNT FROM user_plan_view WHERE USER_CODE = '$user_code' AND STATUS IN (1, 2, 3)");
	$ins_data = $insQ->fetch_assoc();
	return $ins_data['AMOUNT'];
}
// my insert
function my_current_invest($conex, $user_code){
	$insQ = $conex->query("SELECT IFNULL(SUM(AMOUNT), 0) AMOUNT FROM user_plan_view WHERE USER_CODE = '$user_code' AND STATUS = 1");
	$ins_data = $insQ->fetch_assoc();
	return $ins_data['AMOUNT'];
}
// my rank
function my_rank($conex, $user_code){
	$rankQ = $conex->query("SELECT * FROM user_rank_view WHERE USER_CODE = '$user_code' AND STATUS = 1");
	$rank_rows = $rankQ->num_rows;
	$code = 0;
	if($rank_rows == 0){
		$name = 'Beginner';
	}else{
		$rank_data = $rankQ->fetch_assoc();
		$name = $rank_data['NAME'];
		$code = $rank_data['RANK_CODE'];
	}
	$rank['name']= $name;
	$rank['code']= $code;
	return $rank;
}
// my binary commission
function my_binary_commission($conex, $user_code){
	$binQ = $conex->query("SELECT IFNULL(SUM(COMMISSION), 0) COMMISSION FROM binary_commission WHERE USER_CODE = '$user_code'");	
	$bin_data = $binQ->fetch_assoc();
	return $bin_data['COMMISSION'];
}
// my binary commission
function my_refferal_commission($conex, $user_code){
	$refQ = $conex->query("SELECT IFNULL(SUM(COMMISSION), 0) COMMISSION FROM referral_commission WHERE USER_CODE = '$user_code' AND STATUS = 1");	
	$ref_data = $refQ->fetch_assoc();
	return $ref_data['COMMISSION'];
}
// down liner left
function down_liner_left($conex, $user_code){
    $treeQ = $conex->query("SELECT * FROM user_tree WHERE USER_CODE = '$user_code'");
    $tree_data = $treeQ->fetch_assoc();
    $tree_code = $tree_data['CODE'];
	$sql = $conex->query("SELECT * FROM user_tree WHERE CODE >= '$tree_code'");
	$main = array();
	$cont =0;
	while($data = $sql->fetch_assoc()){
		$cont++;
		if($cont == 1 AND empty($data['LEFT_SIDE'])){
			break;
		}
		elseif($cont == 1 AND !empty($data['LEFT_SIDE'])){
			$main[] = $data['LEFT_SIDE'];
		}
		else{
			if(in_array($data['USER_CODE'], $main)){
				if(!empty($data['LEFT_SIDE'])){
					$main[] = $data['LEFT_SIDE'];
				}
				if(!empty($data['RIGHT_SIDE'])){
					$main[] = $data['RIGHT_SIDE'];
				}
			}
			else{
				continue;
			}
		}
	}
	$data['count'] = count($main);
	$data['members'] = $main;
	return $data;
}
// down liner right
function down_liner_right($conex, $user_code){
    $treeQ = $conex->query("SELECT * FROM user_tree WHERE USER_CODE = '$user_code'");
    $tree_data = $treeQ->fetch_assoc();
    $tree_code = $tree_data['CODE'];
	$sql = $conex->query("SELECT * FROM user_tree WHERE CODE >= '$tree_code'");
	$main = array();
	$cont =0;
	while($data = $sql->fetch_assoc()){
		$cont++;
		if($cont == 1 AND empty($data['RIGHT_SIDE'])){
			break;
		}
		elseif($cont == 1 AND !empty($data['RIGHT_SIDE'])){
			$main[] = $data['RIGHT_SIDE'];
		}
		else{
			if(in_array($data['USER_CODE'], $main)){
				if(!empty($data['RIGHT_SIDE'])){
					$main[] = $data['RIGHT_SIDE'];
				}
				if(!empty($data['LEFT_SIDE'])){
					$main[] = $data['LEFT_SIDE'];
				}
			}
			else{
				continue;
			}
		}
	}
	$data['count'] = count($main);
	$data['members'] = $main;
	return $data;
}
// down line invest
function down_liner_invest($conex, $main){
	$inest = 0;
	$paid = 0;
	if(!empty($main)){
		foreach($main as $user_code){
			$sql = $conex->query("SELECT IFNULL(SUM(AMOUNT), 0) AMOUNT FROM user_plan_view WHERE USER_CODE = '$user_code' AND STATUS IN (1, 2, 3)");
			$data = $sql->fetch_assoc();
			$inest += $data['AMOUNT'];
			if(!empty($data['AMOUNT'])){
				$paid++;
			}
		}
	}
	$ins['paid'] = $paid;
	$ins['unpaid'] = count($main) - $paid;
	$ins['ins'] = (int)$inest;
	return $ins;
}
// previous down line invest
function prev_down_liner_invest($conex, $main){
	$inest = 0;
	$paid = 0;
	if(!empty($main)){
		foreach($main as $user_code){
			$sql = $conex->query("SELECT IFNULL(SUM(AMOUNT), 0) AMOUNT FROM user_plan_view WHERE DATE_FORMAT(DATE_TIME, '%Y-%m-%d') < CURDATE() AND USER_CODE = '$user_code' AND STATUS IN (1, 2, 3)");
			$data = $sql->fetch_assoc();
			$inest += $data['AMOUNT'];
			if(!empty($data['AMOUNT'])){
				$paid++;
			}
		}
	}
	$ins['paid'] = $paid;
	$ins['unpaid'] = count($main) - $paid;
	$ins['ins'] = (int)$inest;
	return $ins;
}
// today down line invest
function today_down_liner_invest($conex, $main){
	$inest = 0;
	$paid = 0;
	if(!empty($main)){
		foreach($main as $user_code){
			$sql = $conex->query("SELECT IFNULL(SUM(AMOUNT), 0) AMOUNT FROM user_plan_view WHERE DATE_FORMAT(DATE_TIME, '%Y-%m-%d') = CURDATE() AND USER_CODE = '$user_code' AND STATUS IN (1, 2, 3)");
			$data = $sql->fetch_assoc();
			$inest += $data['AMOUNT'];
			if(!empty($data['AMOUNT'])){
				$paid++;
			}
		}
	}
	$ins['paid'] = $paid;
	$ins['unpaid'] = count($main) - $paid;
	$ins['ins'] = (int)$inest;
	return $ins;
}
// upliner binary commission
function up_line($conex, $user_code){
    if($user_code == 1){
		return false;
	}
	$treeQ = $conex->query("SELECT * FROM user_tree WHERE USER_CODE = '$user_code'");
    $tree_data = $treeQ->fetch_assoc();
    $tree_code = $tree_data['CODE'];
	$searchQ = $conex->query("SELECT * FROM user_tree WHERE CODE < '$tree_code'");
	while($search_data = $searchQ->fetch_assoc()){
		$binary_user = $search_data['USER_CODE'];
		$caping = current_package_caping($conex, $binary_user)['caping'];
		$caping_plan_code = current_package_caping($conex, $binary_user)['code'];
		$right_business = user_carry_amount($conex, $binary_user)['right']; 
		$left_business = user_carry_amount($conex, $binary_user)['left']; 
		$match = min($right_business, $left_business);
		if($match != 0){
		    $commission = (0.1*$match);
			if($commission >= $caping && !empty($caping)){
				$commission = $caping;
			}
			if(my_binary_commission($conex, $binary_user) >= (my_current_invest($conex, $binary_user))*10){
				tenx_expire_txn($conex, $binary_user);
				$conex->query("UPDATE user_plans SET STATUS = 3, UPDATE_DATE = NOW() WHERE USER_CODE = '$binary_user' AND STATUS = 1");
				$conex->query("UPDATE users SET STATUS = 4 WHERE CODE = '$binary_user'");
			}else{
				$check_binaryQ = $conex->query("SELECT * FROM `binary_commission` WHERE USER_CODE = '$binary_user' AND DATE_FORMAT(DATE_TIME, '%Y-%m-%d') = CURDATE() AND STATUS = 0");
				$check_rows = $check_binaryQ->num_rows;
				if($check_rows > 0){
					$conex->query("UPDATE `binary_commission` SET AMOUNT = '$match', COMMISSION = '$commission' WHERE USER_CODE = '$binary_user' AND DATE_FORMAT(DATE_TIME, '%Y-%m-%d') = CURDATE() AND STATUS = 0");	
				}else{
					$conex->query("INSERT INTO binary_commission (USER_CODE, AMOUNT, COMMISSION) VALUES ('$binary_user', '$match', '$commission')");
				}
			}
		}
	}
}
// caping expire txn
function tenx_expire_txn($conex, $user_code){
    $planQ = $conex->query("SELECT * FROM `user_plan_view` WHERE USER_CODE ='$user_code' AND STATUS = 1");
    while($plan_data = $planQ->fetch_assoc()){
        $roi = get_roi($plan_data['ROI'], $plan_data['AMOUNT'], $plan_data['DATE_TIME'], $plan_data['DAYS'], $plan_data['STATUS'], $plan_data['UPDATE_DATE']);
        $conex->query("INSERT INTO user_trxn (AMOUNT, USER_CODE, TYPE) VALUES ('$roi', '$user_code', 4)");
    }
}
// user carry amount
function user_carry_amount($conex, $user_code){
	$prev_left_business = prev_down_liner_invest($conex, down_liner_left($conex, $user_code)['members'])['ins'];
	$prev_right_business = prev_down_liner_invest($conex, down_liner_right($conex, $user_code)['members'])['ins'];
	$today_left_business = today_down_liner_invest($conex, down_liner_left($conex, $user_code)['members'])['ins'];
	$today_right_business = today_down_liner_invest($conex, down_liner_right($conex, $user_code)['members'])['ins'];
	$min = min($prev_left_business, $prev_right_business);
	$prev_left = $prev_left_business - $min;
	$prev_right = $prev_right_business - $min;
	$data['left'] = $prev_left +$today_left_business;  
	$data['right'] = $prev_right +$today_right_business;  
	return $data;
}
// current package Caping
function current_package_caping($conex, $user_code){
	$sql = $conex->query("SELECT IFNULL(MAX(AMOUNT), 0) AMOUNT, CAPING, USER_PLAN_CODE FROM user_plan_view WHERE STATUS = 1 AND USER_CODE = '$user_code'");
	$data = $sql->fetch_assoc();
	$data['caping'] = $data['CAPING'];
	$data['code'] = $data['USER_PLAN_CODE'];
	return $data;
}
// withdraw status
function withdraw_status($status){
	if($status == 0){
		$data[0] = 'PENDDING';
		$data[1] = 'yellow';
	}
	elseif($status == 1){
		$data[0] = 'APPROVED';
		$data[1] = 'approve';
	}
	elseif($status == 2){
		$data[0] = 'REJECTED';
		$data[1] = 'red';
	}
	return $data;
}
// get_tree_user_data
function get_tree_user_data($conex, $user_code){
	$data ='<div class="ref_table">';
	$sql = $conex->query("SELECT * FROM users WHERE CODE = '$user_code'");
	$user_data = $sql->fetch_assoc();
	$sponser_code = $user_data['REFFERED_USER'];
	$sponserQ = $conex->query("SELECT * FROM users WHERE CODE = '$sponser_code'");
	$sponser_data = $sponserQ->fetch_assoc();
	$data .='<div class="pop_detail">';
	$img = ((empty($user_data['IMG']))?'default_user.png':$user_data['IMG']);
	$data .='<img src="images/users/'.$img.'" class="float-left">';
	$data .='<p><span class="py-1 d-block text-center">'.$user_data['FIRST_NAME'].' '.$user_data['LAST_NAME'].'</span>';
	$data .='<span class="py-1 d-block text-center">USER ID: '.$user_data['REF_ID'].'</span>';
	$data .='<span class="py-1 d-block text-center">SPONSOR: '.$sponser_data['REF_ID'].'</span></p>';
	$data .='</div>';
	$data .='<table class="w-100 my_table">';
	$data .='<tr>';
	$data .='<td class="text-left">Join Date:</td>';
	$data .='<td class="text-right">'.date('Y/m/d', strtotime($user_data['JOIN_DATE'])).'</td>';
	$data .='</tr>';
	$data .='<tr>';
	$data .='<td class="text-left"><b>Description</b></td>';
	$data .='<td class="text-left"><b>L</b></td>';
	$data .='<td class="text-left"><b>R</b></td>';
	$data .='</tr>';
	$data .='<tr>';
	$data .='<td class="text-left">Team:</td>';
	$data .='<td class="text-left">'.down_liner_left($conex, $user_code)['count'].'</td>';
	$data .='<td class="text-left">'.down_liner_right($conex, $user_code)['count'].'</td>';
	$data .='</tr>';
	$data .='<tr>';
	$data .='<td class="text-left">Unpaid:</td>';
	$data .='<td class="text-left">'.down_liner_invest($conex, down_liner_left($conex, $user_code)['members'])['unpaid'].'</td>';
	$data .='<td class="text-left">'.down_liner_invest($conex, down_liner_right($conex, $user_code)['members'])['unpaid'].'</td>';
	$data .='</tr>';
	$data .='<tr>';
	$data .='<td class="text-left">Business:</td>';
	$data .='<td class="text-left">'.down_liner_invest($conex, down_liner_left($conex, $user_code)['members'])['ins'].'</td>';
	$data .='<td class="text-left">'.down_liner_invest($conex, down_liner_right($conex, $user_code)['members'])['ins'].'</td>';
	$data .='</tr>';
	$data .='<tr>';
	$data .='<td class="text-left">Carry Forward:</td>';
	$data .='<td class="text-left">'.user_carry_amount($conex, $user_code)['left'].'</td>';
	$data .='<td class="text-left">'.user_carry_amount($conex, $user_code)['right'].'</td>';
	$data .='</tr>';
	$data .='</table>';
	$data .='</div>';
	return $data;
}
// binary commission
function get_binary_commission($conex, $user_code){
	$sql = $conex->query("SELECT IFNULL(SUM(COMMISSION), 0) AMOUNT FROM binary_commission WHERE STATUS = 1 AND USER_CODE = '$user_code'");
	$data = $sql->fetch_assoc();
	return (int)$data['AMOUNT'];
}
// refferal commission
function get_refferal_commission($conex, $user_code){
	$sql = $conex->query("SELECT IFNULL(SUM(COMMISSION), 0) AMOUNT FROM referral_commission WHERE STATUS = 1 AND USER_CODE = '$user_code'");
	$data = $sql->fetch_assoc();
	return $data['AMOUNT'];
}
// rank reward
function get_rank_reward($conex, $user_code){
	$sql = $conex->query("SELECT IFNULL(SUM(REWARD), 0) AMOUNT FROM user_rank_view WHERE USER_CODE = '$user_code'");
	$data = $sql->fetch_assoc();
	return $data['AMOUNT'];
}
// total roi
function get_total_roi($conex, $user_code){
	$roi = 0;
	$sql = $conex->query("SELECT * FROM user_plan_view WHERE USER_CODE = '$user_code' AND STATUS IN (1, 2, 3)");
	while($data = $sql->fetch_assoc()){
		$roi += get_roi($data['ROI'], $data['AMOUNT'], $data['DATE_TIME'], $data['DAYS'], $data['STATUS'],$data['UPDATE_DATE'] );
	}
	return $roi;
}
// received total fund
function received_transfered_fund($conex, $user_code){
	$sql = $conex->query("SELECT IFNULL(SUM(AMOUNT), 0) AMOUNT FROM user_transfer WHERE RECEIVER = '$user_code'");
	$data = $sql->fetch_assoc();
	return $data['AMOUNT'];
}
// get total bonus
function get_total_bonus($conex, $user_code){
	$sql = $conex->query("SELECT IFNULL(SUM(AMOUNT), 0) AMOUNT FROM user_trxn WHERE TYPE IN (2, 3, 4, 5) AND USER_CODE = '$user_code'");
	$data = $sql->fetch_assoc();
	return $data['AMOUNT'];
}
// spent e-wallet for buy plans
function ew_buy_plans($conex, $user_code){
	$sql = $conex->query("SELECT IFNULL(SUM(AMOUNT), 0) AMOUNT FROM user_plan_view WHERE USER_CODE = '$user_code' AND TYPE = 'EW'");
	$data = $sql->fetch_assoc();
	return $data['AMOUNT'];
}
// sent total fund
function send_transfered_fund($conex, $user_code){
	$sql = $conex->query("SELECT IFNULL(SUM(TRANSFER_AMOUNT), 0) AMOUNT FROM user_transfer WHERE SENDER = '$user_code'");
	$data = $sql->fetch_assoc();
	return $data['AMOUNT'];
}
// total withdraw
function total_withdraw($conex, $user_code){
	$sql = $conex->query("SELECT IFNULL(SUM(AMOUNT), 0) AMOUNT FROM user_withdraw WHERE USER_CODE = '$user_code' AND STATUS IN (0, 1)");
	$data = $sql->fetch_assoc();
	return $data['AMOUNT'];
}
// e-wallet
function e_wallet($bonus, $received_fund, $sent_fund, $withdraw){
	return ($bonus + $received_fund) - ($sent_fund + $withdraw);
}
?>