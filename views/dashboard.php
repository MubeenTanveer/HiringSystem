<?php include("includes/dashboard_header.php"); ?>
<?php
  $qtu = $conex->query("SELECT * FROM users");
  $total_applied = $qtu->num_rows;
  $ttu = $conex->query("SELECT * FROM users WHERE STATUS = 3");
  $total_take_test = $ttu->num_rows;
  $qu = $conex->query("SELECT * FROM users WHERE STATUS = 5");
  $total_qualified = $qu->num_rows;
?>
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Applied Users</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?=number_format($total_applied);?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-comment-dollar fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Taken Test</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?=number_format($total_take_test);?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Qualified</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?=number_format($total_qualified);?></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-weight-hanging fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            

          <!-- Content Row -->

          

        </div>
        <!-- /.container-fluid -->
<?php include("includes/dashboard_footer.php"); ?>    
<!-- Page level plugins -->