<?php include("includes/header.php"); ?>
		<!-- Slider area start -->
		<section class="slider">
			<div class="slider-img">
				<div class="slider-overlay">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<div class="slider-content wow zoomIn" style="width: 100%;">
									<div class="slider-content-left">
										<img src="images/slider.jpg" alt="" style="margin: 0;" />
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section><!-- Slider area end -->
		<section class="service-top" id="service">
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center">
						<div class="service-top-head wow roolIn">
							<h2 class="head-two">Apply For Jobs</h2>
							<div class="top-head-before">
								<i class="fa fa-dot-circle-o" aria-hidden="true"></i>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<?php
						$sql = $conex->query("SELECT * FROM jobs WHERE STATUS = 1");
						while ($data = $sql->fetch_assoc()) {
							
						
					?>
					<div class="col-md-3 col-sm-6 text-center">
						<div class="service-top-content wow fadeInUp">
							<h5><?=$data['TITLE'];?></h5>
							<p style="padding: 5px;"><?=$data['COMPANY'];?></p>
							<p style="padding: 5px;"><?=$data['LOCATION'];?></p>
							<p style="padding: 5px;">Rs <?=$data['SALARY'];?></p>
							<a href="apply" class="btn btn-info" style="margin-top:35px;">Apply Now</a>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</section><!-- Service top area end -->
		<!-- Service top area start 
		<section class="service-top" id="service">
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center">
						<div class="service-top-head wow roolIn">
							<h2 class="head-two">Services</h2>
							<div class="top-head-before">
								<i class="fa fa-dot-circle-o" aria-hidden="true"></i>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3 col-sm-6 text-center">
						<div class="service-top-content wow fadeInUp">
							<i class="fa fa-user-o" aria-hidden="true"></i>
							<h5>Personality Test</h5>
							<div class="service-top-icon">
								<a href="#"><i class="fa fa-user-o" aria-hidden="true"></i></a>
							</div>
						</div>
					</div>
					<div class="col-md-3 col-sm-6 text-center">
						<div class="service-top-content wow fadeInUp">
							<i class="fa fa-line-chart" aria-hidden="true"></i>
							<h5>Career aptitude test</h5>
							<div class="service-top-icon">
								<a href="#"><i class="fa fa-line-chart" aria-hidden="true"></i></a>
							</div>
						</div>
					</div>
					<div class="col-md-3 col-sm-6 text-center">
						<div class="service-top-content wow fadeInUp">
							<i class="fa fa-user-circle" aria-hidden="true"></i>
							<h5>IQ test</h5>
							<div class="service-top-icon">
								<a href="#"><i class="fa fa-user-circle" aria-hidden="true"></i></a>
							</div>
						</div>
					</div>
					<div class="col-md-3 col-sm-6 text-center">
						<div class="service-top-content wow fadeInUp">
							<i class="fa fa-balance-scale" aria-hidden="true"></i>
							<h5>Assessment training</h5>
							<div class="service-top-icon">
								<a href="#"><i class="fa fa-balance-scale" aria-hidden="true"></i></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		Service top area end -->
		<!-- Service bottom area start -->
		<!-- Process top area start -->
		<section class="process-top text-center" id="process">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="process-top-head">
							<h2 class="head-two">Process</h2>
							<div class="top-head-before">
								<i class="fa fa-dot-circle-o" aria-hidden="true"></i>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3 col-sm-6">
						<div class="process-top-icon wow fadeInUp">
							<i class="fa fa-wifi" aria-hidden="true"></i>
							<h4 class="text-uppercase">Applied Online</h4>
							<div class="process-top-before">
								<i class="fa fa-angle-right" aria-hidden="true"></i>
							</div>
						</div>
					</div>
					<div class="col-md-3 col-sm-6">
						<div class="process-top-icon last wow fadeInUp">
							<i class="fa fa-question-circle-o" aria-hidden="true"></i>
							<h4 class="text-uppercase">Online Test</h4>
							<div class="process-top-before">
								<i class="fa fa-angle-right" aria-hidden="true"></i>
							</div>
						</div>
					</div>
					<div class="col-md-3 col-sm-6">
						<div class="process-top-icon wow fadeInUp">
							<i class="fa fa-university" aria-hidden="true"></i>
							<h4 class="text-uppercase">Qualified</h4>
							<div class="process-top-before">
								<i class="fa fa-angle-right" aria-hidden="true"></i>
							</div>
						</div>
					</div>
					<div class="col-md-3 col-sm-6">
						<div class="process-top-icon wow fadeInUp">
							<i class="fa fa-user-secret" aria-hidden="true"></i>
							<h4 class="text-uppercase">Job</h4>
						</div>
					</div>
				</div>
			</div>
		</section><!-- Process top area end -->
		
		
		
		
		<!-- Testimonial area start -->
		<section class="testimonial">
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center">
						<div class="testimonial-top">
							<h2 class="head-two">FAQ's</h2>
							<div class="top-head-before">
								<i class="fa fa-dot-circle-o" aria-hidden="true"></i>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="testimonial-left wow fadeInUp">
							<div class="panel-group" id="accordion">
								<div class="panel panel-default">
								  <div class="panel-heading">
									<h4 class="panel-title">
									  <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Where can I find Freelancer on social media websites?</a>
									</h4>
								  </div>
								  <div id="collapse1" class="panel-collapse collapse in">
									<div class="panel-body">Stay organized by adding agencies to lists, review agencies you're working with and keep an eye out for new project features or on mentions of agencies you list.</div>
								  </div>
								</div>
								<div class="panel panel-default">
								  <div class="panel-heading">
									<h4 class="panel-title">
									  <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Who is behind Freelancer?</a>
									</h4>
								  </div>
								  <div id="collapse2" class="panel-collapse collapse">
									<div class="panel-body">Stay organized by adding agencies to lists, review agencies you're working with and keep an eye out for new project features or on mentions of agencies you list.</div>
								  </div>
								</div>
								<div class="panel panel-default">
								  <div class="panel-heading">
									<h4 class="panel-title">
									  <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">Beyond searching for an agency, what else can I do?</a>
									</h4>
								  </div>
								  <div id="collapse3" class="panel-collapse collapse">
									<div class="panel-body">Stay organized by adding agencies to lists, review agencies you're working with and keep an eye out for new project features or on mentions of agencies you list.</div>
								  </div>
								</div>
								<div class="panel panel-default">
								  <div class="panel-heading">
									<h4 class="panel-title">
									  <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">How do I get my agency a profile on Freelancer?</a>
									</h4>
								  </div>
								  <div id="collapse4" class="panel-collapse collapse">
									<div class="panel-body">Stay organized by adding agencies to lists, review agencies you're working with and keep an eye out for new project features or on mentions of agencies you list.</div>
								  </div>
								</div>
								<div class="panel panel-default">
								  <div class="panel-heading">
									<h4 class="panel-title">
									  <a data-toggle="collapse" data-parent="#accordion" href="#collapse5">What benefit could Freelancer bring to my agency?</a>
									</h4>
								  </div>
								  <div id="collapse5" class="panel-collapse collapse">
									<div class="panel-body">Stay organized by adding agencies to lists, review agencies you're working with and keep an eye out for new project features or on mentions of agencies you list.</div>
								  </div>
								</div>
							</div>
							<div class="testimonial-left-para text-center">
								<p>Can't find what you're looking for? No problem.</p>
								<a href="contact">Contact Me</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section><!-- Testimonial area end -->
		<!-- Blog area start -->
		
		
	<?php include("includes/footer.php"); ?>