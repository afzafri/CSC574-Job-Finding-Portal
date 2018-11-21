<?php

  include './config.php';
  session_start();
  //Check whether the session variable SESS_MEMBER_ID is present or not

  $user_id = (isset($_SESSION['USER_ID'])) ? $_SESSION['USER_ID'] : "";
  $user_email = (isset($_SESSION['USER_EMAIL'])) ? $_SESSION['USER_EMAIL'] : "";
  $user_username = (isset($_SESSION['USER_USERNAME'])) ? $_SESSION['USER_USERNAME'] : "";
  $level = (isset($_SESSION['USER_LEVEL'])) ? $_SESSION['USER_LEVEL'] : "";
  $user_name = "";
  $user_ids = "";

  try
  {
    if($level == 1) {

    }
    else if($level == 2) {

      $stmt = $conn->prepare("SELECT * FROM JOB_PROVIDER WHERE L_ID = ?");
      $stmt->execute(array($user_id));
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      $user_ids = $result['JP_ID'];
      $user_name = $result['JP_NAME'];
      $user_desc = $result['JP_DESCRIPTION'];
      $user_area = $result['JP_AREA'];
      $user_address = $result['JP_ADDRESS'];
      $user_phone = $result['JP_PHONE'];
      $user_website = $result['JP_WEBSITE'];
      $user_profilepic = $result['JP_PROFILEPIC'];

    }
    else if($level == 3) {
      $stmt = $conn->prepare("SELECT * FROM JOB_SEEKER WHERE L_ID = ?");
      $stmt->execute(array($user_id));
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $user_ids = $result['JS_ID'];
      $user_name = $result['JS_NAME'];

    }


  }
  catch(PDOException $e)
  {
    echo "Connection failed : " . $e->getMessage();
  }

  ?>

<!DOCTYPE html>
<html lang="zxx" class="no-js">
<head>
  <!-- Mobile Specific Meta -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Favicon-->
  <link rel="shortcut icon" href="./template/img/fav.png">
  <!-- Author Meta -->
  <meta name="author" content="codepixer">
  <!-- Meta Description -->
  <meta name="description" content="">
  <!-- Meta Keyword -->
  <meta name="keywords" content="">
  <!-- meta character set -->
  <meta charset="UTF-8">
  <!-- Site Title -->
  <title><?php echo $pageTitle; ?> | Job Finding Portal</title>

  <link href="./template/css/font.css" rel="stylesheet">
    <!--
    CSS
    ============================================= -->
    <link rel="stylesheet" href="./template/css/linearicons.css">
    <link rel="stylesheet" href="./template/css/font-awesome.min.css">
    <link rel="stylesheet" href="./template/css/bootstrap.css">
    <link rel="stylesheet" href="./template/css/magnific-popup.css">
    <link rel="stylesheet" href="./template/css/nice-select.css">
    <link rel="stylesheet" href="./template/css/animate.min.css">
    <link rel="stylesheet" href="./template/css/owl.carousel.css">
    <link rel="stylesheet" href="./template/css/main.css">
    <link rel="stylesheet" href="./template/plugins/DataTables/datatables.css">
    <!-- Bootstrap FileInput -->
    <link rel="stylesheet" href="./dashboard/template/bower_components/bootstrap-fileinput/css/fileinput.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="./dashboard/template/bower_components/select2/dist/css/select2.css">
    <style>
    .btn[disabled] {
        cursor: not-allowed !important;
    }
    .navActive {
      background-image: -moz-linear-gradient(0deg, #bfacff 0%, #795fff 100%);
      background-image: -webkit-linear-gradient(0deg, #bfacff 0%, #795fff 100%);
      background-image: -ms-linear-gradient(0deg, #bfacff 0%, #795fff 100%);
      border: 1px solid #49e4fa;
    }
    </style>
  </head>
  <body>

      <header id="header" id="home">
        <div class="container">
          <div class="row align-items-center justify-content-between d-flex">
            <div id="logo">
              <a href="index.html"><h3 style="color: white">Job Finding Portal</h3></a>
            </div>
            <nav id="nav-menu-container">
              <ul class="nav-menu">
                <li><a href="./index.php">Home</a></li>
                <li><a href="./jobsearch.php">Job Search</a></li>
                <li><a href="./providers.php">Providers List</a></li>
                <li><a href="./aboutus.php">About Us</a></li>
                <li><a href="./contactus.php">Contact</a></li>
                <?php
                  if($user_id != ""){

                    ?>
                    <li class="menu-has-children"><a href=""><?php echo $user_name; ?></a>
                      <ul>
                        <li><a href="./dashboard/profile.php">View Profile</a></li>
                        <li><a href="./dashboard">Dashboard</a></li>
                        <li><a href="./logout.php">Log Out</a></li>
                      </ul>
                    </li>
                    <?php
                  } else {
                    ?>
                      <li class=""><a class="ticker-btn" href="./login.php">Login</a></li>
                    <?php
                  }

                ?>

              </ul>
            </nav><!-- #nav-menu-container -->
          </div>
        </div>
      </header><!-- #header -->

    <!-- start banner Area -->
    <section class="banner-area relative" id="home">
      <div class="overlay overlay-bg"></div>
      <div class="container">
        <div class="row d-flex align-items-center justify-content-center">
          <div class="about-content col-lg-12">
            <h1 class="text-white">
              <?php echo $pageTitle; ?>
            </h1>
          </div>
        </div>
      </div>
    </section>
    <!-- End banner Area -->
