<?php
require '../../session/session-2.php';
require '../../db/database.php';

$id = null;
if ( !empty($_GET['id'])) {
  $id = $_REQUEST['id'];
}

if ( null==$id ) {
  header("Location: index.php");
}



if ( !empty($_POST)) {
  // keep track validation errors
  $typeError             = null;
  $neNameError           = null;
  $siteIndexError        = null;
  $siteNameError         = null;
  $regionError           = null;


  // keep track post values
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
  try {
    if ($valid) {
      $pdo = Database::connect();
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "UPDATE sitelist SET
      type=?,ne_name=?,site_index=?,site_name=?,
      region=?,address=?,contact=?,onair=?,reportedby=? WHERE site_index=?";

      $q = $pdo->prepare($sql);
      $q->execute(array($type,$neName,$siteIndex,$siteName,$region,$address,$contact,$onairdate,$reportedBy,$id));

      // $id_update = "UPDATE current_outage_table SET outage_id = @autoid :=(@autoid+1)";
      // $id_valid = $pdo->prepare($id_update);
      // $id_valid->execute(array());

      Database::disconnect();

      echo '<script language="javascript">';
      echo 'alert("Successfully Updated the New Site"); location.href="../index.php"';
      echo '</script>';
    }
  } catch (\Exception $e) {
    echo "<p class='alert alert-error'>Outage ID is Not Valid.Use New Outage ID</p>";
  }

}else {
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT * FROM sitelist where site_index = ?";
  $q = $pdo->prepare($sql);
  $q->execute(array($id));
  $data = $q->fetch(PDO::FETCH_ASSOC);

  $siteIndex       = $data['site_index'];
  $neName          = $data['ne_name'];
  $type            = $data['type'];
  $siteName        = $data['site_name'];
  $region          = $data['region'];
  $address         = $data['address'];
  $contact         = $data['contact'];
  $onairdate       = $data['onair'];




  Database::disconnect();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="icon" href="../../images/fevi.png" type="image/x-icon"/>
  <!-- <link   href="css/bootstrap.min.css" rel="stylesheet"> -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../../css/styles.css">
</head>

<body>
  <div class="main">
      <h2>Update Small Site</h2><br>
      <form class="form-horizontal" action="update-newsite.php?id=<?php echo $id?>" method="post">
          <div class="row">
            <div class="col-md-3">

              <div class="form-group <?php echo !empty($siteIndexError)?'error':'';?>">
                <label class="form-label">Site Index</label>

                <input class="form-control" name="siteindex" type="text" placeholder="Site Index" value="<?php echo $siteIndex; ?>"  required>
                <?php if (!empty($siteIndexError)): ?>
                  <span class="help-inline"><?php echo $siteIndexError;?></span>
                <?php endif;?>

              </div>

              <div class="form-group <?php echo !empty($typeError)?'error':'';?>">
                <label class="form-label">Type</label>

                <select class="form-control" name="type" type="text"  placeholder="Type" value="<?php echo !empty($type)?$type:''?>">

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
                <label class="form-label">Site Name</label>

                <input class="form-control" name="sitename" type="text" placeholder="Site Name" value="<?php echo !empty($email)?$email:'';echo $siteName;?>">
                <?php if (!empty($siteNameError)): ?>
                  <span class="help-inline"><?php echo $siteNameError;?></span>
                <?php endif;?>

              </div>

              <div class="form-group <?php echo !empty($regionError)?'error':'';?>">
                <label class="form-label">Region</label>

                <select class="form-control" name="region" type="text"  placeholder="Region" value="<?php echo !empty($region)?$region:'';echo $region;?>">
                  <option <?php if($region=="Co") echo 'selected="selected"'; ?>>Co</option>
                  <option <?php if($region=="Gm") echo 'selected="selected"'; ?>>Gm</option>
                  <option <?php if($region=="De") echo 'selected="selected"'; ?>>De</option>
                  <option <?php if($region=="Ho") echo 'selected="selected"'; ?>>Ho</option>
                  <option <?php if($region=="Ba") echo 'selected="selected"'; ?>>Ba</option>
                  <option <?php if($region=="Ku") echo 'selected="selected"'; ?>>Ku</option>
                  <option <?php if($region=="An") echo 'selected="selected"'; ?>>An</option>
                  <option <?php if($region=="Am") echo 'selected="selected"'; ?>>Am</option>
                  <option <?php if($region=="Po") echo 'selected="selected"'; ?>>Po</option>
                  <option <?php if($region=="Jf") echo 'selected="selected"'; ?>>Jf</option>
                  <option <?php if($region=="Ch") echo 'selected="selected"'; ?>>Ch</option>
                  <option <?php if($region=="Ne") echo 'selected="selected"'; ?>>Ne</option>
                  <option <?php if($region=="Ga") echo 'selected="selected"'; ?>>Ga</option>
                  <option <?php if($region=="Ma") echo 'selected="selected"'; ?>>Ma</option>
                  <option <?php if($region=="Ha") echo 'selected="selected"'; ?>>Ha</option>
                  <option <?php if($region=="Mo") echo 'selected="selected"'; ?>>Mo</option>
                  <option <?php if($region=="Ka") echo 'selected="selected"'; ?>>Ka</option>
                  <option <?php if($region=="De") echo 'selected="selected"'; ?>>De</option>
                  <option <?php if($region=="Pi") echo 'selected="selected"'; ?>>Pi</option>
                  <option <?php if($region=="Pe") echo 'selected="selected"'; ?>>Pe</option>
                  <option <?php if($region=="Ra") echo 'selected="selected"'; ?>>Ra</option>
                  <option <?php if($region=="Kd") echo 'selected="selected"'; ?>>Kd</option>
                  <option <?php if($region=="Wa") echo 'selected="selected"'; ?>>Wa</option>
                  <option <?php if($region=="NOA") echo 'selected="selected"'; ?>>NOA</option>
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
                    <input class="form-control" name="nename" type="text"  placeholder="NE Name" value="<?php echo $neName;?>" required>
                    <?php if (!empty($neNameError)): ?>
                      <span class="help-inline"><?php echo $neNameError;?></span>
                    <?php endif;?>
                  </div>
                </div>

                <div class="form-group">
                  <label class="form-label">Address</label>
                  <div class="controls">
                    <input class="form-control" name="address" type="text"  placeholder="Address" value="<?php echo $address;?>">

                  </div>
                </div>

                <div class="form-group">
                  <label class="form-label">Contact</label>
                  <div class="controls">
                    <input class="form-control" name="contact" type="text"  placeholder="Contact" value="<?php echo $contact;?>">

                  </div>
                </div>



                <div class="form-group">
                  <label class="form-label">Onair Date</label>
                  <div class='input-group date' id='datetimepicker1'>

                    <input name="onairdate" class="form-control" type="text"  placeholder="" value="<?php echo $onairdate;?>">
                    <span class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div>
                </div>
              </div>

              <div class="col-md-1">

              </div>
                <div class="form-actions">
                  <button type="submit" class="btn btn-success">Update</button>
                  <button type="button" class="btn btn-danger" onclick="document.location='../index.php'">Back</button>
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
});
  </script>
</body>
</html>
