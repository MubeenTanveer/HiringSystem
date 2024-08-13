<?php include("includes/header.php"); ?>
<?php
if (isset($_SESSION['test']) && isset($_SESSION['user_code'])) {
	$user_code = $_SESSION['user_code'];
	$check_testQ = $conex->query("SELECT * FROM result WHERE USER_CODE = '$user_code'");
	$check_test_rows = $check_testQ->num_rows;
	$job_id_no = $conex->query("SELECT JOB FROM users WHERE CODE = '$user_code'");
	$job_id_row = $job_id_no->fetch_assoc();
	$job_id = $job_id_row['JOB'];
	$job_cat_no = $conex->query("SELECT CATG FROM jobs WHERE CODE = '$job_id'");
	$job_cat_row = $job_cat_no->fetch_assoc();
	$job_cat = $job_cat_row['CATG'];
	if ($check_test_rows >= 0) {
		if ($check_test_rows >= 10) {
			$conex->query("UPDATE users SET STATUS = 3 WHERE CODE = '$user_code'");
			unset($_SESSION['test']);
			$_SESSION['status'] = 3;
			redirect('user-dashboard', false);
			exit();
		} else {
			$q_list = get_q_list($conex, $user_code);
			$q = $conex->query("SELECT * FROM quest WHERE CODE NOT IN ('$q_list') AND CAT = '$job_cat' ORDER BY RAND() LIMIT 1");
			$q_data = $q->fetch_assoc();
			$q_no = $check_test_rows + 1;
		}
	} else {
		$q = $conex->query("SELECT * FROM quest ORDER BY RAND() LIMIT 1");
		$q_data = $q->fetch_assoc();
		$q_no = 1;
		$conex->query("UPDATE users SET STATUS = 3 WHERE CODE = '$user_code'");
		//redirect('test', false);
		//exit();
	}
}
if (isset($_POST['email_address'])) {
	$email_address = $conex->real_escape_string(clean($_POST['email_address']));
	$pass = $conex->real_escape_string(clean($_POST['pass']));
	$check_codeQ = $conex->query("SELECT * FROM users WHERE EMAIL = '$email_address' AND PASS = '$pass'");
	$check_code_rows = $check_codeQ->num_rows;
	if (empty($email_address) || empty($pass)) {
		$_SESSION['error'] = 'PLEASE FILL REQUIRED FIELDS!';
	} elseif ($check_code_rows == 0) {
		$_SESSION['error'] = 'WRONG EMAIL OR PASSWORD!';
	} else {
		$data = $check_codeQ->fetch_assoc();
		$_SESSION['user_code'] = $data['CODE'];
		$_SESSION['status'] = $data['STATUS'];
		$_SESSION['fname'] = $data['FNAME'];
		if ($data['STATUS'] == 2) {
			$user_code = $data['CODE'];
			$check_testQ = $conex->query("SELECT * FROM result WHERE USER_CODE = '$user_code'");
			$check_test_rows = $check_testQ->num_rows;
			if ($check_test_rows > 0) {
				$conex->query("UPDATE users SET STATUS = 3 WHERE CODE = 'user_code'");
				$_SESSION['error'] = 'YOU HAVE TAKEN THE TEST. WE INFORM RESULT TO YOU THROUGH EMAIL!';
				$_SESSION['status'] = 3;
				redirect('user-dashboard', false);
				exit();
			} else {
				$_SESSION['user_code'] = $data['CODE'];
				$_SESSION['status'] = $data['STATUS'];
				$_SESSION['fname'] = $data['FNAME'];
				redirect('test', false);
				exit();
			}
		} else {
			redirect('user-dashboard', false);
		}
	}
}

?>


