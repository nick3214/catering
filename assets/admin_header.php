<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin Panel</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../bootstrap/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../bootstrap/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../bootstrap/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="../bootstrap/bower_components/fullcalendar/dist/fullcalendar.min.css">
  <link rel="stylesheet" href="../bootstrap/bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">
  <!-- Theme style -->
  <link rel="stylesheet" href="../bootstrap/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="../bootstrap/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="../bootstrap/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../bootstrap/dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="../bootstrap/bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="../bootstrap/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="../bootstrap/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../bootstrap/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="../bootstrap/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link href="https://fonts.googleapis.com/css?family=Charmonman" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="" class="logo" style="background: #ccc; color: #333;">
      <span class="logo-lg" style="font-size:14px;">
        <i class="fa fa-calendar-o"></i> <?php echo date("Y-m-d H:i a");?>
      </span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-globe"></i>
              <?php $kweri = $dbcon->query("SELECT * FROM notifications WHERE user_type = '0' AND read_logs_admin = '0' order by n_id desc") or die(mysqli_error());
            $count = mysqli_num_rows($kweri);
            ?>
              <span class="label label-success"><?php echo $count;?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                 <?php 
                $query = "SELECT * FROM notifications WHERE user_type = '0' AND read_logs_admin = '0' order by n_id desc";
                $notif = getdata_inner_join($query);
                ?>
                <?php if(!empty($notif)):?>
                  <?php foreach ($notif as $key =>$value):?>
                  <li><!-- start message -->
                    <a href="read_logs.php?n_id=<?php echo $value->n_id?>">
                      <div class="pull-left">
                        <?php echo $value->n_logs?>
                      </div>
                    <br>
                    <small><i class="fa fa-clock-o"></i> <?php echo $value->n_date?>dfsdff</small>
                    </a>

                  </li>
                <?php endforeach;?>
              <?php else:?>
                <li>No Records</li>
              <?php endif;?>
                </ul>
              </li>
              
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <?php $h = single_get("*","user_id","user_account",$_SESSION['user_id']);?>
            <?php if($h['gender'] == 'Male'):?>

              <img src="../bootstrap/dist/img/avatar5.png" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $_SESSION['full_name']?></span>
            <?php else:?>
              <img src="../bootstrap/dist/img/avatar2.png" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $_SESSION['full_name']?></span>
            <?php endif;?>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <?php if($h['gender'] == 'Male'):?>
                <img src="../bootstrap/dist/img/avatar5.png" class="user-image" alt="User Image">
                <?php else:?>
                  <img src="../bootstrap/dist/img/avatar2.png" class="user-image" alt="User Image">
                <?php endif;?>

                <p>
                  <?php echo $_SESSION['full_name']?>
                  <small><?php echo $_SESSION['user_email']?></small>
                </p>
              </li>
              <!-- Menu Body -->
              
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="change.php" class="btn btn-default btn-flat">Change Password</a>
                </div>
                <div class="pull-right">
                  <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          
        </ul>
      </div>
    </nav>
  </header>