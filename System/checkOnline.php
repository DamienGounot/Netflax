<?php
session_start();
if (isset($_SESSION['ONLINE']) && $_SESSION['ONLINE'] == TRUE){
 //echo "<script>alert('Logged in !')</script>";
}else{
    header('Location: /index.php');
}
?>