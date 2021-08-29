<?php
    function logger($type,$function,$user,$text,$filepath){
        $file = fopen($filepath, "a+");
        $date = date("d.m.Y;H:i:s");
        fwrite($file, $date.";".$type.";".$function.";".$user.";".$text."\n");
        fclose($file);     
    }

    function sendToClient($type,$text){
        $data = array('type' => $type, 'text' => $text);
        echo json_encode($data);
    }
?>