<?php

//get thhe data sent over post
$data = json_decode(file_get_contents("php://input"), true);

// var_dump($data);
//generate random name for successive files
//use $$ to get dynamic filenames
$fileName = $data['datajson'][0];  

//write to a file
$jsonfile = "../samples/json/jsonfile-$fileName.json";


$file = fopen($jsonfile, 'w');
$fData = array_shift($data['datajson']);
fwrite($file, json_encode($fData));
fclose($file);

//check if the file exists so as to return a response
if (file_exists($jsonfile)) {
    echo "Success: Your .json file is ready at <a class=\"text-green-500 hover:underline\" href=\"$jsonfile\" target=\"_blank\">$jsonfile</a>";
} else {
   echo "Error: Something happened and we could not create the .json file";
}

