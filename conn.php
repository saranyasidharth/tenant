<?php
$con = @mysqli_connect("localhost", "root", "", "rental_house");
if(!$con){
  echo "Connection failed!".@mysqli_error($con);
}
?>
