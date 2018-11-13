@include('inc/php_functions')
@include('inc/header')
@include('inc/nav')

<?php
$resultofusuariosquery =session('mailmessage');


    if ($_SERVER['REQUEST_METHOD']=="POST") {

        $error=[];
        $resultofusuariosquery=[];
       
        $pword = $_POST['password'];
        $pword_conf = $_POST['password'];
       
        if (strlen( $_POST['password'])<6) {
            $error[] = "contrasenia tiene que ser minimo de 6 caracteres ";
        }
        if ($_POST['password'] !=  $_POST['password_confirm']) {
            $error[] = "Las contrasenias no son iguales";
        }
        if ($_POST['token'] !=  session('token')) {
            $error[] = "El codigo no es correcto";
        }

        if (!$error) {
            $email= session('emailreset');
            $password = password_hash($_POST['password'],PASSWORD_BCRYPT);
            $sql = "update usuario set hash_password = :password WHERE email = :email";
            $user_data = [':email'=>$email,':password'=>$password];
            $results = DB::update($sql, $user_data);
            
            $resultofusuariosquery[]="Su contraseña ha sido cambiado";

        }
        
        
        $email="";
        $pword="";
        $pword_conf="";



    } else {
        $email="";
        $pword="";
        $pword_conf="";
    
    }
?>
      

        <div class=" d-flex flex-column justify-content-around align-items-center" >
                       
                <div>
                    <?php 
                        if (isset($error)) {
                            foreach ($error as $msg) {
                                echo "<h4 class='bg-danger text-center'>{$msg}</h4>";
                            }
                        }
                        if (isset($resultofusuariosquery)) {
                            foreach ($resultofusuariosquery as $msg) {
                                echo "<p class='text-dark text-center' style='background-color: lightsteelblue;'>{$msg}</p>";

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
                                            <input type="password" name="password" id="password" tabindex="5" class="form-control" placeholder="Contraseña" value = "<?php echo $pword ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password_confirm" id="confirm-password" tabindex="6" class="form-control" placeholder="Confirma Contraseña" value = "<?php echo $pword_conf ?>" required>
                                        </div>
                                       
                                
                                        <div class="form-group self-align-center p-3"style="width:50%;margin: auto;">
                                            <input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn  btn-success p-15" value="Cambiar Contraseña">
                                        </div>
                                           
                                    </form>
                  
         </div>
         </div>
    @include('inc/footer')
