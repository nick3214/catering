<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
date_default_timezone_set('Asia/Manila');
$date = date('Y-m-d h:i:sa');
$paluto_type_deliver = $_POST['radio'];
$paluto_name = $_POST['user'];
$paluto_deliver_add = $_POST['deliver'];
$paluto_total_price = $_POST['total'];
$paluto_method = $_POST['method'];
$paluto_date_reserve = $_POST['date'];
$user = single_get("*","user_id","user_account",$_SESSION['user_id']);

$verify_date = $dbcon->query("select * from paluto_transaction where paluto_date = '".$paluto_date_reserve."'");
if(mysqli_num_rows($verify_date) >= 5){
    echo "invalid";
}else{

if($paluto_type_deliver == "pickup"){
    $paluto_deliver_add = "none";
}else{
    $paluto_deliver_add = $paluto_deliver_add;
}

$insert_transaction = $dbcon->query("insert into paluto_transaction values('','".$paluto_name."','".$paluto_total_price."','".$paluto_type_deliver."','".$paluto_deliver_add."','".$paluto_date_reserve."','".$paluto_method."',0)");
if($insert_transaction){
    $message ="";
    if($paluto_method == "pack"){
        $message = "Customer: " .$user['full_name']." Reserve for Paluto Package";
    }else{
        $message = "Customer: " .$user['full_name']." Reserve for Short Order Paluto";
    }
    $id = single_get("*","max(n_id)","notifications");

    $dbcon->query("insert into notifications values('".$id['n_id']."','".$user['user_id']."',0,'".$message."','".$date."',0,0)");
    $display = $dbcon->query("select max(paluto_id) as id from paluto_transaction");
    $id = $display->fetch_object();
    $select_cart = $dbcon->query("select * from paluto_reservation_package where paluto_name ='".$paluto_name."'&&paluto_status =1 && paluto_method='".$paluto_method."'");

    while($row = $select_cart->fetch_assoc()){
    $insert_order = $dbcon->query("insert into paluto_order values 
            ('','".$id->id."','".$paluto_name."',
                '".$row['paluto_item_name']."',
                '".$row['paluto_price']."',
                '".$row['paluto_pax']."',
                '".$row['paluto_total_price']."',
                '".$paluto_method."')");
        if($insert_order){
           $dbcon->query("update paluto_reservation_package set paluto_status = 0 where paluto_name='".$paluto_name."'&&paluto_id ='".$row['paluto_id']."'");
         }else{
            echo "error insert";
        }
}
}else{
    echo "error transaction";
}

}