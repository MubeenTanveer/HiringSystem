<?php
include("../config/int.php");
include("../config/conex.php");
include("../helpers/func.php");
include("../helpers/binary_func.php");

if(isset($_POST['q']) && isset($_POST['a'])){
	$user_code = $_SESSION['user_code'];
	$q = $_POST['q'];
	$a = $_POST['a'];
	if(empty($a)){
		$conex->query("INSERT INTO result (USER_CODE, QUEST_CODE, ANS) VALUES('$user_code', '$q', 0)");
	}else{
		$q_query = $conex->query("SELECT * FROM quest WHERE CODE = '$q'");
		$q_data = $q_query->fetch_assoc();
		if($q_data['ANS']==$a){$ans = 1;}else{$ans=2;}
		$conex->query("INSERT INTO result (USER_CODE, QUEST_CODE, ANS) VALUES('$user_code', '$q', '$ans')");
	}
	echo 'yes';
}
elseif(isset($_POST['test'])){
	$_SESSION['test']=1;
}
?>