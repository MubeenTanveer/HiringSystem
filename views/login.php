<?php
if(isset($_GET['ref'])){
	$ref = substr(clean(base64_url_decode($_GET['ref'])),0,-3);
	if(empty($ref)){
		$invalid ='';
	}else{
		$position = rtrim(substr(clean(base64_url_decode($_GET['ref'])),-2),')');
		$sql = $conex->query("SELECT * FROM users WHERE REF_ID = '$ref'");
		$ref_rows = $sql->num_rows;
		if($ref_rows == 1){
			$ref_data = $sql->fetch_assoc();
			$_SESSION['ref'] = $ref_data['CODE'];
		}else{
			$invalid ='';
		}
	}
}else{
	$invalid ='';
}
$email ='';
$fname ='';
$lname ='';
// RESET PASSWORD EMAIL SEND
if(isset($_POST['reset_email'])){
	$email = $conex->real_escape_string(clean($_POST['reset_email']));
	$sql = $conex->query("SELECT * FROM users WHERE EMAIL = '$email'");
	$email_rows = $sql->num_rows;
	if(empty($email)){
		$_SESSION['error'] = 'PLEASE ENTER EMAIL ADDRESS!';
	}
	elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$_SESSION['error'] = 'PLEASE ENTER VALID EMAIL ADDRESS!';
	}
	elseif($email_rows == 0){
		$_SESSION['error'] = 'THERE IS NO SUCH EMAIL EXISTS!';
	}
	else{
		$send_code = rand(100001, 999999);
		$_SESSION['change_pass_email'] = $email;
		$conex->query("UPDATE users SET RE_CODE = '$send_code', CODE_STATUS = 0 WHERE EMAIL = '$email'");
		include("includes/send_pass_code.php");
	}
}
// CHACK EMAIL CODE
if(isset($_POST['pass_code']) && isset($_SESSION['change_pass_email'])){
	$email = $_SESSION['change_pass_email'];
	$code = $conex->real_escape_string(clean($_POST['pass_code']));
	$sql = $conex->query("SELECT * FROM users WHERE EMAIL = '$email' AND RE_CODE = '$code'");
	$code_rows = $sql->num_rows;
	if(empty($code)){
		$_SESSION['error'] = 'PLEASE ENTER 6 DIGIT CODE!';
	}
	elseif($code_rows == 0){
		$_SESSION['error'] = 'PLEASE ENTER VALID 6 DIGIT CODE!';
	}
	else{
		$_SESSION['pass_enter'] = '';
	}
}
// NEW PASSWORD ENTER
if(isset($_POST['pass_change']) && isset($_SESSION['change_pass_email'])){
	$new_pass = $conex->real_escape_string(clean($_POST['pass_change']));
	$con_pass = $conex->real_escape_string(clean($_POST['pass_change_confirm']));
	$email = $_SESSION['change_pass_email'];
	$sql = $conex->query("SELECT * FROM users WHERE EMAIL = '$email'");
	$email_data = $sql->fetch_assoc();
	if(empty($new_pass) || empty($con_pass)){
		$_SESSION['error'] = 'PLEASE ENTER NEW PASSWORDS!';
	}
	elseif(strlen($new_pass) < 8){
		$_SESSION['error'] = 'YOUR PASSWORD MUST BE 8-20 CHARACTERS LONG!';
	}
	elseif($con_pass != $new_pass){
		$_SESSION['error'] = 'PASSWORDS NOT MATCH!';
	}
	elseif(password_verify($new_pass, $email_data['PASSWORD'])){
		$_SESSION['error'] = 'PLEASE ENTER NEW PASSWORD NOT OLD!';
	}
	else{
		$new_pass = password_hash($new_pass, PASSWORD_BCRYPT);
		$sql = $conex->query("UPDATE users SET PASSWORD = '$new_pass' WHERE EMAIL = '$email'");
		if($sql){
			$conex->query("UPDATE users SET CODE_STATUS = 1 WHERE EMAIL = '$email'");
			unset($_SESSION['pass_enter']);
			unset($_SESSION['change_pass_email']);
			if(isset($_COOKIE['todo_nama'])){
				setcookie('todo_nama', '', 0,'/', false, false);
			}
			$_SESSION['pass_chnage_msg'] = '';
		}
		else{
			$_SESSION['error'] = 'THERE IS SOMETHING WRONG!';
		}
	}
}
// LOGIN FORM
if(isset($_POST['login_email'])){
	$email = $conex->real_escape_string(clean($_POST['login_email']));
	$pass = $conex->real_escape_string(clean($_POST['login_pass']));
	if(empty($pass) || empty($email)){
		$_SESSION['error'] = 'PLEASE ENTER EMAIL & PASSWORD!';
	}
	elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$_SESSION['error'] = 'PLEASE ENTER VALID EMAIL ADDRESS!';
	}
	else{
		$checkQ = $conex->query("SELECT * FROM users WHERE EMAIL = '$email'");
		$check_rows = $checkQ->num_rows;
		if($check_rows == 1){
			$user_data = $checkQ->fetch_assoc();
			$user_code = $user_data['CODE'];
			// check 10 days limit
			$planQ = $conex->query("SELECT * FROM `user_plans` WHERE USER_CODE = '$user_code'");
			$plan_rows = $planQ->num_rows;
			if($user_data['TYPE'] == 'USER'){
    			if($plan_rows == 0){
    			    $join_date = $user_data['JOIN_DATE'];
    			    $days = floor(differenceInHours($join_date, date('Y-m-d h:i:s'))/24);
    			    if($days >= 10){
    			        $conex->query("UPDATE users SET STATUS = 3 WHERE CODE = '$user_code'");
    			        $userQ = $conex->query("SELECT * FROM users WHERE CODE = '$user_code'");
    			        $user_data = $userQ->fetch_assoc();
    			    }
    			}else{
    			    $planQ2 = $conex->query("SELECT * FROM `user_plans` WHERE USER_CODE = '$user_code' AND STATUS = 1");
    			    $plan_rows2 = $planQ2->num_rows;
    			    if($plan_rows2 == 0){
    			        $planQ3 = $conex->query("SELECT * FROM `user_plan_view` WHERE USER_CODE = '$user_code' AND STATUS IN (2, 3) ORDER BY DATE_TIME DESC  LIMIT 1");
    			        $plan_rows3 = $planQ->num_rows;
    			        if($plan_rows3 > 0){
    			            $plan_data = $planQ3->fetch_assoc();
    			            $plan_date = date_create($plan_data['DATE_TIME']);
    			            $plan_days = $plan_data['DAYS'];
    	                    $new_date = date_add($plan_date,date_interval_create_from_date_string("{$plan_days}"));
    	                    $new_date = date_format($new_date,"Y-m-d h:i:s");
    			            $days = floor(differenceInHours($new_date, date('Y-m-d h:i:s'))/24);
            			    if($days >= 10){
            			        $conex->query("UPDATE users SET STATUS = 3 WHERE CODE = '$user_code'");
            			        $userQ = $conex->query("SELECT * FROM users WHERE CODE = '$user_code'");
            			        $user_data = $userQ->fetch_assoc();
            			    }       
    			        }
    			    }
    			}
			}
			if(!password_verify($pass, $user_data['PASSWORD'])){
				$_SESSION['error'] = 'WRONG EMAIL OR PASSWORD!';
			}
			elseif($user_data['STATUS'] == 0){
				$_SESSION['error'] = 'PLEASE VERIFY YOUR EMAIL ADDRESS!';
			}
			elseif($user_data['STATUS'] == 2){
				$_SESSION['error'] = 'YOUR ACCOUNT HAS BEEN SUSPENDED. PLEASE CONTACT OUR SUPPORT TEAM AT support@cryptonetworkbank.com.';
			}
			elseif($user_data['STATUS'] == 3){
				$_SESSION['error'] = 'YOUR ACCOUNT HAS BEEN SUSPENDED DUE TO NOT INVESTING UPTO 10 DAYS!';
			}
			elseif($user_data['CODE_STATUS'] == 0){
				$_SESSION['error'] = 'PLEASE ENTER SIX DIGIT CODE SEND ON YOUR EMAIL ADDRESS FOR CHANGE PASSWORD!';
				$_SESSION['change_pass_email'] = $user_data['EMAIL'];
				echo'<script>window.location.href="reset-password";</script>';
				exit;
			}
			else{
				if(isset($_POST['remember'])){
					setcookie('todo_nama', SA_Encryption::encrypt_to_url_param($user_data['EMAIL']), time() + (86400 * 30),'/', false, false);
				}
				$_SESSION['boss_user'] = $user_data['CODE'];
				$_SESSION['boss_type'] = $user_data['TYPE'];
				$user_code = $user_data['CODE'];
				$conex->query("UPDATE users SET LAST_LOGIN = NOW() WHERE CODE = '$user_code'");
				if($_SESSION['boss_type'] == 'ADMIN' || $_SESSION['boss_type'] == 'MANAGER'){
					header("Location:user-list");
				}else{
					if(isset($_SESSION['request_page'])){
						$redict = $_SESSION['request_page'];
						unset($_SESSION['request_page']);
						header("Location:".$redict);
					}else{
						header("Location:dashboard");
					}
				}
			}
		}else{
			$_SESSION['error'] = 'WRONG EMAIL OR PASSWORD!';
		}
	}
}
// REGISTER FORM
if(isset($_POST['signup_email'])){
	$email = $conex->real_escape_string(clean($_POST['signup_email']));
	$signup_pass = $conex->real_escape_string(clean($_POST['signup_pass']));
	$signup_confirm = $conex->real_escape_string(clean($_POST['signup_confirm']));
	$fname = $conex->real_escape_string(clean($_POST['fname']));
	$lname = $conex->real_escape_string(clean($_POST['lname']));
	$position = $conex->real_escape_string(clean($_POST['pos']));
	$emailQ = $conex->query("SELECT * FROM users WHERE EMAIL = '$email'");
	$email_rows = $emailQ->num_rows;
	$hash = password_hash($signup_pass, PASSWORD_BCRYPT);
	if(empty($signup_pass) || empty($email) || empty($fname) || empty($lname) || empty($position)){
		$_SESSION['error'] = 'PLEASE ENTER REQUIRED FIELDS!';
	}
	elseif(!isset($_POST['terms'])){
		$_SESSION['error'] = 'PLEASE AGREE WITH PRIVACY POLICY!';
	}
	elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$_SESSION['error'] = 'PLEASE ENTER VALID EMAIL ADDRESS!';
	}
   /*	elseif (strpos($email, '+') !== false) {
	 $_SESSION['error'] = 'YOUR EMAIL ADDRESS NOT VALID!';
	}*/
	elseif(strlen($signup_pass) < 8 || strlen($signup_pass) > 20){
		$_SESSION['error'] = 'YOUR PASSWORD MUST BE 8-20 CHARACTERS LONG!';
	}
	elseif($signup_pass != $signup_confirm){
		$_SESSION['error'] = 'PASSWORD NOT MATCH!';
	}
	elseif($email_rows > 0){
		$_SESSION['error'] = 'THIS EMAIL ADDRESS ALREADY EXISTS!';
	}
	elseif(!in_array($position, array('L', 'R'))){
		$_SESSION['error'] = 'PLEASE CHOOSE VALID POSITION!';
	}
	else{
		$sql = $conex->query("INSERT INTO users (FIRST_NAME, LAST_NAME, EMAIL, PASSWORD, POS_LETTER) VALUES ('$fname', '$lname', '$email', '$hash', '$position')");
		if($sql){
			if(isset($_SESSION['ref'])){
				$referred_user = $conex->insert_id;
				$ref_code = $_SESSION['ref'];
				$conex->query("UPDATE users SET REFFERED_USER = '$ref_code' WHERE CODE = '$referred_user'");
				unset($_SESSION['ref']);
				include("includes/confirm_email.php");
				$_SESSION['register'] = 'REGISTER';
				header("Location:send-confirm-email");
			}else{
				$referred_user = $conex->insert_id;
				$conex->query("DELETE FROM users  WHERE CODE = '$referred_user'");
				$_SESSION['error'] = 'THERE IS SOME ERROR IN UPDATING REFFERAL!';
			}
		}else{
			$_SESSION['error'] = 'THERE IS SOME ERROR IN REGISTRATION!';
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600%7CRoboto:400,400i,500,700" rel="stylesheet">

	<!-- Icons -->
	<link rel="stylesheet" href="css/themify-icons.css">
	<link rel="stylesheet" href="css/cryptocoins.css">
	<link rel="stylesheet" href="css/cryptocoins-colors.css">

	<!-- CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link id="switch-color" rel="stylesheet" href="css/main-color1.css">

	<!-- Favicons -->
	<link rel="shortcut icon" href="images/fav.png">

	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="Dmitry Volkov">
	<title>LOGIN</title>
	<style>
		.op_color{
			color:rgba(120,176,239);
		}
	</style>
</head>
<body>
	
	<div class="container mt-5">
		<?php include("includes/msg.php"); ?>
	</div>
	<!-- sign form -->
	<div class="sign">
		<!-- particles -->
		<div id="particles-js" class="sign__particles"></div>
		<!-- end particles -->
		<?php if($path == 'log-in'){?>
		<div class="sign__content">
			<!-- form -->
			<form action="log-in" class="sign__form" method="post">
				<a href="https://cryptonetworkbank.com"><img class="sign__logo" src="images/logo.png" alt=""></a>

				<input type="text" class="form__input" required name="login_email" placeholder="Email" value="<?=$email;?>">

				<input type="password" class="form__input" required name="login_pass" placeholder="Password">
				<div class="form__group">
					<input id="remember" name="remember" type="checkbox">
					<label for="remember">Remember Me?</label>
				</div>
				<button class="btn" type="submit">Log In</button>

				<a href="reset-password" class="sign__forgot mt-3">Forgot password?</a>
			</form>
			<!-- end form -->

			<div class="sign__box">
				<p>Don't have an account? <a href="sign-up">Sign up</a></p>
			</div>
		</div>
		<?php }elseif($path == 'reset-password'){ ?>
		<div class="sign__content">
			<?php if(isset($_SESSION['pass_chnage_msg'])){ ?>
			<div class="sign__form">
				<a href="https://cryptonetworkbank.com"><img class="sign__logo" src="images/logo.png" alt=""></a>
				<h3>Password Successfully Changed!</h3>				
				<p><a href="log-in">Sign in</a></p>
			</div>
			<?php unset($_SESSION['pass_chnage_msg']);}elseif(isset($_SESSION['pass_enter'])){ ?>
			<!-- form -->
			<form class="sign__form" method="post" action="reset-password">
				<a href="https://cryptonetworkbank.com"><img class="sign__logo" src="images/logo.png" alt=""></a>
				<p class="register_hd"><strong>Enter New Password</strong></p>
				<input class="form__input"type="password" required name="pass_change" id="pass_chage" placeholder="Enter Password">
				<small id="password_error" class="form-text text-muted">
					Your password must be 8-20 characters long.
				</small>
				<input class="form__input" type="password" required name="pass_change_confirm" id="pass_change_confirm" placeholder="Enter Confirm Password">
				<button class="btn" type="submit">Continue</button>
			</form>
			<!-- end form -->
			<?php }elseif(isset($_SESSION['change_pass_email'])){ ?>
			<!-- form -->
			<form class="sign__form" method="post" action="reset-password">
				<a href="https://cryptonetworkbank.com"><img class="sign__logo" src="images/logo.png" alt=""></a>
				<p class="register_hd"><strong>Enter 6 Digit Code Sent On Your Email Address</strong></p>
				<input class="form__input" type="number" required name="pass_code" id="pass_code" placeholder="Enter 6 Digit Code">
				<button class="btn" type="submit">Continue</button>
			</form>
			<!-- end form -->
			<?php }else{ ?>
			<!-- form -->
			<form class="sign__form" method="post" action="reset-password">
				<a href="https://cryptonetworkbank.com"><img class="sign__logo" src="images/logo.png" alt=""></a>
				<p class="register_hd"><strong>Password Recovery</strong><br> Please provide your registration email</p>
				<input type="text" class="form__input" required name="reset_email" id="reset_email" placeholder="Email">

				<button class="btn" type="submit">Continue</button>
			</form>
			<!-- end form -->

			<div class="sign__box">
				<p>Do you remember password? <a href="log-in">Login</a></p>
			</div>
			<?php } ?>
		</div>
		<?php }elseif($path == 'sign-up'){ ?>
		<div class="sign__content">
			<?php if(isset($invalid)){ ?>
			<div class="sign__form">
				<a href="https://cryptonetworkbank.com"><img class="sign__logo" src="images/logo.png" alt=""></a>
				<p>Registration is currently only possible with a valid invitation!</p>
			</div>
			<?php }else{ ?>
			<!-- form -->
			<form action="sign-up?ref=<?=$_GET['ref'];?>" class="sign__form" method="post" id="sign-up-form">
				<a href="https://cryptonetworkbank.com"><img class="sign__logo" src="images/logo.png" alt=""></a>
				<?php if($position == 'N'){?>
				<select class="form__input" name="pos" id="pos" required>
					<option class="op_color" value="0">Position</option>
					<option value="L">Left</option>
					<option value="R">Right</option>
				</select>
				<?php }else{ ?>
				<input type="hidden" required name="pos" id="pos" value="<?=$position;?>">
				<?php } ?>
				<input type="text" required class="form__input" placeholder="First Name" name="fname" id="fname" value="<?=$fname;?>">
				<input type="text" required class="form__input" placeholder="Last Name" name="lname" id="lname" value="<?=$lname;?>">
				<input type="email" required class="form__input" placeholder="Email" name="signup_email" id="signup_email" value="<?=$email;?>">
				<input type="password" required class="form__input mb-0" placeholder="Password" name="signup_pass" id="signup_pass">
				<small id="password_error" class="form-text text-muted mb-3">
					Your password must be 8-20 characters long.
				</small>
				<input type="password" required class="form__input" placeholder="Confirm" name="signup_confirm" id="signup_confirm">
				<div class="form__group">
					<input id="terms" required name="terms" type="checkbox">
					<label for="terms" id="term_label">I agree to the <a href="https://cryptonetworkbank.com/cnb-terms-and-conditions.pdf" target="_blank">Terms & Conditions</a></label>
				</div>
				<button class="btn" type="submit" id="sign-up-btn">Sign Up</button>
			</form>
			<!-- end form -->
			<?php } ?>
			<div class="sign__box">
				<p>You have an account? <a href="log-in">Login</a></p>
			</div>
		</div>
		<?php } ?>
	</div>
	<!-- end sign form -->
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<script src="js/smooth-scroll.min.js"></script>
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/particles.min.js"></script>
	<script src="js/particles-app.js"></script>
	<script src="js/main.js"></script>
	<script>
		$("#sign-up-btn").click(function(event){
			event.preventDefault();
			var vterms = $("#terms").val(); 
			var vpos = $("#pos").val(); 
			var vfname = $("#fname").val(); 
			var vlname = $("#lname").val(); 
			var vsignup_email = $("#signup_email").val(); 
			var vsignup_pass = $("#signup_pass").val();
			var vsignup_confirm = $("#signup_confirm").val();
			var ar = ['pos', 'fname', 'lname', 'signup_email', 'signup_pass', 'signup_confirm'];
			if(vpos == '' || vfname == '' || vlname == '' || vsignup_email == '' || vsignup_pass == '' || vsignup_confirm == ''){
				//alert($("#terms").val());return false;
				for(var i=0; i < 6; i++){
					if($("#"+ar[i]).val() == ''){
						$("#"+ar[i]).css("border", "1px solid #F00");
					}
				}
				return false;
			}
			else if(!$("#terms").is(":checked")){
				$("#term_label").css("border-bottom","1px solid #F00");
			}
			else{
				$("#sign-up-form").submit();
			}
		});
		$("input").focus(function(){
			$(this).css("border", "none");
		})
		$("#term_label").click(function(){
			$(this).css("border", "none");
		})
	</script>
</body>
</html>