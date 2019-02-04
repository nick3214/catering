<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_admin'])){
  header("Location: ../index.php");
  exit;
}
if(isset($_POST['save_button']) AND !isset($_GET['sub_id'])){
  
  $sub_name =$_POST['sub_name'];
  $cat_id =$_POST['cat_id'];
  
  $allowedExts = array("gif", "jpeg", "jpg", "png");
  $temp = explode(".", $_FILES["photo"]["name"]);
  $photo =$_FILES['photo'] ["name"];
  $extension = end($temp);
  //$menu_type = filter($_POST['menu_type']);
 

  $checkName = single_get("*","sub_name","sub_category",$sub_name);
  if($checkName['sub_name'] == $sub_name){
    $msg = 'Name: '.$f_name.' already exist on database.';
  }
  else{
    $insertSQL = array("sub_name"=>$sub_name, "itm_image"=>$photo,"cat_id"=>$cat_id);
    insertdata("sub_category",$insertSQL);
    move_uploaded_file($_FILES["photo"]["tmp_name"],"../images/". $_FILES["photo"]["name"]);
    header("location: sub_category.php");
  }
}
if(isset($_GET['sub_id'])){
  $row = single_get("*","sub_id","sub_category",$_GET['sub_id']);
}
if(isset($_POST['save_button']) && isset($_GET['sub_id'])){
  $sub_name =$_POST['sub_name'];
  $cat_id =$_POST['cat_id'];
  //$cost_per_head =$_POST['cost_per_head'];
  $allowedExts = array("gif", "jpeg", "jpg", "png");
  $temp = explode(".", $_FILES["photo"]["name"]);
  $photo =$_FILES['photo'] ["name"];
  $extension = end($temp);
  //$menu_type = filter($_POST['menu_type']);
  
  if($photo != ''){
    $update = $dbcon->query("UPDATE sub_category SET sub_name='$sub_name', cat_id='$cat_id', itm_image='$photo' WHERE sub_id = '".$_GET['sub_id']."'") or die(mysqli_error());
    move_uploaded_file($_FILES["photo"]["tmp_name"],"../images/". $_FILES["photo"]["name"]);
  }else{
  $update = $dbcon->query("UPDATE sub_category SET  sub_name='$sub_name', cat_id='$cat_id' WHERE sub_id = '".$_GET['sub_id']."'") or die(mysqli_error());
  }
  header("location: sub_category.php");
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
                    <input type="text" name="sub_name" class="form-control" placeholder="Name" required="required"
                    value="<?php if(isset($_GET['sub_id'])): echo $row['sub_name']; elseif(isset($_POST['save_button'])): echo $_POST['sub_name']; endif;?>">
                  </td>
                </tr>
                <tr>
                  <td>Image:</td>
                  <td>
                    <input type="file" name="photo">
                  </td>
                </tr>
                <tr>
                  <td>Category:</td>
                  <td>
                    <select name="cat_id" style="width:92%; height:40px;">
                    <?php $list = getdata("*","food_categories");?>
                    <?php foreach ($list as $key => $value):?>
                    <option value="<?php echo $value->f_id?>"
                    <?php if(isset($_GET['sub_id'])){
                      if($row['cat_id'] == $value->f_id){
                        echo 'selected';
                      }
                    }
                    elseif(isset($_POST['save_button'])){
                        echo $_POST['cat_id'];
                      }
                      ?>><?php echo $value->f_name?></option>
                  <?php endforeach;?>
            </select>
                  </td>
                </tr>
                <!--
                <tr>
                  <td>Menu Type:</td>
                  <td>
                    <select name="menu_type" style="width:92%; height:40px;">
                    <?php $list = getdata("*","menu");?>
                    <?php foreach ($list as $key => $value):?>
                    <option value="<?php echo $value->menu_id?>"
                    <?php if(isset($_GET['sub_id'])){
                      if($row['menu_type'] == $value->menu_id){
                        echo 'selected';
                      }
                    }
                    elseif(isset($_POST['save_button'])){
                        echo $_POST['menu_type'];
                      }
                      ?>><?php echo $value->menu_name?></option>
                  <?php endforeach;?>
            </select>
                  </td>
                </tr>
              
                <tr>
                  <td>Cost Per head:</td>
                  <td>
                    <input type="text" min="50" name="cost_per_head" class="form-control" placeholder="Cost per Head" required="required"
                    value="<?php if(isset($_GET['sub_id'])): echo $row['cost_per_head']; elseif(isset($_POST['save_button'])): echo $_POST['cost_per_head']; endif;?>">
                  </td>
                </tr>
              -->
                <tr>
                  <td></td>
                  <td>
                    <button class="btn btn-primary" name="save_button"><i class="fa fa-save"></i> Save</button>
                    <a href="sub_category.php" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to list</a>
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
