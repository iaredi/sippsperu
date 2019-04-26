<?php

   function savenewentry($mytable, $myarray){
        try {
            $placeholder="";
            $columnarray="";
            $sql1="INSERT INTO {$mytable} (";
            $sql3=   ") VALUES (";
            $sql5=   ");";
            foreach($myarray as $mycolumn=>$myval){
                $columnarray.=$mycolumn.',';
                if ($myval=="CURRENT_DATE"){
                    $placeholder.='CURRENT_DATE,';
                }else{
                    $placeholdername=':value'.$mycolumn;
                    $placeholder.="{$placeholdername},";
                    $arraytopass[$placeholdername]=$myval;
                }
            }
            //Add user email function
            
            $useremail=session('email');
            $columnarray.='iden_email,';
            $placeholdername=':value'.'iden_email';
            $placeholder.="{$placeholdername},";
            $arraytopass[$placeholdername]=$useremail;
        
            $sql2=substr_replace($columnarray ,"", -1);
            $sql4=substr_replace($placeholder ,"", -1);
            $completesql=$sql1.$sql2.$sql3.$sql4.$sql5;
            Log::info('savenewentry_attempt:', ['email'=>$useremail,'completesql' => $completesql,'arraytopass'=>$arraytopass ]);
            $results = DB::insert($completesql, $arraytopass);
            return ("{$mytable} ha sido guardado con exito");
        } catch(PDOException $e) {
            Log::info('savenewentry_fail:', [$e->getMessage(),'email'=>$useremail,'completesql' => $completesql,'arraytopass'=>$arraytopass ]);
            return ("{$mytable} failed to save with error ". $e->getMessage());
        }
    }

