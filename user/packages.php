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
  <div style="height:20px;"></div>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="width:87%; margin: 0 auto;background: white;border-radius:3px;">
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->


      <div class="row">
       <div class="container">
          <div class="box box-info" style="width:97%;">
            <div class="box-header">
              <h3 class="box-title"><i class="fa fa-list"></i> List of Packages</h3>
            </div>
            <div class="box-body">
              <div class="row" style="margin:1px;">
              <h4>STANDARD PACKAGE</h4><hr>
              <!--Start -->
              <?php 
              $query = "SELECT * FROM packages WHERE p_type = '0' AND custom_user='0'";
              $stnd = getdata_inner_join($query);
              ?>
              <?php if(!empty($stnd)):?>
              <?php foreach ($stnd as $key =>$stnds):?>
                
                 <div class="col-md-3 package" >
                  <div class="box box-danger" style="width:97%;">
                    <div class="box-header">
                      <center><img src="../images/<?php echo $stnds->package_photo?>" class="img-thumbnail" width="500" height="100"></center>
                      <center><?php echo $stnds->package_name?> - &#8369; <?php echo $stnds->total_price?>
<a href="" class="btn btn-info" data-toggle="modal" data-target="#modal-default<?php echo $stnds->code?>" ><i class="fa fa-file"></i> View Full Details</a></center>
 <div class="modal fade" id="modal-default<?php echo $stnds->code?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
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
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
                
                </div>
              </div>
            </div>
              <?php endforeach;?>
              <?php else:?>
                <div class="alert alert-danger">No records on the database.</div>
              <?php endif;?>
            </div>
            <div class="row" style="margin:1px;">
              <!-- End-->
              <h4>FULL PACKAGE</h4><hr>
              <!-- Start-->
              <?php 
              $query = "SELECT * FROM packages WHERE p_type = '1' AND custom_user='0'";
              $full = getdata_inner_join($query);?>
              
              <?php if(!empty($full)):?>
              <?php foreach ($full as $key =>$fulls):?>
                <div class="col-md-3 package" >
                  <div class="box box-danger" style="width:97%;">
                    <div class="box-header">
                      <center><img src="../images/<?php echo $fulls->package_photo?>" class="img-thumbnail" width="500" height="100"></center>
                      <center><?php echo $fulls->package_name?> - &#8369; <?php echo $fulls->total_price?>
                  <a href="" class="btn btn-info" data-toggle="modal" data-target="#modal-full<?php echo $fulls->code?>" ><i class="fa fa-file"></i> View Full Details</a></center>
 <div class="modal fade" id="modal-full<?php echo $fulls->code?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
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
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
                      
                
                </div>
              </div>
            </div>
              <?php endforeach;?>
              <?php else:?>
                <div class="alert alert-danger">No records on the database.</div>
              <?php endif;?>
            </div>
              <!-- End-->
              <h4>KIDDIE PACKAGE</h4><hr>
              <!-- Start -->
              <?php 
              $query = "SELECT * FROM packages WHERE p_type = '2' AND custom_user='0'";
              $kiddie = getdata_inner_join($query);?>
              
              <?php if(!empty($kiddie)):?>
              <?php foreach ($kiddie as $key =>$kiddies):?>
                 <div class="col-md-3 package" >
                  <div class="box box-danger" style="width:97%;">
                    <div class="box-header">
                      <center><img src="../images/<?php echo $kiddies->package_photo?>" class="img-thumbnail" width="500" height="100"></center>
                      <center><?php echo $kiddies->package_name?> - &#8369; <?php echo $kiddies->total_price?></h4>
                 <a href="" class="btn btn-info" data-toggle="modal" data-target="#modal-kiddie<?php echo $kiddies->code?>" ><i class="fa fa-file"></i> View Full Details</a></center>
 <div class="modal fade" id="modal-kiddie<?php echo $kiddies->code?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
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
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
                
                </div>
              </div>
            </div>
              <?php endforeach;?>
              <?php else:?>
                <div class="alert alert-danger">No records on the database.</div>
              <?php endif;?>
              <!-- End -->
              <!--
              <?php $package = getdata("*","packages");?>
              <?php if(!empty($package)):?>
              <?php foreach ($package as $key =>$value):?>
                <div class="col-md-4 package" >
                  <div class="box box-danger" style="width:97%;">
                    <div class="box-header">
                      <center><img src="../images/<?php echo $value->package_photo?>" class="img-thumbnail" width="150"></center>
                      <h4 class="box-title"><?php echo $value->package_name?> - &#8369; <?php echo $value->total_price?></h4>
                      <?php if($value->no_person == '0'):?>
                  Min. of <?php echo $value->no_adults?> pax-adults & <?php echo $value->no_kids;?>pax-kids
                <?php else:?>
                <h4>Minimum of <?php echo $value->no_person;?> pax</h4>
              <?php endif;?>
                      <?php 
                      $query = "SELECT * FROM package_extension WHERE code = ".$value->code." ORDER BY `package_extension`.`package_sync` DESC";
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
                  </div>
                </div>
              <?php endforeach;?>
            <?php else:?>
              <div class="alert alert-danger">There are no records on the database.</div>
            <?php endif;?>
          -->
               
              </div>
            </div>
            
          </div>
       </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<style type="text/css">
  .package{
    padding:5px;
  }
</style>
<?php include'../assets/user_footer.php';?>