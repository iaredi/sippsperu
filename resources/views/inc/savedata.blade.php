
<?php



$resultofquery=[];

if ($_SERVER['REQUEST_METHOD']=="POST"&& sizeof(session('error'))==0 && (!session('visitante'))  ){
    $mtpchoice =$_POST['selectlinea_mtp'];    
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
        if ($_POST['selectpredio']=="Nuevo") {
            
            
            $prediofkey=askforkey("municipio_puebla_4326", "gid", "nomgeo", $_POST['selectmunicipio']);
            
            $prediocolumns=array(
            "nombre"=> $_POST['row0*predio*nombre'],
            "nombre_de_duenio_o_technico"=> $_POST['row0*predio*nombre_de_duenio_o_technico'],
            "referencia_de_accesso"=> $_POST['row0*predio*referencia_de_accesso'],
            "superficie"=> $_POST['row0*predio*superficie'],
            "contacto"=> $_POST['row0*predio*contacto'],
            "iden_muni_predio"=> $_POST['selectmunicipio'].'-'.$_POST['row0*predio*nombre'],
            "clave_municipio"=> $prediofkey
                );
            $resultofquery[]= savenewentry("predio", $prediocolumns);
                }

            //Save Lat/Long Rows
            if ($_POST['selectpredio']=="Nuevo") {      
                $linea_mtpfkey=askforkey("predio", "iden", "iden_muni_predio", $_POST['selectmunicipio'].'-'.$_POST['row0*predio*nombre']);
                $linea_mtppredioname=$_POST['row0*predio*nombre'];
            }else{
                $linea_mtpfkey=askforkey("predio", "iden", "iden_muni_predio", $_POST['selectpredio']);
                $linea_mtppredioname=$_POST['selectpredio'];
            }
            //Save New Linea_MTP Data
            for($i=0; $i<countrows("linea_mtp"); $i++) {
                $comienzo_longitud = round(floatval($_POST["row{$i}*linea_mtp*comienzo_longitud"]),6);
                $fin_longitud = round(floatval($_POST["row{$i}*linea_mtp*fin_longitud"]),6);
                $comienzo_latitud = round(floatval($_POST["row{$i}*linea_mtp*comienzo_latitud"]),6);
                $fin_latitud = round(floatval($_POST["row{$i}*linea_mtp*fin_latitud"]),6);
                $linea_mtpcolumns=array(
                    "comienzo_longitud"=> $comienzo_longitud,
                    "fin_longitud"=> $fin_longitud,
                    "comienzo_latitud"=> $comienzo_latitud,
                    "fin_latitud"=> $fin_latitud,
                    "nombre_iden"=> "{$linea_mtppredioname} ({$comienzo_latitud},{$comienzo_longitud}) ({$fin_latitud},{$fin_longitud})",
                    "iden_predio"=> $linea_mtpfkey,
                    "iden_unidad_de_paisaje"=> "notset"
                        );

                $resultofquery[]= savenewentry("linea_mtp", $linea_mtpcolumns);
                $max_line = getserialmax( "linea_mtp");

                /////////////////////
                $updatesql = "UPDATE linea_mtp set iden_geom = (SELECT ST_GeomFromText('MultiLineString(({$comienzo_longitud} {$comienzo_latitud}, {$fin_longitud} {$fin_latitud}))',4326)) where iden = {$max_line}";
                $stmnt9 = DB::update($updatesql, []);
                //////////////////////
            }




   } else {
        $medicionchoice = $_POST['selectmedicion'];
        session(['my_linea_mtp' => $_POST['selectlinea_mtp']]);
        if ($medicionchoice=="Nuevo") {
        //Save Medicion Data  

            $medicionfkey=askforkey("linea_mtp", "iden", "nombre_iden", $_POST['selectlinea_mtp']);

            $linea_mtpclave_predio=askforkey("linea_mtp", "iden_predio", "nombre_iden", $_POST['selectlinea_mtp']);
            $predioname=askforkey("predio", "nombre", "iden", $linea_mtpclave_predio);
            $medicioncolumns=array(
                "iden_linea_mtp"=>$medicionfkey,
                "fecha"=> $_POST['row0*medicion*fecha'],
                "iden_nombre"=> $predioname."*".$_POST['row0*medicion*fecha']
            );
            $resultofquery[]= savenewentry("medicion", $medicioncolumns);
            $max_medicion = getserialmax( "medicion");


            //Save New People and Brigada Data  
            $max_medicion = getserialmax( "medicion");
            for($i=0; $i<rowmax("personas"); $i++) {
                if(isset($_POST["row{$i}*personas*nombre"])){
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
            }
            //Save GPS Data  
            for($i=0; $i<rowmax("gps"); $i++) {
                if(isset($_POST["row{$i}*gps*anio"])){
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
            }
            //Save Camara Data  
            for($i=0; $i<rowmax("camara"); $i++) {
                if(isset($_POST["row{$i}*camara*anio"])){
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
            }

            
        }else{
            session(['my_medicion' => $_POST['selectmedicion']]);
            //Existing Medicion
            $medicionkey=askforkey("medicion", "iden", "iden_nombre", $_POST['selectmedicion']);
            $obstype= 'observacion_'.$_POST['selectobservaciones'];
            $speciestype=  explode("_" , $obstype)[1];
            $speciestable="especie_".$speciestype;
            


            //Delete old data------------------------------------------------------------------------------------------------------------------------
            if($_POST['mode']=='Datos Existentes'){
                $hiddenlocation=$_POST['hiddenlocation'];
                $transpunto = 'punto';
                if ($obstype=="observacion_hierba" || $obstype=="observacion_herpetofauna" ){
                    $transpunto = 'transecto';
                }
                
                $sql = "DELETE FROM observacion_{$speciestype} WHERE iden_{$transpunto}={$hiddenlocation} and iden_email=:iden_email";
                $numrows =DB::delete($sql, ['iden_email'=>str_replace('"', '', $useremail)]);
                 $sql = "delete FROM {$transpunto}_{$speciestype} WHERE iden={$hiddenlocation}  and iden_email=:iden_email";
                $numrows =DB::delete($sql, ['iden_email'=>str_replace('"', '', $useremail)]);
                

            }

            //AVE------------------------------------------------------------------------------------------------------------------------
            if ($obstype=='observacion_ave'){
                //Handle Punto 
                $unit='Punto';
                $unitlower=strtolower($unit);
                $unitnum= $_POST["select{$unit}"];  
                //Save UDP
                $mylong = $_POST["row0*{$unitlower}_{$speciestype}*longitud_gps"];
                $mylat = $_POST["row0*{$unitlower}_{$speciestype}*latitud_gps"];
                $sql="SELECT udp_puebla_4326.iden FROM udp_puebla_4326 WHERE ST_Intersects(udp_puebla_4326.geom, ST_GeomFromText('POINT({$mylong} {$mylat})',4326))";
                $result= $stmnt = DB::select($sql, []);
                

                $unitcolumns=buildcolumnsarray("{$unitlower}_{$speciestype}", "row0");
                $unitcolumns["iden_sampling_unit"]= $unitnum;
                $unitcolumns["iden_medicion"]= $medicionkey;
                if (sizeof($result)>0){
                    $unitcolumns["iden_udp"]= $result[0]->iden;
                }
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
                        $iden_especie=savenewspecies( $speciestable,$_POST["row{$i}*{$obstype}*comun"],$_POST["row{$i}*{$obstype}*cientifico"],isset($_POST["row{$i}*{$obstype}*invasor"]) );
                    }else{
                        $iden_especie=askforkey( $speciestable, "iden", "comun_cientifico", $especiechoice);
                    }
                    
                    $obscolumns=buildcolumnsarray($obstype, "row{$i}");
                    $obscolumns["iden_especie"]= $iden_especie;
                    $obscolumns["iden_foto"]= $iden_foto;
                    $obscolumns["iden_{$unitlower}"]= $unitmax;

                    $resultofquery[] = savenewentry($obstype, $obscolumns);
                }
            }

            //Hierba------------------------------------------------------------------------------------------------------------------------
            if ($obstype=='observacion_hierba'){
                //Handle Transecto
                $unit='Transecto';
                $unitlower=strtolower($unit);
                $unitnum= $_POST["select{$unit}"];  
                
          //Save UDP
                $mylong = $_POST["row0*{$unitlower}_{$speciestype}*comienzo_longitud"];
                $mylat = $_POST["row0*{$unitlower}_{$speciestype}*comienzo_latitud"];
                $sql="SELECT udp_puebla_4326.iden FROM udp_puebla_4326 WHERE ST_Intersects(udp_puebla_4326.geom, ST_GeomFromText('POINT({$mylong} {$mylat})',4326))";
                $result= $stmnt = DB::select($sql, []);

                    $unitcolumns=buildcolumnsarray("{$unitlower}_{$speciestype}", "row0");
                    $unitcolumns["iden_sampling_unit"]= $unitnum;
                    $unitcolumns["iden_medicion"]= $medicionkey;
                    if (sizeof($result)>0){
                        $unitcolumns["iden_udp"]= $result[0]->iden;
                    }    
                $resultofquery[] = savenewentry("{$unitlower}_{$speciestype}", $unitcolumns);

                $unitmax=getserialmax( "{$unitlower}_{$speciestype}");
                for($i=0; $i<countrows($obstype); $i++) {
                    //Handle fotos
                    $iden_foto=uploadfoto("row{$i}", $obstype);
                    //Handle Species
                    $especiechoice= $_POST["row{$i}*{$obstype}*species"];
                    if ($especiechoice=="Nuevo") {
                        $iden_especie=savenewspecies( $speciestable,$_POST["row{$i}*{$obstype}*comun"],$_POST["row{$i}*{$obstype}*cientifico"],isset($_POST["row{$i}*{$obstype}*invasor"]) );
                    }else{
                        $iden_especie=askforkey( $speciestable, "iden", "comun_cientifico", $especiechoice);
                    }
                   
                    $obscolumns=buildcolumnsarray($obstype, "row{$i}");
                    $obscolumns["iden_especie"]= $iden_especie;
                    $obscolumns["iden_foto"]= $iden_foto;
                    $obscolumns["iden_{$unitlower}"]= $unitmax;

                    $resultofquery[] = savenewentry( $obstype, $obscolumns);
                }
            }
                //Arbol y Arbusto------------------------------------------------------------------------------------------------------------------------
                if ($obstype=='observacion_arbol'||$obstype=='observacion_arbusto'){
                //Handle Transecto
                $unit='Punto';
                $unitlower=strtolower($unit);
                $unitnum= $_POST["select{$unit}"];  

                //Save UDP
                $mylong = $_POST["row0*{$unitlower}_{$speciestype}*longitud_gps"];
                $mylat = $_POST["row0*{$unitlower}_{$speciestype}*latitud_gps"];
                $sql="SELECT udp_puebla_4326.iden FROM udp_puebla_4326 WHERE ST_Intersects(udp_puebla_4326.geom, ST_GeomFromText('POINT({$mylong} {$mylat})',4326))";
                $result= $stmnt = DB::select($sql, []);
                
                
                $unitcolumns=buildcolumnsarray("{$unitlower}_{$speciestype}", "row0");
                $unitcolumns["iden_sampling_unit"]= $unitnum;
                $unitcolumns["iden_numero_punto62"]= $_POST["selectPunto"];
                $unitcolumns["iden_medicion"]= $medicionkey;
                if (sizeof($result)>0){
                    $unitcolumns["iden_udp"]= $result[0]->iden;
                }   

                $resultofquery[] = savenewentry("{$unitlower}_{$speciestype}", $unitcolumns);

                $unitmax=getserialmax( "{$unitlower}_{$speciestype}");
                for($i=0; $i<countrows($obstype); $i++) {
                    /ls /Handle fotos
                    $iden_foto=uploadfoto("row{$i}", $obstype);
                    //Handle Species
                    $especiechoice= $_POST["row{$i}*{$obstype}*species"];
                    if ($especiechoice=="Nuevo") {
                        $iden_especie=savenewspecies( $speciestable,$_POST["row{$i}*{$obstype}*comun"],$_POST["row{$i}*{$obstype}*cientifico"],isset($_POST["row{$i}*{$obstype}*invasor"]) );
                    }else{
                        $iden_especie=askforkey( $speciestable, "iden", "comun_cientifico", $especiechoice);
                    }
                    
    
                    $obscolumns=buildcolumnsarray($obstype, "row{$i}");
                    $obscolumns["iden_especie"]= $iden_especie;
                    $obscolumns["iden_foto"]= $iden_foto;
                    $obscolumns["iden_cuadrante"]= $_POST["row{$i}*{$obstype}*cuadrante"];
                    $obscolumns["iden_{$unitlower}"]= $unitmax;
                    

                    $resultofquery[] = savenewentry( $obstype, $obscolumns);
                }
            }

            //Herpetofauna------------------------------------------------------------------------------------------------------------------------
            if ($obstype=='observacion_herpetofauna'){
                //Handle Transecto
                $unit='Transecto';
                $unitlower=strtolower($unit);
                $unitnum= $_POST["select{$unit}"];  
               
                //Save UDP
                $mylong = $_POST["row0*{$unitlower}_{$speciestype}*comienzo_longitud"];
                $mylat = $_POST["row0*{$unitlower}_{$speciestype}*comienzo_latitud"];
                $sql="SELECT udp_puebla_4326.iden FROM udp_puebla_4326 WHERE ST_Intersects(udp_puebla_4326.geom, ST_GeomFromText('POINT({$mylong} {$mylat})',4326))";
                $result= $stmnt = DB::select($sql, []);

                $unitcolumns=buildcolumnsarray("{$unitlower}_{$speciestype}", "row0");
                $unitcolumns["iden_sampling_unit"]= $unitnum;
                $unitcolumns["iden_medicion"]= $medicionkey;
                if (sizeof($result)>0){
                    $unitcolumns["iden_udp"]= $result[0]->iden;
                }
                

                $resultofquery[] = savenewentry("{$unitlower}_{$speciestype}", $unitcolumns);

                $unitmax=getserialmax( "{$unitlower}_{$speciestype}");
                for($i=0; $i<countrows($obstype); $i++) {
                    //Handle fotos
                    $iden_foto=uploadfoto("row{$i}", $obstype);
                    //Handle Species
                    $especiechoice= $_POST["row{$i}*{$obstype}*species"];
                    if ($especiechoice=="Nuevo") {
                        $iden_especie=savenewspecies( $speciestable,$_POST["row{$i}*{$obstype}*comun"],$_POST["row{$i}*{$obstype}*cientifico"],isset($_POST["row{$i}*{$obstype}*invasor"]) );
                    }else{
                        $iden_especie=askforkey( $speciestable, "iden", "comun_cientifico", $especiechoice);
                    }
                
                    $obscolumns=buildcolumnsarray($obstype, "row{$i}");
                    $obscolumns["iden_especie"]= $iden_especie;
                    $obscolumns["iden_foto"]= $iden_foto;
                    $obscolumns["iden_{$unitlower}"]= $unitmax;

                    $resultofquery[] = savenewentry( $obstype, $obscolumns);
                }
            }

                //MAMIFERO------------------------------------------------------------------------------------------------------------------------
                if ($obstype=='observacion_mamifero'){
                //Handle Punto 
                $unit='Punto';
                $unitlower=strtolower($unit);
                $unitnum= $_POST["select{$unit}"];  
                
                    //Save UDP
                    $mylong = $_POST["row0*{$unitlower}_{$speciestype}*longitud_gps"];
                    $mylat = $_POST["row0*{$unitlower}_{$speciestype}*latitud_gps"];
                    $sql="SELECT udp_puebla_4326.iden FROM udp_puebla_4326 WHERE ST_Intersects(udp_puebla_4326.geom, ST_GeomFromText('POINT({$mylong} {$mylat})',4326))";
                    $result= $stmnt = DB::select($sql, []);
                    

                $unitcolumns=buildcolumnsarray("{$unitlower}_{$speciestype}", "row0");
                $unitcolumns["iden_sampling_unit"]= $unitnum;
                $unitcolumns["iden_medicion"]= $medicionkey;
                
                $interval=date_diff( date_create($_POST['row0*punto_mamifero*fecha_de_activacion']),  date_create($_POST['row0*punto_mamifero*fecha_de_apagado']));

                $unitcolumns["iden_numero_de_dias_operables"]=($interval->format('%d'));
                if (sizeof($result)>0){
                    $unitcolumns["iden_udp"]= $result[0]->iden;
                }
                $resultofquery[] = savenewentry("{$unitlower}_{$speciestype}", $unitcolumns);
                //Handle Species
                $unitmax=getserialmax( "{$unitlower}_{$speciestype}");
                for($i=0; $i<countrows($obstype); $i++) {
                    //Handle fotos
                    $iden_foto=uploadfoto("row{$i}", $obstype);
                    //Handle Species
                    $especiechoice= $_POST["row{$i}*{$obstype}*species"];

                    if ($especiechoice=="Nuevo") {
                        $iden_especie=savenewspecies( $speciestable,$_POST["row{$i}*{$obstype}*comun"],$_POST["row{$i}*{$obstype}*cientifico"],isset($_POST["row{$i}*{$obstype}*invasor"]) );
                    }else{
                        $iden_especie=askforkey( $speciestable, "iden", "comun_cientifico", $especiechoice);
                    }
                    
                    $obscolumns=buildcolumnsarray($obstype, "row{$i}");
                    $obscolumns["iden_especie"]= $iden_especie;
                    $obscolumns["iden_foto"]= $iden_foto;
                    $obscolumns["iden_{$unitlower}"]= $unitmax;
                    if($iden_foto=='No Presentado'||explode("_" , $iden_foto)[0];=='observacion'){
                        $resultofquery[] = savenewentry( $obstype, $obscolumns);
                    }else{ 
                        $resultofquery[] = 'Hubo un problema cargarando su foto';
                    }
                }
            }
        }
   }
    session(['resultofquery' => $resultofquery]);
    $saved=0;
    $failed=0;
    foreach($resultofquery as $result) {
        if (strpos($result, 'exito') !== false){
            $saved++;
        }else{
            $failed++;
        }
    }
    if(!$failed && $saved>0){
        echo 'would redirect';
        //return redirect()->to('/thanks')->send();
        
    }else{
        //$myerror=['Sus datos no fueron guardados.'];
        session(['error' => $resultofquery]);
    }
}
?>