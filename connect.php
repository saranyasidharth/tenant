<?php
$conn = @mysqli_connect("localhost", "root", "", "rental_house");
if(!$conn){
  echo "Connection failed!".@mysqli_error($conn);
}
?>
