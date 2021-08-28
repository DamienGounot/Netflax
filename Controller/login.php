<?php

include_once '../System/global_var.php';
include_once '../System/log.php';
include_once '../System/crypto.php';
include_once '../Database/db.php';

session_start();
$received_data = json_decode(file_get_contents("php://input"));
$username = $received_data->{'usernameLogin'};
$password = $received_data->{'passwordLogin'};

if(isset($username) && isset($password)){ // if every attempt data have been send
    $query = "SELECT password FROM users WHERE username = '".$username."'"; //check if user exist
    $data = sendToDB($query,$HOST_DB,$NAME_DB,$USERNAME_DB,$PASSWORD_DB);
    if(!empty($data)){ // if user exist
        $query = "SELECT status FROM users WHERE username ='".$username."'"; //get user status
        $data = sendToDB($query,$HOST_DB,$NAME_DB,$USERNAME_DB,$PASSWORD_DB);
        if($data[0]['status'] != 0){ // if user account is active
            $query = "SELECT password FROM users WHERE username ='".$username."'"; //get user storedPassword
            $data = sendToDB($query,$HOST_DB,$NAME_DB,$USERNAME_DB,$PASSWORD_DB);
            $storedPassword = $data[0]['password'];
            if(password_verify($password,$storedPassword)){ // if password are matching
                $_SESSION['ONLINE'] = TRUE;
                $_SESSION['USERNAME'] = $username;
                $query = "UPDATE users SET failedLogin = '0' WHERE username='".$username."'"; //  reset number of failed attemp
                $data = sendToDB($query,$HOST_DB,$NAME_DB,$USERNAME_DB,$PASSWORD_DB);
                logger("[SUCCESS][LOGIN]".$username,$FILEPATH);
                sendToClient("SUCCESS","Welcome !");

            }else{  //real credential error
                $query    = "SELECT failedLogin FROM users WHERE username='" . $username . "'"; // get number of failed attemp
                $data = sendToDB($query,$HOST_DB,$NAME_DB,$USERNAME_DB,$PASSWORD_DB);
                $failedLogin = $data[0]['failedLogin'];
                $failedLogin ++;
                $query = "UPDATE users SET failedLogin = '".$failedLogin."' WHERE username='".$username."'"; //  update number of failed attemp
                $data = sendToDB($query,$HOST_DB,$NAME_DB,$USERNAME_DB,$PASSWORD_DB);
                    if($failedLogin >= 3){ // if 3 failed attempt
                        $query = "UPDATE users SET status = '0' WHERE username ='".$username."'"; //update status (block account)
                        $data = sendToDB($query,$HOST_DB,$NAME_DB,$USERNAME_DB,$PASSWORD_DB);
                    }
                logger("[ERROR][LOGIN]".$username." wrong password",$FILEPATH);
                sendToClient("ERROR","Wrong password");
                session_destroy();
            }

        }else{ // if user account is NOT active
            logger("[ERROR][LOGIN]".$username." is not active !",$FILEPATH);
            sendToClient("ERROR","Account is not active");
            session_destroy();
        }
    }else{ //if user does NOT exist
        logger("[ERROR][LOGIN]".$username." does not exist",$FILEPATH);
        sendToClient("ERROR","Account does not exist");
        session_destroy();
    }
}else{
    echo "Error when submitting data to server";
    session_destroy();
}
?>