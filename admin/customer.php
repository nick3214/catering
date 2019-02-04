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
      header("location: amenities.php");
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
              

              <h4 class="box-title"><i class="fa fa-users"></i> Customer List</h4>
            </div>
            <div class="box-body">
              <div class="box">
            <div class="box-body">
    <div class="table table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Full Name</th>
                  <th>Email</th>
                  <th>Contact</th>
                  <th>Gender</th>
                  <th>Type</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
          <?php 
          $sql = $dbcon->query("SELECT * FROM user_account WHERE user_role = '1'") or die(mysqli_error());
          if(mysqli_num_rows($sql) == 0){
            echo 'No records on the database.';
          }else{
          ?>

          <?php while($row = $sql->fetch_assoc()):?>
                <tr>
                  <td><?php echo $row['full_name']?></td>
                  <td><?php echo $row['user_email']?></td>
                  <td><?php echo $row['contact_num']?></td>
                  <td><?php echo $row['gender']?></td>
                  <td>
                    <?php 
                    $f = $dbcon->query("SELECT * FROM reservations WHERE user_id = '".$row['user_id']."' AND reservation_status != 'Draft'") or die(mysqli_error());
                    $count = mysqli_num_rows($f);
                    if($count <= 2){
                      echo 'New Customer';
                    }elseif($count >= 3){
                      echo 'Regular Customer';
                    }
                    ?>
                  </td>
                  
                  <td>
                    <a href="#" <?php echo 'onclick=" confirm(\'Are you sure you want to delete?\') 
      ?window.location = \'customer.php?delete='.$row['user_id'].'\' : \'\';"'; ?>><i class="fa fa-remove"></i></a>
                  </td>
                </tr>
          <?php endwhile;?> 
          <?php }?>              
              </table>
            </div>
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
