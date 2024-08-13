<?php
include("../config/int.php");
include("../config/conex.php");
include("../helpers/func.php");
include("../helpers/binary_func.php");
	if(isset($_POST['user_id'])){
		$user_code = SA_Encryption::decrypt_from_url_param($_POST['user_id']);
		$binQ = $conex->query("SELECT * FROM user_tree WHERE USER_CODE = '$user_code'");
		$bin_data = $binQ->fetch_assoc();
		$userQ = $conex->query("SELECT * FROM users WHERE CODE = '$user_code'");
		$user_data = $userQ->fetch_assoc();
		$f_Left = $bin_data['LEFT_SIDE']; 
		$f_Right = $bin_data['RIGHT_SIDE'];
?>
<div class="row my-3">
	<div class="col">
		<div class="tree_cont">
			<img src="images/yes_user.png" class="ref_img_active d-block mx-auto" user-data="<?=SA_Encryption::encrypt_to_url_param($user_code);?>">
			<p><?=$user_data['REF_ID'];?></p>
			<?=get_tree_user_data($conex, $user_code);?>
		</div>
	</div>
</div>
<div class="row my-3 main_tree">
	<div class="col first_child_tree">
		<div class="tree_cont">
			<img src="images/<?=((empty($f_Left))?'no_user.png':'yes_user.png');?>" class="<?=((empty($f_Left))?'ref_img_inactive':'ref_img_active');?> d-block mx-auto" <?=((empty($f_Left))?'':'user-data="'.SA_Encryption::encrypt_to_url_param($f_Left).'"');?>>
			<p><?=((empty($f_Left))?'NO USER':single_user_data($conex, $f_Left)['REF_ID']);?></p>
			<?=((empty($f_Left))?'<span></span>':get_tree_user_data($conex, $f_Left));?>
		</div>
	</div>
	<div class="col first_child_tree">
		<div class="tree_cont">
			<img src="images/<?=((empty($f_Right))?'no_user.png':'yes_user.png');?>" class="<?=((empty($f_Right))?'ref_img_inactive':'ref_img_active');?> d-block mx-auto" <?=((empty($f_Right))?'':'user-data="'.SA_Encryption::encrypt_to_url_param($f_Right).'"');?>>
			<p><?=((empty($f_Right))?'NO USER':single_user_data($conex, $f_Right)['REF_ID']);?></p>
			<?=((empty($f_Right))?'<span></span>':get_tree_user_data($conex, $f_Right));?>
		</div>
	</div>
</div>
<div class="row my-3 sub_tree">
	<div class="col first_child_tree">
		<div class="tree_cont">
			<?php
				$first = get_binary_users($conex, $f_Left)['LEFTY'];
			?>
			<img src="images/<?=((empty($first))?'no_user.png':'yes_user.png');?>" class="<?=((empty($first))?'ref_img_inactive':'ref_img_active');?> d-block mx-auto" <?=((empty($first))?'':'user-data="'.SA_Encryption::encrypt_to_url_param($first).'"');?>>
			<p><?=((empty($first))?'NO USER':single_user_data($conex, $first)['REF_ID']);?></p>
			<?=((empty($first))?'<span></span>':get_tree_user_data($conex, $first));?>
		</div>
	</div>
	<div class="col first_child_tree">
		<div class="tree_cont">
			<?php
				$second = get_binary_users($conex, $f_Left)['RIGHTY'];
			?>
			<img src="images/<?=((empty($second))?'no_user.png':'yes_user.png');?>" class="<?=((empty($second))?'ref_img_inactive':'ref_img_active');?> d-block mx-auto" <?=((empty($second))?'':'user-data="'.SA_Encryption::encrypt_to_url_param($second).'"');?>>
			<p><?=((empty($second))?'NO USER':single_user_data($conex, $second)['REF_ID']);?></p>
			<?=((empty($second))?'<span></span>':get_tree_user_data($conex, $second));?>
		</div>
	</div>
	<div class="col first_child_tree">
		<div class="tree_cont">
			<?php
				$third = get_binary_users($conex, $f_Right)['LEFTY'];
			?>
			<img src="images/<?=((empty($third))?'no_user.png':'yes_user.png');?>" class="<?=((empty($third))?'ref_img_inactive':'ref_img_active');?> d-block mx-auto" <?=((empty($third))?'':'user-data="'.SA_Encryption::encrypt_to_url_param($third).'"');?>>
			<p><?=((empty($third))?'NO USER':single_user_data($conex, $third)['REF_ID']);?></p>
			<?=((empty($third))?'<span></span>':get_tree_user_data($conex, $third));?>
		</div>
	</div>
	<div class="col first_child_tree">
		<div class="tree_cont">
			<?php
				$four = get_binary_users($conex, $f_Right)['RIGHTY'];
			?>
			<img src="images/<?=((empty($four))?'no_user.png':'yes_user.png');?>" class="<?=((empty($four))?'ref_img_inactive':'ref_img_active');?> d-block mx-auto" <?=((empty($four))?'':'user-data="'.SA_Encryption::encrypt_to_url_param($four).'"');?>>
			<p><?=((empty($four))?'NO USER':single_user_data($conex, $four)['REF_ID']);?></p>
			<?=((empty($four))?'<span></span>':get_tree_user_data($conex, $four));?>
		</div>
	</div>
</div>
<?php
	}
	elseif(isset($_POST['user_code']) && isset($_POST['ref_user'])){
	    $error ='';
	    $user_id = $conex->real_escape_string(clean($_POST['user_code']));
	    $ref_user = SA_Encryption::decrypt_from_url_param($_POST['ref_user']);
	    $userQ = $conex->query("SELECT * FROM users WHERE REF_ID = '$user_id'");
		$user_data = $userQ->fetch_assoc();
		$user_code = $user_data['CODE'];
	    $left_members = down_liner_left($conex, $ref_user)['members'];
	    $right_members = down_liner_right($conex, $ref_user)['members'];
	    $binQ = $conex->query("SELECT * FROM user_tree WHERE USER_CODE = '$user_code'");
	    $bin_rows = $binQ->num_rows;
	    if(!in_array($user_code, $left_members) && !in_array($user_code, $right_members)){
	        $error = 'THERE IS NO SUCH DOWNLINER!';
	    }
	    elseif($bin_rows == 0){
	        $error = 'THERE IS NO SUCH DOWNLINER!';
	    }
	    if(empty($error)){
		$bin ='';
		$bin_data = $binQ->fetch_assoc();
		$f_Left = $bin_data['LEFT_SIDE']; 
		$f_Right = $bin_data['RIGHT_SIDE'];
?>
<div class="row my-3">
	<div class="col">
		<div class="tree_cont">
			<img src="images/yes_user.png" class="ref_img_active d-block mx-auto" user-data="<?=SA_Encryption::encrypt_to_url_param($user_code);?>">
			<p><?=$user_data['REF_ID'];?></p>
			<?=get_tree_user_data($conex, $user_code);?>
		</div>
	</div>
</div>
<div class="row my-3 main_tree">
	<div class="col first_child_tree">
		<div class="tree_cont">
			<img src="images/<?=((empty($f_Left))?'no_user.png':'yes_user.png');?>" class="<?=((empty($f_Left))?'ref_img_inactive':'ref_img_active');?> d-block mx-auto" <?=((empty($f_Left))?'':'user-data="'.SA_Encryption::encrypt_to_url_param($f_Left).'"');?>>
			<p><?=((empty($f_Left))?'NO USER':single_user_data($conex, $f_Left)['REF_ID']);?></p>
			<?=((empty($f_Left))?'<span></span>':get_tree_user_data($conex, $f_Left));?>
		</div>
	</div>
	<div class="col first_child_tree">
		<div class="tree_cont">
			<img src="images/<?=((empty($f_Right))?'no_user.png':'yes_user.png');?>" class="<?=((empty($f_Right))?'ref_img_inactive':'ref_img_active');?> d-block mx-auto" <?=((empty($f_Right))?'':'user-data="'.SA_Encryption::encrypt_to_url_param($f_Right).'"');?>>
			<p><?=((empty($f_Right))?'NO USER':single_user_data($conex, $f_Right)['REF_ID']);?></p>
			<?=((empty($f_Right))?'<span></span>':get_tree_user_data($conex, $f_Right));?>
		</div>
	</div>
</div>
<div class="row my-3 sub_tree">
	<div class="col first_child_tree">
		<div class="tree_cont">
			<?php
				$first = get_binary_users($conex, $f_Left)['LEFTY'];
			?>
			<img src="images/<?=((empty($first))?'no_user.png':'yes_user.png');?>" class="<?=((empty($first))?'ref_img_inactive':'ref_img_active');?> d-block mx-auto" <?=((empty($first))?'':'user-data="'.SA_Encryption::encrypt_to_url_param($first).'"');?>>
			<p><?=((empty($first))?'NO USER':single_user_data($conex, $first)['REF_ID']);?></p>
			<?=((empty($first))?'<span></span>':get_tree_user_data($conex, $first));?>
		</div>
	</div>
	<div class="col first_child_tree">
		<div class="tree_cont">
			<?php
				$second = get_binary_users($conex, $f_Left)['RIGHTY'];
			?>
			<img src="images/<?=((empty($second))?'no_user.png':'yes_user.png');?>" class="<?=((empty($second))?'ref_img_inactive':'ref_img_active');?> d-block mx-auto" <?=((empty($second))?'':'user-data="'.SA_Encryption::encrypt_to_url_param($second).'"');?>>
			<p><?=((empty($second))?'NO USER':single_user_data($conex, $second)['REF_ID']);?></p>
			<?=((empty($second))?'<span></span>':get_tree_user_data($conex, $second));?>
		</div>
	</div>
	<div class="col first_child_tree">
		<div class="tree_cont">
			<?php
				$third = get_binary_users($conex, $f_Right)['LEFTY'];
			?>
			<img src="images/<?=((empty($third))?'no_user.png':'yes_user.png');?>" class="<?=((empty($third))?'ref_img_inactive':'ref_img_active');?> d-block mx-auto" <?=((empty($third))?'':'user-data="'.SA_Encryption::encrypt_to_url_param($third).'"');?>>
			<p><?=((empty($third))?'NO USER':single_user_data($conex, $third)['REF_ID']);?></p>
			<?=((empty($third))?'<span></span>':get_tree_user_data($conex, $third));?>
		</div>
	</div>
	<div class="col first_child_tree">
		<div class="tree_cont">
			<?php
				$four = get_binary_users($conex, $f_Right)['RIGHTY'];
			?>
			<img src="images/<?=((empty($four))?'no_user.png':'yes_user.png');?>" class="<?=((empty($four))?'ref_img_inactive':'ref_img_active');?> d-block mx-auto" <?=((empty($four))?'':'user-data="'.SA_Encryption::encrypt_to_url_param($four).'"');?>>
			<p><?=((empty($four))?'NO USER':single_user_data($conex, $four)['REF_ID']);?></p>
			<?=((empty($four))?'<span></span>':get_tree_user_data($conex, $four));?>
		</div>
	</div>
</div>
<?php
	    }else{
	        echo'<div class="row h-100 justify-content-center align-items-center">
				<div class="col-12">
				  <h2 class="text-center">'.$error.'</h2>
				</div>   
			  </div>';    
	    }
	}
	else{
		echo'<div class="row h-100 justify-content-center align-items-center">
				<div class="col-12">
				  <h2 class="text-center">THERE IS SOMETHING WRONG!</h2>
				</div>   
			  </div>';
	}
?>