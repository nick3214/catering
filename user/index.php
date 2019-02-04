<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_user'])){
  header("Location: ../index.php");
  exit;
}
if(isset($_GET['delete'])){
  $delete = filter($_GET['delete']);
    $ar = array("cancel_id"=>$delete);
    $tbl_name = "cancel_resched";
    $del = delete($dbcon,$tbl_name,$ar);
    if($del){
      header("location: index.php");
    }
}
if(isset($_GET['resched'])){
  $delete = filter($_GET['resched']);
    $ar = array("cancel_id"=>$delete);
    $tbl_name = "cancel_resched";
    $del = delete($dbcon,$tbl_name,$ar);
    if($del){
      header("location: index.php");
    }
}
$reservationSQL = $dbcon->query("SELECT * FROM reservations WHERE user_id = '".$_SESSION['user_id']."' AND reservation_status != 'Draft'") or die(mysqli_error());
$countReservation = mysqli_num_rows($reservationSQL);

$cancelSQL = $dbcon->query("SELECT * FROM reservations WHERE user_id = '".$_SESSION['user_id']."' AND reservation_status = 'Cancelled'") or die(mysqli_error());
$countCancel = mysqli_num_rows($cancelSQL);

$user = $dbcon->query("select * from user_account where user_id ='".$_SESSION['user_id']."'");
$username = $user->fetch_object();

