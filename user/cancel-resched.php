<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_user'])){
  header("Location: ../index.php");
  exit;
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
              

              <h4 class="box-title"><i class="fa fa-calendar"></i> Waiting Approval Request for Re-Scheduling</h4>
            </div>
            <div class="box-body">
              <div class="table table-responsive">

            <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Code</th>
                  <th>Event Name</th>
                  <th>Date</th>
                  <th>Time</th>
                  <th>Reason</th>
                  <th>Status</th>
                  <th>Tools</th>
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
                  <td><?php echo $result['event_date']?></td>
                  <td><?php echo date("h:i:sa",strtotime($result['event_time']))?></td>
                  <td><?php echo $result['reason']?></td>
                  <td><?php if($result['request_status'] == '0'): echo 'Waiting for Approval';elseif($result['request_status'] == '1'): echo 'Approved for Rescheduling';else: echo 'Rejected for Rescheduling';endif;?>
                  </td>
                  <td>
                    <?php if($result['request_status'] == '0'):?>
                  <div class="btn-group">
                    <button type="button" class="btn btn-info">Action</button>
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
            
          </div>
          <hr>
          <div class="box box-info" style="width:97%;">
            <div class="box-header">
              

              <h4 class="box-title"><i class="fa fa-arrow-left"></i> Approval Request for Cancellation</h4>
            </div>
            <div class="box-body">
              <div class="table table-responsive">

              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Code</th>
                  <th>Event Name</th>
                  <th>Date</th>
                  <th>Time</th>
                  <th>Reason</th>
                  <th>Status</th>
                  <th>Tools</th>
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
                  <td><?php if($row['request_status'] == '0'): echo 'Waiting for Approval';elseif($row['request_status'] == '1'): echo 'Approved for Rescheduling';else: echo 'Rejected for Rescheduling';endif;?>
                  </td>
                  <td>
                  <?php if($row['request_status'] == '0'):?>
                  <div class="btn-group">
                    <button type="button" class="btn btn-info">Action</button>
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

