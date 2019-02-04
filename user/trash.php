<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_user'])){
  header("Location: ../index.php");
  exit;
}
$count = count_msg("COUNT(*) as total","msg_from","message",$_SESSION['user_id']);
if(isset($_GET['msg_id'])){
  $update = $dbcon->query("UPDATE message SET msg_status = '0' WHERE msg_id = '".$_GET['msg_id']."'") or die(mysqli_error());
  header("location: trash.php");
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
             <div class="table-responsive mailbox-messages">
    <table id="example1" class="table table-bordered table-striped" style="font-size:12px;">
    <thead>
      <tr>
          <th>From</th>
          <th>To</th>
          <th>Title</th>
          <th>Date created</th>
          <th>Option</th>
      </tr>
                </thead>
    <tbody>            
    <?php 
    $sql = $dbcon->query("SELECT * FROM message WHERE msg_from = '".$_SESSION['user_id']."' AND msg_status = '1' ORDER BY msg_id ASC") or die(mysqli_error());
    ?>
    <?php 
    while($row = $sql->fetch_assoc()):
      $from = single_get("*","user_id","user_account",$row['msg_from']);
      $to = single_get("*","user_id","user_account",$row['msg_to']);
    ?>
  <tr>
    <td>
      <?php echo $from['full_name']?>
    </td>
    <td><?php echo $to['full_name']?></td>
    <td><?php echo $row['msg_title']; ?></td>
    <td><?php echo $row['msg_date']; ?></td>
    <td>
      <a href="trash.php?msg_id=<?php echo $row['msg_id']?>">Restore Message </a>
    </td>
  </tr>
  <?php endwhile;?>
  </table>
                <!-- /.table -->
              </div>
          <hr>
          
       </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php include'../assets/user_footer.php';?>