<?php
  include '../auth.php';
  include '../config.php';
?>

<?php

$user_id = $_SESSION['USER_ID'];
$user_email = $_SESSION['USER_EMAIL'];
$user_username = $_SESSION['USER_USERNAME'];
$level = $_SESSION['USER_LEVEL'];

$user_name = "";

try
{
  if($level == 1) {

    $stmt = $conn->prepare("SELECT * FROM STAFF WHERE L_ID = ?");
    $stmt->execute(array($user_id));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $user_ids = $result['S_ID'];
    $user_name = $result['S_NAME'];
    $user_ic = $result['S_IC'];
    $user_department = $result['S_DEPARTMENT'];
    $user_address = $result['S_ADDRESS'];
    $user_phone = $result['S_PHONE'];
    $currpicname = $result['S_PROFILEPIC'];
    $user_profilepic = ($currpicname != "") ? "../images/profilepics/".$currpicname : "./template/dist/img/avatar.png";

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
    $currpicname = $result['JP_PROFILEPIC'];
    $user_profilepic = ($currpicname != "") ? "../images/profilepics/".$currpicname : "./template/dist/img/avatar.png";

  }
  else if($level == 3) {
    $stmt = $conn->prepare("SELECT * FROM JOB_SEEKER WHERE L_ID = ?");
    $stmt->execute(array($user_id));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $user_ids = $result['JS_ID'];
    $user_name = $result['JS_NAME'];
    $user_about = $result['JS_ABOUT'];
    $user_ic = $result['JS_IC'];
    $user_address = $result['JS_ADDRESS'];
    $user_skill = $result['JS_SKILL'];
    $user_phone = $result['JS_PHONE'];
    $currpicname = $result['JS_PROFILEPIC'];
    $user_profilepic = ($currpicname != "") ? "../images/profilepics/".$currpicname : "./template/dist/img/avatar.png";

  }


}
catch(PDOException $e)
{
  echo "Connection failed : " . $e->getMessage();
}

?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $pageTitle; ?> | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="./template/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./template/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="./template/bower_components/DataTables/datatables.css">
  <!-- DateTimePicker -->
  <link rel="stylesheet" href="./template/bower_components/bootstrap-datetimepicker/bootstrap-datetimepicker.css">
  <!-- Bootstrap FileInput -->
  <link rel="stylesheet" href="./template/bower_components/bootstrap-fileinput/css/fileinput.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="./template/bower_components/select2/dist/css/select2.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./template/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect. -->
  <?php
    /* level 1 = ministry/admin
       level 2 = job provider
       level 3 = youngster */
    if($level == 1) { echo '<link rel="stylesheet" href="./template/dist/css/skins/skin-red.min.css">'; }
    else if($level == 2) { echo '<link rel="stylesheet" href="./template/dist/css/skins/skin-green.min.css">'; }
    else if($level == 3) { echo '<link rel="stylesheet" href="./template/dist/css/skins/skin-purple.min.css">'; }
  ?>


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<?php
  if($level == 1) { echo '<body class="hold-transition skin-red sidebar-mini">'; }
  else if($level == 2) { echo '<body class="hold-transition skin-green sidebar-mini">'; }
  else if($level == 3) { echo '<body class="hold-transition skin-purple sidebar-mini">'; }
?>
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="./index.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>J</b>FP</span>
      <!-- logo for regular state and mobile devices -->
      <?php
        if($level == 1) { echo '<span class="logo-lg"><b>ADMIN</b> Dashboard</span>'; }
        else if($level == 2) { echo '<span class="logo-lg"><b>JOB PROVIDER</b> Dashboard</span>'; }
        else if($level == 3) { echo '<span class="logo-lg"><b>JOB SEEKER</b> Dashboard</span>'; }
      ?>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <img src="<?php echo $user_profilepic; ?>" class="user-image" alt="<?php echo $user_name; ?>">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs"><?php echo $user_name; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <img src="<?php echo $user_profilepic; ?>" class="img-circle" alt="<?php echo $user_name; ?>">

                <p>
                  <?php echo $user_name; ?>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="./profile.php" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <form action="../logout.php" method="post" onsubmit="return confirm('Sign out of the dashboard?')">
                    <button type="submit" class="btn btn-default btn-flat">Sign out</button>
                  </form>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo $user_profilepic; ?>" class="img-circle" alt="<?php echo $user_name; ?>">
        </div>
        <div class="pull-left info">
          <p><?php echo $user_name; ?> (@<?php echo $user_username; ?>)</p>
          <!-- Email -->
          <i class="fa fa-fw fa-envelope"></i> <?php echo $user_email; ?>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">HEADER</li>
        <!-- Optionally, you can add icons to the links -->
        <?php
          if($level == 1) {
            echo '<li><a href="./index.php"><i class="fa fa-fw fa-bar-chart"></i> <span>Portal Statistics</span></a></li>
                  <li><a href="./managestaff.php"><i class="fa fa-fw fa-pencil-square-o"></i> <span>Manage Staff Account</span></a></li>
                  <li><a href="./manageseeker.php"><i class="fa fa-fw fa-pencil-square-o"></i> <span>Manage Seeker Account</span></a></li>
                  <li><a href="./manageprovider.php"><i class="fa fa-fw fa-pencil-square-o"></i> <span>Manage Job Provider Account</span></a></li>
                  <li><a href="./managejob.php"><i class="fa fa-fw fa-pencil-square-o"></i> <span>Manage Job Offers</span></a></li>
                  <li><a href="./managepost.php"><i class="fa fa-fw fa-pencil-square-o"></i> <span>Manage User Post</span></a></li>
                  <li><a href="#"><i class="fa fa-fw fa-file-text"></i> <span>View and Generate Report</span></a></li>';
          }
          else if($level == 2) {
            echo '<li><a href="./index.php"><i class="fa fa-fw fa-list-alt"></i> <span>Manage Job Offers</span></a></li>
                  <li><a href="./jobapplications.php"><i class="fa fa-fw fa-pencil-square-o"></i> <span>View Job Applications</span></a></li>';
          }
          else if($level == 3) {
            echo '<li><a href="./index.php"><i class="fa fa-fw fa-list-alt"></i> <span>Job Applications</span></a></li>
                  <li><a href="./jobdoneposts.php"><i class="fa fa-fw fa-pencil-square-o"></i> <span>Manage Posts</span></a></li>';
          }
        ?>

        <li><a href="../index.php"><i class="fa fa-fw fa-globe"></i> <span>JFP Web</span></a></li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $pageTitle; ?>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

    <!--- Start dari sini ke atas: header.php -->
