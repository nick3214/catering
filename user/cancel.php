<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_user'])){
  header("Location: ../index.php");
  exit;
}
if(isset($_POST['save_button'])){
  $user_id = filter($_SESSION['user_id']);
  $tcode = filter($_GET['tcode']);
  $reason = $_POST['reason'];

  $inserQuery = array("user_id"=>$user_id,"tcode"=>$tcode,"reason"=>$reason,"status_type"=>"0");
  $notifSQL = array("n_logs"=>"Customer: ".$_SESSION['full_name']." has requested to cancel his/her event. Trasaction Code ".$tcode." reason: ".$reason."","user_id"=>$_SESSION['user_id']);
  insertdata("notifications",$notifSQL);
  insertdata("cancel_resched",$inserQuery);
  header("location: index.php");
}
$event = single_get("*","tcode","reservations",$_GET['tcode']);
?>

<?php include'../assets/user_header.php';?>
  <!-- Content Wrapper. Contains page content -->
  <div style="height:20px;"></div>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="width:87%; margin: 0 auto;background: white;border-radius:3px;">
    <!-- Main content -->
    <section class="content">


      <div class="row">
       <div class="container">
        
        <div class="box box-info" style="width:97%;">
            <div class="box-header">
              <h4 class="box-title"><i class="fa fa-calendar"></i> Cancel Reservations</h4>
              
            </div>
            <div class="box-body">
<?php
 
//Our "then" date.
$then = $event['event_date'];
 
//Convert it into a timestamp.
$then = strtotime($then);
 
//Get the current timestamp.
$now = time();
 
//Calculate the difference.
$difference = $now - $then;
 
//Convert seconds into days.
$days = floor($difference / (60*60*24) );
 
$total =  abs($days - 1);

 $date = $event['event_date'];
  $date_subtracted = date('Y-m-d', strtotime('-7 days', strtotime($date)));
  
?>
<form method="post">
  <table class="table ">
    <tr>
      <td><b>Transact Code:</b></td>
      <td><?php echo $event['tcode']?></td>
      <td><b>Event Name:</b></td>
      <td><?php echo $event['event_name']?></td>
    </tr>
    <tr>
      <td><b>Date:</b></td>
      <td><?php echo $event['event_date']?></td>
      <td><b>Time:</b></td>
      <td><?php echo date("h:i:sa",strtotime($event['event_time']))?></td>
    </tr>
  </table>
 <?php if(date("Y-m-d") <= $date_subtracted):?>
  <?php 
 $myDate =  strtotime(date("Y-m-d",strtotime($event['event_date']. "+3 days")));
 $dateToday = strtotime(date("Y-m-d"));
  if($myDate > $dateToday):
  ?>

  <strong>Reason:</strong>
  <textarea class="form-control" placeholder="Please enter your reason" name="reason" required="required"></textarea>
  
  <br>
  <center>
 
    <button class="btn btn-primary" name="save_button"><i class="fa fa-save"></i> Submit</button>
<?php endif;?>
<?php else:?>
    <div class="alert alert-danger">You are not allowed to cancel 1 week before the actual reservation.</div>
    <?php endif;?>
    <a href="reservations.php" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a>
  </center>

</form>
            </div>
            
          </div>
          <hr>
          
       </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
<?php include'../assets/admin_footer.php';?>

</body>
</html>

