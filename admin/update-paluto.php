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
    $ar = array("user_id"=>$delete);
    $tbl_name = "user_account";
    $del = delete($dbcon,$tbl_name,$ar);
    if($del){
      header("location: staff.php");
    }
}
if(isset($_POST['update_btn'])){
  $pr_status = filter($_POST['pr_status']);
  $total_paid = filter($_POST['total_paid']);

  $arr_where = array("pr_code"=>$pr_code);//update where
  $arr_set = array("total_paid"=>$total_paid, "pr_status" => $pr_status);//set update
  $tbl_name = "paluto_reservation";
  $update = update($dbcon,$tbl_name,$arr_set,$arr_where);// UPDATE SQL
   header("location: paluto.php");
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
                  <th>Paluto Details</th>
                  <th>Total Price / Status</th>
                  <th>Tools</th>
                </tr>
                </thead>
                <tbody>
          <?php 
          $sql = $dbcon->query("SELECT * FROM paluto_reservation 
            INNER JOIN user_account on user_account.user_id = paluto_reservation.user_id
            GROUP BY pr_code") or die(mysqli_error());
          ?>

          <?php while($row = $sql->fetch_assoc()):?>
                <tr>
                  <td><h4><?php echo $row['pr_code']?></h4></td>
                  <td>
                    <strong>Name: </strong><?php echo $row['full_name']?><br>
                    <strong>Email: </strong><?php echo $row['user_email']?><br>
                    <strong>Contact Number: </strong><?php echo $row['contact_num']?><br>
                    <strong>Address: </strong><?php echo $row['delivery_address']?>
                  </td>
                  <td>
                    <?php 
                    $sql = $dbcon->query("SELECT * FROM paluto_reservation 
                      INNER JOIN user_account on user_account.user_id = paluto_reservation.user_id
                      WHERE pr_code = '".$row['pr_code']."'") or die(mysqli_error());
                    while($h = $sql->fetch_assoc()){
                    ?>
                    <?php echo $h['pr_name']?>,
                  <?php }?>
                  </td>
                  <td>
                    <?php 
                    $j = $dbcon->query("SELECT SUM(pr_price * pr_person) as total FROM paluto_reservation WHERE pr_code = '".$row['pr_code']."'") or die(mysqli_error());
                    $fetch = $j->fetch_assoc();
                    echo "<strong>".$fetch['total']."</strong>";
                    ?>
                    <br>
                    <strong>Status:</strong> <?php echo $row['pr_status']?>
                  </td>
                  <td>
                  <div class="btn-group">
                    <button type="button" class="btn btn-info">Action</button>
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="" data-toggle="modal" data-target="#update-order<?php echo $row['pr_code']?>">Update Status</a></li>
                    </ul>
                  </div>
                  </td>
                </tr>

                  <!-- modal -->
     <div class="modal fade" id="update-order<?php echo $row['pr_code']?>" style="width:100%;">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
              <form method="post">
                <?php if($row['pr_status'] == 'Pending'):?>
                  <input type="number" name="total_paid" value="0">
                  <select class="form-control" name="pr_status">
                    <option>For Delivery</option>
                  </select>
                <br>
                <?php elseif($row['pr_status'] == 'For Delivery'):?>
                  <input type="number" name="total_paid">
                  <select class="form-control" name="pr_status">
                    <option>Done Transaction</option>
                  </select>
                <?php endif;?>
                <button class="btn btn-primary" name="update_btn">Update</button>
              </form>
              
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div> 
    <!-- end modal -->

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
      'autoWidth'   : true
    })
  })
</script>
</body>
</html>
