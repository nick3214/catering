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
    WHERE (event_date BETWEEN '".$_GET['from_date']."' AND '".$_GET['until_date']."') AND reservation_status = 'Cancelled'";
	$getSales = getdata_inner_join($query);
?>
<?php 
	if(!empty($getSales)):
?>
<?php 
foreach ($getSales as $key => $value):
$selectReserve = single_get("*","tcode","reservations",$value->tcode);//Select Reservation
$packages = single_get("*","code","packages",$selectReserve['package_code']);//Select Packages

$otherQuery = "SELECT * FROM reservation_others 
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

if($selectReserve['event_city'] == 'Valenzuela City'){
  if($packages['p_type'] == '1' OR $packages['p_type'] == '0'){
    $MyTotal = $packages['no_person'] + $pax['sumPax'];
    $menuQuery = "SELECT SUM($MyTotal * cost_per_head) as total  FROM menu_selection
    INNER JOIN food_items on food_items.item_id = menu_selection.item_id
    WHERE menu_selection.tcode = '".$value->tcode."'";
    $MenuTotal = single_inner_join($menuQuery);//Menu Selection

    $getTotal = $getReservation['setting_value'] + ($others['quantity'] * $others['a_price']) + $packages['total_price'] + $theme['theme_price'] + $MenuTotal['total'] + $extension['extensionTotal'] + $pax['totalPax'];
    
    $sub_total = ($others['quantity'] * $others['a_price']) + $packages['total_price'] + $theme['theme_price'] + $MenuTotal['total'] + $extension['extensionTotal'] + $pax['totalPax'];
  }else{
    $paxQuery = "SELECT SUM(pax_person) as pax_person1 FROM additional_pax WHERE tcode = '".$value->tcode."' AND pax_type='1'";
    $Kidspax = single_inner_join($paxQuery);

    $kweri = "SELECT SUM(pax_person) as pax_person2 FROM additional_pax WHERE tcode = '".$value->tcode."' AND pax_type='2'";
    $Adultspax = single_inner_join($kweri);

    $kidsTotal = $packages['no_kids'] + $Kidspax['pax_person1'];
    $adultsTotal = $packages['no_adults'] + $Adultspax['pax_person2'];

    $menuQuery = "SELECT SUM($kidsTotal * cost_per_head) as kidstotal, SUM($adultsTotal * cost_per_head) as adultstotal   FROM menu_selection
    INNER JOIN food_items on food_items.item_id = menu_selection.item_id
    WHERE menu_selection.tcode = '".$value->tcode."'";
    $MenuTotal = single_inner_join($menuQuery);//Menu Selection

    $getTotal = $getReservation['setting_value'] + ($others['quantity'] * $others['a_price']) + $packages['total_price'] + $theme['theme_price'] + $MenuTotal['kidstotal'] + $MenuTotal['adultstotal'] + $extension['extensionTotal'] + $pax['totalPax'];
    
   $sub_total = ($others['quantity'] * $others['a_price']) + $packages['total_price'] + $theme['theme_price'] + $MenuTotal['kidstotal'] + $MenuTotal['adultstotal'] + $extension['extensionTotal'] + $pax['totalPax'];
  }
  
  $reservationFee = $getReservation['setting_value'] ; 
  $transportationFee = '0.00';

}elseif($selectReserve['event_city'] != 'Valenzuela City'){
  if($packages['p_type'] == '1' OR $packages['p_type'] == '0'){
    $MyTotal = $packages['no_person'] + $pax['sumPax'];
    $menuQuery = "SELECT SUM($MyTotal * cost_per_head) as total  FROM menu_selection
    INNER JOIN food_items on food_items.item_id = menu_selection.item_id
    WHERE menu_selection.tcode = '".$value->tcode."'";
    $MenuTotal = single_inner_join($menuQuery);//Menu Selection

    $getTotal = $getReservation['setting_value'] + $getTransportation['setting_value'] + ($others['quantity'] * $others['a_price']) + $packages['total_price'] + $theme['theme_price'] + $MenuTotal['total'] + $extension['extensionTotal'] + $pax['totalPax'];
    
    $sub_total = ($others['quantity'] * $others['a_price']) + $packages['total_price'] + $theme['theme_price'] + $MenuTotal['total'] + $extension['extensionTotal'] + $pax['totalPax'];
  }else{
    $paxQuery = "SELECT SUM(pax_person) as pax_person1 FROM additional_pax WHERE tcode = '".$value->tcode."' AND pax_type='1'";
    $Kidspax = single_inner_join($paxQuery);

    $kweri = "SELECT SUM(pax_person) as pax_person2 FROM additional_pax WHERE tcode = '".$value->tcode."' AND pax_type='2'";
    $Adultspax = single_inner_join($kweri);

    $kidsTotal = $packages['no_kids'] + $Kidspax['pax_person1'];
    $adultsTotal = $packages['no_adults'] + $Adultspax['pax_person2'];

    $menuQuery = "SELECT SUM($kidsTotal * cost_per_head) as kidstotal, SUM($adultsTotal * cost_per_head) as adultstotal   FROM menu_selection
    INNER JOIN food_items on food_items.item_id = menu_selection.item_id
    WHERE menu_selection.tcode = '".$value->tcode."'";
    $MenuTotal = single_inner_join($menuQuery);//Menu Selection

    $getTotal = $getReservation['setting_value'] + $getTransportation['setting_value'] + ($others['quantity'] * $others['a_price']) + $packages['total_price'] + $theme['theme_price'] + $MenuTotal['kidstotal'] + $menuTotal['adultstotal'] + $extension['extensionTotal'] + $pax['totalPax'];
    
    $sub_total = ($others['quantity'] * $others['a_price']) + $packages['total_price'] + $theme['theme_price'] + $MenuTotal['kidstotal'] + $menuTotal['adultstotal'] + $extension['extensionTotal'] + $pax['totalPax'];
  }

  $transportationFee = $getTransportation['setting_value'];
  $reservationFee = $getReservation['setting_value'];
}

$Downpayment = $getTotal * ($getDownpayment['setting_value'] / 100);
$Balance = $getTotal - $Downpayment;
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
        0.00 
    </td>
  </tr>

<?php endforeach;?>
<?php else:?>
<?php endif;?>
    </tbody>

</table>
<center><a href="" class="btn btn-primary" id="hide" onclick="print()">Print Now</a></center>
</body>
</html>