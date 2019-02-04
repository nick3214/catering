<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_admin'])){
  header("Location: ../index.php");
  exit;
}
if(isset($_GET['delete'])){
  $delete = filter($_GET['delete']);
    $ar = array("ex_id"=>$delete);
    $tbl_name = "package_extension";
    $del = delete($dbcon,$tbl_name,$ar);
    if($del){
      header("location: full.php?code=".$_GET['code']."");
    }
}
if(isset($_POST['save_button'])){
  $package_code =$_POST['package_code'];
  $package_name =$_POST['package_name'];
  $package_desc =$_POST['package_desc'];
  //$package_type =$_POST['package_type'];
  //$menu_type = filter($_POST['menu_type']);
  //$service_type = filter($_POST['service_type']);
  //$no_person = filter($_POST['no_person']);
  //$suggest_amount = filter($_POST['suggest_amount']);
  $suggest_total = $_POST['suggest_total'];
  //$per_head = filter($_POST['per_head']);
  //$total_price = $_POST['total_price'];
  $allowedExts = array("gif", "jpeg", "jpg", "png");
  $temp = explode(".", $_FILES["photo"]["name"]);
  $photo =$_FILES['photo'] ["name"];
  $extension = end($temp);

  
  $kweri = $dbcon->query("SELECT COUNT(food_type) as viands FROM package_extension WHERE code = '".$_GET['code']."' AND food_type='Viands'") or die(mysqli_error());

  $viands = $kweri->fetch_assoc();

  $kweri2 = $dbcon->query("SELECT COUNT(food_type) as dessert FROM package_extension WHERE code = '".$_GET['code']."' AND food_type='Dessert'") or die(mysqli_error());

  $dessert = $kweri2->fetch_assoc();

  $kweri3 = $dbcon->query("SELECT COUNT(food_type) as rice FROM package_extension WHERE code = '".$_GET['code']."' AND food_type='Rice'") or die(mysqli_error());

  $rice = $kweri3->fetch_assoc();

  $kweri4 = $dbcon->query("SELECT COUNT(food_type) as pasta FROM package_extension WHERE code = '".$_GET['code']."' AND food_type='Pasta or Vegetables'") or die(mysqli_error());

  $pasta = $kweri4->fetch_assoc();

  $kweri5 = $dbcon->query("SELECT COUNT(food_type) as drinks FROM package_extension WHERE code = '".$_GET['code']."' AND food_type='Drinks'") or die(mysqli_error());

  $drinks = $kweri5->fetch_assoc();
  

  $checkName = single_get("*","package_name","packages",$package_name);
  $checkCode = single_get("*","package_code","packages",$package_code);
  if($checkName['package_name'] == $package_name){
    $msg = 'Name: '.$package_name.' already exist on database.';
  }elseif($checkCode['package_code'] == $package_code){
    $msg = 'Code: '.$package_code.' already exist on database.';
  }elseif($suggest_total == '0'){
     $msg = 'Please add amenities to continue';
  }elseif($viands['viands'] < '2' OR $dessert['dessert'] < '1' OR $rice['rice'] < '1' OR $pasta['pasta'] < '1' OR $drinks['drinks'] < '1'){
      $msg = 'You must complete the required food items to add. 2 Viands, 1 Rice, 1 Drink, 1 Dessert and 1 Pasta';
  }
  else{
    
    $insertSQL = array("package_code"=>$package_code,
      "package_name"=>$package_name,
      "package_desc"=>$package_desc,
      "package_type"=>$package_type,
      "suggest_total"=>$suggest_total,
      "total_price"=>$suggest_total,
      "code"=>$_GET['code'],
      "package_photo"=>$photo,
      "p_type"=>$_GET['pack_type'],
      "p_user"=>$_SESSION['user_id']);


    $one = insertdata("packages",$insertSQL);
    move_uploaded_file($_FILES["photo"]["tmp_name"],"../images/". $_FILES["photo"]["name"]);
    //$choices = array("ex_name"=>"".$kweri['menu_name']."" ,"code"=>$_GET['code'],"package_menu"=>$_POST['no_menu']);
    //$two = insertdata("package_extension",$choices);
    //$kweri = single_get("*","menu_id","menu",$menu_type);

    /*
    $standard_amenities = 'STANDARD AMENITIES<br>
    <ul>
    
    <li>Unlimited Iced Tea</li>
    <li>Well Trained and Uniformed Waiters</li>
    <li>Buffet Set-up with Floral Centerpieces</li>
    <li>Table with Floor Length Cover w/Floral Centerpiece and Chairs</li>
    <li>Purified Drinking Water</li>
    <li>Ice of Beverage</li>
    </ul>';

    $standard = array("ex_name"=>$standard_amenities,"code"=>$_GET['code'], "ex_standard"=>"1");
    */

    //$three = insertdata("package_extension",$standard);
    
    
    if($one){
      header("location: packages.php");
    }else{
      $mg = 'Hindi ng insert';
    }
    
  }
}
if(isset($_GET['code']) && isset($_GET['edit']) == '1'){
  $fetchRow = single_get("*","code","packages",$_GET['code']);
}

