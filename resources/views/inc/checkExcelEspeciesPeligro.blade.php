<?php

  use PhpOffice\PhpSpreadsheet\IOFactory;
  session(['error' => []]);
function guardarEspeciesPeligro (){
    $atLeastOneOk=false;
    $errorlist=[];
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
		$sheetnames = $spreadsheet->getSheetNames();
		if(!isset($sheetnames[0])){
			$errorlist[]="No existe la hoja de datos. Por favor, cargue el archivo de lista de expecies en peligro de exinci&oacute;n.";
		}else{
            $error="";
            //verificando el tituloHeader del archivo
            $titulosHeader=['forma de vida','orden','familia','genero','especie','subespecie','sinonimia','nombre','distribucion','categoria','metodo'];
            $letrasColumnas=['A','B','C','D','E','F','G','H','I','J','K'];
            foreach($titulosHeader as $i=>$tituloHeader){
                $letraColumna=$letrasColumnas[$i];
                $headerColumna=strtolower(trim($spreadsheet->getActiveSheet()->getCell("{$letraColumna}1")->getValue()));
                $headerColumna=str_replace(['í','ó','é'],['i','o','e'],$headerColumna);
                if($tituloHeader!=$headerColumna){
                    $errorlist[]="No se reconoce el formato del archivo (revise el encabezado de la columna {$letraColumna}). Por favor suba la lista de especies en peligro de extinci&oacute;n.";
                    break;
                }
            }
            if(!isset($errorlist[0])){//si no hay errroes en el encabezado
                //id del usuario actual
                $userId=DB::select('select iden from usuario where email = ?', [session('email')])[0]->iden;
                if($userId){
                    $catVidaRiesgo=['ave','herpeto','mamifero','planta'];
                    $camposRequeridos='forma de vida,genero,especie';

                    $sql3[]="";
                    $sqls=['ave'=>'','herpeto'=>'','mamifero'=>'','planta'=>''];              
                    //while recorre las filas
                    $numFilas=$spreadsheet->getActiveSheet()->getHighestRow();
                    for($rownum=2; $rownum<=$numFilas;$rownum++){
                        $ignorarFila=false;
                        //foreach recorre las columnas
                        $especieFila="";
                        $sql="(";
                        foreach($letrasColumnas as $iColumn=>$letraColumna){
                            $tituloHeader=$titulosHeader[$iColumn];
                            $valorCelda=strtolower(trim($spreadsheet->getActiveSheet()->getCell("{$letraColumna}{$rownum}")->getValue()));
                            
                            //si algun campo obligatorio está vacío
                            if(strpos($camposRequeridos,$tituloHeader)>=0 && ($valorCelda==NULL || $valorCelda=="")){
                                $errorlist[]="No se pudo procesar la fila {$rownum} porque hay un campo que es obligatorio que no fue especificado.";
                                $ignorarFila=true;
                                break;
                            }else{
                                if($valorCelda==NULL){
                                    $sql.="'',";
                                }else{
                                    //se define la especie de la fila
                                    if($tituloHeader=='forma de vida'){
                                        $especieFila=str_replace(['á','í','herpetofauna'],['a','i','herpeto'],$valorCelda);
                                        if($especieFila=='arbusto'||$especieFila=='arbol'){
                                            $especieFila='planta';
                                        }
                                    
                                        if($especieFila!='ave'&&$especieFila!='mamifero'&&$especieFila!='herpeto'&&$especieFila!='planta'){
                                            $error.="No se pudo guardar el registro en la fila {$rownum} porque no se reconoce el valor en la columna <i>Tipo de Vida</i>.";
                                            $ignorarFila=true;
                                            break;
                                        }
                                    }else{
                                        $sql.="'{$valorCelda}',";
                                    }
                                }
                            }
                        }

                        if($ignorarFila){
                            continue;
                        }

                        $sql=substr($sql,0,strlen($sql)-1).')';
                        $sqls[$especieFila].="{$sql},";
                    }
                    //se jecutan los inserts
                    foreach($sqls as $i=>$sql){
                        $sql=substr($sql,0,strlen($sql)-1);
                        if($sql!=""){
                            if($i=='herpeto'){
                                $i='herpetofauna';
                            }
                            $completesql= "INSERT INTO riesgo_{$i}
                                (orden,familia,genero,especie,subespecie,sinonimia,nombre,distribution,categoria,metodo) 
                                VALUES ".$sql.";";
                            Log::info($completesql);
                            //se vacia la tabla
                            DB::statement("TRUNCATE TABLE riesgo_{$i};");
                            //se sustituye con la nueva lista
                            $results = DB::insert($completesql, []);
                            
                            if(!$atLeastOneOk && $results){
                                $atLeastOneOk=true;
                            }elseif(!$results){
                                $errorlist[]="Ocurrió un error al guardar la especie {$i}. Por favor vuelva a cargar estos registros.";
                            }
                        }
                    }
                }else{
                    //si no se encuentra al usuario en al sesión,
                    //se destruye la sesión y se forza al usuario a reiniciar sesión.
                    return redirect()->to('/logout')->send();
                }
            }
        }
    }

    if($error!=""){
        $errorlist[]=$error;
    }
    $noErrors=count($errorlist);
    if($atLeastOneOk&&$noErrors==0){
        session(['msgType'=>"okMsg"]);
        session(['adminerror'=> ['Lista de especies en peligro de extinción actualizada.']]);
    }elseif($atLeastOneOk&&$noErrors>0){
        session(['adminerror'=> $errorlist]);
        session(['msgType'=>"warningMsg"]);
    }elseif(!$atLeastOneOk){
        session(['adminerror'=> $errorlist]);
        session(['msgType'=>"errorMsg"]);
    }
}
?>