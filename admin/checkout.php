<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_admin'])){
  header("Location: ../index.php");
  exit;
}
$selectReserve = single_get("*","tcode","reservations",$_GET['tcode']);//Select Reservation
$packages = single_get("*","code","packages",$selectReserve['package_code']);//Select Packages

$otherQuery = "SELECT * FROM reservation_others 
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

if($selectReserve['event_city'] == 'Valenzuela City'){
  if($packages['p_type'] == '1' OR $packages['p_type'] == '0'){
    $MyTotal = $packages['no_person'] + $pax['sumPax'];
    $menuQuery = "SELECT SUM($MyTotal * cost_per_head) as total  FROM menu_selection
    INNER JOIN food_items on food_items.item_id = menu_selection.item_id
    WHERE menu_selection.tcode = '".$_GET['tcode']."'";
    $MenuTotal = single_inner_join($menuQuery);//Menu Selection

    $getTotal = $getReservation['setting_value'] + ($others['quantity'] * $others['a_price']) + $packages['total_price'] + $theme['theme_price'] + $MenuTotal['total'] + $extension['extensionTotal'] + $pax['totalPax'];
    
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

$Downpayment = $getTotal * ($getDownpayment['setting_value'] / 100);
$Balance = $getTotal - $Downpayment;
   
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
<?php include'../assets/admin_header.php';?>
<?php include'../assets/admin_sidebar.php';?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
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
          <b>Transaction Number: <?php echo $_GET['tcode']?></b><br>
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
              <td><?php echo $value->package_name?></td>
              
              <td>&#8369; <?php echo number_format($value->total_price)?></td>
              <td>&#8369; <?php echo number_format($value->total_price)?></td>
            </tr>
<?php endforeach;?>
<?php else:?>
<?php endif;?>
<?php 
$themeQuery = "SELECT * FROM reservations INNER JOIN themes on themes.theme_name = reservations.event_theme WHERE tcode = '".$_GET['tcode']."'";
$theme = getdata_inner_join($themeQuery);
?>
<?php if(!empty($theme)):?>
<?php foreach ($theme as $key => $result):?>
            <tr>
              <td>1</td>
              <td><?php echo $result->theme_name?></td>
              
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
              
              <td>&#8369; <?php echo number_format($row->pax_price)?></td>
              <td>&#8369; <?php $paxTotal = $row->pax_price * $row->pax_person; echo number_format($paxTotal);?></td>
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
          <h4>Food Menu List:</h4>
        <hr>
        <?php 
        $list = "SELECT * FROM menu_list_information INNER JOIN food_items on food_items.item_id = menu_list_information.item_id WHERE menu_code = '".$_GET['tcode']."'";
        $result = getdata_inner_join($list);
        ?>  
        <?php if(!empty($result)):?>
          <table class="table table-striped">
            <tr>
              <td>Code</td>
              <td>Name</td>
            </tr>
          
        <?php foreach ($result as $key => $value):?>
          <tr>
              <td><?php echo $value->item_code?></td>
              <td><?php echo $value->item_name?></td>
            </tr>
        <?php endforeach;?>
        </table>
        <?php else:?>
          No records
        <?php endif;?> 
        <hr>
       
        </div>
        <div class="col-xs-6">
           <h4>Additional Food Menu</h4>
        <hr>
        <?php 
$menuQuery = "SELECT * FROM menu_selection INNER JOIN food_items on food_items.item_id = menu_selection.item_id WHERE tcode = '".$_GET['tcode']."'";
$menu = getdata_inner_join($menuQuery);
?>
<?php if(!empty($menu)):?>
  <table class="table table-striped">
                  <tr>
                    <td>Product Name</td>
                    <td>Quantity</td>
                    <td>Price</td>
                    <td>Total</td>
                    
                  </tr>
<?php foreach ($menu as $key => $result):?>
            <tr>
              <td>1</td>
              <td><?php echo $result->item_name?></td>
              
              <td>&#8369; <?php echo number_format($result->cost_per_head)?></td>
              <td>&#8369; <?php echo number_format($result->cost_per_head)?></td>
            </tr>
<?php endforeach;?>
</table>
<?php else:?>
<?php endif;?>
<!--
         <?php $others = getdata_where("*","code","package_extension",$_GET['tcode']);?>
               <?php if(!empty($others)):?>
                <table class="table table-striped">
                  <tr>
                    <td>Product Name</td>
                    <td>Quantity</td>
                    <td>Price</td>
                    <td>Total</td>
                    
                  </tr>
              <?php foreach ($others as $key => $value):?>
                <tr>
                    <td><?php echo $value->ex_name?></td>
                    <td><?php echo $value->ex_qty?></td>
                    <td>&#8369; <?php echo $value->ex_price?></td>
                    <td>
                      &#8369; <?php $total = $value->ex_price * $value->ex_qty; echo $total;?>
                      
                    </td>
                   
                  </tr>
              <?php endforeach;?>
              </table>
            <?php else:?>
              <div class="alert alert-danger">There are no records on the database.</div>
            <?php endif;?>
-->
        </div>
      </div>
      <div class="row">

        <!-- accepted payments column -->

        <div class="col-xs-6 text-muted well well-sm no-shadow">
           <form action='' method='post' name='frmPayPal1'>
        <h4>Terms And Conditions:</h4>
          <?php $terms = single_get("*","setting_id","site_settings","7");?>
            <?php echo $terms['setting_content'];?>
          
          <center><input type="checkbox" name="check" required="required"> I agree with Terms and Conditions</center>
          <!--
        
        -->
        </div>

        <!-- /.col -->
        <div class="col-xs-6">
          <p class="lead">Details</p>

          <div class="table-responsive">
            <table class="table">
              <tr>
                <th style="width:50%">Subtotal:</th>
                <td>&#8369; <?php echo number_format($sub_total);?></td>
              </tr>
              <tr>
                <th>Reservation Fee: </th>
                <td>&#8369; <?php echo number_format($reservationFee);?></td>
              </tr>
              <tr>
                <th>Transporation Fee:</th>
                <td>&#8369; <?php echo number_format($transportationFee);?></td>
              </tr>
              <tr>
                <th><h1>Total:</h1></th>
                <td><h1>&#8369; <?php echo number_format($getTotal);?></h1></td>
              </tr>
            </table>
          </div>
        </div>
        </div>
          <hr>
          
          <?php if($_GET['payment_option'] == '1'): 
          echo "<div class='alert alert-danger'><h1>FULL PAYMENT: &#8369; ".number_format($getTotal)."</h1></div>"; 
          elseif($_GET['payment_option'] == '0'): 
          echo "<div class='alert alert-warning'><h1>INITIAL PAYMENT: &#8369; ".number_format($Downpayment)."</h1></div>"; endif;
          ?>
        <?php if($selectReserve['reservation_status'] == 'Paid Initial Deposit'):?>
      <div class="alert alert-info"><h4><i class="fa fa-alert"></i> You must pay your current Balance worth: &#8369; <?php echo $Balance;?></h4></div>
    <?php endif;?>
        <input type="hidden" name="tcode" value="<?php echo $_GET['tcode']?>">
        <?php if($_GET['payment_option'] == '1'): ?>
          <input type="hidden" name="mypayment" value="<?php echo $getTotal?>">
        <?php elseif($_GET['payment_option'] == '0'):?> 
           <input type="hidden" name="mypayment" value="<?php echo $Downpayment?>">
        <?php elseif($_GET['payment_option'] == '2'):?> 
           <input type="hidden" name="mypayment" value="<?php echo $Balance?>">
        <?php endif; ?>
        <?php if($_GET['payment_option'] == '1'): ?>
          <input type="hidden" name="t_status" value="1">
        <?php elseif($_GET['payment_option'] == '0'):?> 
           <input type="hidden" name="t_status" value="0">
        <?php elseif($_GET['payment_option'] == '2'):?> 
           <input type="hidden" name="t_status" value="1">
        <?php endif; ?>
        <input type="text" class="form-control" name="input_price" placeholder="0.00"><br>
        <button class="btn btn-success" name="pay_button"><i class="fa fa-shopping-cart"></i> Pay Now</button>
        </form>
       <!--
          <img src="../bootstrap/dist/img/credit/visa.png" alt="Visa">
          <img src="../bootstrap/dist/img/credit/mastercard.png" alt="Mastercard">
          <img src="../bootstrap/dist/img/credit/american-express.png" alt="American Express">
          <img src="../bootstrap/dist/img/credit/paypal2.png" alt="Paypal">
        -->
        <!-- /.col -->
    

         
                   
       
      </div>
            </div>
            
          </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php include'../assets/user_footer.php';?>