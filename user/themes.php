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
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    

    <!-- Main content -->
    <section class="content">
      <div class="row">
       <div class="container">
        
        
          <div class="box box-info" style="width:97%;">
            <div class="box-header">
              <h4><i class="fa fa-plus"></i> Themes</h4>
<div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Image</th>
                  <th>Name</th>
                  <th>Price</th>
                  <th>Date Modified</th>
                  
                  <th>Modified By</th>
                 
                </tr>
                </thead>
                <tbody>
          <?php 
          $sql = $dbcon->query("SELECT * FROM themes") or die(mysqli_error());
          ?>

          <?php while($row = $sql->fetch_assoc()):?>
                <tr>
                  <td><img src="../images/<?php echo $row['theme_img']?>" width="150" class="img img-thumbnail"></td>
                  <td><?php echo $row['theme_name']?></td>
                  <td><?php echo number_format($row['theme_price'])?></td>
                  <td><?php echo $row['date_modified']?></td>
                  <td><?php echo $row['last_modified']?></td>
                  
                </tr>
          <?php endwhile;?> 
                     
              </table>
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