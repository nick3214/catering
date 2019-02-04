<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_admin'])){
  header("Location: ../index.php");
  exit;
}

if(isset($_GET['cancel_approve'])){
  $user_id = single_get("*","tcode","reservations",$_GET['tcode']);
  $cancel_approve = filter($_GET['cancel_approve']);
  $tcode = filter($_GET['tcode']);
  $updateQuery = $dbcon->query("UPDATE reservations SET reservation_status = 'Cancelled' WHERE tcode='$tcode'") or die(mysqli_error());
  $updateCancel = $dbcon->query("UPDATE cancel_resched SET request_status = '1' WHERE cancel_id = '$cancel_approve'") or die(mysqli_error());
  $notifSQL = array("n_logs"=>"Transaction Code: ".$tcode." cancellation has been approved","user_id"=>$user_id['user_id']);
  insertdata("notifications",$notifSQL);
  header("location: index.php");
}elseif(isset($_GET['cancel_reject'])){
  $user_id = single_get("*","tcode","reservations",$_GET['tcode']);
   $cancel_reject = filter($_GET['cancel_reject']);
  $tcode = filter($_GET['tcode']);
  $updateCancel = $dbcon->query("UPDATE cancel_resched SET request_status = '2' WHERE cancel_id = '$cancel_reject'") or die(mysqli_error());
  $notifSQL = array("n_logs"=>"Transaction Code: ".$tcode." cancellation has been rejected","user_id"=>$user_id['user_id']);
  insertdata("notifications",$notifSQL);
  header("location: index.php");
}
if(isset($_GET['resched_approve'])){
  $user_id = single_get("*","tcode","reservations",$_GET['tcode']);
  $resched_approve = filter($_GET['resched_approve']);
  $tcode = filter($_GET['tcode']);

  $fetchReserve = single_get("*","cancel_id","cancel_resched",$resched_approve);

  $updateQuery = $dbcon->query("UPDATE reservations SET event_time = '".$fetchReserve['resched_time']."', event_date='".$fetchReserve['resched_date']."' WHERE tcode='$tcode'") or die(mysqli_error());

  $updateCancel = $dbcon->query("UPDATE cancel_resched SET request_status = '1' WHERE cancel_id = '$resched_approve'") or die(mysqli_error());
  $notifSQL = array("n_logs"=>"Transaction Code: ".$tcode." reschedule has been approved","user_id"=>$user_id['user_id']);
  insertdata("notifications",$notifSQL);

  header("location: index.php");

}elseif(isset($_GET['resched_reject'])){
  $user_id = single_get("*","tcode","reservations",$_GET['tcode']);
  $resched_reject = filter($_GET['resched_reject']);
  $tcode = filter($_GET['tcode']);
  $updateCancel = $dbcon->query("UPDATE cancel_resched SET request_status = '2' WHERE cancel_id = '$cancel_reject'") or die(mysqli_error());
  $notifSQL = array("n_logs"=>"Transaction Code: ".$tcode." reschedule has been rejected","user_id"=>$user_id['user_id']);
  insertdata("notifications",$notifSQL);
  header("location: index.php");
}
$packageSQL = $dbcon->query("SELECT * FROM packages WHERE p_user='".$_SESSION['user_id']."'") or die(mysqli_error());
$countPackage = mysqli_num_rows($packageSQL);

$reservationSQL = $dbcon->query("SELECT * FROM reservations WHERE reservation_status != 'Draft'") or die(mysqli_error());
$countReservation = mysqli_num_rows($reservationSQL);

$customerSQL = $dbcon->query("SELECT * FROM user_account WHERE user_role = '1'") or die(mysqli_error());
$countCustomer = mysqli_num_rows($customerSQL);

