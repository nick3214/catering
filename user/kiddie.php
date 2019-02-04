<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_user'])){
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
$custom = single_get("*","setting_id","site_settings","1");
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
  $per_head = filter($_POST['per_head']);
  $total_price = filter($_POST['total_price']);

  //$allowedExts = array("gif", "jpeg", "jpg", "png");
  //$temp = explode(".", $_FILES["photo"]["name"]);
  //$photo =$_FILES['photo'] ["name"];
  //$extension = end($temp);
 

  $checkName = single_get("*","package_name","packages",$package_name);
  $checkCode = single_get("*","package_code","packages",$package_code);
  if($checkName['package_name'] == $package_name){
    $msg = 'Name: '.$package_name.' already exist on database.';
  }elseif($checkCode['package_code'] == $package_code){
    $msg = 'Code: '.$package_code.' already exist on database.';
  }elseif($suggest_total == '0'){
    $msg = 'Please add amenities';
  }
  else{
    $insertSQL = array("package_code"=>$package_code,"package_name"=>$package_name, "package_desc"=>$package_desc,"package_type"=>$package_type,"menu_type"=>$menu_type,"no_kids"=>$no_kids,"no_adults"=>$no_adults,"no_menu"=>$_POST['no_menu'],"suggest_total"=>$suggest_total,"per_head"=>$per_head,"total_price"=>$total_price,"code"=>$_GET['code'],"package_photo"=>"noimage.png","p_user"=>$_SESSION['user_id'],"p_type"=>$_GET['pack_type'],"custom_user"=>"1");
    insertdata("packages",$insertSQL);
    move_uploaded_file($_FILES["photo"]["tmp_name"],"../images/". $_FILES["photo"]["name"]);
    $standard_amenities = 'STANDARD AMENITIES<br>
    <ul>
    <li>Food menu Choice</li>
    <li>Unlimited Iced Tea</li>
    <li>Well Trained and Uniformed Waiters</li>
    <li>Buffet Set-up with Floral Centerpieces</li>
    <li>Table with Floor Length Cover w/Floral Centerpiece and Chairs</li>
    <li>Purified Drinking Water</li>
    <li>Ice of Beverage</li>
    </ul>';

    $kweri = single_get("*","menu_id","menu",$menu_type);
    $standard = array("ex_name"=>$standard_amenities,"code"=>$_GET['code'],"ex_standard"=>"1");
    
    $choices = array("ex_name"=>"Choices of ".$_POST['no_menu']." ".$kweri['menu_name']."" ,"code"=>$_GET['code'],"package_menu"=>$_POST['no_menu']);
    insertdata("package_extension",$standard);
    insertdata("package_extension",$choices);
    header("location: customize.php");
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
    $msg = 'Please add amenities';
  }else{
    $update = $dbcon->query("UPDATE packages SET package_code='$package_code', package_name='$package_name', package_desc='$package_desc',package_type='$package_type',menu_type='$menu_type',no_kids='$no_kids',no_adults='$no_adults',total_price='$total_price' WHERE code = '".$_GET['code']."'") or die(mysqli_error());
    header("location: customize.php");
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
    header("location: kiddie.php?code=".$code."&pack_type=".$_GET['pack_type']."&kd=".$_GET['kd']."&edit=1&custom=".$_GET['custom']."&package=".$_GET['package']."");
  }else{
  header("location: kiddie.php?code=".$code."&pack_type=".$_GET['pack_type']."&kd=".$_GET['kd']."&custom=".$_GET['custom']."&package=".$_GET['package']."");
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
<?php include'../assets/user_header.php';?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
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

          <?php while($fetchRow = $sql->fetch_assoc()):?>
                <tr>
                  <td><?php echo $fetchRow['a_name']?></td>
                  <td>&#8369; <?php echo $fetchRow['a_price']?></td>
                  <td>
                  <form method="post">
                     <input type="hidden" name="kd" value="<?php echo $_GET['kd']?>">
                     <input type="hidden" name="save_button">
                          <input type="hidden" name="ex_name" value="<?php echo $fetchRow['a_name']?>">
                          <input type="hidden" name="ex_price" value="<?php echo $fetchRow['a_price']?>">
                          <button name="select_option2"><i class="fa fa-plus"></i> Add</button>
                  </form>
                  </td>
                </tr>
          <?php endwhile;?> 
                      
              </table>
              
                </div>
                <div class="col-md-4" style="background:white;border:1px solid #d2d6de;color:#333;width:32%; "><h4><i class="fa fa-list"></i> Menus</h4><hr>
                  <?php $menuSQL = getdata_where("*","code","package_extension",$_GET['code']);?>
                  <?php if(!empty($menuSQL)):?>
                    <table class="table table-bordered">
                      <tr>
                        <td>Name</td>
                        <td>Price</td>
                        <td>Action</td>
                      </tr>
                    
                    <?php foreach ($menuSQL as $key => $value):?>
                      <tr>
                        <td><?php echo $value->ex_name?></td>
                        <td><?php echo $value->ex_price?></td>
                        <td>
                          <a href="#" <?php echo 'onclick=" confirm(\'Are you sure you want to delete?\') 
      ?window.location = \'kiddie.php?delete='.$value->ex_id.'\' : \'\';"'; ?>><i class="fa fa-remove"></i></a>
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
                    value="<?php if(isset($_GET['code']) && isset($_GET['edit']) == '1'): echo $row['package_code']; elseif(isset($_POST['save_button'])): echo $_POST['package_code']; else: echo $pcode; endif;?>" readonly>
                  </td>
                  <td>Name:</td>
                  <td>
                    <input type="text" name="package_name" class="form-control" placeholder="Name" 
                    value="<?php if(isset($_GET['code']) && isset($_GET['edit']) == '1'): echo $row['package_name']; elseif(isset($_POST['save_button'])): echo $_POST['package_name']; else: echo $_GET['package']; endif;?>" readonly="readonly">
                  </td>
                </tr>
                <tr>
                  <td>Description:</td>
                  <td>
                    <input type="text" name="package_desc" class="form-control" placeholder="Package Description" 
                    value="<?php if(isset($_GET['code']) && isset($_GET['edit']) == '1'): echo $row['package_desc']; elseif(isset($_POST['save_button'])): echo $_POST['package_desc']; else: echo $_GET['custom'];endif;?>" readonly="readonly">
                  </td>
                  <!--
                  <td>Suggested total price:</td>
                  <td>
                    
                  </td>
                -->
                <?php $getTotal = $dbcon->query("SELECT SUM(ex_price) as total FROM package_extension WHERE code='".$_GET['code']."'") or die(mysqli_error());
                    $result = $getTotal->fetch_assoc();
                    ?>
                    <input type="hidden" name="suggest_total" id="result2" onkeyup="sum();" class="form-control" readonly="readonly"
                    value="<?php if($result['total'] > 0): echo $result['total'];else: echo '0'; endif;?>">
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
                   <td>No. of Menus(Kids)</td>
                  <td>
                  <!--
                    <input type="number" min="4" max ="9" name="no_menu" class="form-control" placeholder="No. of Menu"
                    value="<?php if(isset($_GET['code']) && isset($_GET['edit']) == '1'): echo $row['no_menu']; elseif(isset($_POST['save_button'])): echo $_POST['no_menu']; endif;?>">
                  -->
                   <select class="form-control" id="categoryList" name="no_menu" onchange="changeKiddie(this.value)">
                    <?php
                    $field = $dbcon->query("SELECT * FROM menu_price WHERE head_type = '1'");
                    $fieldCounter = 0;
                    while($fields = $field->fetch_assoc()){
                      echo '<option value="'.$fields['no_menu'].'">'.$fields['no_menu'].'</option>';
                      if($fieldCounter == 0){
                        $fieldSn = $fields['no_menu'];
                        $fieldCounter = 1;
                      }
                    }
                  ?>
                  </select>
                  </td>
                </tr>
                <tr>
                  
                  
                   <td>Price per Head (Kids)</td>
                  <td>

                    <select  id="textone" onkeyup="sum();" class="form-control" name="per_head" readonly>
      <?php
        $function = $dbcon->query("SELECT * FROM menu_price WHERE no_menu ='".$fieldSn."' AND head_type='1'");
        $functionCounter = 0;
        while($functions = $function->fetch_assoc()){
          echo '<option value="'.$functions['menu_price'].'">'.$functions['menu_price'].'</option>';
          if($functionCounter == 0){
            $functionSn = $functions['menu_price'];
            $functionCounter = 1;
          }
        }
      ?>
    </select>
                  </td>
     <td>No. of Menus(Adults)</td>
                  <td>
                  <!--
                    <input type="number" min="4" max ="9" name="no_menu" class="form-control" placeholder="No. of Menu"
                    value="<?php if(isset($_GET['code']) && isset($_GET['edit']) == '1'): echo $row['no_menu']; elseif(isset($_POST['save_button'])): echo $_POST['no_menu']; endif;?>">
                  -->
                   <select class="form-control" id="categoryList" name="no_menu" onchange="changeFull(this.value)">
                    <?php
                    $field = $dbcon->query("SELECT * FROM menu_price WHERE head_type ='0'");
                    $fieldCounter = 0;
                    while($fields = $field->fetch_assoc()){
                      echo '<option value="'.$fields['no_menu'].'">'.$fields['no_menu'].'</option>';
                      if($fieldCounter == 0){
                        $fieldSn = $fields['no_menu'];
                        $fieldCounter = 1;
                      }
                    }
                  ?>
                  </select>
                  </td>       
                </tr>
                <tr>
                 
                  <td>Price per Head (Adults)</td>
                  <td>

                    <select  id="texttwo" onkeyup="sum();" class="form-control" name="per_head" readonly>
      <?php
        $function = $dbcon->query("SELECT * FROM menu_price WHERE no_menu ='".$fieldSn."' AND head_type='0'");
        $functionCounter = 0;
        while($functions = $function->fetch_assoc()){
          echo '<option value="'.$functions['menu_price'].'">'.$functions['menu_price'].'</option>';
          if($functionCounter == 0){
            $functionSn = $functions['menu_price'];
            $functionCounter = 1;
          }
        }
      ?>
    </select>
                  </td>
 <td>No. of Kids</td>
                  <td>
                    <input type="text" name="no_kids" id = "kidsone" onkeyup="sum();" class="form-control" 
                    value="<?php if(isset($_GET['code']) && isset($_GET['edit']) == '1'): echo $row['no_kids']; elseif(isset($_POST['save_button'])):echo $_POST['no_kids']; endif;?>" placeholder="No. of Kids">
                  </td> 
                  <tr>
               
                   <td>No. of Adults:</td>
                  <td>
                    <input type="text" name="no_adults" id="adultstwo" onkeyup="sum();" class="form-control" 
                    value="<?php if(isset($_GET['code']) && isset($_GET['edit']) == '1'): echo $row['no_adults']; elseif(isset($_POST['save_button'])): echo $_POST['no_adults']; endif;?>" placeholder="No. of Adults">
                  </td>
                  <td>Total Price:</td>
                  <td>
                    <input type="text" name="total_price" id="result" class="form-control" 
                    value="<?php if(isset($_GET['code']) && isset($_GET['edit']) == '1'): echo $row['total_price']; elseif(isset($_POST['save_button'])): echo $_POST['total_price']; endif;?>" placeholder="Total Price" readonly>
                  </td>
                </tr>
                <tr>
                  
                  
                  <td>Customization Fee:</td>
                  <td>
                    <input type="text" name="custom_fee" id="textthree" onkeyup="sum();" class="form-control" value="<?php echo $custom['setting_value']?>" readonly="readonly">
                  </td>
                  
                </tr>
                <!--
                <tr>
                     <td>Photo:</td>
                  <td>
                    <input type="file" name="photo" class="form-control" required="required">
                  </td>
                </tr>
              -->
              </table>
              <hr>
              
               <center>
                <button class="btn btn-primary" name="save_button"><i class="fa fa-save"></i> Save</button>
                    <a href="customize.php" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to list</a>
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
<script type="text/javascript">
  function changeFull(field){
  if(window.XMLHttpRequest){
  // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp = new XMLHttpRequest();
  }else{
  // code for IE6, IE5
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange = function(){
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
      document.getElementById("texttwo").innerHTML = xmlhttp.responseText;
      domino();
    }
  }
  xmlhttp.open("GET","changeFull.php?field="+field, true);
  xmlhttp.send(); 
}
 function changeKiddie(field){
  if(window.XMLHttpRequest){
  // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp = new XMLHttpRequest();
  }else{
  // code for IE6, IE5
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange = function(){
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
      document.getElementById("textone").innerHTML = xmlhttp.responseText;
      domino();
    }
  }
  xmlhttp.open("GET","changeKiddie.php?field="+field, true);
  xmlhttp.send(); 
}
</script>
<?php include'../assets/admin_footer.php';?>
<!--
<script>
    $('#adultstwo').keyup(function(){
        var textone;
        var texttwo;
        var result2;
        result2 = parseFloat($('#result2').val());
        textone = parseFloat($('#textone').val());
        texttwo = parseFloat($('#texttwo').val());
        kidsone = parseFloat($('#kidsone').val());
        adultstwo = parseFloat($('#adultstwo').val());
        textthree = parseFloat($('#textthree').val());
        
        var result = result2 + (textone * kidsone) + (texttwo * adultstwo) + textthree;
        $('#result').val(result.toFixed(2));


    });
</script>
-->
<script>
function sum() {
  var textone = document.getElementById('textone').value;
  var texttwo = document.getElementById('texttwo').value;
  var textthree = document.getElementById('textthree').value;
  var result2 = document.getElementById('result2').value;
  var kidsone = document.getElementById('kidsone').value;
  var adultstwo = document.getElementById('adultstwo').value;

  var result = parseFloat(result2) + (parseFloat(textone) * parseFloat(kidsone)) + (parseFloat(texttwo) * parseFloat(adultstwo)) + parseFloat(textthree) ;
  if (!isNaN(result)) {
      document.getElementById('result').value = result;
  }
}
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
      'autoWidth'   : false
    })
  })
</script>
<script type="text/javascript">
  $('#example1').dataTable( {
  "pageLength": 4
} );
</script>
</body>
</html>

