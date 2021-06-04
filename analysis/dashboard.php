<?php
  require "../session/session-2.php";
  require "data.php";

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="icon" href="images/fevi.png" type="image/x-icon"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <title></title>
  </head>
  <body style="background-image:url(../images/ai-back.png)">

    		<div class="container-fluid mt-3">
          <?php require '../navigation/navigation_dashboard.php';
								echo $nav;
					?>
        </div>
        <div class="container-fluid mt-3">
          <div class="row">
            <div class="col-sm-4">
              <div class="card bg-lighttext-white" style="width:auto;font-family: Poppins, sans-serif;">
                <div class="card-header" >
                  Essentials
                </div>
                <div class="card-body">
                  <button type="button" class="btn btn-warning">
                    <h6>Current Down<span class="badge badge-danger ml-3"><?php echo $cdt; ?></span></h6>
                  </button>

                  <button type="button" class="btn btn-warning mt-3">
                    <h6>Total Outage Down<span class="badge badge-danger ml-3"><?php echo $odt; ?></span></h6>
                  </button>
                </div>
                <div class="card-footer">

                </div>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="card bg-success text-white" style="width:auto;font-family: Poppins, sans-serif;">
                <div class="card-header" >
                  Essentials
                </div>
                <div class="card-body">
                  <div class="progress" style="height: 10px;">
                    <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
                <div class="card-footer">

                </div>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="card bg-success text-white" style="width:auto;font-family: Poppins, sans-serif;">
                <div class="card-header" >
                  Essentials
                </div>
                <div class="card-body">

                </div>
                <div class="card-footer">

                </div>
              </div>
            </div>
          </div>


        </div>

  </body>
</html>
