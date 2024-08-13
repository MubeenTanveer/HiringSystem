<?php include("includes/header.php"); ?>
<?php
if(isset($_SESSION['user_code'])){
	$user_code = $_SESSION['user_code'];
	$check_codeQ = $conex->query("SELECT * FROM users WHERE CODE = '$user_code'");
	$data = $check_codeQ->fetch_assoc();
	if($_SESSION['status'] == 0){
		$_SESSION['error'] = 'WE WILL INFORM YOU INFORM YOU THROUGH EMAIL WITHIN 24 HOURS WHETHER YOU ARE QUALIFIED FOR TEST OR NOT!';
	}
	elseif($_SESSION['status'] == 1){
		$_SESSION['error'] = 'YOU ARE NOT QUALIFIED FOR THIS TEST!';
	}
	elseif($_SESSION['status'] == 3){
		$_SESSION['error'] = 'YOU HAVE TAKEN THE TEST. WE INFORM RESULT TO YOU THROUGH EMAIL!';
	}
	elseif($_SESSION['status'] == 4){
		$_SESSION['error'] = 'YOU ARE NOT  ELIGIBLE FOR JOB!';
	}
	elseif($_SESSION['status'] == 5){
		$_SESSION['error'] = 'YOU ARE QUALIFIED FOR JOB. WE CONTACT YOU SHORTLY!';
	}
}else{
	redirect('test', false);
	exit();
}

?>
<!-- Contact area start -->
		<style type="text/css">
			.fa-angle-down:before{
				position: relative;
				right: 15px;
			}
			.contact-form select {
			    padding: 5px 10px;
			}
			.table tbody tr th,.table tbody tr td{
				border-top:none;
			}
		</style>
		<section class="contact" id="contact">
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center">
						<?php include("includes/msg.php"); ?>
						<div class="contact-top">
							<h2 class="head-two">Profile</h2>
							<div class="top-head-before">
								<i class="fa fa-dot-circle-o" aria-hidden="true"></i>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<table class="table">
					      <tr>
					        <th>First Name</th>
					        <td>------------------</td>
					        <td><?=ucwords($data['FNAME']);?></td>
					      </tr>
					      <tr>
					        <th>Last Name</th>
					        <td>------------------</td>
					        <td><?=ucwords($data['LNAME']);?></td>
					      </tr>
					      <tr>
					        <th>Email</th>
					        <td>------------------</td>
					        <td><?=$data['EMAIL']?></td>
					      </tr>
					      <tr>
					        <th>Job Apply For</th>
					        <td>------------------</td>
					        <td><?=user_job($conex,$data['JOB']);?></td>
					      </tr>
					  </table>
					</div>
				</div>
			</div>
		</section><!-- Contact area end -->
<?php include("includes/footer.php"); ?>