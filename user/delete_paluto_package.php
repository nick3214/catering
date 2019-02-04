<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';

$id = $_POST['id'];

$delete = $dbcon->query("delete from paluto_reservation_package where paluto_id = '".$id."'");
if($delete){
    echo "success";
}else{
    echo "error";
}