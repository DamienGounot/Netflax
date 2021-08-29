<?php
include_once './global_var.php';
include_once './log.php';
include_once '../Database/db.php';

session_start();
             
if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
                    
    $query = "SELECT * FROM users WHERE email='" .htmlspecialchars($_GET['email']). "'AND verificationHash='" .htmlspecialchars($_GET['hash'])."'";
    $clic = date("Y-m-d H:i:s"); //MySQL DATETIME format 
    $data = sendToDB($query,$HOST_DB,$NAME_DB,$USERNAME_DB,$PASSWORD_DB);
    $username = "";

    if(empty($data)){
        header("Location: ../index.php");        
    }else{
        $username = $data[0]["username"];
        $registrationtime = strtotime($data[0]["creationTime"]);
        $clictime = strtotime($clic);

        if($clictime - $registrationtime < $ACTIVATION_DELAY){ // if less than 10 minutes
        
        $query = "UPDATE users SET active = '1' WHERE email='".htmlspecialchars($_GET['email'])."' AND verificationHash='".htmlspecialchars($_GET['hash'])."'"; 
        $data = sendToDB($query,$HOST_DB,$NAME_DB,$USERNAME_DB,$PASSWORD_DB);
        
        $text = "Account activated";
        logger("SUCCESS","ACTIVATION",$username,$text,$FILEPATH);
        sendToClient("SUCCESS",$text);
        header("Location: ../index.php");      
    }else{
                        
        $text = "Delay reached, account not activated";
        logger("ERROR","ACTIVATION",$username,$text,$FILEPATH);
        sendToClient("ERROR",$text);
        header("Location: ../index.php");            
        }
    }
}
?>