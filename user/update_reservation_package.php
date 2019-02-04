<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';

$id = $_POST['id'];
$quantity = $_POST['quantity'];
$price = $_POST['price'];
$total = $quantity * $price;
$update_quantity = $dbcon->query("update paluto_reservation_package set paluto_pax='".$quantity."',paluto_total_price='".$total."'where paluto_id='".$id."'");
if($update_quantity){
    echo "success";
}else{
    echo "error";
}