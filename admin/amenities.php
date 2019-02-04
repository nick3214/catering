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
    $ar = array("a_id"=>$delete);
    $tbl_name = "amenities";
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
              

              <h4 class="box-title"><i class="fa fa-list"></i> Other Services - </h4> <a href="add-amenity.php?type=1"><i class="fa fa-plus"></i> Create New</a><br><br>
              <!--
              <a href="amenities.php" class="btn btn-danger">Standard Amenities</a> | <a href="amenities_other.php" class="btn btn-warning">Other Amenities</a> 
            -->
            </div>
            <div class="box-body">
              <div class="box">
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Name</th>
                  <th>Price</th>
                  <th>Date & time Modified</th>
                  <th>Last Modified</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
          <?php 
          $sql = $dbcon->query("SELECT * FROM amenities WHERE a_type = 'other'") or die(mysqli_error());
          ?>

          <?php while($row = $sql->fetch_assoc()):?>
                <tr>
                  <td><?php echo $row['a_name']?></td>
                  <td>&#8369; <?php echo $row['a_price']?></td>
                  <td><?php echo $row['date_modified']?></td>
                  <td><?php echo $row['last_modified']?></td>
                  <td>
                  <div class="btn-group">
                    
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                      <?php if($row['a_price'] == '0'):?>
                      <li><a href="add-amenity.php?a_id=<?php echo $row['a_id']?>&type=0">Edit</a></li>
                      <?php else:?>
                        <li><a href="add-amenity.php?a_id=<?php echo $row['a_id']?>&type=1">Edit</a></li>
                      <?php endif;?>
                      <li><a href="#" <?php echo 'onclick=" confirm(\'Are you sure you want to delete?\') 
      ?window.location = \'amenities.php?delete='.$row['a_id'].'\' : \'\';"'; ?>>Delete</a></li>
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
