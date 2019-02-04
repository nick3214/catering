<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_user'])){
  header("Location: ../index.php");
  exit;
}
$packageQuery = "SELECT * FROM packages WHERE p_user = '2' OR p_user = '".$_SESSION['user_id']."'";
$package = getdata_inner_join($packageQuery);
 
  $query = "SELECT * FROM packages WHERE p_type = '0' AND custom_user='0'";
  $stnd = getdata_inner_join($query);

  $fullQuery = "SELECT * FROM packages WHERE p_type = '1' AND custom_user='0'";
  $full = getdata_inner_join($fullQuery);

  $kiddieQuery = "SELECT * FROM packages WHERE p_type = '2' AND custom_user='0'";
  $kiddie = getdata_inner_join($kiddieQuery);

  $customQuery = "SELECT * FROM packages WHERE p_user = '".$_SESSION['user_id']."'";
  $custom = getdata_inner_join($customQuery);
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
        
        <div class="box box-info">
            <div class="box-header">
              

              <h4 class="box-title"><i class="fa fa-arrow-right"></i> Step 1: CHOOSE PACKAGE</h4>
            </div>
            <hr>
            <div class="box-body">
<div class="container">
          <div class="container">
        <h4>Packages</h4>
        <?php if(!empty($full)):?>
            <?php foreach ($full as $key => $fulls):?>
              <div class="col-md-3">
                <div class="box box-primary">
            <div class="box-header with-border" style="background: #3c8dbc;color:white;">
              <center><h3 class="box-title"><?php echo $fulls->package_name?></h3></center>
            </div>
            <br>
            <img src="../images/<?php echo $fulls->package_photo?>" class="img-thumbnail"><br>
            <?php $viewPackage = single_get("*","code","packages",$fulls->code);?>
                <h4>
                  <center>&#8369; <?php echo $viewPackage['total_price']?> per head
                  </center>
                </h4>

            <center> 
            <a href="" data-toggle="modal" data-target="#modal-full<?php echo $fulls->code?>" class="btn btn-warning"><i class="fa fa-file"></i> See Package</a>
            </center><br>
          </div>

              </div>
          <div class="modal fade" id="modal-full<?php echo $fulls->code?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Step 2: Select A Package</h4>
              </div>
              <div class="modal-body">
                 <img src="../images/<?php echo $fulls->package_photo?>" class="img-thumbnail"><br><br>
                <?php $viewPackage = single_get("*","code","packages",$fulls->code);?>
                <h3><?php echo $viewPackage['package_name'];?> - &#8369; <?php echo $viewPackage['total_price']?> per head</h3>
                
                <?php 
                $query = "SELECT * FROM package_extension WHERE code = ".$fulls->code." ORDER BY `package_extension`.`package_sync` DESC";
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
                <a href="add-reservation.php?code=<?php echo $value->code?>&package_name=<?php echo $viewPackage['package_name']?>" class="btn btn-primary">Choose Package</a>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
           
            <?php endforeach;?>
          <?php else:?>
            <div class="alert alert-danger">There are no records on the database.</div>
          <?php endif;?>

          </div>
          <div class="container">
        

          </div>
          <div class="container">
        <h4>Custom Package</h4>
        <?php if(!empty($custom)):?>
            <?php foreach ($custom as $key => $customs):?>
              <div class="col-md-3">
                <div class="box box-primary">
            <div class="box-header with-border" style="background: #3c8dbc;color:white;">
              <center><h3 class="box-title"><?php echo $customs->package_name?></h3></center>
            </div>
            <br>
            <img src="../images/<?php echo $customs->package_photo?>" class="img-thumbnail"><br><br>
            <center> 
            <a href="" data-toggle="modal" data-target="#modal-custom<?php echo $customs->code?>" class="btn btn-warning"><i class="fa fa-file"></i> See Package</a>
            </center><br>
          </div>

              </div>
          <div class="modal fade" id="modal-custom<?php echo $customs->code?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Step 2: Select A Package</h4>
              </div>
              <div class="modal-body">
                 <img src="../images/<?php echo $customs->package_photo?>" class="img-thumbnail"><br><br>
                <?php $viewPackage = single_get("*","code","packages",$customs->code);?>
                <h3><?php echo $viewPackage['package_name'];?> - &#8369; <?php echo $viewPackage['total_price']?> per head</h3>
                
                <?php 
                $query = "SELECT * FROM package_extension WHERE code = ".$customs->code." ORDER BY `package_extension`.`package_sync` DESC";
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
                <a href="add-reservation.php?code=<?php echo $value->code?>&package_name=<?php echo $viewPackage['package_name']?>" class="btn btn-primary">Choose Package</a>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
           
            <?php endforeach;?>
          <?php else:?>
            <div class="alert alert-danger" style="width:90%;">There are no records on the database.</div>
          <?php endif;?>

          </div>
          
       </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php include'../assets/user_footer.php';?>