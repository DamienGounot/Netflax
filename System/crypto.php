<?php
    function saltedHash($password){  
       return password_hash($password,PASSWORD_DEFAULT);
    }

    function verify($password,$storedPassword){
        return password_verify($password,$storedPassword);
    }
?>
