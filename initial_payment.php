
<?php

include_once "vendor/nexmo/Client.php";
include_once "vendor/nexmo/Entity/HasEntityTrait.php";
include_once "vendor/nexmo/client/Exception/Exception.php";
include_once "vendor/nexmo/client/Exception/Request.php";
include_once "vendor/nexmo/Entity/EntityInterface.php";
include_once "vendor/nexmo/Message/MessageInterface.php";
include_once "vendor/nexmo/Message/CollectionTrait.php";
include_once "vendor/nexmo/Entity/RequestArrayTrait.php";
include_once "vendor/nexmo/Entity/JsonResponseTrait.php";
include_once "vendor/nexmo/Entity/Psr7Trait.php";
include_once "vendor/nexmo/Message/Message.php";
include_once "vendor/nexmo/client/ClientAwareInterface.php";
include_once "vendor/nexmo/client/ClientAwareTrait.php";
include_once "vendor/nexmo/Message/Client.php";
include_once "vendor/nexmo/client/Factory/FactoryInterface.php";
include_once "vendor/nexmo/client/Factory/MapFactory.php";
include_once "vendor/nexmo/client/Credentials/CredentialsInterface.php";
include_once "vendor/nexmo/client/Credentials/AbstractCredentials.php";
include_once "vendor/nexmo/client/Credentials/Basic.php";
require_once "vendor/autoload.php";


session_start();
include "conn.php";
if(!$_SESSION['username']){
  echo '<script>window.location.href = "login.php";</script>';
  exit();
}
include 'connect.php';


