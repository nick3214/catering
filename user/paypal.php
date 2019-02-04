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
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">


      <div class="row">
       <div class="container">
        
        <div class="box box-info" style="width:97%;">
            <div class="box-body">
             <h4 class="box-title"><i class="fa fa-paypal"></i> Paypal Transactions</h4>
             <hr>
<div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>Transact Code</th>
      
      <th>Event Name</th>
      <th>Date/Time Purchased</th>
      <th>Amount</th>
      <th>Status</th>
    </tr>
  </thead>
<tbody>
<?php $sql = $dbcon->query("SELECT * FROM transactions INNER JOIN reservations on reservations.tcode = transactions.tcode WHERE transactions.user_id = '".$_SESSION['user_id']."'") or die(mysqli_error());?>
<?php while($row = $sql->fetch_assoc()):?>
<tr>
  <td><div class="label label-success"><?php echo $row['tx']?></div></td>
  <td><?php echo $row['event_name']?></td>
  <td><?php echo $row['tdate']?></td>
  <td>&#8369 <?php echo number_format($row['amt'])?></td>
  <td><?php if($row['t_status'] == '0'): echo 'Paid Initial Deposit';else: echo 'Fully Paid';endif;?></td>
  
</tr>
          <?php endwhile;?>          
</table>
</div>
            </div>

            
          </div>
          
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