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
    if(!empty($username) && !empty($password)){
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
                    $text ="Logged in !";
                    logger("SUCCESS","LOGIN",$username,$text,$FILEPATH);
                    sendToClient("SUCCESS",$text);

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
                    $text = "Incorrect credentials";
                    logger("ERROR","LOGIN",$username,$text,$FILEPATH);
                    sendToClient("ERROR",$text);
                }

            }else{ // if user account is NOT active
                $text = "Account is not active";
                logger("ERROR","LOGIN",$username,$text,$FILEPATH);
                sendToClient("ERROR",$text);
            }
        }else{ //if user does NOT exist
            $text = "Unknow account";
            logger("ERROR","LOGIN",$username,$text,$FILEPATH);
            sendToClient("ERROR",$text);
        }
    }else{
        $text = "Missing fields";
        logger("ERROR","LOGIN",$username,$text,$FILEPATH);
        sendToClient("ERROR",$text);    
    }
}else{
    $text = "Issue with server";
    logger("ERROR","LOGIN",$username,$text,$FILEPATH);
    sendToClient("ERROR",$text);
}
?>