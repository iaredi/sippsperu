<?php
use PhpOffice\PhpSpreadsheet\IOFactory;
$errorlist=[];
if ($_SERVER['REQUEST_METHOD']=="POST") {
  //echo var_dump($_FILES);
  while (true){
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

    $newobspost = array('selectlinea_mtp' => $_POST['selectlinea_mtp']);
    $newobspost['selectmedicion']='Nuevo';
    $day =  $spreadsheet->getSheetByName('MEDICION')->getCell('A3')->getValue();
    $month =  $spreadsheet->getSheetByName('MEDICION')->getCell('B3')->getValue();
    $year =  $spreadsheet->getSheetByName('MEDICION')->getCell('C3')->getValue();
    $newobspost['row0*medicion*fecha'] ="{$year}-{$month}-{$day}";

    $brigadarownumber=3;
    while (true){
      $materno =  $spreadsheet->getSheetByName('MEDICION')->getCell("D{$brigadarownumber}")->getValue();
      $paterno =  $spreadsheet->getSheetByName('MEDICION')->getCell("E{$brigadarownumber}")->getValue();
      $nombre =  $spreadsheet->getSheetByName('MEDICION')->getCell("F{$brigadarownumber}")->getValue();
      if ($materno==NULL && $paterno==NULL && $nombre==NULL){
        break;
      }else{
        $rownum=$brigadarownumber-3;
        $newobspost["row{$rownum}*personas*apellido_materno"]=$materno;
        $newobspost["row{$rownum}*personas*apellido_paterno"]=$paterno;
        $newobspost["row{$rownum}*personas*apellido_nombre"]=$nombre;
      }
      $brigadarownumber++;
    }

    $gpsrownumber=3;
    while (true){
      $anio =  $spreadsheet->getSheetByName('MEDICION')->getCell("H{$gpsrownumber}")->getValue();
      $marca =  $spreadsheet->getSheetByName('MEDICION')->getCell("G{$gpsrownumber}")->getValue();
      $modelo =  $spreadsheet->getSheetByName('MEDICION')->getCell("I{$gpsrownumber}")->getValue();
      $numero_de_serie =  $spreadsheet->getSheetByName('MEDICION')->getCell("J{$gpsrownumber}")->getValue();
      if ($anio==NULL && $marca==NULL && $modelo==NULL && $numero_de_serie==NULL){
        break;
      }else{
        $rownum=$gpsrownumber-3;
        $newobspost["row{$rownum}*gps*anio"]=$anio;
        $newobspost["row{$rownum}*gps*marca"]=$marca;
        $newobspost["row{$rownum}*gps*modelo"]=$modelo;
        $newobspost["row{$rownum}*gps*numero_de_serie"]=$numero_de_serie;
      }
      $gpsrownumber++;
    }

    $camararownumber=3;
    while (true){
      $anio =  $spreadsheet->getSheetByName('MEDICION')->getCell("H{$camararownumber}")->getValue();
      $marca =  $spreadsheet->getSheetByName('MEDICION')->getCell("G{$camararownumber}")->getValue();
      $modelo =  $spreadsheet->getSheetByName('MEDICION')->getCell("I{$camararownumber}")->getValue();
      $numero_de_serie =  $spreadsheet->getSheetByName('MEDICION')->getCell("J{$camararownumber}")->getValue();
      if ($anio==NULL && $marca==NULL && $modelo==NULL && $numero_de_serie==NULL){
        break;
      }else{
        $rownum=$camararownumber-3;
        $newobspost["row{$rownum}*camara*anio"]=$anio;
        $newobspost["row{$rownum}*camara*marca"]=$marca;
        $newobspost["row{$rownum}*camara*modelo"]=$modelo;
        $newobspost["row{$rownum}*camara*numero_de_serie"]=$numero_de_serie;
      }
      $camararownumber++;
    }

    echo var_dump($newobspost); 
    $newmedicion = savedata($newobspost,$useremail,true);

    //Begin saving observations
    

    foreach ($worksheetNames as $sheet) {
      $newobspost = array('selectlinea_mtp' => $_POST['selectlinea_mtp']);
      $newobspost['selectmedicion'] = $newmedicion;
      $newobspost['mode']='Datos Nuevos';
      $newobspost['submit']='submit';
      $row_number=2;
      //AVES
      if (strpos($sheet, 'AVE_LOC') !== false){
        $lifeform="ave";
        $transpunto="punto";
        $newobspost['selectobservaciones'] = $lifeform;
        $newobspost["selectPunto"] = explode("_" , $sheet)[2];
        $newobspost["row0*{$transpunto}_{$lifeform}*longitud_gps"] = $spreadsheet->getSheetByName($sheet)->getCell("A2")->getValue();
        $newobspost["row0*{$transpunto}_{$lifeform}*latitud_gps"] = $spreadsheet->getSheetByName($sheet)->getCell("B2")->getValue();
        $newobspost["row0*{$transpunto}_{$lifeform}*hora_inicio"] = $spreadsheet->getSheetByName($sheet)->getCell("C2")->getValue();
        $newobspost["row0*{$transpunto}_{$lifeform}*hora_fin"] = $spreadsheet->getSheetByName($sheet)->getCell("D2")->getValue();
        $newobspost["row0*{$transpunto}_{$lifeform}*estado_del_tiempo"] = $spreadsheet->getSheetByName($sheet)->getCell("E2")->getValue();
        $newobspost["row0*{$transpunto}_{$lifeform}*tipo_vegetacion"] = $spreadsheet->getSheetByName($sheet)->getCell("F2")->getValue();
        $newobspost["row0*{$transpunto}_{$lifeform}*ts_y_ac"] = $spreadsheet->getSheetByName($sheet)->getCell("G2")->getValue();
        $newobspost["row0*{$transpunto}_{$lifeform}*e"] = $spreadsheet->getSheetByName($sheet)->getCell("H2")->getValue();
        $newobspost["row0*{$transpunto}_{$lifeform}*m"] = $spreadsheet->getSheetByName($sheet)->getCell("I2")->getValue();
        $sheetobs="AVE_OBS_".explode("_" , $sheet)[2];
        while (true){
          if ($spreadsheet->getSheetByName($sheetobs)->getCell("C{$row_number}")->getValue()==NULL){
            echo 'worked';
            break;
          }else{
            $true_row=$row_number-2;
            $newobspost["row{$true_row}*observacion_{$lifeform}*species"] = 'Nuevo';
            $newobspost["row{$true_row}*observacion_{$lifeform}*comun"] = $spreadsheet->getSheetByName($sheetobs)->getCell("A{$row_number}")->getValue();
            $newobspost["row{$true_row}*observacion_{$lifeform}*cientifico"] = $spreadsheet->getSheetByName($sheetobs)->getCell("B{$row_number}")->getValue();
            $newobspost["row{$true_row}*observacion_{$lifeform}*radio_0_30m"] = $spreadsheet->getSheetByName($sheetobs)->getCell("C{$row_number}")->getValue();
            $newobspost["row{$true_row}*observacion_{$lifeform}*radio_30m_o_mas"] = $spreadsheet->getSheetByName($sheetobs)->getCell("D{$row_number}")->getValue();
            $newobspost["row{$true_row}*observacion_{$lifeform}*actividad"] = $spreadsheet->getSheetByName($sheetobs)->getCell("E{$row_number}")->getValue();
            $newobspost["row{$true_row}*observacion_{$lifeform}*especie_arbol"] = $spreadsheet->getSheetByName($sheetobs)->getCell("F{$row_number}")->getValue();
            $newobspost["row{$true_row}*observacion_{$lifeform}*especie_arbusto"] = $spreadsheet->getSheetByName($sheetobs)->getCell("G{$row_number}")->getValue();
            $newobspost["row{$true_row}*observacion_{$lifeform}*fo_arbol"] = $spreadsheet->getSheetByName($sheetobs)->getCell("H{$row_number}")->getValue();
            $newobspost["row{$true_row}*observacion_{$lifeform}*fo_arbusto"] = $spreadsheet->getSheetByName($sheetobs)->getCell("I{$row_number}")->getValue();
            $newobspost["row{$true_row}*observacion_{$lifeform}*tr_arbol"] = $spreadsheet->getSheetByName($sheetobs)->getCell("J{$row_number}")->getValue();
            $newobspost["row{$true_row}*observacion_{$lifeform}*tr_arbusto"] = $spreadsheet->getSheetByName($sheetobs)->getCell("K{$row_number}")->getValue();
            $newobspost["row{$true_row}*observacion_{$lifeform}*ro"] = $spreadsheet->getSheetByName($sheetobs)->getCell("L{$row_number}")->getValue();
            $newobspost["row{$true_row}*observacion_{$lifeform}*su"] = $spreadsheet->getSheetByName($sheetobs)->getCell("M{$row_number}")->getValue();
            $newobspost["row{$true_row}*observacion_{$lifeform}*notas"] = $spreadsheet->getSheetByName($sheetobs)->getCell("M{$row_number}")->getValue();

            $newobspost["row{$true_row}*observacion_{$lifeform}*foto"] = $spreadsheet->getSheetByName($sheetobs)->getCell("O{$row_number}")->getValue();
          }
          $row_number++;
          if ($row_number>100){
            break;
            echo 'failed';
          }
        }
        echo var_dump($newobspost);
        echo var_dump($_FILES);

        savedata($newobspost,$useremail,true);
      }//end AVES









    }






    break;
  }

    



}
    

session(['error' => $errorlist]);
?>