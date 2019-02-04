<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_admin'])){
  header("Location: ../index.php");
  exit;
}
if(isset($_POST['save_button']) AND !isset($_GET['f_id'])){
  $f_name =$_POST['f_name'];
  $user = $_SESSION['user_email'];

  $checkName = single_get("*","f_name","food_categories",$f_name);
  if($checkName['f_name'] == $f_name){
    $msg = 'Name: '.$f_name.' already exist on database.';
  }
  else{
    $insertSQL = array("f_name"=>$f_name,"created_by"=>$user, "date_created"=>date("Y-m-d h:i:s"));
    insertdata("food_categories",$insertSQL);
    header("location: food_categories.php");
  }
}
if(isset($_GET['f_id'])){
  $row = single_get("*","f_id","food_categories",$_GET['f_id']);
}
if(isset($_POST['save_button']) && isset($_GET['f_id'])){
  $f_name =$_POST['f_name'];
  $user = $_SESSION['user_email'];
  $date = date("Y-m-d h:i:s"); 
  $update = $dbcon->query("UPDATE food_categories SET f_name='$f_name', date_modified='$date', last_modified='$user' WHERE f_id = '".$_GET['f_id']."'") or die(mysqli_error());
  header("location: food_categories.php");
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
              <h4 class="box-title"><i class="fa fa-plus"></i> Create Item Category  </h4>
            </div>
<?php if(isset($msg)):?><div class="alert alert-danger"><?php echo $msg;?></div><?php endif;?>
            <form method="post">
            <table class="table table-responsive table-bordered">
                <tr>
                  <td>Name:</td>
                  <td>
                    <input type="text" name="f_name" class="form-control" placeholder="Name" required="required"
                    value="<?php if(isset($_GET['f_id'])): echo $row['f_name']; elseif(isset($_POST['save_button'])): echo $_POST['f_name']; endif;?>">
                  </td>
                </tr>
                <tr>
                  <td></td>
                  <td>
                    <button class="btn btn-primary" name="save_button"><i class="fa fa-save"></i> Save</button>
                    <a href="food_categories.php" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to list</a>
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
