
<?php

if (sizeof($error)==0 && $_SERVER['REQUEST_METHOD']=="POST"){

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
            echo $municipiofkey;
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


        foreach(countrows("linea_mtp") as $myRow){

            $comienzo_longitud = $_POST["{$myRow}*linea_mtp*comienzo_longitud"];
            $fin_longitud = $_POST["{$myRow}*linea_mtp*fin_longitud"];
            $comienzo_latitud = $_POST["{$myRow}*linea_mtp*comienzo_latitud"];
            $fin_latitud = $_POST["{$myRow}*linea_mtp*fin_latitud"];

          
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
                $result = $sql = "SELECT udp_puebla_4326.iden FROM udp_puebla_4326 WHERE ST_Crosses(udp_puebla_4326.geom,  ST_GeomFromText('MultiLineString(({$comienzo_longitud} {$comienzo_latitud}, {$fin_longitud} {$fin_latitud}))',4326))";
                
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
    $_SESSION['my_linea_mtp']=$_POST['selectlinea_mtp'];    
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
        foreach(countrows("personas") as $myRow){
            $personascolumns=array(
                    "nombre"=> $_POST["{$myRow}*personas*nombre"],
                    "apellido_materno"=> $_POST["{$myRow}*personas*apellido_materno"],
                    "apellido_paterno"=> $_POST["{$myRow}*personas*apellido_paterno"],
                        );
                    $resultofquery[] = savenewentry("personas", $personascolumns);
                    $brigada_array=array(
                        "iden_medicion"=> $max_medicion,
                        "iden_personas"=> getserialmax( "personas")
                            );
                    $resultofquery[] = savenewentry("brigada", $brigada_array);
            }
        //Save GPS Data  
        foreach(countrows("gps") as $myRow){
            $gpscolumns=array(
                "anio"=> $_POST["{$myRow}*gps*anio"],
                "marca"=> $_POST["{$myRow}*gps*marca"],
                "modelo"=> $_POST["{$myRow}*gps*modelo"],
                "numero_de_serie"=> $_POST["{$myRow}*gps*numero_de_serie"],
                    );
                $resultofquery[] = savenewentry("gps", $gpscolumns);

                $gps_medicion_array=array(
                    "iden_medicion"=> $max_medicion,
                    "iden_gps"=> getserialmax( "gps")
                        );
                $resultofquery[] = savenewentry("gps_medicion", $gps_medicion_array);
        }
        //Save Camara Data  
        foreach(countrows("camara") as $myRow){
            $camaracolumns=array(
                "anio"=> $_POST["{$myRow}*camara*anio"],
                "marca"=> $_POST["{$myRow}*camara*marca"],
                "modelo"=> $_POST["{$myRow}*camara*modelo"],
                "numero_de_serie"=> $_POST["{$myRow}*camara*numero_de_serie"],
                    );
                $resultofquery[] = savenewentry("camara", $camaracolumns);

                $camara_medicion_array=array(
                    "iden_medicion"=> $max_medicion,
                    "iden_camara"=> getserialmax( "camara")
                        );
                $resultofquery[] = savenewentry("camara_medicion", $camara_medicion_array);
        }

        
    }else{
        $_SESSION['my_medicion']=$_POST['selectmedicion'];
        //Existing Medicion
        $medicionkey=askforkey("medicion", "iden", "iden_nombre", $_POST['selectmedicion']);
        $obstype= 'observacion_'.$_POST['selectobservaciones'];
        $speciestype=  explode("_" , $obstype)[1];
        $speciestable="especie_".$speciestype;
        $myRow='row0';
        
        //AVE------------------------------------------------------------------------------------------------------------------------
        if ($obstype=='observacion_ave'){
            //Handle Punto 
            $unit='Punto';
            $unitlower=strtolower($unit);
            $unitnum= $_POST["select{$unit}"];  
            $unitcolumns=array(
                "sampling_unit_point"=> $unitnum,
                "latitud_gps"=> $_POST["{$myRow}*{$obstype}*latitud_gps"],
                "longitud_gps"=> $_POST["{$myRow}*{$obstype}*longitud_gps"],
                "tipo_vegetacion"=> $_POST["{$myRow}*{$obstype}*tipo_vegetacion"],
                "letra_m"=> $_POST["{$myRow}*{$obstype}*m"],
                "letra_e"=> $_POST["{$myRow}*{$obstype}*e"],
                "ts_y_ac"=> $_POST["{$myRow}*{$obstype}*ts_y_ac"],
                "estado_del_tiempo"=> $_POST["{$myRow}*{$obstype}*estado_del_tiempo"],
                "hora_inicio"=> $_POST["{$myRow}*{$obstype}*hora_inicio"],
                "hora_fin"=> $_POST["{$myRow}*{$obstype}*hora_fin"],
                "iden_medicion"=> $medicionkey,
                
                    );
            $resultofquery[] = savenewentry("{$unitlower}_{$speciestype}", $unitcolumns);
            //Handle ave Species
            $unitmax=getserialmax( "{$unitlower}_{$speciestype}");
            foreach(countrows($obstype) as $myRow){
                //Handle fotos
                $iden_foto=uploadfoto($myRow, $obstype);
                //Handle Species
                $especiechoice= $_POST["{$myRow}*{$obstype}*species"];
                if ($especiechoice=="Nuevo") {
                    $iden_especie=savenewspecies( $speciestable,$_POST["{$myRow}*{$obstype}*comun"],$_POST["{$myRow}*{$obstype}*cientifico"] );
                }else{
                    $iden_especie=askforkey( $speciestable, "iden", "comun_cientifico", $especiechoice);
                }
                
                $obscolumns=array(
                    "actividad"=> $_POST["{$myRow}*{$obstype}*actividad"],
                    "tr_arbol"=> $_POST["{$myRow}*{$obstype}*tr_arbol"],
                    "tr_arbusto"=> $_POST["{$myRow}*{$obstype}*tr_arbusto"],
                    "fo_arbol"=> $_POST["{$myRow}*{$obstype}*fo_arbol"],
                    "fo_arbusto"=> $_POST["{$myRow}*{$obstype}*fo_arbusto"],
                    "su"=> $_POST["{$myRow}*{$obstype}*su"],
                    "ro"=> $_POST["{$myRow}*{$obstype}*ro"],
                    "notas"=> $_POST["{$myRow}*{$obstype}*notas"],
                    "abundancia_0_5_min"=> $_POST["{$myRow}*{$obstype}*abundancia_0-5_min"],
                    "abundancia_5_10_min"=> $_POST["{$myRow}*{$obstype}*abundancia_5-10_min"],
                    "iden_especie"=> $iden_especie,
                    "iden_foto"=> $iden_foto,
                    "iden_{$unitlower}"=> $unitmax,
                        );
                $resultofquery[] = savenewentry( $obstype, $obscolumns);
            }
        }

        //Hierba------------------------------------------------------------------------------------------------------------------------
        if ($obstype=='observacion_hierba'){
            //Handle Transecto
            $unit='Transecto';
            $unitlower=strtolower($unit);
            $unitnum= $_POST["select{$unit}"];  
            $myRow='row0';
            $unitcolumns=array(
                "sampling_unit"=> $unitnum,
                "comienzo_latitud"=> $_POST["{$myRow}*{$obstype}*comienzo_latitud"],
                "comienzo_longitud"=> $_POST["{$myRow}*{$obstype}*comienzo_longitud"],
                "fin_latitud"=> $_POST["{$myRow}*{$obstype}*fin_latitud"],
                "fin_longitud"=> $_POST["{$myRow}*{$obstype}*fin_longitud"],
                "iden_medicion"=> $medicionkey,
                
                    );
            $resultofquery[] = savenewentry("{$unitlower}_{$speciestype}", $unitcolumns);

            $unitmax=getserialmax( "{$unitlower}_{$speciestype}");
            foreach(countrows($obstype) as $myRow){
                //Handle fotos
                $iden_foto=uploadfoto($myRow, $obstype);
                //Handle Species
                $especiechoice= $_POST["{$myRow}*{$obstype}*species"];
                if ($especiechoice=="Nuevo") {
                    $iden_especie=savenewspecies( $speciestable,$_POST["{$myRow}*{$obstype}*comun"],$_POST["{$myRow}*{$obstype}*cientifico"] );
                }else{
                    $iden_especie=askforkey( $speciestable, "iden", "comun_cientifico", $especiechoice);
                }
                $obscolumns=array(
                    "ind"=> $_POST["{$myRow}*{$obstype}*ind"],
                    "letra_m"=> $_POST["{$myRow}*{$obstype}*m"],
                    "letra_i"=> $_POST["{$myRow}*{$obstype}*i"],
                    "notas"=> $_POST["{$myRow}*{$obstype}*notas"],
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
            $myRow='row0';
            $unitcolumns=array(
                "sampling_unit"=> $unitnum,
                "latitud_gps"=> $_POST["{$myRow}*{$obstype}*latitud_gps"],
                "longitud_gps"=> $_POST["{$myRow}*{$obstype}*longitud_gps"],
                "letra_n"=> $_POST["{$myRow}*{$obstype}*n"],
                "letra_a"=> $_POST["{$myRow}*{$obstype}*a"],
                "letra_m"=> $_POST["{$myRow}*{$obstype}*m"],
                "letra_e"=> $_POST["{$myRow}*{$obstype}*e"],
                
                "numero_punto62"=> $_POST["selectPunto"],
                "iden_medicion"=> $medicionkey,
                    );
            $resultofquery[] = savenewentry("{$unitlower}_{$speciestype}", $unitcolumns);

            $unitmax=getserialmax( "{$unitlower}_{$speciestype}");
            foreach(countrows($obstype) as $myRow){
                //Handle fotos
                $iden_foto=uploadfoto($myRow, $obstype);
                //Handle Species
                $especiechoice= $_POST["{$myRow}*{$obstype}*species"];
                if ($especiechoice=="Nuevo") {
                    $iden_especie=savenewspecies( $speciestable,$_POST["{$myRow}*{$obstype}*comun"],$_POST["{$myRow}*{$obstype}*cientifico"] );
                }else{
                    $iden_especie=askforkey( $speciestable, "iden", "comun_cientifico", $especiechoice);
                }
                
                $obscolumns=array(
                    "distancia"=> $_POST["{$myRow}*{$obstype}*distancia"],
                    "azimut"=> $_POST["{$myRow}*{$obstype}*azimut"],
                    "altura"=> $_POST["{$myRow}*{$obstype}*altura"],
                    "dn"=> $_POST["{$myRow}*{$obstype}*dn"],
                    "acc1"=> $_POST["{$myRow}*{$obstype}*acc1"],
                    "acc2"=> $_POST["{$myRow}*{$obstype}*acc2"],
                    "acc3"=> $_POST["{$myRow}*{$obstype}*acc3"],
                    "dc1"=> $_POST["{$myRow}*{$obstype}*dc1"],
                    "dc2"=> $_POST["{$myRow}*{$obstype}*dc2"],
                    "cuadrante"=> $_POST["{$myRow}cuadrante"],
                    "notas"=> $_POST["{$myRow}*{$obstype}*notas"],
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
            $myRow='row0';
            $unitcolumns=array(
                "sampling_unit"=> $unitnum,
                "comienzo_latitud"=> $_POST["{$myRow}*{$obstype}*comienzo_latitud"],
                "comienzo_longitud"=> $_POST["{$myRow}*{$obstype}*comienzo_longitud"],
                "fin_latitud"=> $_POST["{$myRow}*{$obstype}*fin_latitud"],
                "fin_longitud"=> $_POST["{$myRow}*{$obstype}*fin_longitud"],
                "estado_del_tiempo"=> $_POST["{$myRow}*{$obstype}*estado_del_tiempo"],
                "iden_medicion"=> $medicionkey,
                    );
            $resultofquery[] = savenewentry("{$unitlower}_{$speciestype}", $unitcolumns);

            $unitmax=getserialmax( "{$unitlower}_{$speciestype}");
            foreach(countrows($obstype) as $myRow){
                //Handle fotos
                $iden_foto=uploadfoto($myRow, $obstype);
                //Handle Species
                $especiechoice= $_POST["{$myRow}*{$obstype}*species"];
                if ($especiechoice=="Nuevo") {
                    $iden_especie=savenewspecies( $speciestable,$_POST["{$myRow}*{$obstype}*comun"],$_POST["{$myRow}*{$obstype}*cientifico"] );
                }else{
                    $iden_especie=askforkey( $speciestable, "iden", "comun_cientifico", $especiechoice);
                }
                $obscolumns=array(
                    "sexo"=> $_POST["{$myRow}*{$obstype}*sexo"],
                    "estadio"=> $_POST["{$myRow}*{$obstype}*estadio"],
                    "actividad"=> $_POST["{$myRow}*{$obstype}*actividad"],
                    "microhabitat"=> $_POST["{$myRow}*{$obstype}*microhabitat"],
                    "hora"=> $_POST["{$myRow}*{$obstype}*hora"],
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
                "latitud_gps"=> $_POST["{$myRow}*{$obstype}*latitud_gps"],
                "longitud_gps"=> $_POST["{$myRow}*{$obstype}*longitud_gps"],
                "tipo_vegetacion"=> $_POST["{$myRow}*{$obstype}*tipo_vegetacion"],
                "anio"=> $_POST["{$myRow}*{$obstype}*anio"],
                "marca"=> $_POST["{$myRow}*{$obstype}*marca"],
                "modelo"=> $_POST["{$myRow}*{$obstype}*modelo"],
                "fecha_de_activacion"=> $_POST["{$myRow}*{$obstype}*fecha_de_activacion"],
                "fecha_de_apagado"=> $_POST["{$myRow}*{$obstype}*fecha_de_apagado"],
                "numero_de_dias_operables"=> $_POST["{$myRow}*{$obstype}*numero_de_dias_operables"],
                "numero_de_fotos_totales"=> $_POST["{$myRow}*{$obstype}*numero_de_fotos_totales"],
                "numero_de_fotos_efectivas"=> $_POST["{$myRow}*{$obstype}*numero_de_fotos_efectivas"],
                "iden_medicion"=> $medicionkey,
                
                    );
            $resultofquery[] = savenewentry("{$unitlower}_{$speciestype}", $unitcolumns);
            //Handle Species
            $unitmax=getserialmax( "{$unitlower}_{$speciestype}");
            foreach(countrows($obstype) as $myRow){
                //Handle fotos
                $iden_foto=uploadfoto($myRow, $obstype);
                //Handle Species
                $especiechoice= $_POST["{$myRow}*{$obstype}*species"];
                if ($especiechoice=="Nuevo") {
                    $iden_especie=savenewspecies( $speciestable,$_POST["{$myRow}*{$obstype}*comun"],$_POST["{$myRow}*{$obstype}*cientifico"] );
                }else{
                    $iden_especie=askforkey( $speciestable, "iden", "comun_cientifico", $especiechoice);
                }
                
                $obscolumns=array(
                    "numero_de_repeticion"=> $_POST["{$myRow}*{$obstype}*numero_de_repeticion"],
                    "fecha_de_captura"=> $_POST["{$myRow}*{$obstype}*fecha_de_captura"],
                    "hora_de_captura"=> $_POST["{$myRow}*{$obstype}*hora_de_captura"],
                    "numero_de_individulos_capturados"=> $_POST["{$myRow}*{$obstype}*numero_de_individulos_capturados"],
                    "numero_de_foto"=> $_POST["{$myRow}*{$obstype}*numero_de_foto"],
                    "etapa_de_vida"=> $_POST["{$myRow}*{$obstype}*etapa_de_vida"],
                    "sexo"=> $_POST["{$myRow}*{$obstype}*sexo"],
                    "notas"=> $_POST["{$myRow}*{$obstype}*notas"],
                    "iden_especie"=> $iden_especie,
                    "iden_foto"=> $iden_foto,
                    "iden_{$unitlower}"=> $unitmax,
                );
                $resultofquery[] = savenewentry( $obstype, $obscolumns);
            }
        }

    }
}


?>