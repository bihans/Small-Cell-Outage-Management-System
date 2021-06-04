<?php
require 'session/session-1.php';

// Include config file
require_once "db/config.php";

// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $sql = "UPDATE users SET password = ? WHERE id = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);

            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: login.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>




<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset='utf-8'>
      <meta name='viewport' content='width=device-width, initial-scale=1'>
      <link rel="icon" href="images/fevi.png" type="image/x-icon"/>
      <title>Small Cell Outage | Reset Password</title>
      <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' rel='stylesheet'>
      <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
      <link rel="stylesheet" href="css/login.css">
      <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
      <script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js'></script>
      <script type='text/javascript'></script>
  </head>
  <body oncontextmenu='return false' class='snippet-body'>
    <div class="container-fluid px-1 px-md-5 px-lg-1 px-xl-5 py-5 mx-auto">
    <div class="card card0 border-0">
        <div class="row d-flex">
            <div class="col-lg-6">
                <div class="card1 pb-5">
                    <div class="row"> <img src="images/fevi.png" style="width:100px;height:100px;" class="logo"> </div>
                    <div class="row px-3 justify-content-center mt-4 mb-5 border-line"></div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card2 card border-0 px-4 py-5">
                    <div class="row mb-4 px-3">
                        <h6 class="mb-0 mr-4 mt-2">SMALL SITE OUTAGE</h6>
                        <div class="facebook text-center mr-3">
                            <i class="fa fa-steam-square"></i>
                        </div>
                        <div class="twitter text-center mr-3">
                            <i class="fa fa-sitemap"></i>
                        </div>
                    </div>
                    <div class="row px-1 mb-4">
                        <div class="line"></div> <small class="or text-center">Hi</small>
                        <div class="line"></div>
                    </div>
                    <form action="reset-password.php" method="post">
                      <div class="row px-3 mb-3"> <label class="mb-1">
                              <h6 class="mb-0 text-sm">New Password</h6>
                          </label> <input type="password" name="new_password" placeholder="Enter password"> </div>
                    <div class="row px-3"> <label class="mb-1">
                            <h6 class="mb-0 text-sm">Confirm Password</h6>
                        </label> <input type="password" name="confirm_password" placeholder="Enter password"> </div>
                    <div class="row px-3 mb-3">
                        <span href="#" class="ml-auto mb-0 text-sm"><?php echo $new_password_err ?></span>
                        <span href="#" class="ml-auto mb-0 text-sm"><?php echo $confirm_password_err ?></span>
                    </div>
                    <div class="row mb-3 px-3"> <button type="submit" class="btn btn-blue text-center">Reset</button> </div>
                    <div class="row mb-4 px-3"> <small class="font-weight-bold">Don't have an account? <a class="text-danger " href="login.php">Login</a></small> </div>
                  </form>
                </div>
            </div>
        </div>
        <div class="bg-blue py-4">
            <div class="row px-3"> <small class="ml-4 ml-sm-5 mb-2">Copyright &copy; 2021. All rights reserved.</small>
                <div class="social-contact ml-4 ml-sm-auto"><span class="mr-4 mr-sm-5 text-sm">Small Cell Outage Management System Created by Bihan Samarasinghe</span> </div>
            </div>
        </div>
    </div>
</div>
                            </body>
                        </html>
