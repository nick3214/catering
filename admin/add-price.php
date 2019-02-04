<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_admin'])){
  header("Location: ../index.php");
  exit;
}
if(isset($_POST['save_button']) AND !isset($_GET['mp_id'])){
  $menu_price =$_POST['menu_price'];
  $no_menu =$_POST['no_menu'];
  $pack_type =$_POST['pack_type'];

  
    $insertSQL = array("menu_price"=>$menu_price,"no_menu"=>$no_menu, "head_type"=>$pack_type);
    insertdata("menu_price",$insertSQL);
    header("location: food_price.php");
}
if(isset($_GET['mp_id'])){
  $row = single_get("*","mp_id","menu_price",$_GET['mp_id']);
}
if(isset($_POST['save_button']) && isset($_GET['mp_id'])){
  $menu_price =$_POST['menu_price'];
  $no_menu =$_POST['no_menu'];
  $pack_type =$_POST['pack_type'];

  
    $update = $dbcon->query("UPDATE menu_price SET menu_price='$menu_price', head_type='$pack_type', no_menu='$no_menu' WHERE mp_id = '".$_GET['mp_id']."'") or die(mysqli_error());  
  header("location: food_price.php");
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
                  <td>No. of Menu:</td>
                  <td>
                    <input type="text" name="no_menu" class="form-control" placeholder="No of Menu" required="required"
                    value="<?php if(isset($_GET['mp_id'])): echo $row['no_menu']; elseif(isset($_POST['save_button'])): echo $_POST['no_menu']; endif;?>">
                  </td>
                </tr>
                <tr>
                  <td>Price:</td>
                  <td>
                    <input type="text" name="menu_price" class="form-control" placeholder="Price" required="required"
                    value="<?php if(isset($_GET['mp_id'])): echo $row['menu_price']; elseif(isset($_POST['save_button'])): echo $_POST['menu_price']; endif;?>">
                  </td>
                </tr>
                
                <tr>
                  <td>Category:</td>
                  <td>
                    <select name="pack_type" style="width:92%; height:40px;">
                      <option value="0" <?php if(isset($_GET['mp_id'])){
                      if($row['head_type'] == "0"){
                        echo 'selected';
                      }
                    }
                    elseif(isset($_POST['save_button'])){
                        echo $_POST['pack_type'];
                      }
                      ?>>Adults</option>
                      <option value="1" <?php if(isset($_GET['mp_id'])){
                      if($row['head_type'] == "1"){
                        echo 'selected';
                      }
                    }
                    elseif(isset($_POST['save_button'])){
                        echo $_POST['pack_type'];
                      }
                      ?>>Kids</option>
              
            </select>
                  </td>
                </tr>
               
              
                <tr>
                  <td></td>
                  <td>
                    <button class="btn btn-primary" name="save_button"><i class="fa fa-save"></i> Save</button>
                    <a href="food_price.php" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to list</a>
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
