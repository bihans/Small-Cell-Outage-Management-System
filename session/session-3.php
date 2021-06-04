<?php

session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin0"]) || $_SESSION["loggedin0"] !== true){
    header("location: login.php");
    exit;
}



 ?>
