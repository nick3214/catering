<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_user'])){
  header("Location: ../index.php");
  exit;
}
//Paypal Setup
$paypal_url='https://www.sandbox.paypal.com/cgi-bin/webscr'; 
$paypal_id='tratskitchen123@gmail.com'; 
//End
//Computation of Total//
$selectReserve = single_get("*","tcode","reservations",$_GET['tcode']);//Select Reservation
$packages = single_get("*","code","packages",$selectReserve['package_code']);//Select Packages

$otherQuery = "SELECT SUM(sub_total) as ServicePrice, quantity, a_price FROM reservation_others 
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

$getReservation = single_get("*","setting_id","site_settings",'4');//get reservation fee
$getTransportation = single_get("*","setting_id","site_settings",'5');//get transportation fee
$getDownpayment = single_get("*","setting_id","site_settings",'2');//get transportation fee

$motif_type = "select * from reservations inner join motif on reservations.sub_id = motif.id WHERE tcode = '".$_GET['tcode']."'";
$get = single_inner_join($motif_type);

  //if($packages['p_type'] == '1' OR $packages['p_type'] == '0'){
    $kweri = "SELECT SUM(pax_person) as total FROM additional_pax WHERE tcode = '".$_GET['tcode']."'";
    $j = single_inner_join($kweri); 
    $motif_type_price = 0;
    $motif_price = 0;
    if($get['motif_type'] == 1){
      $motif_type_price = 20000;
    }
   
    $MyTotal = (($packages['total_price'] *  ($selectReserve['pax'] + $j['total'])) + $others['ServicePrice'])+$motif_type_price;
    if($get['type'] == "platted"){
      $MyTotal *= .20;
    }else{
      $MyTotal = $MyTotal;
    }
    $menuQuery = "SELECT SUM($MyTotal * cost_per_head) as total  FROM menu_selection
    INNER JOIN food_items on food_items.item_id = menu_selection.item_id
    WHERE menu_selection.tcode = '".$_GET['tcode']."'";
    $MenuTotal = single_inner_join($menuQuery);//Menu Selection

    $getTotal = $getReservation['setting_value'] + ($others['quantity'] * $others['a_price']) + $packages['total_price'] + $theme['theme_price'] + $MenuTotal['total'] + $extension['extensionTotal'] + $pax['totalPax'];
    
    $sub_total = ($others['quantity'] * $others['a_price']) + $packages['total_price'] + $theme['theme_price'] + $MenuTotal['total'] + $extension['extensionTotal'] + $pax['totalPax'];
  //}else{
    /*
    $paxQuery = "SELECT SUM(pax_person) as pax_person1 FROM additional_pax WHERE tcode = '".$_GET['tcode']."' AND pax_type='1'";
    $Kidspax = single_inner_join($paxQuery);

    $kweri = "SELECT SUM(pax_person) as pax_person2 FROM additional_pax WHERE tcode = '".$_GET['tcode']."' AND pax_type='2'";
    $Adultspax = single_inner_join($kweri);

    $kidsTotal = $packages['no_kids'] + $Kidspax['pax_person1'];
    $adultsTotal = $packages['no_adults'] + $Adultspax['pax_person2'];

    $menuQuery = "SELECT SUM($kidsTotal * cost_per_head) as kidstotal, SUM($adultsTotal * cost_per_head) as adultstotal   FROM menu_selection
    INNER JOIN food_items on food_items.item_id = menu_selection.item_id
    WHERE menu_selection.tcode = '".$_GET['tcode']."'";
    $MenuTotal = single_inner_join($menuQuery);//Menu Selection

    $getTotal = $getReservation['setting_value'] + ($others['quantity'] * $others['a_price']) + $packages['total_price'] + $theme['theme_price'] + $MenuTotal['kidstotal'] + $MenuTotal['adultstotal'] + $extension['extensionTotal'] + $pax['totalPax'];
    
   $sub_total = ($others['quantity'] * $others['a_price']) + $packages['total_price'] + $theme['theme_price'] + $MenuTotal['kidstotal'] + $MenuTotal['adultstotal'] + $extension['extensionTotal'] + $pax['totalPax'];
   */
  //}
  
  $reservationFee = $getReservation['setting_value'] ; 
  $transportationFee = '0.00';

