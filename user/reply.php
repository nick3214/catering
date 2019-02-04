<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_user'])){
  header("Location: ../index.php");
  exit;
}
if(isset($_POST['send_btn'])){
  $msg_from = filter($_SESSION['user_id']);
  $msg_id = filter($_GET['msg_id']);
  $reply_content = $_POST['reply_content'];

  $data = array(
    "reply_from"      =>$msg_from,
    "msg_id"        =>$msg_id,
    "reply_content" =>$reply_content
  );
  insertdata("reply",$data);
  header("location: messages.php");
}
$msg = single_get("*","msg_id","message",$_GET['msg_id']);
$from = single_get("*","user_id","user_account",$msg['msg_from']);
$to = single_get("*","user_id","user_account",$msg['msg_to']);
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
        
 <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Reply Message</h3>
              <hr>
              <table class="table table-striped">
                <tr>
                  <td>From:</td>
                  <td><?php echo $from['full_name']?></td>
                </tr>
                <tr>
                  <td>To:</td>
                  <td><?php echo $to['full_name']?></td>
                </tr>
                <tr>
                  <td>Message:</td>
                  <td><?php echo $msg['msg_content']?></td>
                </tr>
              </table>
              <strong>Reply:</strong><hr>
              <?php 
              $query = "SELECT * FROM reply WHERE msg_id = '".$_GET['msg_id']."'";
              $reply = getdata_inner_join($query);
              ?>
              <?php 
              if(!empty($reply)):
              ?>
              <?php 
              foreach ($reply as $key => $value):
                $from = single_get("*","user_id","user_account",$value->reply_from);
              ?>
                <div style="border:1px solid #f4f6f9; background:white;">
                 <strong><?php echo $from['full_name']?></strong> - <?php echo $value->reply_date?><br>
                  <?php echo $value->reply_content?>
                </div>
                <br>
              <?php endforeach;?>

              <?php else:?>
                <div class="alert alert-danger">No Records on database.</div>
              <?php endif;?>
              <form method="post">
                <textarea class="form-control" name="reply_content" placeholder="Enter reply here."></textarea>
                <br>
                 <button class="btn btn-primary" name="send_btn"><i class="fa fa-send"></i> Send</button>
                  <a href="messages.php" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
              </form>
              <!-- /.card-tools -->
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