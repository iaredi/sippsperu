
<?php

function savedata($newpost,$useremail){

  $resultofquery=[];
  if ($_SERVER['REQUEST_METHOD']=="POST"&& sizeof(session('error'))==0 && (!session('visitante'))  ){
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
              for($i=0; $i<countrows("linea_mtp"); $i++) {
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
          session(['my_linea_mtp' => $newpost['selectlinea_mtp']]);
          if ($medicionchoice=="Nuevo") {
          //Save Medicion Data  

              $medicionfkey=askforkey("linea_mtp", "iden", "nombre_iden", $newpost['selectlinea_mtp']);

              $linea_mtpclave_predio=askforkey("linea_mtp", "iden_predio", "nombre_iden", $newpost['selectlinea_mtp']);
              $predioname=askforkey("predio", "nombre", "iden", $linea_mtpclave_predio);
              $medicioncolumns=array(
                  "iden_linea_mtp"=>$medicionfkey,
                  "fecha"=> $newpost['row0*medicion*fecha'],
                  "iden_nombre"=> $predioname."*".$newpost['row0*medicion*fecha']
              );
              $resultofquery[]= savenewentry("medicion", $medicioncolumns);
              $max_medicion = getserialmax( "medicion");


              //Save New People and Brigada Data  
              $max_medicion = getserialmax( "medicion");
              for($i=0; $i<rowmax("personas"); $i++) {
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
              for($i=0; $i<rowmax("gps"); $i++) {
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
              for($i=0; $i<rowmax("camara"); $i++) {
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

              
          }else{
              session(['my_medicion' => $newpost['selectmedicion']]);
              //Existing Medicion
              $medicionkey=askforkey("medicion", "iden", "iden_nombre", $newpost['selectmedicion']);
              $obstype= 'observacion_'.$newpost['selectobservaciones'];
              $speciestype=  explode("_" , $obstype)[1];
              $speciestable="especie_".$speciestype;
              


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

              //AVE------------------------------------------------------------------------------------------------------------------------
              if ($obstype=='observacion_ave'){
                  //Handle Punto 
                  $unit='Punto';
                  $unitlower=strtolower($unit);
                  $unitnum= $newpost["select{$unit}"];  
                  //Save UDP
                  $mylong = $newpost["row0*{$unitlower}_{$speciestype}*longitud_gps"];
                  $mylat = $newpost["row0*{$unitlower}_{$speciestype}*latitud_gps"];
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
                      $especiechoice= $newpost["row{$i}*{$obstype}*species"];
                      if ($especiechoice=="Nuevo") {
                          $iden_especie=savenewspecies( $speciestable,$newpost["row{$i}*{$obstype}*comun"],$newpost["row{$i}*{$obstype}*cientifico"],isset($newpost["row{$i}*{$obstype}*invasor"]) );
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
                  $unitnum= $newpost["select{$unit}"];  
                  
            //Save UDP
                  $mylong = $newpost["row0*{$unitlower}_{$speciestype}*comienzo_longitud"];
                  $mylat = $newpost["row0*{$unitlower}_{$speciestype}*comienzo_latitud"];
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
                      $especiechoice= $newpost["row{$i}*{$obstype}*species"];
                      if ($especiechoice=="Nuevo") {
                          $iden_especie=savenewspecies( $speciestable,$newpost["row{$i}*{$obstype}*comun"],$newpost["row{$i}*{$obstype}*cientifico"],isset($newpost["row{$i}*{$obstype}*invasor"]) );
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
                  $unitnum= $newpost["select{$unit}"];  

                  //Save UDP
                  $mylong = $newpost["row0*{$unitlower}_{$speciestype}*longitud_gps"];
                  $mylat = $newpost["row0*{$unitlower}_{$speciestype}*latitud_gps"];
                  $sql="SELECT udp_puebla_4326.iden FROM udp_puebla_4326 WHERE ST_Intersects(udp_puebla_4326.geom, ST_GeomFromText('POINT({$mylong} {$mylat})',4326))";
                  $result= $stmnt = DB::select($sql, []);
                  
                  
                  $unitcolumns=buildcolumnsarray("{$unitlower}_{$speciestype}", "row0");
                  $unitcolumns["iden_sampling_unit"]= $unitnum;
                  $unitcolumns["iden_numero_punto62"]= $newpost["selectPunto"];
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
                      $especiechoice= $newpost["row{$i}*{$obstype}*species"];
                      if ($especiechoice=="Nuevo") {
                          $iden_especie=savenewspecies( $speciestable,$newpost["row{$i}*{$obstype}*comun"],$newpost["row{$i}*{$obstype}*cientifico"],isset($newpost["row{$i}*{$obstype}*invasor"]) );
                      }else{
                          $iden_especie=askforkey( $speciestable, "iden", "comun_cientifico", $especiechoice);
                      }
                      
      
                      $obscolumns=buildcolumnsarray($obstype, "row{$i}");
                      $obscolumns["iden_especie"]= $iden_especie;
                      $obscolumns["iden_foto"]= $iden_foto;
                      $obscolumns["iden_cuadrante"]= $newpost["row{$i}*{$obstype}*cuadrante"];
                      $obscolumns["iden_{$unitlower}"]= $unitmax;
                      

                      $resultofquery[] = savenewentry( $obstype, $obscolumns);
                  }
              }

              //Herpetofauna------------------------------------------------------------------------------------------------------------------------
              if ($obstype=='observacion_herpetofauna'){
                  //Handle Transecto
                  $unit='Transecto';
                  $unitlower=strtolower($unit);
                  $unitnum= $newpost["select{$unit}"];  
                
                  //Save UDP
                  $mylong = $newpost["row0*{$unitlower}_{$speciestype}*comienzo_longitud"];
                  $mylat = $newpost["row0*{$unitlower}_{$speciestype}*comienzo_latitud"];
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
                      $especiechoice= $newpost["row{$i}*{$obstype}*species"];
                      if ($especiechoice=="Nuevo") {
                          $iden_especie=savenewspecies( $speciestable,$newpost["row{$i}*{$obstype}*comun"],$newpost["row{$i}*{$obstype}*cientifico"],isset($newpost["row{$i}*{$obstype}*invasor"]) );
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
                  $unitnum= $newpost["select{$unit}"];  
                  
                      //Save UDP
                      $mylong = $newpost["row0*{$unitlower}_{$speciestype}*longitud_gps"];
                      $mylat = $newpost["row0*{$unitlower}_{$speciestype}*latitud_gps"];
                      $sql="SELECT udp_puebla_4326.iden FROM udp_puebla_4326 WHERE ST_Intersects(udp_puebla_4326.geom, ST_GeomFromText('POINT({$mylong} {$mylat})',4326))";
                      $result= $stmnt = DB::select($sql, []);
                      

                  $unitcolumns=buildcolumnsarray("{$unitlower}_{$speciestype}", "row0");
                  $unitcolumns["iden_sampling_unit"]= $unitnum;
                  $unitcolumns["iden_medicion"]= $medicionkey;
                  
                  $interval=date_diff( date_create($newpost['row0*punto_mamifero*fecha_de_activacion']),  date_create($newpost['row0*punto_mamifero*fecha_de_apagado']));

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
                      $especiechoice= $newpost["row{$i}*{$obstype}*species"];

                      if ($especiechoice=="Nuevo") {
                          $iden_especie=savenewspecies( $speciestable,$newpost["row{$i}*{$obstype}*comun"],$newpost["row{$i}*{$obstype}*cientifico"],isset($newpost["row{$i}*{$obstype}*invasor"]) );
                      }else{
                          $iden_especie=askforkey( $speciestable, "iden", "comun_cientifico", $especiechoice);
                      }
                      
                      $obscolumns=buildcolumnsarray($obstype, "row{$i}");
                      $obscolumns["iden_especie"]= $iden_especie;
                      $obscolumns["iden_foto"]= $iden_foto;
                      $obscolumns["iden_{$unitlower}"]= $unitmax;
                      if($iden_foto=='No Presentado' || explode("_" , $iden_foto)[0]=='observacion'){
                          $resultofquery[] = savenewentry( $obstype, $obscolumns);
                      }else{ 
                          $resultofquery[] = $iden_foto;
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
              $errorarray[]=$result;
          }
      }
      if(!$failed && $saved>0){
          //echo 'would redirect';
          return redirect()->to('/thanks')->send();
          
      }else{
          //$myerror=['Sus datos no fueron guardados.'];
          session(['error' => $errorarray]);
      }
  }
}
?>