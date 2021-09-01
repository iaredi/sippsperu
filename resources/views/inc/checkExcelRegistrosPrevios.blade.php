<?php

  use PhpOffice\PhpSpreadsheet\IOFactory;
  session(['error' => []]);
function guardarRegistrosPrevios (){
    $errorlist=[];
    $atLeastOneOk=false;
    
    if ($_FILES['excelFromUser']['name']=='') {
        $errorlist[]= "No se encuentra el archivo de excel.";
    }else{
        $target_dir = "../storage/shp/";
        $target_file = $target_dir . basename($_FILES['excelFromUser']["name"]);
        $inputFileName = $_FILES['excelFromUser'];
        move_uploaded_file($_FILES['excelFromUser']["tmp_name"], $target_file);
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
        $worksheetNames = $reader->listWorksheetNames($target_file);
        $spreadsheet = $reader->load($target_file);

        try{
            //verificando el header del archivo
            $headerGenero =  strtolower(trim($spreadsheet->getActiveSheet()->getCell('A1')->getValue()));
			$headerEspecie =  strtolower(trim($spreadsheet->getActiveSheet()->getCell('B1')->getValue()));
            $headerTipoEspecie =  strtolower(trim($spreadsheet->getActiveSheet()->getCell('C1')->getValue()));
            if(($headerGenero!="género"&&$headerGenero!="genero")||$headerEspecie!="especie"||$headerTipoEspecie!="forma de vida"){
                $errorlist[]="No se reconoce el formato del archivo. Por favor suba la lista de especies en registros previos.";
            }else{
                //id del usuario actual
                $userId=DB::select('select iden from usuario where email = ?', [session('email')])[0]->iden;
                if($userId){
                    $sql3="";

                    $sql="SELECT nombre, iden FROM especies;";
                    $catEspeciesId= DB::select($sql, []);
                    $catEspecies=array_column($catEspeciesId, 'nombre');
                    $catEspeciesId=array_column($catEspeciesId, 'iden');
                    $atLeastOneOk=false;
                    $numFilas=$spreadsheet->getActiveSheet()->getHighestRow();
                    for($rownum=2; $rownum<=$numFilas;$rownum++){
                        $genero =  strtolower(trim($spreadsheet->getActiveSheet()->getCell("A{$rownum}")->getValue()));
                        $especie =  strtolower(trim($spreadsheet->getActiveSheet()->getCell("B{$rownum}")->getValue()));
                        $tipoDeVida =  strtolower(trim($spreadsheet->getActiveSheet()->getCell("C{$rownum}")->getValue()));
                        if($genero=="" || $especie=="" ||$tipoDeVida==""){
                            $errorlist[]="No se pudo guardar el registro en la fila {$rownum} porque no está completo.";
                            continue;
                        }else{
                            $tipoDeVida=str_replace(['á','í','herpetofauna'],['a','í','herpeto'],$tipoDeVida);
                            $especieId=array_search($tipoDeVida,$catEspecies);
                            if(is_numeric($especieId)&&$especieId>=0){
                                $especieId=$catEspeciesId[$especieId];
                                $sql3.="('{$genero}', '{$especie}', {$userId}, CURRENT_DATE,{$especieId}),";
                            }else{
                                //no se reconoce el tipo de vida
                                $errorlist[]="No se pudo guardar el registro en las fila {$rownum} porque no se reconoce el valor en la columna <i>Tipo de Vida</i>.";
                            }
                        }
                    }
                    $sql3=substr($sql3,0,strlen($sql3)-1);//se quita la última coma
                    
                    //vaciar y guardar los nuevos registros en la tabla
                    $completesql= "INSERT INTO especies_registros_previos 
                    (genero, especie, user_iden, fecha_creacion, especie_iden) VALUES ".$sql3.";";
                    Log::info($completesql);
                    DB::statement("TRUNCATE TABLE especies_registros_previos;");
                    $results = DB::insert($completesql, []);
                    if(!$atLeastOneOk && $results){
                        $atLeastOneOk=true;
                        session(['msgType'=>"okMsg"]);
                    }else{
                        session(['msgType'=>"errorMsg"]);
                        $errorlist[]="Ocurri&oacute; un error al cargar la lista de especies en registro previo. Por favor int&eacute;ntelo de nuevo.";
                    }
                }else{
                    //si no se encuentra al usuario en al sesión,
                    //se destruye la sesión y se forza al usuario a reiniciar sesión.
                    return redirect()->to('/logout')->send();
                }
            }
        }catch(Exception $e){
            $errorlist[]="No existe la hoja de datos. Por favor, cargue el archivo de lista de especies en registros previos.";
        }
        
        $noErrors=count($errorlist);
        if($atLeastOneOk&&$noErrors==0){
            session(['msgType'=>"okMsg"]);
            session(['adminerror'=> ['Lista de especies en registros previos actualizada']]);
        }elseif($atLeastOneOk&&$noErrors>0){
            session(['adminerror'=> $errorlist]);
            session(['msgType'=>"warningMsg"]);
        }elseif(!$atLeastOneOk){
            session(['adminerror'=> $errorlist]);
            session(['msgType'=>"errorMsg"]);
        }
    }
}
?>