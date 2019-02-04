<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_admin'])){
  header("Location: ../index.php");
  exit;
}
if(isset($_POST['save_button']) AND !isset($_GET['package_id'])){
  $package_code =$_POST['package_code'];
  $package_name =$_POST['package_name'];
  $package_desc =$_POST['package_desc'];
  $package_type =$_POST['package_type'];
  $menu_type = filter($_POST['menu_type']);
  $service_type = filter($_POST['service_type']);
  $no_person = filter($_POST['no_person']);
  $suggest_amount = filter($_POST['suggest_amount']);
  $suggest_total = filter($_POST['suggest_total']);
  $per_head = filter($_POST['per_head']);
  $total_price = filter($_POST['total_price']);
 

  $checkName = single_get("*","package_name","packages",$package_name);
  $checkCode = single_get("*","package_code","packages",$package_code);
  if($checkName['package_name'] == $package_name){
    $msg = 'Name: '.$package_name.' already exist on database.';
  }elseif($checkCode['package_code'] == $package_code){
    $msg = 'Code: '.$package_code.' already exist on database.';
  }
  else{
    $insertSQL = array("package_code"=>$package_code,"package_name"=>$package_name, "package_desc"=>$package_desc,"package_type"=>$package_type,"menu_type"=>$menu_type,"service_type"=>$service_type,"no_person"=>$no_person,"suggest_amount"=>$suggest_amount,"suggest_total"=>$suggest_total,"per_head"=>$per_head,"total_price"=>$total_price);
    insertdata("packages",$insertSQL);
    header("location: packages.php");
  }
}
if(isset($_GET['package_id'])){
  $row = single_get("*","package_id","packages",$_GET['package_id']);
}
if(isset($_POST['save_button']) && isset($_GET['package_id'])){
  $package_code =$_POST['package_code'];
  $package_name =$_POST['package_name'];
  $package_desc =$_POST['package_desc'];
  $package_type =$_POST['package_type'];
  $menu_type = filter($_POST['menu_type']);
  $service_type = filter($_POST['service_type']);
  $no_person = filter($_POST['no_person']);
  $suggest_amount = filter($_POST['suggest_amount']);
  $suggest_total = filter($_POST['suggest_total']);
  $per_head = filter($_POST['per_head']);
  $total_price = filter($_POST['total_price']);
  
    $update = $dbcon->query("UPDATE packages SET package_code='$package_code', package_name='$package_name', package_desc='$package_desc',package_type='$package_type', service_type='$service_type',menu_type='$menu_type',no_person='$no_person',suggest_amount='$suggest_amount',per_head='$per_head',total_price='$total_price' WHERE package_id = '".$_GET['package_id']."'") or die(mysqli_error());
  header("location: packages.php");
}
$pcode = "PT-".rand(0,999)."";
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
                    <input type="text" name="package_code" class="form-control" placeholder="Code" required="required"
                    value="<?php if(isset($_GET['package_id'])): echo $row['package_code']; elseif(isset($_POST['save_button'])): echo $_POST['package_code']; else: echo $pcode; endif;?>">
                  </td>
                </tr>
                <tr>
                  <td>Name:</td>
                  <td>
                    <input type="text" name="package_name" class="form-control" placeholder="Name" required="required"
                    value="<?php if(isset($_GET['package_id'])): echo $row['package_name']; elseif(isset($_POST['save_button'])): echo $_POST['package_name']; endif;?>">
                  </td>
                </tr>
               
                <tr>
                  <td>Package Type:</td>
                  <td>
                    <select name="package_type" class="form-control">
                    <?php $list = getdata("*","package_type");?>
                    <?php foreach ($list as $key => $value):?>
                    <option value="<?php echo $value->pt_id?>"
                    <?php if(isset($_GET['package_id'])){
                      if($row['package_type'] == $value->pt_id){
                        echo 'selected';
                      }
                    }
                    elseif(isset($_POST['save_button'])){
                        echo $_POST['package_type'];
                      }
                      ?>><?php echo $value->pt_name?></option>
                  <?php endforeach;?>
            </select>
                  </td>
                </tr>
                <tr>
                  <td>Menu Type:</td>
                  <td>
                    <select name="menu_type" class="form-control">
                    <?php $list = getdata("*","menu");?>
                    <?php foreach ($list as $key => $value):?>
                    <option value="<?php echo $value->menu_id?>"
                    <?php if(isset($_GET['package_id'])){
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
                  <td>Service Type:</td>
                  <td>
                    <select name="service_type" class="form-control">
                    <?php $list = getdata("*","service_type");?>
                    <?php foreach ($list as $key => $value):?>
                    <option value="<?php echo $value->service_type?>"
                    <?php if(isset($_GET['package_id'])){
                      if($row['service_type'] == $value->service_type){
                        echo 'selected';
                      }
                    }
                    elseif(isset($_POST['save_button'])){
                        echo $_POST['service_type'];
                      }
                      ?>><?php echo $value->service_type?></option>
                  <?php endforeach;?>
            </select>
                  </td>
                </tr>
                <tr>
                  <td>Description:</td>
                  <td>
                    <input type="text" name="package_desc" class="form-control" placeholder="Package Description" required="required"
                    value="<?php if(isset($_GET['package_id'])): echo $row['package_desc']; elseif(isset($_POST['save_button'])): echo $_POST['package_desc']; endif;?>">
                  </td>
                </tr>
                <tr>
                  <td>Suggested per head amount:</td>
                  <td>
                    <input type="text" name="suggest_amount" class="form-control" readonly="readonly"
                    value="<?php if(isset($_GET['package_id'])): echo $row['suggest_amount']; else: echo "0"; endif;?>">
                  </td>
                </tr>
                <tr>
                  <td>Suggested total price:</td>
                  <td>
                    <input type="text" name="suggest_total" class="form-control" readonly="readonly"
                    value="<?php if(isset($_GET['package_id'])): echo $row['suggest_total']; else: echo "0"; endif;?>">
                  </td>
                </tr>
                <tr>
                  <td>No. of persons:</td>
                  <td>
                    <input type="text" name="no_person" id = "textone" class="form-control" required="required"
                    value="<?php if(isset($_GET['package_id'])): echo $row['no_person']; elseif(isset($_POST['save_button'])): echo $_POST['no_person']; endif;?>">
                  </td>
                </tr>
                <tr>
                  <td>Per Head Amount:</td>
                  <td>
                    <input type="text" name="per_head" id ="texttwo" class="form-control" required="required"
                    value="<?php if(isset($_GET['package_id'])): echo $row['per_head']; elseif(isset($_POST['save_button'])): echo $_POST['per_head']; endif;?>">
                  </td>
                </tr>
                <tr>
                  <td>Total Price:</td>
                  <td>
                    <input type="text" name="total_price" id="result" class="form-control" required="required"
                    value="<?php if(isset($_GET['package_id'])): echo $row['total_price']; elseif(isset($_POST['save_button'])): echo $_POST['total_price']; endif;?>">
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

<?php include'../assets/admin_footer.php';?>

<script>
    $('#texttwo').keyup(function(){
        var textone;
        var texttwo;
        textone = parseFloat($('#textone').val());
        texttwo = parseFloat($('#texttwo').val());
        var result = textone * texttwo;
        $('#result').val(result.toFixed(2));


    });
</script>
</body>
</html>
