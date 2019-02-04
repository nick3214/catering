<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_admin'])){
  header("Location: ../index.php");
  exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Administration Panel</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link href="https://fonts.googleapis.com/css?family=Charmonman" rel="stylesheet">
  <link rel="stylesheet" href="../bootstrap/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../bootstrap/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../bootstrap/bower_components/Ionicons/css/ionicons.min.css">
  <!-- fullCalendar -->
  <link rel="stylesheet" href="../bootstrap/bower_components/fullcalendar/dist/fullcalendar.min.css">
  <link rel="stylesheet" href="../bootstrap/bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">
  <!-- Theme style -->
  <link rel="stylesheet" href="../bootstrap/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../bootstrap/dist/css/skins/_all-skins.min.css">

  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
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
              <?php $kweri = $dbcon->query("SELECT * FROM notifications WHERE user_type = '0' AND read_logs_admin = '0'") or die(mysqli_error());
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
                $query = "SELECT * FROM notifications WHERE user_type = '0' AND read_logs_admin = '0'";
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
                    <small><i class="fa fa-clock-o"></i> <?php echo $value->n_date?></small>
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

  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar" style="background:#f4f4f4;color:white;">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree" >
        <li class="header" style="background: #069; color:white;">MAIN NAVIGATION</li>
        <li class="active">
          <a href="index.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span> </a>
        </li>
        <li>
          <a href="calendar.php"><i class="fa fa-calendar"></i> <span>Calendar</span> </a>
        </li>
         <li>
          <a href="messages.php"><i class="fa fa-envelope"></i> <span>Messages</span> </a>
        </li>
        <li>
          <a href="customer.php"><i class="fa fa-users"></i> Customers </a>
        </li>
        
        <li class="treeview">
          <a href="#">
            <i class="fa fa-plus"></i>
            <span>File Maintenance</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="amenities.php"><i class="fa fa-circle-o"></i> Other Services</a></li>
            <li><a href="food_categories.php"><i class="fa fa-circle-o"></i> Category</a></li>
             <li><a href="sub_category.php"><i class="fa fa-circle-o"></i> Sub Category</a></li>
            <!--
            <li><a href="menu.php"><i class="fa fa-circle-o"></i> Menus</a></li>
          -->
            <li><a href="food_items.php"><i class="fa fa-circle-o"></i> Menu</a></li>
            <li><a href="package_types.php"><i class="fa fa-circle-o"></i> Package Type</a></li>
            <li><a href="packages.php"><i class="fa fa-circle-o"></i> Packages</a></li>
            
            <li><a href="freebies.php"><i class="fa fa-circle-o"></i> Freebie List</a></li>
          
          
            <li><a href="occasion.php"><i class="fa fa-circle-o"></i> Occasion</a></li>
            <li><a href="motif.php"><i class="fa fa-circle-o"></i> Motif</a></li>
          
            
            <li><a href="staff.php"><i class="fa fa-circle-o"></i> System User</a></li>
         
            <li><a href="photo.php"><i class="fa fa-circle-o"></i> Front End Photo</a></li>
            <!--
            <li><a href="city.php"><i class="fa fa-circle-o"></i> City</a></li>
            <li><a href="contact.php"><i class="fa fa-circle-o"></i> Contact Us</a></li>
          -->
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-folder"></i>
            <span>Reservations</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="online-reservation.php"><i class="fa fa-circle-o"></i> Online Reservations</a></li>
            
            <li><a href="paluto.php"><i class="fa fa-circle-o"></i> Paluto</a></li>
          
            
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-calendar"></i>
            <span>Reports</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="print-amenities.php"><i class="fa fa-circle-o"></i> Amenities</a></li>
            <li><a href="print-sales.php"><i class="fa fa-circle-o"></i> Sales Report</a></li>
            <li><a href="print-cancel.php"><i class="fa fa-circle-o"></i> Cancelled Reports</a></li>
            <li><a href="print-customer.php"><i class="fa fa-circle-o"></i> Customers</a></li>
            <li><a href="print-package.php"><i class="fa fa-circle-o"></i> Packages</a></li>
            <li><a href="print-items.php"><i class="fa fa-circle-o"></i> Food Items</a></li>
            <li><a href="print-products.php"><i class="fa fa-circle-o"></i> Products</a></li>
            <li><a href="print-menu.php"><i class="fa fa-circle-o"></i> Menus</a></li>
            <li><a href="print-resched.php"><i class="fa fa-circle-o"></i> Re-scheduled Reports</a></li>
            
          </ul>
        </li>
        <!--
        <li>
          <a href="themes.php"><i class="fa fa-list"></i> <span>Themes</span> </a>
        </li>
      -->
        <li>
          <a href="settings.php"><i class="fa fa-wrench"></i> <span>Settings</span> </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      

      <div class="row">
       <div class="container">
        
        <div class="box box-info" style="width:95.5%;">
            <div class="box-header">
              

              <h4 class="box-title"><i class="fa fa-calendar"></i> Calendar</h4><br>
              <strong>Legends:</strong><br>
              Red when the schedule is full - <div class="label label-danger">RED</div><br>
              Blue when the schedule is not full - <div class="label label-primary">BLUE</div>
            </div>
            <div class="box-body">
             <div id="calendar"></div>
            </div>
            
          </div>
          <hr>
         
       </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
 
  <footer class="main-footer">
    
    <strong>Copyright &copy; 2017.</strong> All rights
    reserved.
  </footer>
</div>

</body>
<script src="../bootstrap/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../bootstrap/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../bootstrap/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Slimscroll -->
<script src="../bootstrap/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../bootstrap/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../bootstrap/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../bootstrap/dist/js/demo.js"></script>
<!-- fullCalendar -->
<script src="../bootstrap/bower_components/moment/moment.js"></script>
<script src="../bootstrap/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>

<!-- Page specific script -->
<script type="text/javascript">
$(document).ready(function() {
    var calendar = $('#calendar').fullCalendar({
        defaultView: 'month',
        events: {
            url: 'getEvent.php',
            type: 'POST', // Send post data

            error: function() {
                alert('There was an error while fetching events.');
            }
        }
    });

});
</script>
</body>
</html>