<?php
session_start();
include "conn.php";
$id = $_GET['id'];
echo $id;
$sql = "DELETE FROM contract WHERE contract_id = $id";
if (mysqli_query($con, $sql)) {
  echo "<script type='text/javascript'>alert('DELETED.');</script>";
  echo '<style>body{display:none; color:red;}</style>';
  echo '<script>window.location.href = "contract_detail.php";</script>';
  exit;
}else {
  echo "<script type='text/javascript'>alert('FAILED ".mysqli_error($con).".');</script>";
  echo '<style>body{display:none; color:red;}</style>';
  echo '<script>window.location.href = "contract_detail.php";</script>';
  exit;
}

mysqli_close($con);



 ?>
