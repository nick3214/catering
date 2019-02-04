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
    $ar = array("item_id"=>$delete);
    $tbl_name = "food_items";
    $del = delete($dbcon,$tbl_name,$ar);
    if($del){
      header("location: food_items.php");
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
              

              <h4 class="box-title"><i class="fa fa-plus"></i> Food Items- </h4> <a href="add-item.php"><i class="fa fa-plus"></i> Create New</a><br><br>
            </div>
            <div class="box-body">
              <div class="box">
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Image</th>
                  <th>Code</th>
                  <th>Name</th>
                  <th>Category</th>
                  <th>Sub Category</th>
                  <th>Meal type</th>
                  <th>Cost per Head</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
          <?php 
          $sql = $dbcon->query("SELECT *,food_items.itm_image as IMG FROM food_items 
            INNER JOIN food_categories on food_categories.f_id = food_items.item_category
            INNER JOIN sub_category on sub_category.sub_id = food_items.sub_category") or die(mysqli_error());
          ?>
          <?php while($row = $sql->fetch_assoc()):?>
                <tr>
                  <td>
                    <img src="../images/<?php echo $row['IMG']?>" width="150" class="img img-thumbnail">
                  </td>
                  <td>Code: <?php echo $row['item_code']?>
                </td>
                  <td><?php echo $row['item_name']?></td>
                  <td>
                    <?php echo $row['f_name']?>
                      
                  </td>
                  <td>
                    <?php echo $row['sub_name']?>
                      
                  </td>
                  <td><?php 
                    if($row['menu_type'] == 0){
                      echo "Breakfast";
                    }else{
                      echo "Dinner / Lunch";
                    }
                  ?></td>
                  <td>&#8369; <?php echo $row['cost_per_head']?></td>
                  <td>
                    <div class="btn-group">
                   
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                      <li><a href="add-item.php?item_id=<?php echo $row['item_id']?>">Edit</a></li>
                      <li><a href="#" <?php echo 'onclick=" confirm(\'Are you sure you want to delete?\') 
      ?window.location = \'food_items.php?delete='.$row['item_id'].'\' : \'\';"'; ?>>Delete</a></li>
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