if(isset($_POST['save_button']) && isset($_GET['edit']) == '1'){
  $package_code =$_POST['package_code'];
  $package_name =$_POST['package_name'];
  $package_desc =$_POST['package_desc'];
  $package_type =$_POST['package_type'];
  $menu_type = filter($_POST['menu_type']);
  //$service_type = filter($_POST['service_type']);
  $no_person = filter($_POST['no_person']);
  //$suggest_amount = filter($_POST['suggest_amount']);
  $suggest_total = filter($_POST['suggest_total']);
  $per_head = filter($_POST['per_head']);
  $total_price = filter($_POST['total_price']);
  $allowedExts = array("gif", "jpeg", "jpg", "png");
  $temp = explode(".", $_FILES["photo"]["name"]);
  $photo =$_FILES['photo'] ["name"];
  $extension = end($temp);

  $kweri = $dbcon->query("SELECT COUNT(food_type) as viands FROM package_extension WHERE code = '".$_GET['code']."' AND food_type='Viands'") or die(mysqli_error());

  $viands = $kweri->fetch_assoc();

  $kweri2 = $dbcon->query("SELECT COUNT(food_type) as dessert FROM package_extension WHERE code = '".$_GET['code']."' AND food_type='Dessert'") or die(mysqli_error());

  $dessert = $kweri2->fetch_assoc();

  $kweri3 = $dbcon->query("SELECT COUNT(food_type) as rice FROM package_extension WHERE code = '".$_GET['code']."' AND food_type='Rice'") or die(mysqli_error());

  $rice = $kweri3->fetch_assoc();

  $kweri4 = $dbcon->query("SELECT COUNT(food_type) as pasta FROM package_extension WHERE code = '".$_GET['code']."' AND food_type='Pasta or Vegetables'") or die(mysqli_error());

  $pasta = $kweri4->fetch_assoc();

  $kweri5 = $dbcon->query("SELECT COUNT(food_type) as drinks FROM package_extension WHERE code = '".$_GET['code']."' AND food_type='Drinks'") or die(mysqli_error());

  $drinks = $kweri5->fetch_assoc();

  if($viands['viands'] < '2' OR $dessert['dessert'] < '1' OR $rice['rice'] < '1' OR $pasta['pasta'] < '1' OR $drinks['drinks'] < '1'){
      $msg = 'You must complete the required food items to add. 2 Viands, 1 Rice, 1 Drink, 1 Dessert and 1 Pasta';
  }else{
  if($photo != ""){
    if($suggest_total == '0'){
     $msg = 'Please add amenities to continue';
    }else{
     $update = $dbcon->query("UPDATE packages SET package_code='$package_code', package_name='$package_name', package_desc='$package_desc',package_type='$package_type',total_price='$suggest_total', package_photo = '$photo' WHERE code = '".$_GET['code']."'") or die(mysqli_error());
     move_uploaded_file($_FILES["photo"]["tmp_name"],"../images/". $_FILES["photo"]["name"]);
    }
  }else{
    if($suggest_total == '0'){
     $msg = 'Please add amenities to continue';
    }else{
     $update = $dbcon->query("UPDATE packages SET package_code='$package_code', package_name='$package_name', package_desc='$package_desc',package_type='$package_type',total_price='$suggest_total' WHERE code = '".$_GET['code']."'") or die(mysqli_error());
    }
   }
  }

  
    
  header("location: packages.php");
}

