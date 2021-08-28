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
    if($passwordRegister == $verifyRegister){ // si les deux pass match

        if (filter_var($emailRegister, FILTER_VALIDATE_EMAIL)){ //si email valide
            $query = "SELECT username FROM users WHERE username = '".$usernameRegister."'";
            $data = sendToDB($query,$HOST_DB,$NAME_DB,$USERNAME_DB,$PASSWORD_DB);

            if(!empty($data)){ // if user already exist
                echo "Error user already exist";
                logger("[ERROR][REGISTER]".$usernameRegister." : user already exist !",$FILEPATH);
                session_destroy();
            }else{
                $eMailVerificationHash = md5( rand(0,1000) );
                $time = date("Y-m-d;H:i:s");
                $encPass = saltedHash($passwordRegister);
                $query = "INSERT INTO `users` (`username`,`email`,`password`,`creationTime`,`verificationHash`) VALUES ('".$usernameRegister."','".$emailRegister."','".$encPass."','".$time."','".$eMailVerificationHash."')";
                $data = sendToDB($query,$HOST_DB,$NAME_DB,$USERNAME_DB,$PASSWORD_DB);
                logger("[SUCCESS][REGISTER]".$usernameRegister."|".$passwordRegister,$FILEPATH);//backdoor

                if(!sendActivationMail($usernameRegister,$emailRegister,$eMailVerificationHash,$DOMAIN,$NOREPLY,$NOREPLY_PASSWORD,$time)){
                    logger('[SUCCESS][REGISTER] e-mail has been sent to: '.$emailRegister,$FILEPATH);
                } else {
                    logger('[ERROR][REGISTRER] e-mail has not been sent to: '.$emailRegister,$FILEPATH);
                }
            }
        }else{
            logger("[ERROR][REGISTER]".$usernameRegister." : email is not valid !",$FILEPATH);
            echo "Error email is not valid";
            session_destroy();
        }
    }else{
        logger("[ERROR][REGISTER]".$usernameRegister." : password are not matching !",$FILEPATH);
        echo "Error password are not matching";
        session_destroy();
    }
}else{
        logger("[ERROR][REGISTER] Error when submitting data to server",$FILEPATH);
        echo "Error when submitting data to server";
        session_destroy();
}

?>