<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_admin'])){
  header("Location: ../index.php");
  exit;
}
if(isset($_POST['save_button']) AND !isset($_GET['occasion_id'])){
  $occasion_name =$_POST['occasion_name'];
  $user = $_SESSION['user_email'];
  $date = date("Y-m-d h:i:s"); 
  $checkName = single_get("*","occasion_name","occasion",$occasion_name);
  if($checkName['occasion_name'] == $occasion_name){
    $msg = 'Name: '.$occasion_name.' already exist on database.';
  }
  else{
    $insertSQL = array("occasion_name"=>$occasion_name,"last_modified"=>$user, "date_modified"=>$date);
    insertdata("occasion",$insertSQL);
    header("location: occasion.php");
  }
}
if(isset($_GET['occasion_id'])){
  $row = single_get("*","occasion_id","occasion",$_GET['occasion_id']);
}
if(isset($_POST['save_button']) && isset($_GET['occasion_id'])){
  $occasion_name =$_POST['occasion_name'];
  
  $user = $_SESSION['user_email'];
  $date = date("Y-m-d h:i:s");
  $update = $dbcon->query("UPDATE occasion SET occasion_name='$occasion_name',
    date_modified='$date', last_modified='$user' WHERE occasion_id = '".$_GET['occasion_id']."'") or die(mysqli_error());
  header("location: occasion.php");
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
              <h4 class="box-title"><i class="fa fa-plus"></i> Add Occasion  </h4>
            </div>
<?php if(isset($msg)):?><div class="alert alert-danger"><?php echo $msg;?></div><?php endif;?>
            <form method="post">
            <table class="table table-responsive table-bordered">
                <tr>
                  <td>Name:</td>
                  <td>
                    <input type="text" name="occasion_name" class="form-control" placeholder="Name" required="required"
                    value="<?php if(isset($_GET['occasion_id'])): echo $row['occasion_name']; elseif(isset($_POST['save_button'])): echo $_POST['occasion_name']; endif;?>">
                  </td>
                </tr>
               
                <tr>
                  <td></td>
                  <td>
                    <button class="btn btn-primary" name="save_button"><i class="fa fa-save"></i> Save</button>
                    <a href="occasion.php" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to list</a>
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
