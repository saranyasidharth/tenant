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
  // $cpno1 = check($_POST['cpno1']);
  // $cpno2 = check($_POST['cpno2']);
  // $cpno3 = check($_POST['cpno3']);
  // $cpno4 = check($_POST['cpno4']);
  // $cfname1 = check($_POST['fname1']);
  // $cfname2 = check($_POST['fname2']);
  // $clname1 = check($_POST['lname1']);
  // $clname2 = check($_POST['lname2']);
  // $c_occu1 = check($_POST['occu1']);
  // $c_occu2 = check($_POST['occu2']);
  // $nature1 = check($_POST['nature1']);
  // $nature2 = check($_POST['nature2']);
  // $city1 = check($_POST['city1']);
  // $city2 = check($_POST['city2']);
  // $region1 = check($_POST['region1']);
  // $region2 = check($_POST['region2']);
  // $cemail1 = filter_var($_POST['email1'], FILTER_SANITIZE_EMAIL);
  // $cemail2 = filter_var($_POST['email2'], FILTER_SANITIZE_EMAIL);
  // $p_address1 = check($_POST['p_address1']);
  // $p_address2 = check($_POST['p_address2']);
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
          elseif ((strlen($pno1) > 10)) {
            $pno1Err = "The phone number is too long";
            echo "<script> alert('$pno1Err');</script>";
          }
          elseif ((strlen($pno1) < 10)) {
            $pno1Err = "The phone number is too short";
            echo "<script> alert('$pno1Err');</script>";
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
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="wnameth=device-wnameth, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>TENANT</title>
    <link rel="icon" href="icon1.jpg">
  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link href="css/rent.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <style>
  /* .submit-btn:hover{
 background-color:#125980;

  } */
  .loginbox input[type="submit"]{
          border: none;
          outline:none;
          height:40px;
          background:#39A2DB;
          color: #fff;
          /* font-size:18px; */
          border-radius:20px;
              }
      .loginbox input[type="submit"]:hover
      {    cursor:pointer;
          background:#115980;
          color:#353738;
      }
  </style>
 
</head>
<body id="page-top" style= "background-color:#e8f0f2;background-repeat: no-repeat;

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
          <a class="nav-link js-scroll-trigger" href="about.php">About us</a>
        </li><li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="login.php">Sell</a>
        </li><li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="login.php">Rent</a>
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

    <div class="">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">

          <div class="col-lg-12">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4"><b><b>TENANT REGISTRATION</b></b></h1>
              </div>
              <!-- <p><span style = "color:#4e73df;"><b><b>PERSONAL PARTICULARS</b></b></span></p> -->
              <form class="user" action="<?php echo $_SERVER['PHP_SELF']; ?>" method = "POST">
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" name="FirstName" value="<?php echo @$fname; ?>" placeholder="First Name" required>
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" name="LastName" value="<?php echo @$lname; ?>" placeholder="Last Name" required>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    Are you a student?&nbsp&nbsp&nbsp
                    <input type="radio" name="radio"  value="Enable" required>Yes
                  </div>
                  <div class="col-sm-6">
                    <input type="radio" name="radio"  value="Disable">No
                  </div>

                </div>
               
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" name="occupation" value="<?php echo @$occ; ?>" placeholder="Occupation" disabled>
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" name="pno1" value="<?php echo @$pno1; ?>" placeholder="Phone Number" required>
                  </div>
                </div>
                <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                  <input type="text" class="form-control form-control-user" name="pno2" value="<?php echo @$pno2; ?>" placeholder="Alternative Number" >
                </div>
                <div class="col-sm-6">
                  <input type="email" class="form-control form-control-user" name="email" value="<?php echo @$email; ?>" placeholder="Email Address" required>
                </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" name="postal" value="<?php echo @$postal; ?>" placeholder="Postal Address" required>
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" name="city" value="<?php echo @$city; ?>" placeholder="City" required>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" name="region" value="<?php echo @$region; ?>" placeholder="Region" required>
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" name="uname" value="<?php echo @$uname; ?>" placeholder="Username" required>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password" class="form-control form-control-user" name="password" placeholder="Password" required>
                  </div>
                  <div class="col-sm-6">
                    <input type="password" class="form-control form-control-user" name="repeatPassword" placeholder="Repeat Password" required>
                  </div>
                </div>
                <hr>
                <p><span style = "color:#4e73df;"><b><b>CONTRACT</b></b></span></p>
                <div class="form-group row" align = "center">
                  <center>Please click the price of the house you want to rent:<br/></center>
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="radio" name="price" value = "10000" required>Rs. 10,000&nbsp&nbsp&nbsp
                    <input type="radio" name="price" value = "15000">Rs. 15,000<br/>&nbsp
                    <input type="radio" name="price" value = "20000">Rs. 20,000&nbsp&nbsp&nbsp
                    <input type="radio" name="price" value = "30000">Rs. 30,000&nbsp&nbsp
                  </div>
                </div>
                <div class="form-group row">
                  <p id = "values">
                  </p>
                </div>

                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    Contract Duration:<br/>
                    <select class="custom-select" name="duration" id="durations" style="width:300px;">
                      <option  value = "3">3 months</option>
                      <option value = "6">6 months</option>
                      <option value = "12">12 months</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    Payment Terms:<br/>
                    <select class="custom-select" name="term" id="terms" style="width:300px;">
                    <option value = "1" id="1">1 term</option>
                    <option value = "2" id="2">2 terms</option>
                    <option value = "4" id="4">4 terms</option>
                    </select>
                  </div>
                </div>
                <hr>
                <p>Please read the contract <span style = "color:red;">CAREFULLY</span> and check "I agree" if you agree with the TERMS AND CONDITIONS stated.</p><br/>
                <div class="form-group">
                  <iframe src="contract.pdf" width="1000px" height="400px" style="border: none;"></iframe>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="checkbox" name="contract" value = "Occupied" required>I agree&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                  </div>
                </div>
                <hr>
                <!-- <p><span style = "color:#4e73df;"><b><b>CONTACTS' INFORMATION</b></b></span></p>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" name="fname1" value="<?php echo @$cfname1; ?>" placeholder="First Name" required>
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" name="fname2" value="<?php echo @$cfname2; ?>"placeholder="First Name" required>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" name="lname1" value="<?php echo @$clname1; ?>"placeholder="Last Name" required>
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" name="lname2" value="<?php echo @$clname2; ?>" placeholder="Last Name" required>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" name="occu1" value="<?php echo @$c_occu1; ?>"placeholder="Occupation" required>
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" name="occu2" value="<?php echo @$c_occu1; ?>" placeholder="Occupation" required>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" name="cpno1" value="<?php echo @$cpno1; ?>" placeholder="Phone Number 1 e.g; 255717******" required>
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" name="cpno2" value="<?php echo @$cpno2; ?>" placeholder="Phone Number 1 e.g; 255717******" required>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" name="cpno3" value="<?php echo @$cpno3; ?>" placeholder="Phone Number 2 e.g; 255717******">
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" name="cpno4" value="<?php echo @$cpno4; ?>" placeholder="Phone Number 2 e.g; 255717******">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" name="nature1" value="<?php echo @$nature1; ?>" placeholder="Nature of the Relationship" required>
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" name="nature2" value="<?php echo @$nature2; ?>" placeholder="Nature of the Relationship" required>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" name="city1" value="<?php echo @$city1; ?>" placeholder="City" required>
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" name="city2" value="<?php echo @$city2; ?>" placeholder="City" required>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" name="region1" value="<?php echo @$region1; ?>" placeholder="Region" required>
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" name="region2" value="<?php echo @$region2; ?>" placeholder="Region" required>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="email" class="form-control form-control-user" name="email1" value="<?php echo @$cemail1; ?>" placeholder="Email Address">
                  </div>
                  <div class="col-sm-6">
                    <input type="email" class="form-control form-control-user" name="email2" value="<?php echo @$cemail2; ?>" placeholder="Email Address">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" name="p_address1" value="<?php echo @$p_address1; ?>" placeholder="Postal Address" required>
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" name="p_address2" value="<?php echo @$p_address2; ?>" placeholder="Postal Address" required>
                  </div>
                </div>
                <hr> -->
              <center>
<div class="loginbox">
                <input class="btn" type="submit" name="submit" value="Register Account" style="background-color: #39A2DB">
</div>
              </center>

              </form>

              <div class="text-center">
                <a class="small" href="forgot-password.php " style="color:blue;">Forgot Password?</a>
              </div>
              <div class="text-center">
                <a class="small" href="login.php" style="color:blue;">Already have an account? Login!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
  <script type="text/javascript">
    $('input[name = "radio"]').on('change', function()
    {
      $('input[name = "programme"]').attr('disabled', this.value != "Enable");
      $('input[name = "regno"]').attr('disabled', this.value != "Enable");
      $('input[name = "occupation"]').attr('disabled', this.value != "Disable");
      $('input[name = "programme"]').attr('required', this.value == "Enable");
      $('input[name = "regno"]').attr('required', this.value == "Enable");
      $('input[name = "occupation"]').attr('required', this.value == "Disable");
    });


  </script>
  <script type="text/javascript">
    $("#durations").on('change',function(){
      $('#terms option[value = 2]').attr('disabled',this.value == 3);
      $('#terms option[value = 4]').attr('disabled',this.value == 3);
      $('#terms option[value = 4]').attr('disabled',this.value == 6);

     });


  </script>
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
            if(radioValue ==10000){
              var out = "<?php  $con = mysqli_connect('localhost', 'root', '');
                mysqli_select_db($con,'rental_house');
                $sql="SELECT house_id,house_name FROM house WHERE rent_per_month = '10000' AND status = 'Empty'";
                $res = mysqli_query($con, $sql);
                $row = mysqli_fetch_assoc($res);
                echo "<div class='col-sm-6 mb-3 mb-sm-0'>";
                echo "<select class='custom-select' style='width:200px;' name = 'house'>";
                do{
                  echo "<option value =' ".$row["house_id"]."'>".$row["house_name"]."</option>";
                  $row = mysqli_fetch_assoc($res);
                }while ($row);
                echo "</select>";
                echo "</div>";
?>";
              document.getElementById("values").innerHTML = out;

            }else if (radioValue == 15000) {
                var out = "<?php  $con = mysqli_connect('localhost', 'root', '');
                  mysqli_select_db($con,'rental_house');
                  $sql="SELECT house_id,house_name FROM house WHERE rent_per_month = '15000' AND status = 'Empty'";
                  $res = mysqli_query($con, $sql);
                  $row = mysqli_fetch_assoc($res);
                  echo "<div class='col-sm-6 mb-3 mb-sm-0'>";
                  echo "<select class='custom-select' style='width:200px;' name = 'house'>";
                  do{
                    echo "<option value =' ".$row["house_id"]."'>".$row["house_name"]."</option>";
                    $row = mysqli_fetch_assoc($res);
                  }while ($row);
                  echo "</select>";
                  echo "</div>";
  ?>";
                document.getElementById("values").innerHTML = out;
            }else if (radioValue == 20000) {
                var out = "<?php  $con = mysqli_connect('localhost', 'root', '');
                  mysqli_select_db($con,'rental_house');
                  $sql="SELECT house_id,house_name FROM house WHERE rent_per_month = '20000' AND status = 'Empty'";
                  $res = mysqli_query($con, $sql);
                  $row = mysqli_fetch_assoc($res);
                  echo "<div class='col-sm-6 mb-3 mb-sm-0'>";
                  echo "<select class='custom-select' style='width:200px;' name = 'house'>";
                  do{
                    echo "<option value =' ".$row["house_id"]."'>".$row["house_name"]."</option>";
                    $row = mysqli_fetch_assoc($res);
                  }while ($row);
                  echo "</select>";
                  echo "</div>";
  ?>";
                document.getElementById("values").innerHTML = out;
            }else {
                var out = "<?php  $con = mysqli_connect('localhost', 'root', '');
                  mysqli_select_db($con,'rental_house');
                  $sql="SELECT house_id,house_name FROM house WHERE rent_per_month = '30000' AND status = 'Empty'";
                  $res = mysqli_query($con, $sql);
                  $row = mysqli_fetch_assoc($res);
                  echo "<div class='col-sm-6 mb-3 mb-sm-0'>";
                  echo "<select class='custom-select' style='width:200px;' name = 'house'>";
                  do{
                    echo "<option value =' ".$row["house_id"]."'>".$row["house_name"]."</option>";
                    $row = mysqli_fetch_assoc($res);
                  }while ($row);
                  echo "</select>";
                  echo "</div>";
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


</body>

</html>
