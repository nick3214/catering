<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_admin'])){
  header("Location: ../index.php");
  exit;
}
if(isset($_POST['save_button']) AND !isset($_GET['menu_id'])){
  $menu_name =$_POST['menu_name'];
  
  $user = $_SESSION['user_email'];
  $date_modified = date("Y-m-d h:i:s");

  $checkName = single_get("*","menu_name","menu",$menu_name);
  
  if($checkName['menu_name'] == $menu_name){
    $msg = 'Name: '.$menu_name.' already exist on database.';
  }
  else{
    $insertSQL = array("menu_name"=>$menu_name,"last_modified"=>$user,"date_modified"=>$date);
    insertdata("menu",$insertSQL);
    header("location: menu.php");
  }
}
if(isset($_GET['menu_id'])){
  $row = single_get("*","menu_id","menu",$_GET['menu_id']);
}
if(isset($_POST['save_button']) && isset($_GET['menu_id'])){
  $menu_name =$_POST['menu_name'];
  $user = $_SESSION['user_email'];
  $date_modified = date("Y-m-d h:i:s");
  
  $update = $dbcon->query("UPDATE menu SET menu_name='$menu_name', last_modified='$user',date_modified='$date_modified' WHERE menu_id = '".$_GET['menu_id']."'") or die(mysqli_error());
  header("location: menu.php");
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
              <h4 class="box-title"><i class="fa fa-plus"></i> Create Menu  </h4>
            </div>
<?php if(isset($msg)):?><div class="alert alert-danger"><?php echo $msg;?></div><?php endif;?>
            <form method="post" enctype="multipart/form-data">
            <table class="table table-responsive table-bordered">
                
                <tr>
                  <td>Name:</td>
                  <td>
                    <input type="text" name="menu_name" class="form-control" placeholder="Menu Name" required="required"
                    value="<?php if(isset($_GET['menu_id'])): echo $row['menu_name']; elseif(isset($_POST['save_button'])): echo $_POST['menu_name']; endif;?>">
                  </td>
                </tr>
                <tr>
                  <td></td>
                  <td>
                    <button class="btn btn-primary" name="save_button"><i class="fa fa-save"></i> Save</button>
                    <a href="menu.php" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to list</a>
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
