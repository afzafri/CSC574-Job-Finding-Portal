<?php $level = isset($_GET['level']) ? $_GET['level'] : 3; ?>
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
  <!-- Ionicons -->
  <link rel="stylesheet" href="./template/bower_components/Ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="./template/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
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
    <a href="./index.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>J</b>FP</span>
      <!-- logo for regular state and mobile devices -->
      <?php
        if($level == 1) { echo '<span class="logo-lg"><b>ADMIN</b> Dashboard</span>'; }
        else if($level == 2) { echo '<span class="logo-lg"><b>JOB PROVIDER</b> Dashboard</span>'; }
        else if($level == 3) { echo '<span class="logo-lg"><b>YOUNGSTER</b> Dashboard</span>'; }
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
              <img src="./template/dist/img/avatar.png" class="user-image" alt="User Image">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs">Afif Zafri</span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <img src="./template/dist/img/avatar.png" class="img-circle" alt="User Image">

                <p>
                  Afif Zafri - Web Developer
                  <small>Member since Nov. 2012</small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="#" class="btn btn-default btn-flat">Sign out</a>
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
          <img src="./template/dist/img/avatar.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Afif Zafri</p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- search form (Optional) -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
        </div>
      </form>
      <!-- /.search form -->

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">HEADER</li>
        <!-- Optionally, you can add icons to the links -->
        <?php
          if($level == 1) {
            echo '<li class="active"><a href="#"><i class="fa fa-fw fa-list-alt"></i> <span>Portal Statistics</span></a></li>
                  <li><a href="#"><i class="fa fa-fw fa-pencil-square-o"></i> <span>Manage User Account</span></a></li>
                  <li><a href="#"><i class="fa fa-fw fa-pencil-square-o"></i> <span>Manage User Job Provider Account</span></a></li>
                  <li><a href="#"><i class="fa fa-fw fa-pencil-square-o"></i> <span>Manage Job Offers</span></a></li>
                  <li><a href="#"><i class="fa fa-fw fa-pencil-square-o"></i> <span>Manage User Post</span></a></li>
                  <li><a href="#"><i class="fa fa-fw fa-pencil-square-o"></i> <span>View and Generate Report</span></a></li>';
          }
          else if($level == 2) {
            echo '<li class="active"><a href="#"><i class="fa fa-fw fa-list-alt"></i> <span>Manage Job Offers</span></a></li>
                  <li><a href="#"><i class="fa fa-fw fa-pencil-square-o"></i> <span>View Job Applications</span></a></li>';
          }
          else if($level == 3) {
            echo '<li class="active"><a href="#"><i class="fa fa-fw fa-list-alt"></i> <span>Job Applications</span></a></li>
                  <li><a href="#"><i class="fa fa-fw fa-pencil-square-o"></i> <span>Manage Posts</span></a></li>';
          }
        ?>

        <li><a href="../home.php"><i class="fa fa-fw fa-pencil-square-o"></i> <span>JFP Web</span></a></li>
        <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>Multilevel</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#">Link in level 2</a></li>
            <li><a href="#">Link in level 2</a></li>
          </ul>
        </li>
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
        Page Header
        <small>Optional description</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

    <!--- Start dari sini ke atas: header.php -->
