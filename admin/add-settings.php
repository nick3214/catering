<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_admin'])){
  header("Location: ../index.php");
  exit;
}
if(isset($_POST['save_button']) AND !isset($_GET['setting_id'])){
  $setting_name =$_POST['setting_name'];
  $setting_value = filter($_POST['setting_value']);
  $user = $_SESSION['user_email'];
  $date = date("Y-m-d h:i:s"); 
  $checkName = single_get("*","setting_name","site_settings",$setting_name);
  if($checkName['setting_name'] == $setting_name){
    $msg = 'Name: '.$setting_name.' already exist on database.';
  }
  else{
    $insertSQL = array("setting_name"=>$setting_name,"setting_value"=>$setting_value,"last_modified"=>$user, "date_modified"=>$date,"setting_content"=>$_POST['setting_content']);
    insertdata("site_settings",$insertSQL);
    header("location: settings.php");
  }
}
if(isset($_GET['setting_id'])){
  $row = single_get("*","setting_id","site_settings",$_GET['setting_id']);
}
if(isset($_POST['save_button']) && $_GET['setting_id'] != '5'){
  $setting_name =$_POST['setting_name'];
  $setting_value = filter($_POST['setting_value']);
  $user = $_SESSION['user_email'];
  $date = date("Y-m-d h:i:s"); 
  $update = $dbcon->query("UPDATE site_settings SET setting_name='$setting_name',setting_value='$setting_value',
    date_modified='$date', last_modified='$user', setting_content='".$_POST['setting_content']."' WHERE setting_id = '".$_GET['setting_id']."'") or die(mysqli_error());
  header("location: settings.php");
  
}elseif(isset($_POST['save_button']) && $_GET['setting_id'] == '5')
{
  $setting_name =$_POST['setting_name'];
  $setting_value = filter($_POST['setting_value']);
  $user = $_SESSION['user_email'];
  $date = date("Y-m-d h:i:s"); 
  $update = $dbcon->query("UPDATE site_settings SET setting_name='$setting_name',setting_value='$setting_value',
    date_modified='$date', last_modified='$user', setting_content='".$_POST['setting_content']."' WHERE setting_id = '".$_GET['setting_id']."'") or die(mysqli_error());
    
  $updateCity = $dbcon->query("UPDATE city_location SET fee = '$setting_value' WHERE city_location != 'Valenzuela City'") or die(mysqli_error());
  header("location: settings.php");
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
              <h4 class="box-title"><i class="fa fa-plus"></i> Add Settings </h4>
            </div>
<?php if(isset($msg)):?><div class="alert alert-danger"><?php echo $msg;?></div><?php endif;?>
            <form method="post">
            <table class="table table-responsive table-bordered">
                <tr>
                  <td>Name:</td>
                  <td>
                    <input type="text" name="setting_name" class="form-control" placeholder="Name" required="required"
                    value="<?php if(isset($_GET['setting_id'])): echo $row['setting_name']; elseif(isset($_POST['save_button'])): echo $_POST['setting_name']; endif;?>">
                  </td>
                </tr>
                <tr>
                  <td>Value:</td>
                  <td>
                    <input type="number" name="setting_value" class="form-control" placeholder="Value" required="required" value="<?php if(isset($_GET['setting_id'])): echo $row['setting_value']; elseif(isset($_POST['save_button'])): echo $_POST['setting_value']; endif;?>">
                  </td>
                </tr>
                <tr>
                  <td>Content:</td>
                  <td>
                    
                    <textarea id="editor1" class="form-control" name="setting_content" placeholder="Content"><?php if(isset($_GET['setting_id'])): echo $row['setting_content']; elseif(isset($_POST['save_button'])): echo $_POST['setting_content']; endif;?>
                    </textarea>
                  </td>
                </tr>
                <tr>
                  <td></td>
                  <td>
                    <button class="btn btn-primary" name="save_button"><i class="fa fa-save"></i> Save</button>
                    <a href="settings.php" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to list</a>
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
<script src="../bootstrap/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="../bootstrap/bower_components/ckeditor/ckeditor.js"></script>
<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1')
    //bootstrap WYSIHTML5 - text editor
    $('.textarea').wysihtml5()
  })
</script>
</body>
</html>
