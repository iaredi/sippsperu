<?php
  use PhpOffice\PhpSpreadsheet\IOFactory;
  $errorlist=[];
  if ($_SERVER['REQUEST_METHOD']=="POST") {
      if ($_FILES['excelFromUser']['name']=='') {
        $errorlist[]= "No hay excel";
      }
      if ($_POST['selectlinea_mtp']=='notselected') {
        $errorlist[]= "Los menus desplegables no deben estar vacios";
      }
      //Upload fotos

      

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


        $obspostarray = [];
        $uploadfotoarray = [];
        //Begin saving observations
        foreach ($worksheetNames as $sheet) {
          //LOC
          if (strpos($sheet, 'LOC') !== false){
            $obspost = array('selectlinea_mtp' => $_POST['selectlinea_mtp']);
            $obspost['mode']='Datos Nuevos';
            $obspost['submit']='submit';
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
            $obspost['selectobservaciones'] = $lifeform;
            $given_number = explode("_" , $sheet)[2];
            if ($lifeform=='arbol'||$lifeform=='arbusto'){
              $obspost["selectTransecto"] = ceil($given_number/8);
              $obspost["select{$transpuntoup}"]=$given_number - 8*($obspost["selectTransecto"]-1);
            }else{
              $obspost["select{$transpuntoup}"] = $given_number;
            }

            //get loc values
            $letter = 'A';
            while(true){
              $loccolvalue = strtolower(trim($spreadsheet->getSheetByName($sheet)->getCell("{$letter}1")->getValue()));
              if ($loccolvalue==NULL){
                break;
              }else{
                $locvalue = trim($spreadsheet->getSheetByName($sheet)->getCell("{$letter}2")->getValue());
                
                $obspost["row0*{$transpunto}_{$lifeform}*{$loccolvalue}"] = $locvalue;
                
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
                $obscolumnarray[] = strtolower(trim($value2));
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
                  $obsvalue = trim($spreadsheet->getSheetByName($sheetobs)->getCell("{$letter}{$row_number}")->getValue());

                  if (strpos($obscolumn, 'iden_foto') !== false){
                    if($obsvalue==NULL){
                      $obsvalue = "No Presentado";
                    }else{
                      $uploadfotoarray[$obsvalue]="observacion_{$lifeform}";
                      $obsvalue="observacion_{$lifeform}_{$obsvalue}";
                      
                    }
                  }

                  if($obscolumn=='cientifico'){
                    if ($obsvalue==NULL){
                      break;
                    }else{
                      $cientifico = $spreadsheet->getSheetByName($sheetobs)->getCell("{$letter}{$row_number}")->getValue();
                      $obspost["row{$true_row}*observacion_{$lifeform}*species"]="Nuevo";
                      if(sizeof(DB::select("SELECT cientifico FROM especie_{$lifeform} WHERE cientifico=:value", [':value'=>$cientifico]))>0){
                        $obspost["row{$true_row}*observacion_{$lifeform}*species"]=$cientifico;
                      }
                    }
                  }
                  
                  $obspost["row{$true_row}*observacion_{$lifeform}*{$obscolumn}"] = $obsvalue;
                  $letter = ++$letter;
                }//end scan across columns
                $row_number=$row_number+1;
                }
            }//end scan rows of observacions
            $obspostarray[]=$obspost;
        }//end if LOC
      }//end looping through sheets

      //look at fotos
      $newpost=["submit"=>"true"];

      foreach ($uploadfotoarray as $fotonameexcel => $fotolifeform) {
        $foundfoto=false;
        $fotonum=0;
        foreach ($_FILES['photosFromUser']["name"] as $fotonamefile) {
          if ($fotonameexcel==$fotonamefile){
            $foundfoto=true;
            $iden_foto_result = uploadfoto($newpost,$fotonamefile, $_FILES["photosFromUser"]["tmp_name"][$fotonum], $_FILES["photosFromUser"]["size"][$fotonum], $fotolifeform);
            if ($iden_foto_result != $fotolifeform ."_". $fotonamefile){
              $errorlist[]=$iden_foto_result;
            }
          }
        $fotonum++;
        }
        if (!$foundfoto){
          $errorlist[]="{$fotonameexcel} no fue encontrado. Hay que subir fotos con los mismos nombres de los que estan en excel";
        }
      }
      
      //save all if no errors
      echo var_dump($errorlist);
      if(sizeof($errorlist)==0){
        $newmedicion = savedata($medicionpost,$_FILES, $useremail,true);
        foreach ($obspostarray as $currentobspost) {
          $currentobspost['selectmedicion'] = $newmedicion;
          $saveworked = savedata($currentobspost,$useremail,true);
          if ($saveworked=="false"){
            $errorlist[]="Hubo una problema guandando datos";
          }
        }
      }
  }//end if no errors
  if(sizeof($errorlist)==0){
    redirect()->to('/thanks')->send();
  }
}//end if post
  session(['error' => $errorlist]);
?>