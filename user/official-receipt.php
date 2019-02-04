<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';


$selectReserve = single_get("*","tcode","reservations",$_GET['tcode']);//Select Reservation
$user = single_get("*","user_id","user_account",$selectReserve['user_id']);
$packages = single_get("*","code","packages",$selectReserve['package_code']);//Select Packages

$otherQuery = "SELECT SUM(sub_total) as ServicePrice FROM reservation_others 
INNER JOIN amenities on amenities.a_name = reservation_others.amenity_name
WHERE reservation_others.tcode='".$_GET['tcode']."'";
$others = single_inner_join($otherQuery);//Select Other Amenities

$menuQuery = "SELECT cost_per_head as total  FROM menu_selection
INNER JOIN food_items on food_items.item_id = menu_selection.item_id
WHERE menu_selection.tcode = '".$_GET['tcode']."'";
$menu = single_inner_join($menuQuery);//Menu Selection

$paxQuery = "SELECT SUM(pax_price * pax_person) as totalPax, SUM(pax_person) as sumPax FROM additional_pax WHERE tcode = '".$_GET['tcode']."'";
$pax = single_inner_join($paxQuery);//Additional Pax

$themeQuery = "SELECT * FROM reservations INNER JOIN themes on themes.theme_name = reservations.event_theme WHERE tcode = '".$_GET['tcode']."'";
$theme = single_inner_join($themeQuery);

$extensionQuery = "SELECT SUM(ex_price * ex_qty) as extensionTotal  FROM package_extension WHERE code = '".$_GET['tcode']."'";
$extension = single_inner_join($extensionQuery);

$kweri = "SELECT SUM(pax_person) as total FROM additional_pax WHERE tcode = '".$_GET['tcode']."'";
$j = single_inner_join($kweri); 
$MyTotal = ($packages['total_price'] *  ($selectReserve['pax'] + $j['total'])) + $others['ServicePrice'];

$getReservation = single_get("*","setting_id","site_settings",'4');//get reservation fee
$getTransportation = single_get("*","setting_id","site_settings",'5');//get transportation fee
$getDownpayment = single_get("*","setting_id","site_settings",'2');//get transportation fee



$Downpayment = $MyTotal * ($getDownpayment['setting_value'] / 100);
$Balance = $MyTotal - $Downpayment;
   
//end computation //
if(isset($_POST['save_button'])){
  $tcode = filter($_GET['tcode']);
  $update = $dbcon->query("UPDATE reservations SET reservation_status = 'Posted' WHERE tcode= '$tcode'") or die(mysqli_error());
  header("location: reservations.php");
}
if(isset($_POST['pay_button'])){
  $mypayment = filter($_POST['mypayment']);
  $tcode = filter($_POST['tcode']);
  $input_price = filter($_POST['input_price']);
  $t_status = filter($_POST['t_status']);
  $change = $input_price - $mypayment; 
  if($input_price < $mypayment){
    echo '<script>alert("You must pay '.$mypayment.'");</script>';
  }else{
    $insertSQL = array("tcode"=>$tcode,"amt"=>$mypayment,"t_status"=>$t_status);
    insertdata("transactions",$insertSQL);
    if($t_status == '0'){
      $stat = 'Paid Initial Deposit';
    }else{
      $stat = 'Fully Paid';
    }
    $update = $dbcon->query("UPDATE reservations SET reservation_status = '$stat' WHERE tcode = '$tcode'") or die(mysqli_error());
    echo '<script type="text/javascript">
  alert("You have successfully paid '.$input_price.'. Your change is '.$change.'");
  location.href = "walkin-reservation.php";</script>';
  }
}
?>
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
<link rel="stylesheet" href="../bootstrap/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../bootstrap/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../bootstrap/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="../bootstrap/bower_components/fullcalendar/dist/fullcalendar.min.css">
  <link rel="stylesheet" href="../bootstrap/bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">
  <!-- Theme style -->
  <link rel="stylesheet" href="../bootstrap/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="../bootstrap/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="../bootstrap/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../bootstrap/dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="../bootstrap/bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="../bootstrap/bower_components/jvectormap/jquery-jvectormap.css">
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
    <body>
        <h1><center>JMDC KITCHENETTE</center></h1>
        <center>
            <strong>Lot 8 Block 26, Katipunan St. Kingspoint Subd.</strong><br>
        bagbag Quezon City<br>
        Jose Angelo S. Cedon - Prop.<br>
        NON VAT Reg. TIN: 275-047-461-00
        </center>
    <div class="container" style="border:1px solid;padding:5px;">
        <div class="row">
            <div class="col-lg-10" >
                <strong>Official Receipt</strong>
            </div>
             <div class="col-lg-2">
                <strong>Date: <?php echo date("Y-m-d");?></strong>
            </div>
            <br>
            <div class="row" style="padding:15px;">
                <div class="col-lg-12">
                    <p style="font-size:18px;">Recieved from <strong><?php echo $user['full_name']?></strong> with TIN: ______________ and address at <strong><?php echo $selectReserve['event_venue']?></strong> engaged in the business style of <u><strong><?php echo $selectReserve['event_name']?></strong></u> the sum of <u><strong>&#8369; <?php echo number_format($MyTotal);?></strong></u> pesos</p><br>
                    (P <u>&#8369; <?php echo number_format($MyTotal);?></u>) In Partial / Full Payment of <?php if($selectReserve['reservation_status'] == 'Paid Initial Deposit'):?> &#8369; <?php echo number_format($Balance);?> <?php else:?><?php echo number_format($MyTotal);?><?php endif;?><br>
            
                </div>
                <br><br><br>
                <div class="col-lg-3" style="border:1px solid; margin:15px;">Sr. Citizen TIN</div>
                <div class="col-lg-3" style="border:1px solid; margin:15px;">OSCA / PWD No.</div>
                <div class="col-lg-3" style="border:1px solid; margin:15px;">Signiture</div>
                
                
                <div class="col-lg-3">
                    50 bklts. (50x3) 0001-2500<br>
                    BIR PERMIT NO. OCN3AU0001489382<br>
                    Date Issued: 10/24/2017<br>
                    Valid Until: 10/23/2017<br>
                    <br>
                    Printer's Accreditation Date: January 15, 2004
                </div>
                <div class="col-lg-3">
                    <strong>Printed By:</strong> JIMBES Printing<br>
                    VAT Reg. TIN: 160-908-772-000<br>
                    301 Quirino Highway, Brgy Baesa Quezon City. Tel: 455-6138
                </div>
                <div class="col-lg-3">
                    <strong>By:</strong><br><br><br><br>
                    <u>Jose Angelo S. Cedon</u>
                </div>
                </div>
            </div>
        </div>
        
    </div>
    </body>
</html>