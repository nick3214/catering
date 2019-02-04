<?php 
include'config/db.php';
include'config/functions.php';
include'config/main_function.php';
?>
<?php include'assets/header.php';?>

      </nav> 

    </div>
  </div>
  <div style="margin:100px;"></div>
   <div class="container" style="background:white; padding:20px;">
    <h3><i class="fa fa-upload"></i> Gallery</h3><hr>

      <div class="row">
        <div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <?php $f = getdata("*","occasion");?>
                <?php if(!empty($f)):?>
                  <?php foreach ($f as $key => $value):?>
                    <li style="font-size:16px;"><a href="gallery.php?ID=<?php echo $value->occasion_id?>"><i class="fa fa-circle"></i> <?php echo $value->occasion_name; ?></a></li>
                  <?php endforeach;?>
                <?php else:?>
              <?php endif;?>
            </ul>

             <?php $f = getdata_where("*","occasion_id","occasion",$_GET['ID']);?>
                <?php if(!empty($f)):?>
                  <?php foreach ($f as $key => $row):?>
                    <div class="tab-content">
              <div class="tab-pane active" id="tab_<?php echo $row->occasion_id?>">
                <br>
                <h4>Occasion Type: <?php echo $row->occasion_name?></h4>
                <hr>
                <?php $g = getdata_where("*","occasion_name","gallery",$row->occasion_name);?>
                <?php if(!empty($g)):?>
                   <div class="row">
                  <?php foreach ($g as $key => $result):?>
                   
                      <div class="col-sm-4">
                        <img src="images/<?php echo $result->gallery_photo?>" width="100%" class="img-thumbnail">
                        <p style="padding:15px;"><?php echo $result->photo_desc?></p>

                      </div>
                
                  <?php endforeach;?>

                  </div>
                <?php else:?>
                  <div class="alert alert-danger">There are no records on the database.</div>
                <?php endif;?>


              </div>

            </div>
                  <?php endforeach;?>
                <?php else:?>
              <?php endif;?>


            
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
        <!-- /.col -->

        <!-- /.col -->
      </div>

        <!-- / row -->
    </div><!-- / container -->
    <div style="margin:100px;"></div>
<?php include'assets/footer.php';?>
</body>
</html>



