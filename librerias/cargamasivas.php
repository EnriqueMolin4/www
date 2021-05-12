<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//include the file that loads the PhpSpreadsheet classes
require __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class CargasMasivas {

    function loadFile($file) {

        $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        if(isset($file['file']['name']) && in_array($file['file']['type'], $file_mimes)) {
        
            $arr_file = explode('.', $file['file']['name']);
            $extension = end($arr_file);
        
            if('csv' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
        
            $spreadsheet = $reader->load($file['file']['tmp_name']);
            
           return $sheetData = $spreadsheet->getSheet(0);;
           //return  json_encode($sheetData);
        } 
    }

    function placeholders($text, $count=0, $separator=","){
        $result = array();
        if($count > 0){
            for($x=0; $x<$count; $x++){
                $result[] = $text;
            }
        }
    
        return implode($separator, $result);
    }

}
?>