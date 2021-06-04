<?php
require 'session/session-1.php';
require 'db/database.php';

if ( !empty($_POST)) {
  // keep track validation errors
  $typeError          = null;
  $siteNameError      = null;
  $regionError        = null;
  $reportedToError    = null;
  $reportedByError    = null;
  $occuredTimeError   = null;
  $reportedTimeError  = null;
  $reasonforFaultError = null;
  $txReportedToError  = null;

  // keep track post values
  // $outageid        = $_POST['outageid'];
  $type            = $_POST['type'];
  $siteName        = $_POST['sitename'];
  $region          = $_POST['region'];
  $reportedTo      = $_POST['reportedto'];
  $reportedBy      = $_POST['reportedby'];
  $occuredTime     = $_POST['occuredtime'];
  $reportedTime    = $_POST['reportedtime'];
  $reasonforFault  = $_POST['reasonforfault'];
  $txReportedTo    = $_POST['txreportedto'];

  // validate input
  $valid = true;
  if (empty($type)) {
    $typeError = 'Please enter Type';
    $valid = false;
  }

  if (empty($siteName)) {
    $siteNameError = 'Please enter Site Name';
    $valid = false;
  }
  if (empty($region)) {
    $regionError = 'Please enter Region';
    $valid = false;
  }

  if (empty($reportedTo)) {
    $reportedToError = 'Please enter Reported to';
    $valid = false;
  }
  if (empty($reportedBy)) {
    $reportedByError= 'Please enter Reported By';
    $valid = false;
  }

  if (empty($occuredTime)) {
    $occuredTimeError = 'Please enter Occured Time';
    $valid = false;
  }

  if (empty($reportedTime)) {
    $reportedTimeError = 'Please enter Reported Time';
    $valid = false;
  }
  if (empty($reasonforFault)) {
    $reasonforFaultError= 'Please enter Reason for fault';
    $valid = false;
  }

  if (empty($txReportedTo)) {
    $txReportedToError = 'Please enter TX Reported To';
    $valid = false;
  }


  // insert data
  if ($valid) {

    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "
    INSERT INTO `current_outage_table`(`type`, `site_name`,
    `region`, `reported_to`, `reported_by`, `occured_time`, `reported_time`,
    `reason_for_fault`, `tx_reported_to`) VALUES (?,?,?,?,?,?,?,?,?)";

    $q = $pdo->prepare($sql);
    $q->execute(array($type,$siteName,$region,$reportedTo,$reportedBy,$occuredTime,$reportedTime,$reasonforFault,$txReportedTo));
    Database::disconnect();

    echo '<script language="javascript">';
    echo 'alert("Successfully Added"); location.href="index.php"';
    echo '</script>';



  }



}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="icon" href="images/fevi.png" type="image/x-icon"/>
  <link rel="stylesheet" type="text/css" href="css/styles.css">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

</head>

