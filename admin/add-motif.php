<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_admin'])){
  header("Location: ../index.php");
  exit;
}
if(isset($_POST['save_button']) AND !isset($_GET['id'])){
  $motif =$_POST['motif'];
  $motif_decs =$_POST['motif_decs'];
  $occasion_id = $_POST['occasion_id'];
  $motif_type = $_POST['motif_type'];
  $user = $_SESSION['user_email'];
  $date = date("Y-m-d h:i:s"); 
  $checkName = single_get("*","motif","motif",$motif);
  if($checkName['motif'] == $motif){
    $msg = 'Name: '.$motif.' already exist on database.';
  }
  else{
    $insertSQL = array("motif_type"=>$motif_type,"motif"=>$motif,"last_modified"=>$user, "date_modified"=>$date,"occasion_id"=>$occasion_id,"motif_decs"=>$motif_decs);
    insertdata("motif",$insertSQL);
    header("location: motif.php");
  }
}
if(isset($_GET['id'])){
  $row = single_get("*","id","motif",$_GET['id']);
}
if(isset($_POST['save_button']) && isset($_GET['id'])){
  $motif =$_POST['motif'];
   $motif_decs =$_POST['motif_decs'];
  $occasion_id = $_POST['occasion_id'];
  $motif_type = $_POST['motif_type'];
  $user = $_SESSION['user_email'];
  $date = date("Y-m-d h:i:s");
  $update = $dbcon->query("UPDATE motif SET motif='$motif',motif_type='$motif_type',
    date_modified='$date', last_modified='$user', occasion_id = '$occasion_id',motif_decs = '$motif_decs' WHERE id = '".$_GET['id']."'") or die(mysqli_error());
  header("location: motif.php");
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
              <h4 class="box-title"><i class="fa fa-plus"></i> Add Motif  </h4>
            </div>
<?php if(isset($msg)):?><div class="alert alert-danger"><?php echo $msg;?></div><?php endif;?>
            <form method="post">
            <table class="table table-responsive table-bordered">
                <tr>
                  <td>Name:</td>
                  <td>
                    <input type="text" name="motif" class="form-control" placeholder="Name" required="required"
                    value="<?php if(isset($_GET['id'])): echo $row['motif']; elseif(isset($_POST['save_button'])): echo $_POST['motif']; endif;?>">
                  </td>
                </tr>
                 <tr>
                  <td>Description:</td>
                  <td>
                    <input type="text" name="motif_decs" class="form-control" placeholder="Description" required="required"
                    value="<?php if(isset($_GET['id'])): echo $row['motif_decs']; elseif(isset($_POST['save_button'])): echo $_POST['motif_decs']; endif;?>">
                  </td>
                </tr>
                <tr>
                  <td>Paluto Type:</td>
                  <td>
                    <select name="occasion_id" style="width:92%; height:40px;">
                    <?php $list = getdata("*","occasion");?>
                    <?php foreach ($list as $key => $value):?>
                    <option value="<?php echo $value->occasion_id?>"
                    <?php if(isset($_GET['id'])){
                      if($row['occasion_id'] == $value->occasion_id){
                        echo 'selected';
                      }
                    }
                    elseif(isset($_POST['save_button'])){
                        echo $_POST['occasion_id'];
                      }
                      ?>><?php echo $value->occasion_name?></option>
                  <?php endforeach;?>
            </select>
                  </td>
                </tr>
               <tr>
                      <td>Motif Type:</td>
                      <td>
                        <select class="form-control" name="motif_type">
                          <option value="0"
                          <?php 
                          if(isset($_GET['id'])){
                          if($row['motif_type'] == 0){
                            echo "selected";
                          }
                          }
                          ?>
                          >Color</option>
                          <option value="1"
                          <?php 
                             if(isset($_GET['id'])){
                          if($row['motif_type'] == 1){
                            echo "selected";
                          }
                        }
                          ?>
                          >Special</option>
                        </select>
                      </td>
               </tr>
                <tr>
                  <td></td>
                  <td>
                    <button class="btn btn-primary" name="save_button"><i class="fa fa-save"></i> Save</button>
                    <a href="motif.php" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to list</a>
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