if (isset($_POST['submit'])) {
  $uname = @$_SESSION['username'];
  $query = "SELECT * FROM tenant WHERE u_name = '$uname' ";
  $result = mysqli_query($con, $query);
  $row=mysqli_fetch_assoc($result);
  do{
    $id = $row['tenant_id'];
    $row = mysqli_fetch_assoc($result);
  }while ($row);

  $pno = $_POST['pno'];
  $pno1 = $_POST['pno1'];
  $amount= $_POST['amount'];
  $pin = $_POST['pin'];
  $from = $_POST['from'];
  $to = $_POST['to'];
  $sql = "SELECT * FROM user WHERE phone = '$pno'";
  $query = mysqli_query($conn,$sql);
  $row = mysqli_fetch_assoc($query);
  do {
    $amm = $row['amount'];
    $pin_no = $row['pin_no'];
    $user = $row['user_id'];
    $row = mysqli_fetch_assoc($query);
  } while ($row);


  if (mysqli_num_rows($query) == 1) {
    if ($pin != $pin_no) {
      echo "<script> alert('Wrong PIN...');</script>";
    }else {
      if($amount > $amm ){
        echo "<script> alert('Insufficient Amount: your balance is: Tsh. ".$amm."');</script>";
      }
      else {
        $sql1 = "SELECT * FROM user WHERE phone = '$pno1'";
        $query1 = mysqli_query($conn,$sql1);
        $row1 = mysqli_fetch_assoc($query1);
        do {
          $amm1 = $row1['amount'];
          $rec = $row1['user_id'];
          $row1 = mysqli_fetch_assoc($query1);
        } while ($row1);
        if(mysqli_num_rows($query1) == 0){
          echo "<script> alert('The Phone Number does not exist');</script>";
        }else {
          $balance = $amm - $amount;
          $balance1  =  $amm1 + $amount;
          $ref_no = rand(1000000000,2147483647);
          $date = date('Y-m-d H:i:s');
          $sql2 = "INSERT INTO transaction VALUES ('$ref_no','$user','$rec','$amount','$date')";
          mysqli_query($conn,$sql2);
          $sql3 = "INSERT INTO payment(`payment_id`, `tenant_id`, `ref_no`, `amount`, `pay_from`, `pay_to`, `date`) VALUES (' ','$id','$ref_no','$amount','$from','$to','$date')";
          mysqli_query($con,$sql3);
          $sql4 = "UPDATE user SET amount = '$balance' WHERE phone = '$pno'";
          mysqli_query($conn,$sql4);
          $sql5 = "UPDATE user SET amount = '$balance1' WHERE phone = '$pno1'";
          mysqli_query($conn,$sql5);
          $sql6 = "UPDATE tenant SET status = '1' WHERE u_name = '$uname'";
          mysqli_query($con,$sql6);
          mysqli_close($conn);
          mysqli_close($con);

          $basic  = new \Nexmo\Client\Credentials\Basic('855de446', 'iKYHA4zYzabA4VKb');
          $client = new \Nexmo\Client($basic);


          try {
              $message = $client->message()->send([
                  'to' => "$pno",
                  'from' => '255621821818',
                  'text' => "You have sent Tsh. ".number_format($amount)." to $pno1. Your balance is Tsh.".number_format($balance).". Ref. number: $ref_no on $date. Thank You."
              ]);

              $response = $message->getResponseData();

              if($response['messages'][0]['status'] == 0) {
                  echo "<script> alert('The message was sent successfully');</script>";
              } else {
                  echo "<script> alert('The message failed!!!');</script>";
              }
          } catch (Exception $e) {
              echo "<script> alert('The message was not sent!!!');</script>";
          }



          try {
              $message = $client->message()->send([
                  'to' => "$pno1",
                  'from' => '255621821818',
                  'text' => "You have received Tsh. ".number_format($amount)." from $pno. Your balance is Tsh. ".number_format($balance1).". Ref. number: $ref_no on $date. Thank You."
              ]);

              $response = $message->getResponseData();

              if($response['messages'][0]['status'] == 0) {
                  echo "<script> alert('The message was sent successfully');</script>";
              } else {
                  echo "<script> alert('The message failed!!!');</script>";
              }
          } catch (Exception $e) {
              echo "<script> alert('The message was not sent!!!');</script>";
          }

          echo "<script type='text/javascript'>alert('Payment has been performed successfully!');</script>";
          echo '<style>body{display:none;}</style>';
          echo '<script>window.location.href = "login.php";</script>';
        }

      }
    }
  }else {
    echo "<script type='text/javascript'>alert('The number does not exist!');</script>";
    echo '<style>body{display:none;}</style>';
    echo '<script>window.location.href = "pay.php";</script>';
  }

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

 </head>

 <body id="page-top">

   <!-- Page Wrapper -->
   <div id="wrapper">

     <!-- Sidebar -->
     <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

       <!-- Sidebar - Brand -->
       <a class="sidebar-brand d-flex align-items-center justify-content-center" href="home.php">

         <div class="sidebar-brand-text mx-3">Rental House Management System</div>
       </a>

       <!-- Divider -->
       <hr class="sidebar-divider my-0">

       <!-- Nav Item - Dashboard -->
       <li class="nav-item">
         <a class="nav-link">
           <i class="fas fa-fw fa-tachometer-alt"></i>
           <span>Dashboard</span></a>
       </li>

       <!-- Divider -->
       <hr class="sidebar-divider">

       <!-- Heading -->

       <!-- Nav Item - Pages Collapse Menu -->
       <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
           <i class="fas fa-user fa-cog"></i>
           <span>Profile</span>
         </a>
         <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
           <div class="bg-white py-2 collapse-inner rounded">
             <h6 class="collapse-header">Details:</h6>
             <a class="collapse-item">Personal Information</a>
             <a class="collapse-item">Contact Information</a>
             <a class="collapse-item">Payment Information</a>
             <a class="collapse-item">Contract</a>
           </div>
         </div>
       </li>
       <hr class="sidebar-divider">




       <!-- Nav Item - Pages Collapse Menu -->
       <li class="nav-item">
         <a class="nav-link">
           <i class="fas fa-fw fa-exchange-alt"></i>
           <span>Change Password</span>
         </a>

       </li>
       <hr class="sidebar-divider">

       <!-- Nav Item - Charts -->
       <li class="nav-item">
         <a class="nav-link">
           <i class="fas fa-fw fa-clipboard-list"></i>
           <span>Tenant-In form</span>
         </a>

       </li>
       <hr class="sidebar-divider">

       <!-- Nav Item - Charts -->
       <li class="nav-item">
         <a class="nav-link">
           <i class="fas fa-fw fa-dollar-sign"></i>
           <span>Pay Here</span></a>
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

                 $uname = @$_SESSION['username'];
                 $query = "SELECT * FROM tenant WHERE u_name = '$uname' ";
                 $result = mysqli_query($con, $query);
                 $row=mysqli_fetch_assoc($result);
                 do{
                   $fname = $row['fname'];
                   $lname = $row['lname'];
                   $id = $row['tenant_id'];
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
           <h1 class="h3 mb-2 text-gray-800" align="center">TumaPesa Payment</h1>

           <div class="card shadow mb-4">
             <div class="card-body">
               <div class="table-responsive">
                 <table class="table table-borderless" id="dataTable" width="100%" cellspacing="0">

                   <tbody>
                     <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method = "POST">
                     <tr>
                       <td>
                         Your Phone Number: E.g; 255717******
                       </td>
                       <td><input type='text' class='form-control form-control-user' name='pno'></td>
                     </tr>
                     <tr>
                       <td>
                         Receipient's Phone Number:
                       </td>
                       <td><input type='text' class='form-control form-control-user' name='pno1' value="255717812676" readonly></td>
                     </tr>
                     <tr>
                       <td>
                         Your PIN Number:
                       </td>
                       <td><input type='password' class='form-control form-control-user' name='pin'></td>
                     </tr>
                     <tr>
                       <td>
                         Amount:
                       </td>
                       <td><input type='text' class='form-control form-control-user' name='amount'></td>
                     </tr>
                     <tr>
                       <td>
                         Payment From:
                       </td>
                       <td>
                         <select class="custom-select" name="from" id="terms" style="width:300px;">
                         <option value = "January <?php echo date('Y'); ?>">January <?php echo date('Y'); ?></option>
                         <option value = "February <?php echo date('Y'); ?>">February <?php echo date('Y'); ?></option>
                         <option value = "March <?php echo date('Y'); ?>">March <?php echo date('Y'); ?></option>
                         <option value = "April <?php echo date('Y'); ?>">April <?php echo date('Y'); ?></option>
                         <option value = "May <?php echo date('Y'); ?>">May <?php echo date('Y'); ?></option>
                         <option value = "June <?php echo date('Y'); ?>">June <?php echo date('Y'); ?></option>
                         <option value = "July <?php echo date('Y'); ?>">July <?php echo date('Y'); ?></option>
                         <option value = "August <?php echo date('Y'); ?>">August <?php echo date('Y'); ?></option>
                         <option value = "September <?php echo date('Y'); ?>">September <?php echo date('Y'); ?></option>
                         <option value = "October <?php echo date('Y'); ?>">October <?php echo date('Y'); ?></option>
                         <option value = "November <?php echo date('Y'); ?>">November <?php echo date('Y'); ?></option>
                         <option value = "December <?php echo date('Y'); ?>">December <?php echo date('Y'); ?></option>
                         <option value = "January <?php echo date('Y')+1; ?>">January <?php echo date('Y')+1; ?></option>
                         <option value = "February <?php echo date('Y')+1; ?>">February <?php echo date('Y')+1; ?></option>
                         <option value = "March <?php echo date('Y')+1; ?>">March <?php echo date('Y')+1; ?></option>
                         <option value = "April <?php echo date('Y')+1; ?>">April <?php echo date('Y')+1; ?></option>
                         <option value = "May <?php echo date('Y')+1; ?>">May <?php echo date('Y')+1; ?></option>
                         <option value = "June <?php echo date('Y')+1; ?>">June <?php echo date('Y')+1; ?></option>
                         <option value = "July <?php echo date('Y')+1; ?>">July <?php echo date('Y')+1; ?></option>
                         <option value = "August <?php echo date('Y')+1; ?>">August <?php echo date('Y')+1; ?></option>
                         <option value = "September <?php echo date('Y')+1; ?>">September <?php echo date('Y')+1; ?></option>
                         <option value = "October <?php echo date('Y')+1; ?>">October <?php echo date('Y')+1; ?></option>
                         <option value = "November <?php echo date('Y')+1; ?>">November <?php echo date('Y')+1; ?></option>
                         <option value = "December <?php echo date('Y')+1; ?>">December <?php echo date('Y')+1; ?></option>
                         </select>
                       </td>
                     </tr>
                     <tr>
                       <td>
                         To:
                       </td>
                       <td>
                         <select class="custom-select" name="to" id="terms" style="width:300px;">
                         <option value = "January <?php echo date('Y'); ?>">January <?php echo date('Y'); ?></option>
                         <option value = "February <?php echo date('Y'); ?>">February <?php echo date('Y'); ?></option>
                         <option value = "March <?php echo date('Y'); ?>">March <?php echo date('Y'); ?></option>
                         <option value = "April <?php echo date('Y'); ?>">April <?php echo date('Y'); ?></option>
                         <option value = "May <?php echo date('Y'); ?>">May <?php echo date('Y'); ?></option>
                         <option value = "June <?php echo date('Y'); ?>">June <?php echo date('Y'); ?></option>
                         <option value = "July <?php echo date('Y'); ?>">July <?php echo date('Y'); ?></option>
                         <option value = "August <?php echo date('Y'); ?>">August <?php echo date('Y'); ?></option>
                         <option value = "September <?php echo date('Y'); ?>">September <?php echo date('Y'); ?></option>
                         <option value = "October <?php echo date('Y'); ?>">October <?php echo date('Y'); ?></option>
                         <option value = "November <?php echo date('Y'); ?>">November <?php echo date('Y'); ?></option>
                         <option value = "December <?php echo date('Y'); ?>">December <?php echo date('Y'); ?></option>
                         <option value = "January <?php echo date('Y')+1; ?>">January <?php echo date('Y')+1; ?></option>
                         <option value = "February <?php echo date('Y')+1; ?>">February <?php echo date('Y')+1; ?></option>
                         <option value = "March <?php echo date('Y')+1; ?>">March <?php echo date('Y')+1; ?></option>
                         <option value = "April <?php echo date('Y')+1; ?>">April <?php echo date('Y')+1; ?></option>
                         <option value = "May <?php echo date('Y')+1; ?>">May <?php echo date('Y')+1; ?></option>
                         <option value = "June <?php echo date('Y')+1; ?>">June <?php echo date('Y')+1; ?></option>
                         <option value = "July <?php echo date('Y')+1; ?>">July <?php echo date('Y')+1; ?></option>
                         <option value = "August <?php echo date('Y')+1; ?>">August <?php echo date('Y')+1; ?></option>
                         <option value = "September <?php echo date('Y')+1; ?>">September <?php echo date('Y')+1; ?></option>
                         <option value = "October <?php echo date('Y')+1; ?>">October <?php echo date('Y')+1; ?></option>
                         <option value = "November <?php echo date('Y')+1; ?>">November <?php echo date('Y')+1; ?></option>
                         <option value = "December <?php echo date('Y')+1; ?>">December <?php echo date('Y')+1; ?></option>
                         </select>
                       </td>
                     </tr>
                     <tr>
                     <td></td>
                     <td><input class='btn btn-primary btn-user btn-lg' type='submit' name='submit' value='Pay'></td>
                     </form>
                     <tr>
                    </tbody>
                 </table>
               </div>
             </div>
           </div>
           <p><span style="color:red;"><b><b>N.B: Please Fill the Tenant-In Form upon Login. Thank You.</b></b></p></span>
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
