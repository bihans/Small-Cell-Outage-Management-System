<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin0"]) && $_SESSION["loggedin0"] === true){
    header("location:admin-dashboard.php");
    exit;
}

// Include config file
require_once "db/config.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "(Please enter username.)";
    } else{
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "(Please enter your password.)";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ? && user_status ='Admin' ";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin0"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            // Redirect user to welcome page
                            header("location:admin-dashboard.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "(Invalid username or password.You need to Contact System Administrator)";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "(Invalid username or password.You need to Contact System Administrator.)";
                }
            } else{
                echo "(Oops! Something went wrong. Please try again later.)";
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
      <title>SMALL CELL OUTAGE | Admin</title>
      <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' rel='stylesheet'>
      <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
      <link rel="stylesheet" href="css/admin.css">
      <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
      <script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js'></script>

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
                    <form action="admin.php" method="post">
                    <div class="row px-3"> <label class="mb-1">
                            <h6 class="mb-0 text-sm">Username <span class="ml-auto mb-0 text-sm"><?php echo $username_err ?></span></h6>
                        </label> <input class="mb-4" type="text" name="username" placeholder="Enter a valid email address"> </div>
                    <div class="row px-3"> <label class="mb-1">
                            <h6 class="mb-0 text-sm">Password <span class="ml-auto mb-0 text-sm"><?php echo $username_err ?></span></h6>
                        </label> <input type="password" name="password" placeholder="Enter password"> </div>
                    <div class="row px-3 mb-4">
                        <span class="ml-auto mb-0 text-sm"><?php echo $login_err ?></span>
                    </div>
                    <div class="row mb-3 px-3"> <button type="submit" class="btn btn-primary text-center">Login</button> </div>
                    <div class="row mb-4 px-3"> <small class="font-weight-bold">Do you have Primary Account? <a class="text-danger " href="login.php">Login</a></small> </div>
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
