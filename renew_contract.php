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

  <title>Rental House Management System</title>
  <link rel="icon" href="rent.ico">

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

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
        <a class="nav-link" href="renew_contract.php">
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

                $uname = $_SESSION['username'];
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
          <h1 class="h3 mb-2 text-gray-800" align="center">Renew Contract</h1>
          <div class="card shadow mb-4">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-borderless" id="dataTable" width="100%" cellspacing="0">
                  <tbody>
                    <tr>
                      <form class="user" action="<?php echo $_SERVER['PHP_SELF']; ?>" method = "POST">
                      <td>
                        Please click the price of the house you want to rent:
                      </td>
                      <td>
                        <input type="radio" name="price" value = "50000" required>Tsh. 50,000&nbsp
                        <input type="radio" name="price" value = "60000">Tsh. 60,000&nbsp
                        <input type="radio" name="price" value = "70000">Tsh. 70,000&nbsp
                        <input type="radio" name="price" value = "80000">Tsh. 80,000
                      </td>
                    </tr>
                    <tr>
                      <td>
                      </td>
                      <td>
                        <select class="custom-select" name="house" id = "values" style="width:200px;">

                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Contract Duration:
                      </td>
                      <td>
                        <select class="custom-select" name="duration" style="width:300px;">
                          <option  value = "3">3 months</option>
                          <option value = "6">6 months</option>
                          <option value = "12">12 months</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Payment Terms:
                      </td>
                      <td>
                        <select class="custom-select" name="term" id="terms" style="width:300px;">
                        <option value = "1" id="1">1 term</option>
                        <option value = "2" id="2">2 terms</option>
                        <option value = "4" id="4">4 terms</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <a href="#" data-toggle="modal" data-target="#contractModal">
                          Click here to view the contract:
                        </a>
                      </td>
                      <td>
                        <input type="checkbox" name="contract" value = "Occupied" required>I agree
                      </td>
                    </tr>
                    <tr>
                    <td></td>
                    <td><input class='btn btn-primary btn-user btn-lg' type='submit' name='submit' value='Renew Contract'></td>
                    </form>
                  </tr>
                  </tbody>
                  <?php
                  if(isset($_POST["submit"])){
                    $house = (int)$_POST["house"];
                    $dur =  (int)$_POST['duration'];
                    $dur1 =  $dur - 1;
                    $term = (int)$_POST['term'];
                    $price = (int)$_POST['price'];
                    $stat = "Active";
                    $total_rent = $dur * $price;
                    $rent_term = $total_rent / $term;
                    $date_sign = date("Y-m-d H:i:s");
                    $contract = $_POST['contract'];
                    if(date('d')<27){
                      $end = date('Y-m-t', strtotime('+'.$dur1.' month'));
                    }else{
                      $end = date('Y-m-t', strtotime('+'.$dur1.' month'));
                    }
                    if((date('d')<27)){
                      $start = date('Y-m-01');
                    }else{
                      $start = date('Y-m-01', strtotime('+1 month'));
                    }

                    $uname = $_SESSION['username'];
                    $query = "SELECT * FROM tenant WHERE u_name = '$uname' ";
                    $result = mysqli_query($con, $query);
                    $row = mysqli_fetch_assoc($result);
                    do{
                      $id = $row['tenant_id'];

                      $row = mysqli_fetch_assoc($result);
                    }while ($row);


                    if ($dur == 3) {
                      if (!($term == 1)) {
                        echo "<script> alert('3 months cannot have more than 1 term.');</script>";
                      }else {
                        $sql = "INSERT INTO contract (tenant_id, house_id, duration_month, total_rent, terms, rent_per_term, start_day, end_day, date_contract_sign, status) VALUES ('$id', '$house', '$dur', '$total_rent', '$term', '$rent_term', '$start', '$end', '$date_sign', '$stat')";
                        if(mysqli_query($con, $sql)){
                          $sql1 = "UPDATE house SET status= '$contract' WHERE house_id = '$house'";
                          mysqli_query($con, $sql1);
                          $sql2 = "UPDATE tenant SET status= 0 WHERE tenant_id = '$id'";
                          mysqli_query($con, $sql2);
                          mysqli_close($con);
                          unset($_SESSION['username']);
                          session_destroy();
                          echo "<script type='text/javascript'>alert('Your contract is renewed! You will be logged out to proceed with payment!');</script>";
                          echo '<style>body{display:none;}</style>';
                          echo '<script>window.location.href = "login.php";</script>';
                          exit;
                      }
                    }
                    }elseif($dur == 6){
                        if ($term == 4) {
                          echo "<script type='text/javascript'>alert('6 months cannot have more than 2 term.');</script>";
                        }else {
                          $sql = "INSERT INTO contract (tenant_id, house_id, duration_month, total_rent, terms, rent_per_term, start_day, end_day, date_contract_sign, status) VALUES ('$id', '$house', '$dur', '$total_rent', '$term', '$rent_term', '$start', '$end', '$date_sign', '$stat')";
                          if(mysqli_query($con, $sql)){
                            $sql1 = "UPDATE house SET status= '$contract' WHERE house_id = '$house'";
                            mysqli_query($con, $sql1);
                            $sql2 = "UPDATE tenant SET status= 0 WHERE tenant_id = '$id'";
                            mysqli_query($con, $sql2);
                            mysqli_close($con);
                            unset($_SESSION['username']);
                            session_destroy();
                            echo "<script type='text/javascript'>alert('Your contract is renewed! You will be logged out to proceed with payment!');</script>";
                            echo '<style>body{display:none;}</style>';
                            echo '<script>window.location.href = "login.php";</script>';
                            exit;
                        }
                      }
                    }else {
                      $sql = "INSERT INTO contract (tenant_id, house_id, duration_month, total_rent, terms, rent_per_term, start_day, end_day, date_contract_sign, status) VALUES ('$id', '$house', '$dur', '$total_rent', '$term', '$rent_term', '$start', '$end', '$date_sign', '$stat')";
                      if(mysqli_query($con, $sql)){
                        $sql1 = "UPDATE house SET status= '$contract' WHERE house_id = '$house'";
                        mysqli_query($con, $sql1);
                        $sql2 = "UPDATE tenant SET status= 0 WHERE tenant_id = '$id'";
                        mysqli_query($con, $sql2);
                        mysqli_close($con);
                        unset($_SESSION['username']);
                        session_destroy();
                        echo "<script type='text/javascript'>alert('Your contract is renewed! You will be logged out to proceed with payment!');</script>";
                        echo '<style>body{display:none;}</style>';
                        echo '<script>window.location.href = "login.php";</script>';
                        exit;
                    }


                }
                   ?>
                </table>
              </div>
            </div>
          </div>
            <p class="mb-4">For more information or help please kindly contact us through:<br/><br/><b>Phone Number: +255 (0) 756 777 777.<br/>Email Address: rhms123@hotmail.com.</b></p>

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

  <div class="modal" id="contractModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"><b><b>CONTRACT</b></b></h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body"><iframe src="s.pdf" width="1330px" height="400px" style="border: none;"></iframe></div>
      </div>
    </div>
  </div>

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
  $(document).ready(function(){
    $('input:checkbox').click(function() {
        $('input:checkbox').not(this).prop('checked', false);
    });
});
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $("input[name='price']").click(function(){
            var radioValue = $("input[name='price']:checked").val();
            if(radioValue == 50000){
              var out = "<?php  $con = mysqli_connect('localhost', 'root', '');
                mysqli_select_db($con,'rental_house');
                $sql="SELECT house_id,house_name FROM house WHERE rent_per_month = '50000' AND status = 'Empty'";
                $res = mysqli_query($con, $sql);
                $row = mysqli_fetch_assoc($res);


                if (mysqli_num_rows($res) > 0) {

                  do{

                    echo "<option value ='".$row["house_id"]."'>".$row["house_name"]."</option>";
                    $row = mysqli_fetch_assoc($res);
                  }while ($row);

                }else {

                  echo "<option selected disabled>No rooms available</option>";

                }


?>";
              document.getElementById("values").innerHTML = out;

            }else if (radioValue == 60000) {
                var out = "<?php  $con = mysqli_connect('localhost', 'root', '');
                  mysqli_select_db($con,'rental_house');
                  $sql="SELECT house_id,house_name FROM house WHERE rent_per_month = '60000' AND status = 'Empty'";
                  $res = mysqli_query($con, $sql);
                  $row = mysqli_fetch_assoc($res);
                  if (mysqli_num_rows($res) > 0) {

                    do{

                      echo "<option value ='".$row["house_id"]."' selected>".$row["house_name"]."</option>";
                      $row = mysqli_fetch_assoc($res);
                    }while ($row);

                  }else {

                    echo "<option selected disabled>No rooms available</option>";

                  }

                  ?>";
                document.getElementById("values").innerHTML = out;
            }else if (radioValue == 70000) {
                var out = "<?php  $con = mysqli_connect('localhost', 'root', '');
                  mysqli_select_db($con,'rental_house');
                  $sql="SELECT house_id,house_name FROM house WHERE rent_per_month = '70000' AND status = 'Empty'";
                  $res = mysqli_query($con, $sql);
                  $row = mysqli_fetch_assoc($res);

                  if (mysqli_num_rows($res) > 0) {

                    do{

                      echo "<option value ='".$row["house_id"]."'>".$row["house_name"]."</option>";
                      $row = mysqli_fetch_assoc($res);
                    }while ($row);

                  }else {

                    echo "<option selected disabled>No rooms available</option>";

                  }

  ?>";
                document.getElementById("values").innerHTML = out;
            }else {
                var out = "<?php  $con = mysqli_connect('localhost', 'root', '');
                  mysqli_select_db($con,'rental_house');
                  $sql="SELECT house_id,house_name FROM house WHERE rent_per_month = '80000' AND status = 'Empty'";
                  $res = mysqli_query($con, $sql);
                  $row = mysqli_fetch_assoc($res);

                  if (mysqli_num_rows($res) > 0) {

                    do{

                      echo "<option value ='".$row["house_id"]."'>".$row["house_name"]."</option>";
                      $row = mysqli_fetch_assoc($res);
                    }while ($row);

                  }else {

                    echo "<option selected disabled>No rooms available</option>";

                  }

  ?>";
                document.getElementById("values").innerHTML = out;
            }
        });

    });
</script>


<script>
  if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
  }
</script>



  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="js/jquery-1.12.4.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
  <script src="js/jquery.min.js"></script>

</body>

</html>
