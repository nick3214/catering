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

if(isset($_POST['login']))
 {
    $user_email = filter($_POST['user_email']);
    $user_pass = md5(filter($_POST['user_pass']));
    if(has_null($user_email,$user_pass))
    {
      $msg = 'Please enter your username or password.';      
    }
    else
    {
      $check_login = $dbcon->query("SELECT * FROM user_account WHERE user_email = '$user_email' AND user_pass='$user_pass' AND user_status = '1'") or die(mysqli_error());
      $count = mysqli_num_rows($check_login);
      if($count == 0)
      {
        $msg =  'Wrong username/password. OR your account is not yet activated.';         
      }
      else
      {
        while($row = $check_login->fetch_assoc())
        {

          if($row['user_role'] == '0' OR $row['user_role'] == '2')
          {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_email'] = $row['user_email'];
            $_SESSION['user_role'] = $row['user_role'];
            $_SESSION['full_name'] = $row['full_name'];
            $_SESSION['login_admin'] = 'login_admin';
            header("location: admin/");
          }
          elseif($row['user_role'] == '1')
          {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_email'] = $row['user_email'];
            $_SESSION['user_role'] = $row['user_role'];
            $_SESSION['full_name'] = $row['full_name'];
            $_SESSION['login_user'] = 'login_user';
            header("location: user/");
          }
        }
        $dbcon->close();
      }     
    }   
    }
?>
<?php include'assets/header.php';?>

      </nav> 

    </div>
  </div>
  <div style="margin:100px;"></div>
   <div class="container" style="background:white; padding:50px;">
        <div class="row" style="margin:10px;margin-top:50px;">
        <div class="row">
            <div class="col-md-6">
                 <h1 class="text-primary"><i class="fa fa-lock"></i> Login Account</h1>
        <p>Please enter your username and password to login.</p>
        
           <form id="reservationForm" method="post">
                <div class="row">
                    <div class="col-sm-12 reservation-left-area">
                        <div class="form-group">
                            <input type="email" class="form-control" name="user_email" placeholder="Email">
                        </div><!-- / form-group -->
                        <div class="form-group">
                            <input type="password" class="form-control" name="user_pass" placeholder="Password">
                        </div><!-- / form-group -->
                        <button name="login" class="btn btn-lg btn-primary-filled btn-form-submit btn-pill wow fadeInUp first"><i class="fa fa-lock"></i><span><b>Login</b></span></button> or <a href="register.php">Signup Account Here</a> / <a href="forgot.php">Forgot Password</a> 
                        <!-- / form-group -->
                    </div>
                </div><!-- / row -->
            </form>
            </div>
            <div class="col-md-6" style="padding-top:70px;">
                <?php if(isset($msg)):?><span style="color:red;"><?php echo $msg;?></span><?php endif;?>
                
            </div>
        </div>    
            
            
            
            
       
        </div><!-- / row -->
        <!-- / row -->
    </div><!-- / container -->
    <div style="margin:100px;"></div>
<?php include'assets/footer.php';?>
</body>
</html>



