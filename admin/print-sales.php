<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_admin'])){
  header("Location: ../index.php");
  exit;
}
?>
<?php include'../assets/admin_header.php';?>
<?php include'../assets/admin_sidebar.php';?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
    <!-- Main content -->
    <section class="content">
      <div class="row">
       <div class="container">
        
        <div class="box box-info" style="width:95.5%;">
            <div class="box-header">
              <h4 class="box-title"><i class="fa fa-calendar"></i> Sales Report</h4>
              <hr>
<form method="post">
  <select class="form-control" name="choice_type">
    <option value="0">Monthly Report</option>
    <option value="1">Weekly Report</option>
  </select><br>
  <button class="btn btn-danger" name="sel_btn"><i class="fa fa-search"></i></button>
</form>
<hr>
<?php if(isset($_POST['sel_btn']) && $_POST['choice_type'] == '0'):?>
  <form method="get" target="_blank" action="sale-month.php">
  <select class="form-control" name="month">
              <option>January</option>
              <option>February</option>
              <option>March</option>
              <option>April</option>
              <option>May</option>
              <option>June</option>
              <option>July</option>
              <option>August</option>
              <option>September</option>
              <option>October</option>
              <option>November</option>
              <option>December</option>
            </select>
            <br>
            <select class="form-control" name="year">
              <option>2017</option>
              <option>2018</option>
              <option>2019</option>
              <option>2020</option>
              <option>2021</option>
              <option>2022</option>
              <option>2023</option>
              <option>2024</option>
            </select>
            <br>
            <button class="btn btn-primary" name="select_btn"><i class="fa fa-search"></i> Generate Report</button>
</form>
<?php elseif(isset($_POST['sel_btn']) && $_POST['choice_type'] == '1'):?>
  <form method="get" target="_blank" action="preview-sales.php">
  FROM:<br><input type="date" name="from_date" class="form-control" required>UNTIL:<br>
  <input type="date" name="until_date" class="form-control" required><br>
  <button class="btn btn-primary" name="search_btn"><i class="fa fa-search"></i> Search</button>
</form>
<?php endif;?>

            </div>
            <div class="box-body">
               
            </div>
            
          </div>

       </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php include'../assets/admin_footer.php';?>
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable()
  })
</script>
<script language="javascript" type="text/javascript">
    function popitup(url) 
    {
      newwindow=window.open(url,'name','height=500,width=1200');
      if (window.focus) {newwindow.focus()}
      return false;
    }
    </script>
</body>
</html>
