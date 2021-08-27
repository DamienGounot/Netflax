<?php
include_once './global_var.php';
include_once './log.php';
session_start();

$connect = new PDO("mysql:host=".$HOST_DB.";dbname=".$NAME_DB, "$USERNAME_DB", "$PASSWORD_DB");
$received_data = json_decode(file_get_contents("php://input"));
$data = array();

             
if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
                    
    $query    = "SELECT * FROM users WHERE email='" .htmlspecialchars($_GET['email']). "'AND verificationHash='" .htmlspecialchars($_GET['hash'])."'";
    
    $clic = date("Y-m-d");


    $statement = $connect->prepare($query);
    $statement->execute();
    while($row = $statement->fetch(PDO::FETCH_ASSOC))
    {
        $data[] = $row;
    }

    if(empty($data)){
        header("Location: ../index.php");        
    }else{
        
        $registrationtime = strtotime($user["creationTime"]);
        $clictime = strtotime($clic);

        if($clictime - $registrationtime < 360000){ // if less than 10 minutes
        
        $query = "UPDATE users SET status = '1' WHERE email='".htmlspecialchars($_GET['email'])."' AND verificationHash='".htmlspecialchars($_GET['hash'])."' AND status='0'"; 
        $statement = $connect->prepare($query);
        $statement->execute();
        $text = "The account with the email : ".htmlspecialchars($_GET['email'])." has been activated !";
        logger("[SUCCES][ACTIVATION]".$text,$FILEPATH);
        header("Location: ../index.php");        
    }else{
                        
        $text = "The account with the email : ".htmlspecialchars($_GET['email'])." has not been activated because delay reached !";
        logger("[ERROR][ACTIVATION]".$text,$FILEPATH);
        header("Location: ../index.php");            
        }
    }
}