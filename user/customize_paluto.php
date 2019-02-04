<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
if(empty($_SESSION['login_user'])){
  header("Location: ../index.php");
  exit;
}
$user = single_get("*","user_id","user_account",$_SESSION['user_id']);
?>
<?php include'../assets/user_header.php';?>
<style>
#example1_length,#example1_filter{
  display:none;
}
input[type='number']{
  text-align:center;
}
table tr td {
  text-align:center;
}
</style>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/themes/base/jquery-ui.css" rel="stylesheet" />
<script class="jsbin" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
<div class="modal fade" id="update_order" role="document">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">Update Quantitty of <span id="name"></span></div>
      <div class="modal-body">
        <div class="row">
          <input type="hidden"  id="id">
          <input type="hidden"  id="price">
          <div class="col-md-6">
            <span>Previous Pax</span>
            <input type="number" class="form-control" id="pax" readonly >
          </div>
          <div class="col-md-6">
            <span>Update Pax
            <input type="number" min="0"  id="quantity" class="form-control" id="new_quantity">
            <span id="emptyquantity" style="color:Red;font-size:8pt"></span>
          </div>
        </div>
      </div>
      <div class="modal-footer" id="footer">
        <input type="submit" value="Save" class=" btn btn-primary" id="change">
        <input type="submit"  value="Cancel" class=" btn btn-danger" data-dismiss="modal">
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="additional" role="document">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">Additional</div>
      <div class="modal-body">
        <div class="row">
        <table class="table table-bordered">
              <tr>
                <th>Offer</th>
                <th>Price</th>
                <th>Action</th>
              </tr>
              <tbody>
          <?php 
            $show_additional = $dbcon->query("select * from additional_choice");
            while($row = $show_additional->fetch_assoc()):
          ?>
                <tr>
                  <td><?php echo $row['name'];?></td>
                  <td><?php echo $row['price'];?></td>
                  <td> 
                  <input type="text" name="qty" id="qty-<?php echo $row['id'];?>" size="2" >&nbsp;
                    <span id="add" 
                    target="<?php echo $row['id'];?>" 
                    name="<?php echo $row['name']?>" 
                    class="<?php echo $row['price']?>" style="cursor:pointer" >
                    <i style="color:red" class="fa fa-plus"></i></span><br>
                  <span id="empty-<?php echo $row['id'];?>" style="color:Red;font-size:8pt"></span>
                  </td>
          <?php endwhile;?>
          
              </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer" id="footer">
        <input type="submit"  value="Close" class=" btn btn-danger" data-dismiss="modal">
      </div>
    </div>
  </div>
</div>
  <div style="height:20px;"></div>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="padding:20px;width:87%; margin: 0 auto;background: white;border-radius:3px;">

  <div class="row">
    <div class="col-md-7">
      <h4><i class="fa fa-plus"></i> Pack Meal</h4><hr>
      <div class="col-md-10">
    <form method="get">
       <select class="form-control" name="search_field" id="search">
       <?php 
       if(isset($_GET['search_btn'])){
          if($_GET['search_field'] == 1){
            ?>
              <option value="2">All</option>
              <option value="0">Breakfast</option> 
              <option value="1" selected>Dinner / Lunch</option>
            <?php
          }else if($_GET['search_field'] == 0){
            ?>
              <option value="2">All</option>
              <option value="0" selected>Breakfast</option> 
              <option value="1">Dinner / Lunch</option>
            <?php
          }else{
            ?>
              <option value="2" selected>All</option>
              <option value="0" >Breakfast</option> 
              <option value="1">Dinner / Lunch</option>
            <?php
          }
       }else{ ?>
        <option value="2">All</option>
        <option value="0">Breakfast</option> 
        <option value="1">Dinner / Lunch</option>
       <?php } ?>
      
       </select>
  <p></p>
  <button class="btn btn-primary"  id="btn" style="display:none" name="search_btn"><i class="fa fa-search"></i> Search</button>
  </form>
  </div>
  <div class="col-md-2">
   <a href="#" class="btn btn-primary" data-target="#additional" data-toggle="modal"><i class="fa fa-plus"></i>Additional</a>
  </div>
  <div class="col-md-12">
