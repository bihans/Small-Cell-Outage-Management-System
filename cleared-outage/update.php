<?php
require '../session/session-2.php';
require '../db/database.php';

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
  $clearedCategory=null;

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
      echo 'alert("Successfully Updated the Outage."); location.href="index.php"';
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
  $clearedTime     = $data['cleared_date'];
  $reasonforFault  = $data['reason_for_fault'];
  $txReportedTo    = $data['tx_reported_to'];
  $reasonCategory  = $data['clearedreason'];



  Database::disconnect();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="icon" href="../images/fevi.png" type="image/x-icon"/>
  <!-- <link   href="css/bootstrap.min.css" rel="stylesheet"> -->
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
      <h2>Clear current Outage</h2><br>
      <form class="form-horizontal" action="update.php?id=<?php echo $id?>" method="post">
          <div class="row">
            <div class="col-md-2">

              <div class="form-group <?php echo !empty($outageidError)?'error':'';?>">
                <label class="form-label">Outage ID</label>

                <input class="form-control" name="outageid" type="text" placeholder="Outage ID" value="<?php echo $outageid; ?>"  required readonly>
                <?php if (!empty($outageidError)): ?>
                  <span class="help-inline"><?php echo $outageidError;?></span>
                <?php endif;?>

              </div>

              <div class="form-group <?php echo !empty($typeError)?'error':'';?>">
                <label class="form-label">Type</label>

                <select class="form-control" name="type" type="text"  placeholder="Type" value="<?php echo !empty($type)?$type:''?>">

                  <option <?php if($type=="Huawei") echo 'selected="selected"'; ?>>Huawei</option>
                  <option <?php if($type=="ZTE") echo 'selected="selected"'; ?>>ZTE</option>
                </select>


                <?php if (!empty($typeError)): ?>
                  <span class="help-inline"><?php echo $typeError;?></span>
                <?php endif; ?>

              </div>

              <div class="form-group <?php echo !empty($siteNameError)?'error':'';?>">
                <label class="form-label">Site Name</label>

                <input class="form-control" name="sitename" type="text" placeholder="Site Name" value="<?php echo !empty($email)?$email:'';echo $siteName;?>">
                <?php if (!empty($siteNameError)): ?>
                  <span class="help-inline"><?php echo $durationError;?></span>
                  <span class="help-inline"><?php echo $siteNameError;?></span>
                <?php endif;?>

              </div>

              <div class="form-group <?php echo !empty($regionError)?'error':'';?>">
                <label class="form-label">Region</label>

                <select class="form-control" name="region" type="text"  placeholder="Region" value="<?php echo !empty($region)?$region:'';echo $region;?>">
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
              </div>
              <div class="col-md-1">

              </div>

              <div class="col-md-2">
                <div class="form-group <?php echo !empty($reportedToError)?'error':'';?>">
                  <label class="form-label">Reported To</label>
                  <div class="controls">
                    <input class="form-control" name="reportedto" type="text"  placeholder="Reported To" value="<?php echo $reportedTo;?>" required>
                    <?php if (!empty($reportedToError)): ?>
                      <span class="help-inline"><?php echo $reportedToError;?></span>
                    <?php endif;?>
                  </div>
                </div>

                <div class="form-group <?php echo !empty($reportedByError)?'error':'';?>">
                  <label class="form-label">Reported By</label>
                  <div class="controls">
                    <input class="form-control" name="reportedby" type="text"  placeholder="Reported By" value="<?php echo $reportedBy;?>" required>
                    <?php if (!empty($reportedByError)): ?>
                      <span class="help-inline"><?php echo $reportedByError;?></span>
                    <?php endif;?>
                  </div>
                </div>

                <div class="form-group <?php echo !empty($occuredTimeError)?'error':'';?>">
                  <label class="form-label">Occured Time</label>
                  <div class='input-group date' id='datetimepicker1'>
                    <input class="form-control" name="occuredtime" type='text' placeholder="Occured Time" value="<?php echo !empty($occuredTime)?$occuredTime:'';echo $occuredTime;?>" />
                    <span class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                    <?php if (!empty($occuredTimeError)): ?>
                      <span class="help-inline"><?php echo $occuredTimeError;?></span>
                    <?php endif;?>
                  </div>
                </div>



                <div class="form-group <?php echo !empty($reportedTimeError)?'error':'';?>">
                  <label class="form-label">Reported Time</label>
                  <div class='input-group date' id='datetimepicker2'>

                    <input name="reportedtime" class="form-control" type="text"  placeholder="Reported Time" value="<?php echo $reportedTime;?>" required>
                    <span class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                    <?php if (!empty($reportedTimeError)): ?>
                      <span class="help-inline"><?php echo $reportedTimeError;?></span>
                    <?php endif;?>
                  </div>
                </div>
              </div>

              <div class="col-md-1">

              </div>

              <div class="col-md-2">
                <div class="form-group <?php echo !empty($reasonforFaultError)?'error':'';?>">
                  <label class="form-label">Reason for Fault</label>
                  <div class="controls">
                    <input class="form-control" name="reasonforfault" type="text"  placeholder="Reason for Fault" value="<?php echo $reasonforFault;?>" required>
                    <?php if (!empty($reasonforFaultError)): ?>
                      <span class="help-inline"><?php echo $reasonforFaultError;?></span>
                    <?php endif;?>
                  </div>
                </div>

                <div class="form-group <?php echo !empty($txReportedToError)?'error':'';?>">
                  <label class="form-label">TX Reported To</label>
                  <div class="controls">
                    <input class="form-control" name="txreportedto" type="text"  placeholder="TX Reported To" value="<?php echo $txReportedTo;?>" required>
                    <?php if (!empty($txReportedToError)): ?>
                      <span class="help-inline"><?php echo $txReportedToError;?></span>
                    <?php endif;?>
                  </div>
                </div>

                <div class="form-group">
                  <label class="form-label">Cleared Time</label>
                  <div class='input-group date' id='datetimepicker3'>
                    <input class="form-control" name="clearedtime" type='text' placeholder="Cleared Time" value="<?php echo $clearedTime;?>" required/>
                    <span class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div>
                </div>

                <div class="form-group">
                  <?php if (!empty($clearedTimeError)): ?>
                    <span class="help-inline"><?php echo $clearedTimeError;?></span>
                  <?php endif;?>
                </div>

                <div class="form-group">
                  <label class="form-label">Reason Category</label>

                  <input list="brow" name="clearedreason" type="text"  value="<?php echo $reasonCategory; ?>" required>
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
              </div>

              <div class="col-md-1">

              </div>

              <div class="form-group">
                <div class="form-actions">
                  <button type="submit" class="btn btn-success">Update</button>
                  <button type="button" class="btn btn-danger" onclick="document.location='index.php'">Back</button>
                </div>
              </div>





              </div>
            </div>
      </form>
    </div>


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
</body>
</html>
