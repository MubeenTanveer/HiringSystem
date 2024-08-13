<?php
include("../config/int.php");
include("../config/conex.php");
include("../helpers/func.php");
include("../helpers/binary_func.php");
if(isset($_POST['approve_code'])){
	$approve_code = clean(SA_Encryption::decrypt_from_url_param($_POST['approve_code']));
	$sql = $conex->query("SELECT * FROM user_withdraw WHERE CODE = '$approve_code'");
	$view_rows = $sql->num_rows;
	if($view_rows > 0){
		$delQ = $conex->query("UPDATE user_withdraw SET STATUS = 1 WHERE CODE = '$approve_code'");
		if($delQ){
			echo'success';
		}
		else{
			echo'errror';
		}
	}
	else{
		echo'error';
	}
}
elseif(isset($_POST['cancel_code'])){
	$cancel_code = clean(SA_Encryption::decrypt_from_url_param($_POST['cancel_code']));
	$sql = $conex->query("SELECT * FROM user_withdraw WHERE CODE = '$cancel_code'");
	$view_rows = $sql->num_rows;
	if($view_rows > 0){
		$delQ = $conex->query("UPDATE user_withdraw SET STATUS = 2 WHERE CODE = '$cancel_code'");
		if($delQ){
			echo'success';
		}
		else{
			echo'errror';
		}
	}
	else{
		echo'error';
	}
}
elseif(isset($_POST['del_code'])){
	$del_code = clean(SA_Encryption::decrypt_from_url_param($_POST['del_code']));
	$sql = $conex->query("SELECT * FROM user_withdraw WHERE CODE = '$del_code'");
	$view_rows = $sql->num_rows;
	if($view_rows > 0){
		$delQ = $conex->query("DELETE FROM user_withdraw WHERE CODE = '$del_code'");
		if($delQ){
			echo'success';
		}
		else{
			echo'errror';
		}
	}
	else{
		echo'error';
	}
}
else{
	echo'error';
}
?>