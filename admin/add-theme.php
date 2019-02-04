<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_admin'])){
  header("Location: ../index.php");
  exit;
}
if(isset($_POST['save_button']) AND !isset($_GET['theme_id'])){
  $theme_name =$_POST['theme_name'];
  $allowedExts = array("gif", "jpeg", "jpg", "png");
  $temp = explode(".", $_FILES["photo"]["name"]);
  $photo =$_FILES['photo'] ["name"];
  $extension = end($temp);
  $user = $_SESSION['user_email'];
  $date_modified = date("Y-m-d h:i:s");
  $theme_price = filter($_POST['theme_price']);

  $checkName = single_get("*","theme_name","food_items",$theme_name);
  
  if($checkName['theme_name'] == $theme_name){
    $msg = 'Name: '.$theme_name.' already exist on database.';
  }
  else{
    $insertSQL = array("theme_name"=>$theme_name,"last_modified"=>$user, "theme_img"=>$photo,"date_modified"=>$date,"theme_price"=>$theme_price);
    insertdata("themes",$insertSQL);
    move_uploaded_file($_FILES["photo"]["tmp_name"],"../images/". $_FILES["photo"]["name"]);
    header("location: themes.php");
  }
}
if(isset($_GET['theme_id'])){
  $row = single_get("*","theme_id","themes",$_GET['theme_id']);
}
if(isset($_POST['save_button']) && isset($_GET['theme_id'])){
   $theme_name =$_POST['theme_name'];
  $allowedExts = array("gif", "jpeg", "jpg", "png");
  $temp = explode(".", $_FILES["photo"]["name"]);
  $photo =$_FILES['photo'] ["name"];
  $extension = end($temp);
  $user = $_SESSION['user_email'];
  $date_modified = date("Y-m-d h:i:s");
  $theme_price = filter($_POST['theme_price']);
  
  if($photo != ''){
    $update = $dbcon->query("UPDATE themes SET theme_name='$theme_name', last_modified='$user', theme_img='$photo',date_modified='$date_modified', theme_price='$theme_price' WHERE theme_id = '".$_GET['theme_id']."'") or die(mysqli_error());
    move_uploaded_file($_FILES["photo"]["tmp_name"],"../images/". $_FILES["photo"]["name"]);
  }else{
  $update = $dbcon->query("UPDATE themes SET theme_name='$theme_name', last_modified='$user',date_modified='$date_modified',theme_price='$theme_price' WHERE theme_id = '".$_GET['theme_id']."'") or die(mysqli_error());
  }
  header("location: themes.php");
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
              <h4 class="box-title"><i class="fa fa-plus"></i> Create Item  </h4>
            </div>
<?php if(isset($msg)):?><div class="alert alert-danger"><?php echo $msg;?></div><?php endif;?>
            <form method="post" enctype="multipart/form-data">
            <table class="table table-responsive table-bordered">
                
                <tr>
                  <td>Name:</td>
                  <td>
                    <input type="text" name="theme_name" class="form-control" placeholder="Theme Name" required="required"
                    value="<?php if(isset($_GET['theme_id'])): echo $row['theme_name']; elseif(isset($_POST['save_button'])): echo $_POST['theme_name']; endif;?>">
                  </td>
                </tr>
                 <tr>
                  <td>Name:</td>
                  <td>
                    <input type="text" name="theme_price" class="form-control" placeholder="Price" required="required"
                    value="<?php if(isset($_GET['theme_id'])): echo $row['theme_price']; elseif(isset($_POST['save_button'])): echo $_POST['theme_price']; endif;?>">
                  </td>
                </tr>
                <tr>
                  <td>Image:</td>
                  <td>
                    <input type="file" name="photo">
                  </td>
                </tr>
                <tr>
                  <td></td>
                  <td>
                    <button class="btn btn-primary" name="save_button"><i class="fa fa-save"></i> Save</button>
                    <a href="themes.php" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to list</a>
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
