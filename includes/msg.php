
<?php
	if(isset($_SESSION['error'])){
?>

	<div class="alert alert-danger alert-dismissable">
	  <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
	  <p class="text-center m-0 text-dark"><strong><?=$_SESSION['error'];?></strong></p>
	</div>
<?php 
	unset($_SESSION['error']);
	}
	elseif(isset($_SESSION['success'])){ 
?>
	<div class="alert alert-success alert-dismissable">
	  <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
	  <p class="text-center m-0 text-dark"><strong><?=$_SESSION['success'];?></strong></p>
	</div>
<?php
		unset($_SESSION['success']);
	}
	elseif(isset($_SESSION['status_msg'])){ 
?>
	<div class="alert alert-warning alert-dismissable">
	  <p class="text-center m-0 text-dark"><strong><?=$_SESSION['status_msg'];?></strong></p>
	</div>
<?php
	}
?>	