/*
elseif($selectReserve['event_city'] != 'Valenzuela City'){
  if($packages['p_type'] == '1' OR $packages['p_type'] == '0'){
    $MyTotal = $packages['no_person'] + $pax['sumPax'];
    $menuQuery = "SELECT SUM($MyTotal * cost_per_head) as total  FROM menu_selection
    INNER JOIN food_items on food_items.item_id = menu_selection.item_id
    WHERE menu_selection.tcode = '".$_GET['tcode']."'";
    $MenuTotal = single_inner_join($menuQuery);//Menu Selection

    $getTotal = $getReservation['setting_value'] + $getTransportation['setting_value'] + ($others['quantity'] * $others['a_price']) + $packages['total_price'] + $theme['theme_price'] + $MenuTotal['total'] + $extension['extensionTotal'] + $pax['totalPax'];
    
    $sub_total = ($others['quantity'] * $others['a_price']) + $packages['total_price'] + $theme['theme_price'] + $MenuTotal['total'] + $extension['extensionTotal'] + $pax['totalPax'];
  }else{
    $paxQuery = "SELECT SUM(pax_person) as pax_person1 FROM additional_pax WHERE tcode = '".$_GET['tcode']."' AND pax_type='1'";
    $Kidspax = single_inner_join($paxQuery);

    $kweri = "SELECT SUM(pax_person) as pax_person2 FROM additional_pax WHERE tcode = '".$_GET['tcode']."' AND pax_type='2'";
    $Adultspax = single_inner_join($kweri);

    $kidsTotal = $packages['no_kids'] + $Kidspax['pax_person1'];
    $adultsTotal = $packages['no_adults'] + $Adultspax['pax_person2'];

    $menuQuery = "SELECT SUM($kidsTotal * cost_per_head) as kidstotal, SUM($adultsTotal * cost_per_head) as adultstotal   FROM menu_selection
    INNER JOIN food_items on food_items.item_id = menu_selection.item_id
    WHERE menu_selection.tcode = '".$_GET['tcode']."'";
    $MenuTotal = single_inner_join($menuQuery);//Menu Selection

    $getTotal = $getReservation['setting_value'] + $getTransportation['setting_value'] + ($others['quantity'] * $others['a_price']) + $packages['total_price'] + $theme['theme_price'] + $MenuTotal['kidstotal'] + $menuTotal['adultstotal'] + $extension['extensionTotal'] + $pax['totalPax'];
    
    $sub_total = ($others['quantity'] * $others['a_price']) + $packages['total_price'] + $theme['theme_price'] + $MenuTotal['kidstotal'] + $menuTotal['adultstotal'] + $extension['extensionTotal'] + $pax['totalPax'];
  }

  $transportationFee = $getTransportation['setting_value'];
  $reservationFee = $getReservation['setting_value'];
}
*/

$Downpayment = $MyTotal * ($getDownpayment['setting_value'] / 100);
$Balance = $MyTotal - $Downpayment;
   
