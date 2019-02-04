<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_admin'])){
  header("Location: ../index.php");
  exit;
}
if(isset($_POST['save_button'])){
  $item_id = filter($_POST['item_id']);
  $tcode = filter($_GET['tcode']);
  $query = "SELECT * FROM menu_selection WHERE tcode='$tcode' AND item_id='$item_id'";
  $checkMenu = single_inner_join($query);
  if($checkMenu['tcode'] == $tcode AND $checkMenu['item_id'] == $item_id){
    $msg = 'Menu already selected.';
  }else{
    $insertSQL = array("item_id"=>$item_id,"tcode"=>$tcode);
    insertdata("menu_selection",$insertSQL);
    header("location: other-reservation.php?tcode=$tcode&tab=3");
  }
  
}
?>
<?php include'../assets/admin_header.php';?>
<?php include'../assets/admin_sidebar.php';?>
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
              

              <h4 class="box-title">ADD MENU</h4>
            </div>
            <hr>
            <div class="box-body">
            <?php if(isset($msg)):?><div class="alert alert-danger"><?php echo $msg;?></div><?php endif;?>
            <form method="post">
            <?php 
            $code = single_get("*","tcode","reservations",$_GET['tcode']);
            $package = single_get("*","code","packages",$code['package_code']);
            $choice =single_get("*","menu_id","menu",$package['menu_type']);
            ?>
            <h4>Package: <?php echo $code['package_name']?></h4>

              <strong>Choice of Menu:</strong><br>
              <div class="alert alert-info"><?php echo $choice['menu_name'];?></div>
             <?php if(substr($choice['menu_name'],5,2) === 'w/'):?>
            <select class="form-control" name="item_id">
               <?php 
               $queryList = "SELECT * FROM food_items";
               $list = getdata_inner_join($queryList);
               ?>
              <?php if(!empty($list)):?>
              <?php foreach ($list as $key => $result):?>
                
                <option value="<?php echo $result->item_id?>">
                  <img src="../images/<?php echo $result->itm_image?>">
                  <?php echo $result->item_name?>
                  </option>
              <?php endforeach;?>
            </select>
              <?php else:?>
                <option>No records</option>
              <?php endif;?>
             <?php endif; ?>
            <?php if(ucfirst(substr($choice['menu_name'],5,7)) === 'Without'):?>
            
               <?php 
               $row1 = ucfirst(substr($choice['menu_name'],13));

               $query = "SELECT * FROM food_items INNER JOIN food_categories on food_categories.f_id=
               food_items.item_category WHERE food_categories.f_name != '$row1'";
               $without = getdata_inner_join($query);
               ?>
                <select class="form-control" name="item_id">
              <?php if(!empty($without)):?>
               

              <?php foreach ($without as $key => $fetchFood):?>
                <option value="<?php echo $fetchFood->item_id?>"><?php echo $fetchFood->item_name?> </option>
              <?php endforeach;?>
            </select>
              <?php else:?>
                <option>No records</option>
              <?php endif;?>
            
            <?php endif; ?>
            
            <div class="row">
            <center>
              <br>
              <button class="btn btn-primary" name="save_button"><i class="fa fa-save"></i> Add Menu</button>
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
  <script type="text/javascript">
  $(function() {
    $( "#datepicker").datepicker({ 
      minDate: '+2M'

    });
  });
</script>
<?php include'../assets/user_footer.php';?>