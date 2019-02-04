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
    $fname = filter($_POST['fname']);
    $lname = filter($_POST['lname']);
    $full_name = $fname." ".$lname;
    $age = filter($_POST['age']);
    $gender = filter($_POST['gender']);
    $checkUser = single_get("*","user_email","user_account",$user_email);
    $checkName = single_get("*","full_name","user_account",$full_name);
    $checkContact = single_get("*","contact_num","user_account",$contact_num);
    if($user_pass != $confirm_pass){
        $msg = 'Your password do not matched please try again.';
    }elseif($checkUser['user_email'] == $user_email){
    $msg = 'Email address: '.$user_email.' already exist, please try using another email.';
    }elseif($checkName['full_name'] == $full_name){
        $msg = 'Name: '.$full_name.' already exist on the database.';
    }elseif($checkContact['contact_num'] == $contact_num){
        $msg = 'Contact Number: '.$contact_num.' already exist on the database.';
    }elseif(is_numeric($fname)){
        $msg = 'We don not accept numbers for Name.';
    }elseif(is_numeric($lname)){
        $msg = 'We don not accept numbers for Name.';
    }elseif(!is_numeric($contact_num) OR !is_numeric($age)){
        $msg = 'Please enter numbers only.';
    }elseif($age < 18){
        $msg = 'Please make sure you are 18 years old and above.';
    }elseif(strlen($user_pass) < 8){
        $msg = 'Password must be 8 characters and up.';
    }
    else{
        $signup = array(
            "user_email"    =>$user_email,
            "user_pass"     =>md5($user_pass),
            "contact_num"   =>$contact_num,
            "full_name"     =>$full_name,
            "age"           =>$age,
            "gender"        =>$gender,
            "user_role"     =>"1",
            "user_status"   =>"0"
        );
        insertdata("user_account",$signup);
        $subject = "New User Registration";
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= "From: supportadmin@en-hancezo.com" . "\r\n";
        $to = $_POST['user_email'];
        $message = "Hello ".$full_name.",<br><p>Please be informed that you have succesfully registered to our website.</p>
      <p>Please verify your account by clicking to this link</p><br>
      <a href='http://www.tratskitchenette.study-call.com/verified.php?user_name=".$user_email."&pass=".md5($user_pass)."'>Verify your account</>
      <p>Thank you<br>Administrator</p>";
      $mailme = mail($to,$subject,$message,$headers);
        header("location: success.php");
    }
}
?>
<?php include'assets/header.php';?>

      </nav> 

    </div>
  </div>
  <div style="margin:100px;"></div>
   <div class="container" style="background:white; padding:50px;">
 <div class="row" style="margin:10px;">
        <h1 class="text-primary"><i class="fa fa-pencil"></i> Signup Here</h1>
        <p>Please fill up all the fields to register to the website.</p>
        <?php if(isset($msg)):?> <div class="alert alert-danger"><?php echo $msg;?></div><?php  endif;?>
        <?php if(isset($success)):?> <div class="alert alert-success"><?php echo $success;?></div><?php  endif;?>
           <form id="reservationForm" method="post">
<div class="row">
    <div class="col-md-6">
         <input type="text" class="form-control" name="user_email" placeholder="Email Address" required="required" value="<?php if(isset($_POST['register_btn'])): echo $_POST['user_email']; else: echo'';endif;?>">
    </div>
    <div class="col-md-6">
         <input type="password" class="form-control" name="user_pass" placeholder="Password" required="required">
        
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-6">
        <input type="password" class="form-control" name="confirm_pass" placeholder="Confirm Password" required="required">
         
    </div>
    <div class="col-md-6">
        <input type="text" class="form-control" name="fname" placeholder="First Name" required="required" value="<?php if(isset($_POST['register_btn'])): echo $_POST['fname']; else: echo'';endif;?>">

       
        
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-6">
         <input type="text" class="form-control" name="lname" placeholder="Last Name" required="required" value="<?php if(isset($_POST['register_btn'])): echo $_POST['lname']; else: echo'';endif;?>">
        
    </div>
    <div class="col-md-6">
         <input type="text" class="form-control" name="age" placeholder="Age" required="required" maxlength="2" value="<?php if(isset($_POST['register_btn'])): echo $_POST['age']; else: echo'';endif;?>">
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-6">
         
         <select class="form-control" name="gender">
            <option>Male</option>
            <option>Female</option>
        </select>
    </div>
    <div class="col-md-6">
        <input type="text" class="form-control" name="contact_num" placeholder="Phone number" required="required" maxlength="11" value="<?php if(isset($_POST['register_btn'])): echo $_POST['contact_num']; else: echo'';endif;?>">
    </div>
</div>
                <div class="row">
    <br>
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
    <div style="margin:100px;"></div>
<?php include'assets/footer.php';?>
</body>
</html>



