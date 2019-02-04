<?php 
include'config/db.php';
include'config/main_function.php';
include'config/functions.php';
$g = single_get("*","tcode","reservations",$_GET['tcode']);
$user = single_get("*","user_id","user_account",$g['user_id']);
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
<title>Trats Kitchen</title>
<!-- bootstrap css -->
<link rel="stylesheet" href="bootstrap/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bootstrap/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bootstrap/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="bootstrap/bower_components/fullcalendar/dist/fullcalendar.min.css">
  <link rel="stylesheet" href="bootstrap/bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">
  <!-- Theme style -->
  <link rel="stylesheet" href="bootstrap/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="bootstrap/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="bootstrap/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="bootstrap/dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="bootstrap/bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="bootstrap/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="../bootstrap/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../bootstrap/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="../bootstrap/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

<style type="text/css">
@media print {
    #printbtn {
        display :  none;
    }
}
body{
  font-size:16px;
}
</style>  

</head>

<body>
<div class="container" style="border:5px solid;">
  <center>
      <h1>CONTRACT OF AGREEMENT</h1>
      <h5>Lot8 Blk26 Katipunan St., Kingspoint Subd, Novaliches Q.C</h5>
      <h5>Email: chefgelorats@gmail.com</h5>
      <h5>Contact #: 0915-6726535/0927-6063711</h5>
  </center>
<p>Trat's Kitchen Catering Services, with the following official address: Lot8 Blk26 Katipunan St., Kingspoint Subd, Novaliches Q.C:agrees to serve as the food caterer for the following person, groups and entities:</p>
<div class="row">
    <div class="col-md-6">
        <ul style="line-height:35px;">
    <li>The contents of this contract must remain confidential.</li>
    <li>Failure to comply with the terms and conditions in this agreement invalidates the contract.</li>
    <li>Catering is within the area of Metro Manila.</li>
    <li>Minimum pax 100pax.</li>
    <li>The management will call the customer about the payment details.</li>
    <li>Sessions will be held in 3 hours (min) – 5 hours (max)</li>
    <li>“Five event per day” policy.</li>
    <li>For instances, if there is other food that is not include by the Trattoria’s Kitchenette the customer must read and agree to the waiver statement that will be given so the company will not be responsible for any food poisoning, issues, etc.</li>
    <li>Does not include LCD Projector and screen.</li>
    <li>All set items will remain as property of Trattoria’s Kitchenette.</li>
    <li>All materials are subject to availability.</li>
    
    </ul>
    </div>
    <div class="col-md-6">
        <ul style="line-height:35px">
    <li>If the materials that was use in the event had broken or lost by the client, the client are responsible for the additional charges.</li>
    <li>
        For the add-ons, price is subject to quotations.<br>
        <li>For every main course, additional Php 60.00</li>
        <li>For every pasta, additional Php 50.00</li>
    </li>        
                <li>Added services may apply’s extra fees.</li>
    <li>The client can make its own package if it doesn’t like the offer packages.
Cancellations  & Refunds</li>
<li>Customer must pay minimum 30% of down-payment.</li>
<li>The 70% will be paid on the exact date of the event (after the event handle)</li>
<li>If the customer wants to cancel its confirmed reservation due to personal reason after two days of the reserved date, the management will get 30% from the advance payment of the customer made as charge for the incurred expenses.</li>
<li>You may cancel this agreement for any reasons.</li>
<li>Refunds will only be given through walk-in and meet-up.</li>
        </ul>
    </div>
</div>


</ul>
<center>
    <u>I have read and fully understand and accept the terms and conditions stated in this contract</u>
</center>
<br>
<br>
<br>
<div class="row">
    <div class="col-md-6">
        Angelo Salvador Cerdon<br>
        <strong>Owner/Event Coordinator</strong>
    </div>
    <div class="col-md-6">
        <?php echo $user['full_name'];?><br>
        <strong>CLIENT NAME</strong>
    </div>
</div>
<br><br>
<center>Date Signed:</center><br><br>
<center><a href="" class="btn btn-danger" onclick="print()" id="printbtn">Print</a></center>    
</body>
</html>