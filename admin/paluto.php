<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_admin'])){
  header("Location: ../index.php");
  exit;
}
if(isset($_GET['approve'])){
  $update_status = $dbcon->query("update paluto_transaction set paluto_status =2 where paluto_id ='".$_GET['approve']."'");
  if($update_status){
    echo "<script>alert('Accept Transaction');</script>";
  }else{
    echo "<script>alert('Error Transaction');</script>";
  }
}
if(isset($_GET['reject'])){
  $update_status = $dbcon->query("update paluto_transaction set paluto_status =1 where paluto_id ='".$_GET['reject']."'");
  if($update_status){
    echo "<script>alert('Reject Transaction');</script>";
  }else{
    echo "<script>alert('Error Transaction');</script>";
  }
}

?>
<style>
  table tr td{
    text-align:center;
    font-size:8pt;
  }
</style>
<?php include'../assets/admin_header.php';?>
<?php include'../assets/admin_sidebar.php';?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content">
      <div class="row">
       <div class="container">
        
        <div class="box box-info" style="width:95.5%;">
            <div class="box-header">
              

              <h4 class="box-title"><i class="fa fa-list"></i> Paluto</h4>
             
            </div>
            <div class="box-body">
              <div class="box">
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Transaction #</th>
                  <th>Customer Details</th>
                  <th>Date Reserved</th>
                  <th>Paluto Details</th>
                  <th>Total Price / Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
          <?php 
          $sql = $dbcon->query("SELECT * FROM paluto_transaction 
            INNER JOIN user_account on user_account.user_email = paluto_transaction.paluto_name
           ") or die(mysqli_error());
          ?>

          <?php while($row = $sql->fetch_assoc()):?>
                <tr>
                  <td><h4>#0101<?php echo $row['paluto_id']?></h4></td>
                  <td>
                    <strong>Name: </strong><?php echo $row['full_name']?><br>
                    <strong>Email: </strong><?php echo $row['user_email']?><br>
                    <strong>Contact Number: </strong><?php echo $row['contact_num']?><br>
                   
                  </td>
                  <td><?php echo $row['paluto_date'];?></td>
                  <td>
                   
                  <br>
                  <strong>Type:</strong>
                    <?php if($row['paluto_method'] == 'meal'): echo 'Food Order'; else: echo 'Customize Order'; endif;?>
                  </td>
                  <td>
                    <br>
                    <strong>Status:</strong> 
                    <?php 
                    if($row['paluto_status'] == 0){
                      echo "<span style='color:blue'>Pending</span>";
                    }else if($row['paluto_status'] == 1){
                      echo "<span style='color:red'>Reject</span>";
                    }else if($row['paluto_status'] == 3){
                      echo "<span style='color:red'>Cancel</span>";
                    }else{
                      echo "<span style='color:green'>Approve</span>";
                    }
                    ?>
                  </td>
                  <td>
                  <div class="btn-group">
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu"style="margin-left:-100px">
                    <?php
                    if($row['paluto_status'] == 0){ ?>
                    <li><a href="paluto.php?approve=<?php echo $row['paluto_id']?>">Approve</a></li>
                    <li><a href="paluto.php?reject=<?php echo $row['paluto_id']?>">Reject</a></li>
                    <?php }?>
                    <li><a href="#" data-toggle="modal" data-target="#update-order<?php echo $row['paluto_id']?>">View Order</a></li>
               
                    </ul>
                  </div>
                  </td>
                </tr>
                 <!-- modal -->

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
  <?php 
        $show_transaction = $dbcon->query("select * from paluto_transaction");
        while($data = $show_transaction->fetch_assoc()):
          ?>
     <div class="modal fade" id="update-order<?php echo $data['paluto_id']?>" style="width:100%;">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
              <span>#0101<?php echo $data['paluto_id'];?></span>
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
                          <tr>
                            <td>&nbsp;</td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td>Deliver Type:</td>
                            <td> <?php if($data['paluto_method'] == 'pickup'): echo 'Pick Up'; else: echo 'Delivery'; endif;?></td> </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td>Total Food Price:</td>
                            <td><?php 
                                $sum = $dbcon->query("select sum(paluto_total_price) as total from paluto_order where paluto_transaction_id ='".$data['paluto_id']."'");
                                $total = $sum->fetch_object();
                                echo "&#8369; ". number_format($total->total,2);
                            ?></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td>Deliver Cost:</td>
                            <td> <?php if($data['paluto_method'] == 'pickup'): echo '&#8369; 0'; else: echo '&#8369; 200'; endif;?></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td>Total Price:<br>
                              <span style="font-size:8pt;color:red">(Vat incl.)</span>
                            </td>
                            <td> <?php echo  "&#8369; ". number_format($data['paluto_total_price'],2); ?></td>
                          </tr>
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
      'autoWidth'   : true
    })
  })
</script>
</body>
</html>