//end computation //
if(isset($_POST['save_button'])){
  $tcode = filter($_GET['tcode']);
  $update = $dbcon->query("UPDATE reservations SET reservation_status = 'Posted' WHERE tcode= '$tcode'") or die(mysqli_error());
  header("location: reservations.php");
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
            <i class="fa fa-shopping-cart"></i> Billing Statement
            <small class="pull-right">Date: <?php echo date("m/d/Y");?></small>
<br>

          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          From
          <address>
          <?php $admin = single_get("*","user_id","user_account","2");?>
            <strong><?php echo $admin['full_name']?></strong><br>
            Phone: <?php echo $admin['contact_num']?><br>
            Email: <?php echo $admin['user_email']?>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          To
          <address>
            <?php $user = single_get("*","user_id","user_account",$_SESSION['user_id']);?>
            <strong><?php echo $user['full_name']?></strong><br>
            Phone: <?php echo $user['contact_num']?><br>
            Email: <?php echo $user['user_email']?>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>Transact Code: <?php echo $_GET['tcode']?></b><br>
          <br>

        </div>
        <!-- /.col -->
      </div>

      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>Qty</th>
              <th>Name</th>
              <th>Type</th>
              <th>Occasion Type</th>
              <th>Price</th>
              <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>
<?php $code = single_get("*","tcode","reservations",$_GET['tcode']);?>
<?php $package = getdata_where("*","code","packages",$code['package_code']);?>
<?php if(!empty($package)):?>
<?php foreach ($package as $key => $value):?>
            <tr>
              <td>1</td>
              <td><?php echo $value->package_name?> x <?php echo $code['pax']?> Person</td>
              <td>
                  <?php 
                  if($get['type'] == 'platted'){
                    echo "Platted - 20%";
                  }else{
                    echo "Buffet";
                  }?>
              </td>
              <td>
                <?php
                  if($get['motif_type'] == 1){
                    echo "Special - 20,000";
                  }else{
                    echo "Regular";
                  }
                ?>
              </td>
              <td>&#8369; <?php echo number_format($value->total_price)?></td>
              <td>&#8369; <?php
                 $motif_type_price = 0;
                 $motif_price = 0;
                 if($get['motif_type'] == 1){
                   $motif_type_price = 20000;
                 }
                 $total = ($value->total_price * $code['pax'])+$motif_type_price;
                 if($get['type'] == "platted"){
                   $total *= .20;
                 }else{
                   $total = $total;
                 }
              echo number_format($total,2)?></td>
            </tr>
<?php endforeach;?>
<?php else:?>
<?php endif;?>
<?php 
$themeQuery = "SELECT * FROM reservations INNER JOIN themes on themes.theme_name = reservations.event_theme WHERE tcode = '".$_GET['tcode']."'";
$theme = getdata_inner_join($themeQuery);
?>
<tr>
                 <td><span style="color:red;font-size:8pt">Additional <i class="fa fa-plus"></i></span></td>
</tr>
<?php if(!empty($theme)):?>
<?php foreach ($theme as $key => $result):?>
            <tr>
              <td>1</td>
              <td><?php echo $result->theme_name?></td>
              <td></td>
              <td></td>
              <td>&#8369; <?php echo number_format($result->theme_price)?></td>
              <td>&#8369; <?php echo number_format($result->theme_price)?></td>
            </tr>
<?php endforeach;?>
<?php else:?>
<?php endif;?>
<?php if($packages['p_type'] == '1' OR $packages['p_type'] == '0'){?>
<?php 
$menuQuery = "SELECT * FROM menu_selection INNER JOIN food_items on food_items.item_id = menu_selection.item_id WHERE tcode = '".$_GET['tcode']."'";
$menu2 = getdata_inner_join($menuQuery);
?>
<?php if(!empty($menu2)):?>
<?php foreach ($menu2 as $key => $result):?>
            <tr>
              <td>1</td>
              <td><?php echo $result->item_name?></td>
              <td></td>
              <td></td>
              <td>&#8369; <?php echo number_format($result->cost_per_head)?></td>
              <td>&#8369; 
              <?php 
              $menuQuery = "SELECT SUM(cost_per_head) as total  FROM menu_selection
INNER JOIN food_items on food_items.item_id = menu_selection.item_id
WHERE menu_selection.tcode = '".$_GET['tcode']."' AND food_items.item_id = '".$result->item_id."'";
$myMenu = single_inner_join($menuQuery);//Menu Selection
              ?>
              <?php $subTotal = ($packages['no_person'] + $pax['sumPax']) * $myMenu['total']; echo number_format($subTotal);?></td>
            </tr>
<?php endforeach;?>
<?php else:?>
<?php endif;?>
<?php }else{?>
<?php 
$menuQuery = "SELECT * FROM menu_selection INNER JOIN food_items on food_items.item_id = menu_selection.item_id WHERE tcode = '".$_GET['tcode']."' AND pax_type = '1'";
$menu2 = getdata_inner_join($menuQuery);
?>
<?php if(!empty($menu2)):?>
<?php foreach ($menu2 as $key => $result):?>
            <tr>
              <td>1</td>
              <td><?php echo $result->item_name?> - KIDS</td>
              <td></td>
              <td></td>
              <td>&#8369; <?php echo number_format($result->cost_per_head)?></td>
              <td>&#8369; 
<?php 
$paxQuery = "SELECT SUM(pax_person) as total FROM additional_pax WHERE tcode = '".$_GET['tcode']."' AND pax_type='1'";
$Kidspax = single_inner_join($paxQuery);
$menuQuery = "SELECT SUM(cost_per_head) as total  FROM menu_selection
INNER JOIN food_items on food_items.item_id = menu_selection.item_id
WHERE menu_selection.tcode = '".$_GET['tcode']."' AND food_items.item_id = '".$result->item_id."'";
$myMenu = single_inner_join($menuQuery);
?>
              <?php $subTotal = ($packages['no_kids'] + $Kidspax['total']) * $myMenu['total']; echo number_format($subTotal);?></td>
            </tr>
<?php endforeach;?>
<?php else:?>
<?php endif;?>
<?php 
$menuQuery = "SELECT * FROM menu_selection INNER JOIN food_items on food_items.item_id = menu_selection.item_id WHERE tcode = '".$_GET['tcode']."'  AND pax_type = '2'";
$menu2 = getdata_inner_join($menuQuery);
?>
<?php if(!empty($menu2)):?>
<?php foreach ($menu2 as $key => $result):?>
            <tr>
              <td>1</td>
              <td><?php echo $result->item_name?> - Adults</td>
              <td></td>
              <td></td>
              <td>&#8369; <?php echo number_format($result->cost_per_head)?></td>
              <td>&#8369; 
<?php 
$paxQuery = "SELECT SUM(pax_person) as total FROM additional_pax WHERE tcode = '".$_GET['tcode']."' AND pax_type='2'";
$Adultspax = single_inner_join($paxQuery);
$menuQuery = "SELECT SUM(cost_per_head) as total  FROM menu_selection
INNER JOIN food_items on food_items.item_id = menu_selection.item_id
WHERE menu_selection.tcode = '".$_GET['tcode']."' AND food_items.item_id = '".$result->item_id."'";
$myMenu = single_inner_join($menuQuery);
?>
              <?php $subTotal = ($packages['no_adults'] + $Adultspax['total']) * $myMenu['total']; echo number_format($subTotal);?></td>
            </tr>
<?php endforeach;?>
<?php else:?>
<?php endif;?>

<?php }?>
<?php 
$otherQuery = "SELECT * FROM reservation_others INNER JOIN amenities on amenities.a_name = reservation_others.amenity_name WHERE tcode = '".$_GET['tcode']."'";
$others = getdata_inner_join($otherQuery);
?>
<?php if(!empty($others)):?>
<?php foreach ($others as $key => $row):?>
            <tr>
              <td><?php echo $row->quantity?></td>
              <td><?php echo $row->amenity_name?></td>
              <td></td>
              <td></td>
              <td>&#8369; <?php echo number_format($row->a_price)?></td>
              <td>&#8369; <?php $otherTotal = $row->a_price * $row->quantity; echo number_format($otherTotal);?></td>
            </tr>
<?php endforeach;?>
<?php else:?>
<?php endif;?>
<?php 
$paxQuery = "SELECT * FROM additional_pax WHERE tcode = '".$_GET['tcode']."'";
$paxQuery = getdata_inner_join($paxQuery);
?>
<?php if(!empty($paxQuery)):?>
<?php foreach ($paxQuery as $key => $row):?>
            <tr>
              <td><?php echo $row->pax_person?></td>
              <td><?php echo $row->pax_name?></td>
              <td></td>
              <td></td>
              <td>&#8369; <?php echo number_format($packages['total_price'])?></td>
              <td>&#8369; <?php $paxTotal = $packages['total_price'] *  $row->pax_person; echo number_format($paxTotal);?></td>
            </tr>
<?php endforeach;?>
<?php else:?>
<?php endif;?>
<?php $others = getdata_where("*","code","package_extension",$_GET['tcode']);?>
<?php if(!empty($others)):?>
  <?php foreach ($others as $key => $value):?>
                <tr>
                    <td><?php echo $value->ex_qty?></td>
                    <td><?php echo $value->ex_name?></td>
                    <td></td>
                    <td></td>
                    <td>&#8369; <?php echo $value->ex_price?></td>
                    <td>
                      &#8369; <?php $total = $value->ex_price * $value->ex_qty; echo $total;?>
                    </td>
                  </tr>
              <?php endforeach;?>
<?php else:?>
<?php endif;?>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="row">
         <div class="col-xs-6">

       
        </div>
        <div class="col-xs-6">
           

        </div>
      </div>
      <div class="row">

        <!-- accepted payments column -->
<div class="col-md-6">
    <div class="table-responsive">
    <form action='<?php echo $paypal_url; ?>' method='post' name='frmPayPal1'>
        <h4>Terms And Conditions:</h4>
          <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
            
          <?php $terms = single_get("*","setting_id","site_settings","7");?>
            <?php echo $terms['setting_content'];?>
          </p>
          <center><input type="checkbox" name="check" required="required"> I agree with Terms and Conditions</center>
</div>
</div>
<div class="col-md-6">
<div class="table-responsive">
    <p class="lead">Details</p>

            <table class="table">
                 <?php if($_GET['payment_option'] == '0'): ?>
              <tr>
                 
                <th style="width:50%"><strong>Downpayment: <?php echo $getDownpayment['setting_value'] ?>%</strong></th>
                <td>&#8369 <?php echo number_format($Downpayment);?></td>
                    
              </tr>
              <?php endif;?>
              <?php if($_GET['payment_option'] == '1'): ?>
              <tr>
                  
                <th style="width:50%"><strong>Full Payment: <?php $b = 100 - $getDownpayment['setting_value'];
                    
                    ?>100%</strong></th>
                <td>
                    &#8369  <?php $r = ($MyTotal * $b / 100) + $Downpayment; 
                    echo number_format($r); ?>
                    
                </td>
                <?php endif;?>
                <?php if($_GET['payment_option'] == '2'): ?>
              <tr>
                  
                <th style="width:50%"><strong>Remaining Balance: <?php $b = 100 - $getDownpayment['setting_value'];
                    echo $b; 
                    ?>%</strong></th>
                <td>
                    &#8369  <?php $r = ($MyTotal * $b / 100); 
                    echo number_format($r); ?>
                    
                </td>
                <?php endif;?>
              </tr>
              
              </tr>
              
              <!--
              <tr>
                <th>Reservation Fee: </th>
                <td>&#8369; <?php echo number_format($reservationFee);?></td>
              </tr>
              <tr>
                <th>Transporation Fee:</th>
                <td>&#8369; <?php echo number_format($transportationFee);?></td>
              </tr>
            -->
              <tr>
                <th><h1>Total: &#8369; <?php echo number_format($MyTotal);?></h1></th>
              </tr>
            </table>
</div>
</div>
       

        <!-- /.col -->
        
        </div>
       
          <hr>
          <p class="lead">Pay via Paypal:</p>
       <!--
          <img src="../bootstrap/dist/img/credit/visa.png" alt="Visa">
          <img src="../bootstrap/dist/img/credit/mastercard.png" alt="Mastercard">
          <img src="../bootstrap/dist/img/credit/american-express.png" alt="American Express">
          <img src="../bootstrap/dist/img/credit/paypal2.png" alt="Paypal">
        -->
        <!-- /.col -->
         <?php if($_GET['payment_option'] == '1'): 
          echo "<div class='alert alert-danger'><h4>FULL PAYMENT: &#8369; ".number_format($MyTotal)."</h4></div>"; 
          elseif($_GET['payment_option'] == '0'): 
          echo "<div class='alert alert-warning'><h4>INITIAL PAYMENT: ".$getDownpayment['setting_value']." %- &#8369; ".number_format($Downpayment)."</h4></div>";
          else:
            echo'';
          endif;
          ?>
    <?php if($selectReserve['reservation_status'] == 'Paid Initially'):?>
      <div class="alert alert-info"><h4><i class="fa fa-alert"></i> You must pay your current Balance worth: &#8369; <?php echo $Balance;?></h4></div>
    <?php endif;?>

         
                    <input type='hidden' name='business' value='<?php echo $paypal_id;?>'>
                    <input type='hidden' name='cmd' value='_xclick'>
                    <input type="hidden" name="payment_option" value="<?php echo $_GET['payment_option']?>">
                    <input type='hidden' name='item_name' value='<?php echo $selectReserve['event_name'];?>'>
                    
                    <input type='hidden' name='item_number' value='<?php echo $_GET['tcode'];?>'>
                    <input type='hidden' name='amount' value='<?php if($_GET['payment_option'] == '1'): echo $MyTotal; elseif($_GET['payment_option'] == '0'): echo $Downpayment;else:echo $Balance;  endif;?>'>
                    
                    <input type='hidden' name='no_shipping' value='1'>
                    <input type='hidden' name='currency_code' value='PHP'>
                    <input type='hidden' name='handling' value='0'>
                    <input type='hidden' name='cancel_return' value='http://tratskitchenette.tk/user/cancel.php'>
                    <input type='hidden' name='return' value='http://tratskitchenette.study-call.com/user/success.php?payment_option=<?php echo $_GET['payment_option']?>'>

                    <input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                    <img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
                </form> 
       
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
      <!--
      <div class="row no-print">
        <div class="col-xs-12">
          <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
          <button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment
          </button>
          <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
            <i class="fa fa-download"></i> Generate PDF
          </button>
        </div>
      
      </div>-->
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