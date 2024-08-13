<?php include("includes/header.php"); ?>
<?php
	if(isset($_POST['first_name'])){
		$first_name = $conex->real_escape_string(clean($_POST['first_name']));
		$last_name = $conex->real_escape_string(clean($_POST['last_name']));
		$phone_number = $conex->real_escape_string(clean($_POST['phone_number']));
		$email_address = $conex->real_escape_string(clean($_POST['email_address']));
		$country = $conex->real_escape_string(clean($_POST['country']));
		$adr = $conex->real_escape_string(clean($_POST['adr']));
		$qual = $conex->real_escape_string(clean($_POST['qual']));
		$ex = $conex->real_escape_string(clean($_POST['ex']));
		$pass = $conex->real_escape_string(clean($_POST['pass']));
		$desc = $conex->real_escape_string(clean($_POST['desc']));
		$job = $conex->real_escape_string(clean($_POST['job']));
		$check_codeQ = $conex->query("SELECT * FROM users WHERE EMAIL = '$email_address'");
		$check_code_rows = $check_codeQ->num_rows;
		if(empty($first_name) || empty($last_name) || empty($pass) || empty($phone_number) || empty($email_address) || empty($country) || empty($adr) || empty($qual) || empty($ex)){
			$_SESSION['error'] = 'PLEASE FILL REQUIRED FIELDS!';
		}
		elseif($check_code_rows > 0){
			$_SESSION['error'] = 'THIS EMAIL ADDRESS ALREADY EXISTS!';
		}
		else{
			$sql = $conex->query("INSERT INTO users (FNAME, LNAME, PHONE, EMAIL, PASS, COUNTRY, ADDRESS, QUALI, EXP, DEFINATION,JOB) VALUES ('$first_name', '$last_name', '$phone_number', '$email_address', '$pass', '$country', '$adr', '$qual', '$ex', '$desc','$job')");
			if($sql){
				$_SESSION['success'] = 'WE WILL INFORM YOU THROUGH EMAIL WITHIN 24 HOURS WHETHER YOU ARE QUALIFIED FOR TEST OR NOT!';
			}else{
				$_SESSION['error'] = 'THERE IS SOMETHING WRONG!';
			}
		}
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
		</style>
		<section class="contact" id="contact">
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center">
						<?php include("includes/msg.php"); ?>
						<div class="contact-top">
							<h2 class="head-two">Apply Now</h2>
							<div class="top-head-before">
								<i class="fa fa-dot-circle-o" aria-hidden="true"></i>
							</div>
							<p>Please complete the form below and I will be in touch with you shortly.</p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="contact-form wow fadeInUp">
	                        <form class="row" id="contact-form" action="apply" method="post">
								<!-- Form Fields -->
								<div class="col-md-4">
									<div class="form-group">
										<label class="sr-only" for="first_name">First Name</label>
										<input type="text" required="required" class="form-control" id="first_name" name="first_name" placeholder="First Name">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="sr-only" for="last_name">Last Name</label>
										<input type="text" required="required" class="form-control" id="last_name" name="last_name" placeholder="Last Name">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="sr-only" for="phone_number">Phone</label>
										<input type="number" required="required" class="form-control" id="phone_number" name="phone_number" placeholder="Phone">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="sr-only" for="email_address">Email</label>
										<input type="email" required="required" class="form-control" id="email_address" name="email_address" placeholder="Email Address">
									  </div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="sr-only" for="pass">Password</label>
										<input type="password" required="required" class="form-control" id="pass" name="pass" placeholder="Password">
									  </div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="sr-only" for="country">Country</label>
										<select id="country" name="country" required="required">
											<option value="">Country</option>
											<?php
												$cont_sql = $conex->query("SELECT * FROM country");
												while ( $country = $cont_sql->fetch_assoc()) {
											?>
											<option value="<?=$country['NICE_NAME'];?>"><?=ucwords($country['NICE_NAME']);?></option>
											<?php
												}
											?>
										</select>
										<i class="fa fa-angle-down" aria-hidden="true"></i>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="sr-only" for="country">Address</label>
										<input class="form-control" required="required" id="adr" name="adr" type="text" placeholder="Address">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="sr-only" for="qual">Qualification</label>
										<select id="qual" name="qual" required="required">
											<option value="">Qualification</option>
											<option value="1">Bachelor's Degree</option>
											<option value="2">Honours Degree</option>
											<option value="3">Master's Degree</option>
											<option value="4">Doctoral Degree</option>
										</select>
										<i class="fa fa-angle-down" aria-hidden="true"></i>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="sr-only" for="job">Job</label>
										<select id="job" name="job" required="required">
											<option value="">Select Job Apply For</option>
											<?php
												$sql = $conex->query("SELECT * FROM jobs WHERE STATUS = 1");
												while ($data = $sql->fetch_assoc()) {
											?>
											<option value="<?=$data['CODE'];?>"><?=ucwords($data['TITLE']);?></option>
											<?php
												}
											?>
											
										</select>
										<i class="fa fa-angle-down" aria-hidden="true"></i>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="sr-only" for="ex">Experience</label>
										<input class="form-control" required="required" id="ex" name="ex" type="text" placeholder="Experience">
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label class="sr-only" for="ex">Describe Yourself</label>
										<textarea class="form-control" required="required" id="desc" rows="10" name="desc" placeholder="Describe Yourself"></textarea>
									</div>
								</div>
								<div class="col-md-12 text-center">
									<button type="submit" name="submit" id="submit">Submit</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section><!-- Contact area end -->
<?php include("includes/footer.php"); ?>