<span style="color:red">* Note: Minimum of 10 pax per item</span>
</div>
<hr><br>
<table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Photo</th>
                  <th>Name</th>
                  
                  <th>Price</th>
                  <th>Type</th>
                  <th>Action</th>
                  
                </tr>
                </thead>
                <tbody>
          <?php 
           if(isset($_GET['search_btn'])){
            if($_GET['search_field'] == 1 || $_GET['search_field'] == 0){
              $sql = "SELECT *,food_items.itm_image as IMG FROM food_items 
              INNER JOIN food_categories on food_categories.f_id = food_items.item_category
              INNER JOIN sub_category on sub_category.sub_id = food_items.sub_category
              WHERE food_items.menu_type ='".$_GET['search_field']."'";
            
            }else{
              $sql = "SELECT *,food_items.itm_image as IMG FROM food_items 
              INNER JOIN food_categories on food_categories.f_id = food_items.item_category
              INNER JOIN sub_category on sub_category.sub_id = food_items.sub_category";
            }
           }else{
            $sql = "SELECT *,food_items.itm_image as IMG FROM food_items 
            INNER JOIN food_categories on food_categories.f_id = food_items.item_category
            INNER JOIN sub_category on sub_category.sub_id = food_items.sub_category
            where food_items.menu_type = 0
            ";
           }
          $sql = $dbcon->query($sql) or die(mysqli_error());
          ?>

          <?php while($row = $sql->fetch_assoc()):?>
                <tr>
                  <td>
                    <img src="../images/<?php echo $row['IMG']?>" class="img-thumbnail" width="100">
                  </td>
                  <td><?php echo $row['item_name']?></td>
                  <td>&#8369; <?php echo $row['cost_per_head']?></td>
                  <td><?php 
                  if($row['menu_type'] == 0){
                    echo "Breakfast";
                  }else{
                    echo "Lunch / Dinner";
                  }?></td>
                  <td>
             
                    
                  <input type="text" name="qty" id="qty-<?php echo $row['item_id'];?>" size="2">&nbsp;
                    <span id="add" 
                    target="<?php echo $row['item_id'];?>" 
                    name="<?php echo $row['item_name']?>" 
                    class="<?php echo $row['cost_per_head']?>" style="cursor:pointer" >
                    <i style="color:red" class="fa fa-plus"></i></span>
                  <span id="empty-<?php echo $row['item_id'];?>" style="color:Red;font-size:8pt"></span>
                  </td>
                </tr>
          <?php endwhile;?> 
                      
              </table>
       
    </div>
    <div class="col-md-5">
      <h4><i class="fa fa-shopping-cart"></i> Pack Meal Cart</h4><hr>
      <table id="example3" class="table table-bordered">
                <thead>
                <tr>
                  <th>Name</th>
                  <th>Quantity</th>
                  <th>Price</th>
                  <th>Total Price</th>
                  <th>Edit</th>
                </tr>
                </thead>
                <tbody>
          <?php 
          $sql = $dbcon->query("SELECT * FROM paluto_reservation_package WHERE paluto_name = '".$user['user_email']."'&& paluto_status=1 && paluto_method = 'pack'") or die(mysqli_error());
          ?>

          <?php while($row = $sql->fetch_assoc()):?>
                <tr>
                  <td style="width:100px"><?php echo $row['paluto_item_name']?></td>
                  <td><?php echo $row['paluto_pax']?></td>
                  <td>&#8369; <?php echo $row['paluto_price']?></td>
                  <th><?php echo $row['paluto_total_price'];?></td>
                  <td>
                  <a href="#" data-toggle="modal" id="up" name="<?php echo $row['paluto_id'];?>" data-target="#update_order"><i class="fa fa-edit"></i> </a>
                  <a href="#" id="remove" class="<?php echo $row['paluto_item_name'];?>" name="<?php echo $row['paluto_id'];?>"><i class="fa fa-remove"></i> </a>
                  </td>
                </tr>
          <?php endwhile; ?>
              </tbody>
            
              </table>
              <input type="submit" value="Remove All" id="remove_all" class="pull-right btn btn-danger">
  <hr>
  <?php 
    $total = $dbcon->query("select sum(paluto_total_price) as total_price from paluto_reservation_package WHERE paluto_name = '".$user['user_email']."'&& paluto_status=1 && paluto_method='pack'");
    $total_price = $total->fetch_object();
  ?>
  <h4><i class="fa fa-user"></i> Information</h4>
  <hr>
  <div class="row">
    <div class="col-md-3"><strong>Full Name:</strong></div>
    <div class="col-md-9"><?php echo $user['full_name']?></div>
    <input type="hidden" value="<?php echo $user['user_email']?>" id="user">
  </div>
  <p></p>
  <div class="row">
    <div class="col-md-3"><strong>Contact #:</strong></div>
    <div class="col-md-9"><?php echo $user['contact_num']?></div>
  </div>
  <p></p>
  <div class="row">
    <div class="col-md-3"><strong>Email:</strong></div>
    <div class="col-md-9"><?php echo $user['user_email']?></div>
  </div>
  <p></p>
  <div class="row">
    <div class="col-md-4"><strong>Date Reserve:</strong></div>
    <div class="col-md-8"><input type="text"readonly  id="datepicker" >
    <span id="emptydate" style="color:Red;font-size:8pt"></span>
    </div>
  </div>
  <p></p>
  <div class="row">
    <div class="col-md-3"><strong>Delivery:</strong></div>
    <div class="col-md-9">
      
      <input type="radio" name="delivery" checked target ="pickup" id="deliver">Pick Up<br>
      <input type="radio" name="delivery" target="deliver" id="deliver">Delivery
      <input type="text" name="delivery_address" style="display:none" id="del" placeholder="Delivery Address" class="form-control" >
      <span id="emptydeliver" style="color:Red;font-size:8pt"></span>
                 
    </div>
  </div>
  <br>
  <h4><i class="fa fa-file"></i> Payment Summary</h4>
  <hr>
  <div class="row">
    <div class="col-md-8"><h4>Food Price:</h4></div>
    <div class="col-md-4"><h4>&#8369; <?php echo number_format($total_price->total_price,2);?></h4></div>
          <input type="hidden" value="<?php echo $total_price->total_price;?>" id="hidden_total_price">
  </div>
  <div class="row">
    <div class="col-md-8"><h4>Delivery Price:</h4> <span style="color:red;">Only on Metro Manila only</span></div>
    <div class="col-md-4"><h4>&#8369; <span id="deliver_price">0</span></h4></div>
  </div>
  <div class="row">
           <div class="col-md-7">
  <h3>Total Price:</h3> <span style="color:red;">(VAT incl.)</span>  
  </div>
  <div class="col-md-5">
  <h3>&#8369; <span id="total_price"><?php echo number_format($total_price->total_price,2);?></span></h3>
  <input type="hidden" value="<?php echo $total_price->total_price?>" id="hidetotal">
  </div>
  </div>
  <button id="proceed" class="btn btn-info col-sm-12" name="proceed">Reserve</button>

    </div>
  </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php include'../assets/user_footer.php';?>
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable()
  })
  $(document).ready(function(){
    $("div #search").change(function(){
      $("#btn").click();
    })
   
    $("input[type='radio']").change(function(){
      var deliver = $(this).attr('target');
      var total_price = $("#hidden_total_price").val();
      var total ;
      $("#emptydeliver").text("");
      if(deliver == "deliver"){
        total = parseInt(total_price) + 200;
        $("#del").show();
        $("#deliver_price").text("200");
       
        $("#total_price").text(total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g,"$1,"));
        $("#hidetotal").val(total);
      }else{
        total = parseInt(total_price) + 0;
        $("#hidetotal").val(total);
        $("#del").hide();
        $("#deliver_price").text("0");
        $("#total_price").text(total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g,"$1,"));
      }
    })
    function transaction(user,radio,deliver,total_price,method,date){
      $.ajax({
        url:"checkout_paluto.php",
        method:"post",
        data:"user="+user+"&radio="+radio+"&deliver="+deliver+"&total="+total_price+"&method="+method+"&date="+date,
        success:function(data){
          if(data == "invalid"){
              $("#emptydate").text("Sorry This date is already full");
          }else{
            document.location.assign('index.php');
          }
        }
      })
    }
    $("#proceed").click(function(){
      var radio = $("input[name='delivery']:checked").attr('target'); 
      var user = $("#user").val();
      var deliver = $("#del").val();
      var total_price = $("#hidetotal").val();
      var date = $("#datepicker").val();
      var method = "pack";
      if(date == ""){
        $("#emptydate").text("Required field");
      }else{
      if(radio == "deliver"){
        if(deliver == ""){
            $("#emptydeliver").text("Required Field")
        }else{
          transaction(user,radio,deliver,total_price,method,date);
        }
      }else{
        transaction(user,radio,deliver,total_price,method,date);
      
      }
      }
    })
    $("table tr td #add").click(function(){
      var name = $(this).attr('name');
      var price = $(this).attr('class');
      var method = "pack";
      var id = $(this).attr('target');
      var qty = $("#qty-"+id).val();
      var user = $("#user").val();
      if(qty == ""){
        $("table tr td #empty-"+id).text("Required Field");
      }else if(qty < 10){
        $("table tr td #empty-"+id).text("Minimum of 10 pax");
      }else{
        var data = "name="+name+"&price="+price+"&qty="+qty+"&user="+user+"&method="+method;

        $.ajax({
          url:"add_to_cart_package.php",
          method:"post",
          data:data,
          success:function(data){
          
            if(data == 'success'){
              alert("Succesfully added to cart");
              location.reload();
            }else{
              console.log(data);
            }
          }
        })
      }
  })

  $("table tr td #remove").click(function(){
    var id = $(this).attr("name");
    var name = $(this).attr("class");
    var data = "id="+id;
    if(confirm("Are you sure you want to remove "+name+" ?")){
      $.ajax({
        url:"delete_paluto_package.php",
        method:"POST",
        data:data,
        success:function(data){
        
          console.log(data);
          if(data == 'success'){
          alert("Remove Successfully!");
          location.reload();
          }
        }
      })
    }
  })

