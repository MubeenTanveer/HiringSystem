<?php
include("../config/int.php");
include("../config/conex.php");
include("../helpers/func.php");
include("../helpers/binary_func.php");
if(isset($_POST['user_id'])){
	$user_id = clean($_POST['user_id']);
	$sql = $conex->query("SELECT * FROM users WHERE REF_ID = '$user_id' AND TYPE = 'USER'");
	$view_rows = $sql->num_rows;
	if($view_rows > 0){
		$data = $sql->fetch_assoc();
		echo $data['FIRST_NAME'].' '.$data['LAST_NAME'];
	}
	else{
		echo'No User';
	}
}else{
	echo'No User';
}
?>