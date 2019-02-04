<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_user'])){
  header("Location: ../index.php");
  exit;
}
if(isset($_POST['save_button'])){
  //$quantity = filter($_POST['quantity']);
  $freebie_name = filter($_POST['freebie_name']);
  $tcode = filter($_GET['tcode']);

  $checkfree = $dbcon->query("SELECT * FROM package_extension WHERE code='$tcode' AND ex_name='$freebie_name'") or die(mysqli_error());
  $count = mysqli_num_rows($checkfree);
  
   $checkfree1 = $dbcon->query("SELECT * FROM package_extension WHERE code='$tcode' AND package_sync='1'") or die(mysqli_error());
  $count1 = mysqli_num_rows($checkfree1);

  if($count == 1){
    $msg = '<div class="alert alert-danger">'.$freebie_name.' already exist.</div>';
  }elseif($count1 >= 1){
    $msg = '<div class="alert alert-danger">We are giving away 1 freebie for each reservation</div>';
  }else{
  $view = single_get("*","freebie_name","freebies",$freebie_name);
  $price = $view['f_price'];
    $insertSQL = array("ex_price"=>$price,"ex_qty"=>"0","ex_name"=>$freebie_name,"code"=>$tcode,"package_sync" => "1");
  insertdata("package_extension",$insertSQL);
  header("location: other-reservation.php?tcode=$tcode&tab=4");
  }
  
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
            <div class="box-header">
              

              <h4 class="box-title">Add Freebies</h4>
            </div>

            <div class="box-body">
              <?php if(isset($msg)): echo $msg; endif;?>
            <form method="post">
          <!--      <input type="hidden" name="quantity" min="1" class="form-control" placeholder="Quantity">-->
            <br>
            <?php 
            $g = $dbcon->query("SELECT COUNT(*) as total FROM reservations WHERE reservation_status != 'Draft' AND user_id = '".$_SESSION['user_id']."'") or die(mysqli_error());
            $fetch = $g->fetch_assoc();
            ?>
            <?php if($fetch['total'] <= 2):?>
                <select class="form-control" name="freebie_name">
                <?php $freebies = getdata_where("*","freebie_type","freebies","0");?>
                <?php if(!empty($freebies)):?>
                <?php foreach ($freebies as $key => $value):?>
                  <option value="<?php echo $value->freebie_name?>"><?php echo $value->freebie_name?> <?php echo $value->f_price?></option>
                <?php endforeach;?>
                </select>
              <?php else:?>
                <option>No Records on database.</option>
              <?php endif;?>
            <?php elseif($fetch['total'] >= 3):?>
               <select class="form-control" name="freebie_name">
                <?php $freebies = getdata_where("*","freebie_type","freebies","1");?>
                <?php if(!empty($freebies)):?>
                <?php foreach ($freebies as $key => $value):?>
                  <option value="<?php echo $value->freebie_name?>"><?php echo $value->freebie_name?></option>
                <?php endforeach;?>
                </select>
              <?php else:?>
                <option>No Records on database.</option>
              <?php endif;?>
            <?php endif;?>
            <div class="row">
            <center>
              <br>
              <a href="other-reservation.php?tcode=<?php echo $_GET['tcode']?>&tab=4" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>

              <button class="btn btn-primary" name="save_button"><i class="fa fa-save"></i> Save Data</button>
              
            </center>
            </form>
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