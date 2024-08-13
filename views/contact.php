<?php include("includes/header.php"); ?>
<!-- Contact area start -->
		<section class="contact" id="contact">
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center">
						<div class="contact-top">
							<h2 class="head-two">Contact</h2>
							<div class="top-head-before">
								<i class="fa fa-dot-circle-o" aria-hidden="true"></i>
							</div>
							<p>Please call or complete the form below and I will be in touch with you shortly.</p>
							<a href="#"><i class="fa fa-phone" aria-hidden="true"></i><span>Call me:</span> (012) 345-6789</a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="contact-form wow fadeInUp">
	                        <form class="form-inline" id="contact-form">
	                            <!-- IF MAIL SENT SUCCESSFULLY -->
	                            <div class="success">
	                                Your message has been sent successfully.
	                            </div>
	                            <!-- IF MAIL SENDING UNSUCCESSFULL -->
	                            <div class="error">
	                                E-mail must be valid and message must be longer than 1 character.
	                            </div>
								<!-- Form Fields -->
								<div class="col-md-4">
									<div class="form-group">
										<label class="sr-only" for="first_name">First Name</label>
										<input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="sr-only" for="last_name">Last Name</label>
										<input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="sr-only" for="phone_number">Phone</label>
										<input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Phone">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="sr-only" for="email_address">Email</label>
										<input type="email" class="form-control" id="email_address" name="email_address" placeholder="Email Address">
									  </div>
								</div>
								<div class="col-md-8">
									<div class="form-group">
										<select id="contact_reason" name="contact_reason">
											<option value="Reason of Contact">Reason of Contact</option>
											<option value="Reason of Contact">Reason of Contact</option>
											<option value="Reason of Contact">Reason of Contact</option>
											<option value="Reason of Contact">Reason of Contact</option>
										</select>
										<i class="fa fa-angle-down" aria-hidden="true"></i>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group-textarea">
										<textarea class="form-control" id="message" name="message" rows="4" placeholder="Message"></textarea>
									</div>
								</div>
								<div class="col-md-12 text-center">
									<button type="submit" name="submit" id="submit">Contact Now</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section><!-- Contact area end -->
<?php include("includes/footer.php"); ?>