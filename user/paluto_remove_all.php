<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';

$user =$_POST['user'];
$method = $_POST['method'];

$delete = $dbcon->query("delete from paluto_reservation_package where paluto_name='".$user."'&& paluto_method='".$method."'&& paluto_status = 1");
if($delete){
    echo "success";
}else{
    echo "error";
}