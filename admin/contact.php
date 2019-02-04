<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_admin'])){
  header("Location: ../index.php");
  exit;
}

$row = single_query("*","contact_us");

if(isset($_POST['save_button'])){
  $contact_address = filter($_POST['contact_address']);
  $contact_mobile = filter($_POST['contact_mobile']);
  $contact_tel = filter($_POST['contact_tel']);
  
  $update = $dbcon->query("UPDATE contact_us SET contact_address='$contact_address',contact_mobile='$contact_mobile',contact_tel='$contact_tel'") or die(mysqli_error());
  //$msg = '<div class="alert alert-success">You have successfully updated the data.</div>';
  header("location: contact.php");
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
              <h4 class="box-title"><i class="fa fa-plus"></i> Contact Us  </h4>
            </div>
<?php if(isset($msg)):?><div class="alert alert-danger"><?php echo $msg;?></div><?php endif;?>
            <form method="post">
            <table class="table table-responsive table-bordered">
                
                <tr>
                  <td>Address:</td>
                  <td>
                    <input type="text" name="contact_address" class="form-control" placeholder="Location" required="required"
                    value="<?php echo $row['contact_address']; ?>">
                  </td>
                </tr>
                <tr>
                  <td>Mobile Number:</td>
                  <td>
                    <input type="text" name="contact_mobile" class="form-control" placeholder="Location" required="required"
                    value="<?php echo $row['contact_mobile']; ?>"> 
                
                  </td>
                </tr>
                 <tr>
                  <td>Telephone Number:</td>
                  <td>
                     <input type="text" name="contact_tel" class="form-control" placeholder="Location" required="required" value="<?php echo $row['contact_tel']; ?>">
                
                  </td>
                </tr>
                <tr>
                  <td></td>
                  <td>
                    <button class="btn btn-primary" name="save_button"><i class="fa fa-save"></i> Save</button>
                    <a href="index.php" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to list</a>
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
