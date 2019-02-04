<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_admin'])){
  header("Location: ../index.php");
  exit;
}
$adults = single_get("*","person_id","per_person","1");
$kids = single_get("*","person_id","per_person","2");
if(isset($_POST['save_button'])){
  $update = $dbcon->query("UPDATE per_person SET person_price='".$_POST['adults']."' WHERE person_id = '1'") or die(mysqli_error());
  $update = $dbcon->query("UPDATE per_person SET person_price='".$_POST['kids']."' WHERE person_id = '2'") or die(mysqli_error());
  header("location: person.php");
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
              
              <h4 class="box-title"><i class="fa fa-plus"></i> Customer Price Per head</h4><br><br> 
              
            </div>
            <div class="box-body">
              <div class="box">
            <div class="box-body">
              <form method="post">
                <h4>Adults:</h4>
                <input type="text" name="adults" min="1" class="form-control" value="<?php echo $adults['person_price']?>">
                <h4>Kids:</h4>
                <input type="text" name="kids" min="1" class="form-control" value="<?php echo $kids['person_price']?>">
                <br>
                <button class="btn btn-primary" name="save_button"><i class="fa fa-save"></i> Save</button> <a href="index.php" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a>
              </form>
            <!-- /.box-body -->
          </div>
            </div>
            
          </div>
          
       </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
<?php include'../assets/admin_footer.php';?>
</body>
</html>
