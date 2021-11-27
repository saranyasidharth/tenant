<?php
session_start();
include "conn.php";

$user = $_SESSION['username'];
$sql = "SELECT * FROM user WHERE u_name = '$user'";
$res = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($res);
do {
  $role = $row['role'];
  $row = mysqli_fetch_assoc($res);
} while ($row);
if(!$user && $role == 'Manager'){
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

  <title>Rental House Management System</title>
  <link rel="icon" href="rent.ico">

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="manager_home.php">

        <div class="sidebar-brand-text mx-3">Rental House Management System</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item">
        <a class="nav-link" href="manager_home.php">
          <i class="fas fa-fw fa-user"></i>
          <span>Tenant</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link" href="list.php">
          <i class="fas fa-fw fa-dollar-sign"></i>
          <span>List of Payments</span></a>
      </li>
      <hr class="sidebar-divider">

      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link" href="mform_out.php">
          <i class="fas fa-fw fa-clipboard-list"></i>
          <span>Tenant-Out form</span>
        </a>

      </li>
      <hr class="sidebar-divider">
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link" href="m_change.php">
          <i class="fas fa-fw fa-exchange-alt"></i>
          <span>Change Password</span>
        </a>

      </li>



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
         <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

           <!-- Sidebar Toggle (Topbar) -->
           <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
             <i class="fa fa-bars"></i>
           </button>


           <ul class="navbar-nav ml-auto">


             <div class="topbar-divider d-none d-sm-block"></div>

             <!-- Nav Item - User Information -->
             <li class="nav-item dropdown no-arrow">
               <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php

                 include "conn.php";
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
           <h1 class="h3 mb-2 text-gray-800" align="center">Tenant-Out Form.</h1>
           <p style="color:red;"><b><b>Please fill the required information upon tenant leaving the House.</b></b></p>

           <div class="card shadow mb-4">
             <div class="card-body">
               <div class="table-responsive">
                 <table class="table table-borderless" id="dataTable" width="100%" cellspacing="0">

                   <tbody>
                     <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method = "POST">
                       <tr>
                         <td>
                           Search for a tenant:
                         </td>
                         <td>
                           <select class="custom-select" name="tenant" style="width:300px;" required>
                             <option value = "" disabled selected>Please choose...</option>
                             <?php
                             $query = "SELECT * FROM contract WHERE status = 'Inactive'";
                             $result = mysqli_query($con, $query);
                             $row1=mysqli_fetch_assoc($result);
                             do {
                               $tenant_id = $row1['tenant_id'];
                               $query2 = "SELECT * FROM tenant WHERE tenant_id = '$tenant_id'";
                               $result1 = mysqli_query($con, $query2);
                               $row=mysqli_fetch_assoc($result1);
                               do{
                                 $id = $row['tenant_id'];
                                 $fname = $row['fname'];
                                 $lname = $row['lname'];
                                 $uname = $row['u_name'];
                                 echo "<option value = '".$id."'>".$fname." ".$lname." (". $uname.")"."</option>";
                                 $row = mysqli_fetch_assoc($result1);
                               }while ($row);

                               $row1=mysqli_fetch_assoc($result);
                             } while ($row1);

                              ?>
                           </select>
                         </td>
                       </tr>

                     <tr>
                       <td>
                         Condition of the Key and its Holder:
                       </td>
                       <td>
                         <select class="custom-select" name="key" style="width:300px;" required>
                           <option value = "" disabled selected>Please choose...</option>
                           <option value = "Good">Good</option>
                           <option value = "Average">Average</option>
                           <option value = "Bad">Bad</option>
                           <option value = "No key holder">No key holder</option>
                         </select>
                       </td>
                     </tr>
                     <tr>
                       <td>
                         Condition of the Electricity Remote:
                       </td>
                       <td>
                         <select class="custom-select" name="remote" style="width:300px;" required>
                           <option value = "" disabled selected>Please choose...</option>
                           <option value = "Good">Good</option>
                           <option value = "Average">Average</option>
                           <option value = "Bad">Bad</option>
                           <option value = "No remote">No remote</option>
                         </select>
                       </td>
                     </tr>
                     <tr>
                       <td>
                         Number of bulbs:
                       </td>
                       <td>
                         <select class="custom-select" name="nbulb" style="width:300px;" required>
                           <option value = "" disabled selected>Please choose...</option>
                           <option value = "1">1</option>
                           <option value = "2">2</option>
                           <option value = "3">3</option>
                           <option value = "0">0</option>
                         </select>
                       </td>
                     </tr>
                     <tr>
                       <td>
                         Condition of the Bulbs:
                       </td>
                       <td>
                         <select class="custom-select" name="bulb" style="width:300px;" required>
                           <option value = "" disabled selected>Please choose...</option>
                           <option value = "Good">Good</option>
                           <option value = "Average">Average</option>
                           <option value = "Bad">Bad</option>
                           <option value = "Some missing">Some missing</option>
                         </select>
                       </td>
                     </tr>
                     <tr>
                       <td>
                         Condition of the paint on the wall:
                       </td>
                       <td>
                         <select class="custom-select" name="paint" style="width:300px;" required>
                           <option value = "" disabled selected>Please choose...</option>
                           <option value = "Good">Good</option>
                           <option value = "Average">Average</option>
                           <option value = "Bad">Bad</option>
                         </select>
                       </td>
                     </tr>
                     <tr>
                       <td>
                         Condition of the Windows:
                       </td>
                       <td>
                         <select class="custom-select" name="window" style="width:300px;" required>
                           <option value = "" disabled selected>Please choose...</option>
                           <option value = "Good">Good</option>
                           <option value = "Average">Average</option>
                           <option value = "Bad">Bad</option>
                           <option value = "Some broken or missing">Some broken or missing</option>
                         </select>
                       </td>
                     </tr>
                     <tr>
                       <td>
                         Condition of the Toilet Sink:
                       </td>
                       <td>
                         <select class="custom-select" name="tsink" style="width:300px;" required>
                           <option value = "" disabled selected>Please choose...</option>
                           <option value = "Good">Good</option>
                           <option value = "Average">Average</option>
                           <option value = "Bad">Bad</option>
                           <option value = "Broken">Broken</option>
                         </select>
                       </td>
                     </tr>
                     <tr>
                       <td>
                         Condition of the Normal Sink:
                       </td>
                       <td>
                         <select class="custom-select" name="wsink" style="width:300px;" required>
                           <option value = "" disabled selected>Please choose...</option>
                           <option value = "Good">Good</option>
                           <option value = "Average">Average</option>
                           <option value = "Bad">Bad</option>
                           <option value = "Broken">Broken</option>
                         </select>
                       </td>
                     </tr>
                     <tr>
                       <td>
                         Condition of the Door Lock:
                       </td>
                       <td>
                         <select class="custom-select" name="lock" style="width:300px;" required>
                           <option value = "" disabled selected>Please choose...</option>
                           <option value = "Good">Good</option>
                           <option value = "Average">Average</option>
                           <option value = "Bad">Bad</option>
                           <option value = "Broken">Broken</option>
                         </select>
                       </td>
                     </tr>
                     <tr>
                       <td>
                         Condition of the Toilet's Door Lock:
                       </td>
                       <td>
                         <select class="custom-select" name="tlock" style="width:300px;" required>
                           <option value = "" disabled selected>Please choose...</option>
                           <option value = "Good">Good</option>
                           <option value = "Average">Average</option>
                           <option value = "Bad">Bad</option>
                           <option value = "Broken">Broken</option>
                         </select>
                       </td>
                     </tr>
                     <tr>
                       <td>
                         <span style="color:red;"><b><b>Please outline in details the concerns pertaining the above  items.</b></b></span>
                         <br/>Comments:
                       </td>
                       <td>
                         <textarea class='form-control' name="msg"  required><?php echo @$msg; ?></textarea>
                       </td>
                     </tr>
                     <tr>
                     <td></td>
                     <td><input class='btn btn-dark btn-user btn-lg' type='submit' name='submit' value='Submit'></td>
                     </form>
                     <tr>
                     <?php
                     if (isset($_POST['submit'])) {
                       $id = $_POST['tenant'];
                       $query1 = "SELECT * FROM contract WHERE tenant_id = '$id' AND status = 'Inactive'";
                       $result2 = mysqli_query($con, $query1);
                       $row1=mysqli_fetch_assoc($result2);
                       do{
                         $cid = $row1['contract_id'];
                         $row1 = mysqli_fetch_assoc($result2);
                       }while ($row1);
                       $h_key = $_POST['key'];
                       $remote = $_POST['remote'];
                       $nbulb = $_POST['nbulb'];
                       $bulb = $_POST['bulb'];
                       $paint = $_POST['paint'];
                       $window = $_POST['window'];
                       $tsink = $_POST['tsink'];
                       $wsink = $_POST['wsink'];
                       $lock = $_POST['lock'];
                       $tlock = $_POST['tlock'];

                       $msg = check($_POST['msg']);
                       $date = date('Y-m-d');


                       $query3 = "SELECT * FROM tenant_in WHERE contract_id = '$cid'";
                       $rs = mysqli_query($con, $query3);
                       if(mysqli_num_rows($rs) == 0){

                         $sql = "INSERT INTO tenant_out(`out_id`, `contract_id`, `stat_keyholder`, `stat_electricityRemote`, `no_bulbs`, `stat_bulbs`, `stat_paint`, `stat_Windows`, `stat_toiletSink`, `stat_washingSink`, `stat_doorLock`, `stat_toiletDoorLock`, `comments`, `date_reg`)
                         VALUES (' ','$cid','$h_key','$remote','$nbulb','$bulb','$paint','$window','$tsink','$wsink','$lock','$tlock','$msg','$date')";
                         mysqli_query($con, $sql);
                         mysqli_close($con);
                         echo "<script type='text/javascript'>alert('Your form has been submitted successfully');</script>";
                         echo '<style>body{display:none;}</style>';
                         echo '<script>window.location.href = "manager_home.php";</script>';


                       }else {
                         echo "<script type='text/javascript'>alert('You have already filled the form. Thank You.');</script>";
                         echo '<style>body{display:none;}</style>';
                         echo '<script>window.location.href = "manager_home.php";</script>';
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
             <span>Copyright &copy; RHMS 2019</span>
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
           <a class="btn btn-dark" href="logout.php">Logout</a>
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

   <!-- Page level plugins -->
   <script src="vendor/datatables/jquery.dataTables.min.js"></script>
   <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

   <!-- Page level custom scripts -->
   <script src="js/demo/datatables-demo.js"></script>

 </body>

 </html>
