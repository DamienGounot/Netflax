<?php
    function sendToDB($query,$HOST_DB,$NAME_DB,$USERNAME_DB,$PASSWORD_DB){
        $data = array();
        $connect = new PDO("mysql:host=".$HOST_DB.";dbname=".$NAME_DB, "$USERNAME_DB", "$PASSWORD_DB");
        $statement = $connect->prepare($query);
        $statement->execute();
        while($row = $statement->fetch(PDO::FETCH_ASSOC))
        {
            $data[] = $row;
        }
        return $data;
    }
?>