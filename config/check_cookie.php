<?php
	if(isset($_COOKIE['todo_nama'])){
		$cookie_email = $conex->real_escape_string(clean(SA_Encryption::decrypt_from_url_param($_COOKIE['todo_nama'])));
		if(!empty($cookie_email)){
			$sql = $conex->query("SELECT * FROM users WHERE EMAIL = '$cookie_email'");
			$cookie_rows = $sql->num_rows;
			if($cookie_rows == 1){
				$cookie_data = $sql->fetch_assoc();
				$user_code = $cookie_data['CODE'];
				$coinQ = $conex->query("SELECT IFNULL(SUM(AMOUNT),0) COINS FROM `user_plan_view` WHERE USER_CODE = '$user_code'");
				$coin_data = $coinQ->fetch_assoc();
				$coins = $coin_data['COINS'];
				$hours = differenceInHours($cookie_data['JOIN_DATE'], date("Y-m-d h:i:s"));
				if($cookie_data['STATUS'] == 2){
					setcookie('todo_nama', '', 0,'/', false, false);
				}
				elseif($cookie_data['CODE_STATUS'] == 0){
					setcookie('todo_nama', '', 0,'/', false, false);
				}
				elseif($coins == 0 AND $hours >= 72 AND $cookie_data['TYPE'] == 'USER'){
					setcookie('todo_nama', '', 0,'/', false, false);
				}
				else{
					$_SESSION['boss_user'] = $cookie_data['CODE'];
					$_SESSION['boss_type'] = $cookie_data['TYPE'];
				}
			}
		}
	}
?>