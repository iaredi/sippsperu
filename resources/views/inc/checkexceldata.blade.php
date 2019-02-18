<?php
  use PhpOffice\PhpSpreadsheet\IOFactory;
  $errorlist=[];
  if ($_SERVER['REQUEST_METHOD']=="POST") {
    //echo var_dump($_FILES);
      if ($_FILES['excelFromUser']['name']=='') {
        $errorlist[]= "No hay excel";
      }
      if ($_POST['selectlinea_mtp']=='notselected') {
        $errorlist[]= "Los menus desplegables no deben estar vacios";
      }
      if(sizeof($errorlist)==0){
        $target_dir = "../storage/shp/";
        $target_file = $target_dir . basename($_FILES['excelFromUser']["name"]);
        $inputFileName = $_FILES['excelFromUser'];
        move_uploaded_file($_FILES['excelFromUser']["tmp_name"], $target_file);
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
        $worksheetNames = $reader->listWorksheetNames($target_file);
        $spreadsheet = $reader->load($target_file);

        $medicionpost = array('selectlinea_mtp' => $_POST['selectlinea_mtp']);
        $medicionpost['selectmedicion']='Nuevo';
        $day =  $spreadsheet->getSheetByName('MEDICION')->getCell('A3')->getValue();
        $month =  $spreadsheet->getSheetByName('MEDICION')->getCell('B3')->getValue();
        $year =  $spreadsheet->getSheetByName('MEDICION')->getCell('C3')->getValue();
        $medicionpost['row0*medicion*fecha'] ="{$year}-{$month}-{$day}";

        $brigadarownumber=3;
        while (true){
          $materno =  $spreadsheet->getSheetByName('MEDICION')->getCell("D{$brigadarownumber}")->getValue();
          $paterno =  $spreadsheet->getSheetByName('MEDICION')->getCell("E{$brigadarownumber}")->getValue();
          $nombre =  $spreadsheet->getSheetByName('MEDICION')->getCell("F{$brigadarownumber}")->getValue();
          if ($materno==NULL && $paterno==NULL && $nombre==NULL){
            break;
          }else{
            $rownum=$brigadarownumber-3;
            $medicionpost["row{$rownum}*personas*apellido_materno"]=$materno;
            $medicionpost["row{$rownum}*personas*apellido_paterno"]=$paterno;
            $medicionpost["row{$rownum}*personas*apellido_nombre"]=$nombre;
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
            $medicionpost["row{$rownum}*gps*anio"]=$anio;
            $medicionpost["row{$rownum}*gps*marca"]=$marca;
            $medicionpost["row{$rownum}*gps*modelo"]=$modelo;
            $medicionpost["row{$rownum}*gps*numero_de_serie"]=$numero_de_serie;
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
            $medicionpost["row{$rownum}*camara*anio"]=$anio;
            $medicionpost["row{$rownum}*camara*marca"]=$marca;
            $medicionpost["row{$rownum}*camara*modelo"]=$modelo;
            $medicionpost["row{$rownum}*camara*numero_de_serie"]=$numero_de_serie;
          }
          $camararownumber++;
        }

        echo var_dump($medicionpost); 
        $newmedicion = savedata($medicionpost,$useremail,true);

        //Begin saving observations
        foreach ($worksheetNames as $sheet) {
          $basepost = array('selectlinea_mtp' => $_POST['selectlinea_mtp']);
          $basepost['selectmedicion'] = $newmedicion;
          $basepost['mode']='Datos Nuevos';
          $basepost['submit']='submit';
          //LOC
          if (strpos($sheet, 'AVE_LOC') !== false){
            $lifeformraw = explode("_" , $sheet)[0];
            if ($lifeformraw=="AVE") $lifeform='ave';
            if ($lifeformraw=="ARBO") $lifeform='arbol';
            if ($lifeformraw=="ARBU") $lifeform='arbusto';
            if ($lifeformraw=="HIER") $lifeform='hierba';
            if ($lifeformraw=="MAMI") $lifeform='mamifero';
            if ($lifeformraw=="HERP") $lifeform='herpetofauna';

            $transpunto="punto";
            if ($lifeform=='hierba' || $lifeform=='herpetofauna'){
              $transpunto="transecto";
            }
            $transpuntoup=ucfirst($transpunto);
            $basepost['selectobservaciones'] = $lifeform;
            $given_number = explode("_" , $sheet)[2]
            if ($lifeform=='arbol'||$lifeform=='arbusto'){
              $basepost["selectTransecto"] =   ceil($given_number/8))
              $basepost["select{$transpuntoup}"]=$given_number - 8*(($basepost["selectTransecto"]-1)
            }

            $basepost["select{$transpuntoup}"] = explode("_" , $sheet)[2];

            //get loc values
            $letter = 'A';
            while(true){
              $value = $spreadsheet->getSheetByName($sheet)->getCell("{$letter}1")->getValue();
              if ($value==NULL){
                break;
              }else{
                $basepost["row0*{$transpunto}_{$lifeform}*{$value}"] = $spreadsheet->getSheetByName($sheet)->getCell("{$letter}2")->getValue();
                $letter = ++$letter;
              }
            }
        
            $sheetobs= str_replace("LOC","OBS",$sheet);
            $obscolumnarray=[];
            $letter = 'A';
            //scan columns to get column names
            while(true){
              $value2 = $spreadsheet->getSheetByName($sheetobs)->getCell("{$letter}1")->getValue();
              if ($value2 == NULL){
                break;
              }else{
                $obscolumnarray[] = $value2;
                $letter = ++$letter;
              }
            }
            //scan rows of observacions
            $row_number=2;
            while (true){
              if ($spreadsheet->getSheetByName($sheetobs)->getCell("B{$row_number}")->getValue()==NULL){
                break;
              }else{
                $true_row=$row_number-2;
                $letter = 'A';
                //scan across columns
                foreach ($obscolumnarray as $obscolumn) {
                  if($obscolumn=='cientifico'){
                    $cientifico = $spreadsheet->getSheetByName($sheetobs)->getCell("{$letter}{$row_number}")->getValue();
                    $basepost["row{$true_row}*observacion_{$lifeform}*species"]="Nuevo";
                    if(sizeof(DB::select("SELECT cientifico FROM especie_{$lifeform} WHERE cientifico=:value", [':value'=>$cientifico]))>0){
                      $basepost["row{$true_row}*observacion_{$lifeform}*species"]=$cientifico;
                    }
                  }
                  
                  $basepost["row{$true_row}*observacion_{$lifeform}*{$obscolumn}"] = $spreadsheet->getSheetByName($sheetobs)->getCell("{$letter}{$row_number}")->getValue();
                  $letter = ++$letter;
                }//end scan across columns
            
                $row_number=$row_number+1;
                echo $row_number;
                if ($row_number>10000){
                  break;
                  echo 'failed';
                  }
                }
            }//end scan rows of observacions
            echo var_dump($basepost);

            savedata($basepost,$useremail,true);
        }//end if LOC
      }//end looping through sheets
  }//end if no errors
}//end if post
  session(['error' => $errorlist]);
?>