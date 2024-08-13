<!DOCTYPE HTML>
<html lang="en-US">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Apply online for Job</title>
		<!-- Font Awesome CSS -->
		<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" media="all" />
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" media="all" />
		<!-- Lightbox CSS -->
		<link rel="stylesheet" href="css/lightbox.min.css"/>
		<!-- Flaticon CSS -->
		<link rel="stylesheet" href="flaticon/flaticon.css">
		<!-- Owl carousel CSS -->
		<link rel="stylesheet" href="css/owl.carousel.min.css">
		<!-- Animate CSS -->
		<link rel="stylesheet" href="css/animate.min.css">
		<!-- Reset CSS -->
		<link rel="stylesheet" href="css/reset.css">
		<!-- Main style CSS -->
		<link rel="stylesheet" type="text/css" href="style.css?var=<?=rand(100,1000);?>" media="all" />
		<!-- Responsive CSS -->
		<link rel="stylesheet" type="text/css" href="css/responsive.css" media="all" />
	    <!-- Freelancer colors. You can choose any other color by changing color css file.
	    -->
		<!-- <link rel="stylesheet" type="text/css" href="css/colors/default.css"> -->
		<!-- <link rel="stylesheet" type="text/css" href="css/colors/red.css"> -->
		<!-- <link rel="stylesheet" type="text/css" href="css/colors/blue.css"> -->
		<!-- <link rel="stylesheet" type="text/css" href="css/colors/green.css"> -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body class="js" data-spy="scroll" data-target=".navbar" data-offset="50">
	    <!-- Page loader -->
	    <div id="preloader"></div>
		<!-- Header area start -->
		<header id="menu" class="menubar">
			<nav class="navbar navbar-fixed-top">
			  <div class="container">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
				  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				  </button>
				  <a class="navbar-brand" href="http://localhost/applyjobV1/"><img src="images/logo.png"></a>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				  <ul class="nav navbar-nav navbar-right menu">
					<li><a href="apply" class="menu-color">Apply Online</a></li>
					<li><a href="test" class="menu-color">Take a Test & Resume</a></li>
					<li><a href="contact" class="menu-color">Contact Us</a></li>
					<li><a href="about" class="menu-color">About Us</a></li>
					<?php if(isset($_SESSION['user_code'])){ ?>
						<li><a href="user-dashboard" class="menu-color">Dashboard</a></li>
						<li><a href="logout" class="menu-color">Logout</a></li>
					<?php } ?>
				  </ul>
				</div><!-- /.navbar-collapse -->
			  </div><!-- /.container-fluid -->
			</nav>
		</header><!-- Header area end -->
