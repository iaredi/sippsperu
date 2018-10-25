@include('inc/header')
@include('inc/php_functions')
@include('inc/nav')

<?php

    if ($_SERVER['REQUEST_METHOD']=="POST") {
        $nombre = $_POST['nombre'];
        $apellido_materno = $_POST['apellido_materno'];
        $apellido_paterno = $_POST['apellido_paterno'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $notas = $_POST['notas'];
        $email = $_POST['email'];
        
        $pword = $_POST['password'];
        $pword_conf = $_POST['password'];
        $comments = $_POST['notas'];
        
        
        
        if (strlen( $_POST['password'])<6) {
            $error[] = "contrasenia tiene que ser minimo de 6 caracteres  ";
        }
        if ($_POST['password'] !=  $_POST['password_confirm']) {
            $error[] = "Las contrasenias no son iguales";
        }

        if (!DB::select('select email from usuario_permitido where email = ?', [$_POST['email']])) {
            $error[] = "Email '{$_POST['email']}' no es aprovado. Contáctenos en admin@semarnat.org ";
        }
        if (DB::select('select email from usuario where email = ?', [$_POST['email']])) {
            $error[] = "Email '{$_POST['email']}' ya esta registrado. Por favor, login o reiniciar su contrasenia ";
        }


        if (!isset($error)) {

            $usuarioscolumns=array(
                "nombre"=> $_POST['nombre'],
                "apellido_materno"=> $_POST['apellido_materno'],
                "apellido_paterno"=> $_POST['apellido_paterno'],
                "email"=> $_POST['email'],
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

    <body>
      

        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-lg-offset-3">
                    <?php 
                        if (isset($error)) {
                            foreach ($error as $msg) {
                                echo "<h4 class='bg-danger text-center'>{$msg}</h4>";
                            }
                        }
                        if (isset($resultofusuariosquery)) {
                            foreach ($resultofusuariosquery as $msg) {
                                echo "<h4 class=bg-info text-center'>{$msg}</h4>";
                            }
                        }
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-login">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
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
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6 col-sm-offset-3">
                                                    <input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-custom" value="Registro">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('inc/footer')

    </body>
</html>