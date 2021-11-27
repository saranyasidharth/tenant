<?php
include "conn.php";

function check($data){
  $data= trim($data);
  $data= htmlspecialchars($data);
  $data= stripslashes($data);
  return $data;
}

if(isset($_POST["submit"])){

  $fname = check($_POST['FirstName']);
  $lname = check($_POST['LastName']);
  $prog = @check($_POST['programme']);
  $reg = @check($_POST['regno']);
  $occ = @check($_POST['occupation']);
  $pno1 = check($_POST['pno1']);
  $pno2 = check($_POST['pno2']);
  $postal = check($_POST['postal']);
  $city = check($_POST['city']);
  $region = check($_POST['region']);
  $uname = check($_POST['uname']);
  $pword = check($_POST['password']);
  $rpword = check($_POST['repeatPassword']);
  $price = $_POST['price'];
  $dur = $_POST['duration'];
  $dur1 = $dur - 1;
  $term = (int)$_POST['term'];
  $contract = $_POST['contract'];
  $house = $_POST['house'];
  $price = (int)$_POST['price'];
  $total_rent = $dur * $price;
  $rent_per_term =$total_rent / $term;
  $cpno1 = check($_POST['cpno1']);
  $cpno2 = check($_POST['cpno2']);
  $cpno3 = check($_POST['cpno3']);
  $cpno4 = check($_POST['cpno4']);
  $cfname1 = check($_POST['fname1']);
  $cfname2 = check($_POST['fname2']);
  $clname1 = check($_POST['lname1']);
  $clname2 = check($_POST['lname2']);
  $c_occu1 = check($_POST['occu1']);
  $c_occu2 = check($_POST['occu2']);
  $nature1 = check($_POST['nature1']);
  $nature2 = check($_POST['nature2']);
  $city1 = check($_POST['city1']);
  $city2 = check($_POST['city2']);
  $region1 = check($_POST['region1']);
  $region2 = check($_POST['region2']);
  $cemail1 = filter_var($_POST['email1'], FILTER_SANITIZE_EMAIL);
  $cemail2 = filter_var($_POST['email2'], FILTER_SANITIZE_EMAIL);
  $p_address1 = check($_POST['p_address1']);
  $p_address2 = check($_POST['p_address2']);
  if(date('d')<27){
    $end_date = date('Y-m-t', strtotime('+'.$dur1.' month'));
  }else{
    $end_date = date('Y-m-t', strtotime('+'.$dur1.' month'));
  }
  if((date('d')<27)){
    $start_day = date('Y-m-01');
  }else{
    $start_day = date('Y-m-01', strtotime('+1 month'));
  }
  $date_reg = date('Y-m-d');
  $date_reg1 = date('Y-m-d H:i:s');
  $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
  $stat = "Active";
  $status = 0;


  if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    if(!ctype_alpha($fname)){
      $fnameErr = "The name should only contain letters!";
      echo "<script> alert('$fnameErr');</script>";
    }
    elseif ((strlen($fname)<3) || (strlen($fname)>10)) {
      $fnameErr = "The name is either too short or too long";
      echo "<script> alert('$fnameErr');</script>";
    }
    else {
      if(!ctype_alpha($lname)){
        $lnameErr = "The name should only contain letters!";
        echo "<script> alert('$lnameErr');</script>";
      }
      elseif ((strlen($lname)<3) || (strlen($lname)>10)) {
        $lnameErr = "The name is either too short or too long";
        echo "<script> alert('$lnameErr');</script>";
      }
      else {
        if((ctype_digit($occ)) && !($occ == "")){
          $occErr = "Your ocupation should only contain letters!";
          echo "<script> alert('$occErr');</script>";
        }
        else {
          if ((!is_numeric($pno1)) || (!is_numeric($pno2))) {
            $pno1Err = "The phone number should not contain letters";
            echo "<script> alert('$pno1Err');</script>";
          }
          elseif ((strlen($pno1) > 12)|| (strlen($pno2) > 12)) {
            $pno1Err = "The phone number is too long";
            echo "<script> alert('$pno1Err');</script>";
          }
          elseif ((strlen($pno1) < 12)|| (strlen($pno2) < 12)) {
            $pno1Err = "The phone number is too short";
            echo "<script> alert('$pno1Err');</script>";
          }
          else {
            if ((!is_numeric($cpno1)) || (!is_numeric($cpno2))) {
              $cpno1Err = "The phone number should not contain letters";
              echo "<script> alert('$cpno1Err');</script>";
            }
            elseif ((strlen($cpno1) > 12)|| (strlen($cpno2) > 12)) {
              $cpno1Err = "The phone number is too long";
              echo "<script> alert('$cpno1Err');</script>";
            }
            elseif ((strlen($cpno1) < 12)|| (strlen($cpno2) < 12)) {
              $cpno1Err = "The phone number is too short";
              echo "<script> alert('$cpno1Err');</script>";
            }
            else {
              if (((!is_numeric($cpno3)) || (!is_numeric($cpno4))) && (!($cpno4 == "") || !($cpno3 == ""))) {
                $cpno3Err = "The phone number should not contain letters";
                echo "<script> alert('$cpno3Err');</script>";
              }
              elseif (((strlen($cpno3) > 12)|| (strlen($cpno4) > 12)) && (!($cpno4 == "") || !($cpno3 == ""))) {
                $cpno3Err = "The phone number is too long";
                echo "<script> alert('$cpno3Err');</script>";
              }
              elseif (((strlen($cpno3) < 12)|| (strlen($cpno4) < 12)) && (!($cpno4 == "") || !($cpno3 == ""))) {
                $cpno3Err = "The phone number is too short";
                echo "<script> alert('$cpno3Err');</script>";
              }
              else {
                if((!ctype_alpha($cfname1)) || (!ctype_alpha($cfname2)) || (!ctype_alpha($clname1)) || (!ctype_alpha($clname2))){
                  $cfname1Err = "The name should only contain letters!";
                  echo "<script> alert('$cfname1Err');</script>";
                }
                
                else {
                  if((ctype_digit($c_occu1)) || (ctype_digit($c_occu2))){
                    $c_occ1Err = "The occupation should only contain letters!";
                    echo "<script> alert('$c_occ1Err');</script>";
                  }
                  else {
                    if((ctype_digit($nature1)) || (ctype_digit($nature2))){
                      $nature1Err = "Nature of the relationship should only contain letters!";
                      echo "<script> alert('$nature1Err');</script>";
                    }
                    else {
                      if (((!filter_var($cemail1, FILTER_VALIDATE_EMAIL)) && !($cemail1 == "")) || ((!filter_var($cemail2, FILTER_VALIDATE_EMAIL)) && !($cemail2 == ""))) {
                        $cemail1Err = "Invalid Email";
                        echo "<script> alert('$cemail1Err');</script>";
                      }
                      else {

                        $sql4 = "SELECT * FROM tenant WHERE u_name = '$uname'";
                        $query = mysqli_query($con, $sql4);
                        if(mysqli_num_rows($query) > 0){
                          echo "<script> alert('Username exists!!');</script>";
                        }
                        else {
                          if ((strlen($pword) < 8) || (strlen($rpword) < 8)) {
                            echo "<script> alert('Password is too short');</script>";
                          }
                          elseif($pword == $rpword){
                            if ($dur == 3) {
                              if (!($term == 1)) {
                                echo "<script> alert('3 months cannot have more than 1 term.');</script>";
                              }
                              else {
                                $pword = md5($pword);
                                $sql= "INSERT INTO tenant VALUES (' ','$fname','$lname','$prog','$reg','$occ','$pno1','$pno2','$email','$postal','$city','$region','$uname','$pword', '$date_reg', '$status')";

                                mysqli_query($con, $sql);

                                $last_id=mysqli_insert_id($con);

                                $sql2= "INSERT INTO tenant_contacts VALUES (' ','$last_id','$cfname1','$clname1','$c_occu1','$nature1','$cpno1','$cpno3','$cemail1','$p_address1','$city1','$region1','$cfname2','$clname2','$c_occu2','$nature2','$cpno2','$cpno4', '$cemail2', '$p_address2', '$city2', '$region2')";

                                mysqli_query($con, $sql2);

                                $sql1 = "INSERT INTO contract VALUES (' ','$last_id', '$house','$dur','$total_rent','$term','$rent_per_term','$start_day', '$end_date', '$date_reg1', '$stat')";

                                mysqli_query($con, $sql1);

                                $sql3 = "UPDATE house SET status= '$contract' WHERE house_id = '$house'";
                                mysqli_query($con, $sql3);
                                mysqli_close($con);
                                echo "<script type='text/javascript'>alert('Welcome $fname $lname! Your contract begins on $start_day and ends on $end_date.');</script>";
                                echo '<style>body{display:none;}</style>';
                                echo '<script>window.location.href = "login.php";</script>';

                              }
                            }elseif($dur == 6){
                                if ($term == 4) {
                                  echo "<script> alert('6 months cannot have more than 2 term.');</script>";
                                }else {
                                  $pword = md5($pword);
                                  $sql= "INSERT INTO tenant VALUES (' ','$fname','$lname','$prog','$reg','$occ','$pno1','$pno2','$email','$postal','$city','$region','$uname','$pword', '$date_reg', '$status')";

                                  mysqli_query($con, $sql);

                                  $last_id=mysqli_insert_id($con);

                                  $sql2= "INSERT INTO tenant_contacts VALUES (' ','$last_id','$cfname1','$clname1','$c_occu1','$nature1','$cpno1','$cpno3','$cemail1','$p_address1','$city1','$region1','$cfname2','$clname2','$c_occu2','$nature2','$cpno2','$cpno4', '$cemail2', '$p_address2', '$city2', '$region2')";

                                  mysqli_query($con, $sql2);

                                  $sql1 = "INSERT INTO contract VALUES (' ','$last_id', '$house','$dur','$total_rent','$term','$rent_per_term','$start_day', '$end_date', '$date_reg1', '$stat')";

                                  mysqli_query($con, $sql1);

                                  $sql3 = "UPDATE house SET status= '$contract' WHERE house_id = '$house'";
                                  mysqli_query($con, $sql3);
                                  mysqli_close($con);
                                  echo "<script type='text/javascript'>alert('Welcome $fname $lname! Your contract begins on $start_day and ends on $end_date.');</script>";
                                  echo '<style>body{display:none;}</style>';
                                  echo '<script>window.location.href = "login.php";</script>';

                                }

                              }else {
                                $pword = md5($pword);
                                $sql= "INSERT INTO tenant VALUES (' ','$fname','$lname','$prog','$reg','$occ','$pno1','$pno2','$email','$postal','$city','$region','$uname','$pword', '$date_reg', '$status')";

                                mysqli_query($con, $sql);

                                $last_id=mysqli_insert_id($con);

                                $sql2= "INSERT INTO tenant_contacts VALUES (' ','$last_id','$cfname1','$clname1','$c_occu1','$nature1','$cpno1','$cpno3','$cemail1','$p_address1','$city1','$region1','$cfname2','$clname2','$c_occu2','$nature2','$cpno2','$cpno4', '$cemail2', '$p_address2', '$city2', '$region2')";

                                mysqli_query($con, $sql2);

                                $sql1 = "INSERT INTO contract VALUES (' ','$last_id', '$house','$dur','$total_rent','$term','$rent_per_term','$start_day', '$end_date', '$date_reg1', '$stat')";

                                mysqli_query($con, $sql1);

                                $sql3 = "UPDATE house SET status= '$contract' WHERE house_id = '$house'";
                                mysqli_query($con, $sql3);
                                mysqli_close($con);
                                echo "<script type='text/javascript'>alert('Welcome $fname $lname! Your contract begins on $start_day and ends on $end_date.');</script>";
                                echo '<style>body{display:none;}</style>';
                                echo '<script>window.location.href = "login.php";</script>';
                              }

                          }
                            else {
                              echo "<script> alert('Password does not match');</script>";
                            }
                        }
                      }
                    }
                  }
                }
              }
            }
          }
        }
      }
    }
  }
  else {
    $emailErr = "Invalid Email";
    echo "<script> alert('$emailErr');</script>";
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
      /* .loginbox input{width: 100%;
          margin-bottom:20px;
                     } */
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
          width:18pc;
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

<body id="page-top" style= "background-color:#e8f0f2;background-image: url('signuptemplate.png');background-repeat: no-repeat;

background-size:contain ;">
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
             echo '<a class="nav-link" href="registers.php">Register</a>';
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
          <div class="login-header" style="position:absolute;top:2pc;right:3cm;">
                  <form class="" action="<?php echo $_SERVER['PHP_SELF']; ?>" method = "POST">
                   <h1>Sign up</h1><div class="form-group" style="color:#697070;"><b>I am a &nbsp;&nbsp; </b>
                   <input type="radio" class="" name="radio" value="renter"><B><label for="radio">&nbsp;&nbsp; RENTER </label></B>
                    <input type="radio" class="" name="radio" value="rentee" ><B><label for="radio"> &nbsp;&nbsp;RENTEE </label></B>
        </div>   
        <div class="form-group">
                      <input type="text" class="form-control form-control-user" name="name"  value="<?php echo @$fname; ?>" placeholder="Name">
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" name="username" aria-describedby="emailHelp" value="<?php echo @$uname; ?>" placeholder="Username">
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" name="email1" aria-describedby="emailHelp" value="<?php echo @$uname; ?>" placeholder="Email">
                    </div>  <div class="form-group">
                      <input type="text" class="form-control form-control-user" name="pno1" aria-describedby="emailHelp" value="<?php echo @$uname; ?>" placeholder="Phone Number">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" name="password" placeholder="Password">
                    </div>
                    <!-- <div class="form-group"><B>I am a</B>  -->
                   
        <!-- </div> -->
                    <input class="btn " type="submit" name="signup" value="signup">
                  </form>
                    <hr>
                    
                  <div class="text-center">
                    <a class="small" href="forgot-password.php">Forgot Password?</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="registers.php">Create an Account!</a>
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
