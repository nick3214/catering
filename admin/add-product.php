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
  $freebie_name = filter($_POST['freebie_name']);
  $tcode = filter($_GET['tcode']);

  $checkfree = $dbcon->query("SELECT * FROM package_extension WHERE code='$tcode' AND ex_name='$freebie_name'") or die(mysqli_error());
  $count = mysqli_num_rows($checkfree);

  if($count == 1){
    $msg = '<div class="alert alert-danger">'.$freebie_name.' already exist.</div>';
  }else{
  $view = single_get("*","freebie_name","freebies",$freebie_name);
  $price = $view['f_price'];
    $insertSQL = array("ex_price"=>$price,"ex_qty"=>$quantity,"ex_name"=>$freebie_name,"code"=>$tcode);
  insertdata("package_extension",$insertSQL);
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
              

              <h4 class="box-title">Add Products</h4>
            </div>
            <hr>
            <div class="box-body">
              <?php if(isset($msg)): echo $msg; endif;?>
            <form method="post">
              <strong>Quantity:</strong>
                <br>
                <input type="text" name="quantity" min="1" class="form-control" placeholder="Quantity">
            <br>
             <strong>Products:</strong>
                <br>
                <select class="form-control" name="freebie_name">
                <?php $freebies = getdata("*","freebies");?>
                <?php if(!empty($freebies)):?>
                <?php foreach ($freebies as $key => $value):?>
                  <option value="<?php echo $value->freebie_name?>"><?php echo $value->freebie_name?> <?php echo $value->f_price?></option>
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