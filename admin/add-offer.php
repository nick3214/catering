<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';

$action = $_POST['action'];
$id = $_POST['id'];
$name = $_POST['name'];
$price = $_POST['price'];

if($action == "remove"){
    $delete = $dbcon->query("delete from additional_choice where id='".$id."'");
    action($delete);
}else if($action == "update"){
    $update = $dbcon->query("update additional_choice set price ='".$price."' where id='".$id."'");
    action($update);
}elseif($action == "add"){

$verify_name = $dbcon->query("select * from additional_choice where name = '".$name."'");
    if(mysqli_num_rows($verify_name) == 1){
        echo "test";
    }else{
        $insert = $dbcon->query("insert into additional_choice values('','".$name."','".$price."')");
        action($insert);
    }
}else{
    $show_data = $dbcon->query("select * from additional_choice where id='".$id."'");
    $data = array();
    while($show = $show_data->fetch_assoc()){
        $data['id'] = $show['id'];
        $data['name'] = $show['name'];
        $data['price'] = $show['price'];
    }
    echo json_encode($data);
}
function action($action){
    if($action){
        echo "success";
    }else{
        echo "error";
    }
}