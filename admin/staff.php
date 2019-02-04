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
              

              <h4 class="box-title"><i class="fa fa-users"></i> Staff - </h4> <a href="add-staff.php"><i class="fa fa-plus"></i> Create New</a>
             
            </div>
            <div class="box-body">
              <div class="box">
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Full Name</th>
                  <th>Email</th>
                  <th>Contact Number</th>
                  <th>User Role</th>
                  <th>Tools</th>
                </tr>
                </thead>
                <tbody>
          <?php 
          $sql = $dbcon->query("SELECT * FROM user_account WHERE user_role = '0'") or die(mysqli_error());
          ?>

          <?php while($row = $sql->fetch_assoc()):?>
                <tr>
                  <td><?php echo $row['full_name']?></td>
                  <td><?php echo $row['user_email']?></td>
                  <td><?php echo $row['contact_num']?></td>
                  <td>Administrator</td>
                  <td>
                  <div class="btn-group">
                    <button type="button" class="btn btn-info">Action</button>
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="add-staff.php?user_id=<?php echo $row['user_id']?>">Edit</a></li>
                      <li><a href="#" <?php echo 'onclick=" confirm(\'Are you sure you want to delete?\') 
      ?window.location = \'staff.php?delete='.$row['user_id'].'\' : \'\';"'; ?>>Delete</a></li>
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
      'autoWidth'   : true
    })
  })
</script>
</body>
</html>
