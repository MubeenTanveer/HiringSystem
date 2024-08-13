<?php include("includes/dashboard_header.php"); ?>
		<?php
			if(isset($_POST['users'])){
				$users = $_POST['users'];
				if(!empty($users)){
				$user_list = '';
				foreach ($users as $user) {
					$user_list .= $user.',';
				}
				$all_list = substr($user_list, 0, -1);
				$conex->query("UPDATE users SET STATUS = 5 WHERE CODE IN ('$all_list') AND STATUS = 3");
				$conex->query("UPDATE users SET STATUS = 4 WHERE CODE NOT IN ('$all_list') AND STATUS = 3");
				$_SESSION['success'] = 'SELECTED USER Failed FOR JOB!';
				redirect('failed', false);
				exit();
				}else{
					$_SESSION['error'] = 'PLEASE SELECT SOME USER!';
				}
			}
		?>

		<?php if(isset($_GET['view'])){ 
			$user_code = $_GET['view'];
			$userQ = $conex->query("SELECT * FROM users WHERE CODE = '$user_code'");
			$user_data = $userQ->fetch_assoc();
			$aQ = $conex->query("SELECT sum(ANS) ANS FROM result WHERE USER_CODE = '$user_code' AND ANS = 1");
			$result_data = $aQ->fetch_assoc();

		?>

			<div class="container-fluid">
        	<?php include("includes/msg.php"); ?>
          <!-- Page Heading -->
          <div class="d-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Failed Users</h1>
          </div>
          <div id="operation_message"></div>
          <div class="card shadow mb-4">
            <div class="card-body">
              <form class="table-responsive" action="failed" method="post">
                <table class="table table-bordered" id="RateTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>                      
                    	<th>NAME</th>
                      <th>EMAIL</th>
                      <th>QUALIFICATION SCORE</th>
                      <th>TEST SCORE</th>
                      <th>TOTAL SCORE</th>
                      <th>INTRODUCTION</th>
                    </tr>
                  </thead>
                  <tbody>
                  	<td><?=ucwords($user_data['FNAME'].' '.$user_data['LNAME'])?></td>
                  	<td><?=$user_data['EMAIL'];?></td>
                  	<td><?=$user_data['QUALI']+$user_data['EXP'];?></td>
                  	<td><?=$result_data['ANS'];?></td>
                  	<td><?=$result_data['ANS']+($user_data['QUALI']+$user_data['EXP']);?></td>
                    <td><?=$user_data['DEFINATION'];?></td>
                  </tbody>
                </table>
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
            <h1 class="h3 mb-0 text-gray-800">Failed Users</h1>
          </div>
          <div id="operation_message"></div>
          <div class="card shadow mb-4">
            <div class="d-flex align-items-center justify-content-between card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Failed User List</h6>
            </div>
            <div class="card-body">
              <form class="table-responsive" action="failed" method="post">
                <table class="table table-bordered" id="RateTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>FIRST NAME</th>
                      <th>LAST NAME</th>
                      <th>EMAIL</th>
                      <th>SCORE</th>
                      <th>View</th>
                    </tr>
                  </thead>
                  <tbody>
                  	<?php
                  		$userq = $conex->query("SELECT U.FNAME, U.LNAME, U.EMAIL, U.PHONE, U.QUALI, U.EXP, U.STATUS, U.CODE USER_CODE, R.QUEST_CODE, SUM(R.ANS) ANS FROM `users` U, result R WHERE U.CODE = R.USER_CODE AND R.ANS = 1 AND U.STATUS = 4 GROUP BY R.USER_CODE ORDER BY (SUM(R.ANS)+U.QUALI+u.EXP) ASC");
                  		while ($data = $userq->fetch_assoc()) {
                  	?>
                  		<tr>
                        <td><?=ucwords($data['FNAME']);?></td>
                  			<td><?=ucwords($data['LNAME']);?></td>
                  			<td><?=ucwords($data['EMAIL']);?></td>
                  			<td><?=($data['QUALI']+$data['EXP']+$data['ANS']);?></td>
                  			<td><a href="failed?view=<?=($data['USER_CODE']);?>">View</a></td>
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