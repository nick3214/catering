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
?>
<?php include'../assets/user_header.php';?>
  <div style="height:20px;"></div>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="width:87%; margin: 0 auto;background: white;border-radius:3px;padding:20px;">
    <!-- Content Header (Page header) -->
<h4 class="box-title"><i class="fa fa-calendar"></i> Calendar</h4><br>
               <strong>Legends:</strong><br>
              Red when the schedule is full - <div class="label label-danger">RED</div><br>
              Blue when the schedule is not full - <div class="label label-primary">BLUE</div>
              <div id="calendar"></div>
            </div>
            <div class="box-body">
             
            </div>

    <!-- Main content -->
    

      

    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php include'../assets/user_footer.php';?>

