<?php
    function logger($text,$filepath){
        $file = fopen($filepath, "a+");
        $date = date("d.m.Y;H:i:s");
        fwrite($file, $date.";".$text."\n");
        fclose($file);     
    }
?>