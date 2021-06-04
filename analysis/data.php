<?php

require "../db/connection.php";

//current down total cdt
//outage total odt

$cdt = '';
$odt = '';


$cdt_result= mysqli_query($connection, "SELECT COUNT(status) AS cdt_v FROM current_outage_table WHERE status='0'");
$odt_result = mysqli_query($connection, "SELECT COUNT(status) AS odt_v FROM current_outage_table WHERE status='1'");

while($row = mysqli_fetch_array($cdt_result))
{
  $cdt=$row['cdt_v'];
}

while($row = mysqli_fetch_array($odt_result))
{
  $odt=$row['odt_v'];
}

 ?>
