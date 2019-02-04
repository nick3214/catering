<?php 
include '../config/db.php';
include '../config/main_function.php';
include '../config/functions.php';

$id = $_POST['id'];
$data = array();
$select_paluto = $dbcon->query("select * from paluto_reservation_package where paluto_id ='".$id."'");
while($row = $select_paluto->fetch_assoc()){
    $data['id'] = $row['paluto_id'];
    $data['name'] = $row['paluto_item_name'];
    $data['price'] = $row['paluto_price'];
    $data['pax'] = $row['paluto_pax'];
}

echo json_encode($data);