<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_user'])){
  header("Location: ../index.php");
  exit;
}
if(isset($_POST['send_btn'])){
  $msg_to = filter($_POST['msg_to']);
  $msg_from = filter($_SESSION['user_id']);
  $msg_title = filter($_POST['msg_title']);
  $msg_content = $_POST['msg_content'];

  $data = array(
    "msg_to"      =>$msg_to,
    "msg_from"    =>$msg_from,
    "msg_content" =>$msg_content,
    "msg_title"   =>$msg_title
  );
  insertdata("message",$data);
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
        
<div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Compose Message</h3>
              <hr>
              <form method="post">
                  <select class="form-control" name="msg_to">
                    <?php 
                    $query = 'SELECT * FROM user_account WHERE user_id != "'.$_SESSION['user_id'].'" AND user_role ="0"';
                    $user = getdata_inner_join($query);
                    ?>
                    <?php if(!empty($user)):?>
                      <?php foreach ($user as $key => $value):?>
                        <option value="<?php echo $value->user_id?>">
                          <?php echo $value->full_name?>
                          <?php if($value->user_role == '0'):?>
                            -Administrator
                          <?php else:?>
                            -Customer
                          <?php endif;?>
                          </option>
                      <?php endforeach;?>
                    <?php else:?>
                      <option>No Records</option>
                    <?php endif;?>
                  </select><br>
                  <input type="text" name="msg_title" class="form-control" required placeholder="Enter Title">
                  <br>
                  <textarea class="form-control" placeholder="Place your message here" name="msg_content" required="required"></textarea>
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