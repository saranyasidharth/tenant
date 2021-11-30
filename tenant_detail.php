<?php
session_start();
include "conn.php";
if(!$_SESSION['username']){
  echo '<script>window.location.href = "login.php";</script>';
  exit();
}
 ?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>TENANT</title>
    <link rel="icon" href="icon1.jpg">
   <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
 </head>
 <body id="page-top">
   <!-- Page Wrapper -->
   <div id="wrapper">
     <!-- Sidebar -->
     <ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar"style="background-image: linear-gradient(200deg,#39A2DB,#25ffc8);">
<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="admin_home.php">

    <img src="logo.png" height="70" width="200">
  <div class="sidebar-brand-text mx-3"></div>
</a>

<!-- Divider -->
<div class="dashboard" >
<hr class="sidebar-divider" width=100%>
<li class="nav-item" >
  <a class="nav-link" href="admin_home.php">
    <i class="fa fa-dashboard" style="color:black;"></i>
    <span style="color:black; font-weight:700;">Dashboard</span>
  </a>
</li>


<!-- Nav Item - Pages Collapse Menu -->

<hr class="sidebar-divider">
<li class="nav-item" >
  <a class="nav-link" href="house_detail.php">
    <i class="fas fa-home"style="color:black;"></i>
    <span style="color:black; font-weight:700;">House Information</span>
  </a>
</li>
<hr class="sidebar-divider">
<li class="nav-item" >
<a class="nav-link" href="contract_detail.php">
<i class="fas fa-file-contract"style="color:black;"></i>
<span style="color:black; font-weight:700;">Contract</span>
</a>
</li>
<hr class="sidebar-divider">
<li class="nav-item" >
<a class="nav-link" href="tenant_detail.php">
<i class="fa fa-user"style="color:black;"></i>
<span style="color:black; font-weight:700;">Tenants</span>
</a>
</li>
<hr class="sidebar-divider">
<li class="nav-item" >
<a class="nav-link" href="payment_detail.php">
<i class="fas fa-rupee-sign"style="color:black;"></i>
<span style="color:black; font-weight:700;">Payment</span>
</a>
</li>


</li>
<hr class="sidebar-divider">
<li class="nav-item" >
<a class="nav-link" href="a_change.php">
<i class="fas fa-fw fa-exchange-alt"style="color:black;"></i>
<span style="color:black; font-weight:700;">Change Password
</span>
</a>
</li>



   <!-- Nav Item - Charts -->


<!-- Nav Item - Tables -->

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<center>
<div class="text-center d-none d-md-inline">
  <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>
<center>
</ul>
     <!-- End of Sidebar -->

     <!-- Content Wrapper -->
     <div id="content-wrapper" class="d-flex flex-column">

<!-- Main Content -->
<div id="content">

  <!-- Topbar -->
  <nav class="navbar navbar-expand navbar-light  topbar mb-2 static-top shadow" style="background-color:rgba(57,162,219,.96); height:1.91cm; width=100%" >
  
  <!-- <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"> -->

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
      <i class="fa fa-bars"></i>
    </button>


    <ul class="navbar-nav ml-auto">


      <div class="topbar-divider d-none d-sm-block"></div>

      <!-- Nav Item - User Information -->
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="mr-2 d-none d-lg-inline text-white-600 small">
            <?php

          $uname = $_SESSION['username'];
          echo "<b><b>".$uname."</b></b>";

            ?></span>
          <img class="img-profile rounded-circle" src="user.png">
        </a>
        <!-- Dropdown - User Information -->
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">

          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
            Logout
          </a>

      </li>

    </ul>

  </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800" align = "center">Tenants</h1>


          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Occupation</th>
                      <th>Phone # 1</th>
                      <th>Phone # 2</th>
                      <th>Email</th>
                      <th>Postal Address</th>
                      <th>City</th>
                      <th>Region</th>
                      <th>Status</th>
                      <th></th>

                    </tr>
                  </thead>
                  <tbody>
                    <?php

                    $sql = "SELECT * FROM tenant";
                    $result = mysqli_query($con, $sql);
                    $row = mysqli_fetch_assoc($result);

                    do{
                      $fname = $row['fname'];
                      $lname = $row['lname'];
                      $uname = $row['u_name'];
                      $occ = $row['occupation'];
                      if($row['occupation'] == ''){
                         $occ = '-';
                      }
                      $pno1 = $row['p_no'];
                      $pno2 = $row['pno1'];
                      $email = $row['e_address'];
                      $postal = $row['p_address'];
                      $city = $row['city'];
                      $region = $row['region'];
                      $status = $row['status'];
                      if ($status == 0) {
                        echo '<tr>';
                        echo '<td>'.$fname.' '.$lname.'<br/>('.$uname.')</td>';
                        echo '<td>'.$occ.'</td>';
                        echo '<td>'.$pno1.'</td>';
                        echo '<td>'.$pno2.'</td>';
                        echo '<td>'.$email.'</td>';
                        echo '<td>'.$postal.'</td>';
                        echo '<td>'.$city.'</td>';
                        echo '<td>'.$region.'</td>';
                        echo "<td style = 'color:green;'>Payment Pending</td>";
                        echo "<td align = 'center'><a href='edit_tenant.php?id=".$row['tenant_id']."' class='btn  btn-circle'><i class='fas fa-edit' style='color:green'></i></a></td>";
                        echo '</tr>';
                      }elseif ($status == 1) {
                        echo '<tr>';
                        echo '<td>'.$fname.' '.$lname.'<br/>('.$uname.')</td>';
                        // echo '<td>'.$prog.'</td>';
                        // echo '<td>'.$reg.'</td>';
                        echo '<td>'.$occ.'</td>';
                        echo '<td>'.$pno1.'</td>';
                        echo '<td>'.$pno2.'</td>';
                        echo '<td>'.$email.'</td>';
                        echo '<td>'.$postal.'</td>';
                        echo '<td>'.$city.'</td>';
                        echo '<td>'.$region.'</td>';
                        echo "<td><b><b>Account Active</b></b></td>";
                        echo "<td align = 'center'><a href='edit_tenant.php?id=".$row['tenant_id']."' class='btn  btn-circle'><i class='fas fa-edit' style='color:green'></i></a></td>";
                        echo '</tr>';
                      }
                      elseif ($status == 2) {
                        echo '<tr>';
                        echo '<td>'.$fname.' '.$lname.'<br/>('.$uname.')</td>';
                        // echo '<td>'.$prog.'</td>';
                        // echo '<td>'.$reg.'</td>';
                        echo '<td>'.$occ.'</td>';
                        echo '<td>'.$pno1.'</td>';
                        echo '<td>'.$pno2.'</td>';
                        echo '<td>'.$email.'</td>';
                        echo '<td>'.$postal.'</td>';
                        echo '<td>'.$city.'</td>';
                        echo '<td>'.$region.'</td>';
                        echo "<td style = 'color:red;'>Contact the System Administrator.</td>";
                        echo "<td align = 'center'><a href='edit_tenant.php?id=".$row['tenant_id']."' class='btn  btn-circle'><i class='fas fa-edit' style='color:green'></i></a></td>";
                        echo '</tr>';
                      }
                      else {

                        echo '<tr>';
                        echo '<td>'.$fname.' '.$lname.'<br/>('.$uname.')</td>';
                        // echo '<td>'.$prog.'</td>';
                        // echo '<td>'.$reg.'</td>';
                        echo '<td>'.$occ.'</td>';
                        echo '<td>'.$pno1.'</td>';
                        echo '<td>'.$pno2.'</td>';
                        echo '<td>'.$email.'</td>';
                        echo '<td>'.$postal.'</td>';
                        echo '<td>'.$city.'</td>';
                        echo '<td>'.$region.'</td>';
                        echo "<td style = 'color:red;'>Contract has Expired.</td>";
                        echo "<td align = 'center'><a href='edit_tenant.php?id=".$row['tenant_id']."' class='btn btn-circle'><i class='fas fa-edit' style='color:green'></i></a></td>";
                        echo '</tr>';
                      }




                      $row = mysqli_fetch_assoc($result);
                    }while ($row);


                     ?>

                  </tbody>
                </table>
                <hr>
                <br/>
                <table class="table table-borderless" id="dataTable" width="100%" cellspacing="0">
                  <tbody>
                    <?php

                    $sql = "SELECT * FROM tenant";
                    $result = mysqli_query($con, $sql);
                    echo '<tr>';
                    echo '<td><b><b>TOTAL NUMBER OF TENANTS</b></b></td>';
                    echo "<td style = 'color:#39ADBA;'><b><b>".mysqli_num_rows($result)."</b></b></td>";
                    echo '</tr>';

                     ?>

                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
          <span>Copyright &copy; TENANT 2021</span>

          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-success" href="logout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>

</body>

</html>
