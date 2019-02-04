<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_admin'])){
  header("Location: ../index.php");
  exit;
}
if(isset($_POST['save_button']) AND !isset($_GET['item_id'])){
  $item_code =$_POST['item_code'];
  $item_name =$_POST['item_name'];
  $item_category =$_POST['cat_id'];
  $item_type = $_POST['meal_type'];
  $sub_id =$_POST['sub_id'];
  $cost_per_head =$_POST['cost_per_head'];
  $allowedExts = array("gif", "jpeg", "jpg", "png");
  $temp = explode(".", $_FILES["photo"]["name"]);
  $photo =$_FILES['photo'] ["name"];
  $extension = end($temp);
  //$menu_type = filter($_POST['menu_type']);
 

  $checkName = single_get("*","item_name","food_items",$item_name);
  $checkCode = single_get("*","item_code","food_items",$item_code);
  if($checkName['item_name'] == $item_name){
    $msg = 'Name: '.$f_name.' already exist on database.';
  }elseif($checkCode['item_code'] == $item_code){
    $msg = 'Code: '.$item_code.' already exist on database.';
  }
  else{
    $insertSQL = array("item_code"=>$item_code,"item_name"=>$item_name, "itm_image"=>$photo,"item_category"=>$item_category,"cost_per_head"=>$cost_per_head,"sub_category"=>$sub_id,"menu_type"=>$item_type);
    insertdata("food_items",$insertSQL);
    move_uploaded_file($_FILES["photo"]["tmp_name"],"../images/". $_FILES["photo"]["name"]);
    header("location: food_items.php");
  }
}
if(isset($_GET['item_id'])){
  $row = single_get("*","item_id","food_items",$_GET['item_id']);
}
if(isset($_POST['save_button']) && isset($_GET['item_id'])){
  $item_code =$_POST['item_code'];
  $item_name =$_POST['item_name'];
  $item_category =$_POST['cat_id'];
  $sub_id =$_POST['sub_id'];
  $item_type = $_POST['meal_type'];
  $cost_per_head =$_POST['cost_per_head'];
  $allowedExts = array("gif", "jpeg", "jpg", "png");
  $temp = explode(".", $_FILES["photo"]["name"]);
  $photo =$_FILES['photo'] ["name"];
  $extension = end($temp);
  //$menu_type = filter($_POST['menu_type']);
  
  if($photo != ''){
    $update = $dbcon->query("UPDATE food_items SET item_code='$item_code', item_name='$item_name', item_category='$item_category',cost_per_head='$cost_per_head', itm_image='$photo', sub_category='$sub_id',menu_type='$item_type' WHERE item_id = '".$_GET['item_id']."'") or die(mysqli_error());
    move_uploaded_file($_FILES["photo"]["tmp_name"],"../images/". $_FILES["photo"]["name"]);
  }else{
  $update = $dbcon->query("UPDATE food_items SET item_code='$item_code', item_name='$item_name', item_category='$item_category',cost_per_head='$cost_per_head', sub_category='$sub_id',menu_type='$item_type' WHERE item_id = '".$_GET['item_id']."'") or die(mysqli_error());
  }
  header("location: food_items.php");
}
$pcode = "FI-".rand(0,999)."";
?>
<?php include'../assets/admin_header.php';?>
<?php include'../assets/admin_sidebar.php';?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content">
      <div class="row">
       <div class="container">
        
        <div class="box box-info" style="width:95.5%;">
            <div class="box-header">
              <h4 class="box-title"><i class="fa fa-plus"></i> Create Item  </h4>
            </div>
<?php if(isset($msg)):?><div class="alert alert-danger"><?php echo $msg;?></div><?php endif;?>
            <form method="post" enctype="multipart/form-data">
            <table class="table table-responsive table-bordered">
                <tr>
                  <td>Code:</td>
                  <td>
                    <input type="text" name="item_code" class="form-control" placeholder="Code" required="required"
                    value="<?php if(isset($_GET['item_id'])): echo $row['item_code']; elseif(isset($_POST['save_button'])): echo $_POST['item_code']; else: echo $pcode; endif;?>" readonly="readonly">
                  </td>
                </tr>
                <tr>
                  <td>Name:</td>
                  <td>
                    <input type="text" name="item_name" class="form-control" placeholder="Name" required="required"
                    value="<?php if(isset($_GET['item_id'])): echo $row['item_name']; elseif(isset($_POST['save_button'])): echo $_POST['item_name']; endif;?>">
                  </td>
                </tr>
                <tr>
                  <td>Image:</td>
                  <td>
                    <input type="file" name="photo">
                  </td>
                </tr>
                <tr>
                  <td>Category:</td>
                  <td>

                     <select class="form-control" required = 'required' name = "cat_id" id="functionList" onchange="changeCat(this.value)">
                      <?php
                      $catCounter = 0;
                      $field = $dbcon->query("SELECT * FROM food_categories") or die(mysqli_error());
                      while($fields = $field->fetch_assoc()){
                        if($catCounter == 0){
                          $catCounter += 1;
                          $functionOne = $fields['f_id'];
                        }
                      ?>
                      <option value="<?php echo $fields['f_id']?>"><?php echo $fields['f_name']?></option>
                      <?php   
                      }
                      ?>
                    </select>
                  </td>
                </tr>
                
                <tr>
                  <td>Sub Category:</td>
                  <td>
                    <select class="form-control" required = 'required' name="sub_id" id="compList" onchange="me(this.value)" >
                        <?php
                        $funcCounter = 0;
                        $function = $dbcon->query("SELECT * FROM sub_category WHERE cat_id = ".$functionOne) or die(mysqli_error());
                        if(mysqli_num_rows($function) == 0){
                          echo '<option>Select Data</option>';
                        }else{
                        while($functions = $function->fetch_assoc()){
                          if($funcCounter == 0){
                            $funcCounter += 1;
                            $compOne = $functions['cat_id'];
                          }
                      ?>
                       <option value="<?php echo $functions['sub_id']?>"><?php echo $functions['sub_name']?></option>
                       
                      <?php }
                      }
                        ?>
                      </select>
                  </td>
                </tr>
              <tr>  
                      <td>Meal Type</td>
                      <td>
                      <select name="meal_type" class="form-control">
                        <option value="0">Breakfast</option>
                        <option value="1">Dinner / Lunch</option> 
                      </select>
                      </td>
              </tr>
                <tr>
                  <td>Cost Per head:</td>
                  <td>
                    <input type="text" min="50" name="cost_per_head" class="form-control" placeholder="Cost per Head" required="required"
                    value="<?php if(isset($_GET['item_id'])): echo $row['cost_per_head']; elseif(isset($_POST['save_button'])): echo $_POST['cost_per_head']; endif;?>">
                  </td>
                </tr>
                <tr>
                  <td></td>
                  <td>
                    <button class="btn btn-primary" name="save_button"><i class="fa fa-save"></i> Save</button>
                    <a href="food_items.php" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to list</a>
                  </td>
                </tr>
              </table>
              </form>
            
          </div>
          
       </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script type="text/javascript">
function changeCat(key){
  if(window.XMLHttpRequest){
  // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp = new XMLHttpRequest();
  }else{
  // code for IE6, IE5
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange = function(){
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
      document.getElementById("compList").innerHTML = xmlhttp.responseText;
      var comp = document.getElementById("compList").value;
      me(comp);
    }
  }
  xmlhttp.open("GET","changeCat.php?key="+key, true);
  xmlhttp.send(); 
}
</script>
<?php include'../assets/admin_footer.php';?>

</body>
</html>
