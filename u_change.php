<?php
session_start();
include "conn.php";
if(!$_SESSION['username']){
  echo '<script>window.location.href = "login.php";</script>';
  exit();
}
function check($data){
  $data= trim($data);
  $data= htmlspecialchars($data);
  $data= stripslashes($data);
  return $data;
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

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar" style="background-image: linear-gradient(200deg,#39A2DB,#25ffc8);">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="home.php">

        <div class="sidebar-brand-text mx-3">TENANT</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item" >
        <a class="nav-link" href="home.php"> &nbsp;
          <i class="fas fa-user fa-cog" style="color:black;"></i>
          <span style="color:black;  font-weight:700;">My Profile</span></a>
      </li>
      </li>
      <hr class="sidebar-divider">
      <li class="nav-item" >
        <a class="nav-link" href="u_personal.php">&nbsp;
          <i class="fa fa-info"style="color:black;"></i>
          <span style="color:black; font-weight:700;">Additional Information</span>
        </a>
      </li>
      <hr class="sidebar-divider">
      <li class="nav-item">
        <a class="nav-link" href="upay.php">
          <i class="fas fa-money-check" style="color:black;"></i>
          <span style="color:black; font-weight:700;">Payment History</span>
        </a>
      </li>
      <hr class="sidebar-divider">
      <li class="nav-item">
        <a class="nav-link" href="u_change.php">
          <i class="fas fa-fw fa-exchange-alt "style="color:black;"></i>
          <span style="color:black; font-weight:700;">Change Password</span>
        </a>
      </li>
      <hr class="sidebar-divider">
      <li class="nav-item">
        <a class="nav-link" href="pay.php">
          <i class="fas fa-fw fa-dollar-sign" style="color:black;"></i>
          <span style="color:black;font-weight:700;">Pay Here</span></a>
      </li>
      <!-- Nav Item - Tables -->

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow" style="background-color:#39A2DB; height:1.9cm;">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>


          <ul class="navbar-nav ml-auto">

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="mr-2 d-none d-lg-inline text-white-900 small" style="font-weight:900;"><?php

                $uname = @$_SESSION['username'];
                $query = "SELECT * FROM tenant WHERE u_name = '$uname' ";
                $result = mysqli_query($con, $query);
                $row=mysqli_fetch_assoc($result);
                do{
                  $fname = $row['fname'];
                  $lname = $row['lname'];
                  $full = $fname." ".$lname;
                  echo $full;

                  $row = mysqli_fetch_assoc($result);
                }while ($row);
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
          <h1 class="h3 mb-2 text-gray-800" align="center">Change Password</h1>

          <div class="card shadow mb-4">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-borderless" id="dataTable" width="100%" cellspacing="0">

                  <tbody>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method = "POST">
                    <tr>
                      <td>
                        Old Password:
                      </td>
                      <td><input type='text' class='form-control form-control-user' name='change'></td>
                    </tr>
                    <tr>
                      <td>
                        New Password:
                      </td>
                      <td><input type='password' class='form-control form-control-user' name='change1'></td>
                    </tr>
                    <tr>
                      <td>
                        Repeat the new Password:
                      </td>
                      <td><input type='password' class='form-control form-control-user' name='change2'></td>
                    </tr>
                    <tr>
                    <td></td>
                    <td><input class='btn btn-primary btn-user btn-lg' type='submit' name='submit' value='Change Password'></td>
                    </form>
                    <tr>
                    <?php
                    if (isset($_POST['submit'])) {
                      $query = "SELECT * FROM tenant WHERE u_name = '$uname' ";
                      $result1 = mysqli_query($con, $query);
                      $row=mysqli_fetch_assoc($result1);
                      do{
                        $id = $row['tenant_id'];
                        $pword = $row['p_word'];
                        $row = mysqli_fetch_assoc($result1);
                      }while ($row);
                      $old = md5($_POST['change']);
                      $new = check($_POST['change1']);
                      $rnew = check($_POST['change2']);
                      if($old == $pword){
                          if(!($rnew == $new)){
                          echo "<script> alert('Password does not match.');</script>";
                          }else{
                              if((strlen($rnew) < 8) || (strlen($new) < 8)){
                                echo "<script> alert('Password is too short.');</script>";
                              }elseif(!($rnew == '') || !($new == '')){
                                $new = md5($new);
                                $sql = "UPDATE tenant SET p_word ='$new' WHERE tenant_id = '$id'";
                                $result = mysqli_query($con, $sql);
                                echo "<script> alert('Password has been changed successfully. New password will be effective upon new login.');</script>";
                                echo '<style>body{display:none;}</style>';
                                echo '<script>window.location.href = "u_change.php";</script>';
                                exit;
                              }
                        }

                      }else{
                        echo "<script> alert('The old password is incorrect.');</script>";
                      }

                    }
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
          <a class="btn btn-primary" href="logout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <script>
    if ( window.history.replaceState ) {
      window.history.replaceState( null, null, window.location.href );
    }
  </script>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