<style type="text/css">
	.contact-form a {
		background: #60C926;
		text-align: center;
		padding: 8px 35px;
		color: #fff;
		border-radius: 25px;
		font-family: 'poppinsmedium';
		margin-top: 20px;
		transition: all 0.4s;
		display: inline-block;
	}

	.input-group-addon {
		margin-right: 10px;
		display: inline-block;
		background: transparent;
		border: none;
	}

	.input-group {
		display: inline-block;
	}

	.timer {
		width: 50px;
		height: 50px;
		text-align: center;
		line-height: 50px;
		background: red;
		color: white;
		position: fixed;
		top: 150px;
		left: 50px;
		border-radius: 50%;
		font-size: 20px;
	}
 

	
	input::file-selector-button  {
    background-color: #60c926; /* Green background */
    color: white; /* White text */
    border: none; /* No border */
    padding: 10px 15px; /* Padding */
    text-align: center; /* Centered text */
    text-decoration: none; /* No underline */
    font-size: 16px; /* Font size */
    margin: 15px 2px; /* Margin */
    border-radius: 20px; /* Rounded corners */
    transition: background-color 0.4s, color 0.4s; /* Transition for hover effect */
    cursor: pointer; /* Pointer cursor */
	transition: all 0.25s;

}

input::file-selector-button:hover {
    background-color: white; /* White background on hover */
    color: #242b55; /* Green text on hover */
	transform: scale(1.1);

}

</style>
<!-- Contact area start -->
<section class="contact" id="contact">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<?php include("includes/msg.php"); ?>
			</div>
		</div>
		<?php
		if (isset($_SESSION['test'])) {

		?>
			<div class=" timer"><strong id="myspan">0</strong>
			</div>
			<div class="alert alert-danger alert-dismissable" style="margin-bottom:0;position: fixed;bottom: 0;width: 100%;left:0;z-index: 100;">
				<a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
				<p class="text-center m-0 text-dark"><strong>DO NOT CLOSE YOU BROWSER ELSE YOU WILL LOST YOUR TEST!</strong></p>
			</div>
			<div class="row">
				<div class="col-md-12 text-center">
					<div class="contact-top">
						<h2 class="head-two">Question # <?= $q_no; ?></h2>
						<div class="top-head-before">
							<i class="fa fa-dot-circle-o" aria-hidden="true"></i>
						</div>
						<p><?= $q_data['QUEST']; ?></p>
						<input type="hidden" id="q_code" value="<?= $q_data['CODE']; ?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-md-offset-3 text-center">
					<div class="col-lg-6">
						<div class="input-group" style="margin: 20px 0;">
							<span class="input-group-addon">
								<input type="radio" class="ans" name="ans" q-code="<?= $q_data['CODE']; ?>" value="<?= $q_data['OPT1']; ?>">
							</span>
							<?= $q_data['OPT1']; ?>
						</div><!-- /input-group -->
					</div><!-- /.col-lg-6 -->
					<div class="col-lg-6">
						<div class="input-group" style="margin: 20px 0;">
							<span class="input-group-addon">
								<input type="radio" class="ans" name="ans" q-code="<?= $q_data['CODE']; ?>" value="<?= $q_data['OPT2']; ?>">
							</span>
							<?= $q_data['OPT2']; ?>
						</div><!-- /input-group -->
					</div><!-- /.col-lg-6 -->
					<div class="col-lg-6">
						<div class="input-group" style="margin: 20px 0;">
							<span class="input-group-addon">
								<input type="radio" class="ans" name="ans" q-code="<?= $q_data['CODE']; ?>" value="<?= $q_data['OPT3']; ?>">
							</span>
							<?= $q_data['OPT3']; ?>
						</div><!-- /input-group -->
					</div><!-- /.col-lg-6 -->
					<div class="col-lg-6">
						<div class="input-group" style="margin: 20px 0;">
							<span class="input-group-addon">
								<input type="radio" class="ans" name="ans" q-code="<?= $q_data['CODE']; ?>" value="<?= $q_data['OPT4']; ?>">
							</span>
							<?= $q_data['OPT4']; ?>
						</div><!-- /input-group -->
					</div><!-- /.col-lg-6 -->
				</div>
			</div>
		<?php
		} elseif (isset($_SESSION['user_code'])) {
			if (isset($_GET['test'])) {
				$_SESSION['test'] = 1;
				redirect('test', false);
				exit();
			} ?>


			<?php

			$user_code = $_SESSION['user_code'];
			$resumestatus = $conex->query("SELECT RESUMESTATUS FROM users WHERE CODE = '$user_code'");
			$resume_status = $resumestatus->fetch_assoc();
			$status_value = $resume_status['RESUMESTATUS'];
			$rscore = rand(0, 20);
			if ($status_value == 0) { ?>
				<div class="container">
					<div class="row">
						<div class="col-md-12 text-center">
							<div class="contact-top">
								<h2 class="head-two">Upload Resume </h2>
								<div class="top-head-before">
									<i class="fa fa-dot-circle-o" aria-hidden="true"></i>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="contact-form wow fadeInUp">
								<form class="form-inline" id="contact-form" method="post" action="" enctype="multipart/form-data">
									<!-- Form Fields -->
									<div class="col-md-6">
										<label class="form-label" for="resume_file">Upload Resume:</label>
										<input type="file" class="" id="resume_file" name="resume_file" accept=".docx, .pdf, " required>
									</div>

									<div class="col-md-12 text-center">
										<button type="submit" id="resume_uploade" name="resume_uploade" value="Submit"">Upload</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<?php
				$rquery =  "UPDATE users SET RESUMESCORE = '$rscore' WHERE CODE = '$user_code'";
				if ($conex->query($rquery) === TRUE) {
					// Update successful
				} else {
					// Error handling
					echo "Error updating resume status: " . $conex->error;
				}

				$update_query = "UPDATE users SET RESUMESTATUS = 1 WHERE CODE = '$user_code'";
				// Execute the update query
				if ($conex->query($update_query) === TRUE) {
					// Update successful
				} else {
					// Error handling
					echo "Error updating resume status: " . $conex->error;
				}
			} else { ?>
<div class=" col-md-12 text-center contact-form" style="margin: 100px 0;">
											<button type="button" id="submit">Begin Test</button>
									</div>
								<?php } ?>
							<?php
						} else {
							?>

								<div class="row">
									<div class="col-md-12 text-center">
										<div class="contact-top">
											<h2 class="head-two">Login</h2>
											<div class="top-head-before">
												<i class="fa fa-dot-circle-o" aria-hidden="true"></i>
											</div>
											<p>Please enter email addrees and password</p>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 col-md-offset-3">
										<div class="contact-form wow fadeInUp">
											<form class="form-inline" id="contact-form" method="post" action="test">
												<!-- Form Fields -->
												<div class="col-md-12">
													<div class="form-group">
														<label class="sr-only" for="email_address">Email</label>
														<input type="email" required="required" class="form-control" id="email_address" name="email_address" placeholder="Email Address">
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group">
														<label class="sr-only" for="pass">Password</label>
														<input type="password" required="required" class="form-control" id="pass" name="pass" placeholder="Password">
													</div>
												</div>
												<div class="col-md-12 text-center">
													<button type="submit" name="submit" id="login">Login</button>
												</div>
											</form>
										</div>
									</div>
								</div>
							<?php } ?>
							</div>
