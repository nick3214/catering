<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_admin'])){
  header("Location: ../index.php");
  exit;
}
if(isset($_POST['save_button']) AND !isset($_GET['a_id'])){
  $a_name =$_POST['a_name'];
  $a_price = filter($_POST['a_price']);
  
  $user = $_SESSION['user_email'];

  if($_GET['type'] == '0'){
    $a_type = 'Standard';
  }else{
    $a_type = 'Other';
  }

  $checkName = single_get("*","a_name","amenities",$a_name);
  if($checkName['a_name'] == $a_name){
    $msg = 'Name: '.$a_name.' already exist on database.';
  }elseif(!is_numeric($a_price)){
    $msg = 'Please enter digits only.';
  }
  else{
    $insertSQL = array("a_name"=>$a_name,"a_price"=>$a_price,"a_type"=>$a_type,"last_modified"=>$user);
    insertdata("amenities",$insertSQL);
    header("location: amenities.php");
  }
}
if(isset($_GET['a_id'])){
  $row = single_get("*","a_id","amenities",$_GET['a_id']);
}
if(isset($_POST['save_button']) && isset($_GET['a_id'])){
  $a_name =$_POST['a_name'];
  $a_price = filter($_POST['a_price']);
  $user = $_SESSION['user_email'];
  if($_GET['type'] == '0'){
    $a_type = 'Standard';
  }else{
    $a_type = 'Other';
  }
  
  $update = $dbcon->query("UPDATE amenities SET a_name='$a_name',a_price='$a_price',a_type='$a_type',
    date_modified=NOW(), last_modified='$user' WHERE a_id = '".$_GET['a_id']."'") or die(mysqli_error());
  header("location: amenities.php");
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
              <h4 class="box-title"><i class="fa fa-plus"></i> <?php if($_GET['type'] == 0): echo 'Standard Amenities'; else: echo 'Service Information'; endif;?> </h4>
            </div>
<?php if(isset($msg)):?><div class="alert alert-danger"><?php echo $msg;?></div><?php endif;?>
            <form method="post">
            <table class="table table-responsive table-bordered">
                <tr>
                  <td>Name:</td>
                  <td>
                    <input type="text" name="a_name" class="form-control" placeholder="Name" required="required"
                    value="<?php if(isset($_GET['a_id'])): echo $row['a_name']; elseif(isset($_POST['save_button'])): echo $_POST['a_name']; endif;?>">
                  </td>
                </tr>
                <tr>
                  <td>Price:</td>
                  <td>
                  <?php if($_GET['type'] == '0'):?>
                    <input type="number" name="a_price" class="form-control" readonly="readonly" placeholder="0.00" value="<?php if(isset($_GET['a_id'])): echo $row['a_price']; elseif(isset($_POST['save_button'])): echo "0.00"; endif;?>">
                  <?php elseif($_GET['type'] == '1'):?>
                    <input type="number" name="a_price" min = "1" class="form-control" placeholder="Price" required="required" value="<?php if(isset($_GET['a_id'])): echo $row['a_price']; elseif(isset($_POST['save_button'])): echo $_POST['a_price']; endif;?>">
                  <?php endif;?>
                    

                  </td>
                </tr>
                
                <tr>
                  <td></td>
                  <td>
                    <button class="btn btn-primary" name="save_button"><i class="fa fa-save"></i> Save</button>
                    <a href="amenities.php" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to list</a>
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
