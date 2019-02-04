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
<?php include'../assets/admin_header.php';?>
<?php include'../assets/admin_sidebar.php';?>
<style type="text/css">
@media print {
    #printbtn {
        display :  none;
    }
}
</style>  
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
            <?php $user = single_get("*","user_id","user_account",$selectReserve['user_id']);?>
            <?php if($selectReserve['reservation_type'] == '1'):?>
            <strong><?php echo $selectReserve['reservation_name']?></strong><br>
            Phone: <?php echo $selectReserve['reservation_contact']?><br>
            <?php elseif($selectReserve['reservation_type'] == '0'):?>
              <strong><?php echo $user['full_name']?></strong><br>
            Phone: <?php echo $user['contact_num']?><br>
            Email: <?php echo $user['user_email']?>
            <?php endif;?>
          
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
              <td><?php echo $value->package_name?> * <?php echo $code['pax']?></td>
              
              <td>&#8369; <?php echo number_format($value->total_price)?></td>
              <td>&#8369; 
              <?php 
              $total = $value->total_price * $code['pax']; 
              echo number_format($total)
              ?></td>
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
        <!-- /.col -->
        <div class="col-xs-12">
          <p class="lead">Details</p>

          <div class="table-responsive">
            <table class="table">
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
              <?php if($selectReserve['reservation_status'] == 'Paid Initial Deposit'):?>
              <tr>
                  <th>Balance to pay:</th>
                  <td>&#8369; <?php echo number_format($Balance);?></td>
                  <td>
                      
                  </td>
              </tr>
              <?php else:?>
                 <tr>
                  <th>Full Payment:</th>
                  <td>&#8369; <?php echo number_format($MyTotal);?></td>
                  <td>
                     
                  </td>
              </tr>
              <?php endif;?>
              <tr>
                <th><h1>Total:</h1></th>
                <td><h1>&#8369; <?php echo number_format($MyTotal);?></h1></td>
              </tr>
             
            </table>
          </div>
        </div>
        </div>
          <hr>
         <center><a href="" id="printbtn" class="btn btn-warning" onclick="print()"><i class="fa fa-print"></i>Print Billing Statement</a></center>
        </form>

      </div>
            </div>
            
          </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php include'../assets/admin_footer.php';?>