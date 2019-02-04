<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_user'])){
  header("Location: ../index.php");
  exit;
}
$max = single_get("*","setting_id","site_settings","3");
$selectReserve = single_get("*","tcode","reservations",$_GET['tcode']);

$outside = single_get("*","setting_id","site_settings","4");
if(isset($_POST['save_button'])){
  $package_name = filter($_GET['package_name']);
  $event_name = filter($_POST['event_name']);
  $event_city = filter($_POST['event_city']);
  $event_date = date("Y-m-d",strtotime($_POST['event_date']));
  $event_theme = filter($_POST['event_theme']);
  $event_time = filter($_POST['event_time']);
  $event_color = filter($_POST['event_color']);
  $event_venue = filter($_POST['event_venue']);
  $event_instructions = filter($_POST['event_instructions']);
  $tcode = rand();
  $package_code = filter($_GET['code']);
  //$city_location = $_POST['city_location'];

  $kweri = $dbcon->query("SELECT * FROM reservations WHERE event_date = '$event_date' AND reservation_status != 'Draft'") or die(mysqli_error());
  $count = mysqli_num_rows($kweri);
  if($count >= $max['setting_value']){
    $msg = '<div class="alert alert-danger">You have reached the maximum number of reservations per day. We only cater '.$max['setting_value'].' reservations per day.</div>';
  }else{
      $updateQuery = $dbcon->query("UPDATE reservations SET event_name='$event_name', event_city='$event_city', event_date='$event_date', event_theme='$event_theme', event_time='$event_time', event_instructions='$event_instructions', event_color='$event_color', event_venue='$event_venue' WHERE tcode='".$_GET['tcode']."'") or die(mysqli_error());
    //insertdata("notifications",$notifSQL);
    header("location: other-reservation.php?tcode=".$_GET['tcode']."&tab=1");
  }
  
  
}
?>
<?php include'../assets/user_header.php';?>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/themes/base/jquery-ui.css" rel="stylesheet" />
<script class="jsbin" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
  <!-- Content Wrapper. Contains page content -->
  <div style="height:20px;"></div>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="width:87%; margin: 0 auto;background: white;border-radius:3px;">
    <!-- Main content -->
    <section class="content">


      <div class="row">
       <div class="container">
        
        <div class="box box-info" style="width:97%;">
            <div class="box-header">
              

              <h4 class="box-title">STEP 3: Fillout event details</h4>
            </div>
            <hr>
            <div class="box-body">
            <?php if(isset($msg)): echo $msg; endif;?>
            <form method="post">
             
            <div class="row">

              <div class="col-md-6">
                <strong>Event Name:</strong>
                <br>
                <input type="text" name="event_name" class="form-control" placeholder="Event Name" required="required" value="<?php echo $selectReserve['event_name']?>">
              </div>
              <div class="col-md-6">
                <strong>City:</strong>
                <br>
                <select name="event_city" class="form-control">
                   <?php $city = getdata("*","city_location");?>
                <?php if(!empty($city)):?>
                <?php foreach ($city as $key => $value):?>
                  <option value="<?php echo $value->city_location?>"><?php echo $value->city_location?> - <?php echo $value->fee?></option>
                <?php endforeach;?>
                </select>
              <?php else:?>
                <option>No Records on database.</option>
              <?php endif;?>
                
                </select>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-6">
                <strong>Date:</strong><small style="color:red;"> (Your reservation should be 2 months prior the actual event)</small>
                <br>
                <input type="text" name="event_date" id="datepicker" class="form-control" placeholder="Date" required="required" value="<?php echo $selectReserve['event_date']?>">
              </div>
              <div class="col-md-6">
                <strong>Theme:</strong>
                <br>
                <select class="form-control" name="event_theme">
                <?php $theme = getdata("*","themes");?>
                <?php if(!empty($theme)):?>
                <?php foreach ($theme as $key => $value):?>
                  <option value="<?php echo $value->theme_name?>"><?php echo $value->theme_name?> - <?php echo $value->theme_price?></option>
                <?php endforeach;?>
                </select>
              <?php else:?>
                <option>No Records on database.</option>
              <?php endif;?>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-6">
                <strong>Time:</strong>
                <br>
                <input type="time" name="event_time" class="form-control" placeholder="Event Name" required="required" value="<?php echo $selectReserve['event_time']?>">
              </div>
              <div class="col-md-6">
                <strong>Color Motiff:</strong>
                <br>
                <select name="event_color" class="form-control">
                  <option>Red</option>
                  <option>Blue</option>
                  <option>Pink</option>
                  <option>Yellow</option>
                  <option>Green</option>
                  <option>Black</option>
                  <option>White</option>
                  <option>Indigo</option>
                  <option>Violet</option>
                </select>
                
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-6">
                <strong>Venue:</strong>
                <br>
                <textarea class="form-control" name="event_venue" placeholder="Venue" required="required"><?php echo $selectReserve['event_venue']?></textarea>
              </div>
              <div class="col-md-6">
                <strong>Special Instructions:</strong>
                <br>
                <textarea class="form-control" name="event_instructions" placeholder="Special Instructions" required="required"><?php echo $selectReserve['event_instructions']?></textarea>
              </div>
              <!--
              <div class="col-md-6">
                <strong>City Location:</strong>
                <br>
                <select class="form-control" name="city_location">
                  <option value="Inside Valenzuela City">Inside Valenzuela City - Free</option>
                  <option value="Outside Valenuela City">Outside Valenuela City - <?php echo $outside['setting_value']?></option>
                </select>
              </div>
            
          -->
          </div>
            <center>
              <br>
              <button class="btn btn-primary" name="save_button"><i class="fa fa-save"></i> Save Data</button> <a href="reservation-package.php" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a>
            </center>
            </form>
            </div>
            
          </div>
          <hr>
          
       </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script type="text/javascript">
  $(function() {
    $( "#datepicker").datepicker({ 
      minDate: '+2M'

    });
  });
</script>
<?php include'../assets/user_footer.php';?>