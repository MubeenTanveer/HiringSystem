<?php include("config/check.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Apply Online Job</title>

  <!-- Custom fonts for this template-->
  
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="img/fav.png" rel="shortcut icon">
  <!-- Custom styles for this template-->
  <link href="admin_css/sb-admin-2.min.css" rel="stylesheet">
  <link href="admin_css/print.css" rel="stylesheet">
  <link href="admin_css/bootstrap-datepicker.min.css" rel="stylesheet">
  
  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard">
        <div class="sidebar-brand-icon">
          <img src="images/logo.png" alt="Poultry">
        </div>
       <!-- <div class="sidebar-brand-text mx-3">Apply Online Job</div> -->
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item <?=($current_file_name == 'dashboard.php')?'active':'';?>">
        <a class="nav-link" href="http://localhost/applyjobV1/dashboard">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>
      <li class="nav-item <?=($current_file_name == 'dashboard.php')?'active':'';?>">
        <a class="nav-link" href="all">
          <i class="fas fa-user-graduate"></i>
          <span>All Users</span></a>
      </li>
      <li class="nav-item <?=($current_file_name == 'dashboard.php')?'active':'';?>">
        <a class="nav-link" href="applied">
          <i class="fas fa-user-tie"></i>
          <span>Applied Users</span></a>
      </li>
      <li class="nav-item <?=($current_file_name == 'dashboard.php')?'active':'';?>">
        <a class="nav-link" href="test-wait">
          <i class="fas fa-user-tie"></i>
          <span>Test Waiting</span></a>
      </li>
      <li class="nav-item <?=($current_file_name == 'dashboard.php')?'active':'';?>">
        <a class="nav-link" href="taken">
          <i class="fas fa-user-graduate"></i>
          <span>Test Taken Users</span></a>
      </li>
      <li class="nav-item <?=($current_file_name == 'dashboard.php')?'active':'';?>">
        <a class="nav-link" href="qualified">
          <i class="fas fa-user-graduate"></i>
          <span>Qualified Users</span></a>
      </li>
      <li class="nav-item <?=($current_file_name == 'dashboard.php')?'active':'';?>">
        <a class="nav-link" href="failed">
          <i class="fas fa-user-graduate"></i>
          <span>Failed Users</span></a>
      </li>
      <li class="nav-item <?=($current_file_name == 'dashboard.php')?'active':'';?>">
        <a class="nav-link" href="no-test">
          <i class="fas fa-user-graduate"></i>
          <span>No Test Users</span></a>
      </li>
      <li class="nav-item <?=($current_file_name == 'dashboard.php')?'active':'';?>">
        <a class="nav-link" href="jobs">
          <i class="fas fa-user-graduate"></i>
          <span>Jobs</span></a>
      </li>
      <li class="nav-item <?=($current_file_name == 'dashboard.php')?'active':'';?>">
        <a class="nav-link" href="quest">
          <i class="fas fa-user-graduate"></i>
          <span>Questions</span></a>
      </li>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search 
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>
      -->
          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">
            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"></span>
                <img class="img-profile rounded-circle" src="">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->