<?php
    $colum = $_POST["columns"];
    $frame = $_POST["frame"];
    if($frame >2 || $frame <1){
        $frame = 1;
    }
    if($colum >6 || $colum<4){$colum = 5;}
$json = 
'{
    "fondo": 1,
    "marco": '.$frame.',
    "columnas": "'.$colum.'"
}';
    file_put_contents("../../config.json", $json);