<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_user'])){
  header("Location: ../index.php");
  exit;
}
//Computation of Total//
$selectReserve = single_get("*","tcode","reservations",$_GET['tcode']);//Select Reservation
$packages = single_get("*","code","packages",$selectReserve['package_code']);//Select Packages
$max = single_get("*","setting_id","site_settings","3");
$kweri = $dbcon->query("SELECT * FROM reservations WHERE event_date = '".$selectReserve['event_date']."' AND reservation_status != 'Draft'") or die(mysqli_error());
$countmax = mysqli_num_rows($kweri);
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
echo "<script>console.log('".$get['motif_type']."');</script>";
/** PROCESS **/
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
      $MyTotal = $MyTotal * $motif_price; 
    }
    
    $menuQuery = "SELECT SUM($MyTotal * cost_per_head) as total  FROM menu_selection
    INNER JOIN food_items on food_items.item_id = menu_selection.item_id
    WHERE menu_selection.tcode = '".$_GET['tcode']."'";
    $MenuTotal = single_inner_join($menuQuery);//Menu Selection

    //$getTotal = $getReservation['setting_value'] + ($others['quantity'] * $others['a_price']) + $packages['total_price'] + $theme['theme_price'] + $MenuTotal['total'] + $extension['extensionTotal'] + $pax['totalPax'];
    
    //$sub_total = ($others['quantity'] * $others['a_price']) + $packages['total_price'] + $theme['theme_price'] + $MenuTotal['total'] + $extension['extensionTotal'] + $pax['totalPax'];
  //}
  /*
  else{
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
  */
  
  $reservationFee = $getReservation['setting_value'] ; 
  $transportationFee = '0.00';
//END of PROCESS //


