<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_admin'])){
  header("Location: ../index.php");
  exit;
}
if(isset($_POST['save_button'])){
  $quantity = filter($_POST['quantity']);
  $amenity_name = filter($_POST['amenity_name']);
  $tcode = filter($_GET['tcode']);

  $checkOthers = $dbcon->query("SELECT * FROM reservation_others WHERE tcode='$tcode' AND amenity_name='$amenity_name'") or die(mysqli_error());
  $count = mysqli_num_rows($checkOthers);

  if($count == 1){
    $msg = '<div class="alert alert-danger">Amenity name: '.$amenity_name.' already exist.</div>';
  }else{
    $insertSQL = array("quantity"=>$quantity,"amenity_name"=>$amenity_name,"tcode"=>$tcode);
  insertdata("reservation_others",$insertSQL);
  header("location: other-reservation.php?tcode=$tcode&tab=4");
  }
  
}
?>
<?php include'../assets/user_header.php';?>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/themes/base/jquery-ui.css" rel="stylesheet" />
<script class="jsbin" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">


      <div class="row">
       <div class="container">
   
        <div class="box box-info" style="width:97%;">
            <div class="box-header">
              

              <h4 class="box-title">OTHER AMENITIES</h4>
            </div>
            <hr>
            <div class="box-body">
              <?php if(isset($msg)): echo $msg; endif;?>
            <form method="post">
              <strong>Quantity:</strong>
                <br>
                <input type="text" name="quantity" min = '1' class="form-control" placeholder="Quantity">
            <br>
             <strong>Amenities:</strong>
                <br>
                <select class="form-control" name="amenity_name">
                <?php $amenities = getdata_where("*","a_type","amenities","Other");?>
                <?php if(!empty($amenities)):?>
                <?php foreach ($amenities as $key => $value):?>
                  <option><?php echo $value->a_name?></option>
                <?php endforeach;?>
                </select>
              <?php else:?>
                <option>No Records on database.</option>
              <?php endif;?>
            <div class="row">

              
            
            <center>
              <br>
              <button class="btn btn-primary" name="save_button"><i class="fa fa-save"></i> Save Data</button>
            </center>
            </form>
            </div>
            
          </div>
            </div>
            
          </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php include'../assets/user_footer.php';?>