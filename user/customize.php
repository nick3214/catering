<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_user'])){
  header("Location: ../index.php");
  exit;
}
if(isset($_GET['delete'])){
  $delete = filter($_GET['delete']);
    $ar = array("package_id"=>$delete);
    $tbl_name = "packages";
    $del = delete($dbcon,$tbl_name,$ar);
    if($del){
      header("location: customize.php");
    }
}
$stnd = "STND-".rand(0,999)."";
$kd = "KD-".rand(0,999)."";
$full = "CUSTOM-".rand(0,999)."";
?>

<?php include'../assets/user_header.php';?>
  <!-- Content Wrapper. Contains page content -->
  <div style="height:20px;"></div>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="width:87%; margin: 0 auto;background: white;border-radius:3px;">
    <!-- Main content -->
    <section class="content">


      <div class="row">
       <div class="container">
        
                
        <div style="width:100%;">
            <div>
              
<?php 
$code = mt_rand();
/*
if(isset($_GET['pack_btn'])): $code = mt_rand();if($_GET['pack_type'] == '0'): 
header("location: standard.php?code=".$code."&pack_type=0&stnd=$stnd&custom=Customize-".$code."&package=Package-".$code."");
elseif($_GET['pack_type'] == '1'): 
  header("location: full.php?code=".$code."&pack_type=1&full=$full&custom=Customize-".$code."&package=Package-".$code.""); 
elseif($_GET['pack_type'] == '2'): 
  header("location: kiddie.php?code=".$code."&pack_type=2&kd=$kd&custom=Customize-".$code."&package=Package-".$code.""); 
  endif; 
endif;?>
*/?>
              <h4 class="box-title"><i class="fa fa-plus"></i> Packages - <a href="full.php?code=<?php echo $code;?>&pack_type=1&full=<?php echo $full; ?>&custom=Customize-<?php echo $code;?>&package=Package-<?php echo $code; ?>">Add Custom Package</a> </h4>
              
            </div>
            <div class="box-body">
              <div class="">
            <div class="box-body">
            <div class="table-responsive">
              <table id="example1" class="table table-bordered table-striped table-responsive">
                <thead>
                <tr>
                  <th>Photo</th>
                  <th>Package Name</th>
                  <th>Description</th>
                  <th>Total Price</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
          <?php 
          $sql = $dbcon->query("SELECT * FROM packages WHERE p_user = '".$_SESSION['user_id']."'") or die(mysqli_error());
          ?>
          <?php while($row = $sql->fetch_assoc()):?>
                <tr>
                  <td><img src="../images/photo.jpg" class="img-thumbnail" width="100"></td>
                  <td>
                    Code:<?php echo $row['package_code']?><br>
                    Name:<?php echo $row['package_name'];?><br>
                  </td>
                  
                  <td><?php echo $row['package_desc']?></td>
                  <!--
                  <td><?php echo $row['suggest_total']?></td>
                  <td><?php echo $row['per_head']?></td>
                -->
                  <td>&#8369; <?php echo $row['total_price']?></td>
                  <td>
                    <div class="btn-group">
                    <button type="button" class="btn btn-info">Action</button>
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                      <li>
                        <?php if($row['p_type'] == '0'):?>
                        <a href="standard.php?code=<?php echo $row['code']?>&pack_type=0&edit=1">Edit</a>
                      <?php elseif($row['p_type'] == '1'):?>
                        <a href="full.php?code=<?php echo $row['code']?>&pack_type=1&edit=1">Edit</a>
                      <?php else:?>
                         <a href="kiddie.php?code=<?php echo $row['code']?>&pack_type=2&edit=1">Edit</a>
                      <?php endif;?>
                      </li>
                      <li><a href="#" data-toggle="modal" data-target="#modal-default<?php echo $row['code']?>">View Details</a></li>
                      <li><a href="#" <?php echo 'onclick=" confirm(\'Are you sure you want to delete?\') 
      ?window.location = \'customize.php?delete='.$row['package_id'].'\' : \'\';"'; ?>>Delete</a></li>
                    </ul>
                  </div>
                  </td>
                </tr>
          <!-- Modal Start-->
           <div class="modal fade" id="modal-default<?php echo $row['code']?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php $viewPackage = single_get("*","code","packages",$row['code']);?>
                <h3><?php echo $viewPackage['package_name'];?> - &#8369; <?php echo $viewPackage['total_price']?></h3></h4>
              </div>
              <div class="modal-body">
                
               
                <?php 
                $query = "SELECT * FROM package_extension WHERE code = ".$row['code']." ORDER BY `package_extension`.`package_sync` DESC";
                $fetchEx = getdata_inner_join($query);
                ?>
                <?php if(!empty($fetchEx)):?>
                  <ul>
                <?php foreach ($fetchEx as $key => $value):?>
                  <li><?php echo $value->ex_name?></li>
                <?php endforeach;?>
                  </ul>
              <?php else:?>
                <div class="alert alert-danger">No records on the database.</div>
              <?php endif;?>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
          <!-- End Modal-->
          <?php endwhile;?> 
              </table>
            </div>
          </div>
            <!-- /.box-body -->
          </div>
            </div>
            
          </div>
          <hr>
          
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

