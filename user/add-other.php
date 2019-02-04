<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_user'])){
  header("Location: ../index.php");
  exit;
}
if(isset($_POST['save_button'])){
  $quantity = filter($_POST['quantity']);
  $amenity_name = filter($_POST['amenity_name']);
  $tcode = filter($_GET['tcode']);

  $checkOthers = $dbcon->query("SELECT * FROM reservation_others WHERE tcode='$tcode' AND amenity_name='$amenity_name'") or die(mysqli_error());
  $count = mysqli_num_rows($checkOthers);
  
  $h = $dbcon->query("SELECT * FROM amenities WHERE a_name = '$amenity_name'") or die(mysqli_error());
  $t = $h->fetch_assoc();
  
  $sub_total = $t['a_price'] * $quantity;
  if($count == 1){
    $msg = '<div class="alert alert-danger">Amenity name: '.$amenity_name.' already exist.</div>';
  }else{
    $insertSQL = array("quantity"=>$quantity,"amenity_name"=>$amenity_name,"tcode"=>$tcode, "sub_total" => $sub_total);
  insertdata("reservation_others",$insertSQL);
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
              

              <h4 class="box-title">OTHER SERVICES</h4>
            </div>
            <hr>
            <div class="box-body">
              <?php if(isset($msg)): echo $msg; endif;?>
            <form method="post">
             <strong>Quantity:</strong>
                <br>
                <input type="text" name="quantity" min = '1' class="form-control" placeholder="Quantity"required>
            <br>
             <strong>Other Services:</strong>
                <br>
                <select class="form-control" name="amenity_name">
                <?php $amenities = getdata_where("*","a_type","amenities","Other");?>
                <?php if(!empty($amenities)):?>
                <?php foreach ($amenities as $key => $value):?>
                  <option value="<?php echo $value->a_name?>"><?php echo $value->a_name?> - <?php echo number_format($value->a_price)?></option>
                <?php endforeach;?>
                </select>
              <?php else:?>
                <option>No Records on database.</option>
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