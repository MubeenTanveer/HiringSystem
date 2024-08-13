<?php include("includes/dashboard_header.php"); ?>
<?php
if (isset($_POST['users'])) {
  $users = $_POST['users'];
  if (!empty($users)) {
    $user_list = '';
    foreach ($users as $user) {
      $user_list .= $user . ',';
    }
    $all_list = substr($user_list, 0, -1);
    $conex->query("UPDATE users SET STATUS = 5 WHERE CODE IN ('$all_list') AND STATUS = 3");
    $conex->query("UPDATE users SET STATUS = 4 WHERE CODE NOT IN ('$all_list') AND STATUS = 3");
    $_SESSION['success'] = 'SELECTED USER QUALIFIED FOR JOB!';
    redirect('qualified', false);
    exit();
  } else {
    $_SESSION['error'] = 'PLEASE SELECT SOME USER!';
  }
}
?>
<?php
if (isset($_POST['mail'])) {
  $userq = $conex->query("SELECT U.FNAME, U.RESUMESCORE, U.LNAME, U.EMAIL, U.PHONE, U.QUALI, U.EXP, U.STATUS, U.CODE USER_CODE, R.QUEST_CODE, SUM(R.ANS) ANS FROM `users` U, result R WHERE U.CODE = R.USER_CODE AND R.ANS = 1 AND U.STATUS = 5 GROUP BY R.USER_CODE ORDER BY (SUM(R.ANS)+U.QUALI+u.EXP) ASC");
  while ($data = $userq->fetch_assoc()) {
    $to = $data['EMAIL'];
    $subject = "Invitation for Interview - Congratulations!";
    $message = "
    Dear {$data['FNAME']} {$data['LNAME']},

    We are delighted to inform you that after reviewing your resume, test and qualifications, you have been selected for the next stage in our hiring process. Congratulations on being shortlisted for an interview in company name.
    We were impressed by your skills experience qualities and believe that you would be a valuable addition to our team. Your application stood out among many others, and we are eager to learn more about you during the interview.
    During the interview, we will discuss your background, skills, and experiences in more detail. Please come prepared to talk about your achievements, career goals, and how you can contribute to our organization.
    Interview Details:
    Date: 20/5/2024
    Time: 9:PM PAK Time
    Location: Head Office Lahore
     ";

    $from = "bsit-fa20-008@tuf.edu.pk";
    $headers = "From : $from";

    if (mail($to, $subject, $message, $headers)) {
    } else {
      echo "Email sending failed.";
    }
  }
}
?>

<?php

if (isset($_GET['view'])) {
  $user_code = $_GET['view'];
  $userQ = $conex->query("SELECT * FROM users WHERE CODE = '$user_code'");
  $user_data = $userQ->fetch_assoc();
  $rscore = $conex->query("SELECT RESUMESCORE FROM users WHERE CODE = '$user_code'");
  $resume = $rscore->fetch_assoc();
  $aQ = $conex->query("SELECT sum(ANS) ANS FROM result WHERE USER_CODE = '$user_code' AND ANS = 1");
  $result_data = $aQ->fetch_assoc();
?>

  <div class="container-fluid">
    <?php include("includes/msg.php"); ?>
    <!-- Page Heading -->
    <div class="d-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Qualified Users</h1>
    </div>
    <div id="operation_message"></div>
    <div class="card shadow mb-4">
      <div class="card-body">
        <form class="table-responsive" action="qualified" method="post">
          <table class="table table-bordered" id="RateTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>NAME</th>
                <th>EMAIL</th>
                <th>QUALIFICATION SCORE</th>
                <th>TEST SCORE</th>
                <th>RESUME SCORE</th>
                <th>TOTAL SCORE</th>
                <th>INTRODUCTION</th>
              </tr>
            </thead>
            <tbody>
              <td><?= ucwords($user_data['FNAME'] . ' ' . $user_data['LNAME']) ?></td>
              <td><?= $user_data['EMAIL']; ?></td>
              <td><?= $user_data['QUALI'] + $user_data['EXP']; ?></td>
              <td><?= $result_data['ANS']; ?></td>
              <td><?= $resume['RESUMESCORE']; ?></td>
              <td><?= $result_data['ANS'] + $resume['RESUMESCORE'] + ($user_data['QUALI'] + $user_data['EXP']); ?></td>
              <td><?= $user_data['DEFINATION']; ?></td>
            </tbody>
          </table>
        </form>
      </div>
    </div>
  </div>
<?php } else { ?>
  <!-- Begin Page Content -->
  <div class="container-fluid">
    <?php include("includes/msg.php"); ?>
    <!-- Page Heading -->
    <div class="d-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Qualified Users</h1>
    </div>
    <div id="operation_message"></div>
    <div class="card shadow mb-4">
      <div class="d-flex align-items-center justify-content-between card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Qualified User List</h6>
      </div>
      <div class="card-body">
        <form class="table-responsive" action="qualified" method="post">
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
              $userq = $conex->query("SELECT U.FNAME, U.RESUMESCORE, U.LNAME, U.EMAIL, U.PHONE, U.QUALI, U.EXP, U.STATUS, U.CODE USER_CODE, R.QUEST_CODE, SUM(R.ANS) ANS FROM `users` U, result R WHERE U.CODE = R.USER_CODE AND R.ANS = 1 AND U.STATUS = 5 GROUP BY R.USER_CODE ORDER BY (SUM(R.ANS)+U.QUALI+u.EXP) ASC");
              while ($data = $userq->fetch_assoc()) {
              ?>
                <tr>
                  <td><?= ucwords($data['FNAME']); ?></td>
                  <td><?= ucwords($data['LNAME']); ?></td>
                  <td><?= ucwords($data['EMAIL']); ?></td>
                  <td><?php echo $data['QUALI'] + $data['EXP'] + $data['ANS'] + $data['RESUMESCORE'] ?></td>
                  <td><a href="qualified?view=<?= ($data['USER_CODE']); ?>">View</a></td>
                </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
          <button class="btn btn-info" type="submit" name="mail" id="mail">Send Mail</button>
        </form>
      </div>
    </div>
  </div>
<?php } ?>
<?php include("includes/dashboard_footer.php"); ?>