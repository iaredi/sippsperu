@include('inc/php_functions')
@include('inc/header')
@include('inc/nav')
<div class='bodycontainer'>
    <?php
        $resultofusuariosquery =[];

        if ($_SERVER['REQUEST_METHOD']=="POST") {
            $error=[];
            $pword = $_POST['password'];
            $pword_conf = $_POST['password'];
        
            if (strlen( $_POST['password'])<6) {
                $error[] = "Contraseña tiene que ser minimo de 6 caracteres ";
            }
            if ($_POST['password'] !=  $_POST['password_confirm']) {
                $error[] = "Las contraseñas no son iguales";
            }
            $changed_via_admin = false;
            $emailsmatching = DB::SELECT("SELECT iden_email FROM usuario where cambio_permitido = 'si' and email = ?",[$_POST['token']]);
            if (sizeof($emailsmatching)>0) {
                $changed_via_admin = true;
                session(['emailreset' => $_POST['token']]);
            }else{
                if ($_POST['token'] !=  session('token')) {
                    $error[] = "El codigo no es correcto";
                }
            }

            if (!$error) {
                $email = session('emailreset');
                $password = password_hash($_POST['password'],PASSWORD_BCRYPT);
                $sql = "UPDATE usuario set hash_password = :password WHERE email = :email";
                $user_data = [':email'=>$email,':password'=>$password];
                $results = DB::update($sql, $user_data);
                if($changed_via_admin){
                    $sql2 = "UPDATE usuario set cambio_permitido = 'no' WHERE email = :email";
                    $results2 = DB::update($sql2, [':email'=>$email]);
                }
                if($results==1){
                    $resultofusuariosquery[]="Su contraseña ha sido cambiado";
                }else{
                    $resultofusuariosquery[]="Su contraseña no ha sido cambiado";
                }
            }        
            $email="";
            $pword="";
            $pword_conf="";
        } else {
            $email="";
            $pword="";
            $pword_conf="";
            $resultofusuariosquery[] =session('mailmessage');
        }
    ?>
      

    <div class=" d-flex flex-column justify-content-around align-items-center" >    
        <div>
            <?php 
                if (isset($error)) {
                    foreach ($error as $msg) {
                        echo "<h4 class='bg-danger2 text-center'>{$msg}</h4>";
                    }
                }
                echo "<p class='text-dark text-center'  '>Si no receibes el email, se puede pedir accesso a jesus.castan@semarnat.gob.mx </p>";
                if (isset($resultofusuariosquery)) {
                    foreach ($resultofusuariosquery as $msg) {
                        echo "<p class='text-dark text-center'  '>{$msg}</p>";
                    }
                }
            ?>
        </div>
        
        <div style="width:60%;">
            <form id="register-form" method="post" role="form" >
                    {{ csrf_field() }}
                <div class="form-group">
                    <input type="text" name="token" id="token" tabindex="4" class="form-control" placeholder="codigo" value="" required >
                </div>
                <div class="form-group">
                    <input type="password" name="password" id="password" tabindex="5" class="form-control" placeholder="Contraseña Nueva" value = "<?php echo $pword ?>" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password_confirm" id="confirm-password" tabindex="6" class="form-control" placeholder="Confirma Contraseña Nueva" value = "<?php echo $pword_conf ?>" required>
                </div>
                <div class="form-group self-align-center p-3"style="width:50%;margin: auto;">
                    <input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn  btn-success p-15" value="Cambiar Contraseña">
                </div>  
            </form>
        </div>
    </div>
    @include('inc/footer')
