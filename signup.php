<?php 
include'config/db.php';
include'config/functions.php';
include'config/main_function.php';

if(!empty($_SESSION['login_user']))
{
    header("location: user/index.php");
}
if(!empty($_SESSION['login_admin']))
{
    header("Location: admin/index.php");
}

if(isset($_POST['register_btn'])){
    $user_email = filter($_POST['user_email']);
    $user_pass = filter($_POST['user_pass']);
    $confirm_pass = filter($_POST['confirm_pass']);
    $contact_num = filter($_POST['contact_num']);
    $full_name = filter($_POST['full_name']);
    $age = filter($_POST['age']);
    $gender = filter($_POST['gender']);
    $checkUser = single_get("*","user_email","user_account",$user_email);
    $checkName = single_get("*","full_name","user_account",$full_name);
    $checkContact = single_get("*","contact_num","user_account",$contact_num);
    if($user_pass != $confirm_pass){
        $msg = 'Your password do not matched please try again.';
    }elseif($checkUser['user_email'] == $user_email){
        $msg = 'Email address: '.$user_email.' already exist on the database.';
    }elseif($checkName['full_name'] == $full_name){
        $msg = 'Name: '.$full_name.' already exist on the database.';
    }elseif($checkContact['contact_num'] == $contact_num){
        $msg = 'Contact Number: '.$contact_num.' already exist on the database.';
    }elseif(is_numeric($full_name)){
        $msg = 'We don not accept numbers for Name.';
    }elseif(!is_numeric($contact_num) OR !is_numeric($age)){
        $msg = 'Please enter numbers only.';
    }elseif($age < 18){
        $msg = 'Please make sure you are 18 years old and above.';
    }
    else{
        $signup = array("user_email"=>$user_email,"user_pass"=>md5($user_pass),
            "contact_num"=>$contact_num,"full_name"=>$full_name,"age"=>$age,
            "gender"=>$gender,"user_role"=>"1","user_status"=>"0");
        insertdata("user_account",$signup);
        $subject = "New User Registration";
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= "From: supportadmin@en-hancezo.com" . "\r\n";
        $to = $_POST['user_email'];
        $message = "Hello ".$full_name.",<br><p>Please be informed that you have succesfully registered to our website.</p>
      <p>Please verify your account by clicking to this link</p><br>
      <a href='http://www.tratskitchenette.tk/verified.php?user_name=".$user_email."&pass=".md5($user_pass)."'>Verify your account</>
      <p>Thank you<br>Administrator</p>";
      $mailme = mail($to,$subject,$message,$headers);
        header("location: success.php");
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

<!-- preloader -->
<div id="preloader">
    <div class="spinner spinner-round"></div>
</div>
<!-- / preloader -->

<div id="top"></div>

<!-- header -->
<header>
    <nav class="navbar navbar-default dark-bg page-nav navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><img src="images/25395533_1594206917288749_1709393525_n.png" alt="logo" class="inline-logo"> <img src="images/25395533_1594206917288749_1709393525_n.png" alt="logo" class="collapsed-logo" align="left"></a><p style="font-size:12px;width: 100%;" class="slide-title fadeInUp animated second space-top-30"><span style="font-size:20px;color:red;font-family: 'Lobster', cursive;">Earviems Catering Services</span> </p>
            </div><!-- / navbar-header -->
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="index.php" class="page-scroll"><span class="fa fa-home"></span> HOME</a></li>
                    <li><a href="index.php" class="page-scroll"><span class="fa fa-user"></span> ABOUT</a></li>
                    <li><a href="index.php" class="page-scroll"><span class="fa fa-list"></span> PACKAGES</a></li>
                    <li><a href="index.php" class="page-scroll"><span class="fa fa-photo"></span> GALLERY</a></li>
                    <li><a href="signup.php" class="page-scroll"><span class="fa fa-pencil"></span> REGISTER</a></li>
                    <li><a href="login.php" class="page-scroll"><span class="fa fa-lock"></span> LOGIN</a></li>
                    <li><a href="index.php" class="page-scroll"><span class="fa fa-phone"></span> CONTACT</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div><!-- / container -->
    </nav>
</header>
<!-- / header -->

<!-- content -->

<div class="space-80">&nbsp;</div>

<section id="about">
    <div class="container">
        <div class="row" style="margin:10px;">
        <h1 class="text-primary"><i class="fa fa-pencil"></i> Signup Here</h1>
        <p>Please fill up all the fields to register to the website.</p>
        <?php if(isset($msg)):?> <div class="alert alert-danger"><?php echo $msg;?></div><?php  endif;?>
        <?php if(isset($success)):?> <div class="alert alert-success"><?php echo $success;?></div><?php  endif;?>
           <form id="reservationForm" method="post">
                <div class="row">
                    <div class="col-sm-6 reservation-left-area">
                       <!-- / form-group -->
                       <div class="form-group">
                            <input type="text" class="form-control" name="user_email" placeholder="Email Address" required="required" value="<?php if(isset($_POST['register_btn'])): echo $_POST['user_email']; else: echo'';endif;?>">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="confirm_pass" placeholder="Confirm Password" required="required">
                        </div><!-- / form-group -->
                        
                        <div class="form-group">
                            <input type="text" class="form-control" name="age" placeholder="Age" required="required" maxlength="2" value="<?php if(isset($_POST['register_btn'])): echo $_POST['age']; else: echo'';endif;?>">
                        </div>
                        <div class="form-group">
                            
                            <select class="form-control" name="gender">
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div><!-- / form-group -->
                    </div>
                    <div class="col-sm-6 reservation-right-area">
                        <div class="form-group">
                            <input type="password" class="form-control" name="user_pass" placeholder="Password" required="required">
                        </div><!-- / form-group -->
                        <div class="form-group">
                            <input type="text" class="form-control" name="full_name" placeholder="Full Name" required="required" value="<?php if(isset($_POST['register_btn'])): echo $_POST['full_name']; else: echo'';endif;?>">
                        </div><!-- / form-group -->
                        <div class="form-group">
                            <input type="text" class="form-control" name="contact_num" placeholder="PHONE" required="required" maxlength="11" value="<?php if(isset($_POST['register_btn'])): echo $_POST['contact_num']; else: echo'';endif;?>">
                        </div>

                        <!-- / form-group -->
                    </div>
                    <!-- textarea and button -->
                    <div class ="col-xs-12 textarea-button">
                    <!-- / form-group -->
                        <div class="text-center">
                            <button name="register_btn" class="btn btn-lg btn-primary-filled btn-form-submit btn-pill wow fadeInUp first"><i class="fa fa-pencil"></i><span><b>Signup</b></span></button>
                            <div class="clearfix"></div>
                        </div><!-- / text-center -->
                    </div>
                    <!-- / textarea and button -->
                </div><!-- / row -->
            </form>
        </div><!-- / row -->
        <!-- / row -->
    </div><!-- / container -->
</section>

<a href="#top" class="scroll-to-top page-scroll is-hidden" data-nav-status="toggle"><i class="fa fa-angle-up"></i></a>
<!-- / scroll to top -->

<!-- footer -->
<footer>
    <div class="container">
        <p class="footer-info">© 2017 - All Rights Reserved.
            <span class="social pull-right">
                <a href="#"><i class="fa fa-facebook"></i></a>
                <a href="#"><i class="fa fa-twitter"></i></a>
                <a href="#"><i class="fa fa-instagram"></i></a>
                <a href="#"><i class="fa fa-pinterest"></i></a>
            </span>
        </p>
    </div><!-- / container -->
</footer>
<!-- / footer -->

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