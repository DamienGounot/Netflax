<?php

include_once '../System/global_var.php';
include_once '../System/log.php';

session_start();
$connect = new PDO("mysql:host=".$HOST_DB.";dbname=".$NAME_DB, "$USERNAME_DB", "$PASSWORD_DB");
$received_data = json_decode(file_get_contents("php://input"));
$data = array();

//$input =  json_encode($received_data);
$username = $received_data->{'usernameLogin'};
$password = $received_data->{'passwordLogin'};

if(isset($username) && isset($password)){ // if every attempt data have been send

    $query = "SELECT username FROM users WHERE username = '".$username."' AND password = '".$password."'";
    $statement = $connect->prepare($query);
    $statement->execute();
    while($row = $statement->fetch(PDO::FETCH_ASSOC))
    {
        $data[] = $row;
    }

    if(!empty($data)){
        $_SESSION['ONLINE'] = TRUE;
        logger("[SUCCESS][LOGIN]".$username,$FILEPATH);
    }else{
        logger("[ERROR][LOGIN]".$username,$FILEPATH);
        session_destroy();
    }

}else{
    echo "Error when submitting data to server";
    session_destroy();
}




?>