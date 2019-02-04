<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_user'])){
  header("Location: ../index.php");
  exit;
}
$loginUser = single_get("*","user_id","user_account",$_SESSION['user_id']);
$item_no = $_GET['item_number'];
$item_transaction = $_GET['tx'];
$item_price = $_GET['amt'];
$item_currency = $_GET['cc'];

$kweri = $dbcon->query("SELECT COUNT(*) as total FROM transactions WHERE tcode = '$item_no'") or die(mysqli_error());
$checkPaypal = $kweri->fetch_assoc();

if($checkPaypal['total'] == 0 AND $_GET['payment_option'] == '0'){
  $result = $dbcon->query("INSERT INTO transactions (`tcode`,`tx`,`amt`,`t_status`,`user_id`) VALUES ('$item_no','".$_GET['tx']."','$item_price','0','".$_SESSION['user_id']."')");
  if($result){
    $updateQuery = $dbcon->query("UPDATE reservations SET reservation_status = 'Paid Initially' WHERE tcode = '$item_no'") or die(mysqli_error());
    $notifSQL = array("n_logs"=>"Customer: ".$_SESSION['full_name']." paid initial deposit worth: ".$item_price." transaction ID: ".$item_no."","user_id"=>$_SESSION['user_id']);
    insertdata("notifications",$notifSQL);
    //Email
     $subject = "Billing Statement and Contract";
     $headers  = 'MIME-Version: 1.0' . "\r\n";
     $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
     $headers .= "From: supportadmin@en-hancezo.com" . "\r\n";
     $to = $loginUser['user_email'];
     $message = "Hello ".$loginUser['full_name'].",<br><p>You have successfully paid initial deposit worth: ".$item_price."</p>
     <p>You may print your billing statement and Contract here:</p>
     <ul>
     <li>Billing statement:<a href='".$billing_down."".$item_no."' target='_blank'>Click to view</a></li>
     <li>Contract Agreement:<a href='".$contract_down."".$item_no."&type=online' target='_blank'>Click to view</a></li>
     <li>Official Receipt:<a href='http://tratskitchenette.study-call.com/official-receipt.php?tcode=".$item_no."'>Click here to view</a></li>
     </ul>
      <p>Thank you<br>Administrator</p>";
      $mailme = mail($to,$subject,$message,$headers);
    //End Email
    $msg = 'You haves successfully paid the initial deposit worth: &#8369; '.number_format($_GET['amt']).'';
  }else{
      $msg = "Payment Error";
  }
}elseif($checkPaypal['total'] ==  0 AND $_GET['payment_option'] == '1'){
   $result = $dbcon->query("INSERT INTO transactions (`tcode`,`tx`,`amt`,`t_status`,`user_id`) VALUES ('$item_no','".$_GET['tx']."','$item_price','1','".$_SESSION['user_id']."')");
  if($result){
    $updateQuery = $dbcon->query("UPDATE reservations SET reservation_status = 'Full Paid' WHERE tcode = '$item_no'") or die(mysqli_error());
    $notifSQL = array("n_logs"=>"Customer: ".$_SESSION['full_name']." paid the reservation worth: ".$item_price." transaction ID: ".$item_no."","user_id"=>$_SESSION['user_id']);
    insertdata("notifications",$notifSQL);
    //Email
     $subject = "Billing Statement and Contract";
     $headers  = 'MIME-Version: 1.0' . "\r\n";
     $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
     $headers .= "From: supportadmin@en-hancezo.com" . "\r\n";
     $to = $loginUser['user_email'];
     $message = "Hello ".$loginUser['full_name'].",<br><p>You have successfully paid the reservation worth: ".$item_price."</p>
     <p>You may print your billing statement and Contract here:</p>
     <ul>
     <li>Billing statement:<a href='".$billing_down."".$item_no."' target='_blank'>Click to view</a></li>
     <li>Contract Agreement:<a href='".$contract_down."".$item_no."&type=online' target='_blank'>Click to view</a></li>
     <li>Official Receipt:<a href='http://tratskitchenette.study-call.com/official-receipt.php?tcode=".$item_no."'>Click here to view</a></li>
     </ul>
      <p>Thank you<br>Administrator</p>";
      $mailme = mail($to,$subject,$message,$headers);
    //End Email
    $msg = 'You haves successfully paid the remaining deposit worth: &#8369; '.number_format($_GET['amt']).'';
  }else{
      $msg = "Payment Error";
  }
}
elseif($checkPaypal['total'] > 0 AND $_GET['payment_option'] == '2'){
   $result = $dbcon->query("INSERT INTO transactions (`tcode`,`tx`,`amt`,`t_status`,`user_id`) VALUES ('$item_no','".$_GET['tx']."','$item_price','1','".$_SESSION['user_id']."')");
  if($result){
    $updateQuery = $dbcon->query("UPDATE reservations SET reservation_status = 'Full Paid' WHERE tcode = '$item_no'") or die(mysqli_error());
    $notifSQL = array("n_logs"=>"Customer: ".$_SESSION['full_name']." paid the reservation worth: ".$item_price." transaction ID: ".$item_no."","user_id"=>$_SESSION['user_id']);
    insertdata("notifications",$notifSQL);
    //Email
     $subject = "TratsKitchen: Billing Statement and Contract";
     $headers  = 'MIME-Version: 1.0' . "\r\n";
     $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
     $headers .= "From: supportadmin@en-hancezo.com" . "\r\n";
     $to = $loginUser['user_email'];
     $message = "Hello ".$loginUser['full_name'].",<br><p>You have successfully paid the reservation worth: ".$item_price."</p>
     <p>You may print your billing statement and Contract here:</p>
     <ul>
     <li>Billing statement:<a href='".$billing_down."".$item_no."' target='_blank'>Click to view</a></li>
     <li>Contract Agreement:<a href='".$contract_down."".$item_no."&type=online' target='_blank'>Click to view</a></li>
     </ul>
      <p>Thank you<br>Administrator</p>";
      $mailme = mail($to,$subject,$message,$headers);
    //End Email
    $msg = 'You haves successfully paid the remaining deposit worth: &#8369; '.number_format($_GET['amt']).'';
  }else{
      $msg = "Payment Error";
  }
}
else{
  $msg = 'Opps you are trying to hack the site.';
}

?>
<?php include'../assets/user_header.php';?>
  <!-- Content Wrapper. Contains page content -->
  <div style="height:20px;"></div>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="width:87%; margin: 0 auto;background: white;border-radius:3px;">
    <!-- Main content -->
    <section class="content">


      <div class="row">
       <div class="container">
        
        <div class="box box-info" style="width:97%;">
            <div class="box-body">
            <!-- Start -->
    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-shopping-cart"></i> Billing Status
            <small class="pull-right">Date: <?php echo date("m/d/Y");?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <div class="row">
        <!-- accepted payments column -->
      <div class="alert alert-success">
        <h2><?php if(isset($msg)): echo $msg; endif;?></h2>
      </div>
      <a href="reservations.php" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Click here to return</a>
    </section>
            <!-- End-->
            </div>
            
          </div>
          <hr>
          
       </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php include'../assets/user_footer.php';?>