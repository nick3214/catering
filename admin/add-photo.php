<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_admin'])){
  header("Location: ../index.php");
  exit;
}
if(isset($_POST['save_button']) AND !isset($_GET['user_id'])){
  $allowedExts = array("gif", "jpeg", "jpg", "png");
  $temp = explode(".", $_FILES["photo"]["name"]);
  $photo =$_FILES['photo'] ["name"];
  $extension = end($temp);
  $photo_desc = $_POST['photo_desc'];
  $occasion_name = filter($_POST['occasion_name']);

  $checkName = single_get("*","gallery_photo","gallery",$photo);
  
  if($checkName['gallery_photo'] == $photo){
    $msg = 'Photo already exist.';
  }
  $insertSQL = array(
    "gallery_photo"     =>$photo,
    "uploaded_by"       =>$_SESSION['user_email'],
    "photo_desc"        =>$photo_desc,
    "occasion_name"     =>$occasion_name
  );
  move_uploaded_file($_FILES["photo"]["tmp_name"],"../images/". $_FILES["photo"]["name"]);
  insertdata("gallery",$insertSQL);
  header("location: photo.php");
  
}
if(isset($_POST['save_button']) && isset($_GET['g_id'])){
   $allowedExts = array("gif", "jpeg", "jpg", "png");
  $temp = explode(".", $_FILES["photo"]["name"]);
  $photo =$_FILES['photo'] ["name"];
  $extension = end($temp);
  
  $update = $dbcon->query("UPDATE gallery SET gallery_photo='$photo',uploaded_by='".$_SESSION['user_email']."' WHERE g_id = '".$_GET['g_id']."'") or die(mysqli_error());
  move_uploaded_file($_FILES["photo"]["tmp_name"],"../images/". $_FILES["photo"]["name"]);
  header("location: photo.php");
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
              <h4 class="box-title"><i class="fa fa-plus"></i> Add Photo  </h4>
            </div>
<?php if(isset($msg)):?><div class="alert alert-danger"><?php echo $msg;?></div><?php endif;?>
            <form method="post" enctype="multipart/form-data">
            <table class="table table-responsive table-bordered">
                
                <tr>
                  <td>Photo:</td>
                  <td>
                    <input type="file" name="photo" required="required">
                  </td>
                </tr>
                <tr>
                  <td>Occation:</td>
                  <td>
                    <select class="form-control" name="occasion_name">
                      <?php $f = getdata("*","occasion");?>
                      <?php if(!empty($f)):?>
                        <?php foreach ($f as $key => $value):?>
                          <option><?php echo $value->occasion_name; ?></option>
                        <?php endforeach;?>
                      <?php else:?>
                      <?php endif;?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>Description:</td>
                  <td>
                    <textarea class="form-control" name="photo_desc" placeholder="Please enter description"></textarea>
                  </td>
                </tr>
             
                  <td></td>
                  <td>
                    <button class="btn btn-primary" name="save_button"><i class="fa fa-save"></i> Save</button>
                    <a href="photo.php" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to list</a>
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
