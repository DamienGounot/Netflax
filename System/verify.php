<?php
include_once './global_var.php';
include_once './log.php';
include_once '../Database/db.php';

session_start();
             
if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
                    
    $query = "SELECT * FROM users WHERE email='" .htmlspecialchars($_GET['email']). "'AND verificationHash='" .htmlspecialchars($_GET['hash'])."'";
    $clic = date("Y-m-d;H:i:s");
    $data = sendToDB($query,$HOST_DB,$NAME_DB,$USERNAME_DB,$PASSWORD_DB);
    if(empty($data)){
        header("Location: ../index.php");        
    }else{
        
        $registrationtime = strtotime($user["creationTime"]);
        $clictime = strtotime($clic);

        if($clictime - $registrationtime < 600){ // if less than 10 minutes
        
        $query = "UPDATE users SET status = '1' WHERE email='".htmlspecialchars($_GET['email'])."' AND verificationHash='".htmlspecialchars($_GET['hash'])."' AND status='0'"; 
        $data = sendToDB($query,$HOST_DB,$NAME_DB,$USERNAME_DB,$PASSWORD_DB);
        
        $text = "The account with the email : ".htmlspecialchars($_GET['email'])." has been activated !";
        logger("[SUCCES][ACTIVATION]".$text,$FILEPATH);
        header("Location: ../index.php");
        sendToClient("SUCCESS","Account activated");        
    }else{
                        
        $text = "The account with the email : ".htmlspecialchars($_GET['email'])." has not been activated because delay reached !";
        logger("[ERROR][ACTIVATION]".$text,$FILEPATH);
        sendToClient("ERROR","Error delay reached");
        header("Location: ../index.php");            
        }
    }
}
?>