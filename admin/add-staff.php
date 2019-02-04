<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_admin'])){
  header("Location: ../index.php");
  exit;
}
if(isset($_POST['save_button']) AND !isset($_GET['user_id'])){
  $full_name = filter($_POST['full_name']);
  $user_email = filter($_POST['user_email']);
  $contact_num = filter($_POST['contact_num']);
  $user_pass = filter($_POST['user_pass']);
  $confirm_pass = filter($_POST['confirm_pass']);

  $checkName = single_get("*","full_name","user_account",$full_name);
  $checkEmail = single_get("*","user_email","user_account",$user_email);
  if($checkName['full_name'] == $full_name){
    $msg = 'Name: '.$pt_name.' already exist on database.';
  }elseif($checkEmail['user_email'] == $user_email){
    $msg = 'Email: '.$user_email.' already exist on database.';
  }elseif($user_pass != $confirm_pass){
    $msg = 'Password do not matched please try again.';
  }elseif(!is_numeric($contact_num)){
    $msg = 'Please enter numbers only';
  }
  else{
    $insertSQL = array("full_name"=>$full_name,"user_email"=>$user_email,"user_pass"=>md5($user_pass),"user_role"=>"0","contact_num"=>$contact_num,"user_status"=>"");
    insertdata("user_account",$insertSQL);
    header("location: staff.php");
  }
}
if(isset($_GET['user_id'])){
  $row = single_get("*","user_id","user_account",$_GET['user_id']);
}
if(isset($_POST['save_button']) && isset($_GET['user_id'])){
  $full_name = filter($_POST['full_name']);
  $user_email = filter($_POST['user_email']);
  $contact_num = filter($_POST['contact_num']);
  $user_pass = filter($_POST['user_pass']);
  $confirm_pass = filter($_POST['confirm_pass']);
  
  $update = $dbcon->query("UPDATE user_account SET full_name='$full_name',user_email='$user_email',contact_num='$contact_num' WHERE user_id = '".$_GET['user_id']."'") or die(mysqli_error());
  header("location: staff.php");
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
              <h4 class="box-title"><i class="fa fa-plus"></i> Create Staff  </h4>
            </div>
<?php if(isset($msg)):?><div class="alert alert-danger"><?php echo $msg;?></div><?php endif;?>
            <form method="post">
            <table class="table table-responsive table-bordered">
                
                <tr>
                  <td>Full Name:</td>
                  <td>
                    <input type="text" name="full_name" class="form-control" placeholder="Name" required="required"
                    value="<?php if(isset($_GET['user_id'])): echo $row['full_name']; elseif(isset($_POST['save_button'])): echo $_POST['full_name']; endif;?>">
                  </td>
                </tr>
                <tr>
                  <td>Contact Number:</td>
                  <td>
                    <input type="text" maxlength="11" name="contact_num" class="form-control" placeholder="Contact Number" required="required"
                    value="<?php if(isset($_GET['user_id'])): echo $row['contact_num']; elseif(isset($_POST['save_button'])): echo $_POST['contact_num']; endif;?>">
                  </td>
                </tr>
                <tr>
                  <td>Email Address:</td>
                  <td>
                    <input type="text" name="user_email" class="form-control" placeholder="Email Address" required="required"
                    value="<?php if(isset($_GET['user_id'])): echo $row['user_email']; elseif(isset($_POST['save_button'])): echo $_POST['user_email']; endif;?>">
                  </td>
                </tr>
                <?php if(!isset($_GET['user_id'])):?>
                <tr>
                  <td>Password:</td>
                  <td>
                    <input type="password" name="user_pass" class="form-control" placeholder="Password" required="required">
                  </td>
                </tr>
                <tr>
                  <td>Confirm Password:</td>
                  <td>
                    <input type="password" name="confirm_pass" class="form-control" placeholder="Confirm Password" required="required"
                    >
                  </td>
                </tr>
              <?php endif;?>
                <tr>
                  <td></td>
                  <td>
                    <button class="btn btn-primary" name="save_button"><i class="fa fa-save"></i> Save</button>
                    <a href="staff.php" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to list</a>
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
