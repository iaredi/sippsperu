
<?php
$resultofquery=[];
if ($_SERVER['REQUEST_METHOD']=="POST"&& sizeof(session('error'))==0){

    $mtpchoice =$_POST['selectlinea_mtp'];    
    //$mtpchoice = $_POST['selectlinea_mtp'];      
    if ($mtpchoice=="Nuevo") {
        //Save New Estado Data
        $estadochoice = $_POST['selectestado'];
        
        if ($estadochoice=="Nuevo") {
            $estadocolumns=array(
            "clave"=> $_POST['row0*estado*clave'],
            "nombre"=> $_POST['row0*estado*nombre']
                );
            $resultofquery[]= savenewentry("estado", $estadocolumns);
        }

        //Save New Municipio Data
        $municipiochoice = $_POST['selectmunicipio'];  
        if ($municipiochoice=="Nuevo") {
            if ($estadochoice=="Nuevo") {
                $municipiofkey=$_POST['row0*estado*clave'];
            }else{
                $municipiofkey=askforkey("estado", "clave", "nombre", $_POST['selectestado']);
            }
            $municipiocolumns=array(
            "clave"=> $_POST['row0*municipio*clave'],
            "nombre"=> "{$municipiofkey} -->{$_POST['row0*municipio*nombre']}",
            "clave_estado"=> $municipiofkey
                );
            $resultofquery[]= savenewentry("municipio", $municipiocolumns);
                }

        //Save New Predio Data
        $prediochoice = $_POST['selectpredio'];
        if ($prediochoice=="Nuevo") {
            if ($municipiochoice=="Nuevo") {
                $prediofkey=$_POST['row0*municipio*clave'];
            }else{
                $prediofkey=askforkey("municipio", "clave", "nombre", $_POST['selectmunicipio']);
            }
            $prediocolumns=array(
            "clave"=> $_POST['row0*predio*clave'],
            "nombre"=> $_POST['row0*predio*nombre'],
            "direccion"=> $_POST['row0*predio*direccion'],
            "superficie"=> $_POST['row0*predio*superficie'],
            "telefono"=> $_POST['row0*predio*telefono'],
            "clave_municipio"=> $prediofkey
                );
            $resultofquery[]= savenewentry("predio", $prediocolumns);
                }

            //Save Lat/Long Rows
            if ($prediochoice=="Nuevo") {
                $linea_mtpfkey=$_POST['row0*predio*clave'];
                $linea_mtppredioname=$_POST['row0*predio*nombre'];
            }else{
                $linea_mtpfkey=askforkey("predio", "clave", "nombre", $_POST['selectpredio']);
                $linea_mtppredioname=$_POST['selectpredio'];
            }
            
            for($i=0; $i<countrows("linea_mtp"); $i++) {
                $comienzo_longitud = $_POST["row{$i}*linea_mtp*comienzo_longitud"];
                $fin_longitud = $_POST["row{$i}*linea_mtp*fin_longitud"];
                $comienzo_latitud = $_POST["row{$i}*linea_mtp*comienzo_latitud"];
                $fin_latitud = $_POST["row{$i}*linea_mtp*fin_latitud"];
                $linea_mtpcolumns=array(
                    "comienzo_longitud"=> $comienzo_longitud,
                    "fin_longitud"=> $fin_longitud,
                    "comienzo_latitud"=> $comienzo_latitud,
                    "fin_latitud"=> $fin_latitud,
                    "nombre_iden"=> "{$linea_mtppredioname} ({$comienzo_latitud},{$comienzo_longitud}) ({$fin_latitud},{$fin_longitud})",
                    "clave_predio"=> $linea_mtpfkey,
                    "iden_unidad_de_paisaje"=> "notset"
                        );
                    $resultofquery[]= savenewentry("linea_mtp", $linea_mtpcolumns);
                    $max_line = getserialmax( "linea_mtp");
                //Save Line
                if (is_numeric($comienzo_longitud) && is_numeric($comienzo_latitud) && is_numeric($fin_longitud) && is_numeric($fin_latitud)){
                    $sql = "INSERT INTO linea_mtp_4326 (iden_linea_mtp, geom) SELECT {$max_line}, ST_GeomFromText('MultiLineString(({$comienzo_longitud} {$comienzo_latitud}, {$fin_longitud} {$fin_latitud}))',4326)";
                    $stmnt = DB::insert($sql, []);
                    //Save Linking table
                    $sql = "SELECT udp_puebla_4326.iden FROM udp_puebla_4326 WHERE ST_Crosses(udp_puebla_4326.geom,  ST_GeomFromText('MultiLineString(({$comienzo_longitud} {$comienzo_latitud}, {$fin_longitud} {$fin_latitud}))',4326))";
                    $result = DB::select($sql, []);
                    foreach($result as $row) {
                        $linea_mtp_udp=array(
                            "iden_linea_mtp"=> $max_line,
                            "iden_udp_puebla_4326"=> $row->iden
                                );
                        $resultofquery[]= savenewentry("linea_mtp_udp", $linea_mtp_udp,false);
                    }
                }
            }




   } else {
        $medicionchoice = $_POST['selectmedicion'];
        session(['my_linea_mtp' => $_POST['selectlinea_mtp']]);
        if ($medicionchoice=="Nuevo") {
        //Save Medicion Data  

            $medicionfkey=askforkey("linea_mtp", "iden", "nombre_iden", $_POST['selectlinea_mtp']);

            $linea_mtpclave_predio=askforkey("linea_mtp", "clave_predio", "nombre_iden", $_POST['selectlinea_mtp']);
            $predioname=askforkey("predio", "nombre", "clave", $linea_mtpclave_predio);
            $medicioncolumns=array(
                "iden_linea_mtp"=>$medicionfkey,
                "fecha"=> $_POST['row0*medicion*fecha'],
                "iden_nombre"=> $predioname."*".$_POST['row0*medicion*fecha']
            );
            $resultofquery[]= savenewentry("medicion", $medicioncolumns);
            $max_medicion = getserialmax( "medicion");


            //Save New People and Brigada Data  
            $max_medicion = getserialmax( "medicion");
            for($i=0; $i<countrows("personas"); $i++) {
                $personascolumns=array(
                        "nombre"=> $_POST["row{$i}*personas*nombre"],
                        "apellido_materno"=> $_POST["row{$i}*personas*apellido_materno"],
                        "apellido_paterno"=> $_POST["row{$i}*personas*apellido_paterno"],
                            );
                        $resultofquery[] = savenewentry("personas", $personascolumns);
                        $brigada_array=array(
                            "iden_medicion"=> $max_medicion,
                            "iden_personas"=> getserialmax( "personas")
                                );
                        $resultofquery[] = savenewentry("brigada", $brigada_array);
                }
            //Save GPS Data  
            for($i=0; $i<countrows("gps"); $i++) {
                $gpscolumns=array(
                    "anio"=> $_POST["row{$i}*gps*anio"],
                    "marca"=> $_POST["row{$i}*gps*marca"],
                    "modelo"=> $_POST["row{$i}*gps*modelo"],
                    "numero_de_serie"=> $_POST["row{$i}*gps*numero_de_serie"],
                        );
                    $resultofquery[] = savenewentry("gps", $gpscolumns);

                    $gps_medicion_array=array(
                        "iden_medicion"=> $max_medicion,
                        "iden_gps"=> getserialmax( "gps")
                            );
                    $resultofquery[] = savenewentry("gps_medicion", $gps_medicion_array);
            }
            //Save Camara Data  
            for($i=0; $i<countrows("camara"); $i++) {
                $camaracolumns=array(
                    "anio"=> $_POST["row{$i}*camara*anio"],
                    "marca"=> $_POST["row{$i}*camara*marca"],
                    "modelo"=> $_POST["row{$i}*camara*modelo"],
                    "numero_de_serie"=> $_POST["row{$i}*camara*numero_de_serie"],
                        );
                    $resultofquery[] = savenewentry("camara", $camaracolumns);

                    $camara_medicion_array=array(
                        "iden_medicion"=> $max_medicion,
                        "iden_camara"=> getserialmax( "camara")
                            );
                    $resultofquery[] = savenewentry("camara_medicion", $camara_medicion_array);
            }

            
        }else{
            session(['my_medicion' => $_POST['selectmedicion']]);
            //Existing Medicion
            $medicionkey=askforkey("medicion", "iden", "iden_nombre", $_POST['selectmedicion']);
            $obstype= 'observacion_'.$_POST['selectobservaciones'];
            $speciestype=  explode("_" , $obstype)[1];
            $speciestable="especie_".$speciestype;
            
            //AVE------------------------------------------------------------------------------------------------------------------------
            if ($obstype=='observacion_ave'){
                //Handle Punto 
                $unit='Punto';
                $unitlower=strtolower($unit);
                $unitnum= $_POST["select{$unit}"];  
                $unitcolumns=array(
                    "sampling_unit_point"=> $unitnum,
                    "latitud_gps"=> $_POST["row0*{$obstype}*latitud_gps"],
                    "longitud_gps"=> $_POST["row0*{$obstype}*longitud_gps"],
                    "tipo_vegetacion"=> $_POST["row0*{$obstype}*tipo_vegetacion"],
                    "letra_m"=> $_POST["row0*{$obstype}*m"],
                    "letra_e"=> $_POST["row0*{$obstype}*e"],
                    "ts_y_ac"=> $_POST["row0*{$obstype}*ts_y_ac"],
                    "estado_del_tiempo"=> $_POST["row0*{$obstype}*estado_del_tiempo"],
                    "hora_inicio"=> $_POST["row0*{$obstype}*hora_inicio"],
                    "hora_fin"=> $_POST["row0*{$obstype}*hora_fin"],
                    "iden_medicion"=> $medicionkey,
                    
                        );
                $resultofquery[] = savenewentry("{$unitlower}_{$speciestype}", $unitcolumns);
                //Handle ave Species
                $unitmax=getserialmax( "{$unitlower}_{$speciestype}");
                for($i=0; $i<countrows($obstype); $i++){
                    //Handle fotos
                    $iden_foto=uploadfoto("row{$i}", $obstype);
                    //$iden_foto='0000';
                    //Handle Species
                    $especiechoice= $_POST["row{$i}*{$obstype}*species"];
                    if ($especiechoice=="Nuevo") {
                        $iden_especie=savenewspecies( $speciestable,$_POST["row{$i}*{$obstype}*comun"],$_POST["row{$i}*{$obstype}*cientifico"] );
                    }else{
                        $iden_especie=askforkey( $speciestable, "iden", "comun_cientifico", $especiechoice);
                    }
                    
                    $obscolumns=array(
                        "actividad"=> $_POST["row{$i}*{$obstype}*actividad"],
                        "tr_arbol"=> $_POST["row{$i}*{$obstype}*tr_arbol"],
                        "tr_arbusto"=> $_POST["row{$i}*{$obstype}*tr_arbusto"],
                        "fo_arbol"=> $_POST["row{$i}*{$obstype}*fo_arbol"],
                        "fo_arbusto"=> $_POST["row{$i}*{$obstype}*fo_arbusto"],
                        "su"=> $_POST["row{$i}*{$obstype}*su"],
                        "ro"=> $_POST["row{$i}*{$obstype}*ro"],
                        "notas"=> $_POST["row{$i}*{$obstype}*notas"],
                        "abundancia_0_5_min"=> $_POST["row{$i}*{$obstype}*abundancia_0-5_min"],
                        "abundancia_5_10_min"=> $_POST["row{$i}*{$obstype}*abundancia_5-10_min"],
                        "iden_especie"=> $iden_especie,
                        "iden_foto"=> $iden_foto,
                        "iden_{$unitlower}"=> $unitmax,
                            );
                    $resultofquery[] = savenewentry($obstype, $obscolumns);
                }
            }

            //Hierba------------------------------------------------------------------------------------------------------------------------
            if ($obstype=='observacion_hierba'){
                //Handle Transecto
                $unit='Transecto';
                $unitlower=strtolower($unit);
                $unitnum= $_POST["select{$unit}"];  
               
                $unitcolumns=array(
                    "sampling_unit"=> $unitnum,
                    "comienzo_latitud"=> $_POST["row0*{$obstype}*comienzo_latitud"],
                    "comienzo_longitud"=> $_POST["row0*{$obstype}*comienzo_longitud"],
                    "fin_latitud"=> $_POST["row0*{$obstype}*fin_latitud"],
                    "fin_longitud"=> $_POST["row0*{$obstype}*fin_longitud"],
                    "iden_medicion"=> $medicionkey,
                    
                        );
                $resultofquery[] = savenewentry("{$unitlower}_{$speciestype}", $unitcolumns);

                $unitmax=getserialmax( "{$unitlower}_{$speciestype}");
                for($i=0; $i<countrows($obstype); $i++) {
                    //Handle fotos
                    $iden_foto=uploadfoto("row{$i}", $obstype);
                    //Handle Species
                    $especiechoice= $_POST["row{$i}*{$obstype}*species"];
                    if ($especiechoice=="Nuevo") {
                        $iden_especie=savenewspecies( $speciestable,$_POST["row{$i}*{$obstype}*comun"],$_POST["row{$i}*{$obstype}*cientifico"] );
                    }else{
                        $iden_especie=askforkey( $speciestable, "iden", "comun_cientifico", $especiechoice);
                    }
                    $obscolumns=array(
                        "ind"=> $_POST["row{$i}*{$obstype}*ind"],
                        "letra_m"=> $_POST["row{$i}*{$obstype}*m"],
                        "letra_i"=> $_POST["row{$i}*{$obstype}*i"],
                        "notas"=> $_POST["row{$i}*{$obstype}*notas"],
                        "iden_especie"=> $iden_especie,
                        "iden_foto"=> $iden_foto,
                        "iden_{$unitlower}"=> $unitmax,
                            );
                    $resultofquery[] = savenewentry( $obstype, $obscolumns);
                }
            }
                //Arbol y Arbusto------------------------------------------------------------------------------------------------------------------------
                if ($obstype=='observacion_arbol'||$obstype=='observacion_arbusto'){
                //Handle Transecto
                $unit='Punto';
                $unitlower=strtolower($unit);
                $unitnum= $_POST["select{$unit}"];  
                $unitcolumns=array(
                    "sampling_unit"=> $unitnum,
                    "latitud_gps"=> $_POST["row0*{$obstype}*latitud_gps"],
                    "longitud_gps"=> $_POST["row0*{$obstype}*longitud_gps"],
                    "letra_n"=> $_POST["row0*{$obstype}*n"],
                    "letra_a"=> $_POST["row0*{$obstype}*a"],
                    "letra_m"=> $_POST["row0*{$obstype}*m"],
                    "letra_e"=> $_POST["row0*{$obstype}*e"],
                    
                    "numero_punto62"=> $_POST["selectPunto"],
                    "iden_medicion"=> $medicionkey,
                        );
                $resultofquery[] = savenewentry("{$unitlower}_{$speciestype}", $unitcolumns);

                $unitmax=getserialmax( "{$unitlower}_{$speciestype}");
            for($i=0; $i<countrows($obstype); $i++) {
                    //Handle fotos
                    $iden_foto=uploadfoto("row{$i}", $obstype);
                    //Handle Species
                    $especiechoice= $_POST["row{$i}*{$obstype}*species"];
                    if ($especiechoice=="Nuevo") {
                        $iden_especie=savenewspecies( $speciestable,$_POST["row{$i}*{$obstype}*comun"],$_POST["row{$i}*{$obstype}*cientifico"] );
                    }else{
                        $iden_especie=askforkey( $speciestable, "iden", "comun_cientifico", $especiechoice);
                    }
                    
                    $obscolumns=array(
                        "distancia"=> $_POST["row{$i}*{$obstype}*distancia"],
                        "azimut"=> $_POST["row{$i}*{$obstype}*azimut"],
                        "altura"=> $_POST["row{$i}*{$obstype}*altura"],
                        "dn"=> $_POST["row{$i}*{$obstype}*dn"],
                        "acc1"=> $_POST["row{$i}*{$obstype}*acc1"],
                        "acc2"=> $_POST["row{$i}*{$obstype}*acc2"],
                        "acc3"=> $_POST["row{$i}*{$obstype}*acc3"],
                        "dc1"=> $_POST["row{$i}*{$obstype}*dc1"],
                        "dc2"=> $_POST["row{$i}*{$obstype}*dc2"],
                        "cuadrante"=> $_POST["row{$i}cuadrante"],
                        "notas"=> $_POST["row{$i}*{$obstype}*notas"],
                        "iden_especie"=> $iden_especie,
                        "iden_foto"=> $iden_foto,
                        "iden_{$unitlower}"=> $unitmax,
                            );
                    $resultofquery[] = savenewentry( $obstype, $obscolumns);
                }
            }

            //Herpetofauna------------------------------------------------------------------------------------------------------------------------
            if ($obstype=='observacion_herpetofauna'){
                //Handle Transecto
                $unit='Transecto';
                $unitlower=strtolower($unit);
                $unitnum= $_POST["select{$unit}"];  
                $unitcolumns=array(
                    "sampling_unit"=> $unitnum,
                    "comienzo_latitud"=> $_POST["row0*{$obstype}*comienzo_latitud"],
                    "comienzo_longitud"=> $_POST["row0*{$obstype}*comienzo_longitud"],
                    "fin_latitud"=> $_POST["row0*{$obstype}*fin_latitud"],
                    "fin_longitud"=> $_POST["row0*{$obstype}*fin_longitud"],
                    "estado_del_tiempo"=> $_POST["row0*{$obstype}*estado_del_tiempo"],
                    "iden_medicion"=> $medicionkey,
                        );
                $resultofquery[] = savenewentry("{$unitlower}_{$speciestype}", $unitcolumns);

                $unitmax=getserialmax( "{$unitlower}_{$speciestype}");
                for($i=0; $i<countrows($obstype); $i++) {
                    //Handle fotos
                    $iden_foto=uploadfoto("row{$i}", $obstype);
                    //Handle Species
                    $especiechoice= $_POST["row{$i}*{$obstype}*species"];
                    if ($especiechoice=="Nuevo") {
                        $iden_especie=savenewspecies( $speciestable,$_POST["row{$i}*{$obstype}*comun"],$_POST["row{$i}*{$obstype}*cientifico"] );
                    }else{
                        $iden_especie=askforkey( $speciestable, "iden", "comun_cientifico", $especiechoice);
                    }
                    $obscolumns=array(
                        "sexo"=> $_POST["row{$i}*{$obstype}*sexo"],
                        "estadio"=> $_POST["row{$i}*{$obstype}*estadio"],
                        "actividad"=> $_POST["row{$i}*{$obstype}*actividad"],
                        "microhabitat"=> $_POST["row{$i}*{$obstype}*microhabitat"],
                        "hora"=> $_POST["row{$i}*{$obstype}*hora"],
                        "iden_especie"=> $iden_especie,
                        "iden_foto"=> $iden_foto,
                        "iden_{$unitlower}"=> $unitmax,
                            );
                    $resultofquery[] = savenewentry( $obstype, $obscolumns);
                }
            }

                //MAMIFERO------------------------------------------------------------------------------------------------------------------------
                if ($obstype=='observacion_mamifero'){
                //Handle Punto 
                $unit='Punto';
                $unitlower=strtolower($unit);
                $unitnum= $_POST["select{$unit}"];  
                $unitcolumns=array(
                    "sampling_unit_point"=> $unitnum,
                    "latitud_gps"=> $_POST["row0*{$obstype}*latitud_gps"],
                    "longitud_gps"=> $_POST["row0*{$obstype}*longitud_gps"],
                    "tipo_vegetacion"=> $_POST["row0*{$obstype}*tipo_vegetacion"],
                    "anio"=> $_POST["row0*{$obstype}*anio"],
                    "marca"=> $_POST["row0*{$obstype}*marca"],
                    "modelo"=> $_POST["row0*{$obstype}*modelo"],
                    "fecha_de_activacion"=> $_POST["row0*{$obstype}*fecha_de_activacion"],
                    "fecha_de_apagado"=> $_POST["row0*{$obstype}*fecha_de_apagado"],
                    "numero_de_dias_operables"=> $_POST["row0*{$obstype}*numero_de_dias_operables"],
                    "numero_de_fotos_totales"=> $_POST["row0*{$obstype}*numero_de_fotos_totales"],
                    "numero_de_fotos_efectivas"=> $_POST["row0*{$obstype}*numero_de_fotos_efectivas"],
                    "iden_medicion"=> $medicionkey,
                    
                        );
                $resultofquery[] = savenewentry("{$unitlower}_{$speciestype}", $unitcolumns);
                //Handle Species
                $unitmax=getserialmax( "{$unitlower}_{$speciestype}");
                for($i=0; $i<countrows($obstype); $i++) {
                    //Handle fotos
                    $iden_foto=uploadfoto("row{$i}", $obstype);
                    //Handle Species
                    $especiechoice= $_POST["row{$i}*{$obstype}*species"];
                    if ($especiechoice=="Nuevo") {
                        $iden_especie=savenewspecies( $speciestable,$_POST["row{$i}*{$obstype}*comun"],$_POST["row{$i}*{$obstype}*cientifico"] );
                    }else{
                        $iden_especie=askforkey( $speciestable, "iden", "comun_cientifico", $especiechoice);
                    }
                    
                    $obscolumns=array(
                        "numero_de_repeticion"=> $_POST["row{$i}*{$obstype}*numero_de_repeticion"],
                        "fecha_de_captura"=> $_POST["row{$i}*{$obstype}*fecha_de_captura"],
                        "hora_de_captura"=> $_POST["row{$i}*{$obstype}*hora_de_captura"],
                        "numero_de_individulos_capturados"=> $_POST["row{$i}*{$obstype}*numero_de_individulos_capturados"],
                        "numero_de_foto"=> $_POST["row{$i}*{$obstype}*numero_de_foto"],
                        "etapa_de_vida"=> $_POST["row{$i}*{$obstype}*etapa_de_vida"],
                        "sexo"=> $_POST["row{$i}*{$obstype}*sexo"],
                        "notas"=> $_POST["row{$i}*{$obstype}*notas"],
                        "iden_especie"=> $iden_especie,
                        "iden_foto"=> $iden_foto,
                        "iden_{$unitlower}"=> $unitmax,
                    );
                    $resultofquery[] = savenewentry( $obstype, $obscolumns);
                }
            }

        }







   }

        echo '<script>console.log('.json_encode($resultofquery).');</script>';


}
?>