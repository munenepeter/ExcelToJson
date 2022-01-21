<?php


$data = json_decode(file_get_contents("php://input"), true);
//var_dump(json_encode($data));

$jsonfile = "../samples/json/file-2.json";
$file = fopen($jsonfile, 'w');
fwrite($file, json_encode($data));
fclose($file);
