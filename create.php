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
  try{
    if ($valid) {

      $pdo = Database::connect();
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "
      INSERT INTO `current_outage_table`(`type`, `site_name`,
      `region`, `reported_to`, `reported_by`, `occured_time`, `reported_time`,
      `reason_for_fault`, `tx_reported_to`,`status`) VALUES (?,?,?,?,?,?,?,?,?,0)";

      $q = $pdo->prepare($sql);
      $q->execute(array($type,$siteName,$region,$reportedTo,$reportedBy,$occuredTime,$reportedTime,$reasonforFault,$txReportedTo));
      Database::disconnect();

      echo '<script language="javascript">';
      echo 'alert("Successfully Added"); location.href="index.php"';
      echo '</script>';

    }
  } catch (\Exception $e) {
    echo $e;
  }

}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Create Outage</title>
    <link rel="icon" href="images/fevi.png" type="image/x-icon"/>
    <link rel="stylesheet" href="css/multiform.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css" rel="stylesheet"/>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

  </head>
  <body>

  <div class="container">
    <div class="card">
      <div class="card-header bg-dark">
        Add New Outage
      </div>
      <div class="card-body">
        <form action="create.php"  method="post">

          <div class="step step-1 active">

            <div class="form-group <?php echo !empty($typeError)?'error':'';?>">
              <label for="firstName">Type</label>
              <select name="type" type="text"  placeholder="Type" value="<?php echo !empty($type)?$type:'';?>" required>
              <option>Hua-2G</option>
              <option>Hua-3G</option>
              <option>Hua-4G</option>
              <option>ZTE-2G</option>
              <option>ZTE-3G</option>
              <option>ZTE-4G</option>
            </select>

            <?php if (!empty($typeError)): ?>
              <span class="help-inline"><?php echo $typeError;?></span>
            <?php endif; ?>

            </div>
            <div class="form-group <?php echo !empty($siteNameError)?'error':'';?>">
              <label for="lastName">Site Name</label>
                <?php require 'jquery-search/search.php';

                      ?>

            </div>

            <div class="form-group <?php echo !empty($regionError)?'error':'';?>">
              <label for="nickName">Region</label>
              <select name="region" type="text"  placeholder="Region" value="<?php echo !empty($region)?$region:'';?>">
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
            <button type="button" class="previous-btn" onclick="document.location='index.php'" >Back to Current</button>
            <button type="button" class="next-btn">Next</button>
          </div>

          <div class="step step-2">
            <div class="form-group <?php echo !empty($occuredTimeError)?'error':'';?>">
              <label for="firstName">Occured Time</label>
              <div class='input-group date' id='datetimepicker1'>
              <input name="occuredtime" type='text' placeholder="Occured Time" value="" />
              <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
            </div>

            <div class="form-group <?php echo !empty($reportedTimeoError)?'error':'';?>">
              <label for="firstName">Reported Time</label>
              <div class='input-group date' id='datetimepicker2'>
              <input name="reportedtime" type='text' placeholder="Reported Time" value="" />
              <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
            </div>

            <button type="button" class="previous-btn">Prev</button>
            <button type="button" class="next-btn">Next</button>
          </div>

          <div class="step step-3">
            <div class="form-group">
              <label for="country">Reported To</label>
              <input name="reportedto" type="text"  placeholder="Reported To" value="" required>
            </div>
            <div class="form-group">
              <label for="city">Reported By</label>
                <input name="reportedby" type="text"  placeholder="Reported By" value="<?php echo htmlspecialchars($_SESSION["username"]);?>" required readonly>
            </div>
            <div class="form-group">
              <label for="postCode">Tx Reported</label>
              <input name="txreportedto" type="text"  placeholder="TX Reported To" value="" required>
            </div>

            <div class="form-group">
              <label for="city">Reason for Fault</label>
              <input name="reasonforfault" type="text"  placeholder="Reason for Fault" value="" required>
            </div>
            <div class="form-actions">
            <button type="button" class="previous-btn">Prev</button>
            <button type="submit" class="submit-btn">Submit</button>
            </div>
          </div>

        </form>
      </div>
      <div class="card-footer">

      </div>
    </div>

  </div>
<script src="js/multiform.js" charset="utf-8"></script>

<script type="text/javascript">
  $(function () {
    $('#datetimepicker1').datetimepicker({
      // dateFormat: "yy-mm-dd",
      format: 'YYYY-MM-DD HH:mm'
    });

    $('#datetimepicker2').datetimepicker({
      // dateFormat: "yy-mm-dd",
      format: 'YYYY-MM-DD HH:mm'
    });

  });
  </script>
<script src="js/script.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js" ></script>
<script>
$("#searchddl").chosen();

</script>
  </body>
</html>
