<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';

$paluto_name = $_POST['name'];
$paluto_price = $_POST['price'];
$paluto_pax = $_POST['qty'];
$total = $paluto_price * $paluto_pax;
$user = $_POST['user'];
$method = $_POST['method'];

$verify_data = $dbcon->query("select * from paluto_reservation_package where paluto_name ='".$user."'&& paluto_item_name='".$paluto_name."'&& paluto_status =1 && paluto_method='".$method."'");
if(mysqli_num_rows($verify_data) == 1){
    while($data = $verify_data->fetch_assoc()){
        $price = $data['paluto_total_price'];
        $quantity = $data['paluto_pax'];
        $total_quantity = $quantity + $paluto_pax;
        $total_price = $price + $total;

        $update_data = $dbcon->query("update paluto_reservation_package set paluto_pax = '".$total_quantity."',paluto_total_price='".$total_price."'where paluto_name ='".$user."'&& paluto_item_name='".$paluto_name."'");
        if($update_data){
            echo "success";
        }else{
            echo "error";
        }
    }
}else{
$insert_data = $dbcon->query("insert into paluto_reservation_package values ('','".$user."','".$paluto_name."','".$paluto_pax."','".$paluto_price."','".$total."',1,'".$method."')");
if($insert_data){
    echo "success";
}else{
    echo "error";
}
}
