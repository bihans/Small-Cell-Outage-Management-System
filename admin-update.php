<?php

require 'session/session-3.php';
require 'db/database.php';

$id = null;
if ( !empty($_GET['id'])) {
  $id = $_REQUEST['id'];
}

if ( null==$id ) {
  header("Location: admin.php");
}



if ( !empty($_POST)) {
  // keep track validation errors
  $userStatusError          = null;


  // keep track post values
  $userStatus       = $_POST['userstatus'];


  // validate input
  $valid = true;
  if (empty($userStatus)) {
    $userStatusError = 'Please enter Us';
    $valid = false;
  }





  // insert data
  try {
    if ($valid) {
      $pdo = Database::connect();
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "UPDATE users SET
      user_status=? WHERE id=?";

      $q = $pdo->prepare($sql);
      $q->execute(array($userStatus,$id));

      // $id_update = "UPDATE current_outage_table SET outage_id = @autoid :=(@autoid+1)";
      // $id_valid = $pdo->prepare($id_update);
      // $id_valid->execute(array());

      Database::disconnect();

      echo '<script language="javascript">';
      echo 'alert("Successfully Updated."); location.href="admin-update.php"';
      echo '</script>';
    }
  } catch (\Exception $e) {
    echo "<p class='alert alert-error'>Outage ID is Not Valid.Use New Outage ID</p>";
  }

} else {
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT * FROM users where id = ?";
  $q = $pdo->prepare($sql);
  $q->execute(array($id));
  $data = $q->fetch(PDO::FETCH_ASSOC);

  $userStatus        = $data['user_status'];




  Database::disconnect();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="icon" href="images/fevi.png" type="image/x-icon"/>
  <!-- <link   href="css/bootstrap.min.css" rel="stylesheet"> -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
  <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>

<body>
  <div class="main">
      <h2>Update User Status</h2><br>
      <form class="form-horizontal" action="admin-update.php?id=<?php echo $id?>" method="post">
          <div class="row">
            <div class="col-md-3">

              <div class="form-group <?php echo !empty($siteNameError)?'error':'';?>">
                <label class="form-label">User Status</label>

                <select class="form-control" name="userstatus" value="">
                  <option <?php if($userStatus=="Approve") echo 'selected="selected"'; ?>>Approve</option>
                  <option <?php if($userStatus=="Reject") echo 'selected="selected"'; ?>>Reject</option>
                  <option <?php if($userStatus=="Admin") echo 'selected="selected"'; ?>>Admin</option>
                </select>

                <?php if (!empty($userStatusError)): ?>
                  <span class="help-inline"><?php echo $userStatusError;?></span>
                <?php endif;?>

                <div class="form-actions">
                  <button type="submit" class="btn btn-success">Update</button>
                  <button type="button" class="btn btn-danger" onclick="document.location='admin.php'">Back</button>
                </div>
              </div>
            </div>

      </form>
    </div>
</body>
</html>
