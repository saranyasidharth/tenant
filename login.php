<?php
session_start();
include "conn.php";


function check($data){
  $data= trim($data);
  $data= htmlspecialchars($data);
  $data= stripslashes($data);
  $data = mysqli_real_escape_string($con, $data);
  return $data;
}


if(isset($_POST["login"])){
  $uname = $_POST['username'];
  $pword = md5($_POST['password']);
  //$rem = $_COOKIE['rememberme'];
  $sql = "SELECT * FROM tenant WHERE u_name = '$uname' AND p_word = '$pword'";
  $sql1 = "SELECT * FROM user WHERE u_name = '$uname' AND pword = '$pword'";
  $query = mysqli_query($con, $sql);
  $query1 = mysqli_query($con, $sql1);
  $row = mysqli_fetch_assoc($query);
  $row1 = mysqli_fetch_assoc($query1);
  do {
    $role = $row1['role'];
    $row1 = mysqli_fetch_assoc($query1);
  } while ($row1);

  do{
    $fname = $row['fname'];

    $lname = $row['lname'];

    $stat = $row['status'];

    $id = $row['tenant_id'];
    $sql2 = "SELECT * FROM contract WHERE tenant_id = '$id'";
    $query2 = mysqli_query($con, $sql2);
    $row1 = mysqli_fetch_assoc($query2);

    do{
      $end_date = $row1['end_day'];
      $h_id = $row1['house_id'];
      $row1 = mysqli_fetch_assoc($query2);
    }while ($row1);
    $row = mysqli_fetch_assoc($query);

  }while ($row);



  if ((mysqli_num_rows($query) == 1) || (mysqli_num_rows($query1) == 1)) {



    if($role == "Administrator"){
      $_SESSION['username'] = $uname;
      echo "<script type='text/javascript'>alert('Welcome $uname!');</script>";
      echo '<style>body{display:none;}</style>';
      echo '<script>window.location.href = "admin_home.php";</script>';

    }
    elseif ($role == "Manager") {
      $_SESSION['username'] = $uname;
      echo "<script type='text/javascript'>alert('Welcome $uname!');</script>";
      echo '<style>body{display:none;}</style>';
      echo '<script>window.location.href = "manager_home.php";</script>';
    }
    else {

      if ($stat == 0) {
        $_SESSION['username'] = $uname;
        echo "<script type='text/javascript'>alert('Welcome $fname $lname!');</script>";
        echo '<style>body{display:none;}</style>';
        echo '<script>window.location.href = "pay.php";</script>';
      }elseif ($stat == 1) {
        $_SESSION['username'] = $uname;
        echo "<script type='text/javascript'>alert('Welcome $fname $lname!');</script>";
        echo '<style>body{display:none;}</style>';
        echo '<script>window.location.href = "home.php";</script>';
      }elseif ($stat == 2) {
        $_SESSION['username'] = $uname;
        echo "<script type='text/javascript'>alert('Welcome $fname $lname!');</script>";
        echo '<style>body{display:none;}</style>';
        echo '<script>window.location.href = "waiting.php";</script>';
      }elseif((date('Y-m-d') > $end_date) && $stat == 1){
        $sql3 = "UPDATE tenant SET status = '3' WHERE tenant_id = '$id'";
        mysqli_query($con, $sql3);
        $sql5 = "UPDATE contract SET status ='Inactive' WHERE status = 'Active' AND tenant_id = '$id'";
        mysqli_query($con, $sql5);
        $sql5 = "UPDATE house SET status ='Empty' WHERE house_id = '$h_id'";
        mysqli_query($con, $sql5);
        $_SESSION['username'] = $uname;
        echo "<script type='text/javascript'>alert('Welcome $fname $lname! Your contract has expired. To access the system please renew the contract.');</script>";
        echo '<style>body{display:none; color:red;}</style>';
        echo '<script>window.location.href = "renew_contract.php";</script>';

      }elseif ($stat == 3) {
        $_SESSION['username'] = $uname;
        echo "<script type='text/javascript'>alert('Welcome $fname $lname! Your contract has expired. To access the system please renew the contract.');</script>";
        echo '<style>body{display:none;}</style>';
        echo '<script>window.location.href = "renew_contract.php";</script>';
      }
    }
    mysqli_close($con);
    $uname = "";


  }else {
    echo "<script style = 'color:red;'> alert('Incorrect Username or Password!!!')</script>";
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

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link href="css/rent.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <style>
      
      .loginbox{  width: 320px;
          height: 450px;
          background-color:rgba(255,255,255,.05);
          color: black;
          top:15%;
          left:69%;
          position:absolute;
          padding: 70px 30px;
          /* opacity:.6; */
               }
      .avatar{  width: 100px;
          height: 100px;
          border-radius:40%;
          position:absolute;
          top:-14%;
          left:calc(50% - 50px);
             }
      h1{    margin:0;
          padding: 0 0 20px;
          text-align: center;
          font-size: 30px;
          font-family:AR JULIAN;
          color:#39A2DB;
        }    
      .loginbox p{  margin:0;
          padding: 0;
          font-weight:bold;
                 }
      .loginbox input{width: 100%;
          margin-bottom:20px;
                     }
      .loginbox input[type="text"], input[type="password"]{
          border: none;
          border-bottom: 1px solid #000;
          background: transparent;
          outline:none;
          height:40px;
          width:18pc;
          color:#fff;
          font-size:16px;
              }
      .loginbox input[type="submit"]{
          border: none;
          outline:none;
          height:40px;
          background:#39A2DB;
          color: #fff;
          font-size:18px;
          border-radius:20px;
              }
      .loginbox input[type="submit"]:hover
      {    cursor:pointer;
          background:#115980;
          color:#000;
      }
      .loginbox a{   
          text-decoration:none;
          font-size:12px;
          line-height:20px;
          color:black;
      }
      .loginbox a:hover
      {  
        color:#ff5107;
      }
      .active{
        color:#fff;
        background:#e02626;
        border-radius:4px;
      }
       </style>
  </head>
 
</head>

<body id="page-top" style= "background-color:#e8f0f2;background-image: url('logintemplate.png');background-repeat: no-repeat;

background-size: 90%;">
<header class="header mb-5">

<nav class="navbar navbar-expand-lg fixed-top "  style="background-color: #39A2DB; height:60px;" id="mainNav">
  <div class="container">
    <a class="navbar-brand " href="#page-top">
    <img src="logo.png" height="10%" width="18%"  style="position:relative; top:8px;">

    </a>
    <!-- <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      Menu
      <i class="fa fa-bars"></i>
    </button> -->
    <div class="" id="navbarResponsive" style="position:absolute;right:20px;">
      <ul class="navbar-nav  ml-auto">
       
      <li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="index.php">Home</a>
        </li><li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="#about">About us</a>
        </li><li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="#sell">Sell</a>
        </li><li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="#rent">Rent</a>
        </li>
        
       
        <?php 
          if(empty($_SESSION['username'])){
            echo '<li class="nav-item">';
              echo '<a class="nav-link" href="login.php">Sign in</a>';
            echo '</li>';
          }else{
            echo '<li class="nav-item">';
             echo '<a class="nav-link" href="signup.php">Register</a>';
           echo '</li>';
          }
        ?>
        


      </ul>
    </div>
  </div>
</nav>
</header>
  <div class="container">

    <!-- Outer Row-->
    <div class="  loginbox row justify-content-center" >

      <div class="form">
        <div class="login">
          <div class="login-header">
                  <form class="" action="<?php echo $_SERVER['PHP_SELF']; ?>" method = "POST">
                   <h1>LOGIN</h1>
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" name="username" aria-describedby="emailHelp" value="<?php echo @$uname; ?>" placeholder="Username">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" name="password" placeholder="Password">
                    </div>

                    <input class="btn " type="submit" name="login" value="Login">
                  </form>
                    <hr>
                  <div class="text-center">
                    <a class="small" href="forgot-password.php">Forgot Password?</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="signup.php">Create an Account!</a>
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
