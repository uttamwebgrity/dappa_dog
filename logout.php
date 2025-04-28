<?php
include_once("includes/configuration.php");

session_unset();
session_destroy();
session_start();

$_SESSION["client_success_msg"]="Successfully Logged out.";
header("location:" . $general_func->site_url ."login.php");
exit();
?>
