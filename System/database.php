<?php
include_once 'global_var.php'
class Database {

    const server = $SERVER_DB;
    const username = $USERNAME_DB;
    const password = $PASSWORD_DB;
    const db_name = $NAME_DB;

    private $connection = null;
    private $myError = '';

    function connectToDB() {
        $this->connection = new mysqli(self::server, self::username, self::password, self::db_name);
        if ($this->connection->connect_errno) {
            echo "Error during connection: " . $this->connection->connect_errno . ", " .
            $this->connection->connect_error;
            $this->myError = $this->connection->connect_error;
        }else{
            $this->connection->set_charset("utf8");
        }
        return $this->connection;
    }

    function closeDB() {
        $this->connection->close();
    }

    function selectDB($query) {
        $result = $this->connection->query($query);
        if ($this->connection->connect_errno) {
            echo "Error on query: {$query} - " . $this->connection->connect_errno . ", " .
            $this->connection->connect_error;
            $this->myError = $this->connection->connect_error;
        }
        if (!$result) {
            $result = null;
        }
        return $result;
    }

    function updateDB($query, $script = '') {
        $result = $this->connection->query($query);
        if ($this->connection->connect_errno) {
            echo "Error on query: {$query} - " . $this->connection->connect_errno . ", " .
            $this->connection->connect_error;
            $this->myError = $this->connection->connect_error;
        } else {
            if ($script != '') {
                header("Location: $script");
            }
        }
        return $result;
    }
    
    function showMyErrorDB(){
        if ($this->myError != '') {
            return true;
        } else {
            return false;
        }
    }
}
?>