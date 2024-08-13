<?php
  if(isset($_POST['email'])){
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $sql = $conex->query("SELECT * FROM admin WHERE EMAIL = '$email' AND PASS = '$pass'");
    $rows  = $sql->num_rows;
    if(empty($email) || empty($pass)){
      $_SESSION['error'] = 'PLEASE ALL REQUIRED FEILDS!';
    }
    elseif($rows > 0){
        $data = $sql->fetch_assoc();
        $_SESSION['admin_code'] = $data['CODE'];
        redirect('dashboard', false);
        exit();
    }else{
      $_SESSION['error'] = 'WRONG EMAIL OR PASSWORD!';
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Apply Online - Login</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="img/fav.png" rel="shortcut icon">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="admin_css/sb-admin-2.min.css" rel="stylesheet">
	<style>
		body{
			background-image:url(img/login_bg.png);
			background-repeat:no-repeat;
			background-position:50px -90px;
			background-size:cover;
		}
	</style>
</head>

<body>

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">
      <?php include("includes/msg.php"); ?>
      <div class="col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5" style="background-color:rgba(0,0,0,0.5);margin-top:100px !important;">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-12">
                <div class="p-5 m-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4" style="color:#FFF !important;">Login</h1>
                  </div>
                  <form class="user" action="admin" method="post" id="my_form">
                    <div class="form-group">
                      <input autocomplete="off" type="email" class="form-control form-control-user" name="email" id="email" placeholder="Enter Username...">
						            <span id="username_error_msg" class="text-danger"></span>
					           </div>
                    <div class="form-group">
                      <input autocomplete="off" type="password" class="form-control form-control-user" name="pass" id="pass" placeholder="Password">
						          <span id="pass_error_msg" class="text-danger"></span>
					           </div>
                    <button id="sub_btn" class="btn btn-primary btn-user btn-block">
                      Login
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>
