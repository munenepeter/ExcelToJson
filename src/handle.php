<?php

require_once 'functions.php';

$logger->log('Reached handle.php')->save();
 
$data = json_decode(file_get_contents("php://input"), true);

$logger->log('Received data from axios => '. json_encode($data))->save();

var_dump($data);

if (isset($_POST['submit'])) {
    $logger->log('Submit button pressed')->save();
    echo getExcelData($_FILES['file']['tmp_name']);    
}