<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_admin'])){
  header("Location: ../index.php");
  exit;
}
if(isset($_POST['save_button']) AND !isset($_GET['paluto_id'])){
  $paluto_name =$_POST['paluto_name'];
  $paluto_price =$_POST['paluto_price'];
  $paluto_type = $_POST['paluto_type'];

  $allowedExts = array("gif", "jpeg", "jpg", "png");
  $temp = explode(".", $_FILES["photo"]["name"]);
  $photo =$_FILES['photo'] ["name"];
  $extension = end($temp);
 
  $checkName = single_get("*","paluto_name","paluto_menu",$paluto_name);
  if($checkName['paluto_name'] == $paluto_name){
    $msg = 'Name: '.$paluto_name.' already exist on database.';
  }
  else{
    $insertSQL = array(
      "paluto_name"     =>$paluto_name,
      "paluto_type"     =>$paluto_type,
      "paluto_price"    =>$paluto_price,
      "paluto_photo"    =>$photo
    );
    insertdata("paluto_menu",$insertSQL);
    move_uploaded_file($_FILES["photo"]["tmp_name"],"../images/". $_FILES["photo"]["name"]);
    header("location: paluto_menu.php");
  }
}
if(isset($_GET['paluto_id'])){
  $row = single_get("*","paluto_id","paluto_menu",$_GET['paluto_id']);
}
if(isset($_POST['save_button']) && isset($_GET['paluto_id'])){
  $paluto_name =$_POST['paluto_name'];
  $paluto_price =$_POST['paluto_price'];
  $paluto_type = $_POST['paluto_type'];

  $allowedExts = array("gif", "jpeg", "jpg", "png");
  $temp = explode(".", $_FILES["photo"]["name"]);
  $photo =$_FILES['photo'] ["name"];
  $extension = end($temp);


  if($photo == ""){
    $update = $dbcon->query("UPDATE paluto_menu SET paluto_name='$paluto_name',
    paluto_type = '$paluto_type',paluto_price = '$paluto_price' WHERE paluto_id = '".$_GET['paluto_id']."'") or die(mysqli_error());
  header("location: paluto_menu.php");
  }
  else{
    $update = $dbcon->query("UPDATE paluto_menu SET paluto_name='$paluto_name',
    paluto_type = '$paluto_type',paluto_price = '$paluto_price', paluto_photo = '$photo' WHERE paluto_id = '".$_GET['paluto_id']."'") or die(mysqli_error());
    move_uploaded_file($_FILES["photo"]["tmp_name"],"../images/". $_FILES["photo"]["name"]);
  header("location: paluto_menu.php");
  }
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
              <h4 class="box-title"><i class="fa fa-plus"></i> Add Paluto  </h4>
            </div>
<?php if(isset($msg)):?><div class="alert alert-danger"><?php echo $msg;?></div><?php endif;?>
            <form method="post" enctype="multipart/form-data">
            <table class="table table-responsive table-bordered">
              <tr>
                  <td>Image:</td>
                  <td>
                    <input type="file" name="photo">
                  </td>
                </tr>
                <tr>
                  <td>Name:</td>
                  <td>
                    <input type="text" name="paluto_name" class="form-control" placeholder="Name" required="required"
                    value="<?php if(isset($_GET['paluto_id'])): echo $row['paluto_name']; elseif(isset($_POST['save_button'])): echo $_POST['paluto_name']; endif;?>">
                  </td>
                </tr>
                 <tr>
                  <td>Price:</td>
                  <td>
                    <input type="number" name="paluto_price" class="form-control" placeholder="Price" required="required"
                    value="<?php if(isset($_GET['paluto_id'])): echo $row['paluto_price']; elseif(isset($_POST['save_button'])): echo $_POST['paluto_price']; endif;?>">
                  </td>
                </tr>
                <tr>
                  <td>Paluto Type:</td>
                  <td>
                    

            <select name="paluto_type" class="form-control">
 
                    <option value="Breakfast"
                    <?php if(isset($_GET['paluto_paluto_id'])){
                      if($row['paluto_type'] == "Breakfast"){
                        echo 'selected';
                      }
                    }
                    elseif(isset($_POST['save_button'])){
                        echo $_POST['paluto_type'];
                      }
                      ?>>Breakfast</option>

                       <option value="Lunch"
                    <?php if(isset($_GET['paluto_paluto_id'])){
                      if($row['paluto_type'] == "Lunch"){
                        echo 'selected';
                      }
                    }
                    elseif(isset($_POST['save_button'])){
                        echo $_POST['paluto_type'];
                      }
                      ?>>Lunch</option>
                      <option value="Dinner"
                    <?php if(isset($_GET['paluto_paluto_id'])){
                      if($row['paluto_type'] == "Dinner"){
                        echo 'selected';
                      }
                    }
                    elseif(isset($_POST['save_button'])){
                        echo $_POST['paluto_type'];
                      }
                      ?>>Dinner</option>
                  
            </select>
                  </td>
                </tr>
               
                <tr>
                  <td></td>
                  <td>
                    <button class="btn btn-primary" name="save_button"><i class="fa fa-save"></i> Save</button>
                    <a href="paluto_menu.php" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to list</a>
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
