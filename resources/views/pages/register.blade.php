@include('inc/php_functions')
@include('inc/header')
@include('inc/nav')
<div class='bodycontainer' id="main">
    <section class="four">
        <div class="container">
            <header><h2>Registro</h2></header>
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
                        $error[] = "La contraseña tiene que ser mínimo de 6 caracteres.";
                    }
                    if ($_POST['password'] !=  $_POST['password_confirm']) {
                        $error[] = "Las contraseñas no son iguales.";
                    }

                    $email=DB::select('select email from usuario_permitido where email = ?', [$useremail]);
                    $emailvisitante=DB::select('select email from usuario_permitido where email = ?', [$useremail.'*']);

                    if (!$email && !$emailvisitante) {
                        $error[] = "El email '{$_POST['email']}' no ha sido aprobado. Contáctenos en el siguiente email: sipps.peru@gmail.com.";
                    }
                    
                    if (DB::select('select email from usuario where email = ?', [$useremail])) {
                        $error[] = "El email '{$_POST['email']}' ya está registrado. Por favor, haga clic en Iniciar sesión o utilice la opción para reiniciar su contraseña.";
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
                                echo "<p class='text-dark text-center''>{$msg}</p>";
                            }
                        }
                    }
                ?>
            </div>
                
            <form id="register-form" method="post" role="form" >
                <div class="row">
                    {{ csrf_field() }}
                    <div class="col-12"><input type="text" name="nombre" id="Nombre" placeholder="Nombre" value="<?php echo $nombre ?>" required size="65%" ></div>
                    <div class="col-12"><input type="text" name="apellido_materno" id="apellido_materno"  placeholder="Apellido Materno" size="65%" value="<?php echo $apellido_materno ?>" required ></div>
                    <div class="col-12"><input type="text" name="apellido_paterno" id="apellido_paterno"  placeholder="Apellido Paterno" size="65%" value="<?php echo $apellido_paterno ?>" required ></div>
                    <div class="col-6 col-12-mobile"><input type="email" name="email" id="register_email"  placeholder="Email" size="19%" value="<?php echo $email ?>" required ></div>
                    <div class="col-6 col-12-mobile"><input type="text" name="telefono" id="telefono"  placeholder="Teléfono" size="19%" value="<?php echo $telefono ?>" required ></div>
                    <div class="col-12"><input type="text" name="direccion" id="direccion"  placeholder="Dirección" size="65%" value="<?php echo $direccion ?>" required ></div>
                    <div class="col-6 col-12-mobile"><input type="password" name="password" id="password"  placeholder="Contraseña" size="19%" value = "<?php echo $pword ?>" required></div>
                    <div class="col-6 col-12-mobile"><input type="password" name="password_confirm" id="confirm-password"  size="19%" placeholder="Confirma Contraseña" value = "<?php echo $pword_conf ?>" required></div>
                    <div class="col-12"><textarea name="notas" id="notas" tabindex="7"   placeholder="Notas"><?php echo $notas ?></textarea></div>

                    <div class="form-group self-align-center p-3"style="width:50%;margin: auto;">
                        <input type="submit" id="register-submit" class="mySubmit" name="register-submit" value="Registro">
                    </div>
                </div>
            </form>
        </div>
        @include('inc/footer')
    </section>