$walkinSQL = $dbcon->query("SELECT * FROM reservations WHERE reservation_type = '1'") or die(mysqli_error());
$countWalkin = mysqli_num_rows($walkinSQL);
?>
<?php include'../assets/admin_header.php';?>
<?php include'../assets/admin_sidebar.php';?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $countPackage;?></h3>

              <p>Packages</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="packages.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $countReservation;?></h3>

              <p>Online Reservations</p>
            </div>
            <div class="icon">
              <i class="ion ion-calendar"></i>
            </div>
            <a href="online-reservation.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $countCustomer;?></h3>

              <p>Customers</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="customer.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->

        <!-- ./col -->
      </div>

      <div class="row">
       <div class="container">
          <div class="box box-danger" style="width:95.5%;">
            <div class="box-header">
              

              <h4 class="box-title"><i class="fa fa-arrow-left"></i> Approval Request for Cancellation</h4>
            </div>
            <div class="box-body">
             <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Code</th>
                  <th>Event Name</th>
                  <th>Date</th>
                  <th>Time</th>
                  <th>Reason</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
          <?php 
          $sql = $dbcon->query("SELECT * FROM cancel_resched INNER JOIN user_account on user_account.user_id = cancel_resched.user_id INNER JOIN reservations on reservations.tcode = cancel_resched.tcode WHERE status_type = '0'") or die(mysqli_error());
          ?>

          <?php while($row = $sql->fetch_assoc()):?>
                <tr>
                  <td><?php echo $row['tcode']?></td>
                  <td><?php echo $row['event_name']?></td>
                  <td><?php echo $row['event_date']?></td>
                  <td><?php echo date("h:i:sa",strtotime($row['event_time']))?></td>
                  <td><?php echo $row['reason']?></td>
                  <td><?php if($row['request_status'] == '0'): echo 'Waiting for Approval';elseif($row['request_status'] == '1'): echo 'Cancelled';else: echo 'Rejected';endif;?></td>
                  <td>
                  <?php if($row['request_status'] =='0'):?>
                  <div class="btn-group">
                    
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                     
                      <li><a href="#" <?php echo 'onclick=" confirm(\'Are you sure you want to approve?\') 
      ?window.location = \'index.php?cancel_approve='.$row['cancel_id'].'&tcode='.$row['tcode'].'\' : \'\';"'; ?>>Approve</a></li>
      <li><a href="#" <?php echo 'onclick=" confirm(\'Are you sure you want to reject?\') 
      ?window.location = \'index.php?cancel_reject='.$row['cancel_id'].'&tcode='.$row['tcode'].'\' : \'\';"'; ?>>Reject</a></li>
                    </ul>
                  </div>
                <?php endif;?>
                  </td>
                </tr>
          <?php endwhile;?> 
                      
              </table>
            </div>
            
          </div>
          <hr>
           <div class="box box-danger" style="width:95.5%;">
            <div class="box-header">
              

              <h4 class="box-title"><i class="fa fa-calendar"></i> Approval Request for Scheduling</h4>
            </div>
            <div class="box-body">
               <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Code</th>
                  <th>Event Name</th>
                  <th>Date</th>
                  <th>Time</th>
                  <th>Reason</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
          <?php 
          $kweri = $dbcon->query("SELECT * FROM cancel_resched INNER JOIN user_account on user_account.user_id = cancel_resched.user_id INNER JOIN reservations on reservations.tcode = cancel_resched.tcode WHERE status_type = '1'") or die(mysqli_error());
          ?>

          <?php while($result = $kweri->fetch_assoc()):?>
                <tr>
                  <td><?php echo $result['tcode']?></td>
                  <td><?php echo $result['event_name']?></td>
                  <td><?php echo $result['resched_date']?></td>
                  <td><?php echo date("h:i:sa",strtotime($result['event_time']))?></td>
                  <td><?php echo $result['reason']?></td>
                  <td><?php if($result['request_status'] == '0'): echo 'Waiting for Approval';elseif($result['request_status'] == '1'): echo 'Approved for Rescheduling';else: echo 'Rejected for Rescheduling';endif;?>
                  </td>
                  <td>
                  <?php if($result['request_status'] =='0'):?>
                  <div class="btn-group">
                    
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                     
                      <li><a href="#" <?php echo 'onclick=" confirm(\'Are you sure you want to approve?\') 
      ?window.location = \'index.php?resched_approve='.$result['cancel_id'].'&tcode='.$result['tcode'].'\' : \'\';"'; ?>>Approve</a></li>
      <li><a href="#" <?php echo 'onclick=" confirm(\'Are you sure you want to reject?\') 
      ?window.location = \'index.php?resched_reject='.$result['cancel_id'].'&tcode='.$result['tcode'].'\' : \'\';"'; ?>>Reject</a></li>
                    </ul>
                  </div>
                <?php endif;?>
                  </td>
                </tr>
          <?php endwhile;?> 
                      
              </table>
            </div>
            
          </div>
       </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php include'../assets/admin_footer.php';?>
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable()
  })
</script>
</body>
</html>
