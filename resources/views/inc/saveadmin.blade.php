
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
    }else{
        
        if($_POST['admin_option']=='add_email'){
            $targetuser=$_POST['email_input'];
            $sql = "insert into usuario_permitido (email) values(:targetuser)";
            $user_data = [':targetuser'=>$targetuser];
            $results = DB::insert($sql, $user_data);
            session(['adminerror'=> "{$targetuser} has sido agregado"]);

        }
        if($_POST['admin_option']=='remove_email'){
            $targetuser=$_POST['selectusuario_permitido'];
            $sql = "DELETE FROM usuario_permitido WHERE email = :targetuser";
            $user_data = [':targetuser'=>$targetuser];
            $results = DB::delete($sql, $user_data);
            session(['adminerror'=>  "{$targetuser} ha sido borrado desde los permitidos"]);
        }

    }

    } catch(PDOException $e) {
        echo "Error: ".$e->getMessage();
    }
}
?>