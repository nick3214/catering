<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_admin'])){
  header("Location: ../index.php");
  exit;
}
$code = single_get("*","tcode","reservations",$_GET['tcode']);
 $amount = single_get("*","code","packages",$code['package_code']);
if(isset($_POST['save_button'])){
  if($amount['p_type'] =='1' OR $amount['p_type'] == '0'){
    $pax_price = filter($_POST['pax_price']);
    $pax_person = filter($_POST['pax_person']);
    $tcode = filter($_GET['tcode']);

    $insertSQL = array("pax_name"=>"Additional ".$pax_person." PAX (Package: ".$pax_price."","pax_person"=>$pax_person,"pax_price"=>$pax_price,"tcode"=>$tcode);
    insertdata("additional_pax",$insertSQL);
  }else{
    $pax_price = filter($_POST['pax_price']);
    $pax_person = filter($_POST['pax_person']);
    $pax_price2 = filter($_POST['pax_price2']);
    $pax_person2 = filter($_POST['pax_person2']);
    $tcode = filter($_GET['tcode']);
    if($pax_person == '0'){
         $insertSQL2 = array("pax_name"=>"Additional ".$pax_person2." PAX (Package: ".$pax_price2.") for Adults","pax_person"=>$pax_person2,"pax_price"=>$pax_price2,"tcode"=>$tcode,"pax_type"=>"2");
         insertdata("additional_pax",$insertSQL2);
    }elseif($pax_person2 == '0'){
         $insertSQL1 = array("pax_name"=>"Additional ".$pax_person." PAX (Package: ".$pax_price." for Kids)","pax_person"=>$pax_person,"pax_price"=>$pax_price,"tcode"=>$tcode,"pax_type"=>"1");
         insertdata("additional_pax",$insertSQL1);
    }else{
        $insertSQL1 = array("pax_name"=>"Additional ".$pax_person." PAX (Package: ".$pax_price." for Kids)","pax_person"=>$pax_person,"pax_price"=>$pax_price,"tcode"=>$tcode,"pax_type"=>"1");
        $insertSQL2 = array("pax_name"=>"Additional ".$pax_person2." PAX (Package: ".$pax_price2.") for Adults","pax_person"=>$pax_person2,"pax_price"=>$pax_price2,"tcode"=>$tcode,"pax_type"=>"2");
        insertdata("additional_pax",$insertSQL1);
        insertdata("additional_pax",$insertSQL2);
    }


  }
  header("location: other-reservation.php?tcode=$tcode&tab=5");
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
              

              <h4 class="box-title">ADD ADDITIONAL PAX</h4>
            </div>
            <hr>
            <div class="box-body">
            <form method="post">
            <?php 
           

            if($amount['p_type'] =='1' OR $amount['p_type'] == '0'){
            ?>
            <h4>Package: <?php echo $code['package_name']?></h4>
            <strong>Amount per Head (Package + Additional Food):</strong>
                <br>
                <input type="text" name="pax_price" class="form-control"
                value="<?php echo $amount['per_head'];?>" readonly="readonly">
            <br>
            <strong>No. of persons:</strong>
                <br>
                <input type="text" name="pax_person" min="1" class="form-control" placeholder="No. of Persons">
            <br>
            <?php 
            }else{
              $kids = single_get("*","person_id","per_person","2");
              $adults = single_get("*","person_id","per_person","1");
            ?>
            <strong>Amount per Head (Kids):</strong>
                <br>
                <input type="text" name="pax_price" class="form-control"
                value="<?php echo $kids['person_price'];?>" readonly="readonly">
            <br>
            <strong>No. of persons:</strong>
                <br>
                <input type="text" name="pax_person" min="1" class="form-control" placeholder="No. of Persons">
            <br>
            <strong>Amount per Head (Adults):</strong>
                <br>
                <input type="text" name="pax_price2" class="form-control"
                value="<?php echo $adults['person_price'];?>" readonly="readonly">
            <br>
            <strong>No. of persons:</strong>
                <br>
                <input type="text" name="pax_person2" min="1" class="form-control" placeholder="No. of Persons">
            <br>
            <?php }?>
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