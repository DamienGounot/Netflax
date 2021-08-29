<?php
session_start();
logger("SUCCESS","LOGOUT",$_SESSION['USERNAME'],"Disconnect",$FILEPATH);
session_destroy();
header("Location: ../index.php");
?>