function askforkey($mytable, $myprimary, $myfield,  $myvalue){
       try {
            $sql="SELECT {$myprimary} FROM {$mytable} WHERE {$myfield}=:value";
            $stmnt= DB::select($sql,[':value'=>$myvalue]);
            return $stmnt[0]->$myprimary; 
       } catch(PDOException $e) {
            return $e->getMessage();
       }
  }

  function getserialmax($tablename){
        $invNum= DB::select("SELECT MAX(iden) AS max_id FROM {$tablename}");
        $max_id = $invNum[0]->max_id;
        if(is_null($max_id)){
            return 0;
        }else{
            return $max_id;
        }    
    }


    function savenewspecies($table,$comun,$cientifico, $invasor, $extra = false ){
        $invasorstring='false';
        if ($invasor){
            $invasorstring='true';
        }
        $extrastring='false';
        if ($extra){
            $extrastring='true';
        }   
        
        $newspecies=array(
            "comun"=> $comun,
            "cientifico"=> $cientifico,
            "comun_cientifico"=> $comun."*".$cientifico,
            "invasor"=> $invasorstring
                );
        if ($table=='especie_arbol'){
          $newspecies["iden_cactus"] = $extrastring;
        }
        if ($table=='especie_herpetofauna'){
          $newspecies["iden_anfibio"] = $extrastring;
        }
        

        $namesmatching = DB::select("SELECT cientifico FROM {$table} WHERE cientifico=:value", [':value'=>$cientifico]);
        if (sizeof($namesmatching)==1){
            return askforkey($table, 'iden', "cientifico",  $cientifico);
        }else{
            $resultofquery = savenewentry($table, $newspecies);
            return getserialmax( $table);
        }
    }


   


    function countrows($newpost,$tablename){
        $rownumlist=[];
        foreach($newpost as $key => $value) {
            if (substr_count($key, '*')==2){
                $expoldekey=explode("*" , $key );
                if ($expoldekey[1]==$tablename){
                    if (!(in_array($expoldekey[0],$rownumlist))){
                        array_push($rownumlist,$expoldekey[0]);
                    }
                }
            }
        }
    return(sizeof($rownumlist));
    } 

    function rowmax($newpost,$tablename){
        $myrowmax=0;
        foreach($newpost as $key => $value) {
            if (substr_count($key, '*')==2 && strpos($key, $tablename) !== false ){
                $expoldekey=explode("*" , $key );
                $num=explode("row" , $expoldekey[0] );
                if ($num[1]>$myrowmax){
                    $myrowmax-$num[1];
                }
            }
        }
    return($myrowmax);
    } 


    function buildcolumnsarray($newpost,$tablename, $rowandnum, $withval=true){
        try {
            $sql="SELECT column_name FROM information_schema.columns WHERE table_schema = 'public' AND table_name   = :tablename";
            $result= DB::select($sql,[':tablename'=>$tablename]);
            $colarray=array();
                foreach($result as $colobj){
                    $col=$colobj->column_name;
                    if (substr($col,0,4) != 'iden'){
						if($withval){
							$colarray[$col]=trim($newpost["{$rowandnum}*{$tablename}*{$col}"]);
							//Check for incorrect datetime formats 
							if (strpos($col, 'hora') !== false && strpos($colarray[$col], ':') == false){
								$colarray[$col]="00:01";
							}
							if (strpos($col, 'fecha') !== false && strpos($colarray[$col], '-') == false){
								$colarray[$col]="01/01/0001";
							}
						}else{
							$colarray[$col]='';
						}
                    }
                }
            return $colarray;
           
       } catch(PDOException $e) {
            return $e->getMessage();
       }
  }


  function formatdate($locvalue, $sheet, $letter, $row_number){
	  try {
		if ($locvalue=='00'||$locvalue=='000'||$locvalue=='0000'){
			$locvalue='01-01-1900';
		}
		// if (strlen($locvalue)<8){
		// 	return array($locvalue, "La fecha en {$letter}{$row_number} en {$sheet} es incorrecto.");
		// }

		//Add leading zero to day 
		if (!is_numeric(substr($locvalue, 1, 1))){	
			$locvalue="0".$locvalue;
		}

		//Add leading zero to day 
		if (is_numeric($locvalue)){	
			$locvalue=gmdate("d-m-Y", ($locvalue - 25569) * 86400);
		}
		
		//Add leading zero to month 
		if (is_numeric(substr($locvalue, 3, 1)) && !(is_numeric(substr($locvalue, 4, 1)))){	
			$locvalue=substr($locvalue, 0, 3) . "0" . substr($locvalue, 3);
		}
		$divider=substr($locvalue, 2, 1);
		$rawmonth=strtolower(explode($divider, $locvalue)[1]);

		if (ctype_alpha(substr($locvalue, 3, 3))){
			if (strpos($rawmonth, 'ene') !== false || strpos($rawmonth, 'jan') !== false){
				$rawmonth='01';
			}
			elseif (strpos($rawmonth, 'feb') !== false){
				$rawmonth='02';
			}
			elseif (strpos($rawmonth, 'mar') !== false){
				$rawmonth='03';
			}
			elseif (strpos($rawmonth, 'abr') !== false || strpos($rawmonth, 'apr') !== false){
				$rawmonth='04';
			}
			elseif (strpos($rawmonth, 'may') !== false){
				$rawmonth='05';
			}
			elseif (strpos($rawmonth, 'jun') !== false){
				$rawmonth='06';
			}
			elseif (strpos($rawmonth, 'jul') !== false){
				$rawmonth='07';
			}
			elseif (strpos($rawmonth, 'aug') !== false || strpos($rawmonth, 'ago') !== false){
				$rawmonth='08';
			}
			elseif (strpos($rawmonth, 'ene') !== false){
				$rawmonth='09';
			}
			elseif (strpos($rawmonth, 'ene') !== false){
				$rawmonth='10';
			}
			elseif (strpos($rawmonth, 'ene') !== false){
				$rawmonth='11';
			}
			elseif (strpos($rawmonth, 'dic') !== false || strpos($rawmonth, 'dec') !== false){
				$rawmonth='12';
			}
		}
		$newloc = $rawmonth ."-". explode($divider, $locvalue)[0] ."-" .  explode($divider, $locvalue)[2];

		if (!(is_numeric(substr($newloc, 0, 2))&&is_numeric(substr($newloc, 3, 2))&&is_numeric(substr($newloc, 6, 4)))){


			return array($locvalue, "La fecha en {$letter}{$row_number} en {$sheet} es en formato incorrecto");
		}
		//Switch day and month
		
		if (!(
			is_numeric(substr($newloc, 3, 2)) && intval(substr($newloc, 3, 2))>0 && intval(substr($newloc, 3, 2))<=31 &&
			is_numeric(substr($newloc, 0, 2)) && intval(substr($newloc, 0, 2))>0 && intval(substr($newloc, 0, 2))<13 &&
			is_numeric(substr($newloc, 6, 4)) && intval(substr($newloc, 6, 4))>1899 && intval(substr($newloc, 6, 4))<3000
		)){
			return array($newloc, "La fecha en {$letter}{$row_number} en {$sheet} tiene numeros incorrectos.");
		}
		if(!checkdate ( substr($newloc, 0, 2), substr($newloc, 3, 2), substr($newloc, 6, 4) )){
			return array($locvalue, "La fecha en {$letter}{$row_number} en {$sheet} no aparece en el calendario");
		}
		return array($newloc,'');
	}catch (Exception $e){

		return array($locvalue, "La fecha en {$letter}{$row_number} en {$sheet}es en formato incorrecto.");
	}
  }


  function formathour($locvalue, $sheet, $letter, $row_number){
	  try {
		
		if ($locvalue=='00'||$locvalue=='000'||$locvalue=='0000'){
			$locvalue='01:01';
		}
		if (intval($locvalue<1)&&intval($locvalue>=0)&&is_numeric($locvalue)){
			return array($locvalue, "");
		}
		if (strlen($locvalue)<3){
			return array($locvalue, "La hora en {$letter}{$row_number} en {$sheet} es en formato incorrecto.");
		}
		//Add leading zero to hour 
		if (!is_numeric(substr($locvalue, 1, 1))){	
			$locvalue="0".$locvalue;
		}
		if (!(is_numeric(substr($locvalue, 0, 2)) && is_numeric(substr($locvalue, 3, 2)) && substr($locvalue, 2, 1)==':')){
			return array($locvalue, "La hora en {$letter}{$row_number} en {$sheet} es en formato incorrecto.");
		}

		if (!(
			is_numeric(substr($locvalue, 0, 2)) && intval(substr($locvalue, 0, 2))>=0 && intval(substr($locvalue, 0, 2))<24 &&
			is_numeric(substr($locvalue, 3, 2)) && intval(substr($locvalue, 3, 2))>=0 && intval(substr($locvalue, 3, 2))<60
		)){
			return array($locvalue, "La hora en {$letter}{$row_number} en {$sheet} es en formato incorrecto.");
		}
		return array(substr($locvalue, 0, 2).":".substr($locvalue, 3, 2), '');
	}catch (Exception $e){
		return array($locvalue, "La hora en {$letter}{$row_number} en {$sheet} es en formato incorrecto.");
	}
  }




    function uploadfoto($newpost,$filesname,$filestmpname,$filessize, $obstype){
          if (isset($filesname) && ($filesname)!="" && ($filesname)!="0" && ($filesname)!="00" && ($filesname)!="000"){
            $target_dir = "../storage/img/";
            $target_file = $target_dir . $obstype ."_". basename($filesname);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            // Check if image file is a actual image or fake image
            if(isset($newpost["submit"])) {
                $check = getimagesize($filestmpname);
                if($check !== false) {
                    echo "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    return "El formato de su photo no es correcto.";
                    $uploadOk = 0;
                }
            }
            // Check if file already exists
            if (file_exists($target_file)) {
                return "Un foto con esa nombre ya existe";
                $uploadOk = 0;
            }
            // Check file size
            if ($filessize > 5000000000) {
                return "El tamano de su foto es demasiado grande";
                $uploadOk = 0;
            }
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                return "Solo JPG, JPEG, PNG y GIF son permitidos";
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                return "Hubo un problema con el cargo de su foto (1)";
            // if everything is ok, try to upload file
            } else {

           
                if (move_uploaded_file($filestmpname, $target_file)) {
                    echo "The file  has been uploaded.";
                    return  $obstype ."_". basename($filesname);
                } else {
                    return "Hubo un problema con el cargo de su foto (2)";
                }
            }
            return "Hubo un problema con el cargo de su foto (3)";
        }
        return ('No Presentado');
    }

    function uploadshape($shpname){
        if (strlen($_FILES[$shpname]["name"])){
            $target_dir = "../storage/shp/";
            $target_file = $target_dir . basename($_FILES[$shpname]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            // Check if image file is a actual image or fake image
            if(isset($_POST["submit"])) {
                $check = getimagesize($_FILES[$shpname]["tmp_name"]);
                if($check !== false) {
                    echo "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    echo "File is not an image.";
                    //$uploadOk = 0;
                }
            }
            // Check if file already exists
            if (file_exists($target_file)) {
                $uploadOk = 0;
            }
            // Check file size
            if ($_FILES[$shpname]["size"] > 5000000000) {
                $uploadOk = 0;
            }
            // Allow certain file formats
            
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
            // if everything is ok, try to upload file
            } else {

           
                if (move_uploaded_file($_FILES[$shpname]["tmp_name"], $target_file)) {
                    echo "The file  has been uploaded.";
                    return (basename( $_FILES[$shpname]["name"]));
                } else {
                    
                    echo "Sorry, there was an error uploading your file.";
                    
                }


                
            }
            return ('Failed');
        }
    
        return ('No Presentado');
    }