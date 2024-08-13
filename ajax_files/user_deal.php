<?php
include("../config/int.php");
include("../config/conex.php");
include("../helpers/func.php");
include("../helpers/binary_func.php");
if(isset($_POST['block_code'])){
	$block_code = clean(SA_Encryption::decrypt_from_url_param($_POST['block_code']));
	$sql = $conex->query("SELECT * FROM users WHERE CODE = '$block_code'");
	$view_rows = $sql->num_rows;
	if($view_rows > 0){
		$delQ = $conex->query("UPDATE users SET STATUS = 2 WHERE CODE = '$block_code'");
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
	$sql = $conex->query("SELECT * FROM users WHERE CODE = '$del_code'");
	$view_rows = $sql->num_rows;
	if($view_rows > 0){
		$delQ = $conex->query("DELETE FROM users WHERE CODE = '$del_code'");
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
elseif(isset($_POST['active_code'])){
	$active_code = clean(SA_Encryption::decrypt_from_url_param($_POST['active_code']));
	$sql = $conex->query("SELECT * FROM users WHERE CODE = '$active_code'");
	$view_rows = $sql->num_rows;
	if($view_rows > 0){
		$delQ = $conex->query("UPDATE users SET STATUS = 1 WHERE CODE = '$active_code'");
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