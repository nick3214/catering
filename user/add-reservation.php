<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_user'])){
  header("Location: ../index.php");
  exit;
}
$max = single_get("*","setting_id","site_settings","3");
$outside = single_get("*","setting_id","site_settings","4");
if(isset($_POST['save_button'])){
  $package_name = filter($_GET['package_name']);
  $event_name = filter($_POST['event_name']);
  $pax = filter($_POST['pax']);
  $event_date = date("Y-m-d",strtotime($_POST['event_date']));
  $cat_id = filter($_POST['cat_id']);
  $event_time = filter($_POST['event_time']);
  $sub_id = filter($_POST['sub_id']);
  $event_venue = $_POST['venue_one']." ".$_POST['venue_two']. " ".$_POST['venue_three'];
  $event_instructions = filter($_POST['event_instructions']);
  $tcode = rand();
  $package_code = filter($_GET['code']);
  //$city_location = $_POST['city_location'];

  $kweri = $dbcon->query("SELECT * FROM reservations WHERE event_date = '$event_date' AND reservation_status != 'Draft'") or die(mysqli_error());
  $count = mysqli_num_rows($kweri);

  if($count >= $max['setting_value']){
    $msg = '<div class="alert alert-danger">You have reached the maximum number of reservations per day. We only cater '.$max['setting_value'].' reservations per day.</div>';
  }elseif($event_date == "1970-01-01"){
    $msg = '<div class="alert alert-danger">Please enter a date</div>';
  }else{
    $insertSQL = array(
      "event_name"        =>$event_name,
      "pax"               =>$pax,
      "event_date"        =>$event_date,
      //"event_theme"       =>$event_theme,
      "event_time"        =>$event_time,
      "cat_id"            =>$cat_id,
      "event_venue"       =>$event_venue,
      "event_instructions"=>$event_instructions,
      "package_name"      =>$package_name,
      "reservation_status"=>"Draft",
      "tcode"             =>$tcode,
      "package_code"      =>$package_code,
      "sub_id"            =>$sub_id,
      "user_id"           =>$_SESSION['user_id'],
      "type"              =>$_POST['eating_type']
    );
   //$notifSQL = array("n_logs"=>"Customer: ".$_SESSION['full_name']." added a reservation: ".$event_name." and set to Draft","user_id"=>$_SESSION['user_id']);
    insertdata("reservations",$insertSQL);
    //insertdata("notifications",$notifSQL);
    header("location: other-reservation.php?tcode=$tcode&tab=1");
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
              <input type="text" name="package_name" value="<?php echo $_GET['package_name']?>" placeholder="Event Name" class="form-control" readonly="readonly">
            <div class="row">

              <div class="col-md-6">
                <strong>Event Name:</strong>
                <br>
                <input type="text" name="event_name" class="form-control" placeholder="Event Name" required="required" value="<?php if(isset($_POST['save_button'])): echo $_POST['event_name']; endif;?>">
              </div>
              <div class="col-md-6">
                <!--
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
              -->
              <strong>Date:</strong><small style="color:red;"> (Your reservation should be 3 days prior the actual event)</small>
                <br>
                <input type="text" name="event_date" id="datepicker" class="form-control" placeholder="Date" readonly="readonly" required="required">
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-6">
                <strong>Time:</strong>
                <br>
                <input type="time" name="event_time" class="form-control" placeholder="Event Name" required="required" value="<?php if(isset($_POST['save_button'])): echo $event_time; endif;?>">
              </div>
              <div class="col-md-6">
                <strong>Number of Pax:</strong> <small style="color:red;">(Minimum of 100 pax and Maximum of 1,000 pax)</small>
                 <input type="number" min="100" max="1000" class="form-control" placeholder="No. of Pax" name="pax" required>
                <!--
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
            -->
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-6">
              <strong>Type: </strong>
              <span style="color:red;font-size:8pt" id="hide_type">(Additional 20% for Plated Type)</span>
                  <select name="eating_type"  class="form-control" id="type">
                      <option value="buffet">Buffet</option>
                      <option value="plated">Plated</option>
                  </select>
              </div>
              <div class="col-md-6">
                <strong>Occasion: </strong>
                 <span style="color:red;font-size:8pt" id="hide_type">(Additional 20,000 for Special Type Setup Included</span>
                  <select class="form-control" required = 'required' name = "cat_id" id="functionList">
                      <?php
                      $catCounter = 0;
                      $field = $dbcon->query("SELECT * FROM occasion") or die(mysqli_error());
                      while($fields = $field->fetch_assoc()){
                        if($catCounter == 0){
                          $catCounter += 1;
                          $functionOne = $fields['occasion_id'];
                        }
                      ?>
                      <option value="<?php echo $fields['occasion_id']?>"><?php echo $fields['occasion_name']?></option>
                      <?php   
                      }
                      ?>
                    </select>
                      <input type="radio" target="0" checked name="occasion_type">Color
                      <input type="radio" target="1" name="occasion_type">Special
  
              
              </div>

            </div>
            <br>
            <div class="row">
              <div class="col-md-6">
              <strong>Motif: </strong>
              <select class="form-control" required = 'required' name="sub_id" id="compList" onchange="me(this.value)" >
                        <?php
                        $funcCounter = 0;
                        $function = $dbcon->query("SELECT * FROM motif WHERE occasion_id = ".$functionOne."&&motif_type=0 ") or die(mysqli_error());
                        if(mysqli_num_rows($function) == 0){
                          echo '<option>Select Data</option>';
                        }else{
                        while($functions = $function->fetch_assoc()){
                          if($funcCounter == 0){
                            $funcCounter += 1;
                            $compOne = $functions['id'];
                          }
                      ?>
                       <option value="<?php echo $functions['id']?>"><?php echo $functions['motif']?></option>
                       
                      <?php }
                      }
                        ?>
                      </select>
              </div>
              <div class="col-md-6">
                <strong>House Number, Building, Street Name: </strong>
              <input type="text" name="venue_one" class="form-control" placeholder="House Number, Building, Street Name" required>
              </div>

            </div>
            <br>
            <div class="row">
              <div class="col-md-6">
              <strong>Barangay: </strong>
                  <input type="text" name="venue_two" class="form-control" placeholder="Barangay" required>
              </div>
              <div class="col-md-6">
              <strong>City/Municipality: </strong>
              <input type="text" name="venue_three" class="form-control" placeholder="City/Municipality" required>
              </div>

            </div>
            <br>
            <div class="row">
              <div class="col-md-6">
                
                <input class="form-control" name="event_instructions" placeholder="Special Instructions" required="required" type="hidden" value="none">
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
              <a href="reservation-package.php" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
              <button class="btn btn-primary" name="save_button"><i class="fa fa-save"></i> Save Data</button> 
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


<?php include'../assets/user_footer.php';?>
<script type="text/javascript">
function changeCat(key){
  if(window.XMLHttpRequest){
  // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp = new XMLHttpRequest();
  }else{
  // code for IE6, IE5
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange = function(){
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
      document.getElementById("compList").innerHTML = xmlhttp.responseText;
      var comp = document.getElementById("compList").value;
      me(comp);
    }
  }
  xmlhttp.open("GET","changeCat.php?key="+key, true);
  xmlhttp.send(); 
}

$(document).ready(function(){
   $( "#datepicker").datepicker({ 
      minDate: '4'

    });
  $("#functionList").change(function(){
    var type = $("input[type='radio']:checked").attr('target');
    var list = $(this).val();
    // console.log(list+type);
    $("#compList").html("");
    $.ajax({
      url: "changeCat.php",
      method:"post",
      data:"list="+list+"&type="+type,
      success:function(data){
        $("#compList").append(data);
      
      }
    })
  })
  $("input[type='radio']").change(function(){
    var list = $("#functionList").val();
    var type = $(this).attr('target');
    // console.log(list+type);
    $("#compList").html("");
    $.ajax({
      url: "changeCat.php",
      method:"post",
      data:"list="+list+"&type="+type,
      success:function(data){
        $("#compList").append(data);
      
      }
    })
  })
})
</script>