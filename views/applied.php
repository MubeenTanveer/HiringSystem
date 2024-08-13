<?php include("includes/dashboard_header.php"); ?>
		<?php
			if(isset($_POST['users'])){
				$users = $_POST['users'];
				$user_list = '';
				foreach ($users as $user) {
					$user_list .= $user.',';
				}
				$all_list = substr($user_list, 0, -1);
				//echo $all_list;exit;
				$conex->query("UPDATE users SET STATUS = 2 WHERE CODE IN ($all_list) AND STATUS = 0");
				$conex->query("UPDATE users SET STATUS = 1 WHERE CODE NOT IN ($all_list) AND STATUS = 0");
				$_SESSION['success'] = 'SELECTED USER CAN TAKE TEST!';
				redirect('applied', false);
				exit();
			}
		?>    
        <!-- Begin Page Content -->
        <div class="container-fluid">
        	<?php include("includes/msg.php"); ?>
          <!-- Page Heading -->
          <div class="d-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Applied Users</h1>
          </div>
          <div id="operation_message"></div>
          <div class="card shadow mb-4">
            <div class="d-flex align-items-center justify-content-between card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Applied User List</h6>
            </div>
            <div class="card-body">
              <form class="table-responsive" action="applied" method="post">
                <table class="table table-bordered" id="RateTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th></th>
                      <th>FIRST NAME</th>
                      <th>LAST NAME</th>
                      <th>EMAIL</th>
                      <th>SCORE</th>
                    </tr>
                  </thead>
                  <tbody>
                  	<?php
                  		$userq = $conex->query("SELECT * FROM users WHERE STATUS = 0 ORDER BY (QUALI+EXP) DESC");
                  		while ($data = $userq->fetch_assoc()) {
                  	?>
                  		<tr>
                  			<td><input type="checkbox" id="<?=$data['CODE'];?>" name="users[]" value="<?=$data['CODE'];?>"></td>
                  			<td><?=ucwords($data['FNAME']);?></td>
                  			<td><?=ucwords($data['LNAME']);?></td>
                  			<td><?=ucwords($data['EMAIL']);?></td>
                  			<td><?=($data['QUALI']+$data['EXP']);?></td>
                  		</tr>
                  	<?php
                  		}
                  	?>
                  </tbody>
                </table>
                <button class="btn btn-info" type="submit">Apply</button>
              </form>
            </div>
          </div>
        </div>
       
<?php include("includes/dashboard_footer.php"); ?>