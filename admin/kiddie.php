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
      header("location: kiddie.php?code=".$_GET['code']."");
    }
}
$adults = single_get("*","person_id","per_person","1");
$kids = single_get("*","person_id","per_person","2");
if(isset($_POST['save_button']) AND isset($_GET['code'])){
  $package_code =$_POST['package_code'];
  $package_name =$_POST['package_name'];
  $package_desc =$_POST['package_desc'];
  $package_type =$_POST['package_type'];
  $menu_type = filter($_POST['menu_type']);
  //$service_type = filter($_POST['service_type']);
  $no_adults = filter($_POST['no_adults']);
  $no_kids = filter($_POST['no_kids']);
  //$suggest_amount = filter($_POST['suggest_amount']);
  $suggest_total = filter($_POST['suggest_total']);
  //$per_head = filter($_POST['per_head']);
  $total_price = filter($_POST['total_price']);
  $allowedExts = array("gif", "jpeg", "jpg", "png");
  $temp = explode(".", $_FILES["photo"]["name"]);
  $photo =$_FILES['photo'] ["name"];
  $extension = end($temp);
 

  $checkName = single_get("*","package_name","packages",$package_name);
  $checkCode = single_get("*","package_code","packages",$package_code);
  if($checkName['package_name'] == $package_name){
    $msg = 'Name: '.$package_name.' already exist on database.';
  }elseif($checkCode['package_code'] == $package_code){
    $msg = 'Code: '.$package_code.' already exist on database.';
  }elseif($suggest_total == '0'){
     $msg = 'Please add amenities to continue';
  }
  else{
    $insertSQL = array("package_code"=>$package_code,"package_name"=>$package_name, "package_desc"=>$package_desc,"package_type"=>$package_type,"menu_type"=>$menu_type,"service_type"=>$service_type,"no_kids"=>$no_kids,"no_adults"=>$no_adults,"no_menu"=>$_POST['no_menu'],"suggest_total"=>$suggest_total,"per_head"=>$per_head,"total_price"=>$total_price,"code"=>$_GET['code'],"package_photo"=>$photo,"p_type"=>$_GET['pack_type'],"p_user"=>$_SESSION['user_id']);
    insertdata("packages",$insertSQL);
    move_uploaded_file($_FILES["photo"]["tmp_name"],"../images/". $_FILES["photo"]["name"]);
    $kweri = single_get("*","menu_id","menu",$menu_type);
    $standard_amenities = 'STANDARD AMENITIES<br>
    <ul>
    
    <li>Unlimited Iced Tea</li>
    <li>Well Trained and Uniformed Waiters</li>
    <li>Buffet Set-up with Floral Centerpieces</li>
    <li>Table with Floor Length Cover w/Floral Centerpiece and Chairs</li>
    <li>Purified Drinking Water</li>
    <li>Ice of Beverage</li>
    </ul>';
    $standard = array("ex_name"=>$standard_amenities,"code"=>$_GET['code'],"ex_standard"=>"1");
    $choices = array("ex_name"=>"Choices of ".$_POST['no_menu']." ".$kweri['menu_name']."" ,"code"=>$_GET['code'],"package_menu"=>$_POST['no_menu']);
    insertdata("package_extension",$standard);
    insertdata("package_extension",$choices);
    
    
    header("location: packages.php");
  }
}
if(isset($_GET['code']) && isset($_GET['edit']) == '1'){
  $row = single_get("*","code","packages",$_GET['code']);
}
if(isset($_POST['save_button']) && isset($_GET['edit']) == '1'){
  $package_code =$_POST['package_code'];
  $package_name =$_POST['package_name'];
  $package_desc =$_POST['package_desc'];
  $package_type =$_POST['package_type'];
  $menu_type = filter($_POST['menu_type']);
  //$service_type = filter($_POST['service_type']);
  $no_adults = filter($_POST['no_adults']);
  $no_kids = filter($_POST['no_kids']);
  //$suggest_amount = filter($_POST['suggest_amount']);
  $suggest_total = filter($_POST['suggest_total']);
  //$per_head = filter($_POST['per_head']);
  $total_price = filter($_POST['total_price']);
  $allowedExts = array("gif", "jpeg", "jpg", "png");
  $temp = explode(".", $_FILES["photo"]["name"]);
  $photo =$_FILES['photo'] ["name"];
  $extension = end($temp);
  if($suggest_total == '0'){
     $msg = 'Please add amenities to continue';
  }else{
    $update = $dbcon->query("UPDATE packages SET package_code='$package_code', package_name='$package_name', package_desc='$package_desc',package_type='$package_type',menu_type='$menu_type',no_kids='$no_kids',no_adults='$no_adults',total_price='$total_price' WHERE code = '".$_GET['code']."'") or die(mysqli_error());
    header("location: packages.php");
  }
  
}
if(isset($_POST['select_option1'])){
  $ex_name = filter($_POST['ex_name']);
  $ex_price = filter($_POST['ex_price']);
  $code = filter($_GET['code']);
  $insertSQL = array("ex_name"=>$ex_name,"code"=>$code,"ex_price"=>$ex_price);
  insertdata("package_extension",$insertSQL);

  header("location: kiddie.php?code=".$code."&pack_type=".$_GET['pack_type']."&edit=1");
}elseif(isset($_POST['select_option2'])){
  $ex_name = filter($_POST['ex_name']);
  $ex_price = filter($_POST['ex_price']);
  $code = filter($_GET['code']);
  $insertSQL = array("ex_name"=>$ex_name,"code"=>$code,"ex_price"=>$ex_price);
  insertdata("package_extension",$insertSQL);
  if(isset($_GET['edit']) == '1'){
    header("location: kiddie.php?code=".$code."&pack_type=".$_GET['pack_type']."&edit=1&kd=".$_GET['kd']."");
  }else{
    header("location: kiddie.php?code=".$code."&pack_type=".$_GET['pack_type']."&kd=".$_GET['kd']."");
  }
  
}elseif(isset($_POST['select_option3'])){
  $ex_name = filter($_POST['ex_name']);
  $ex_price = filter($_POST['ex_price']);
  $code = filter($_GET['code']);
  $insertSQL = array("ex_name"=>$ex_name,"code"=>$code,"ex_price"=>$ex_price);
  insertdata("package_extension",$insertSQL);

  header("location: kiddie.php?code=".$code."&pack_type=".$_GET['pack_type']."&edit=1");
}
if(!isset($_GET['edit'])){
$pcode = $_GET['kd'];
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
              <h4 class="box-title"><i class="fa fa-plus"></i> Create Package - KIDDIE PACKAGE</h4>
            </div>
<?php if(isset($msg)):?><div class="alert alert-danger"><?php echo $msg;?></div><?php endif;?>
            
            <div class="row" style="padding:5px;">
                <div class="col-md-8">
                  <h4><i class="fa fa-list"></i> Amenities</h4>
                  <hr>
              
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Name</th>
                  <th>Price</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
          <?php 
          $sql = $dbcon->query("SELECT * FROM amenities WHERE a_type = 'Other'") or die(mysqli_error());
          ?>

          <?php while($result = $sql->fetch_assoc()):?>
                <tr>
                  <td><?php echo $result['a_name']?></td>
                  <td>&#8369; <?php echo $result['a_price']?></td>
                  <td>
                  <form method="post">
                          <input type="hidden" name="ex_name" value="<?php echo $result['a_name']?>">
                          <input type="hidden" name="ex_price" value="<?php echo $result['a_price']?>">
                          <button name="select_option2"><i class="fa fa-plus"></i> Add</button>
                  </form>
                  </td>
                </tr>
          <?php endwhile;?> 
                      
              </table>
              
              
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
                        <td><?php echo number_format($value->ex_price)?></td>
                        <td>
                          <?php if($value->ex_standard == '1'):?>
                        <?php else:?>
                          <a href="#" <?php echo 'onclick=" confirm(\'Are you sure you want to delete?\') 
      ?window.location = \'kiddie.php?delete='.$value->ex_id.'\' : \'\';"'; ?>><i class="fa fa-remove"></i></a>
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
                    value="<?php if(isset($_GET['code']) && isset($_GET['edit']) == '1'): echo $row['package_code']; elseif(isset($_POST['save_button'])): echo $_POST['package_code']; else: echo $_GET['kd']; endif;?>" readonly>
                  </td>
                  <td>Name:</td>
                  <td>
                    <input type="text" name="package_name" class="form-control" placeholder="Name" 
                    value="<?php if(isset($_GET['code']) && isset($_GET['edit']) == '1'): echo $row['package_name']; elseif(isset($_POST['save_button'])): echo $_POST['package_name']; endif;?>">
                  </td>
                </tr>
                <tr>
                  <td>Description:</td>
                  <td>
                    <input type="text" name="package_desc" class="form-control" placeholder="Package Description" 
                    value="<?php if(isset($_GET['code']) && isset($_GET['edit']) == '1'): echo $row['package_desc']; elseif(isset($_POST['save_button'])): echo $_POST['package_desc']; endif;?>">
                  </td>
                  <td>Amenities Total Price:</td>
                  <td>
                    <?php $getTotal = $dbcon->query("SELECT SUM(ex_price) as total FROM package_extension WHERE code='".$_GET['code']."'") or die(mysqli_error());
                    $result = $getTotal->fetch_assoc();
                    ?>
                    <input type="text" name="suggest_total" id="result2" class="form-control" readonly="readonly"
                    value="<?php if($result['total'] > 0): echo $result['total'];else: echo '0'; endif;?>">
                  </td>
                </tr>
                <tr>
                  <td>No. of Menus</td>
                  <td>
                    <input type="number" min="4" max ="9" name="no_menu" class="form-control" placeholder="No. of Menu"
                    value="<?php if(isset($_GET['code']) && isset($_GET['edit']) == '1'): echo $row['no_menu']; elseif(isset($_POST['save_button'])): echo $_POST['no_menu']; endif;?>">
                  </td>
                  <td>Menu Type</td>
                  <td>
                    <select name="menu_type" class="form-control">
                    <?php $list = getdata("*","menu");?>
                    <?php foreach ($list as $key => $value):?>
                    <option value="<?php echo $value->menu_id?>"
                    <?php if(isset($_GET['code']) && isset($_GET['edit']) == '1'){
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
                <tr>
                  <td>Package Type:</td>
                  <td>
                    <select name="package_type" class="form-control">
                    
                    <?php $list = getdata("*","package_type");?>
                    <?php foreach ($list as $key => $value):?>
                    <option value="<?php echo $value->pt_id?>"><?php echo $value->pt_code?><?php echo $value->pt_name?></option>
                  <?php endforeach;?>
            </select>
                  </td>
                   <td>No. of Kids - &#8369; <?php echo $kids['person_price']?></td>
                  <td>
                    <input type="text" name="no_kids" id = "textone" class="form-control" 
                    value="<?php if(isset($_GET['code']) && isset($_GET['edit']) == '1'): echo $row['no_kids']; elseif(isset($_POST['save_button'])):echo $_POST['no_kids']; endif;?>">
                  </td>
                 
                </tr>
                <tr>
                   <td>No. of Adults - &#8369; <?php echo $adults['person_price']?></td>
                  <td>
                    <input type="text" name="no_adults" id ="texttwo" class="form-control" 
                    value="<?php if(isset($_GET['code']) && isset($_GET['edit']) == '1' ): echo $row['no_adults']; elseif(isset($_POST['save_button'])): echo $_POST['no_adults']; endif;?>">
                  </td>
                  <td>Suggested Price:</td>
                  <td>
                    <input type="text" name="total_price2" id="result" class="form-control" 
                    value="<?php if(isset($_GET['code']) && isset($_GET['edit']) == '1'): echo $row['total_price']; elseif(isset($_POST['save_button'])): echo $_POST['total_price']; endif;?>" readonly>
                  </td>
                </tr>
                <tr>
                     <td>Photo:</td>
                  <td>
                    <input type="file" name="photo" class="form-control" required="required">
                  </td>
                   <td>Total Price:</td>
                  <td>
                    <input type="text" name="total_price" id="result3" class="form-control" 
                    value="<?php if(isset($_GET['code']) && isset($_GET['edit']) == '1'): echo $row['total_price']; elseif(isset($_POST['save_button'])): echo $_POST['total_price']; endif;?>">
                  </td>
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
        
        var result = result2 + (textone * <?php echo $kids['person_price']?>)  + (texttwo * <?php echo $adults['person_price']; ?>);
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
        
        var result = result2 + (textone * <?php echo $kids['person_price']?>)  + (texttwo * <?php echo $adults['person_price']; ?>);
        $('#result3').val(result.toFixed(2));


    });
</script>
<script type="text/javascript">
  $('#example1').dataTable( {
  "pageLength": 4
} );
</script>
</body>
</html>
