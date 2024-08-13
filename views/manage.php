<?php include("includes/dashboard_header.php");?>
		<div class="content-inner">
          <!-- Page Header-->
          <header class="page-header">
            <div class="container-fluid">
              <h2 class="no-margin-bottom">Staff
				<?php if(isset($_GET['edit']) || isset($_GET['add'])){ ?>
					<a href="manage" class="btn btn-primary float-right mb-1">All Staff</a>
					<?php }else{ ?>
					<a href="manage?add=1" class="btn btn-primary float-right mb-1">Add Staff</a>
					<?php } ?>
			  </h2>
            </div>
          </header>
          <?php 
					if(isset($_GET['del_staff']) && !empty($_GET['del_staff'])){
						$del_code = $_GET['del_staff'];
						$staffQ = $conex->query("SELECT * FROM users WHERE CODE = '$del_code'");
						$staff_data = $staffQ->fetch_assoc();
						if($staff_data['TYPE'] == 'ADMIN' || $staff_data['TYPE'] == 'MANAGER'){
							$sql = $conex->query("DELETE FROM  users WHERE CODE = '$del_code'");
							if($sql){
								echo'<script>window.location.href="manage";</script>';
								exit;
							}
							else{
								echo'<script>window.location.href="manage";</script>';
								exit;
							}
						}else{
							echo'<script>window.location.href="manage";</script>';
							exit;
						}
					}
					if(isset($_GET['edit']) || isset($_GET['add'])){
						$fname = ((isset($_POST['fname']))?clean($_POST['fname']):'');
						$lname = ((isset($_POST['lname']))?clean($_POST['lname']):'');
						$email = ((isset($_POST['email']))?clean($_POST['email']):'');
						$pass = ((isset($_POST['pass']))?clean($_POST['pass']):'');
						$type = ((isset($_POST['type']))?clean($_POST['type']):'');
						if(isset($_GET['edit'])){
							$edit_code = $_GET['edit'];
							$sql = $conex->query("SELECT * FROM users WHERE CODE = '$edit_code'");
							$staff_data = $sql->fetch_assoc();
							$fname = ((isset($_POST['fname']))?clean($_POST['fname']):$staff_data['FIRST_NAME']);
							$lname = ((isset($_POST['lname']))?clean($_POST['lname']):$staff_data['LAST_NAME']);
							$email = ((isset($_POST['email']))?clean($_POST['email']):$staff_data['EMAIL']);
							$pass = ((isset($_POST['pass']))?clean($_POST['pass']):$staff_data['PASSWORD']);
							$type = ((isset($_POST['type']))?clean($_POST['type']):$staff_data['TYPE']);
							$status = ((isset($_POST['status']))?clean($_POST['status']):$staff_data['STATUS']);
						}
						if(isset($_POST['fname'])){
							if(isset($_GET['edit'])){
								$emailQ = $conex->query("SELECT * FROM users WHERE EMAIL = '$email' AND CODE != '$edit_code'");
								$email_rows = $emailQ->num_rows;
							}
							else{
								$emailQ = $conex->query("SELECT * FROM users WHERE EMAIL = '$email'");
								$email_rows = $emailQ->num_rows;
							}
							if(empty($fname) || empty($email) || empty($lname)){
								$_SESSION['error'] = 'PLEASE ENTER REQUIRED FIELDS!';
							}
							elseif($email_rows > 0){
								$_SESSION['error'] = 'THIS EMAIL ADDRESS ALREADY EXISTS!';
							}
							elseif(empty($pass) && isset($_GET['add'])){
								$_SESSION['error'] = 'PLEASE ENTER PASSWORD!';
							}
							elseif(strlen($pass) < 8 && isset($_GET['add'])){
								$_SESSION['error'] = 'PLEASE ENTER PASSWORD MIN 8 CHARACTERS!';
							}
							elseif(!empty($pass) && strlen($pass) < 8 && isset($_GET['edit'])){
								$_SESSION['error'] = 'PLEASE ENTER PASSWORD MIN 8 CHARACTERS!';
							}
							else{
								if(isset($_GET['edit'])){
									if(!empty($pass)){
										$hash = password_hash($pass, PASSWORD_BCRYPT);
										$sql = $conex->query("UPDATE users SET FIRST_NAME = '$fname', LAST_NAME = '$lname', EMAIL = '$email', PASSWORD = '$hash', TYPE = '$type', STATUS = '$status' WHERE CODE = '$edit_code' ");
									}
									else{
										$sql = $conex->query("UPDATE users SET  FIRST_NAME = '$fname', LAST_NAME = '$lname', EMAIL = '$email', TYPE = '$type', STATUS = '$status' WHERE CODE = '$edit_code' ");
									}
									
								}else{
									$hash = password_hash($pass, PASSWORD_BCRYPT);
									$sql = $conex->query("INSERT INTO users (FIRST_NAME, LAST_NAME, EMAIL, PASSWORD, TYPE, STATUS) VALUES ($fname', '$lname', '$email', '$hash', '$type', 1)");
								}
								if($sql){
									echo'<script>window.location.href="manage";</script>';
									exit;
								}
								else{
									$_SESSION['error'] = 'THERE IS SOMETHING WRONG!';
								}
							}
						}
				?>
		  <!-- Dashboard Counts Section-->
          <section class="dashboard-counts no-padding-bottom pt-3">
            <div class="container-fluid">
              <div class="row p-0">
                <div class="col-md-12 p-0">
					<?php include("includes/msg.php"); ?>
					<div class="card">
						<div class="card-header d-flex align-items-center">
						  <h3 class="h4"><?=(isset($_GET['edit']))?'Edit':'Add';?> Staff</h3>
						</div>
						<div class="card-body p-0">
						  <form action="manage?<?=(isset($_GET['edit']))?'edit='.$_GET['edit']:'add=1';?>" method="post" class="row p-0" enctype="multipart/form-data">
							<div class="form-group col-md-12">
							  <label class="form-control-label">Email</label>
							  <input type="email" placeholder="Email Address" name="email" class="form-control" value="<?=$email;?>">
							</div>
							<div class="form-group col-md-6">
							  <label class="form-control-label">First Name</label>
							  <input type="text" placeholder="First Name" name="fname" required class="form-control" value="<?=$fname;?>">
							</div>
							<div class="form-group col-md-6">
							  <label class="form-control-label">Last Name</label>
							  <input type="text" placeholder="Last Name" name="lname" required class="form-control" value="<?=$lname;?>">
							</div>
							<div class="form-group col-md-6">       
							  <label class="form-control-label">Password</label>
							  <input type="password" placeholder="Password" name="pass" class="form-control">
							  <small id="password_error" class="form-text text-muted">
									Your password must be 8-20 characters long.
								</small>
							</div>
							<div class="form-group col-md-6">       
							  <label class="form-control-label">Type</label>
							  <select name="type" class="form-control">
								<option value="MANAGER" <?=($type == 'MANAGER')?'selected':'';?>>MANAGER</option>
								<option value="ADMIN" <?=($type == 'ADMIN')?'selected':'';?>>ADMIN</option>
							  </select>
							</div>
							<?php if(isset($_GET['edit'])){ ?>
							<div class="form-group col-md-6">       
							  <label class="form-control-label">Status</label>
							  <select name="status" class="form-control">
								<option value="1" <?=($status == 1)?'selected':'';?>>Active</option>
								<option value="2" <?=($status == 2)?'selected':'';?>>Block</option>
							  </select>
							</div>
							<?php } ?>
							<div class="form-group col-md-12">       
							  <input type="submit" value="<?=(isset($_GET['edit']))?'Save':'Add'?>" class="btn btn-primary">
							</div>
						  </form>
						</div>
					</div>
				</div>
              </div>
            </div>
          </section>
		<?php }else{ ?>
		<section class="tables pt-3" id="refferals">   
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-header d-flex align-items-center">
                      <h3 class="h4">All Staff</h3>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive d-block d-sm-table">
                        <table class="table table-md" id="my_table">
                          <thead>
                            <tr>
                              <th>NAME</th>
                              <th>EMAIL</th>
                              <th>TYPE</th>
                              <th>STATUS</th>
                              <th>ACTION</th>
                            </tr>
                          </thead>
                          <tbody>
							<?php
								$sql = $conex->query("SELECT * FROM users WHERE TYPE IN('ADMIN', 'MANAGER')");
								while($s_data = $sql->fetch_assoc()){
							?>
							<tr>
								<td><?=ucwords($s_data['FIRST_NAME'].' '.$s_data['LAST_NAME']);?></td>
								<td><?=$s_data['EMAIL'];?></td>
								<td><?=$s_data['TYPE'];?></td>
								<td><button class="btn"><?=get_status($s_data['STATUS']);?></button></td>
								<td>
									<ul class="action_list">
										<li><a href="#"><i class="fas fa-ellipsis-h"></i></a></li>
										<ul class="actions">
											<li><a href="manage?edit=<?=$s_data['CODE'];?>">Edit</a></li>
											<li><a href="manage?del_staff=<?=$s_data['CODE'];?>">Delete</a></li>
										</ul>
									</ul>
								</td>
							</tr>
							<?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
		<?php } ?>
<?php include("includes/dashboard_footer.php");?>
<script>
	$(".action_list > li > a").blur(function(event){
		event.preventDefault();
		$(this).parent().next().stop().fadeOut();
	});
	$(".action_list > li > a").click(function(event){
		event.preventDefault();
		$(".actions").stop().fadeOut();
		$(this).parent().next().stop().fadeToggle();
	});
	// DATE PICKER
		$(function() {
			if (!$.fn.bootstrapDP && $.fn.datepicker && $.fn.datepicker.noConflict) {
			var datepicker = $.fn.datepicker.noConflict();
			$.fn.bootstrapDP = datepicker;
			}
			//$("#jquery-ui-datepicker").datepicker({});
			$('#date').bootstrapDP({
				format: "yyyy-M-dd",
				startView: 4,
				clearBtn:true,
				startDate:'1900-00-00'
			});
		});
	
</script>