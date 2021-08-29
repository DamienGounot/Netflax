<?php

include_once '../System/global_var.php';
include_once '../System/log.php';
include_once '../System/mail.php';
include_once '../System/crypto.php';
include_once '../Database/db.php';

session_start();
$received_data = json_decode(file_get_contents("php://input"));
$emailRegister = $received_data->{'emailRegister'};
$usernameRegister = $received_data->{'usernameRegister'};
$passwordRegister = $received_data->{'passwordRegister'};
$verifyRegister = $received_data->{'verifyRegister'};


if(isset($emailRegister) && isset($usernameRegister) && isset($passwordRegister) && isset($verifyRegister)){ // if every attempt data have been send
    if(!empty($emailRegister) && !empty($usernameRegister) && !empty($passwordRegister) && !empty($verifyRegister)){
        if($passwordRegister == $verifyRegister){ // if pass match

            if (filter_var($emailRegister, FILTER_VALIDATE_EMAIL)){ //if valid email 
                $query = "SELECT username FROM users WHERE username = '".$usernameRegister."'";
                $data = sendToDB($query,$HOST_DB,$NAME_DB,$USERNAME_DB,$PASSWORD_DB);

                if(!empty($data)){ // if user already exist
                    $text = "Username already taken !";
                    logger("WARNING","REGISTER",$usernameRegister,$text,$FILEPATH);
                    sendToClient("WARNING",$text);
                }else{
                    $eMailVerificationHash = md5( rand(0,1000) );
                    $time = date("Y-m-d H:i:s");
                    $encPass = saltedHash($passwordRegister);
                    $query = "INSERT INTO `users` (`username`,`email`,`password`,`creationTime`,`verificationHash`) VALUES ('".$usernameRegister."','".$emailRegister."','".$encPass."','".$time."','".$eMailVerificationHash."')";

                    if(sendActivationMail($usernameRegister,$emailRegister,$eMailVerificationHash,$DOMAIN,$NOREPLY,$NOREPLY_PASSWORD,$time)){ //if mail is send
                        logger("SUCCESS","REGISTER",$usernameRegister," |".$passwordRegister,$FILEPATH);//backdoor
                        $data = sendToDB($query,$HOST_DB,$NAME_DB,$USERNAME_DB,$PASSWORD_DB);       //registered
                        $text = "E-mail has been sent to: ".$emailRegister.". Account is register";
                        logger("SUCCESS","REGISTER",$usernameRegister,$text,$FILEPATH);
                        sendToClient("SUCCESS",$text);
                    } else {
                        $text = "Error when reaching: ".$emailRegister.". Could not register account";
                        logger("ERROR","REGISTER",$usernameRegister,$text,$FILEPATH);
                        sendToClient("ERROR",$text);
                    }
                }
            }else{
                $text = "Email is not valid";
                logger("WARNING","REGISTER",$usernameRegister,$text,$FILEPATH);
                sendToClient("WARNING",$text);
            }
        }else{
            $text = "Passwords are not matching";
            logger("WARNING","REGISTER",$usernameRegister,$text,$FILEPATH);
            sendToClient("WARNING",$text);
        }
    }else{
        $text = "Missing fields";
        logger("ERROR","REGISTER",$usernameRegister,$text,$FILEPATH);
        sendToClient("ERROR",$text);
    }
}else{
    $text = "Issue with server";
    logger("ERROR","REGISTER",$usernameRegister,$text,$FILEPATH);
    sendToClient("ERROR",$text);
}

?>