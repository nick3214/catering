<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_admin'])){
  header("Location: ../index.php");
  exit;
}
if(isset($_POST['change_btn'])){
    $old_pass = md5($_POST['old_pass']);
    $new_pass = filter($_POST['new_pass']);
    $confirm_pass = filter($_POST['confirm_pass']);

    $g = single_get("*","user_email","user_account",filter($_SESSION['user_email']));

    if(has_null($old_pass,$new_pass,$confirm_pass)){
      $msg= 'Please fill up all the fields.';
    } 
    elseif($new_pass != $confirm_pass){
      $msg = 'Password do not matched.';
    }
    elseif($g['user_pass'] != $old_pass){
      $msg = 'Old password do no matched';
    }
    /*
    elseif(!preg_match('/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/',$_POST['new_pass'])){
      $msg = 'Minimum 8 and Maximum 10 characters at least 1 Uppercase Alphabet, 1 Lowercase Alphabet, 1 Number and 1 Special Character:';
    }
    elseif(!preg_match('/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/',$_POST['confirm_pass'])){
      $msg = 'Minimum 8 and Maximum 10 characters at least 1 Uppercase Alphabet, 1 Lowercase Alphabet, 1 Number and 1 Special Character:';
    } */
    else{
      $f = $dbcon->query("UPDATE user_account SET user_pass = '".md5($new_pass)."' WHERE user_email = '".filter($_SESSION['user_email'])."'") or die(mysqli_error());
      $success = 'Password has been successfully updated.';
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
              

              <h4 class="box-title"><i class="fa fa-calendar"></i> Change Password</h4>
            </div>
            <div class="box-body">
             <?php if(isset($msg)):?>
              <div class="alert alert-danger alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <?php echo $msg;?>
              <br />
            </div>
            <?php endif;?>
            <?php if(isset($success)):?>
              <div class="alert alert-success alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <?php echo $success;?>
              <br />
            </div>
            <?php endif;?>
             <form method="post">
             <table class="table table-bordered">
                <tr>
                  <td>Old Password:</td>
                  <td><input type="password" name="old_pass" style="width:90%; height:34px;" placeholder="Old Password"></td>
                </tr>
                 <tr>
                  <td>New Password:</td>
                  <td><input type="password" name="new_pass" style="width:90%; height:34px;" placeholder="New Password"></td>
                </tr>
                 <tr>
                  <td>Confirm Password:</td>
                  <td><input type="password" name="confirm_pass" style="width:90%; height:34px;" placeholder="Confirm Password"></td>
                </tr>
                <tr>
                  <td></td>
                  <td>
                     <button class="btn btn-primary btn-large" name="change_btn"><i class="fa fa-save"></i> Change Password</button>
                <a href="index.php" class="btn btn-danger btn-large"><i class="fa fa-arrow-left"></i> Return</a>
                  </td>
                </tr>
              </table>
          </form>
            </div>
            
          </div>
          <hr>
          
       </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php include'../assets/admin_footer.php';?>
</body>
</html>
