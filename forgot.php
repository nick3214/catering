<?php 
include'config/db.php';
include'config/main_function.php';
include'config/functions.php';

if(!empty($_SESSION['login_user']))
{
    header("location: user/index.php");
}
if(!empty($_SESSION['login_admin']))
{
    header("Location: admin/index.php");
}
if(isset($_POST['forgot_btn'])){
  $user_email = filter($_POST['user_email']);
  

  if(ForgotPassword($user_email)){
    
    $Password = md5("newpassword123");
    
    $arr_where = array("user_email"=>$user_email);//update where
    $arr_set = array("user_pass"=>$Password);//set update
    $tbl_name = "user_account";
    $update = update($dbcon,$tbl_name,$arr_set,$arr_where);// UPDATE SQL
  
  
    $subject = "Forgot Password";
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= "From: supportadmin@en-hancezo.com" . "\r\n";
    $to = $user_email;
    $message = "Hello Customer,<br>
      <p>We've sent you an email with the instruction to reset your password.</p>
      <p>Username: ".$user_email."</p>
      <p>New Password: newpassword123</p>

      <a href='http://tratskitchenette.study-call.com/login.php>Click here to login</a>
      <p>Thank you<br>
      Administrator</p>";
    $mailme = mail($to,$subject,$message,$headers);
    $success = '<div class="alert alert-success">You have successfully change your password. Please check your email</div>'; 
  }else{
    $msg = '<div class="alert alert-danger">Please enter a valid credential.</div>';
  }
} 
?>
<?php include'assets/header.php';?>

      </nav> 

    </div>
  </div>
  <div style="margin:100px;"></div>
   <div class="container" style="background:white; padding:60px;width:50%;">
        <div class="row" style="margin:10px;margin-top:40px;">
        <center><h1 class="text-primary"><i class="fa fa-th"></i> Forgot Password</h1>
        <p>Please enter your email address to send your new password</p>
        <?php if(isset($msg)): echo $msg; endif;?>
  <?php if(isset($success)): echo $success; endif;?>
  </center>
  <br>
  <form method="post">
  <div class="row">
    <div style="width:400px;margin: 0 auto;">
        <center>
            <input type="email" name="user_email" class="form-control" placeholder="Please enter your email address" required="required">
        </center>
      
    </div>
    <br>
    <div class="col-md-4"></div>
    <div class="col-md-8">
      <button class="btn btn-primary" name="forgot_btn"><i class="fa fa-save"></i> Reset Password</button>
      <a href="index.php" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Cancel</a>
    </div>
  </div>
  </form>
  
  </div>
        </div><!-- / row -->
        <!-- / row -->
    </div><!-- / container -->
    <div style="margin:100px;"></div>
<?php include'assets/footer.php';?>
</body>
</html>



