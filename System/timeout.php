<?php
include_once 'database.php';
include_once 'log.php';
include_once 'global_var.php';


$time = $_SERVER['REQUEST_TIME'];
$db = new Database();
$c  = $db->connectToDB();
$timeout_duration = 600; // 10 minutes timeout


if (isset($_SESSION['LAST_ACTIVITY']) && 
   ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    
    if(isset($_SESSION['username'])){
        
        $text="".$_SESSION['username']." timeout";
        
        logger($text,$FILEPATH)

    }
    session_destroy();
}
$_SESSION['LAST_ACTIVITY'] = $time;
?>