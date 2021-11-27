<?php
include "conn.php";


function check($data){
  $data= trim($data);
  $data= htmlspecialchars($data);
  $data= stripslashes($data);
  return $data;
}


if(isset($_POST["reset"])){
  $uname = check($_POST['username']);
  $pword = check($_POST['pword']);
  $cpword = check($_POST['cpword']);
  $query = "SELECT * FROM tenant WHERE u_name = '$uname'";
  $res = mysqli_query($con,$query);
  if(mysqli_num_rows($res) == 1){
    if ($pword != $cpword) {
      echo "<script type='text/javascript'>alert('Passwords don't match.');</script>";
    }else {
      if((strlen($pword) < 8) || (strlen($cpword) < 8)){
        echo "<script> alert('Password is too short.');</script>";
      }elseif(!($pword == '') || !($cpword == '')){
        $pword = md5($pword);
        $sql = "UPDATE tenant SET p_word ='$pword' WHERE u_name = '$uname'";
        if (mysqli_query($con, $sql)) {
          echo "<script> alert('Password has been changed successfully. New password will be effective upon new login.');</script>";
          echo '<style>body{display:none;}</style>';
          echo '<script>window.location.href = "u_change.php";</script>';
          mysqli_close($con);
          exit;
        }

      }
    }
  }else{
    echo "<script> alert('Username does not exist.');</script>";
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

<body style="background: linear-gradient(#4e73df, white);">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block"><img src="house.jpg" alt="Rental House" width="500" height="560" style="opacity:0.6;"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4"><b><b>Rental House Management System</b></b><br/><br/>Reset Password</h1>
                  </div>
                  <form class="user" action="<?php echo $_SERVER['PHP_SELF']; ?>" method = "POST">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" name="username" aria-describedby="emailHelp" value="<?php echo @$uname; ?>" placeholder="Username" required>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" name="pword" placeholder="Password" required>
                    </div>

                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" name="cpword" placeholder=" Confirm Password" required>
                    </div>

                    <input class="btn btn-primary btn-user btn-block" type="submit" name="reset" value="Reset Password">
                    <hr>
                  <div class="text-center">
                    <a class="small" href="login.php">Login</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="register.php">Create an Account!</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
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
