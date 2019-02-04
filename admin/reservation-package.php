<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_admin'])){
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
?>
<?php include'../assets/admin_header.php';?>
<?php include'../assets/admin_sidebar.php';?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content">
      <div class="row">
       <div class="container">
        
        <div class="box box-info" style="width:97%;">
            <div class="box-header">
              

              <h4 class="box-title"><i class="fa fa-arrow-right"></i> Step 1: CHOOSE PACKAGE</h4>
            </div>
            <hr>
            <div class="box-body">
<div class="container">
              <h4>Standard Package</h4>
            <?php if(!empty($stnd)):?>
            <?php foreach ($stnd as $key => $stnds):?>
              <div class="col-md-3">
                <div class="box box-primary">
            <div class="box-header with-border" style="background: #3c8dbc;color:white;">
              <center><h3 class="box-title"><?php echo $stnds->package_name?></h3></center>
            </div>
            <br>
            <img src="../images/<?php echo $stnds->package_photo?>" class="img-thumbnail"><br><br>
            <center> 
            <a href="" data-toggle="modal" data-target="#modal-default<?php echo $stnds->code?>" class="btn btn-warning"><i class="fa fa-file"></i> See Package</a>
            </center><br>
          </div>

              </div>
          <div class="modal fade" id="modal-default<?php echo $stnds->code?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Step 2: Select A Package</h4>
              </div>
              <div class="modal-body">
                 <img src="../images/<?php echo $stnds->package_photo?>" class="img-thumbnail"><br><br>
                <?php $viewPackage = single_get("*","code","packages",$stnds->code);?>
                <h3><?php echo $viewPackage['package_name'];?> - &#8369; <?php echo $viewPackage['total_price']?></h3>
                <?php if($viewPackage['no_person'] == '0'):?>
                  Min. of <?php echo $viewPackage['no_adults']?> pax-adults & <?php echo $viewPackage['no_kids']?>pax-kids
                <?php else:?>
                <h4>Minimum of <?php echo $viewPackage['no_person']?> pax</h4>
              <?php endif;?>
                <?php 
                $query = "SELECT * FROM package_extension WHERE code = ".$stnds->code." ORDER BY `package_extension`.`package_sync` DESC";
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
                <a href="add-walkin.php?code=<?php echo $value->code?>&package_name=<?php echo $viewPackage['package_name']?>" class="btn btn-primary">Choose Package</a>
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
        <hr>
<div class="container">
        <h4>Full Package</h4>
        <?php if(!empty($full)):?>
            <?php foreach ($full as $key => $fulls):?>
              <div class="col-md-3">
                <div class="box box-primary">
            <div class="box-header with-border" style="background: #3c8dbc;color:white;">
              <center><h3 class="box-title"><?php echo $fulls->package_name?></h3></center>
            </div>
            <br>
            <img src="../images/<?php echo $fulls->package_photo?>" class="img-thumbnail"><br><br>
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
                <h3><?php echo $viewPackage['package_name'];?> - &#8369; <?php echo $viewPackage['total_price']?></h3>
                <?php if($viewPackage['no_person'] == '0'):?>
                  Min. of <?php echo $viewPackage['no_adults']?> pax-adults & <?php echo $viewPackage['no_kids']?>pax-kids
                <?php else:?>
                <h4>Minimum of <?php echo $viewPackage['no_person']?> pax</h4>
              <?php endif;?>
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
                <a href="add-walkin.php?code=<?php echo $value->code?>&package_name=<?php echo $viewPackage['package_name']?>" class="btn btn-primary">Choose Package</a>
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
        <h4>Kiddie Package</h4>
        <?php if(!empty($kiddie)):?>
            <?php foreach ($kiddie as $key => $kiddies):?>
              <div class="col-md-3">
                <div class="box box-primary">
            <div class="box-header with-border" style="background: #3c8dbc;color:white;">
              <center><h3 class="box-title"><?php echo $kiddies->package_name?></h3></center>
            </div>
            <br>
            <img src="../images/<?php echo $kiddies->package_photo?>" class="img-thumbnail"><br><br>
            <center> 
            <a href="" data-toggle="modal" data-target="#modal-kiddie<?php echo $kiddies->code?>" class="btn btn-warning"><i class="fa fa-file"></i> See Package</a>
            </center><br>
          </div>

              </div>
          <div class="modal fade" id="modal-kiddie<?php echo $kiddies->code?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Step 2: Select A Package</h4>
              </div>
              <div class="modal-body">
                 <img src="../images/<?php echo $kiddies->package_photo?>" class="img-thumbnail"><br><br>
                <?php $viewPackage = single_get("*","code","packages",$kiddies->code);?>
                <h3><?php echo $viewPackage['package_name'];?> - &#8369; <?php echo $viewPackage['total_price']?></h3>
                <?php if($viewPackage['no_person'] == '0'):?>
                  Min. of <?php echo $viewPackage['no_adults']?> pax-adults & <?php echo $viewPackage['no_kids']?>pax-kids
                <?php else:?>
                <h4>Minimum of <?php echo $viewPackage['no_person']?> pax</h4>
              <?php endif;?>
                <?php 
                $query = "SELECT * FROM package_extension WHERE code = ".$kiddies->code." ORDER BY `package_extension`.`package_sync` DESC";
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
                <a href="add-walkin.php?code=<?php echo $value->code?>&package_name=<?php echo $viewPackage['package_name']?>" class="btn btn-primary">Choose Package</a>
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

          <hr>
          
       </div>
      </div>
          
       </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php include'../assets/admin_footer.php';?>

</body>
</html>
