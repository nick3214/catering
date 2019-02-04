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
<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Minimal Restaurant Template">
<meta name="keywords" content="responsive, retina ready, html5, css3, restaurant, food, bar, events" />
<meta name="author" content="KingStudio.ro">

<!-- favicon -->
<link rel="icon" href="images/favicon.png">
<!-- page title -->
<title>MR - Minimal Restaurant Template</title>
<!-- bootstrap css -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<!-- css -->
<link href="css/style.css" rel="stylesheet">
<link href="css/animate.css" rel="stylesheet">
<!-- fonts -->
<link href="https://fonts.googleapis.com/css?family=Oleo+Script+Swash+Caps" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Cabin:400,700" rel="stylesheet">
<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href='fonts/FontAwesome.otf' rel='stylesheet' type='text/css'>
</head>

<body>
    <div class="container">
        <div class="row">
        <img src="images/25395533_1594206917288749_1709393525_n.png" style="width: 50%;">
        <h4><center>Login Account</center></h4>
        <?php if(isset($msg)):?><div class="alert alert-danger"><?php echo $msg;?></div><?php endif;?>
           <form id="reservationForm" method="post">
                <div class="row">
                    <div class="col-sm-6 reservation-left-area">
                        <div class="form-group">
                            <input type="email" class="form-control" name="user_email" placeholder="Email">
                        </div><!-- / form-group -->
                        <div class="form-group">
                            <input type="password" class="form-control" name="user_pass" placeholder="Password">
                        </div><!-- / form-group -->
                        <button name="login" class="btn btn-primary"><i class="fa fa-lock"></i><span><b>Login</b></span></button>
                        <a href="register.php" class="btn btn-primary"><i class="fa fa-pencil"></i>Signup</a>
                        <!-- / form-group -->
                    </div>
                </div><!-- / row -->
            </form>
        </div><!-- / row -->
        <!-- / row -->
    </div><!-- / container -->

<!-- / scroll to top -->

<!-- footer -->

<!-- javascript -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<!-- sticky nav -->
<script src="js/jquery.easing.min.js"></script>
<script src="js/scrolling-nav-sticky.js"></script>
<!-- / sticky nav -->

<!-- preloader -->
<script src="js/preloader.js"></script>
<!-- / preloader -->

<!-- wow -->
<script src="js/wow.min.js"></script>
<script>
new WOW().init();
</script>
<!-- / wow -->

<!-- hide nav -->
<script src="js/hide-nav.js"></script>
<!-- / hide nav -->

<!-- / javascript -->

</body>


<!-- Mirrored from kingstudio.ro/demos/mr/about.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 18 Oct 2017 15:11:45 GMT -->
</html>