<?php
session_start();
logger("[SUCCESS][LOGOUT]".$_SESSION['USERNAME'],$FILEPATH);
session_destroy();
header("Location: ../index.php");
?>