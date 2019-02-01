<?php
use PhpOffice\PhpSpreadsheet\IOFactory;
$errorlist=[];
if ($_SERVER['REQUEST_METHOD']=="POST") {


  //echo var_dump($_FILES);
    
  
  while (sizeof($errorlist)==0){
    if ($_FILES['excelFromUser']['name']=='') {
      $errorlist[]= "No hay excel";
      break;
    }
    if ($_POST['selectlinea_mtp']=='notselected') {
      $errorlist[]= "Los menus desplegables no deben estar vacios";
      break;
    }

    $target_dir = "../storage/shp/";
    $target_file = $target_dir . basename($_FILES['excelFromUser']["name"]);
    $inputFileName = $_FILES['excelFromUser'];
    move_uploaded_file($_FILES['excelFromUser']["tmp_name"], $target_file);

$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');

$worksheetNames = $reader->listWorksheetNames($target_file);
$spreadsheet = $reader->load($target_file);

foreach ($worksheetNames as $sheet) {
  echo $sheet;
  $myval = $spreadsheet->getSheetByName($sheet)->getCell('A1')->getValue();
  echo $myval;
}

//$spreadsheet->getSheetByName($sheet);

    //$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($target_file);

    break;
  }

    



}
    

session(['error' => $errorlist]);
?>