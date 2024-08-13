<?php include("includes/dashboard_header.php"); ?>
<?php
if (isset($_GET['add']) || isset($_GET['edit'])) {
  $quest = (isset($_POST['quest'])) ? $_POST['quest'] : '';
  $opt1 = (isset($_POST['opt1'])) ? mysqli_escape_string($conex, $_POST['opt1']) : '';
  $opt2 = (isset($_POST['opt2'])) ? mysqli_escape_string($conex, $_POST['opt2']) : '';
  $opt3 = (isset($_POST['opt3'])) ? mysqli_escape_string($conex, $_POST['opt3']) : '';
  $opt4 = (isset($_POST['opt4'])) ? mysqli_escape_string($conex, $_POST['opt4']) : '';
  $ans = (isset($_POST['ans'])) ? mysqli_escape_string($conex, $_POST['ans']) : '';
  $cat = (isset($_POST['cat'])) ? mysqli_escape_string($conex, $_POST['cat']) : '';
  if (isset($_GET['edit'])) {
    $edit_code = $_GET['edit'];
    $sql = $conex->query("SELECT * FROM quest WHERE CODE = '$edit_code'");
    $data = $sql->fetch_assoc();
    $quest = (isset($_POST['quest'])) ? $_POST['quest'] : $data['QUEST'];
    $opt1 = (isset($_POST['opt1'])) ? mysqli_escape_string($conex, $_POST['opt1']) : $data['OPT1'];
    $opt2 = (isset($_POST['opt2'])) ? mysqli_escape_string($conex, $_POST['opt2']) : $data['OPT2'];
    $opt3 = (isset($_POST['opt3'])) ? mysqli_escape_string($conex, $_POST['opt3']) : $data['OPT3'];
    $opt4 = (isset($_POST['opt4'])) ? mysqli_escape_string($conex, $_POST['opt4']) : $data['OPT4'];
    $ans = (isset($_POST['ans'])) ? mysqli_escape_string($conex, $_POST['ans']) : $data['ANS'];
    $cat = (isset($_POST['cat'])) ? mysqli_escape_string($conex, $_POST['cat']) : $data['CAT'];
  }
  if (isset($_POST['quest'])) {
    if (isset($_GET['edit'])) {
      $sql = $conex->query("SELECT * FROM quest WHERE CODE != '$edit_code' AND quest = '$quest'");
    } else {
      $sql = $conex->query("SELECT * FROM quest WHERE QUEST = '$quest'");
    }
    $rows = $sql->num_rows;
    if (empty($quest) || empty($opt1) || empty($opt2) || empty($opt3) || empty($opt4) || empty($ans)  || empty($cat)) {
      $_SESSION['error'] = 'PLEASE FILL ALL REQUIRED FIELDS!';
    } elseif ($rows > 1) {
      $_SESSION['error'] = 'THIS QUESTION ALREADY EXISTS!';
    } else {
      if (isset($_GET['edit'])) {
        $sql = $conex->query("UPDATE quest SET QUEST = '$quest', CAT = '$cat', OPT1 = '$opt1', OPT2 = '$opt2', OPT3 = '$opt3', OPT4 = '$opt4', ANS = '$ans' WHERE CODE = '$edit_code'");
        $msg = 'QUESTION SUCCESSFULLY UPDATED!';
      } else {
        $sql = $conex->query("INSERT INTO quest (CAT, QUEST, OPT1, OPT2, OPT3, OPT4, ANS) VALUES ('$cat', '$quest', '$opt1', '$opt2', '$opt3', '$opt4', '$ans')");
        $msg = 'QUESTION SUCCESSFULLY ADDED!';
      }
      if ($sql) {
        $_SESSION['success'] = $msg;
        redirect('quest', false);
        exit();
      } else {
        $_SESSION['error'] = 'THERE IS SOMETHING WRONG!';
      }
    }
  }
?>
  <div class="container-fluid">
    <?php include("includes/msg.php"); ?>
    <!-- Page Heading -->
    <div class="d-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">All questions</h1>
    </div>
    <div id="operation_message"></div>
    <div class="card shadow mb-4">
      <div class="d-flex align-items-center justify-content-between card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><?= (isset($_GET['edit'])) ? 'Edit' : 'Add' ?> Question</h6>
        <a href="quest" class="d-inline-block btn btn-sm btn-primary shadow-sm" id="add_button">All Questions</a>
      </div>
      <div class="card-body">
        <form action="quest?<?= (isset($_GET['edit'])) ? 'edit=' . $_GET['edit'] : 'add=1'; ?>" method="post">
          <div class="row">
            <div class="form-group col-md-12">
              <label for="quest">Question</label>
              <input type="text" name="quest" value="<?= $quest; ?>" id="quest" class="form-control " required />
            </div>
            <div class="form-group col-md-6">
              <label for="opt1">Option 1</label>
              <input type="text" name="opt1" value="<?= $opt1; ?>" id="opt1" class="form-control " required />
            </div>
            <div class="form-group col-md-6">
              <label for="opt2">Option 2</label>
              <input type="text" name="opt2" value="<?= $opt2; ?>" id="opt2" class="form-control " required />
            </div>
            <div class="form-group col-md-6">
              <label for="opt3">Option 3</label>
              <input type="text" name="opt3" value="<?= $opt3; ?>" id="opt3" class="form-control " required />
            </div>
            <div class="form-group col-md-6">
              <label for="opt4">Option 4</label>
              <input type="text" name="opt4" value="<?= $opt4; ?>" id="opt4" class="form-control " required />
            </div>
            <div class="form-group col-md-6">
              <label for="opt1">Answer</label>
              <input type="text" name="ans" value="<?= $ans; ?>" id="ans" class="form-control " required />
            </div>
            <div class="form-group col-md-6">
              <label for="opt1">Category</label>
              <input type="text" name="cat" value="<?= $cat; ?>" id="cat" class="form-control " required />
            </div>
            <div class="form-group col-md-12">
              <button type="submit" class="btn btn-info"><?= (isset($_GET['edit'])) ? 'Edit' : 'Add' ?></button>
            </div>
          </div>
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
      <h1 class="h3 mb-0 text-gray-800">All Questions</h1>
    </div>
    <div id="operation_message"></div>
    <div class="card shadow mb-4">
      <div class="d-flex align-items-center justify-content-between card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">All Questions List</h6>
        <a href="quest?add=1" class="d-inline-block btn btn-sm btn-primary shadow-sm" id="add_button">Add Question</a>
      </div>
      <div class="card-body">
        <form class="table-responsive" action="applied" method="post">
          <table class="table table-bordered" id="RateTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>QUESTION</th>
                <th>OPT 1</th>
                <th>OPT 2</th>
                <th>OPT 3</th>
                <th>OPT 4</th>
                <th>ANS</th>
                <th>MANAGE</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $userq = $conex->query("SELECT * FROM quest ORDER BY CODE DESC");
              while ($data = $userq->fetch_assoc()) {
              ?>
                <tr>
                  <td><?= ucwords($data['QUEST']); ?></td>
                  <td><?= ucwords($data['OPT1']); ?></td>
                  <td><?= ucwords($data['OPT2']); ?></td>
                  <td><?= ucwords($data['OPT3']); ?></td>
                  <td><?= ucwords($data['OPT4']); ?></td>
                  <td><?= ($data['ANS']); ?></td>
                  <td><a href="quest?edit=<?= $data['CODE']; ?>">Edit</a></td>
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