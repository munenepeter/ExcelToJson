<?php

//get thhe data sent over post
//$data = json_encode(file_get_contents("php://input"));







use PhpOffice\PhpSpreadsheet\Reader\Xlsx;


require_once("../vendor/autoload.php");
$reader = new Xlsx();
$reader->setReadDataOnly(true);
$spreadsheet = $reader->load($_FILES['excelFile']["tmp_name"]);


$worksheet = $spreadsheet->getActiveSheet();


$headers = $spreadsheet->getActiveSheet()->rangeToArray('A1:L1', NULL, FALSE, TRUE, false)[0];
$datas = $spreadsheet->getActiveSheet()->rangeToArray('A2:L7', NULL, FALSE, TRUE, false);



$headers = [
    "issuing_body",
    "document_name",
    "page_url",
    "extracted_at",
    "jurisdiction",
    "effective_date",
    "public_response_date",
    "document_type1",
    "document_type2",
    "document_type3",
    "document_type4",
    "document_type5"
];


function randomString() {
    $characters = array_merge(range(0,9),range('a','z'),range('A','Z'));
    $randstring = [];
    for ($i = 0; $i < 24; $i++) {
        array_push($randstring, $characters[rand(0, count($characters)-$i)]);
    }
    return implode("",$randstring);
}


function convertDate($exceldate) {
    if (empty($exceldate)) return "";
    $UNIX_DATE = ((int)$exceldate - 25569) * 86400;
    return gmdate("d/m/Y", $UNIX_DATE);
    //return Date::excelToDateTimeObject($exceldate)->date;
}





//print_r($datas);
foreach ($datas as $data) {
    $data = array_map(function ($v) {
        return (is_null($v)) ? "" : $v;
    }, $data);

    $vs[] = array_combine($headers, $data);
}
function getDTs(...$v) {
    $dts = [];
    for ($i = 0; $i < count($v); $i++) {
        if ($i == 0) {
            $dts[] = $v[$i];
            continue;
        }
        if ($v[$i] !== "") {
            array_push($dts, $v[$i]);
        }
        
    }
    return implode(", ",$dts);
}

$data = array_map(function ($v) {
    $v['extracted_at'] = convertDate($v['extracted_at']);
    $v['effective_date'] = convertDate($v['effective_date']);
    $v['public_response_date'] = convertDate($v['public_response_date']);
    $v['document_type'] = getDTs($v['document_type1'], $v['document_type2'], $v['document_type3'], $v['document_type4'], $v['document_type5']);
    $v['spider_id'] = randomString();
    return $v;
}, $vs);

$final = [
    "total" => count($data),
    "articles" => $data
];





//use $$ to get dynamic filenames
$fileName = preg_replace('/\s+/', '-', $_FILES['excelFile']["name"]);  
$$fileName = trim($fileName);

//write to a file
$jsonfile = "../samples/json/{$$fileName}.json";

$file = fopen($jsonfile, 'w');
fwrite($file, json_encode($final));
fclose($file);

//check if the file exists so as to return a response
if (file_exists($jsonfile)) {
    echo "Success: Your .json file is ready at <a class=\"text-green-500 hover:underline\" href=\"$jsonfile\" target=\"_blank\">$jsonfile</a>";
} else {
   echo "Error: Something happened and we could not create the .json file";
}