<body>
<div class="main">

  <h2>Create New Outage</h2> <br>
  <form class="form-horizontal" action="create.php" method="post">
      <div class="row">
        <div class="col-md-3">

          <div class="form-group <?php echo !empty($typeError)?'error':'';?>">
            <label class="form-label">Type</label>

            <select class="form-control" name="type" type="text"  placeholder="Type" value="<?php echo !empty($type)?$type:'';?>">
              <option>Huawei</option>
              <option>ZTE</option>
            </select>


            <?php if (!empty($typeError)): ?>
              <span class="help-inline"><?php echo $typeError;?></span>
            <?php endif; ?>

          </div>

                <!-- searchble -->
                <div class="form-group <?php echo !empty($siteNameError)?'error':'';?>">
                  <label class="form-label">Site Name</label>

                  <input type="text" name="sitename" id="search" class="form-control" placeholder="Search..." autocomplete="off" required>
                        <select class="list-group" >
                          <option value="" id="show-list"></option>
                          <!-- Here autocomplete list will be display -->
                        </select>

                </div>

        </div>
        <div class="col-md-1">

        </div>

        <div class="col-md-3">
          <div class="form-group <?php echo !empty($regionError)?'error':'';?>">
            <label class="form-label">Region</label>

            <select class="form-control" name="region" type="text"  placeholder="Region" value="<?php echo !empty($region)?$region:'';?>">
              <option>Colombo</option>
              <option>Gampaha</option>
              <option>Dehiwala</option>
              <option>Homagama</option>
              <option>Badulla</option>
              <option>Kurunegala</option>
              <option>Anuradhapura</option>
              <option>Ampara</option>
              <option>Polonnaruwa</option>
              <option>Jaffna</option>
              <option>Chilaw</option>
              <option>Negombo</option>
              <option>Galle</option>
              <option>Matara</option>
              <option>Monaragala</option>
              <option>Kandy</option>
              <option>Dehiovita</option>
              <option>Piliyandala</option>
              <option>Pettah</option>
              <option>Ratnapura</option>
            </select>

            <div class="controls">
              <?php if (!empty($regionError)): ?>
                <span class="help-inline"><?php echo $regionError;?></span>
              <?php endif;?>
            </div>
          </div>

          <div class="form-group <?php echo !empty($reportedToError)?'error':'';?>">
            <label class="form-label">Reported To</label>
            <div class="controls">
              <input class="form-control" name="reportedto" type="text"  placeholder="Reported To" value="<?php echo !empty($reportedTo)?$reportedTo:'';?>">
              <?php if (!empty($reportedToError)): ?>
                <span class="help-inline"><?php echo $reportedToError;?></span>
              <?php endif;?>
            </div>
          </div>

          <div class="form-group <?php echo !empty($reportedByError)?'error':'';?>">
            <label class="form-label">Reported By</label>
            <div class="controls">
              <input class="form-control" name="reportedby" type="text"  placeholder="Reported By" value="<?php echo htmlspecialchars($_SESSION["username"]);?>" required readonly>
              <?php if (!empty($reportedByError)): ?>
                <span class="help-inline"><?php echo $reportedByError;?></span>
              <?php endif;?>
            </div>
          </div>

          <div class="form-group <?php echo !empty($occuredTimeError)?'error':'';?>">
            <label class="form-label">Occured Time</label>
            <div class='input-group date' id='datetimepicker1'>
              <input class="form-control" name="occuredtime" type='text' placeholder="Occured Time" value="<?php echo !empty($occuredTime)?$occuredTime:'';?>" />
              <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
          </div>

        </div>

        <div class="col-md-1">

        </div>

        <div class="col-md-3">

          <div class="form-group <?php echo !empty($reportedTimeError)?'error':'';?>">
            <label class="form-label">Reported Time</label>
            <div class='input-group date' id='datetimepicker2'>

              <input name="reportedtime" class="form-control" type="text"  placeholder="Reported Time" value="<?php echo !empty($reportedTime)?$reportedTime:'';?>">
              <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </span>
              <?php if (!empty($reportedTimeError)): ?>
                <span class="help-inline"><?php echo $reportedTimeError;?></span>
              <?php endif;?>
            </div>
          </div>



          <div class="form-group <?php echo !empty($reasonforFaultError)?'error':'';?>">
            <label class="form-label">Reason for Fault</label>
            <div class="controls">
              <input class="form-control" name="reasonforfault" type="text"  placeholder="Reason for Fault" value="<?php echo !empty($reasonforFault)?$reasonforFault:'';?>">
              <?php if (!empty($reasonforFaultError)): ?>
                <span class="help-inline"><?php echo $reasonforFaultError;?></span>
              <?php endif;?>
            </div>
          </div>

          <div class="form-group <?php echo !empty($txReportedToError)?'error':'';?>">
            <label class="form-label">TX Reported To</label>
            <div class="controls">
              <input class="form-control" name="txreportedto" type="text"  placeholder="TX Reported To" value="<?php echo !empty($txReportedTo)?$txReportedTo:'';?>">
              <?php if (!empty($txReportedToError)): ?>
                <span class="help-inline"><?php echo $txReportedToError;?></span>
              <?php endif;?>
            </div>
          </div>
          <div class="form-actions">

            <button type="submit" class="btn btn-success">Create</button>
            <button type="button" class="btn btn-danger" onclick="document.location='index.php'">Back</button>
            <!-- <a class="btn" href="index.php">Back</a> -->
          </div>
        </div>

      </div>

  </form>
  </div>

  <script type="text/javascript">
  $(function () {
    $('#datetimepicker2').datetimepicker({
      // dateFormat: "yy-mm-dd",
      format: 'YYYY-MM-DD HH:mm'
    });

    $('#datetimepicker1').datetimepicker({
      // dateFormat: "yy-mm-dd",
      format: 'YYYY-MM-DD HH:mm'
    });
  });
  </script>
  <script src="js/script.js"></script>
</body>
</html>
