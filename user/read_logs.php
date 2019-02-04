<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_user'])){
  header("Location: ../index.php");
  exit;
}
$log = single_get("*","n_id","notifications",$_GET['n_id']);
if(isset($_GET['n_id'])){
  $updateLogs = $dbcon->query("UPDATE notifications SET read_logs = '1' WHERE n_id = '".$_GET['n_id']."'") or die(mysqli_error());
  //header("location: read_logs.php?n_id=".$_GET['n_id']."");
}
?>

<?php include'../assets/user_header.php';?>
  <!-- Content Wrapper. Contains page content -->
  <div style="height:20px;"></div>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="width:87%; margin: 0 auto;background: white;border-radius:3px;">
    <!-- Main content -->
    <section class="content">


      <div class="row">
       <div class="container">
        
        <div class="box box-info" style="width:97%;">
            <div class="box-header">
              <h4 class="box-title"><i class="fa fa-globe"></i> Notifications</h4>
              <hr>
<blockquote>
<h4><?php echo $log['n_logs']?></h4>
<small><?php echo $log['n_date']?></small>
</blockquote>
<a href="index.php" class="btn btn-default">Back</a>
            </div>
            <div class="box-body">


            </div>
            
          </div>
          <hr>
          
       </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
<?php include'../assets/admin_footer.php';?>

</body>
</html>

