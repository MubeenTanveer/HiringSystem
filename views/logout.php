<?php
session_destroy();
if(isset($_COOKIE['todo_nama'])){
	setcookie('todo_nama', '', 0,'/', false, false);
}
header("Location:test");
?>