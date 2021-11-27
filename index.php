<?php
include 'conn.php';
 ?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>TENANT</title>
    <link rel="icon" href="icon1.jpg">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="vendor1/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="vendor1/font-awesome/css/font-awesome.min.css">
    <!-- Google fonts - Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700">
    <!-- owl carousel-->
    <link rel="stylesheet" href="vendor1/owl.carousel/assets/owl.carousel.css">
    <link rel="stylesheet" href="vendor1/owl.carousel/assets/owl.theme.default.css">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="css1/style.default.css" id="theme-stylesheet">
    <!-- <link rel="stylesheet" href="css1/custom.css"> -->
    <link href="css/rent.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet"> 

   </head>
  <body id="page-top" style= "background-image: url('homepage.jpg');background-repeat: no-repeat;

  background-size: 100%;">
    <header class="header mb-5">

    <nav class="navbar navbar-expand-lg fixed-top "  style="background-color: #39A2DB; height:60px;" id="mainNav">
      <div class="container">
        <a class="navbar-brand " href="#page-top">
          <img src="logo.png" height="10%" width="15%"  style="position:relative; top:8px;">
        </a>
      
        <div class="" id="navbarResponsive" style="position:absolute;right:20px;">
          <ul class="navbar-nav  ">
           
          <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#pagetop">Home</a>
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
                 echo '<a class="nav-link" href="./auth/dashboard.php">Home</a>';
               echo '</li>';
              }
            ?>
            


          </ul>
        </div>
      </div>
    </nav>

    <section id="search top-left" class="">
    <!-- <img src="homepage.jpg" height="100%" width="100%">     -->
      <div class="container">
        <div class="row">
          <div class="col-lg-12 ">
          <h2 class="section-heading ">Secure and safe way to rent<br> your home</h2>
            <!-- <h3 class="section-subheading text-muted">Search rooms or homes for hire.</h3> -->
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <form action="" method="POST" class="" novalidate>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <input class="form-control" id="keywords" name="keywords" type="text" placeholder="Search for locality, home, landmark" required data-validation-required-message="Please enter keywords">
                    <p class="help-block text-danger"></p>
                  </div>
                </div><br>
                <br>
                <br>
                <br>
