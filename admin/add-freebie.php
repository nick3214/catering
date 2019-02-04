<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_admin'])){
  header("Location: ../index.php");
  exit;
}
if(isset($_POST['save_button']) AND !isset($_GET['f_id'])){
  $freebie_name =$_POST['freebie_name'];
  $f_price = filter($_POST['f_price']);
  $freebie_type = filter($_POST['freebie_type']);
  $user = $_SESSION['user_email'];
  $date = date("Y-m-d h:i:s"); 
  $checkName = single_get("*","freebie_name","freebies",$freebie_name);
  if($checkName['freebie_name'] == $freebie_name){
    $msg = 'Name: '.$freebie_name.' already exist on database.';
  }
  else{
    $insertSQL = array("freebie_name"=>$freebie_name,"f_price"=>$f_price,"last_modified"=>$user, "date_modified"=>$date,"freebie_type" => $freebie_type);
    insertdata("freebies",$insertSQL);
    header("location: freebies.php");
  }
}
if(isset($_GET['f_id'])){
  $row = single_get("*","f_id","freebies",$_GET['f_id']);
}
if(isset($_POST['save_button']) && isset($_GET['f_id'])){
  $freebie_name =$_POST['freebie_name'];
  $freebie_type = filter($_POST['freebie_type']);
  $f_price = filter($_POST['f_price']);
  $user = $_SESSION['user_email'];
  $date = date("Y-m-d h:i:s");

  $update = $dbcon->query("UPDATE freebies SET freebie_name='$freebie_name',f_price='$f_price',
    date_modified='$date', last_modified='$user', freebie_type='$freebie_type' WHERE f_id = '".$_GET['f_id']."'") or die(mysqli_error());
  header("location: freebies.php");
}
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
              <h4 class="box-title"><i class="fa fa-plus"></i> Add Products  </h4>
            </div>
<?php if(isset($msg)):?><div class="alert alert-danger"><?php echo $msg;?></div><?php endif;?>
            <form method="post">
            <table class="table table-responsive table-bordered">
                <tr>
                  <td>Name:</td>
                  <td>
                    <input type="text" name="freebie_name" class="form-control" placeholder="Name" required="required"
                    value="<?php if(isset($_GET['f_id'])): echo $row['freebie_name']; elseif(isset($_POST['save_button'])): echo $_POST['freebie_name']; endif;?>">
                  </td>
                </tr>
                <tr>
                  <td>Price:</td>
                  <td>
                    <input type="text" name="f_price" min="1" class="form-control" placeholder="Price" required="required" value="0.00" readonly>
                  </td>
                </tr>
                 <tr>
                  <td>Freebie Type:</td>
                  <td>
                    <select name="freebie_type" class="form-control">
                    <option value="0"
                    <?php if(isset($_GET['f_id'])){
                      if($row['freebie_type'] == '0'){
                        echo 'selected';
                      }
                    }
                    elseif(isset($_POST['save_button'])){
                        echo $_POST['freebie_type'];
                      }
                      ?>>New Customer</option>
                      <option value="1"
                    <?php if(isset($_GET['f_id'])){
                      if($row['freebie_type'] == '1'){
                        echo 'selected';
                      }
                    }
                    elseif(isset($_POST['save_button'])){
                        echo $_POST['freebie_type'];
                      }
                      ?>>Existing Customer</option>
                  
            </select>
                  </td>
                </tr>
                <tr>
                  <td></td>
                  <td>
                    <button class="btn btn-primary" name="save_button"><i class="fa fa-save"></i> Save</button>
                    <a href="freebies.php" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to list</a>
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

</body>
</html>
