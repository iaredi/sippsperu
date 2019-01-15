
<?php
if ($_SERVER['REQUEST_METHOD']=="POST"){
    $resultofquery=[];

    try {
        if ($_POST['action']=="activo") {
            $targetuser=$_POST['selectusuario'];
            if($_POST['admin_option']=='add_admin'){
                $sql = "UPDATE usuario SET administrador = true WHERE email = :targetuser";
                $user_data = [':targetuser'=>$targetuser];
                $results = DB::update($sql, $user_data);
                session(['adminerror'=>  "{$targetuser} ahora es admin"]);

            }
            if($_POST['admin_option']=='remove_admin'){
                $sql = "UPDATE usuario SET administrador = false WHERE email = :targetuser";
                $user_data = [':targetuser'=>$targetuser];
                $results = DB::update($sql, $user_data);
                session(['adminerror'=>  "{$targetuser} ahora no es admin"]);

            }
            if($_POST['admin_option']=='delete_user'){
                $sql = "DELETE FROM usuario WHERE email = :targetuser";
                $user_data = [':targetuser'=>$targetuser];
                $results = DB::delete($sql, $user_data);
                session(['adminerror'=>  "{$targetuser} ha sido borrado"]);
            }
        }
        if ($_POST['action']=="permitido") {
            
            if($_POST['admin_option']=='add_email'){
                $visitante='';
                if (isset($_POST['visitante'])){
                    $visitante='*';
                }
               
                $targetuser=$_POST['email_input'].$visitante;

                $sql = "insert into usuario_permitido (email) values(:targetuser)";
                $user_data = [':targetuser'=>trim($targetuser)];
                $results = DB::insert($sql, $user_data);
                session(['adminerror'=> "{$targetuser} ha sido agregado"]);

            }
            if($_POST['admin_option']=='remove_email'){
                $targetuser=$_POST['selectusuario_permitido'];
                $sql = "DELETE FROM usuario_permitido WHERE email = :targetuser";
                $user_data = [':targetuser'=>$targetuser];
                $results = DB::delete($sql, $user_data);
                session(['adminerror'=>  "{$targetuser} ha sido borrado de los permitidos"]);
            }

        }

        if ($_POST['action']=="delete_field") {
                $targettable=$_POST['table_option'];
                $targetcampo=$_POST['field_option'];
                $sql = "alter table {$targettable} drop column {$targetcampo}";
                $user_data = [];
                $results = DB::delete($sql, $user_data);
                session(['adminerror'=>  "{$targetcampo} ha sido borrado de {$targettable}"]);
            }

        if($_POST['action']=='add_field'){
            $targettable=$_POST['table_option2'];
            $datatype=$_POST['datatype'];
            $targetcampo=$_POST['field_input'];
            $sql = "alter table {$targettable} add column {$targetcampo} {$datatype}";
            $user_data = [];
            $results = DB::statement($sql, $user_data);
            session(['adminerror'=> "{$targetcampo} ha sido agregado en {$targettable}"]);
        }

        if($_POST['action']=='cargarshape'){
            
            $selectsql = "select tablename from additional_layers where displayname=?";
            $cargartablename = (DB::select($selectsql, [$_POST["selectadditional_layers"]]))[0]->tablename;
            if ($_POST["deletetable"]==1){
                $layerresult= DB::delete("DELETE from additional_layers where tablename = ?", [$cargartablename]);
                DB::statement("DROP table ?", [$cargartablename]);
                session(['adminerror'=> "{$cargartablename} ha side borrado"]);            
            }else{
                $arraytopass = [$_POST['displayname'],$_POST['lineacolor'],$_POST['fillcolor'],$_POST['fillopacidad']];
                array_push( $arraytopass,$_POST['lineaopacidad'],$_POST['lineaanchura'],$cargartablename);
                $layerresult= DB::update("UPDATE additional_layers set (displayname, color,fillcolor,fillopacity,opacity,weight) = (?,?,?,?,?,?) where tablename = ?", $arraytopass);            
                session(['adminerror'=> "{$cargartablename} ha cambiado"]);
            }
        }

        

        
           
        

    } catch(PDOException $e) {
        echo "Error: ".$e->getMessage();
    }
}
?>