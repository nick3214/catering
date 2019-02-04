<?php 
include'config/db.php';
include'config/functions.php';
include'config/main_function.php';

if(isset($_GET['user_name']) && isset($_GET['pass'])){
    $pass = $_GET['pass'];
    $user_name = $_GET['user_name'];
    $getStatus = $dbcon->query("SELECT * FROM user_account WHERE user_email='$user_name' AND user_pass='$pass' AND user_status
        ='1'") or die(mysqli_error());
    $count =mysqli_num_rows($getStatus);
    if($count == 1){
        $msg = '<div class="alert alert-danger">Account already verified.</div>';
    }else{
    $update = $dbcon->query("UPDATE user_account SET user_status = '1' WHERE user_email='$user_name' AND user_pass='$pass'") or die(mysqli_error());
    $msg = '<div class="alert alert-success">
            <h3 style="color:Black;">You have successfully verified your account.</h3>
            <p><a href="login.php">Please login to continue</a></p></div>';
    }
}
else{
    $msg = '<div class="alert alert-danger">Oooops do not bypass this code.</div>';
}
?>
<?php include'assets/header.php';?>

      </nav> 

    </div>
  </div>
  <div style="margin:100px;"></div>
   <div class="container" style="background:white; padding:50px;">
            <div class="row" style="margin:10px;">
        <div>
            <?php if(isset($msg)): echo $msg; endif;?>
        </div>
        </div><!-- / row -->
        <!-- / row -->
    </div><!-- / container -->
    <div style="margin:100px;"></div>
<?php include'assets/footer.php';?>
</body>
</html>



