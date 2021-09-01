<?php
    session_start();
    session(['error' => []]);
    if ($_SERVER['REQUEST_METHOD']=='POST') {
        $email=$_POST['email'];
        $password=$_POST['password'];
       	if (DB::select('select email from usuario where email = ?', [$_POST['email']])){
         
            $gethashpassword=DB::select('select hash_password from usuario where email = ?', [$_POST['email']]);

            if (password_verify($_POST['password'], $gethashpassword[0]->hash_password)) {
                echo("Logged in successfully");
                //Assign Visitante
                if (DB::select('select visitante from usuario where email = ?', [$_POST['email']])[0]->visitante=='1'){
                    session(['visitante' => 1]);
                }else{
                    session(['visitante' => 0]);
                }
                //Assign Admin
                if (DB::select('select administrador from usuario where email = ?', [$_POST['email']])[0]->administrador=='true'){
                    session(['admin' => 1]);
                }else{
                    session(['admin' => 0]);
				}
				//Assign Read PP
                if (DB::select('select readpp from usuario where email = ?', [$_POST['email']])[0]->readpp=='true'){
                    session(['readpp' => 'true']);
                }
                session(['email' => $email]);
                session(['error' => ['']]);
                DB::update('update usuario set fecha_ultimo_login = CURRENT_DATE where email = ?', [$_POST['email']]);
                DB::update('update usuario set hora_ultimo_login = CURRENT_TIME where email = ?', [$_POST['email']]);

                //borra los shapes temporales del usuario
                DB::statement("delete from puntosmtp_udas where iden_uda in (SELECT gid FROM usershapes WHERE iden_email='".session('email')."' and temp_shape=true);");
                DB::statement("delete from usershapes where iden_email='".session('email')."' and temp_shape=true;");

                return redirect()->to('/mostrarmapas')->send();
            } else {
                session(['error' => ['Error en los datos de inicio de sesi&oacute;n']]);
            }
        } else {
            session(['error' => ['Error al iniciar sesión. Verifique sus datos.']]);
        }
    } else {
        $email="";
        $password="";
    }
?>

@include('inc/header')
@include('inc/nav')
<div class='bodycontainer' id="main">
    <section class="three">
        <div class="container">
            <br>
            <header><h3>Sistema de Informaci&oacute;n para la Planeaci&oacute;n 
                de los Paisajes Sostenibles Provincia de Oxapampa Perú</h3></header>  
            <!------------------>
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body customer-box">
                        <div class="tab-content">
                            <?php 
                                if (session('error')) {
                                    foreach (session('error') as $msg) {
                                        echo "<p class='errorMsg'>{$msg}</p>";
                                    }
                                }
                            ?>

                <p class='warningMsg'>Debido a los c&aacute;lculos necesarios para mostrar el mapa interactivo, el inicio de sesi&oacute;n puede demorar varios minutos. Por favor sea paciente.</p>

                            <form  method="post" class="form-horizontal" role="form">
                                <div class="row">
                                    {{ csrf_field() }}
                                    <div class="col-12"><input class="loginfield" id="email" placeholder="Email" type="text" name="email" tabindex="1" value='<?php echo $email; ?>' required></div>
                                    <div class="col-12"><input class="loginfield" id="login-password" placeholder="Contrase&ntilde;a" type="password" name="password" tabindex="2" value='<?php echo $password;?>' required></div>
                                    <div class="col-12">
                                        <button type="submit" tabindex="3" name="login-submit" id="login-submit">Iniciar sesi&oacute;n</button>
                                        <a class="for-pwd" href="/reset_1"  tabindex="4">¿Olvidaste tu contraseña?</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!------------------>
            <div id="loginFooter" class="creditFooter">
                <p class="creditos"><strong>Desarrollo conceptual :</strong> <br/> Jesús Hernández Castán, Alfredo Gámez,
                <br/> Daniel Espinoza, Tonatiuh González <br/></p>
                <br>
                <p class="creditos">
                    <strong>Código base de código abierto programado por: </strong> <br/> Forest Carter
                    <br /><br />
                    <strong>Puntos de mejora implementados para Perú: </strong> <br/> Yared Sabinas Figueroa
                </p>
            </div>
        </div>
    </section>


    @include('inc/footer')
