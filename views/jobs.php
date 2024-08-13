<?php include("includes/dashboard_header.php"); ?>
		<?php
      if(isset($_GET['add']) || isset($_GET['edit'])){
        $title = (isset($_POST['title']))?$_POST['title']:'';
        $comp = (isset($_POST['comp']))?mysqli_escape_string($conex,$_POST['comp']):'';
        $salary = (isset($_POST['salary']))?mysqli_escape_string($conex,$_POST['salary']):'';
        $loca = (isset($_POST['loca']))?mysqli_escape_string($conex,$_POST['loca']):'';
        $skills = (isset($_POST['skills']))?mysqli_escape_string($conex,$_POST['skills']):'';
        $qualif = (isset($_POST['qualif']))?mysqli_escape_string($conex,$_POST['qualif']):'';
        $status = (isset($_POST['status']))?$_POST['status']:1;
        if(isset($_GET['edit'])){
          $edit_code = $_GET['edit'];
          $sql = $conex->query("SELECT * FROM jobs WHERE CODE = '$edit_code'");
          $data = $sql->fetch_assoc();
          $title = (isset($_POST['title']))?$_POST['title']:$data['TITLE'];
          $salary = (isset($_POST['salary']))?$_POST['salary']:$data['SALARY'];
          $loca = (isset($_POST['loca']))?$_POST['loca']:$data['LOCATION'];
          $comp = (isset($_POST['comp']))?mysqli_escape_string($conex,$_POST['comp']):$data['COMPANY'];
          $skills = (isset($_POST['skills']))?mysqli_escape_string($conex,$_POST['skills']):$data['SKILLS'];
          $qualif = (isset($_POST['qualif']))?mysqli_escape_string($conex,$_POST['qualif']):$data['QUALIFICATION'];
          $status = (isset($_POST['status']))?$_POST['status']:$data['STATUS'];
        }
			if(isset($_POST['title'])){
          if(isset($_GET['edit'])){
            $sql = $conex->query("SELECT * FROM jobs WHERE CODE != '$edit_code' AND TITLE = '$title'");
          }else{
            $sql = $conex->query("SELECT * FROM jobs WHERE TITLE = '$title'");
          }
				  $rows = $sql->num_rows;
          if(empty($title) || empty($comp) || empty($salary) || empty($loca)){
            $_SESSION['error'] = 'PLEASE FILL ALL REQUIRED FIELDS!';
          }
          elseif ($rows > 1) {
            $_SESSION['error'] = 'THIS JOB TITLE ALREADY EXISTS!';
          }
          else{
            if(isset($_GET['edit'])){
              $sql = $conex->query("UPDATE jobs SET TITLE = '$title', COMPANY = '$comp', LOCATION ='$loca' , SALARY = '$salary', SKILLS = '$skills', QUALIFICATION = '$qualif', STATUS = '$status' WHERE CODE = '$edit_code'");
              $msg = 'JOB SUCCESSFULLY UPDATED!';
            }else{
              $sql = $conex->query("INSERT INTO jobs (TITLE, COMPANY, LOCATION, SALARY, SKILLS, QUALIFICATION, STATUS) VALUES ('$title', '$comp', '$loca', '$salary', '$skills', '$qualif', '$status')");
              $msg = 'JOB SUCCESSFULLY ADDED!';
            }
            if($sql){
              $_SESSION['success'] = $msg;
              redirect('jobs', false);
              exit();
            }else{
              $_SESSION['error'] = 'THERE IS SOMETHING WRONG!';
            }
          }
			}
    ?>
    <div class="container-fluid">
          <?php include("includes/msg.php"); ?>
          <!-- Page Heading -->
          <div class="d-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">All Jobs</h1>
          </div>
          <div id="operation_message"></div>
          <div class="card shadow mb-4">
            <div class="d-flex align-items-center justify-content-between card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary"><?=(isset($_GET['edit']))?'Edit':'Add'?> Job</h6>
              <a href="jobs" class="d-inline-block btn btn-sm btn-primary shadow-sm" id="add_button">All Jobs</a>
            </div>
            <div class="card-body">
             <form action="jobs?<?=(isset($_GET['edit']))?'edit='.$_GET['edit']:'add=1';?>" method="post">
               <div class="row">
                  <div class="form-group col-md-6">
                    <label for="title">Job Title</label>
                    <input type="text" name="title" value="<?=$title;?>" id="title" class="form-control required" />
                  </div>
                  <div class="form-group col-md-6">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control required">
                      <option value="1" <?=(($status == 1))?'selected':''?>>Active</option>
                      <option value="0" <?=(($status == 0))?'selected':''?>>Inactive</option>
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="comp">Company</label>
                    <input type="text" name="comp" value="<?=$comp;?>" id="comp" class="form-control required" />
                  </div>
                  <div class="form-group col-md-6">
                    <label for="salary">Job Salary</label>
                    <input type="text" name="salary" value="<?=$salary;?>" id="salary" class="form-control required" />
                  </div>
                  <div class="form-group col-md-6">
                    <label for="loca">Job Location</label>
                    <input type="text" name="loca" value="<?=$loca;?>" id="loca" class="form-control required" />
                  </div>
                  <div class="form-group col-md-6">
                    <label for="skills">Job Skills</label>
                    <input type="text" name="skills" value="<?=$skills;?>" id="skills" class="form-control required" />
                  </div>
                  <div class="form-group col-md-6">
                    <label for="qualif">Job Qualification</label>
                    <input type="text" name="qualif" value="<?=$qualif;?>" id="qualif" class="form-control required" />
                  </div>
                  <div class="form-group col-md-12">
                     <button type="submit" class="btn btn-info"><?=(isset($_GET['edit']))?'Edit':'Add'?></button>
                  </div>
                </div>
             </form>
            </div>
          </div>
        </div>
    <?php }else{ ?>    
        <!-- Begin Page Content -->
        <div class="container-fluid">
        	<?php include("includes/msg.php"); ?>
          <!-- Page Heading -->
          <div class="d-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">All Jobs</h1>
          </div>
          <div id="operation_message"></div>
          <div class="card shadow mb-4">
            <div class="d-flex align-items-center justify-content-between card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">All Jobs List</h6>
              <a href="jobs?add=1" class="d-inline-block btn btn-sm btn-primary shadow-sm" id="add_button">Add Job</a>
            </div>
            <div class="card-body">
              <form class="table-responsive" action="applied" method="post">
                <table class="table table-bordered" id="RateTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>TITLE</th>
                      <th>COMPANY</th>
                      <th>LOCATION</th>
                      <th>SALARY</th>
                      <th>STATUS</th>
                      <th>MANAGE</th>
                    </tr>
                  </thead>
                  <tbody>
                  	<?php
                  		$userq = $conex->query("SELECT * FROM jobs ORDER BY CODE DESC");
                  		while ($data = $userq->fetch_assoc()) {
                  	?>
                  		<tr>
                  			<td><?=ucwords($data['TITLE']);?></td>
                  			<td><?=ucwords($data['COMPANY']);?></td>
                  			<td><?=ucwords($data['LOCATION']);?></td>
                  			<td><?=ucwords($data['SALARY']);?></td>
                  			<td><?=job_status($data['STATUS']);?></td>
                        <td><a href="jobs?edit=<?=$data['CODE'];?>">Edit</a></td>
                  		</tr>
                  	<?php
                  		}
                  	?>
                  </tbody>
                </table>
              </form>
            </div>
          </div>
        </div>
       <?php } ?>
<?php include("includes/dashboard_footer.php"); ?>