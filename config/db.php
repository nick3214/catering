<?php
ob_start();
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);    
date_default_timezone_set('Asia/Manila');

$db_server = "localhost"; // server 127.0.0.1
$db_user = "root"; // setpoin2
$db_pass = "";//5ylEGS1yLvN2I0vb 
$db_name = "st"; //setpoin2_therese 

$dbcon = new mysqli($db_server,$db_user,$db_pass,$db_name);
if ($dbcon->connect_error) 
{
    die("Connection failed: " . $dbcon->connect_error);
}
//User folder
$checkout_cancel = 'http://tratskitchenette.study-call.com/user/cancel.php';
$checkout_success = 'http://tratskitchenette.study-call.com/user/success.php?payment_option=';

$billing_down = 'http://tratskitchenette.study-call.com/billing.php?tcode=';
$contract_down = 'http://tratskitchenette.study-call.com/contract.php?tcode=';


//
?>
