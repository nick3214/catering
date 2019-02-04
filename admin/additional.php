<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_admin'])){
  header("Location: ../index.php");
  exit;
}
if(isset($_GET['delete'])){
  $delete = filter($_GET['delete']);
    $ar = array("paluto_id"=>$delete);
    $tbl_name = "paluto_menu";
    $del = delete($dbcon,$tbl_name,$ar);
    if($del){
      header("location: paluto_menu.php");
    }
}
?>
<?php include'../assets/admin_header.php';?>
<?php include'../assets/admin_sidebar.php';?>
<style>
    table tr td{
        text-align:center;
    }

    input[type='text'],input[type='number']{
        text-align:center;
    }
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="modal fade" id="new" role="document">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">New Offer</div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                    <input type="hidden" value="<?php echo $row['id'];?>" id="update_id">
                        <span>Name</span>
                        <input type="text" class="form-control" id="name">
                        <span id="emptyname" style="color:Red;font-size:8pt"></span>
                    </div>
                    <div class="col-md-6">
                        <span>Price</span>
                        <input type="number" min="0" class="form-control" id="price">
                        <span id="emptyupdate" style="color:Red;font-size:8pt"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" value="Save" id="save" class="btn btn-primary">
                <input type="submit" value="Cancel" data-dismiss="modal"  class="btn btn-danger">
            </div>
        </div>
    </div>
  </div>

  <div class="modal fade" id="update" role="document">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">Update Offer</div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                    <input type="hidden" id="id">
                        <span>Name</span>
                        <input type="text" class="form-control" id="update_name" readonly>
                        <span id="emptyname" style="color:Red;font-size:8pt"></span>
                    </div>
                    <div class="col-md-6">
                        <span>Price</span>
                        <input type="number" min="0" class="form-control" id="show_price">
                        <span id="emptyupdateprice" style="color:Red;font-size:8pt"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" value="Save" id="update_offer" class="btn btn-primary">
                <input type="submit" value="Cancel" data-dismiss="modal"  class="btn btn-danger">
            </div>
        </div>
    </div>
  </div>
  <div class="content-wrapper">
    <section class="content">
      <div class="row">
       <div class="container">
        
        <div class="box box-info" style="width:95.5%;">
            <div class="box-header">
              

              <h4 class="box-title"><i class="fa fa-list"></i> Additional - </h4> <a href="#" data-toggle="modal" data-target="#new"><i class="fa fa-plus"></i> Create New</a><br>
            </div>
            <div class="box-body">
              <div class="box">
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Name</th>
                  <th>Price</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
          <?php 
          $sql = $dbcon->query("SELECT * FROM additional_choice") or die(mysqli_error());
          
          ?>

          <?php while($row = $sql->fetch_assoc()):?>
                <tr>
                  <td><?php echo $row['name']?></td>
                  <td><?php echo $row['price']; ?></td>
                  <td>
                  <div class="btn-group">
                    
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                      <li><a href="#"  id="edit" name="<?php echo $row['id'];?>" data-target="#update" data-toggle="modal">Edit</a></li>
                      <li><a href="#"  id="remove" name="<?php echo $row['id'];?>">Delete</a></li>
                    </ul>
                  </div>
                  </td>
                </tr>
          <?php endwhile;?> 
                      
              </table>
            </div>
            <!-- /.box-body -->
          </div>
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
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
<script>
$(document).ready(function(){
    $("table tr td #remove").click(function(){
        var action = "remove";
        var id = $(this).attr("name");
        var price = "";
        var name = "";
        var data = "action="+action+"&id="+id+"&price="+price+"&name="+name;
        if(confirm("Are you sure you want to remove this item?")){
        $.ajax({
               url:"add-offer.php",
               method:"post",
               data:data,
               success:function(data){
                   if(data == "success"){
                       alert("Remove Successfully");
                       location.reload();
                   }else{
                       console.log(data);
                       $("#emptyname").text("Name Already Exist!");
                   }
               }
           })
        }
    })
    $("#save").click(function(){
        var action = "add";
        var name = $("#name").val();
        var id = 0;
        var price = $("#price").val();
        var data = "name="+name+"&price="+price+"&action="+action+"&id="+id;
        if(name == ""){
            $("#emptyname").text("Required Field");
        }else{
            $("#emptyname").text("");
        }
        if(price == ""){
            $("#emptyprice").text("Required Field");
        }else{
            $("#emptyprice").text("");
        }

        if(name != "" && price != ""){
           $.ajax({
               url:"add-offer.php",
               method:"post",
               data:data,
               success:function(data){
                   if(data == "success"){
                       alert("New offer Added");
                       location.reload();
                   }else{
                       console.log(data);
                       $("#emptyname").text("Name Already Exist!");
                   }
               }
           })
        }
    })
    $("table tr td #edit").click(function(){
        var action = "edit";
        var id = $(this).attr("name");
        var price = "";
        var name = "";
        var data = "action="+action+"&id="+id+"&price="+price+"&name="+name;
        
        $.ajax({
               url:"add-offer.php",
               method:"post",
               data:data,
               dataType:"JSON",
               success:function(data){
                $("#id").val(data.id);
                $("#update_name").val(data.name);
                $("#show_price").val(data.price);
               }
           })
        
    })
    $("#update_offer").click(function(){
        var action = "update";
        var name = "";
        var id = $("#id").val();
        var price = $("#show_price").val();
        var data = "name="+name+"&price="+price+"&action="+action+"&id="+id;
       
        if(price == ""){
            $("#emptyupdateprice").text("Required Field");
        }else{
            $("#emptyupdateprice").text("");
        }

        if(price != ""){
           $.ajax({
               url:"add-offer.php",
               method:"post",
               data:data,
               success:function(data){
                   if(data == "success"){
                       alert("Update Successfully");
                       location.reload();
                   }else{
                       console.log(data);
                       $("#emptyname").text("Name Already Exist!");
                   }
               }
           })
        }
    });
})
</script>
</body>
</html>
