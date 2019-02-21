<?php
  function savedata($newpost, $useremail, $fromexcel=false){
    $errorarray=[];
    $resultofquery=[];
    if ($_SERVER['REQUEST_METHOD']=="POST" && sizeof(session('error'))==0 && (!session('visitante'))){
      $mtpchoice =$newpost['selectlinea_mtp'];    
        if ($mtpchoice=="Nuevo") {
          //Save New Estado Data
          $estadochoice = $newpost['selectestado'];
          if ($estadochoice=="Nuevo") {
            $estadocolumns=array(
              "clave"=> $newpost['row0*estado*clave'],
              "nombre"=> $newpost['row0*estado*nombre']
            );
            $resultofquery[]= savenewentry("estado", $estadocolumns);
          }

          //Save New Municipio Data
          $municipiochoice = $newpost['selectmunicipio'];  
          if ($municipiochoice=="Nuevo") {
            if ($estadochoice=="Nuevo") {
              $municipiofkey=$newpost['row0*estado*clave'];
            }else{
              $municipiofkey=askforkey("estado", "clave", "nombre", $newpost['selectestado']);
            }
            $municipiocolumns=array(
              "clave"=> $newpost['row0*municipio*clave'],
              "nombre"=> "{$municipiofkey} -->{$newpost['row0*municipio*nombre']}",
              "clave_estado"=> $municipiofkey
            );
            $resultofquery[]= savenewentry("municipio", $municipiocolumns);
          }

            //Save New Predio Data
            if ($newpost['selectpredio']=="Nuevo") { 
              $prediofkey=askforkey("municipio_puebla_4326", "gid", "nomgeo", $newpost['selectmunicipio']); 
              $prediocolumns=array(
                "nombre"=> $newpost['row0*predio*nombre'],
                "nombre_de_duenio_o_technico"=> $newpost['row0*predio*nombre_de_duenio_o_technico'],
                "referencia_de_accesso"=> $newpost['row0*predio*referencia_de_accesso'],
                "superficie"=> $newpost['row0*predio*superficie'],
                "contacto"=> $newpost['row0*predio*contacto'],
                "iden_muni_predio"=> $newpost['selectmunicipio'].'-'.$newpost['row0*predio*nombre'],
                "clave_municipio"=> $prediofkey
              );
              $resultofquery[]= savenewentry("predio", $prediocolumns);
            }
              //Save Lat/Long Rows
            if ($newpost['selectpredio']=="Nuevo") {      
              $linea_mtpfkey=askforkey("predio", "iden", "iden_muni_predio", $newpost['selectmunicipio'].'-'.$newpost['row0*predio*nombre']);
              $linea_mtppredioname=$newpost['row0*predio*nombre'];
            }else{
              $linea_mtpfkey=askforkey("predio", "iden", "iden_muni_predio", $newpost['selectpredio']);
              $linea_mtppredioname=$newpost['selectpredio'];
            }
            //Save New Linea_MTP Data
            for($i=0; $i<countrows($newpost,"linea_mtp"); $i++) {
              $comienzo_latitud = round(floatval($newpost["row{$i}*linea_mtp*comienzo_latitud"]),6);
              $comienzo_longitud = round(floatval($newpost["row{$i}*linea_mtp*comienzo_longitud"]),6);
              $punto_2_latitud = round(floatval($newpost["row{$i}*linea_mtp*punto_2_latitud"]),6);
              $punto_2_longitud = round(floatval($newpost["row{$i}*linea_mtp*punto_2_longitud"]),6);
              $punto_3_latitud = round(floatval($newpost["row{$i}*linea_mtp*punto_3_latitud"]),6);
              $punto_3_longitud = round(floatval($newpost["row{$i}*linea_mtp*punto_3_longitud"]),6);
              $punto_4_latitud = round(floatval($newpost["row{$i}*linea_mtp*punto_4_latitud"]),6);
              $punto_4_longitud = round(floatval($newpost["row{$i}*linea_mtp*punto_4_longitud"]),6);
              $fin_latitud = round(floatval($newpost["row{$i}*linea_mtp*fin_latitud"]),6);
              $fin_longitud = round(floatval($newpost["row{$i}*linea_mtp*fin_longitud"]),6);

            
              $linea_mtpcolumns=array(
                "comienzo_longitud"=> $comienzo_longitud,
                "fin_longitud"=> $fin_longitud,
                "comienzo_latitud"=> $comienzo_latitud,
                "fin_latitud"=> $fin_latitud,
                "punto_2_latitud"=> $punto_2_latitud,
                "punto_2_longitud"=> $punto_2_longitud,
                "punto_3_latitud"=> $punto_3_latitud,
                "punto_3_longitud"=> $punto_3_longitud,
                "punto_4_latitud"=> $punto_4_latitud,
                "punto_4_longitud"=> $punto_4_longitud,
                "nombre_iden"=> "{$linea_mtppredioname} ({$comienzo_latitud},{$comienzo_longitud}) ({$fin_latitud},{$fin_longitud})",
                "iden_predio"=> $linea_mtpfkey,
                "iden_unidad_de_paisaje"=> "notset"
              );
              $resultofquery[]= savenewentry("linea_mtp", $linea_mtpcolumns);
              $max_line = getserialmax( "linea_mtp");

              /////////////////////
              $updatesql = "UPDATE linea_mtp set iden_geom = (SELECT ST_GeomFromText('MultiLineString(({$comienzo_longitud} {$comienzo_latitud},{$punto_2_longitud} {$punto_2_latitud},{$punto_3_longitud} {$punto_3_latitud},{$punto_4_longitud} {$punto_4_latitud}, {$fin_longitud} {$fin_latitud}))',4326)) where iden = {$max_line}";
              $stmnt9 = DB::update($updatesql, []);
              //////////////////////
            }

        } else {
            $medicionchoice = $newpost['selectmedicion'];
            session(['my_linea_mtp' => $mtpchoice]);
            if ($medicionchoice=="Nuevo") {
            //Save Medicion Data  

                $medicionfkey=askforkey("linea_mtp", "iden", "nombre_iden", $mtpchoice);

                $linea_mtpclave_predio=askforkey("linea_mtp", "iden_predio", "nombre_iden", $mtpchoice);
                $predioname=askforkey("predio", "nombre", "iden", $linea_mtpclave_predio);
                $medicioncolumns=array(
                  "iden_linea_mtp"=>$medicionfkey,
                  "fecha"=> $newpost['row0*medicion*fecha'],
                  "iden_nombre"=> $predioname."*".$newpost['row0*medicion*fecha']
                );
                $resultofquery[]= savenewentry("medicion", $medicioncolumns);
                $max_medicion = getserialmax( "medicion");
                session(['testvar' => $newpost['row0*medicion*fecha']]);


                //Save New People and Brigada Data  
                $max_medicion = getserialmax( "medicion");
                for($i=0; $i<rowmax($newpost,"personas"); $i++) {
                    if(isset($newpost["row{$i}*personas*nombre"])){
                        $personascolumns=array(
                                "nombre"=> $newpost["row{$i}*personas*nombre"],
                                "apellido_materno"=> $newpost["row{$i}*personas*apellido_materno"],
                                "apellido_paterno"=> $newpost["row{$i}*personas*apellido_paterno"],
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
                for($i=0; $i<rowmax($newpost,"gps"); $i++) {
                    if(isset($newpost["row{$i}*gps*anio"])){
                        $gpscolumns=array(
                            "anio"=> $newpost["row{$i}*gps*anio"],
                            "marca"=> $newpost["row{$i}*gps*marca"],
                            "modelo"=> $newpost["row{$i}*gps*modelo"],
                            "numero_de_serie"=> $newpost["row{$i}*gps*numero_de_serie"],
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
                for($i=0; $i<rowmax($newpost,"camara"); $i++) {
                    if(isset($newpost["row{$i}*camara*anio"])){
                        $camaracolumns=array(
                            "anio"=> $newpost["row{$i}*camara*anio"],
                            "marca"=> $newpost["row{$i}*camara*marca"],
                            "modelo"=> $newpost["row{$i}*camara*modelo"],
                            "numero_de_serie"=> $newpost["row{$i}*camara*numero_de_serie"],
                                );
                            $resultofquery[] = savenewentry("camara", $camaracolumns);

                            $camara_medicion_array=array(
                                "iden_medicion"=> $max_medicion,
                                "iden_camara"=> getserialmax( "camara")
                                    );
                            $resultofquery[] = savenewentry("camara_medicion", $camara_medicion_array);
                    }
                }
                if($fromexcel){
                  return $predioname."*".$newpost['row0*medicion*fecha'];
                }
            }else{
              session(['my_medicion' => $medicionchoice]);
              //Existing Medicion
              $medicionkey = askforkey("medicion", "iden", "iden_nombre", $medicionchoice);
              $obstype = 'observacion_'.$newpost['selectobservaciones'];
              $speciestype = explode("_" , $obstype)[1];
              $speciestable = "especie_".$speciestype; 
              //Delete old data------------------------------------------------------------------------------------------------------------------------
              if($newpost['mode']=='Datos Existentes'){
                $hiddenlocation=$newpost['hiddenlocation'];
                $transpunto = 'punto';
                if ($obstype=="observacion_hierba" || $obstype=="observacion_herpetofauna" ){
                    $transpunto = 'transecto';
                }
                $sql = "DELETE FROM observacion_{$speciestype} WHERE iden_{$transpunto}={$hiddenlocation} and iden_email=:iden_email";
                $numrows =DB::delete($sql, ['iden_email'=>str_replace('"', '', $useremail)]);
                $sql = "delete FROM {$transpunto}_{$speciestype} WHERE iden={$hiddenlocation}  and iden_email=:iden_email";
                $numrows =DB::delete($sql, ['iden_email'=>str_replace('"', '', $useremail)]);
              }



        //SAVE ALL SPECIES------------------------------------------------------------------------------------------------------------------------
              $lifeform=explode("_",$obstype)[1];
              $transpunto="punto";
              $longitudcolumn="longitud_gps";
              $latitudcolumn="latitud_gps";

              if ($lifeform=='hierba' || $lifeform=='herpetofauna'){
                $transpunto="transecto";
                $longitudcolumn="comienzo_longitud";
                $latitudcolumn="comienzo_latitud";
              }
            //Handle Punto 
                $unit=ucfirst($transpunto);
                $unitnum= $newpost["select{$unit}"]; 
                $unitcolumns=buildcolumnsarray($newpost,"{$transpunto}_{$speciestype}", "row0");
                $unitcolumns["iden_sampling_unit"]= $unitnum; 
                if ($lifeform=='arbol' || $lifeform=='arbusto'){
                  $unitcolumns["iden_sampling_unit"]= $newpost["selectTransecto"];
                  $unitnum = $newpost["select{$unit}"]; 
                  $unitcolumns["iden_numero_punto62"]= $unitnum;
                } 
                //Save UDP
                $mylong = $newpost["row0*{$transpunto}_{$speciestype}*{$longitudcolumn}"];
                $mylat = $newpost["row0*{$transpunto}_{$speciestype}*{$latitudcolumn}"];
                $sql="SELECT udp_puebla_4326.iden FROM udp_puebla_4326 WHERE ST_Intersects(udp_puebla_4326.geom, ST_GeomFromText('POINT({$mylong} {$mylat})',4326))";
                $udpresult = DB::select($sql, []);
                if (sizeof($udpresult)>0){
                    $unitcolumns["iden_udp"]= $udpresult[0]->iden;
                } 
                $unitcolumns["iden_medicion"]= $medicionkey;
            //Handle observaciones
                $obscolumnarray=[];
                for($i=0; $i<countrows($newpost,$obstype); $i++){
                  //Handle fotos
                  $postid = "row{$i}*{$obstype}*iden_foto";
                  if ($fromexcel){
                    $iden_foto = $newpost[$postid];
                  }else{
                    $iden_foto = $_FILES[$postid];
                    $iden_foto = uploadfoto($newpost,$_FILES[$postid]["name"], $_FILES[$postid]["tmp_name"], $_FILES[$postid]["size"], $obstype);
                  }
                  //Handle Species
                  $especiechoice= $newpost["row{$i}*{$obstype}*species"];
                  if(sizeof(explode("*" , $especiechoice))==2){
                    $especiechoice=explode("*" , $especiechoice)[1];
                  }
                  if ($especiechoice=="Nuevo") {
                      $iden_especie=savenewspecies( $speciestable,$newpost["row{$i}*{$obstype}*comun"],$newpost["row{$i}*{$obstype}*cientifico"],isset($newpost["row{$i}*{$obstype}*invasor"]) );
                  }else{
                    $iden_especie=askforkey( $speciestable, "iden", "cientifico", $especiechoice);
                  }
                  
                  $obscolumns=buildcolumnsarray($newpost,$obstype, "row{$i}");
                  $obscolumns["iden_especie"]= $iden_especie;
                  $obscolumns["iden_foto"]= $iden_foto;
                  
                  
                  if($iden_foto=='No Presentado' || explode("_" , $iden_foto)[0]=='observacion'){
                    echo "HELLO";
                    $obscolumnarray[]=$obscolumns;
                  }else{ 
                    $resultofquery[] = $iden_foto;
                  }
                } 
                if (sizeof($resultofquery)==0){
                  echo var_dump($obscolumnarray);
                  $resultofquery[] = savenewentry("{$transpunto}_{$speciestype}", $unitcolumns);
                  $unitmax=getserialmax("{$transpunto}_{$speciestype}"); 
                  foreach ($obscolumnarray as $obscolumn) {
                    $obscolumn["iden_{$transpunto}"]= $unitmax;
                    $resultofquery[] = savenewentry( $obstype, $obscolumn); 
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
          $errorarray[]=$result;
        }
      }
      if(!$failed && $saved>0){
        return "true";
      }else{
        session(['error' => $errorarray]);
        return "false";
      }
    }
  }
?>