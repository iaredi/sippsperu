@include('inc/php_functions')

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
			if($_POST['admin_option']=='cambio'){
                $sql = "UPDATE usuario set cambio_permitido ='si' WHERE email = :targetuser";
                $user_data = [':targetuser'=>$targetuser];
                $results = DB::delete($sql, $user_data);
                session(['adminerror'=>  "{$targetuser} se puede cambio su contraseña una vez (dile que su código  es su email)"]);
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
		
		if ($_POST['action']=="borrarmedicion") {
			if($_POST['selectmedicion']!="notselected"){
				$target=$_POST['selectmedicion'];
				$targetkey = askforkey('medicion', 'iden', 'iden_nombre', $target);
				$delresultloc=0;
				$delresultobs=0;
				$locList=['punto_ave','punto_arbol','punto_arbusto','punto_mamifero', 'transecto_hierba','transecto_herpetofauna'];


				//$medicion_empty=true;
				$delete_all = $_POST['borrar_forma_de_vida'] == 'medicion_completa';
				foreach ($locList as $loc) {
					$expoldeloc=explode("_" , $loc );
					if (($expoldeloc[1] == $_POST['borrar_forma_de_vida']) || $delete_all){
						$sql="SELECT iden FROM {$loc} WHERE iden_medicion=:value";
						$stmnt= DB::select($sql,[':value'=>$targetkey]);
						foreach ($stmnt as $row) { 
							$delresultobs=$delresultobs + DB::delete("DELETE FROM observacion_{$expoldeloc[1]} WHERE iden_{$expoldeloc[0]}=:value",[':value'=>$row->iden]); 
						}
						$delresultloc=$delresultloc + DB::delete("DELETE FROM {$loc} WHERE iden_medicion=:value",[':value'=>$targetkey]);
					}
					// $points_in_medicion = DB::SELECT("SELECT iden_{$expoldeloc[0]} FROM {$loc} where WHERE iden_medicion=:value",[':value'=>$targetkey]);
					// if (sizeof($points_in_medicion)>0){
					// 	$medicion_empty=false;
					// }

				}

				if ($delete_all){
					$delmedicion=DB::delete("DELETE FROM medicion WHERE iden_nombre=:value",[':value'=>$target]);
				}
				session(['adminerror'=>  "{$delresultloc} puntos/transectos borrados y {$delresultobs} observaciones borrados"]);
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
            if (isset($_POST["deletetable"]) && $_POST["deletetable"]==1){
                $layerresult= DB::delete("DELETE from additional_layers where tablename = ?", [$cargartablename]);
                DB::statement("drop table {$cargartablename}");
                session(['adminerror'=> "{$cargartablename} ha side borrado"]);            
            }else{
                $arraytopass = [$_POST['displayname'],$_POST['campoclick'],$_POST['lineacolor'],$_POST['fillcolor'],$_POST['fillopacidad']];
                array_push( $arraytopass,$_POST['lineaopacidad'],$_POST['lineaanchura'],$_POST['category'],$cargartablename);
                $layerresult= DB::update("UPDATE additional_layers set (displayname,featurecolumn,color,fillcolor,fillopacity,opacity,weight,category) = (?,?,?,?,?,?,?,?) where tablename = ?", $arraytopass);            
                session(['adminerror'=> "{$cargartablename} ha cambiado"]);
            }
		}
		
		if ($_POST['action']=="cambiar_especie") {
				$targettable=$_POST['cambiar_especie'];
				return redirect()->to("/cambiar/{$targettable}")->send();
            }

        

        
           
        

    } catch(PDOException $e) {
        echo "Error: ".$e->getMessage();
    }
}
?>