if(isset($_POST['select_option1'])){
  $ex_name = filter($_POST['ex_name']);
  $ex_price = filter($_POST['ex_price']);
  $code = filter($_GET['code']);
  $insertSQL = array("ex_name"=>$ex_name,"code"=>$code,"ex_price"=>$ex_price);
  insertdata("package_extension",$insertSQL);

  header("location: full.php?code=".$code."&pack_type=".$_GET['pack_type']."&options=0&search_btn=&full=".$_GET['full']."&edit=1");
}elseif(isset($_POST['select_option2'])){
  $ex_name = filter($_POST['ex_name']);
  $ex_price = filter($_POST['ex_price']);
  $code = filter($_GET['code']);
  $s = $dbcon->query("SELECT * FROM package_extension WHERE ex_name='$ex_name' AND code='$code' AND food_type = '".$_POST['food_type']."'") or die(mysqli_error());
  if(mysqli_num_rows($s) > 0){
      echo '<script>alert("Food items already exist.");</script>';
  }else{
      $insertSQL = array("ex_name"=>$ex_name,"code"=>$code,"ex_price"=>$ex_price,"food_type"=>$_POST['food_type']);
      insertdata("package_extension",$insertSQL);
  
  
  if(isset($_GET['edit']) == '1'){
    header("location: full.php?code=".$code."&pack_type=".$_GET['pack_type']."&full=".$_GET['package_code']."&options=1&search_btn=&edit=1&search_field=".$_GET['search_field']."");
  }
  else{
    header("location: full.php?code=".$code."&pack_type=".$_GET['pack_type']."&full=".$_GET['full']."&options=1&search_btn=&search_field=".$_GET['search_field']."");
  }
  }
  
}elseif(isset($_POST['select_option3'])){
  $ex_name = filter($_POST['ex_name']);
  $ex_price = filter($_POST['ex_price']);
  $code = filter($_GET['code']);
  $insertSQL = array("ex_name"=>$ex_name,"code"=>$code,"ex_price"=>$ex_price);
  insertdata("package_extension",$insertSQL);

  header("location: full.php?code=".$code."&pack_type=".$_GET['pack_type']."&options=2&search_btn=&full=".$_GET['full']."&edit=1");
}

if(!isset($_GET['edit'])){
  $pcode = $_GET['full'];
}

?>
<?php include'../assets/admin_header.php';?>
<?php include'../assets/admin_sidebar.php';?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content">
      <div class="row">
       <div class="container">
        
        <div class="box box-info" style="width:97.5%;">
            <div class="box-header">
            </div>
<?php if(isset($msg)):?><div class="alert alert-danger"><?php echo $msg;?></div><?php endif;?>
            
            <div class="row" style="padding:5px;">
                <div class="col-md-8">
                  <h4><i class="fa fa-plus"></i> Create Package - Combo Meals</h4>
                  <hr>
<form method="get">
  <input type="hidden" name="code" value="<?php echo $_GET['code']?>">
  <input type="hidden" name="pack_type" value="1">
  <input type="hidden" name="full" value="<?php echo $_GET['full']?>">
  <input type="hidden" name="option" value="1">
  <?php if(isset($_GET['edit']) == '1'):?>
    <input type="hidden" name="edit" value="1">
  <?php endif;?>
  <select class="form-control" name="search_field">
    <?php $r = getdata("*","food_categories");?>
    <?php if(!empty($r)):?>
      <?php foreach ($r as $key => $value):?>
        <option value="<?php echo $value->f_id?>" <?php 
        if(isset($_GET['search_btn'])){
          if($value->f_id == $_GET['search_field']){
            echo 'selected';
          }
        }
        ?>><?php echo $value->f_name?></option>
      <?php endforeach;?>
      <?php else:?>
        <div class="alert alert-danger">There are no records on the database.</div>
    <?php endif;?>
  </select>
  <p></p>
  <button class="btn btn-primary" name="search_btn"><i class="fa fa-search"></i> Search</button>
