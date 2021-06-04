<?php
require "db/connection.php";

if(mysqli_connect_errno()){
  echo "Connection Failed".mysqli_connect_error();
}

$result=mysqli_query($connection,"SELECT * FROM sitelist");

echo "<select name='sitename' id='searchddl'>";
echo "<option>--search Site</option>";
while($row=mysqli_fetch_array($result)){
  echo "<option>$row[site_name]</option>";
}
echo "</select>";

mysqli_close($connection);
 ?>
