<?php

require_once 'functions.php';

if($_FILES['file']['name'] != ''){
    $test = explode('.', $_FILES['file']['name']);
    $extension = end($test);    
    $name = rand(100,999).'.'.$extension;
    $logger->log('File => '. $name)->save();

    $location = "../uploads/".$name;
    move_uploaded_file($_FILES['file']['tmp_name'], $location);

    $logger->log('File location'. $location)->save();

    var_dump(getExcelData($location));

    echo 'File uploaded successfully';
}
