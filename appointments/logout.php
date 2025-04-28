<?php
include_once("../includes/configuration.php");

$data_login=array();
$data_login['logout_date_time']='now()';		
$db->query_update("admin_login_hostory",$data_login,"id='". $_SESSION['login_hostory_id'] ."'");


session_unset();
session_destroy();
session_start();


$_SESSION['message']="Successfully Logged out.";
$general_func->header_redirect("index.php");
?>