</section><!-- Contact area end -->
<?php include("includes/footer.php"); ?>



<script type="text/javascript">
	$("#submit").click(function(e) {
		e.preventDefault();
		$.ajax({
			url: "ajax_files/quest.php",
			method: "post",
			data: {
				test: ''
			},
			success: function(data) {

				window.location.href = "test";

			}
		});
		window.location.href = "test";
	});
	<?php if (isset($_SESSION['test'])) { ?>
		var timeLeft = 15;
		var elem = document.getElementById('myspan');
		var timerId = setInterval(countdown, 1000);

		function countdown() {
			if (timeLeft == 0) {
				clearTimeout(timerId);
				var q = $("#q_code").val();
				var a = '';
				$.ajax({
					url: "ajax_files/quest.php",
					method: "post",
					data: {
						q: q,
						a: a
					},
					success: function(data) {
						if (data != '') {
							window.location.href = "test";
						} else {
							return false;
						}
					}
				});
			} else {
				elem.innerHTML = timeLeft;
				timeLeft--;
			}
		}
		$(".ans").click(function() {
			var q = $("#q_code").val();
			var a = $(this).val();
			$.ajax({
				url: "ajax_files/quest.php",
				method: "post",
				data: {
					q: q,
					a: a
				},
				success: function(msg) {
					if (msg != "") {
						window.location.href = "test";
					} else {
						return false;
					}
				}
			});
		});
	<?php } ?>
</script>