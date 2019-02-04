<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_user'])){
  header("Location: ../index.php");
  exit;
}
$custom = single_get("*","setting_id","site_settings","1");
if(isset($_POST['save_button']) && isset($_GET['code'])){
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

  //$allowedExts = array("gif", "jpeg", "jpg", "png");
  //$temp = explode(".", $_FILES["photo"]["name"]);
  //$photo =$_FILES['photo'] ["name"];
  //$extension = end($temp);

  $per_head_amt = single_get("*","no_menu","menu_price",$_POST['no_menu']);   
  $total_price = filter($_POST['total_price']);
  //$GrandTotal = $total_price * $per_head_amt['menu_price'];

  $checkName = single_get("*","package_name","packages",$package_name);
  $checkCode = single_get("*","package_code","packages",$package_code);
  if($checkName['package_name'] == $package_name){
    $msg = 'Name: '.$package_name.' already exist on database.';
  }elseif($checkCode['package_code'] == $package_code){
    $msg = 'Code: '.$package_code.' already exist on database.';
  }
  else{
    $insertSQL = array("package_code"=>$package_code,"package_name"=>$package_name, "package_desc"=>$package_desc,"package_type"=>$package_type,"menu_type"=>$menu_type,"service_type"=>$service_type,"no_person"=>$no_person,"no_menu"=>$_POST['no_menu'],"suggest_total"=>$suggest_total,"per_head"=>$per_head,"total_price"=>$total_price,"code"=>$_GET['code'],"package_photo"=>"noimage.png","p_type"=>$_GET['pack_type'],"p_user"=>$_SESSION['user_id'],"custom_user"=>"1");
    insertdata("packages",$insertSQL);

    $standard_amenities = 'STANDARD AMENITIES<br>
    <ul>
    <li>Food Menu Choices</li>
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
    move_uploaded_file($_FILES["photo"]["tmp_name"],"../images/". $_FILES["photo"]["name"]);
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
  $no_person = filter($_POST['no_person']);
  //$suggest_amount = filter($_POST['suggest_amount']);
  $suggest_total = filter($_POST['suggest_total']);
  //$per_head = filter($_POST['per_head']);
  //$total_price = filter($_POST['total_price']);
  //$allowedExts = array("gif", "jpeg", "jpg", "png");
  //$temp = explode(".", $_FILES["photo"]["name"]);
  //$photo =$_FILES['photo'] ["name"];
  //$extension = end($temp);

  $per_head = single_get("*","no_menu","menu_price",$_POST['no_menu']);   
  $total_price = filter($_POST['total_price']);
  //$GrandTotal = ($total_price * $per_head['menu_price']);

  
     $update = $dbcon->query("UPDATE packages SET package_code='$package_code', package_name='$package_name', package_desc='$package_desc',package_type='$package_type',menu_type='$menu_type',no_person='$no_person',per_head='$per_head',total_price='$total_price',package_photo='noimage.png' WHERE code = '".$_GET['code']."'") or die(mysqli_error());
     
  header("location: customize.php");
}
if(isset($_POST['select_option1'])){
  $ex_name = filter($_POST['ex_name']);
  $ex_price = filter($_POST['ex_price']);
  $code = filter($_GET['code']);
  $insertSQL = array("ex_name"=>$ex_name,"code"=>$code,"ex_price"=>$ex_price);
  insertdata("package_extension",$insertSQL);
  
  header("location: standard.php?code=".$code."&pack_type=".$_GET['pack_type']."&options=0&search_btn=");
}elseif(isset($_POST['select_option2'])){
  $ex_name = filter($_POST['ex_name']);
  $ex_price = filter($_POST['ex_price']);
  $code = filter($_GET['code']);
  $insertSQL = array("ex_name"=>$ex_name,"code"=>$code,"ex_price"=>$ex_price);
  insertdata("package_extension",$insertSQL);
  
  header("location: standard.php?code=".$code."&pack_type=".$_GET['pack_type']."&options=1&search_btn=");
}elseif(isset($_POST['select_option3'])){
  $ex_name = filter($_POST['ex_name']);
  $ex_price = filter($_POST['ex_price']);
  $code = filter($_GET['code']);
  $insertSQL = array("ex_name"=>$ex_name,"code"=>$code,"ex_price"=>$ex_price);
  insertdata("package_extension",$insertSQL);
  
  header("location: standard.php?code=".$code."&pack_type=".$_GET['pack_type']."&options=2&search_btn=");
}
if(!isset($_GET['edit'])){
$pcode = $_GET['stnd'];
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
              <h4 class="box-title"><i class="fa fa-plus"></i> Create Package - STANDARD PACKAGE </h4>
            </div>
<?php if(isset($msg)):?><div class="alert alert-danger"><?php echo $msg;?></div><?php endif;?>
            
            <div class="row" style="padding:5px;">
                <div class="col-md-12">
<!--
              <form method="GET">
                <input type="hidden" name="code" value="<?php echo $_GET['code'];?>">
                <input type="hidden" name="pack_type" value="<?php echo $_GET['pack_type'];?>">
                  <select name="options" class="form-control">
                  <option value="0" <?php if(isset($_GET['search_btn'])): if($_GET['options'] == '0'): echo 'selected';endif;endif;?>>Freebies</option>
                  <option value="1" <?php if(isset($_GET['search_btn'])): if($_GET['options'] == '1'): echo 'selected';endif;endif;?>>Other Amenities</option>
                  <option value="2" <?php if(isset($_GET['search_btn'])): if($_GET['options'] == '2'): echo 'selected';endif;endif;?>>Themes</option>
                  </select><br>
                  <button class="btn btn-info" name="search_btn"><i class="fa fa-search"></i> Search</button>
              </form>
              <?php if(isset($_GET['search_btn'])):?>
                  <?php if($_GET['options'] =='0'){
                    $kweri = getdata("*","freebies");
                    if(!empty($kweri)):
                  ?>
                  <table class="table table-bordered">
                    <tr>
                      <td>Name</td>
                      <td>Price</td>
                      <td>Action</td>
                    </tr>
                  <?php 
                      foreach ($kweri as $key => $value):
                  ?>
                  <tr>
                      <td><?php echo $value->freebie_name?></td>
                      <td><?php echo $value->f_price?></td>
                      <td>
                        <form method="post">
                          <input type="hidden" name="ex_name" value="<?php echo $value->freebie_name?>">
                          <input type="hidden" name="ex_price" value="<?php echo $value->f_price?>">
                          <button name="select_option1"><i class="fa fa-plus"></i> Add</button>
                        </form>
                      </td>
                    </tr>
                  <?php endforeach;?>
                  </table>
                  <?php else:?>
                    No records
                  <?php endif;?>
                  <?php }elseif($_GET['options'] =='1'){
                    $sql = getdata_where("*","a_type","amenities","Other");
                    if(!empty($sql)):
                  ?>
                  <table class="table table-bordered">
                    <tr>
                      <td>Name</td>
                      <td>Price</td>
                      <td>Action</td>
                    </tr>
                  <?php 
                      foreach ($sql as $key => $value):
                  ?>
                  <tr>
                      <td><?php echo $value->a_name?></td>
                      <td><?php echo $value->a_price?></td>
                      <td>
                        <form method="post">
                          <input type="hidden" name="ex_name" value="<?php echo $value->a_name?>">
                          <input type="hidden" name="ex_price" value="<?php echo $value->a_price?>">
                          <button name="select_option2"><i class="fa fa-plus"></i> Add</button>
                        </form>
                      </td>
                    </tr>
                  <?php endforeach;?>
                  </table>
                  <?php else:?>
                    No records
                  <?php endif;?>
                  <?php }elseif($_GET['options'] == '2'){
                    $sql1 = getdata("*","themes");
                    if(!empty($sql1)):
                  ?>
                  <table class="table table-bordered">
                    <tr>
                      <td>Image</td>
                      <td>Name</td>
                      <td>Action</td>
                    </tr>
                  <?php 
                      foreach ($sql1 as $key => $value):
                  ?>
                  <tr>
                      <td><img src="../images/<?php echo $value->theme_img?>" width="100"></td>
                      <td><?php echo $value->theme_name?></td>
                      <td>
                        <form method="post">
                          <input type="hidden" name="ex_name" value="<?php echo $value->theme_name?>">
                          <button name="select_option3"><i class="fa fa-plus"></i> Add</button></form>
                      </td>
                    </tr>
                  <?php endforeach;?>
                  </table>
                  <?php else:?>
                    No records
                  <?php endif;?>
                  <?php }?>

              <?php endif;?>
              
                </div>
                <div class="col-md-4" style="background:#f4f4f4;border:1px solid #d2d6de;color:#333;width:32%; "><h4><i class="fa fa-list"></i> Menus</h4><hr>
                  <?php $menuSQL = getdata_where("*","code","package_extension",$_GET['code']);?>
                  <?php if(!empty($menuSQL)):?>
                    <table class="table table-bordered">
                      <tr>
                        <td>Name</td>
                        <td>Action</td>
                      </tr>
                    
                    <?php foreach ($menuSQL as $key => $value):?>
                      <tr>
                        <td><?php echo $value->ex_name?></td>
                        <td>
                          <a href="#" <?php echo 'onclick=" confirm(\'Are you sure you want to delete?\') 
      ?window.location = \'standard.php?delete='.$value->ex_id.'\' : \'\';"'; ?>><i class="fa fa-remove"></i></a>
                        </td>
                      </tr>
                    <?php endforeach;?>
                    </table>
                  <?php else:?>
                    <div class="alert alert-danger">There are no records on the database</div>
                  <?php endif;?>
                </div>
              </div>
            -->
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
                    value="<?php if(isset($_GET['code']) && isset($_GET['edit']) == '1'): echo $row['package_name']; elseif(isset($_POST['save_button'])): echo $_GET['package']; else: echo $_GET['package']; endif;?>" readonly="readonly">
                  </td>
                </tr>
                <tr>
                  <td>Description:</td>
                  <td>
                    <input type="text" name="package_desc" class="form-control" placeholder="Package Description" 
                    value="<?php if(isset($_GET['code']) && isset($_GET['edit']) == '1'): echo $row['package_desc']; elseif(isset($_POST['save_button'])): echo $_GET['custom']; else:  echo $_GET['custom']; endif;?>" readonly="readonly">
                  </td>
                  <!--
                  <td>Suggested total price:</td>
                  <td>
                    
                  </td>
                -->
                <input type="hidden" name="suggest_total" class="form-control" readonly="readonly"
                    value="<?php if(isset($_GET['code']) && isset($_GET['edit']) == '1'): echo $row['suggest_total']; else: echo "0"; endif;?>">
                <td>No. of Menus</td>
                  <td>
                    <!--
                    <input type="number" min="4" max ="9" name="no_menu" class="form-control" placeholder="No. of Menu"
                    value="<?php if(isset($_GET['code']) && isset($_GET['edit']) == '1'): echo $row['no_menu']; elseif(isset($_POST['save_button'])): echo $_POST['no_menu']; endif;?>">
                  -->
                   <select class="form-control" id="categoryList" name="no_menu" onchange="changeQMFunctions(this.value)">
                    <?php
                    $field = $dbcon->query("SELECT * FROM menu_price WHERE head_type = '0'");
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
                  <td>Package Type:</td>
                  <td>
                    <select name="package_type" class="form-control">
                    
                    <?php $list = getdata("*","package_type");?>
                    <?php foreach ($list as $key => $value):?>
                    <option value="<?php echo $value->pt_id?>"><?php echo $value->pt_code?><?php echo $value->pt_name?></option>
                  <?php endforeach;?>
            </select>
                  </td>
                </tr>
                <tr>
                  
                  <td>No. of persons:</td>
                  <td>
                    <input type="text" name="no_person" min="100" id = "textone" onkeyup="sum();" class="form-control" 
                    value="<?php if(isset($_GET['code']) && isset($_GET['edit']) == '1'): echo $row['no_person']; elseif(isset($_POST['save_button'])): echo $_POST['no_person']; endif;?>" placeholder="No. of persons">
                  </td>
                 <td>Per Head Amount:</td>
                  <td>
                    <!--
                    <input type="text" name="per_head" id ="functionList" class="form-control" 
                    value="<?php if(isset($_GET['code']) && isset($_GET['edit']) == '1'): echo $row['per_head']; elseif(isset($_POST['save_button'])): echo $amt_head['menu_price']; endif;?>">
                  -->
                  
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
                </tr>
                <tr>
                  
                   
                
                  <td>Customization Fee:</td>
                  <td>
                    <input type="text" name="custom_fee" id="textthree" onkeyup="sum();" class="form-control" value="<?php echo $custom['setting_value']?>" readonly="readonly">
                  </td>
                    <td>Total Price:</td>
                  <td>
                    <input type="text" name="total_price" id="result"  class="form-control" 
                    value="<?php if(isset($_GET['code']) && isset($_GET['edit']) == '1'): echo $row['total_price']; elseif(isset($_POST['save_button'])): echo $_POST['total_price']; endif;?>" readonly>
                  </td>
                </tr>
                <tr>
                 <!--
                  <td>Photo:</td>
                  <td>
                    <input type="file" name="photo" class="form-control">
                  </td>
                -->
                </tr>
              </table>
             
              

              <hr>
              
               <center>
                <button class="btn btn-primary" name="save_button"><i class="fa fa-save"></i> Save</button>
                    <a href="customize.php" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to list</a>
              </center><br>
              </form>
          </div>
          
       </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script type="text/javascript">
  function changeQMFunctions(field){
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
  xmlhttp.open("GET","changeQMFunctions.php?field="+field, true);
  xmlhttp.send(); 
}
</script>  
<?php include'../assets/admin_footer.php';?>
<!--
<script>
    $('#texttwo').keyup(function(){
        var textone;
        var texttwo;
        textone = parseFloat($('#textone').val());
        texttwo = parseFloat($('#texttwo').val());
        textthree = parseFloat($('#textthree').val());
        
        var result = (textone * texttwo) + textthree;
        $('#result').val(result.toFixed(2));


    });
</script>
-->
<script>
function sum() {
  var textone = document.getElementById('textone').value;
  var texttwo = document.getElementById('texttwo').value;
  var textthree = document.getElementById('textthree').value;
  var result = (parseFloat(textone) * parseFloat(texttwo)) + parseFloat(textthree);
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
</body>
</html>

