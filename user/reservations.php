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
    $ar = array("tcode"=>$delete);
    $reservationTBL = "reservations";
    $othersTBL = "reservation_others";
    
    $del = delete($dbcon,$reservationTBL,$ar);
    $delOthers = delete($dbcon,$othersTBL,$ar);
    
    if($del){
      header("location: amenities.php");
    }
}
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
              

              <h4 class="box-title"><i class="fa fa-calendar"></i> Reservations</h4>
            </div>
            <div class="box-body">
            <a href="reservation-package.php" class="btn btn-info"><i class="fa fa-plus"></i> Add Reservations</a>
<hr>
<div>
<table id="example1" class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>Date Time Created</th>
      <th>Transact Code</th>
      <th>Event Name</th>
      <th>Date/Time</th>
      <th>Status</th>
      
      <th>Action</th>
    </tr>
  </thead>
<tbody>
<?php $sql = $dbcon->query("SELECT * FROM reservations WHERE user_id = '".$_SESSION['user_id']."'") or die(mysqli_error());?>
<?php while($row = $sql->fetch_assoc()):?>
<tr>
  <td><?php echo $row['date_created']?></td>
  <td><?php echo $row['tcode']?></td>
  <td><?php echo $row['event_name']?></td>
  <td><?php echo $row['event_date']?>/ <?php echo date("h:i:s a",strtotime($row['event_time']))?></td>
  <td><?php echo $row['reservation_status']?></td>
  
  <td>
      <div class="btn-group">
      <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
          <span class="caret"></span>
          <span class="sr-only">Toggle Dropdown</span>
      </button>
      <ul class="dropdown-menu" role="menu">
      <?php if($row['reservation_status'] != 'Draft' AND $row['reservation_status'] != 'Cancel'):?>
        <li><a href="cancel.php?tcode=<?php echo $row['tcode']?>">Cancel</a></li>
          <li><a href="resched.php?tcode=<?php echo $row['tcode']?>">Re-Schedule</a></li>
         
          <li><a href="view-details.php?tcode=<?php echo $row['tcode']?>">Print Billing Statement</a></li>
          <li><a href="official-receipt.php?tcode=<?php echo $row['tcode']?>" target="_blank">Official Receipt</a></li>
           <!--
          <li><a href="../contract.php?tcode=<?php echo $row['tcode']?>&type=online" target="_blank">Print Contract</a></li>
          -->
          
      <?php endif;?>

        <li><a href="other-reservation.php?tcode=<?php echo $row['tcode']?>&tab=1">View Full Details</a></li>
      </ul>
      </div>
  </td>
</tr>
          <?php endwhile;?>          
</table>
</div>

            </div>
            
          </div>
          <hr>
          
       </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
<?php include'../assets/user_footer.php';?>
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
</body>
</html>

