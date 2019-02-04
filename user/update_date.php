<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';

$id = $_POST['id'];
$date = $_POST['date'];

$verify_date = $dbcon->query("select * from paluto_transaction where paluto_date ='".$date."'");
if(mysqli_num_rows($verify_date) == 5){
    echo "invalid";
}else{
    $update = $dbcon->query("update paluto_transaction set paluto_date='".$date."'where paluto_id ='".$id."'");
    if($update){
        echo "success";
    }else{
        echo "error";
    }
}