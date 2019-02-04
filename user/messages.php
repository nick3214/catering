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
  $update = $dbcon->query("UPDATE message SET msg_status = '1' WHERE msg_id = '".$_GET['msg_id']."'") or die(mysqli_error());
  header("location: messages.php");
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
        
       <div class="box box-info" style="width:95.5%;">
            <div class="box-header">
              
            <div class="row">
        <div class="col-md-3">
          <a href="compose.php" class="btn btn-primary btn-block mb-3">Compose</a>

          <div class="card" style="border:1px #e9ecef solid;padding:10px; border-radius:3px;margin-top:5px;">
            <div class="card-header" >

              
            </div>
            <ul style="list-style: none; padding:5px;line-height: 10px;font-size: 18px;">
              <li >
                <a href="messages.php" class="nav-link">
                    <i class="fa fa-inbox"></i> Inbox
                    <span class="badge bg-primary float-right"><?php echo $count['total']?></span>
                  </a>
                  <hr>
              </li>
              <li>
                 <a href="sent.php" class="nav-link">
                    <i class="fa fa-envelope-o"></i> Sent
                  </a>
                  <hr>
              </li>
              <li>
                <a href="trash.php" class="nav-link">
                    <i class="fa fa-trash-o"></i> Trash
                  </a>
                  <hr>
              </li>
            </ul>
            
            <!-- /.card-body -->
          </div>

        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Inbox</h3>
              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="mailbox-controls">

                <!-- /.float-right -->
              </div>
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
    $sql = $dbcon->query("SELECT * FROM message WHERE msg_from = '".$_SESSION['user_id']."' AND msg_status = '0' OR msg_to = '".$_SESSION['user_id']."'") or die(mysqli_error());
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
    <td><a href="reply.php?msg_id=<?php echo $row['msg_id']?>&msg_from=<?php echo $from['user_id']?>"><?php echo $to['full_name']?></a></td>
    <td><?php echo $row['msg_title']; ?></td>
    <td><?php echo $row['msg_date']; ?></td>
    <td>
      <a href="messages.php?msg_id=<?php echo $row['msg_id']?>"><i class="fa fa-remove"></i> </a>
    </td>
  </tr>
  <?php endwhile;?>
  </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.card-body -->

          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
          </div>
          
       </div>
          <hr>
          
       </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php include'../assets/user_footer.php';?>