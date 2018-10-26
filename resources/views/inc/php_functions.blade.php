<?php

   function savenewentry($mytable, $myarray, $withemail=true){
        try {
            $placeholder="";
            $columnarray="";
            $sql1="INSERT INTO {$mytable} (";
            $sql3=   ") VALUES (";
            $sql5=   ");";
            foreach($myarray as $mycolumn=>$myval){
                $columnarray.=$mycolumn.',';
                $valarray[]=$myval;
                if ($myval=="CURRENT_DATE"){
                    $placeholder.='CURRENT_DATE,';
                }else{
                    $placeholdername=':value'.$mycolumn;
                    $placeholder.="{$placeholdername},";
                    $arraytopass[$placeholdername]=$myval;
                }
            }
            //Add user email function
            if ($withemail){
                $useremail=session('email');
                $mycolumn='iden_email';
                $myval= $useremail;
                $columnarray.=$mycolumn.',';
                $valarray[]=$myval;
                $placeholdername=':value'.$mycolumn;
                $placeholder.="{$placeholdername},";
                $arraytopass[$placeholdername]=$myval;
            }
            $sql2=substr_replace($columnarray ,"", -1);
            $sql4=substr_replace($placeholder ,"", -1);
            $completesql=$sql1.$sql2.$sql3.$sql4.$sql5;
            $results = DB::insert($completesql, $arraytopass);
            return ("{$mytable} ha sido guardado con exito");
        } catch(PDOException $e) {  
            return ("{$mytable} failed to save with error ". $e->getMessage());
        }
    }

function askforkey($mytable, $myprimary, $myfield,  $myvalue){
       try {
            $sql="SELECT {$myprimary} as {$myprimary} FROM {$mytable} WHERE {$myfield}=:value";
            $stmnt= DB::select($sql,[':value'=>$myvalue]);
            if(is_array($stmnt)){
                return $stmnt[0]->$myprimary;
            }else{
               return $stmnt->$myprimary; 
            }
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


    function savenewspecies($table,$comun,$cientifico ){
        $newspecies=array(
            "comun"=> $comun,
            "cientifico"=> $cientifico,
            "comun_cientifico"=> $comun."*".$cientifico
                );
        $namesmatching = DB::select("SELECT cientifico FROM {$table} WHERE cientifico=:value", [':value'=>$cientifico]);
        if (sizeof($namesmatching)==1){
            return askforkey($table, 'iden', "cientifico",  $cientifico);
        }else{
            $resultofquery = savenewentry($table, $newspecies);
            return getserialmax( $table);
        }
    }


   


    function countrows($tablename){
        $rownumlist=[];
        foreach($_POST as $key => $value) {
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


    function buildcolumnsarray($tablename, $rowandnum){
        try {
            $sql="SELECT column_name FROM information_schema.columns WHERE table_schema = 'public' AND table_name   = :tablename";
            $result= DB::select($sql,[':tablename'=>$tablename]);
            $colarray=array();
                foreach($result as $colobj){
                    if (explode("_" , $tablename)[0]!='observacion'){
                        $tablename='observacion_'.explode("_" , $tablename)[1];
                    };

                    $col=$colobj->column_name;
                    if (substr($col,0,4)!='iden'){
                        $colarray[$col]=$_POST["{$rowandnum}*{$tablename}*{$col}"];
                    }
                }
            return $colarray;
           
       } catch(PDOException $e) {
            return $e->getMessage();
       }
  }





    
    function uploadfoto($myRow, $obstype){
        $fotoinputid="{$myRow}*{$obstype}*foto";
        
        if (strlen($_FILES[$fotoinputid]["name"])){
            $target_dir = "img/";
            $target_file = $target_dir . $obstype . basename($_FILES[$fotoinputid]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            // Check if image file is a actual image or fake image
            if(isset($_POST["submit"])) {
                $check = getimagesize($_FILES[$fotoinputid]["tmp_name"]);
                if($check !== false) {
                    echo "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    echo "File is not an image.";
                    $uploadOk = 0;
                }
            }
            // Check if file already exists
            if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }
            // Check file size
            if ($_FILES[$fotoinputid]["size"] > 500000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            } else {


                if (move_uploaded_file($_FILES[$fotoinputid]["tmp_name"], $target_file)) {
                    //echo "The file ". basename( $_FILES[$fotoinputid]["name"]). " has been uploaded.";
                    return (basename( $_FILES[$fotoinputid]["name"]));
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }


                
            }
            return ('Failed');
        }
    
        return ('No Presentado');
    }