</form>
<hr>
<?php if(isset($_GET['search_btn'])):?>
             <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Name</th>
                  <th>Sub Category</th>
                  <th>Price</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
          <?php 
          $sql = $dbcon->query("SELECT * FROM food_items 
            INNER JOIN sub_category on sub_category.sub_id = food_items.sub_category
            INNER JOIN food_categories on food_categories.f_id = food_items.item_category
            WHERE food_items.item_category = '".$_GET['search_field']."'
          ") or die(mysqli_error());
          ?>

          <?php while($row = $sql->fetch_assoc()):?>
                <tr>
                  <td><?php echo $row['item_name']?></td>
                  <td><?php echo $row['sub_name']?></td>
                  <td>&#8369; <?php echo $row['cost_per_head']?></td>
                  <td>
                  <form method="post">
                    <input type="hidden" name="food_type" value="<?php echo $row['f_name']?>">
                          <input type="hidden" name="ex_name" value="<?php echo $row['item_name']?>">
                          <input type="hidden" name="ex_price" value="<?php echo $row['cost_per_head']?>">
                          <button name="select_option2"><i class="fa fa-plus"></i> Add</button>
                  </form>
                  </td>
                </tr>
          <?php endwhile;?> 
                      
              </table>
<?php endif;?>          
                </div>
                <div class="col-md-4" style="border:1px solid #d2d6de;color:#333;width:32%; "><h4><i class="fa fa-shopping-cart"></i> Items</h4><hr>
                  <?php $menuSQL = getdata_where("*","code","package_extension",$_GET['code']);?>
                  <?php if(!empty($menuSQL)):?>
                    <table class="table table-hovered table-bordered">
                      <tr>
                        <td>Name</td>
                        <td>Price</td>
                        <td>Action</td>
                      </tr>
                    
                    <?php foreach ($menuSQL as $key => $value):?>
                      <tr>
                        <td><?php echo $value->ex_name?></td>
                        <td>&#8369 <?php echo number_format($value->ex_price)?></td>
                        <td>
                        <?php if($value->ex_standard == '1'):?>
                        <?php else:?>
                          <a href="#" <?php echo 'onclick=" confirm(\'Are you sure you want to delete?\') 
      ?window.location = \'full.php?delete='.$value->ex_id.'\' : \'\';"'; ?>><i class="fa fa-remove"></i></a>
                        <?php endif;?>
                        </td>
                      </tr>
                    <?php endforeach;?>
                    </table>
                  <?php else:?>
                    <div class="alert alert-danger">There are no records on the database</div>
                  <?php endif;?>
                </div>
              </div>
                      <?php $getTotal = $dbcon->query("SELECT SUM(ex_price) as total FROM package_extension WHERE code='".$_GET['code']."'") or die(mysqli_error());
    $fetchResult = $getTotal->fetch_assoc();
?> 
                <?php if($fetchResult['total'] == 0):?><?php else: ?>
            <form method="post" enctype="multipart/form-data">
            <table class="table table-responsive table-bordered">
                <tr>
                  <td>Code:</td>
                  <td>
                    <input type="text" name="package_code" class="form-control" placeholder="Code" 
                    value="<?php if(isset($_GET['code']) && isset($_GET['edit']) =='1'): echo $fetchRow['package_code']; elseif(isset($_POST['save_button'])): echo $_POST['package_code']; else: echo $pcode; endif;?>" readonly="readonly">
                  </td>
                  <td>Name:</td>
                  <td>
                    
                    <input type="text" name="package_name" class="form-control" placeholder="Name" 
                    value="<?php if(isset($_GET['code']) && isset($_GET['edit']) =='1'): echo $fetchRow['package_name']; elseif(isset($_POST['save_button'])): echo $_POST['package_name']; endif;?>">
                  </td>
                </tr>
                <tr>
                  <td>Description:</td>
                  <td>
                    <textarea class="form-control" name="package_desc"><?php if(isset($_GET['code']) && isset($_GET['edit']) =='1'): echo $fetchRow['package_desc']; elseif(isset($_POST['save_button'])): echo $_POST['package_desc']; endif;?></textarea>
                  </td>
                  <td>Total Auto Computed Price:</td>
                  <td>
                    <?php $getTotal = $dbcon->query("SELECT SUM(ex_price) as total FROM package_extension WHERE code='".$_GET['code']."'") or die(mysqli_error());
                    $result = $getTotal->fetch_assoc();
                    ?>
                    <input type="text" name="suggest_total" id="result2" class="form-control" readonly="readonly"
                    value="<?php if($result['total'] > 0): echo $result['total'];else: echo '0'; endif;?>">
                  </td>
                </tr>
                <!--
                <tr>
                  <td>No. of Menus</td>
                  <td>
                    <input type="number" min="4" max ="9" name="no_menu" class="form-control" placeholder="No. of Menu"
                    value="<?php if(isset($_GET['code']) && $_GET['edit'] =='1'): echo $fetchRow['no_menu']; elseif(isset($_POST['save_button'])): echo $_POST['no_menu']; endif;?>">
                  </td>
                </tr>
              
              <tr>
                  <td>Menu Type</td>
                  <td>
                    <select name="menu_type" class="form-control">
                    
                    <?php $list = getdata("*","menu");?>
                    <?php foreach ($list as $key => $value):?>
                    <option value="<?php echo $value->menu_id?>"
                    <?php if(isset($_GET['code']) && isset($_GET['edit']) =='1'){
                      if($row['menu_type'] == $value->menu_id){
                        echo 'selected';
                      }
                    }
                    elseif(isset($_POST['save_button'])){
                        echo $_POST['menu_type'];
                      }
                      ?>><?php echo $value->menu_name?></option>
                  <?php endforeach;?>
            </select>
                  </td>
                </tr>
                -->
                <tr>
                    <!--
                   <td>Package Type:</td>
                  <td>
                    <select name="package_type" class="form-control">
                    <?php $list = getdata("*","package_type");?>
                    <?php foreach ($list as $key => $value):?>
                    <option value="<?php echo $value->pt_id?>"><?php echo $value->pt_name?></option>
                  <?php endforeach;?>
            </select>
                  </td>-->
                   <td>Photo:</td>
                  <td>
                    <input type="file" name="photo" class="form-control" required="required">
                  </td>
            <!--
            <tr>
                   <td>No. of persons:</td>
                  <td>
                    <input type="text" min="100" name="no_person" id = "textone" class="form-control" 
                    value="<?php if(isset($_GET['code']) && isset($_GET['edit']) =='1'): echo $fetchRow['no_person']; elseif(isset($_POST['save_button'])): echo $_POST['no_person']; endif;?>" placeholder="No. of Persons">
                  </td>
                  
                </tr>

                <tr>
                  <td>Per Head Amount:</td>
                  <td>
                    <input type="text" name="per_head" id ="texttwo" class="form-control" 
                    value="<?php if(isset($_GET['code']) && isset($_GET['edit']) =='1'): echo $fetchRow['per_head']; elseif(isset($_POST['save_button'])): echo $_POST['per_head']; endif;?>" placeholder="Per Head amount">
                  </td>
                  <td>Suggested Price:</td>
                  <td>
                    <input type="text" name="total_price2" id="result" class="form-control" 
                    value="<?php if(isset($_GET['code']) && isset($_GET['edit']) =='1'): echo $fetchRow['total_price']; elseif(isset($_POST['save_button'])): echo $_POST['total_price']; endif;?>" readonly="readonly" placeholder="Suggested Price">
                  </td>
                
                </tr>
              -->
                <tr>
                  
                  <!--
                   <td>Total Price:</td>
                  <td>
                    <input type="text" name="total_price" id="result3" class="form-control" 
                    value="<?php if(isset($_GET['code']) && isset($_GET['edit']) =='1'): echo $fetchRow['total_price']; elseif(isset($_POST['save_button'])): echo $_POST['total_price']; endif;?>">
                  </td>
                -->
                </tr>
              </table>
             
              

              <hr>
              
               <center>
                <button class="btn btn-primary" name="save_button"><i class="fa fa-save"></i> Save</button>
                    <a href="packages.php" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to list</a>
              </center><br>
              </form>
            <?php endif;?>
          </div>
          
       </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php include'../assets/admin_footer.php';?>

<script>
    $('#texttwo').keyup(function(){
        var textone;
        var texttwo;
        var result2;
        result2 = parseFloat($('#result2').val());
        textone = parseFloat($('#textone').val());
        texttwo = parseFloat($('#texttwo').val());
        
        var result = result2 + (textone * texttwo);
        $('#result').val(result.toFixed(2));

        


    });
</script>
<script>
    $('#texttwo').keyup(function(){
        var textone;
        var texttwo;
        var result2;
        result2 = parseFloat($('#result2').val());
        textone = parseFloat($('#textone').val());
        texttwo = parseFloat($('#texttwo').val());
        
        var result = result2 + (textone * texttwo);
        $('#result3').val(result.toFixed(2));

        


    });
</script>
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true
    })
  })
</script>
<script type="text/javascript">
  $('#example1').dataTable( {
  "pageLength": 6
} );
</script>
</body>
</html>
