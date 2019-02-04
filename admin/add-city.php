<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_admin'])){
  header("Location: ../index.php");
  exit;
}
if(isset($_POST['save_button']) AND !isset($_GET['city_id'])){
  $city_location = filter($_POST['city_location']);
  $fee = filter($_POST['fee']);
  $checkName = single_get("*","city_location","city_location",$city_location);
  if($checkName['city_location'] == $city_location){
    $msg = 'Name: '.$city_location.' already exist on database.';
  }
  else{
    $insertSQL = array("city_location"=>$city_location,"created_by"=>$_SESSION['user_email'],"fee"=>$fee);
    insertdata("city_location",$insertSQL);
    header("location: city.php");
  }
}
if(isset($_GET['city_id'])){
  $row = single_get("*","city_id","city_location",$_GET['city_id']);
}
if(isset($_POST['save_button']) && isset($_GET['city_id'])){
   $city_location = filter($_POST['city_location']);
  $fee = filter($_POST['fee']);
  
  $update = $dbcon->query("UPDATE city_location SET city_location='$city_location',created_by='".$_SESSION['user_email']."',fee='$fee' WHERE city_id = '".$_GET['city_id']."'") or die(mysqli_error());
  header("location: city.php");
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
              <h4 class="box-title"><i class="fa fa-plus"></i> Create Staff  </h4>
            </div>
<?php if(isset($msg)):?><div class="alert alert-danger"><?php echo $msg;?></div><?php endif;?>
            <form method="post">
            <table class="table table-responsive table-bordered">
                
                <tr>
                  <td>City Location:</td>
                  <td>
                    <input type="text" name="city_location" class="form-control" placeholder="Location" required="required"
                    value="<?php if(isset($_GET['city_id'])): echo $row['city_location']; elseif(isset($_POST['save_button'])): echo $_POST['city_location']; endif;?>">
                  </td>
                </tr>
                <tr>
                  <td>Fee:</td>
                  <td>
                     <select class="form-control" name="fee">
<?php $getReservation = single_get("*","setting_id","site_settings",'5');//get reservation fee ?>
                         <option value="0">0 for Inside Valenzuela City</option>
                         <option value="<?php echo $getReservation['setting_value']?>"><?php echo $getReservation['setting_value']?> For outside Valenzuela City</option>
                     </select>
                
                  </td>
                </tr>
                <tr>
                  <td></td>
                  <td>
                    <button class="btn btn-primary" name="save_button"><i class="fa fa-save"></i> Save</button>
                    <a href="city.php" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to list</a>
                  </td>
                </tr>
              </table>
              </form>
            
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
