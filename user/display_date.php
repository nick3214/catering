<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';

$id = $_POST['id'];
$select_date = $dbcon->query("select * from paluto_transaction where paluto_id='".$id."'");
$fetch = $select_date->fetch_object();
echo $fetch->paluto_date;