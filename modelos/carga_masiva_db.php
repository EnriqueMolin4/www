<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//include the file that loads the PhpSpreadsheet classes
echo  __DIR__;
require __DIR__ . '/../vendor/autoload.php';

//create directly an object instance of the IOFactory class, and load the xlsx file
$fxls ='CARGA MASIVA DE EVENTOS.xlsx';
$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($fxls);


//read excel data and store it into an array
$xls_data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
/* $xls_data contains this array:
[1=>['A'=>'Domain', 'B'=>'Category', 'C'=>'Nr. Pages'], 2=>['A'=>'CoursesWeb.net', 'B'=>'Web Development', 'C'=>4000], 3=>['A'=>'MarPlo.net', 'B'=>'Courses & Games', 'C'=>15000]]
*/

//now it is created a html table with the excel file data
$html_tb ='<table border="1"><tr><th>'. implode('</th><th>', $xls_data[1]) .'</th></tr>';
$nr = count($xls_data); //number of rows
for($i=2; $i<=$nr; $i++){
var_dump($xls_data[$i]);
  $html_tb .='<tr><td>'. implode('</td><td>', $xls_data[$i]) .'</td></tr>';
}
$html_tb .='</table>';

echo $html_tb;

 
?>