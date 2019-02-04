<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_admin'])){
  header("Location: ../index.php");
  exit;
}
if(isset($_GET['delete'])){
  $delete = filter($_GET['delete']);
    $ar = array("tcode"=>$delete);
    $tbl_name = "reservations";
    $del = delete($dbcon,$tbl_name,$ar);
    if($del){
      header("location: online-reservation.php");
    }
}
?>
<?php include'../assets/admin_header.php';?>
<?php include'../assets/admin_sidebar.php';?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content">
      <div class="row">
       <div class="container">
        
        <div class="box box-info" style="width:95.5%;">
            <div class="box-header">
              

              <h4 class="box-title"><i class="fa fa-calendar"></i> Online Reservation</h4>
            </div>
            <div class="box-body">
              <div class="box">
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>Date/Time</th>
      <th>Transact Code</th>
      <th>Customer Name</th>
      <th>Event Name</th>
      
      <th>Status</th>
      <th>Action</th>
    </tr>
  </thead>
<tbody>
<?php $sql = $dbcon->query("SELECT * FROM `reservations` INNER JOIN user_account on user_account.user_id = reservations.user_id WHERE reservation_type = '0' AND reservation_status != 'Draft' ORDER BY `reservations`.`r_id` DESC") or die(mysqli_error());?>
<?php while($row = $sql->fetch_assoc()):?>
<tr>
  <td><?php echo $row['event_date']?>/ <?php echo date("h:i:s a",strtotime($row['event_time']));?></td>
  <td><?php echo $row['tcode']?></td>
  <td><?php echo $row['full_name']?></td>
  <td><?php echo $row['event_name']?></td>
  
  <td><?php echo $row['reservation_status']?></td>
  <td>
      <div class="btn-group">
      <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
          <span class="caret"></span>
          <span class="sr-only">Toggle Dropdown</span>
      </button>
      <ul class="dropdown-menu" role="menu">
      <?php if($row['reservation_status'] == 'Draft'):?>
        <li><a href="#" <?php echo 'onclick=" confirm(\'Are you sure you want to delete?\') 
      ?window.location = \'online-reservation.php?delete='.$row['tcode'].'\' : \'\';"'; ?>>Delete</a></li>
      <?php elseif($row['reservation_status'] == 'Full Paid' OR $row['reservation_status'] == 'Paid Initially'):?>
        <li><a href="view-details.php?tcode=<?php echo $row['tcode']?>">Billing Statement</a></li>
      
      <?php endif;?>
        
        <li><a href="other-reservation.php?tcode=<?php echo $row['tcode']?>&tab=1&stat=online">View Full Details</a></li>
      </ul>
      </div>
  </td>
</tr>
          <?php endwhile;?>          
</table>
            </div>
            <!-- /.box-body -->
          </div>
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
