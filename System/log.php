<?php
    function logger($text,$filepath){
        $file = fopen($filepath, "a+");
        $date = date("d.m.Y;H:i:s");
        fwrite($file, $date.";".$text."\n");
        fclose($file);     
    }

    function sendToClient($type,$text){
        $data = array('type' => $type, 'text' => $text);
        echo json_encode($data);
    }
?>