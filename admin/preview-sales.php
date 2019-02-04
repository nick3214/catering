<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
?>
<html>
<title>Print Preview</title>
<link rel="stylesheet" href="../bootstrap/bower_components/bootstrap/dist/css/bootstrap.min.css">
<head></head>
<style>
 	
 	@media print {
  #hide {
    display: none;
  }
}

    @media screen{
    	thead{
    		display:none;
    	}
    }
    @media print{
    	thead{
    		display:table-header-group; margin-bottom:2px;
    	}
   	}
    @page{
    	margin-top:1cm;margin-left:1cm;margin-right:1cm;margin-bottom:1.5cm;
    	}
    }
</style>
<body>
	<table class="table table-bordered" style="font-size:10px;">
    <thead>
        <tr>
            <th colspan="10">
                <center><img src="../images/logo.png" align="center" width="200"> </center>
                <center><span style="font-size:16px;">JMDC TRATTORIAS</span><br>Lot 8 Block 26, Katipunan St., Kingspoint Subd.
Bagbag, Quezon City
JOSE ANGELO CERDON – Prop.
09156726535</center>

            </th>
        </tr>
        <tr>
            <td>FROM:</td>
            <td><?php echo $_GET['from_date']?></td>
            <td>Until:</td>
            <td><?php echo $_GET['until_date']?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>

        </tr>
    </thead>
    <tbody>

  <tr>
    <td>Ref. No.</td>
    <td>Reserved Date</td>
    <td>Customer</td>
    <td>Event Type</td>
    <td>Reserved Sched.</td>
    <td>MOP</td>
    <td>Status</td>
    <td>Price</td>
  </tr>
<?php 
    $query = "SELECT * FROM reservations 
    LEFT JOIN user_account on user_account.user_id = reservations.user_id 
    WHERE (date_created BETWEEN '".$_GET['from_date']."' AND '".$_GET['until_date']."') AND reservation_status = 'Fully Paid' OR reservation_status = 'Paid Initial Deposit'";
	$getSales = getdata_inner_join($query);
?>
<?php 
	if(!empty($getSales)):
?>
<?php 
foreach ($getSales as $key => $value):
$selectReserve = single_get("*","tcode","reservations",$value->tcode);//Select Reservation
$packages = single_get("*","code","packages",$selectReserve['package_code']);//Select Packages

$otherQuery = "SELECT SUM(a_price) as ServicePrice FROM reservation_others 
INNER JOIN amenities on amenities.a_name = reservation_others.amenity_name
WHERE reservation_others.tcode='".$value->tcode."'";
$others = single_inner_join($otherQuery);//Select Other Amenities

$menuQuery = "SELECT cost_per_head as total  FROM menu_selection
INNER JOIN food_items on food_items.item_id = menu_selection.item_id
WHERE menu_selection.tcode = '".$value->tcode."'";
$menu = single_inner_join($menuQuery);//Menu Selection

$paxQuery = "SELECT SUM(pax_price * pax_person) as totalPax, SUM(pax_person) as sumPax FROM additional_pax WHERE tcode = '".$value->tcode."'";
$pax = single_inner_join($paxQuery);//Additional Pax

$themeQuery = "SELECT * FROM reservations INNER JOIN themes on themes.theme_name = reservations.event_theme WHERE tcode = '".$value->tcode."'";
$theme = single_inner_join($themeQuery);

$extensionQuery = "SELECT SUM(ex_price * ex_qty) as extensionTotal  FROM package_extension WHERE code = '".$value->tcode."'";
$extension = single_inner_join($extensionQuery);

$getReservation = single_get("*","setting_id","site_settings",'4');//get reservation fee
$getTransportation = single_get("*","setting_id","site_settings",'5');//get transportation fee
$getDownpayment = single_get("*","setting_id","site_settings",'2');//get transportation fee


$selectReserve = single_get("*","tcode","reservations",$value->tcode);//Select Reservation
    $packages = single_get("*","code","packages",$selectReserve['package_code']);//Select Packages

    $otherQuery = "SELECT SUM(sub_total) as ServicePrice FROM reservation_others 
    INNER JOIN amenities on amenities.a_name = reservation_others.amenity_name
    WHERE reservation_others.tcode='".$value->tcode."'";
    $others = single_inner_join($otherQuery);//Select Other Amenities

    $kweri = "SELECT SUM(pax_person) as total FROM additional_pax WHERE tcode = '".$value->tcode."'";
    $j = single_inner_join($kweri); 
    $MyTotal = ($packages['total_price'] *  ($selectReserve['pax'] + $j['total'])) + $others['ServicePrice'];



$getTotal = $MyTotal;

  //$reservationFee = $getReservation['setting_value'] ; 
  //$transportationFee = '0.00';



$Downpayment = $MyTotal * ($getDownpayment['setting_value'] / 100);
$Balance = $MyTotal - $Downpayment;

//$down += $Downpayment;
//$full += $MyTotal; 
?>
	<tr>
    <td><?php echo $value->tcode?></td>
    <td><?php echo $value->date_created?></td>
    <td>
        <?php if($value->reservation_name == ''): echo $value->full_name; else: echo $value->reservation_name; endif;?>
    </td>
    <td>
        <?php echo $value->event_name?>
    </td>
    <td><?php echo $value->event_date?> / <?php echo $value->event_time?></td>
    
    <td>
        <?php if($value->reservation_name == ''): echo "Online Payment(Paypal)"; else: echo "Walkin Reservation(Cash)"; endif;?>
    </td>
    <td><?php echo $value->reservation_status?></td>
    <td>
        <?php if($value->reservation_status == 'Paid Initial Deposit'):
        echo number_format($Downpayment);
        ?>

        <?php elseif($value->reservation_status == 'Fully Paid'):
        echo number_format($MyTotal);?>
        <?php endif;?>
    </td>
  </tr>

<?php endforeach;?>
<tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>
        <!--<strong>Total:</strong>-->
    </td>
    <td></strong>
    <?php if($value->reservation_status == 'Paid Initial Deposit'):
        //echo number_format($down);
        ?>

        <?php elseif($value->reservation_status == 'Fully Paid'):
        //echo number_format($full);?>
        <?php endif;?></strong>
    </td>
</tr>
<?php else:?>
<?php endif;?>
    </tbody>

</table>
<div class="row">
<div class="col-md-4">Created by:<br><strong><?php echo $_SESSION['full_name']?></strong></div>
<div class="col-md-4">Prepared by:<br><strong><?php echo $_SESSION['full_name']?></strong></div>
<div class="col-md-4">Date:<br><strong><?php echo date("Y-m-d");?></strong></div>
</div>
<center><a href="" class="btn btn-primary" id="hide" onclick="print()">Print Now</a></center>
</body>
</html>