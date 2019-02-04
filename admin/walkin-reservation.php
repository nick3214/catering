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
$stnd = "STND-".rand(0,999)."";
$kd = "KD-".rand(0,999)."";
$full = "FULL-".rand(0,999)."";
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
              

              <h4 class="box-title"><i class="fa fa-calendar"></i> Walkin Reservation</h4>
            </div>
            <div class="box-body">
              <div class="box">
            <div class="box-body">
<?php 
if(isset($_GET['pack_btn'])): 
  $code = mt_rand();
if($_GET['pack_type'] == '0'): 
header("location: standard-customization.php?code=".$code."&pack_type=0&stnd=$stnd&custom=Customize-".$code."&package=Package-".$code."");
elseif($_GET['pack_type'] == '1'): 
  header("location: full-customization.php?code=".$code."&pack_type=1&full=$full&custom=Customize-".$code."&package=Package-".$code.""); 
elseif($_GET['pack_type'] == '2'): 
  header("location: kiddie-customization.php?code=".$code."&pack_type=2&kd=$kd&custom=Customize-".$code."&package=Package-".$code.""); 
  endif; 
endif;?>
              <form method="get">
                <select style="width:70.5%;height:33px;" name="pack_type">
                  <option value="0">Standard Package</option>
                  <option value="1">Full Package</option>
                  <option value="2">Kiddie Package</option>
                </select>
                <button class="btn btn-danger" name="pack_btn"><i class="fa fa-plus"></i> Create Customization</button>
                <a href="reservation-package.php" class="btn btn-info"><i class="fa fa-plus"></i> Add Reservation</a>
              </form>
<br>
<table id="example1" class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>Code</th>
      
      <th>Event Name</th>
      <th>Date/Time</th>
      <th>Status</th>
      <th>Date Time Created</th>
      <th>Tools</th>
    </tr>
  </thead>
<tbody>
<?php $sql = $dbcon->query("SELECT * FROM `reservations` WHERE reservation_type = '1' AND reservation_status != 'Draft' ORDER BY `reservations`.`r_id` DESC") or die(mysqli_error());?>
<?php while($row = $sql->fetch_assoc()):?>
<tr>
  <td><?php echo $row['tcode']?></td>
  <td><?php echo $row['event_name']?></td>
  <td><?php echo $row['event_date']?>/ <?php echo date("h:i:s a",strtotime($row['event_time']));?></td>
  <td><?php echo $row['reservation_status']?></td>
  <td><?php echo $row['date_created']?></td>
  <td>
      <div class="btn-group">
      <button type="button" class="btn btn-info">View</button>
      <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
          <span class="caret"></span>
          <span class="sr-only">Toggle Dropdown</span>
      </button>
      <ul class="dropdown-menu" role="menu">
      <?php if($row['reservation_status'] == 'Draft'):?>
        <li><a href="#" <?php echo 'onclick=" confirm(\'Are you sure you want to delete?\') 
      ?window.location = \'online-reservation.php?delete='.$row['tcode'].'\' : \'\';"'; ?>>Delete</a></li>
    <?php elseif($row['reservation_status'] == 'Fully Paid'):?>
        <li><a href="view-details.php?tcode=<?php echo $row['tcode']?>">Print Billing Statement</a></li>
        <li><a href="../contract.php?tcode=<?php echo $row['tcode']?>&type=walkin" target="_blank">Print Contract</a></li>
      <?php endif;?>
        <li><a href="other-reservation.php?tcode=<?php echo $row['tcode']?>&tab=1&stat=walkin">View Full Details</a></li>
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
