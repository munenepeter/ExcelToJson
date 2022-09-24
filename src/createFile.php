<?php

//get thhe data sent over post
//$data = json_encode(file_get_contents("php://input"));

$data = $_FILES;
var_dump($_FILES['excelFile']["tmp_name"]);

// //check if the file exists so as to return a response
// if (file_exists($jsonfile)) {
//     echo "Success: Your .json file is ready at <a class=\"text-green-500 hover:underline\" href=\"$jsonfile\" target=\"_blank\">$jsonfile</a>";
// } else {
//    echo "Error: Something happened and we could not create the .json file";
// }

