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
    $ar = array("menu_id"=>$delete);
    $tbl_name = "menu";
    $del = delete($dbcon,$tbl_name,$ar);
    if($del){
      header("location: menu.php");
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
              

              <h4 class="box-title"><i class="fa fa-plus"></i> Menus- </h4> <a href="add-menu.php"><i class="fa fa-plus"></i> Create New</a>
              <p class="alert alert-info"><strong>Instructions:</strong><br> You can create Menu to the system by clicking the create new Menu on top. Ex. Menu w/ Beef, Menu Without Beef</p>
            </div>
            <div class="box-body">
              <div class="box">
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  
                  <th>Name</th>
                  <th>Date Modified</th>
                  <th>Modified By</th>
                  <th>Tools</th>
                </tr>
                </thead>
                <tbody>
          <?php 
          $sql = $dbcon->query("SELECT * FROM menu") or die(mysqli_error());
          ?>

          <?php while($row = $sql->fetch_assoc()):?>
                <tr>
                  
                  <td><?php echo $row['menu_name']?></td>
                  
                  <td><?php echo $row['date_modified']?></td>
                  <td><?php echo $row['last_modified']?></td>
                  <td>
                    <div class="btn-group">
                    <button type="button" class="btn btn-info">Action</button>
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                      <li><a href="add-menu.php?menu_id=<?php echo $row['menu_id']?>">Edit</a></li>
                      <li><a href="#" <?php echo 'onclick=" confirm(\'Are you sure you want to delete?\') 
      ?window.location = \'menu.php?delete='.$row['menu_id'].'\' : \'\';"'; ?>>Delete</a></li>
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