$Downpayment = $MyTotal * ($getDownpayment['setting_value'] / 100);
$Balance = $MyTotal - $Downpayment;   
//end computation //
if(isset($_POST['save_button'])){
  $tcode = filter($_GET['tcode']);
  $update = $dbcon->query("UPDATE reservations SET reservation_status = 'Posted' WHERE tcode= '$tcode'") or die(mysqli_error());
  header("location: reservations.php");
}
if(isset($_GET['ms_id'])){
  $ms_id = filter($_GET['ms_id']);
  $tcode = filter($_GET['tcode']);
    $ar = array("ms_id"=>$ms_id);
    $tbl_name = "menu_selection";
    $del = delete($dbcon,$tbl_name,$ar);
    if($del){
      header("location: other-reservation.php?tcode=$tcode&tab=3");
    }
}
if(isset($_GET['ro_id'])){
  $ro_id = filter($_GET['ro_id']);
  $tcode = filter($_GET['tcode']);
    $ar = array("ro_id"=>$ro_id);
    $tbl_name = "reservation_others";
    $del = delete($dbcon,$tbl_name,$ar);
    if($del){
      header("location: other-reservation.php?tcode=$tcode&tab=4");
    }
}
if(isset($_GET['pax_id'])){
  $pax_id = filter($_GET['pax_id']);
  $tcode = filter($_GET['tcode']);
  $tab= $_GET['tab'];
    $ar = array("pax_id"=>$pax_id);
    $tbl_name = "additional_pax";
    $del = delete($dbcon,$tbl_name,$ar);
    //if($del){
      //header("location: other-reservation.php?tcode=$tcode&tab=$tab");
    //}
}
if(isset($_GET['ex_id'])){
  $ex_id = filter($_GET['ex_id']);
  $tcode = filter($_GET['tcode']);
  $tab= $_GET['tab'];
    $ar = array("ex_id"=>$ex_id);
    $tbl_name = "package_extension";
    $del = delete($dbcon,$tbl_name,$ar);
    //if($del){
      //header("location: other-reservation.php?tcode=$tcode&tab=$tab");
    //}
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
        
        <div class="box box-info">
            <div class="box-body">
            <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li <?php if($_GET['tab'] == '1'): echo "class='active'"; endif;?>><a href="#tab_1" data-toggle="tab"><i class="fa fa-calendar"></i> RESERVATION DETAILS</a></li>
              <li <?php if($_GET['tab'] == '2'): echo "class='active'"; endif;?>><a href="#tab_2" data-toggle="tab"><i class="fa fa-cubes"></i> PACKAGE DETAILS</a></li>
              <!--
              <li <?php if($_GET['tab'] == '3'): echo "class='active'"; endif;?>>
                <a href="#tab_3" data-toggle="tab"><i class="fa fa-file-text"></i> MENU SELECTION</a></li>
              -->
              <li <?php if($_GET['tab'] == '4'): echo "class='active'"; endif;?>><a href="#tab_4" data-toggle="tab"><i class="fa fa-gear"></i> OTHER SERVICES</a></li>
              <li <?php if($_GET['tab'] == '5'): echo "class='active'"; endif;?>><a href="#tab_5" data-toggle="tab"><i class="fa fa-users"></i> ADDITIONAL PAX</a></li>
              <li <?php if($_GET['tab'] == '6'): echo "class='active'"; endif;?>><a href="#tab_6" data-toggle="tab"><i class="fa fa-shopping-basket"></i> ADDITIONAL FOOD</a></li>
       
            </ul>
            <div class="tab-content">
              <div class="tab-pane <?php if($_GET['tab'] == '1'):?>active<?php endif;?>" id="tab_1">
            <div class="row">
            <?php $pName = single_get("*","tcode","reservations",$_GET['tcode']);?>
              <div class="col-md-6">
                <strong>Event Name:</strong>
                <br>
                <input type="text" name="event_name" readonly="readonly" class="form-control" value="<?php echo $pName['event_name']?>">
              </div>
              <div class="col-md-6">
                <strong>Type:</strong>
                <br>
                <input type="text" name="type" readonly="readonly" class="form-control" value="<?php echo $pName['type']?>">
                  
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-6">
                <strong>Date:</strong>
                <br>
                <input type="date" name="event_name" readonly="readonly" class="form-control" value="<?php echo $pName['event_date']?>">
              </div>
              <div class="col-md-6">
                <strong>Occasion:</strong><br>
                <?php $o = single_get("*","occasion_id","occasion",$pName['cat_id']);?>
                <input type="text" name="occasion_name" class="form-control" readonly="readonly"  value=" <?php echo $o['occasion_name']?>">
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-6">
                <strong>Motif:</strong>
                <br>
                <?php $f = single_get("*","id","motif",$pName['sub_id']);?>
                <input type="text" name="motif" class="form-control" readonly="readonly"  value=" <?php echo $f['motif']?>">
              </div>
              <div class="col-md-6">
                <strong>Time:</strong>
                <br>
                <input type="time" name="event_name" readonly="readonly" class="form-control" value="<?php echo $pName['event_time']?>">

                
                
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-6">
                <strong>Venue:</strong>
                <br>
                <textarea class="form-control" name="event_venue" readonly="readonly"><?php echo $pName['event_venue']?></textarea>
              </div>
              <div class="col-md-6">
                
                <strong>Downpayment <div class="label label-primary">(Upon Reservation)</div></strong>
                <br>
                <input type="text" name="event_name" readonly="readonly" class="form-control" value="<?php if($selectReserve['reservation_status'] == 'Draft'): echo number_format($Downpayment); elseif($selectReserve['reservation_status'] == 'Paid Initially'): echo "0.00";else: echo '0.00';endif;?>">

                <br>
              </div>
              <div class="col-md-6">
                <strong>Balance <div class="label label-danger">(To be paid before)</div></strong>
                <br><br>
                <input type="text" name="event_name" readonly="readonly" class="form-control" value="<?php if($selectReserve['reservation_status'] == 'Draft'): echo '0.00';elseif($selectReserve['reservation_status'] == 'Paid Initially'): echo number_format($Balance);else: echo '0.00'; endif;?>">
              </div><br>
              <div class="col-md-6">
               <br>
              </div>
              <!--
              <div class="col-md-6">
                <strong>City Location:</strong>
                <br>
                <input type="text" name="event_name" readonly="readonly" class="form-control" value="<?php echo $pName['city_location']?>">
              </div>
            -->
              <div class="col-md-6">
                <strong>Total Amount:</strong>
                <br>
                <input type="text" name="event_name" readonly="readonly" class="form-control" value="<?php echo number_format($MyTotal);?>">
              </div>
            </div>
            
              <br>
              <!--
              <button class="btn btn-primary" name="save_button"><i class="fa fa-save"></i> Save</button>
            -->
              <a href="reservations.php" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
            
              <?php if($selectReserve['reservation_status'] == 'Draft' AND $countmax < $max['setting_value']):?>
                 
                <!--
                <a href="add-pax.php?tcode=<?php echo $_GET['tcode']?>" class="btn btn-danger"><i class="fa fa-plus"></i> Add Pax</a> 
                -->
              
                <a href="checkout.php?tcode=<?php echo filter($_GET['tcode']);?>&payment_option=0" class="btn btn-warning"><i class="fa fa-file"></i> Initial Deposit</a>
              
              
                <a href="checkout.php?tcode=<?php echo filter($_GET['tcode']);?>&payment_option=1" class="btn btn-info"><i class="fa fa-file"></i> Pay Fullpayment</a>
              
              <?php elseif($selectReserve['reservation_status'] == 'Paid Initially'):?>
                
                
                  <a href="checkout.php?tcode=<?php echo filter($_GET['tcode']);?>&payment_option=2" class="btn btn-success"><i class="fa fa-shopping-cart"></i> Remainig Balance</a>
                
              <?php elseif($countmax >= $max['setting_value']):?>
                
                  <div class="alert alert-danger">You are not allowed to pay because reservation is full <a href="update-reservation.php?tcode=<?php echo $_GET['tcode']?>">Click here to update</a></div>
                

              <?php else:?>

              <?php endif;?>
            
              
                      

              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane <?php if($_GET['tab'] == '2'):?>active<?php endif;?>" id="tab_2">
              <?php $pDetails = single_get("*","tcode","reservations",$_GET['tcode']);?>
              <?php 
              $kweri = "SELECT * FROM packages WHERE code = '".$pDetails['package_code']."'";
              $details = single_inner_join($kweri);
              ?>  
                <div class="row">
                    <?php if($details['custom_user'] == '0'):?>
                  <div class="col-md-7">
                    
                    <strong>Name:</strong>
                    <br>
                    <input type="text" class="form-control" value="<?php echo $details['package_name']?>" readonly="readonly">
                    <br>
                    <strong>Description:</strong>
                    <br>
                    <input type="text" class="form-control" value="<?php echo $details['package_desc']?>" readonly="readonly">
                    <br>
                    
                     <strong>Total Price:</strong>
                    <br>
                    <input type="text" class="form-control" value="<?php echo $details['total_price']?>" readonly="readonly">
        <?php else:?>
                <div class="col-md-7">
                    
                    <strong>Name:</strong>
                    <br>
                    <input type="text" class="form-control" value="<?php echo $details['package_name']?>" readonly="readonly">
                    <br>
                    <strong>Description:</strong>
                    <br>
                    <input type="text" class="form-control" value="<?php echo $details['package_desc']?>" readonly="readonly">
                    <br>
                     <strong>Total Price:</strong>
                    <br>
                    <input type="text" class="form-control" value="<?php echo $details['total_price']?>" readonly="readonly">
        <?php endif;?>
                  </div>
                  <div class="col-md-5">
                    <h4><?php echo $details['package_name']?></h4>
                    <hr>
                    <?php 
                      $query = "SELECT * FROM package_extension WHERE code = ".$pDetails['package_code']." ORDER BY `package_extension`.`package_sync` DESC";
                      $fetchEx = getdata_inner_join($query);
                      ?>
                      <?php if(!empty($fetchEx)):?>
                  <ul>
                <?php foreach ($fetchEx as $key => $value):?>
                  <li><?php echo $value->ex_name?></li>
                <?php endforeach;?>
                  </ul>
              <?php else:?>
                <div class="alert alert-danger">No records on the database.</div>
              <?php endif;?>

                  </div>

                </div>
                <hr>
                <a href="reservations.php" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
              <!--
                  <h4>Food Menu Details</h4>
                <div class="alert alert-info"><strong>Note: </strong><br>
                These are the list of detailed menu with your choice.</div>
              -->
                <?php if($selectReserve['reservation_status'] == 'Draft' AND $countmax < $max['setting_value']):?>
                 
                <!--
                <a href="add-pax.php?tcode=<?php echo $_GET['tcode']?>" class="btn btn-danger"><i class="fa fa-plus"></i> Add Pax</a> 
                -->
              
                <a href="checkout.php?tcode=<?php echo filter($_GET['tcode']);?>&payment_option=0" class="btn btn-warning"><i class="fa fa-file"></i> Initial Deposit</a>
              
              
                <a href="checkout.php?tcode=<?php echo filter($_GET['tcode']);?>&payment_option=1" class="btn btn-info"><i class="fa fa-file"></i> Pay Fullpayment</a>
              
              <?php elseif($selectReserve['reservation_status'] == 'Paid Initially'):?>
                
                
                  <a href="checkout.php?tcode=<?php echo filter($_GET['tcode']);?>&payment_option=2" class="btn btn-success"><i class="fa fa-shopping-cart"></i> Remainig Balance</a>
                
              <?php elseif($countmax >= $max['setting_value']):?>
                
                  <div class="alert alert-danger">You are not allowed to pay because reservation is full <a href="update-reservation.php?tcode=<?php echo $_GET['tcode']?>">Click here to update</a></div>
                

              <?php else:?>

              <?php endif;?>
            
                
              </div>
              
              <!-- /.tab-pane -->
              <div class="tab-pane <?php if($_GET['tab'] == '3'):?>active<?php endif;?>" id="tab_3">
              <?php if(isset($msg)): echo $msg; endif;?>
              <hr>
               <?php
  if(isset($_POST['save_list']) != '')
  {
    $code = single_get("*","tcode","reservations",$_GET['tcode']);
    $package = single_get("*","code","packages",$code['package_code']);
    $extensionQuery = "SELECT * FROM package_extension WHERE code = '".$package['code']."' AND ex_name LIKE '%Choices of%'";
    $extension = single_inner_join($extensionQuery);
    $menuQuery = "SELECT COUNT(*) as total FROM menu_list_information WHERE menu_code='".$_GET['tcode']."'";
    $count = single_inner_join($menuQuery);
                
    if($extension['package_menu'] == $count['total']){ 
    echo '<div class="alert alert-danger">You already select the maximum number of choices which is '.$count['total'].'</div>';         
    }else{
      if(empty($_POST['checkboxstatus'])) {            
        echo '<div class="alert alert-danger">Please select choices</div>';                 
      }
      else{
        if($extension['package_menu'] < count($_REQUEST['checkboxstatus'])){
        echo '<div class="alert alert-danger">Sorry we only allowed'.$extension['package_menu'].' choices of menu</div>';
        }else{
        $checked_values = $_REQUEST['checkboxstatus'];
        foreach($checked_values as $val) {
                        
          $insertSQL = array("item_id"=>$val,"menu_code"=>$_GET['tcode']);
          $success = insertdata("menu_list_information",$insertSQL);  
        header("location:other-reservation.php?tcode=".$_GET['tcode']."&tab=3");
        }
        }
      }
      }
  }
  ?>
              <form method="post">
               <?php 
                $code = single_get("*","tcode","reservations",$_GET['tcode']);
                $package = single_get("*","code","packages",$code['package_code']);
                $choice =single_get("*","menu_id","menu",$package['menu_type']);
                $extensionQuery = "SELECT * FROM package_extension WHERE code = '".$package['code']."' AND ex_name LIKE '%Choices of%'";
                $result = single_inner_join($extensionQuery);
               ?>
               <h4>Menu: <?php echo $result['ex_name'];?></h4>
            
             <?php if(substr($choice['menu_name'],5,2) === 'w/'):?>
               <?php 
               $foodQuery = 'SELECT * FROM food_items INNER JOIN food_categories on food_categories.f_id = food_items.item_category';
               $list = getdata_inner_join($foodQuery);
               ?>
              <?php if(!empty($list)):?>
              <div class="table-responsive">
                <table class="table table-bordered">
                  <tr>
                    <td></td>
                    <td>Photo</td>
                    <td>Name</td>
                    <td>Category</td>
                    <td>Cost Per Head</td>
                  </tr>
              <?php foreach ($list as $key2 => $result):?>
               <tr>
                    <td>
                    <?php 
                    $checkSQL = $dbcon->query("SELECT * FROM menu_list_information WHERE item_id = '".$result->item_id."' AND menu_code = '".$_GET['tcode']."'") or die(mysqli_error());
                    $countFood = mysqli_num_rows($checkSQL);
                    if($countFood == 0):
                    ?>
                      <input type="checkbox" name="checkboxstatus[<?php echo $key2;?>]" value="<?php echo $result->item_id; ?>">
                    <?php else:?>
                      <div class="label label-danger">Already selected</div>
                    <?php endif;?>
                    </td>
                    <td> <img src="../images/<?php echo $result->itm_image?>" class="img-thumbnail" width="150"></td>
                    <td><?php echo $result->item_name?></td>
                    <td><?php echo $result->f_name?></td>
                    <td><?php echo number_format($result->cost_per_head)?></td>
                  </tr>
               
              <?php endforeach;?>
               </table>
             </div>
               
              <?php else:?>
                <option>No records</option>
              <?php endif;?>
              <hr>
            
            <?php elseif(ucfirst(substr($choice['menu_name'],5,7)) === 'Without'):?>
             
               <?php 
               $row1 = ucfirst(substr($choice['menu_name'],13));

               $query = "SELECT * FROM food_items INNER JOIN food_categories on food_categories.f_id=
               food_items.item_category WHERE food_categories.f_name != '$row1'";
               $without = getdata_inner_join($query);
               ?>
              <?php if(!empty($without)):?>
                <div class="table-responsive">
                 <table class="table table-bordered">
                  <tr>
                    <td></td>
                    <td>Photo</td>
                    <td>Name</td>
                    <td>Category</td>
                    <td>Cost Per Head</td>
                  </tr>
              <?php foreach ($without as $key => $fetchFood):?>
                <tr>
                    <td>

                     <?php 
                    $checkSQL = $dbcon->query("SELECT * FROM menu_list_information WHERE item_id = '".$fetchFood->item_id."' AND menu_code = '".$_GET['tcode']."'") or die(mysqli_error());
                    $countFood = mysqli_num_rows($checkSQL);
                    if($countFood == 0):
                    ?>
                      <input type="checkbox" name="checkboxstatus[<?php echo $key;?>]" value="<?php echo $fetchFood->item_id; ?>">
                    <?php else:?>
                      <div class="label label-danger">Already selected</div>
                    <?php endif;?>

                      
                    </td>
                    <td> <img src="../images/<?php echo $fetchFood->itm_image?>" class="img-thumbnail" width="150"></td>
                    <td><?php echo $fetchFood->item_name?></td>
                    <td><?php echo $fetchFood->f_name?></td>
                    <td><?php echo number_format($fetchFood->cost_per_head)?></td>
                  </tr>
              <?php endforeach;?>
                   </table>
              </div>
              <?php else:?>
                <option>No records</option>
              <?php endif;?>
            <?php endif; ?>
            </select>
            <?php if($selectReserve['reservation_status'] == 'Draft'):?>
            <button class="btn btn-success" name="save_list"><i class="fa fa-save"></i> Save List</button>
            <?php endif;?>
            </form>
            <hr>
            <?php  if($packages['p_type'] == '1' OR $packages['p_type'] == '0'){?>
              <h4>Additional Menu:</h4>
              <?php if($selectReserve['reservation_status'] == 'Draft'):?>
              <a href="add-menu.php?tcode=<?php echo $_GET['tcode']?>" class="btn btn-info"><i class="fa fa-plus"></i> Add Menu</a>
              <?php endif;?>
              <br><br>
              <form method="post">
              <?php 
              $query = "SELECT * FROM menu_selection INNER JOIN food_items on food_items.item_id = menu_selection.item_id WHERE menu_selection.tcode='".$_GET['tcode']."'";
              $list = getdata_inner_join($query);
              ?>
              <?php if(!empty($list)):?>
              <div class="row">
              <?php foreach ($list as $key => $value):?>
                <div class="col-md-2">
                  <img src="../images/<?php echo $value->itm_image?>" class="img-thumbnail" width="250">
                  <br>
                  <center><strong><?php echo $value->item_name?></strong><br>
                  Cost per head: &#8369; <?php echo $value->cost_per_head;?><br>
                  <?php if($selectReserve['reservation_status'] == 'Draft'):?>
                  <a href="other-reservation.php?ms_id=<?php echo $value->ms_id?>&tcode=<?php echo $_GET['tcode']?>"><i class="fa fa-remove"></i> Delete</a>
                  <?php endif;?>
                  </center>
                </div>

              <?php endforeach;?>
              </div>
            <?php else:?>
              <div class="alert alert-danger">There are no records on the database.</div>
            <?php endif;?>

              </form>
              <?php }else{?>
              <br>
               <h4>Additional Menu:</h4>
              <a href="add-menu-kiddie.php?tcode=<?php echo $_GET['tcode']?>" class="btn btn-info"><i class="fa fa-plus"></i> Add Menu</a>
              <br>
              <strong>Food For Adults</strong><hr>
              <?php 
              $query = "SELECT * FROM menu_selection INNER JOIN food_items on food_items.item_id = menu_selection.item_id WHERE menu_selection.tcode='".$_GET['tcode']."' AND pax_type='2'";
              $list = getdata_inner_join($query);
              ?>
              <?php if(!empty($list)):?>
              <div class="row">
              <?php foreach ($list as $key => $value):?>
                <div class="col-md-2">
                  <img src="../images/<?php echo $value->itm_image?>" class="img-thumbnail" width="250">
                  <br>
                  <center><strong><?php echo $value->item_name?></strong><br>
                  Cost per head: &#8369; <?php echo $value->cost_per_head;?><br>
                  <?php if($selectReserve['reservation_status'] == 'Draft'):?>
                  <a href="other-reservation.php?ms_id=<?php echo $value->ms_id?>&tcode=<?php echo $_GET['tcode']?>"><i class="fa fa-remove"></i> Delete</a>
                  <?php endif;?>
                  </center>
                </div>

              <?php endforeach;?>
              </div>
            <?php else:?>
              <div class="alert alert-danger">There are no records on the database.</div>
            <?php endif;?>
              <strong>Food for Kids</strong>
              <?php 
              $query = "SELECT * FROM menu_selection INNER JOIN food_items on food_items.item_id = menu_selection.item_id WHERE menu_selection.tcode='".$_GET['tcode']."' AND pax_type = '1'";
              $list = getdata_inner_join($query);
              ?>
              <?php if(!empty($list)):?>
              <div class="row">
              <?php foreach ($list as $key => $value):?>
                <div class="col-md-2">
                  <img src="../images/<?php echo $value->itm_image?>" class="img-thumbnail" width="250">
                  <br>
                  <center><strong><?php echo $value->item_name?></strong><br>
                  Cost per head: &#8369; <?php echo $value->cost_per_head;?><br>
                  <?php if($selectReserve['reservation_status'] == 'Draft'):?>
                  <a href="other-reservation.php?ms_id=<?php echo $value->ms_id?>&tcode=<?php echo $_GET['tcode']?>"><i class="fa fa-remove"></i> Delete</a>
                  <?php endif;?>
                  </center>
                </div>

              <?php endforeach;?>
              </div>
            <?php else:?>
              <div class="alert alert-danger">There are no records on the database.</div>
            <?php endif;?>
              <?php }?>

              </div>
              <div class="tab-pane <?php if($_GET['tab'] == '4'):?>active<?php endif;?>" id="tab_4">
            <?php if($selectReserve['reservation_status'] == 'Draft'):?>
              <a href="add-other.php?tcode=<?php echo $_GET['tcode']?>" class="btn btn-info"><i class="fa fa-plus"></i> Add Item</a><br>
              <?php endif;?>
              <br>
              <h4>Other Services</h4>
               <?php $others = getdata_where("*","tcode","reservation_others",$_GET['tcode']);?>
               <?php if(!empty($others)):?>
              <div class="table-responsive">
                <table class="table table-bordered">
                  <tr>
                    <td>Amenity Name</td>
                    <td>Quantity</td>
                    <td>Subtotal</td>
                    <td>Options</td>
                  </tr>
              <?php foreach ($others as $key => $value):?>
                <tr>
                    <td><?php echo $value->amenity_name?></td>
                    <td><?php echo $value->quantity?></td>
                    <td>
                      &#8369; <?php $query = $dbcon->query("SELECT * FROM amenities WHERE a_name = '".$value->amenity_name."'") or die(mysqli_error());
                      $result = $query->fetch_assoc();
                      $total = $result['a_price'] * $value->quantity;
                      echo number_format($total);
                      ?>
                    </td>
                    <td>
                    <?php if($selectReserve['reservation_status'] == 'Draft'):?>
                        <a href="other-reservation.php?tcode=<?php echo $_GET['tcode']?>&ro_id=<?php echo $value->ro_id?>"><i class="fa fa-remove"></i> Delete</a>
                    <?php endif;?>    
                    </td>
                  </tr>
              <?php endforeach;?>
              </table>
            </div>
            <?php else:?>
              <div class="alert alert-danger">There are no records on the database.</div>
            <?php endif;?>
            <hr>
            <h4>Freebies</h4>
            <?php if($selectReserve['reservation_status'] == 'Draft'):?>
            <a href="add-product.php?tcode=<?php echo $_GET['tcode']?>" class="btn btn-info"><i class="fa fa-plus"></i> Add Freebies</a><br><br>
            <?php endif;?>
             <?php $others = getdata_where("*","code","package_extension",$_GET['tcode']);?>
               <?php if(!empty($others)):?>
            <div class="table-responsive">
                <table class="table table-bordered">
                  <tr>
                    <td>Product Name</td>
                 
                    <td>Options</td>
                  </tr>
              <?php foreach ($others as $key => $value):?>
                <tr>
                    <td><?php echo $value->ex_name?></td>
                   
                    <td>
                    <?php if($selectReserve['reservation_status'] == 'Draft'):?>    
                    <a href="other-reservation.php?tcode=<?php echo $_GET['tcode']?>&ex_id=<?php echo $value->ex_id?>"><i class="fa fa-remove"></i> Delete</a>
                    <?php endif;?>
                    </td>
                  </tr>
              <?php endforeach;?>
              </table>
            </div>
            <?php else:?>
              <div class="alert alert-danger">There are no records on the database.</div>
            <?php endif;?>
             <a href="reservations.php" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
               <?php if($selectReserve['reservation_status'] == 'Draft' AND $countmax < $max['setting_value']):?>
                 
                <!--
                <a href="add-pax.php?tcode=<?php echo $_GET['tcode']?>" class="btn btn-danger"><i class="fa fa-plus"></i> Add Pax</a> 
                -->
              
                <a href="checkout.php?tcode=<?php echo filter($_GET['tcode']);?>&payment_option=0" class="btn btn-warning"><i class="fa fa-file"></i> Initial Deposit</a>
              
              
                <a href="checkout.php?tcode=<?php echo filter($_GET['tcode']);?>&payment_option=1" class="btn btn-info"><i class="fa fa-file"></i> Pay Fullpayment</a>
              
              <?php elseif($selectReserve['reservation_status'] == 'Paid Initially'):?>
                
                
                  <a href="checkout.php?tcode=<?php echo filter($_GET['tcode']);?>&payment_option=2" class="btn btn-success"><i class="fa fa-shopping-cart"></i> Remainig Balance</a>
                
              <?php elseif($countmax >= $max['setting_value']):?>
                
                  <div class="alert alert-danger">You are not allowed to pay because reservation is full <a href="update-reservation.php?tcode=<?php echo $_GET['tcode']?>">Click here to update</a></div>
                

              <?php else:?>

              <?php endif;?>
            
             
              </div>
              <div class="tab-pane <?php if($_GET['tab'] == '5'):?>active<?php endif;?>" id="tab_5">
            <?php if($selectReserve['reservation_status'] == 'Draft'):?>
              <a href="add-pax.php?tcode=<?php echo $_GET['tcode']?>" class="btn btn-info"><i class="fa fa-plus"></i> Add Additional Pax</a><br>
             <?php endif;?>
              <br>
               <?php $others = getdata_where("*","tcode","additional_pax",$_GET['tcode']);?>
               <?php if(!empty($others)):?>
              <div class="table-responsive">
                <table class="table table-bordered">
                  <tr>
                    <td>Name</td>
                    <td>No. of Persons</td>
                    <td>Option</td>
                  </tr>
              <?php foreach ($others as $key => $value):?>
                <tr>
                    <td><?php echo $value->pax_name?></td>
                    <td><?php echo $value->pax_person?></td>
                   <td><!-- &#8369; <?php $total = $value->pax_person * $value->pax_price; echo number_format($total);?></td>
                    <td>
                    -->
                    <?php if($selectReserve['reservation_status'] == 'Draft'):?>
                        <a href="other-reservation.php?tcode=<?php echo $_GET['tcode']?>&pax_id=<?php echo $value->pax_id?>&tab=5"><i class="fa fa-remove"></i> Delete</a>
                    <?php endif;?>
                    </td>
                  </tr>
              <?php endforeach;?>
              </table>
            </div>
            <?php else:?>
              <div class="alert alert-danger">There are no records on the database.</div>
            <?php endif;?>
            <a href="reservations.php" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
               <?php if($selectReserve['reservation_status'] == 'Draft' AND $countmax < $max['setting_value']):?>
                 
                <!--
                <a href="add-pax.php?tcode=<?php echo $_GET['tcode']?>" class="btn btn-danger"><i class="fa fa-plus"></i> Add Pax</a> 
                -->
              
                <a href="checkout.php?tcode=<?php echo filter($_GET['tcode']);?>&payment_option=0" class="btn btn-warning"><i class="fa fa-file"></i> Initial Deposit</a>
              
              
                <a href="checkout.php?tcode=<?php echo filter($_GET['tcode']);?>&payment_option=1" class="btn btn-info"><i class="fa fa-file"></i> Pay Fullpayment</a>
              
              <?php elseif($selectReserve['reservation_status'] == 'Paid Initially'):?>
                
                
                  <a href="checkout.php?tcode=<?php echo filter($_GET['tcode']);?>&payment_option=2" class="btn btn-success"><i class="fa fa-shopping-cart"></i> Remainig Balance</a>
                
              <?php elseif($countmax >= $max['setting_value']):?>
                
                  <div class="alert alert-danger">You are not allowed to pay because reservation is full <a href="update-reservation.php?tcode=<?php echo $_GET['tcode']?>">Click here to update</a></div>
                

              <?php else:?>

              <?php endif;?>
            
              
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
            </div>
            
          </div>

          
       </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php include'../assets/user_footer.php';?>