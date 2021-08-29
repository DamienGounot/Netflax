<?php
include_once '../System/global_var.php';
include_once '../System/log.php';
session_start();
logger("SUCCESS","LOGOUT",$_SESSION['USERNAME'],"Disconnect",$FILEPATH);
$text = "Disconnect";
sendToClient("SUCCESS",$text);
$_SESSION['ONLINE'] == FALSE;
session_destroy();
?>