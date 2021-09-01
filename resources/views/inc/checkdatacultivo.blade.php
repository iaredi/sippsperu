<?php
$errorlist=[];
if ($_SERVER['REQUEST_METHOD']=="POST") {

	if(isset($_POST['row0*cultivo*descripcion'])){
		$result = DB::select("SELECT descripcion FROM cultivo WHERE descripcion  = :value", [':value'=>$_POST['row0*cultivo*descripcion']]);
		if (sizeof($result)>0) {
			$errorlist[]= "Una acci&oacute;n con esta descripci&oacute;n ya existe. Por favor cambie la descripci&oacute;n.";
		}
	}

  foreach( $_FILES as $postkey2=> $postvalwithoutname) {
	 	if (sizeof(explode("*" , $postkey2))>1){
			$tablename= explode("*" , $postkey2)[1];
			$postval=$postvalwithoutname['name'];
			if (DB::select("SELECT iden_foto FROM {$tablename} WHERE iden_foto  = :value", [':value'=>$postval])) {
				$errorlist[]= "La foto {$postval} ya existe. Por favor cambie el nombre de la foto.";
			}
		}
    }
    foreach( $_POST as $postkey=> $postval) {
        if ($postval=='notselected') {
            $selectmenuname= substr($postkey, 6);
            $errorlist[]= "Los men&uacute;s desplegables no deben estar vac&iacute;os.";
        }
        if (substr_count($postkey, '*')==2){

            $columnname= explode("*" , $postkey)[2];
            $tablename= explode("*" , $postkey)[1];
            //Handle empty fields
            if(strlen($postval)==0){
                $hidden=false;
                if ($tablename=='estado'||$tablename=='municipio'||$tablename=='predio'){
                    if ($_POST['selectlinea_mtp']!="Nuevo"){
                        $hidden=true;
                    }else{
                        if (($_POST['selectestado']!="Nuevo") && $tablename=='estado'){
                            $hidden=true;
                        }
                        if (($_POST['selectmunicipio']!="Nuevo") && $tablename=='municipio'){
                            $hidden=true;
                        }
                        if (($_POST['selectpredio']!="Nuevo") && $tablename=='predio'){
                            $hidden=true;
                        }
                    }
                }
                if (!$hidden && $columnname !='notas'){
                    $errorlist[]= "El campo '{$columnname}' est&aacute; vac&iacute;o.";
                }
                //Handle non-empty fields
            }else{
       
                
                if (($columnname=='no_de_trabajadores') && !(is_numeric($postval))) {
                    $errorlist[]= "El campo 'No De Trabajadores' tiene que ser num&eacute;rico.";
                }
                if ((strpos($columnname, 'latitud') !== false ||strpos($columnname, 'longitud') !== false)&& !(is_numeric($postval))) {
                    $errorlist[]= "El campo '{$columnname}' tiene que ser num&eacute;rico.";
                }
                if (strpos($columnname, 'latitud') !== false && (!($postval<0.5) || !($postval>-18.5))) {
                    $errorlist[]= "El campo '{$columnname}' tiene que ser un n&uacute;mero entre -18.5000 y 0.5000 grados.";
                }
                if (strpos($columnname, 'longitud') !== false && (!($postval>-82.49) || !($postval<-67.72))) {
                    $errorlist[]= "El campo '{$columnname}' tiene que ser un n&uacute;mero entre -82.4900 y -67.7200 grados.";
                }
                if ($postval=='notselected' && $columnname !='notas') {
                    $errorlist[]= "{$tablename} est&aacute; vac&iacute;o";
                }
               
                /*$listnumcol=array(
                  'dn'=>'3','m'=>'3','a'=>'0','dc1'=>'3',
                  'dc2'=>'3','acc1'=>'3','acc2'=>'3','acc3'=>'3',
                  'altura'=>'3','distancia'=>'3','azimut'=>'3',
                  'longitud_gps'=>'4', 'latitud_gps'=>'4',
                  'comienzo_longitud'=>'4','comienzo_latitud'=>'4',
                  'fin_longitud'=>'4','fin_latitud'=>'4',
                  'anio_de_camara'=>'0', 'numero_de_photos_totales'=>'0', 
                  'porcentaje_de_bateria'=>'0', 'anio'=>'0'
                );
                foreach ($listnumcol as $numcol=>$precision) {
                  if ($columnname == $numcol) {
                    $exploded = explode("." , $postval);
                    if (!is_numeric($postval)){
                      $errorlist[]= "El campo '{$columnname}' debe ser num&eacute;rico.";
                    }else{
                      if($precision==0){
                        if ($postval!=0 && (sizeof($exploded)!=1)){
                          $errorlist[]= "El campo '{$columnname}' debe ser un n&uacute;mero con precisi&oacute;n de {$precision} decimales.";
                        }
                      }elseif($postval!=0 && (sizeof($exploded)!=2 || strlen($exploded[1]) != $precision)){
                        $errorlist[]= "El campo '{$columnname}' debe ser un n&uacute;mero con precisi&oacute;n de {$precision} decimales.";
                      }
                    }
                  }
                }*/
        }
    }
  }
    // for($i=0; $i<countrows($_POST,'observacion_ave'); $i++){
    //   $micrototal=
    //     $_POST["row{$i}*observacion_ave*fo_arbol"] + 
    //     $_POST["row{$i}*observacion_ave*fo_arbusto"] +
    //     $_POST["row{$i}*observacion_ave*tr_arbol"] +
    //     $_POST["row{$i}*observacion_ave*tr_arbusto"] +
    //     $_POST["row{$i}*observacion_ave*ro"] +
    //     $_POST["row{$i}*observacion_ave*su"];
    //   if ($micrototal != 0 && $micrototal != 1){
    //     $realrow=$i+1;
    //     $errorlist[]= "Hay error en observacion {$realrow}, hay que entrar 1 para solo un lugar, en 0 por los demas";
    //   } 
    // }





  }
session(['error' => $errorlist]);
?>