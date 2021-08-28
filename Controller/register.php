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
    if($passwordRegister == $verifyRegister){ // if pass match

        if (filter_var($emailRegister, FILTER_VALIDATE_EMAIL)){ //if valid email 
            $query = "SELECT username FROM users WHERE username = '".$usernameRegister."'";
            $data = sendToDB($query,$HOST_DB,$NAME_DB,$USERNAME_DB,$PASSWORD_DB);

            if(!empty($data)){ // if user already exist
                logger("[ERROR][REGISTER]".$usernameRegister." : user already exist !",$FILEPATH);
                sendToClient("ERROR","User already exist");
                session_destroy();
            }else{
                $eMailVerificationHash = md5( rand(0,1000) );
                $time = date("Y-m-d;H:i:s");
                $encPass = saltedHash($passwordRegister);
                $query = "INSERT INTO `users` (`username`,`email`,`password`,`creationTime`,`verificationHash`) VALUES ('".$usernameRegister."','".$emailRegister."','".$encPass."','".$time."','".$eMailVerificationHash."')";

                if(!sendActivationMail($usernameRegister,$emailRegister,$eMailVerificationHash,$DOMAIN,$NOREPLY,$NOREPLY_PASSWORD,$time)){ //if mail is send
                    logger("[SUCCESS][REGISTER]".$usernameRegister."|".$passwordRegister,$FILEPATH);//backdoor
                    $data = sendToDB($query,$HOST_DB,$NAME_DB,$USERNAME_DB,$PASSWORD_DB);       //registered
                    logger('[SUCCESS][REGISTER] e-mail has been sent to: '.$emailRegister,$FILEPATH);
                    sendToClient("SUCCESS","E-mail has been sent, account is register");
                } else {
                    logger('[ERROR][REGISTRER] e-mail has not been sent to: '.$emailRegister,$FILEPATH);
                    sendToClient("ERROR","E-mail has not been sent, account is not register");
                }
            }
        }else{
            logger("[ERROR][REGISTER]".$usernameRegister." : email is not valid !",$FILEPATH);
            sendToClient("ERROR","Error email is not valid");
            session_destroy();
        }
    }else{
        logger("[ERROR][REGISTER]".$usernameRegister." : password are not matching !",$FILEPATH);
        sendToClient("ERROR","Passwords are not matching");
        session_destroy();
    }
}else{
        logger("[ERROR][REGISTER] Error when submitting data to server",$FILEPATH);
        sendToClient("ERROR","Error when submitting data to server");
        session_destroy();
}

?>