<?php
require '../session/session-2.php';
require '../db/database.php';

if ( !empty($_POST)) {
  // keep track validation errors
  $typeError             = null;
  $neNameError           = null;
  $siteIndexError        = null;
  $siteNameError         = null;
  $regionError           = null;


  // keep track post values
  // $outageid        = $_POST['outageid'];
  $type        = $_POST['type'];
  $neName      = $_POST['nename'];
  $siteIndex   = $_POST['siteindex'];
  $siteName    = $_POST['sitename'];
  $region      = $_POST['region'];
  $address     = $_POST['address'];
  $contact     = $_POST['contact'];
  $onairdate     = $_POST['onairdate'];
  $reportedBy = htmlspecialchars($_SESSION["username"]);

  $valid = true;
  if (empty($type)) {
    $typeError = 'Please enter Type';
    $valid = false;
  }

  if (empty($neName)) {
    $neNameError = 'Please enter Ne Name';
    $valid = false;
  }
  if (empty($siteIndex)) {
    $siteIndexError = 'Please enter Site Index';
    $valid = false;
  }

  if (empty($siteName)) {
    $siteNameError = 'Please enter Site Name';
    $valid = false;
  }
  if (empty($region)) {
    $regionError= 'Please enter Region';
    $valid = false;
  }


  // insert data
  try{
    if ($valid) {

      $pdo = Database::connect();
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "
      INSERT INTO `sitelist`(`type`, `ne_name`,
      `site_index`, `site_name`, `region`,`address`,`contact`,`onair`,`reportedby`) VALUES (?,?,?,?,?,?,?,?,?)";

      $q = $pdo->prepare($sql);
      $q->execute(array($type,$neName,$siteIndex,$siteName,$region,$address,$contact,$onairdate,$reportedBy));
      Database::disconnect();

      echo '<script language="javascript">';
      echo 'alert("Successfully Added the New Site"); location.href="index.php"';
      echo '</script>';

    }
  }catch (\Exception $e) {
    echo $e;
  }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Create New Site</title>
  <link rel="icon" href="../images/fevi.png" type="image/x-icon"/>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>

<body>
<div class="main">
  <div class="row">
  <h2>Create New Site</h2> <br>
  <form class="form-horizontal" action="createsite.php" method="post">
      <div class="row">
        <div class="col-md-3">

          <div class="form-group <?php echo !empty($siteIndexError)?'error':'';?>">
            <label class="form-label">Site Index</label>

            <input class="form-control" name="siteindex" type="number" placeholder="Site Index" value=""  required>
            <?php if (!empty($siteIndexError)): ?>
              <span class="help-inline"><?php echo $siteIndexError;?></span>
            <?php endif;?>

          </div>

          <div class="form-group <?php echo !empty($typeError)?'error':'';?>">
            <label class="form-label">Type</label>

            <select class="form-control" name="type" type="text"  placeholder="Type" value="">

              <option >Hua-2G</option>
              <option >Hua-3G</option>
              <option >Hua-4G</option>
              <option >ZTE-2G</option>
              <option >ZTE-3G</option>
              <option >ZTE-4G</option>
            </select>


            <?php if (!empty($typeError)): ?>
              <span class="help-inline"><?php echo $typeError;?></span>
            <?php endif; ?>

          </div>

          <div class="form-group <?php echo !empty($siteNameError)?'error':'';?>">
            <label class="form-label">Site Name</label>

            <input class="form-control" name="sitename" type="text" placeholder="Site Name" value="" required>
            <?php if (!empty($siteNameError)): ?>
              <span class="help-inline"><?php echo $siteNameError;?></span>
            <?php endif;?>

          </div>

          <div class="form-group <?php echo !empty($regionError)?'error':'';?>">
            <label class="form-label">Region</label>

            <select class="form-control" name="region" type="text"  placeholder="Region" value="" required>
              <option >Co</option>
              <option >Gm</option>
              <option >De</option>
              <option >Ho</option>
              <option >Ba</option>
              <option >Ku</option>
              <option >An</option>
              <option >Am</option>
              <option >Po</option>
              <option >Jf</option>
              <option >Ch</option>
              <option >Ne</option>
              <option >Ga</option>
              <option >Ma</option>
              <option >Ha</option>
              <option >Mo</option>
              <option >Ka</option>
              <option >De</option>
              <option >Pi</option>
              <option >Pe</option>
              <option >Ra</option>
              <option >Kd</option>
              <option >Wa</option>
              <option >NOA</option>
            </select>

            <div class="controls">
              <?php if (!empty($regionError)): ?>
                <span class="help-inline"><?php echo $regionError;?></span>
              <?php endif;?>
            </div>
          </div>
          </div>
          <div class="col-md-1">

          </div>

          <div class="col-md-3">
            <div class="form-group <?php echo !empty($neNameError)?'error':'';?>">
              <label class="form-label">Ne Name</label>
              <div class="controls">
                <input class="form-control" name="nename" type="text"  placeholder="NE Name" value="" required>
                <?php if (!empty($neNameError)): ?>
                  <span class="help-inline"><?php echo $neNameError;?></span>
                <?php endif;?>
              </div>
            </div>

            <div class="form-group">
              <label class="form-label">Address</label>
              <div class="controls">
                <input class="form-control" name="address" type="text"  placeholder="Address" value="">
              </div>
            </div>

            <div class="form-group">
              <label class="form-label">Contact</label>
              <div class="controls">
                <input class="form-control" name="contact" type="number"  placeholder="Contact" value="">
              </div>
            </div>



            <div class="form-group">
              <label class="form-label">Onair Date</label>
              <div class='input-group date' id='datetimepicker1'>

                <input name="onairdate" class="form-control" type="text"  placeholder="On Air Date" value="">
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
                </span>
              </div>
            </div>
          </div>

          <div class="col-md-1">

          </div>
            <div class="form-actions">
              <button type="submit" class="btn btn-success">Create</button>
              <button type="button" class="btn btn-danger" onclick="document.location='index.php'">Back</button>
            </div>
          </div>
        </div>

  </form>
  </div>
</div>
<script type="text/javascript">
$(function () {
  $('#datetimepicker1').datetimepicker({
    // dateFormat: "yy-mm-dd",
    format: 'YYYY-MM-DD HH:mm'
  });
});
</script>
  <script src="js/script.js"></script>
</body>
</html>
