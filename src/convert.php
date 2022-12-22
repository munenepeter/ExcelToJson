<?php
ini_set('memory_limit', '-1');
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;


require_once("../vendor/autoload.php");
$reader = new Xlsx();
$reader->setReadDataOnly(true);
$spreadsheet = $reader->load($_FILES['excelFile']["tmp_name"]);
$activeSheet = $spreadsheet->getActiveSheet();

$highestRow = $activeSheet->getHighestRow();
$highestColumn = $activeSheet->getHighestColumn();




$headers = $activeSheet->rangeToArray("A1:{$highestColumn}1", "", FALSE, TRUE, false)[0];
//Should change to have only occupied cells 
//But for now will add a dangerous 'safe' no 1000000
$datas = $activeSheet->rangeToArray("A2:{$highestColumn}100000", "", true, TRUE, false);

//remove empty cells
for ($i = 0; $i <= 100000; $i++) {
    if (!empty($datas[$i][0])) {
        continue;
    } else {
        unset($datas[$i]);
    }
}


function convertDate($exceldate) {
    if (empty($exceldate)) return "";
    $UNIX_DATE = ((int)$exceldate - 25569) * 86400;
    return gmdate("d/m/Y", $UNIX_DATE);
    //return Date::excelToDateTimeObject($exceldate)->date;
}


//remove nulls & combine the headers & data
$vs = [];
foreach ($datas as $data) {
    $data = array_map(function ($v) {
        return (is_null($v)) ? "" : $v;
    }, $data);

    $vs[] = array_combine($headers, $data);
}


//And the extra values & format the excel dates
$data = array_map(function ($v) {
    // TODO Format the data
    return $v;
}, $vs);

//Add the final format
$final = [
    "total" => count($data),
    "items" => $data
];



//From here we write to a file

//use $$ to get dynamic filenames
$fileName = preg_replace('/\s+/', '-', $_FILES['excelFile']["name"]);
$$fileName = trim($fileName);

//write to a file
$jsonfile = "../samples/json/{$$fileName}.json";

$file = fopen($jsonfile, 'w');
//unescape the slashes
fwrite($file, json_encode($final, JSON_UNESCAPED_SLASHES));
fclose($file);

//check if the file exists so as to return a response
if (file_exists($jsonfile)) {
    echo "Success: Your .json file is ready at <a class=\"text-green-500 hover:underline\" href=\"$jsonfile\" target=\"_blank\">$jsonfile</a>";
} else {
    echo "Error: Something happened and we could not create the .json file";
}
