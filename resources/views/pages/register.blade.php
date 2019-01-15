@include('inc/php_functions')
@include('inc/header')
@include('inc/nav')

<?php
    if ($_SERVER['REQUEST_METHOD']=="POST") {
        $error=[];
        $nombre = $_POST['nombre'];
        $apellido_materno = $_POST['apellido_materno'];
        $apellido_paterno = $_POST['apellido_paterno'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $notas = $_POST['notas'];
        $useremail = $_POST['email'];
        $pword = $_POST['password'];
        $pword_conf = $_POST['password'];
        $comments = $_POST['notas'];
        
        if (strlen( $_POST['password'])<6) {
            $error[] = "contrasenia tiene que ser minimo de 6 caracteres ";
        }
        if ($_POST['password'] !=  $_POST['password_confirm']) {
            $error[] = "Las contrasenias no son iguales";
        }

        $email=DB::select('select email from usuario_permitido where email = ?', [$useremail]);
        $emailvisitante=DB::select('select email from usuario_permitido where email = ?', [$useremail.'*']);

        if (!$email && !$emailvisitante) {
            $error[] = "Email '{$_POST['email']}' no es aprovado. Contáctenos en forest.carter@gmail.com ";
        }
        
        if (DB::select('select email from usuario where email = ?', [$useremail])) {
            $error[] = "Email '{$_POST['email']}' ya esta registrado. Por favor, login o reiniciar su contrasenia ";
        }

        if (!($error)) {
            $visitante='2';
            if($emailvisitante){
                $visitante='1';
            }
            $usuarioscolumns=array(
                "visitante"=> intval($visitante),
                "nombre"=> $_POST['nombre'],
                "apellido_materno"=> $_POST['apellido_materno'],
                "apellido_paterno"=> $_POST['apellido_paterno'],
                "email"=> $useremail,
                "hash_password"=> password_hash($_POST['password'],PASSWORD_BCRYPT),
                "telefono"=> $_POST['telefono'],
                "direccion"=> $_POST['direccion'],
                "fecha_ultimo_login"=> "CURRENT_DATE",
                "fecha_activacion"=> "CURRENT_DATE",
                "notas"=> $_POST['notas']
                    );   
            $resultofusuariosquery[]= savenewentry("usuario", $usuarioscolumns,false);
        }
        $email="";
        $pword="";
        $pword_conf="";

    } else {
        $nombre="";
        $apellido_materno="";
        $apellido_paterno="";
        $email="";
        $telefono="";
        $direccion="";
        $pword="";
        $pword_conf="";
        $notas="";
    }
?>
      
<div class=" d-flex flex-column justify-content-around align-items-center" >
    <div>
        <?php 
            if (isset($error)) {
                foreach ($error as $msg) {
                    echo "<p class='bg-danger2 text-center'>{$msg}</p>";
                }
            }
            if (isset($resultofusuariosquery)) {
                foreach ($resultofusuariosquery as $msg) {
                    if (strpos($msg, 'exito') !== false){
                        echo "<p class='text-dark text-center' style='background-color: lightsteelblue;'>{$msg}</p>";
                    }
                }
            }
        ?>
    </div>
    
    <div style="width:60%;">
        <form id="register-form" method="post" role="form" >
                {{ csrf_field() }}
            <div class="form-group">
                <input type="text" name="nombre" id="Nombre" tabindex="1" class="form-control" placeholder="Nombre" value="<?php echo $nombre ?>" required >
            </div>
            <div class="form-group">
                <input type="text" name="apellido_materno" id="apellido_materno" tabindex="2" class="form-control" placeholder="Apellido Materno" value="<?php echo $apellido_materno ?>" required >
            </div>
            <div class="form-group">
                <input type="text" name="apellido_paterno" id="apellido_paterno" tabindex="3" class="form-control" placeholder="Apellido Paterno" value="<?php echo $apellido_paterno ?>" required >
            </div>
            <div class="form-group">
                <input type="email" name="email" id="register_email" tabindex="4" class="form-control" placeholder="Email" value="<?php echo $email ?>" required >
            </div>
            <div class="form-group">
                <input type="text" name="telefono" id="telefono" tabindex="4" class="form-control" placeholder="Telefono" value="<?php echo $telefono ?>" required >
            </div>
            <div class="form-group">
                <input type="text" name="direccion" id="direccion" tabindex="4" class="form-control" placeholder="Direccion" value="<?php echo $direccion ?>" required >
            </div>
            <div class="form-group">
                <input type="password" name="password" id="password" tabindex="5" class="form-control" placeholder="Contraseña" value = "<?php echo $pword ?>" required>
            </div>
            <div class="form-group">
                <input type="password" name="password_confirm" id="confirm-password" tabindex="6" class="form-control" placeholder="Confirma Contraseña" value = "<?php echo $pword_conf ?>" required>
            </div>
            <div class="form-group">
                <textarea name="notas" id="notas" tabindex="7" class="form-control"  placeholder="Notas"><?php echo $notas ?></textarea>
            </div>
            <div class="form-group self-align-center p-3"style="width:50%;margin: auto;">
                <input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn  btn-success p-15" value="Registro">
            </div>
        </form>
    </div>
</div>
    @include('inc/footer')