$palutoSql = $dbcon->query("SELECT * FROM paluto_transaction WHERE paluto_name = '".$username->user_email."'") or die(mysqli_error());
$countPaluto = mysqli_num_rows($palutoSql);
?>
<?php include'../assets/user_header.php';?>
<style>
input[type='text']{
  text-align:center;
}
</style>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/themes/base/jquery-ui.css" rel="stylesheet" />
<script class="jsbin" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
  <div style="height:20px;"></div>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="width:87%; margin: 0 auto;background: white;border-radius:3px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    
      <?php 
      $ua = strtolower($_SERVER['HTTP_USER_AGENT']);
      if(stripos($ua,'android') !== false) { // && stripos($ua,'mobile') !== false) {
      ?>
      <section class="content">

    <h4><i class="fa fa-dashboard"></i> Dashboard</h4><hr>
    <div class="row" style="background: white;">
        <div class="col-lg-4 col-xs-4">
          <center><h2><a href="index.php"><i class="fa fa-dashboard"></i></a></h2>
          <small>Dashboard</small></center>
          
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-4">
          <center><h2><a href="calendar.php"><i class="fa fa-calendar"></i></a></h2>
            <small>Calendar</small></center>
        </div>
        <div class="col-lg-4 col-xs-4">
          <center><h2><a href="packages.php"><i class="fa fa-folder"></i></a></h2>
            <small>Packages</small></center>
        </div>
         <div class="col-lg-4 col-xs-4">
          <center><h2><a href="paypal.php"><i class="fa fa-paypal"></i></a></h2>
            <small>Transaction</small></center>
        </div>
        <div class="col-lg-4 col-xs-4">
          <center><h2><a href="reservations.php"><i class="fa fa-th"></i></a></h2>
            <small>Reservations</small></center>
        </div>
        <div class="col-lg-4 col-xs-4">
          <center><h2><a href="customize.php"><i class="fa fa-pencil"></i></a></h2>
            <small>Customize</small></center>
        </div>
        <div class="col-lg-4 col-xs-4">
          <center><h2><a href="themes.php"><i class="fa fa-file"></i></a></h2>
            <small>themes</small></center>
        </div>
        <div class="col-lg-4 col-xs-4">
          <center><h2><a href="cancel-resched.php"><i class="fa fa-list"></i></a></h2>
            <small>Cancel/Resched</small></center>
        </div>
      </div>
      <hr>
                <div class="row">
        
        <!-- ./col -->
        <div class="col-lg-6 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $countReservation; ?></h3>

              <p>Reservations</p>
            </div>
            <div class="icon">
              <i class="ion ion-calendar"></i>
            </div>
            <a href="online-reservations.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-6 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $countCancel;?></h3>

              <p>Cancelled</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="cancel-reservation.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>

            
          </div>
       </div>
      </div>
    </section>
      <?php }else{?>
      <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <!-- ./col -->
        <div class="col-lg-4 col-xs-4">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $countReservation; ?></h3>

              <p>Event Reservations</p>
            </div>
            <div class="icon">
              <i class="ion ion-calendar"></i>
            </div>
            <a href="online-reservations.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-4">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3><?php echo $countPaluto;?></h3>

              <p>Paluto Reservations</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#paluto" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-4 col-xs-4">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $countCancel;?></h3>

              <p>Cancelled Reservations</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="cancel-reservation.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>

      <div class="row">
       <div class="container">
        
        <div class="box box-info" style="width:97%;">
            <div class="box-header">
              

              <h4 class="box-title"><i class="fa fa-calendar"></i> Waiting Approval Request for Re-Scheduling</h4>
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
                    <?php if($result['request_status'] == '0'):?>
                  <div class="btn-group">
                    <button type="button" class="btn btn-info">Action</button
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                     
                      <li><a href="#" <?php echo 'onclick=" confirm(\'Are you sure you want to delete?\') 
      ?window.location = \'index.php?resched='.$result['cancel_id'].'\' : \'\';"'; ?>>Delete</a></li>
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
          <div class="box box-info" style="width:97%;" id="paluto">
            <div class="box-header">
              

              <h4 class="box-title"><i class="fa fa-calendar"></i> Paluto Reservation</h4>
            </div>
            <div class="box-body">
            <table id="example3" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Code</th>
                  <th>Reservation Type</th>
                  <th>Date Reserve</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
          <?php 
          $kweri = $dbcon->query("SELECT * FROM paluto_transaction where paluto_name ='".$username->user_email."'") or die(mysqli_error());
          ?>

          <?php while($result = $kweri->fetch_assoc()):?>
                <tr>
                  <td>#0101<?php echo $result['paluto_id']?></td>
                  <td><?php
                    if($result['paluto_method'] == "pack"){
                      echo "Short Order Reservation";
                    }else{
                      echo "Customize Reservation";
                    }
                  ?></td>
                  <td><?php echo $result['paluto_date'];?></td>
                
                  <td><?php if($result['paluto_status'] == '0'): echo '<span style="color:blue">Pending</span>';elseif($result['paluto_status'] == '2'): echo '<span style="color:blue">Approved</span>';elseif($result['paluto_status'] == '1'): echo '<span style="color:red">Reject</span>';else: echo '<span style="color:red">Canceled</span>';endif;?>
                  </td>
                  <td>
                  
                  <div class="btn-group">
                   
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                     <?php 
                     if($result['paluto_status'] == 0):
                      ?>
                      <li><a href="index.php?cancel=<?php echo $result['paluto_id'];?>">Cancel</a></li>
                      <li><a href="#" data-toggle="modal" id="change" name="<?php echo $result['paluto_id'];?>" data-target="#edit">Resched</a></li>
                      <li><a href="#" data-toggle="modal" data-target="#show-<?php echo $result['paluto_id'];?>">View</a></li>
                     <?php else: ?>
                     <li><a href="#" data-toggle="modal" data-target="#show-<?php echo $result['paluto_id'];?>">View</a></li>
                     <?php endif;?>
                    </ul>
                  </div>
               
                  </td>
                </tr>
          <?php endwhile;?> 
                      
              </table>
            </div>
            
          </div>
          <hr>
          <div class="box box-info" style="width:97%;">
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
                  <td><?php if($row['request_status'] == '0'): echo 'Waiting for Approval';elseif($row['request_status'] == '1'): echo 'Approved for Cancellation';else: echo 'Rejected for Rescheduling';endif;?>
                  </td>
                  <td>
                  <?php if($row['request_status'] == '0'):?>
                  <div class="btn-group">
                    
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                     
                      <li><a href="#" <?php echo 'onclick=" confirm(\'Are you sure you want to delete?\') 
      ?window.location = \'index.php?delete='.$row['cancel_id'].'\' : \'\';"'; ?>>Delete</a></li>
                    </ul>
                  </div>
                <?php endif;?>
                  </td>
                </tr>
          <?php endwhile;?> 
                      
              </table>
            </div>
            <?php 
      }
      ?>
          </div>
       </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php 
        $show_transaction = $dbcon->query("select * from paluto_transaction");
        while($data = $show_transaction->fetch_assoc()):
          ?>
     <div class="modal fade" id="show-<?php echo $data['paluto_id']?>" style="width:100%;">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
              <span>Transaction Number #0101<?php echo $data['paluto_id'];?></span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                
                      <table class="table table-bordered">
                        <tr>
                          <th>Food Name</th>
                          <th>Food Price</th>
                          <th>No. of Person</th>
                          <th>Food Price</th>
                        <tr>
                          <?php 
                            $show_order = $dbcon->query("select * from paluto_order where paluto_transaction_id ='".$data['paluto_id']."'");
                            while($row = $show_order->fetch_assoc()): ?>
                          <tr>
                            <td><?php echo $row['paluto_item_name'];?></td>
                            <td><?php echo number_format($row['paluto_price'],2);?></td>
                            <td><?php echo $row['paluto_pax'];?></td>
                            <td><?php echo number_format($row['paluto_total_price'],2);?></td>
                          </tr>
                          <?php endwhile; ?>
                  
                      </table>
                
              </div>
              <div class="modal-footer">
            <input type="submit" class="btn btn-danger" value="Close" data-dismiss="modal">
            </div>
            </div>
            <!-- /.modal-content -->
            
          </div>
          <!-- /.modal-dialog -->
        </div> 
    <!-- end modal -->  
    <?php endwhile;?>
    <div class="modal fade" id="edit" style="width:100%;">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
              <span>Transaction Number #0101<span id="trans_id"></span></span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                  <div class="row">
                    <div class="col-md-6">
                      <input type="hidden" id="id">
                      <label for="date">Previous Date</label>
                      <input type="text" class="form-control" readonly value="" id="prev_date">
                    </div>
                    <div class="col-md-6">
                      <label for="date">New Date</label>
                      <input type="text" class="date form-control" readonly id="datepicker" >
                      <span id="emptydate" style="color:Red;font-size:8pt"></span>
                    </div>
                  </div>
                     
                
              </div>
              <div class="modal-footer">
              <input type="submit" class="btn btn-primary"  value="Change" id="update">
            <input type="submit" class="btn btn-danger" value="Close" data-dismiss="modal">
            </div>
            </div>
            <!-- /.modal-content -->
            
          </div>
          <!-- /.modal-dialog -->
        </div> 
    <!-- end modal --> 
      
<?php include'../assets/user_footer.php';?>
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable()
    $('#example3').DataTable()
    $( "#datepicker").datepicker({ 
      minDate: '4'

    });

    $("div #change").click(function(){
      var id = $(this).attr('name');
      $("#trans_id").text(id);
      $("#id").val(id);
      $.ajax({
        url:"display_date.php",
        data:"id="+id,
        method:"POST",
        success:function(data){
         $("#prev_date").val(data);
        }
      })
    })

    $("#update").click(function(){
      var id = $("#id").val();
      var date = $("#datepicker").val();
      if(date == ""){
        $("#emptydate").text("Required field");
      }else{
        $.ajax({
          url: "update_date.php",
          data: "id="+id+"&date="+date,
          method:"post",
          success:function(data){
            if(data == "success"){
              alert("Save");
              location.reload();
            }else if(data=="invalid"){
              $("#emptydate").text("Sorry This date is already full");
            }else{
              console.log(data);
            }
          }
        })
      }
    })
  })
    
 

</script>