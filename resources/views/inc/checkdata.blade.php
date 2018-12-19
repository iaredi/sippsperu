<?php
$errorlist=[];
if ($_SERVER['REQUEST_METHOD']=="POST") {

    foreach( $_FILES as $postkey2=> $postvalwithoutname) {
        $tablename= explode("*" , $postkey2)[1];
        $postval=$postvalwithoutname['name'];
        if (DB::select("SELECT iden_foto FROM {$tablename} WHERE iden_foto  = :value", [':value'=>$postval])) {
            $errorlist[]= "El foto {$postval} ya existe, por favor cambie el nombre del foto";
        }
    }
    foreach( $_POST as $postkey=> $postval) {
        if ($postval=='notselected') {
            $selectmenuname= substr($postkey, 6);
            $errorlist[]= "Los menus desplegables no deben estar vacios";
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
                    $errorlist[]= "El campo '{$columnname}' de {$tablename} esta vacio";
                }
                //Handle non-empty fields
            }else{
       
                if ($columnname=='clave' && !(strlen($postval)==3 && ctype_alpha($postval))) {
                    $errorlist[]= "El campo 'clave' de {$tablename} tiene que ser 3 letras";
                }
                if ($columnname=='clave' && DB::select("SELECT {$columnname} FROM {$tablename} WHERE {$columnname}  = :value", [':value'=>$postval])) {
                    $errorlist[]= "El clave {$postval} ya existe, ingrese un clave diferente";
                }
                if (($columnname=='superficie') && !(is_numeric($postval))) {
                    $errorlist[]= "El campo 'superficie' de {$tablename} tiene que ser numero";
                }
                if ($columnname=='telefono' && strlen($postval)>0 && !(is_numeric($postval))) {
                    $errorlist[]= "El campo 'telefono' de {$tablename} tiene que ser solo numeros";
                }
                if (strpos($columnname, 'itud') !== false && !(is_numeric($postval))) {
                    $errorlist[]= "El campo '{$columnname}' de {$tablename} tiene que ser numero";
                }
                if (strpos($columnname, 'longitud') !== false && (!($postval<-80) || !($postval>-120))) {
                    $errorlist[]= "El campo '{$columnname}' de {$tablename} tiene que ser entre -80 y -120 grados";
                }
                if (strpos($columnname, 'latitud') !== false && (!($postval>14) || !($postval<34))) {
                    $errorlist[]= "El campo '{$columnname}' de {$tablename} tiene que ser entre 14 y 34 grados";
                }
                if ($postval=='notselected' && $columnname !='notas') {
                    $errorlist[]= "{$tablename} esta vacio";
                }
            }
        }
    }
}
session(['error' => $errorlist]);
?>