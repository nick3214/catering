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
              <h4 class="box-title"><i class="fa fa-list"></i> Freebies</h4>
              <hr>
<form method="get" target="_blank" action="preview-product.php">
  <button class="btn btn-primary" name="search_btn"><i class="fa fa-search"></i> Search</button>
</form>
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