$("table tr td #up").click(function(){
  var id = $(this).attr('name');
  console.log("test");
  $.ajax({
        url:"display_data.php",
        method:"POST",
        data:"id="+id,
        dataType:"JSON",
        success:function(data){
          $("#name").text(data.name);
          $("#id").val(data.id);
          $("#price").val(data.price);
          $("#pax").val(data.pax);
        }
      })
})
  $("#change").click(function(){
    console.log("test");
    var quantity = $("#quantity").val();
    var id = $("#id").val();
    var price = $("#price").val();
    var data = "id="+id+"&quantity="+quantity+"&price="+price;
    if(quantity == ""){
      $("#emptyquantity").text("Required Field");
    }else if(quantity < 10){
      $("#emptyquantity").text("Minimum Of 10 pax");
    }else{
      $.ajax({
        url: "update_reservation_package.php",
        method:"POST",
        data:data,
        success:function(data){
          if(data == 'success'){
            alert("Successfully Update Pax");
            location.reload();
          }else{
            console.log(data);
          }
        }
      })
    }
  })
    
  $(function() {
    $( "#datepicker").datepicker({ 
      minDate: '4'

    });
  });

  $("#remove_all").click(function(){
    var method = "pack";
    var user = $("#user").val();
    if(confirm("Are you sure you want to remove all of your orders?")){
      $.ajax({
        url:"paluto_remove_all.php",
        method:"post",
        data:"method="+method+"&user="+user,
        success:function(data){
          if(data == "success"){
            console.log(data);
          }else{
            console.log(data);
          }
        }
      })
    }
  })
  })
</script>