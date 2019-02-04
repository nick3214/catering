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
    $ar = array("id"=>$delete);
    $tbl_name = "motif";
    $del = delete($dbcon,$tbl_name,$ar);
    if($del){
      header("location: motif.php");
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
              

              <h4 class="box-title"><i class="fa fa-list"></i> Motif - </h4> <a href="add-motif.php"><i class="fa fa-plus"></i> Create New</a><br>
            </div>
            <div class="box-body">
              <div class="box">
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Occasion</th>
                  <th>Type</th>
                  <th>Date & time Modified</th>
                  <th>Last Modified</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
          <?php 
          $sql = $dbcon->query("SELECT * FROM motif INNER JOIN occasion on occasion.occasion_id = motif.occasion_id ") or die(mysqli_error());
          
          ?>

          <?php while($row = $sql->fetch_assoc()):?>
                <tr>
                  <td><?php echo $row['motif']?></td>
                  <td><?php echo $row['motif_decs']?></td>
                  <td><?php echo $row['occasion_name']?></td>
                  <td>
                  <?php 
                  if($row['motif_type'] == "0"){
                    echo "Color";
                  }else{
                    echo "Special";
                  }?></td>
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
                      <li><a href="add-motif.php?id=<?php echo $row['id']?>">Edit</a></li>
                      <li><a href="#" <?php echo 'onclick=" confirm(\'Are you sure you want to delete?\') 
      ?window.location = \'motif.php?delete='.$row['id'].'\' : \'\';"'; ?>>Delete</a></li>
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