<br>

                <div class="col-md-2" style=";position:absolute;"><br>
                <br><br>


                  <div class="form-group">
                    <button id="" class="btn btn-success btn-md text-uppercase"  name="search" value="search" type="submit">Search</button>
                  </div>
                </div>
              </div>
            </form></header>
    <div id="all">
      <div id="content">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div id="main-slider" class="owl-carousel owl-theme">
                <!-- <div class="item"><img src="" alt="" class="img-fluid"></div> -->
              </div>
              <!-- /#main-slider-->
            </div>
          </div>
        </div>
        <!--
        *** ADVANTAGES HOMEPAGE ***
        _________________________________________________________

        <!--
        *** HOT PRODUCT SLIDESHOW ***
        _________________________________________________________
        -->
        <div id="hot">
          <div class="box py-4">
            <div class="container">
              <div class="row">
                <div class="col-md-12">
                  <h2 class="mb-0">Houses</h2>
                </div>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="product-slider owl-carousel owl-theme">
              <div class="item">
                <div class="product">
                  <div class="flip-container">
                    <div class="flipper">
                      <div class="front"><a><img src="rent_1.jpg" alt="" class="img-fluid"></a></div>
                      <div class="back"><a><img src="rent_1.jpg" alt="" class="img-fluid"></a></div>
                    </div>
                  </div><a class="invisible"><img src="rent_1.jpg" alt="" class="img-fluid"></a>
                  <div class="text">
                    <h3><a>List of Houses</a></h3>
                    <p class="price">
                      To Rent
                    </p>
                  </div>
                  <!-- /.text-->

                  <!-- /.ribbon-->

                  <!-- /.ribbon-->
                </div>
                <!-- /.product-->
              </div>
              <div class="item">
                <div class="product">
                  <div class="flip-container">
                    <div class="flipper">
                      <div class="front"><a href="login.php"><img src="house1_1.jpg" alt="" class="img-fluid"></a></div>
                      <div class="back"><a href="login.php"><img src="house2_1.jpg" alt="" class="img-fluid"></a></div>
                    </div>
                  </div><a href="login.php" class="invisible"><img src="house1_1.jpg" alt="" class="img-fluid"></a>
                  <div class="text">
                    <h3><a href="login.php">Rs 15,000/-</a></h3>
                    <p class="price">
                      Available Rooms:<br/><?php
                      $sql = "SELECT * FROM house WHERE rent_per_month = 50000 AND status = 'Empty'";
                      $query = mysqli_query($con,$sql);
                      $num = mysqli_num_rows($query);
                      echo $num;
                       ?>
                    </p>
                  </div>
                  <!-- /.text-->

                  <!-- /.ribbon-->

                  <!-- /.ribbon-->
                </div>
                <!-- /.product-->
              </div>
              <div class="item">
                <div class="product">
                  <div class="flip-container">
                    <div class="flipper">
                      <div class="front"><a href="login.php"><img src="house3_2.jpg" alt="" class="img-fluid"></a></div>
                      <div class="back"><a href="login.php"><img src="house1_1.jpg" alt="" class="img-fluid"></a></div>
                    </div>
                  </div><a href="login.php" class="invisible"><img src="house3_2.jpg" alt="" class="img-fluid"></a>
                  <div class="text">
                    <h3><a href="login.php">Rs 30,000/-</a></h3>
                    <p class="price">
                      Available Rooms:<br/><?php
                      $sql = "SELECT * FROM house WHERE rent_per_month = 60000 AND status = 'Empty'";
                      $query = mysqli_query($con,$sql);
                      $num = mysqli_num_rows($query);
                      echo $num;
                       ?>
                    </p>
                  </div>
                  <!-- /.text-->

                  <!-- /.ribbon-->

                  <!-- /.ribbon-->
                </div>
                <!-- /.product-->
              </div>
              <div class="item">
                <div class="product">
                  <div class="flip-container">
                    <div class="flipper">
                      <div class="front"><a href="login.php"><img src="house4_1.jpg" alt="" class="img-fluid"></a></div>
                      <div class="back"><a href="login.php"><img src="house2_1.jpg" alt="" class="img-fluid"></a></div>
                    </div>
                  </div><a href="login.php" class="invisible"><img src="house4_1.jpg" alt="" class="img-fluid"></a>
                  <div class="text">
                    <h3><a href="login.php">Rs. 20,000/-</a></h3>
                    <p class="price">
                      Available Rooms:<br/><?php
                      $sql = "SELECT * FROM house WHERE rent_per_month = 70000 AND status = 'Empty'";
                      $query = mysqli_query($con,$sql);
                      $num = mysqli_num_rows($query);
                      echo $num;
                       ?>
                    </p>
                  </div>
                  <!-- /.text-->

                  <!-- /.ribbon-->

                  <!-- /.ribbon-->
                </div>
                <!-- /.product-->
              </div>
              <div class="item">
                <div class="product">
                  <div class="flip-container">
                    <div class="flipper">
                      <div class="front"><a href="login.php"><img src="house2_1.jpg" alt="" class="img-fluid"></a></div>
                      <div class="back"><a href="login.php"><img src="house1_1.jpg" alt="" class="img-fluid"></a></div>
                    </div>
                  </div><a href="login.php" class="invisible"><img src="house2_1.jpg" alt="" class="img-fluid"></a>
                  <div class="text">
                    <h3><a href="login.php">Rs. 20,000/-</a></h3>
                    <p class="price">
                      Available Rooms:<br/><?php
                      $sql = "SELECT * FROM house WHERE rent_per_month = 80000 AND status = 'Empty'";
                      $query = mysqli_query($con,$sql);
                      $num = mysqli_num_rows($query);
                      echo $num;
                       ?>
                    </p>
                  </div>
                  <!-- /.text-->

                  <!-- /.ribbon-->

                  <!-- /.ribbon-->
                </div>
                <!-- /.product-->
              </div>
              <!-- /.product-slider-->
            </div>
            <!-- /.container-->
          </div>
          <!-- /#hot-->
          <!-- *** HOT END ***-->
        </div>

      </div>
    </div>


    <!-- /#footer-->
    <!-- *** FOOTER END ***-->


    <!--
    *** COPYRIGHT ***
    _________________________________________________________
    -->
    <div id="copyright">
      <div class="container center">
        <div class="row">
          <div class="">
            <p class="text-center ">Copyright &copy; 2021</p>
          </div>
        </div>
      </div>
    </div>
    
    <script src="vendor1/jquery/jquery.min.js"></script>
    <script src="vendor1/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor1/jquery.cookie/jquery.cookie.js"> </script>
    <script src="vendor1/owl.carousel/owl.carousel.min.js"></script>
    <script src="vendor1/owl.carousel2.thumbs/owl.carousel2.thumbs.js"></script>
    <script src="js1/front.js"></script>
  </body>
</html>
