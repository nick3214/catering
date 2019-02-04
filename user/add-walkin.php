<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_admin'])){
  header("Location: ../index.php");
  exit;
}
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
  $city_location = $_POST['city_location'];
  
  $insertSQL = array("event_name"=>$event_name,"event_city"=>$event_city,"event_date"=>$event_date,"event_theme"=>$event_theme,"event_time"=>$event_time,"event_color"=>$event_color,"event_venue"=>$event_venue,"event_instructions"=>$event_instructions,"package_name"=>$package_name,"reservation_status"=>"Draft","tcode"=>$tcode,"package_code"=>$package_code,"city_location"=>$city_location,"user_id"=>$_SESSION['user_id']);
  insertdata("reservations",$insertSQL);
  header("location: other-reservation.php?tcode=$tcode&tab=1");
}
?>
<?php include'../assets/user_header.php';?>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/themes/base/jquery-ui.css" rel="stylesheet" />
<script class="jsbin" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
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
            <form method="post">
              <input type="text" name="package_name" value="<?php echo $_GET['package_name']?>" placeholder="Event Name" class="form-control" readonly="readonly">
            <div class="row">

              <div class="col-md-6">
                <strong>Event Name:</strong>
                <br>
                <input type="text" name="event_name" class="form-control" placeholder="Event Name" required="required">
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
                <input type="text" name="event_date" id="datepicker" class="form-control" placeholder="Date" required="required">
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
                <input type="time" name="event_time" class="form-control" placeholder="Event Name" required="required">
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
                <textarea class="form-control" name="event_venue" placeholder="Venue" required="required"></textarea>
              </div>
              <div class="col-md-6">
                <strong>Special Instructions:</strong>
                <br>
                <textarea class="form-control" name="event_instructions" placeholder="Special Instructions" required="required"></textarea>
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
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php include'../assets/user_footer.php';?>