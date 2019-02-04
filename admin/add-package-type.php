<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_admin'])){
  header("Location: ../index.php");
  exit;
}
if(isset($_POST['save_button']) AND !isset($_GET['pt_id'])){
  $pt_code =$_POST['pt_code'];
  $pt_name =$_POST['pt_name'];
  $user = $_SESSION['user_email'];

  $checkName = single_get("*","pt_name","package_type",$pt_name);
  $checkCode = single_get("*","pt_code","package_type",$pt_code);
  if($checkName['pt_name'] == $pt_name){
    $msg = 'Name: '.$pt_name.' already exist on database.';
  }elseif($checkCode['pt_code'] == $pt_code){
    $msg = 'Code: '.$pt_code.' already exist on database.';
  }
  else{
    $insertSQL = array("pt_name"=>$pt_name,"pt_code"=>$pt_code,"created_by"=>$user, "date_created"=>date("Y-m-d h:i:s"));
    insertdata("package_type",$insertSQL);
    header("location: package_types.php");
  }
}
if(isset($_GET['pt_id'])){
  $row = single_get("*","pt_id","package_type",$_GET['pt_id']);
}
if(isset($_POST['save_button']) && isset($_GET['pt_id'])){
  $pt_code =$_POST['pt_code'];
  $pt_name =$_POST['pt_name'];
  $user = $_SESSION['user_email'];
  $date = date("Y-m-d h:i:s"); 
  $update = $dbcon->query("UPDATE package_type SET pt_name='$pt_name',pt_code='$pt_code',date_modified='$date', last_modified='$user' WHERE pt_id = '".$_GET['pt_id']."'") or die(mysqli_error());
  header("location: package_types.php");
}
$pcode = "PT-".rand(0,999)."";
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
              <h4 class="box-title"><i class="fa fa-plus"></i> Create Package Category  </h4>
            </div>
<?php if(isset($msg)):?><div class="alert alert-danger"><?php echo $msg;?></div><?php endif;?>
            <form method="post">
            <table class="table table-responsive table-bordered">
                <tr>
                  <td>Code:</td>
                  <td>
                    <input type="text" name="pt_code" class="form-control" placeholder="Code" required="required"
                    value="<?php if(isset($_GET['pt_id'])): echo $row['pt_code']; elseif(isset($_POST['save_button'])):echo $_POST['pt_code']; else: echo $pcode;endif;?>" readonly>
                  </td>
                </tr>
                <tr>
                  <td>Name:</td>
                  <td>
                    <input type="text" name="pt_name" class="form-control" placeholder="Name" required="required"
                    value="<?php if(isset($_GET['pt_id'])): echo $row['pt_name']; elseif(isset($_POST['save_button'])): echo $_POST['pt_name']; endif;?>">
                  </td>
                </tr>
                <tr>
                  <td></td>
                  <td>
                    <button class="btn btn-primary" name="save_button"><i class="fa fa-save"></i> Save</button>
                    <a href="package_types.php" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to list</a>
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
