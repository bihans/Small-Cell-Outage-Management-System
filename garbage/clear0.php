<?php

require 'session/session-1.php';
require 'db/database.php';

$id = null;
if ( !empty($_GET['id'])) {
  $id = $_REQUEST['id'];
}

if ( null==$id ) {
  header("Location: index.php");
}



if ( !empty($_POST)) {
  // keep track validation errors
  $idError          = null;
  $typeError          = null;
  $siteNameError      = null;
  $regionError        = null;
  $reportedToError    = null;
  $reportedByError    = null;
  $occuredTimeError   = null;
  $reportedTimeError  = null;
  $reasonforFaultError = null;
  $txReportedToError  = null;
  $clearedTimeError=null;
  $clearedCategoryError=null;

  // keep track post values
  $outageid        = $_POST['outageid'];
  $type            = $_POST['type'];
  $siteName        = $_POST['sitename'];
  $region          = $_POST['region'];
  $reportedTo      = $_POST['reportedto'];
  $reportedBy      = $_POST['reportedby'];
  $occuredTime     = $_POST['occuredtime'];
  $reportedTime    = $_POST['reportedtime'];
  $reasonforFault  = $_POST['reasonforfault'];
  $txReportedTo    = $_POST['txreportedto'];
  $clearedTime     = $_POST['clearedtime'];
  $clearedCategory = $_POST['clearedreason'];
  // validate input
  $valid = true;

  if (empty($outageid)) {
    $outageidError = 'Please enter ID';
    $valid = false;
  }

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
    $TimeError = 'Please Enter Correct Cleared Time';
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

  $date1 = strtotime($clearedTime);
  $date2 = strtotime($occuredTime);
  $durationError =($date1 - $date2)/60 ;

  if ($durationError<0 ) {
    $clearedTimeError = 'Please enter Valid cleared time';
    $valid = false;
  }

  if ($clearedCategoryError<0 ) {
    $clearedCategoryError = 'Please enter Valid cleared Category';
    $valid = false;
  }



  // insert data
  try {
    if ($valid) {
      $pdo = Database::connect();
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "UPDATE current_outage_table SET
      outage_id=?,type=?,site_name=?,region=?,
      reported_to=?,reported_by=?,occured_time=?,
      reported_time=?,cleared_date=?,reason_for_fault=?,
      tx_reported_to=?,status=1,duration=$durationError,clearedreason=? WHERE outage_id=?";

      $q = $pdo->prepare($sql);
      $q->execute(array($outageid,$type,$siteName,$region,$reportedTo,$reportedBy,$occuredTime,$reportedTime,$clearedTime,$reasonforFault,$txReportedTo,$clearedCategory,$id));

      // $id_update = "UPDATE current_outage_table SET outage_id = @autoid :=(@autoid+1)";
      // $id_valid = $pdo->prepare($id_update);
      // $id_valid->execute(array());

      Database::disconnect();
      echo '<script language="javascript">';
      echo 'alert("Successfully Cleared the Outage.Please Find it from Outage Tab"); location.href="index.php"';
      echo '</script>';
    }
  } catch (\Exception $e) {
    echo $e;
  }

} else {
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT * FROM current_outage_table where outage_id = ?";
  $q = $pdo->prepare($sql);
  $q->execute(array($id));
  $data = $q->fetch(PDO::FETCH_ASSOC);

  $outageid        = $data['outage_id'];
  $type            = $data['type'];
  $siteName        = $data['site_name'];
  $region          = $data['region'];
  $reportedTo      = $data['reported_to'];
  $reportedBy      = $data['reported_by'];
  $occuredTime     = $data['occured_time'];
  $reportedTime    = $data['reported_time'];
  $reasonforFault  = $data['reason_for_fault'];
  $txReportedTo    = $data['tx_reported_to'];



  Database::disconnect();
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="css/multiform.css">

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
        <form action="clear.php?id=<?php echo $id?>"  method="post">

          <div class="step step-1 active">

            <div class="form-group">
              <label for="country">Outage ID</label>
              <input name="outageid" type="text"  placeholder="Reported To" value="<?php echo $outageid; ?>" readonly >
            </div>

            <div class="form-group <?php echo !empty($typeError)?'error':'';?>">
              <label for="firstName">Type</label>
              <select name="type" type="text"  placeholder="Type" value="<?php echo !empty($type)?$type:'';?>" required>
              <option <?php if($type=="Hua-2G") echo 'selected="selected"'; ?>>Hua-2G</option>
              <option <?php if($type=="Hua-3G") echo 'selected="selected"'; ?>>Hua-3G</option>
              <option <?php if($type=="Hua-4G") echo 'selected="selected"'; ?>>Hua-4G</option>
              <option <?php if($type=="ZTE-2G") echo 'selected="selected"'; ?>>ZTE-2G</option>
              <option <?php if($type=="ZTE-3G") echo 'selected="selected"'; ?>>ZTE-3G</option>
              <option <?php if($type=="ZTE-4G") echo 'selected="selected"'; ?>>ZTE-4G</option>
            </select>

            <?php if (!empty($typeError)): ?>
              <span class="help-inline"><?php echo $typeError;?></span>
            <?php endif; ?>

            </div>
            <div class="form-group <?php echo !empty($siteNameError)?'error':'';?>">
              <label for="lastName">Site Name</label>
              <input type="text" name="sitename" value="<?php echo $siteName;?>" id="search" placeholder="Type Search..." autocomplete="off" required>
                <div class="list-group" id="show-list">
                          <!-- Here autocomplete list will be display -->
                </div>
            </div>

            <div class="form-group <?php echo !empty($regionError)?'error':'';?>">
              <label for="nickName">Region</label>
              <select name="region" type="text"  placeholder="Region" value="<?php echo !empty($region)?$region:'';?>">
                <option <?php if($region=="Colombo") echo 'selected="selected"'; ?>>Colombo</option>
                <option <?php if($region=="Gampaha") echo 'selected="selected"'; ?>>Gampaha</option>
                <option <?php if($region=="Dehiwala") echo 'selected="selected"'; ?>>Dehiwala</option>
                <option <?php if($region=="Homagama") echo 'selected="selected"'; ?>>Homagama</option>
                <option <?php if($region=="Badulla") echo 'selected="selected"'; ?>>Badulla</option>
                <option <?php if($region=="Kurunegala") echo 'selected="selected"'; ?>>Kurunegala</option>
                <option <?php if($region=="Anuradhapura") echo 'selected="selected"'; ?>>Anuradhapura</option>
                <option <?php if($region=="Ampara") echo 'selected="selected"'; ?>>Ampara</option>
                <option <?php if($region=="Polonnaruwa") echo 'selected="selected"'; ?>>Polonnaruwa</option>
                <option <?php if($region=="Jaffna") echo 'selected="selected"'; ?>>Jaffna</option>
                <option <?php if($region=="Chilaw") echo 'selected="selected"'; ?>>Chilaw</option>
                <option <?php if($region=="Negombo") echo 'selected="selected"'; ?>>Negombo</option>
                <option <?php if($region=="Galle") echo 'selected="selected"'; ?>>Galle</option>
                <option <?php if($region=="Matara") echo 'selected="selected"'; ?>>Matara</option>
                <option <?php if($region=="Monaragala") echo 'selected="selected"'; ?>>Monaragala</option>
                <option <?php if($region=="Kandy") echo 'selected="selected"'; ?>>Kandy</option>
                <option <?php if($region=="Dehiovita") echo 'selected="selected"'; ?>>Dehiovita</option>
                <option <?php if($region=="Piliyandala") echo 'selected="selected"'; ?>>Piliyandala</option>
                <option <?php if($region=="Pettah") echo 'selected="selected"'; ?>>Pettah</option>
                <option <?php if($region=="Ratnapura") echo 'selected="selected"'; ?>>Ratnapura</option>
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
              <input name="occuredtime" type='text' placeholder="Occured Time" value="<?php echo $occuredTime;?>" />
              <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
            </div>

            <div class="form-group <?php echo !empty($reportedTimeoError)?'error':'';?>">
              <label for="firstName">Reported Time</label>
              <div class='input-group date' id='datetimepicker2'>
              <input name="reportedtime" type='text' placeholder="Reported Time" value="<?php echo $reportedTime;?>" />
              <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
            </div>

            <div class="form-group">
              <label for="country">Reported To</label>
              <input name="reportedto" type="text"  placeholder="Reported To" value="<?php echo $reportedTo;?>" required>
            </div>
            <div class="form-group">
              <label for="city">Reported By</label>
                <input name="reportedby" type="text"  placeholder="Reported By" value="<?php echo htmlspecialchars($_SESSION["username"]);?>" required readonly>
            </div>


            <button type="button" class="previous-btn">Prev</button>
            <button type="button" class="next-btn">Next</button>
          </div>

          <div class="step step-3">

            <div class="form-group">
              <label for="postCode">Tx Reported</label>
              <input name="txreportedto" type="text"  placeholder="TX Reported To" value="<?php echo $txReportedTo;?>" required>
            </div>

            <div class="form-group">
              <label for="city">Reason for Fault</label>
              <input name="reasonforfault" type="text"  placeholder="Reason for Fault" value="<?php echo $reasonforFault;?>" required>
            </div>

            <div class="form-group">
              <label for="firstName">Cleared Time</label>
              <div class='input-group date' id='datetimepicker3'>
              <input name="clearedtime" type='text' placeholder="Cleared Time" value="" required/>
              <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
            </div>

            <div class="form-group">
              <label class="form-label">Reason Category</label>

              <input list="brow" name="clearedreason" type="text"  value="" required>
              <datalist id="brow">
                <option>CEB / LECO PD</option>
                <option>Low Volt</option>
                <option>Pwr Tri</option>
                <option>Pwr Diss</option>
                <option>BT Weak</option>
                <option>BT Stolen</option>
                <option>E1 / Fiber</option>
                <option>SCTP</option>
                <option>S-Other</option>
                <option>ZTE/HW/ER</option>
                <option>E1 Configuration</option>
                <option>E1 Connector</option>
                <option>E1 Cable</option>
                <option>SCTP</option>
                <option>M-Other</option>
                <option>DBN TX</option>
                <option>ETI TX</option>
                <option>Army TX</option>
                <option>RAIN FD</option>
                <option>Lightning</option>
                <option>Flood</option>
                <option>Geny Fault</option>
                <option>Geny Fuel</option>
                <option>Geny Maintaince</option>
                <option>Faults</option>
                <option>Acci</option>
                <option>Auto Up</option>
                <option>Highroom</option>
                <option>BRD</option>
                <option>FAN</option>
                <option>CBL</option>
                <option>BBU</option>
                <option>Access issues</option>


              </datalist>
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

    $('#datetimepicker3').datetimepicker({
      // dateFormat: "yy-mm-dd",
      format: 'YYYY-MM-DD HH:mm'
    });

  });
  </script>
<script src="js/script.js"></script>
  </body>
</html>
