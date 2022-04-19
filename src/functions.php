<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

require_once "../vendor/autoload.php";
$tmpfname = "../samples/excel/Report - 02.03.2021_example.xlsx";

function getExcelData(String $filename): string{

    $spreadsheet = IOFactory::load($filename);
    return json_encode($spreadsheet->getActiveSheet()->toArray(null, true, true, true));
}
function formatToJSON(array $data): String{
    return json_encode($data);
}

 
// create a logger
$logger = new class {
    
    public String $log = "";

    public function log(String $message){
        $this->log = date("D, d M Y H:i:s").' - '.$_SERVER['SERVER_NAME'].' - '. $_SERVER['REQUEST_URI'].' - ' ."$message".PHP_EOL;
        return $this;
    }

    public function save():void{

        $logFile = "../Logs/log.log";

        $file = fopen($logFile, 'a');
        fwrite($file, $this->log);
        fclose($file);
    }

};
 