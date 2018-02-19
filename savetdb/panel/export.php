<?php

  session_start();
  require_once '../login/class.user.php';

  $panel_home = new USER();

  if(!$panel_home->is_logged_in_admin())
  {
    $panel_home->redirect('../login/index.php');
  }

  // Uskladjivanje vremenske zone sa bazom
  date_default_timezone_set('Europe/Belgrade');
  // $settimezone = $user_home->runQuery("SET SESSION time_zone = '+2:00'");
  // $settimezone->execute();

  // upit koji za rezultat daje broj registrovanih korisnika
  $stmt = $panel_home->runQuery("SELECT COUNT(*) FROM tbl_members");
  $stmt->execute();
  $membersNumber = $stmt->fetchColumn();

   // upit koji za rezultat daje broj registrovanih korisnika
  $stmt = $panel_home->runQuery("SELECT COUNT(*) FROM tbl_comments");
  $stmt->execute();
  $commentsNumber = $stmt->fetchColumn();

?>

<!DOCTYPE html>
<html lang="sr" class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SBSNS | BAZA PODATAK</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.css">
  <link rel="stylesheet" href="dist/css/buttons.bootstrap.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/skin-red.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-red sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="index.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>S</b>DB</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Savet</b>DB</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="dist/img/novi-sad-logo.png" class="user-image" alt="User Image">
              <span class="hidden-xs">Savet za koordinaciju poslova bezbednosti saobraćaja na putevima na teritoriji Grada Novog Sada</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="dist/img/novi-sad-logo.png" class="img-circle" alt="User Image">

                <p>
                  Savet za koordinaciju poslova bezbednosti saobraćaja na putevima na teritoriji Grada Novog Sada
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-12 text-center">
                    <a href="http://sbsns.rs">www.sbsns.rs</a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                  <a href="#" class="btn btn-default btn-flat">Odjava</a>
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
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="dist/img/novi-sad-logo.png" class="img-circle" alt="Logo korisnika">
        </div>
        <div class="pull-left info">
          <p>sbsns.rs</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MENI</li>
        <li>
          <a href="index.php"><i class="fa fa-table"></i> <span>Korisnici i komentari</span>
          </a>
        </li>
        <li>
          <a href="korisnici.php"><i class="fa fa-users"></i> <span>Korisnici</span>
          </a>
        </li>
        <li>
          <a href="komentari.php"><i class="fa fa-commenting-o"></i> <span>Komentari</span>
          </a>
        </li>
        <li>
          <a href="posalji-vest.php"><i class="fa fa-paper-plane-o"></i> <span>Pošalji vest članovima</span>
          </a>
        </li>
        <li class="active">
          <a href="export.php"><i class="fa fa-download"></i> <span>Eksport baze</span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       EXPORT BAZE
        <small>Izvoz podataka iz baze</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Pošalji vest</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-6 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $membersNumber; ?></h3>

              <p>Broj registrovanih korisnika</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="korisnici.php" class="small-box-footer">Više informacija <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-6 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo $commentsNumber; ?></h3>

              <p>Broj komentara</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="komentari.php" class="small-box-footer">Više informacija <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title" style="color: green; font-weight: bold;" >EXPORT PODATAKA
                <small>Klikom na dugme izvezi podatke u Excel</small>
              </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body pad">
              <form action="export-excel.php" method="post">
                <input type="submit" class="btn btn-block btn-success btn-lg" name="export_excel" value="Izvezi podatke u Excel" style="width: 200px;">
              </form>
            </div>
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; 2017 <a href="#">ASajfar</a> - </strong> All rights
    reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.js"></script>
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- page script -->
<script>
  $(function () {
    //bootstrap WYSIHTML5 - text editor
    $(".textarea").wysihtml5();
  });
</script>
</body>
</html>
