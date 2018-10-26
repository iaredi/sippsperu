<?php
    

   $root_directory = "testdir";
    if ($_SERVER['REQUEST_METHOD']=='POST') {
        $email=$_POST['email'];
        $password=$_POST['password'];
       if (DB::select('select email from usuario where email = ?', [$_POST['email']])){
         
            $gethashpassword=DB::select('select hash_password from usuario where email = ?', [$_POST['email']]);

            if (password_verify($_POST['password'], $gethashpassword[0]->hash_password)) {
            
                echo("Logged in successfully");
                session_start();
                //update_login_date($pdo, $email);
                //check for admin
                if (DB::select('select administrador from usuario where email = ?', [$_POST['email']])){
                //if (askforkey($pdo,"usuario", "administrador", "email", $_POST['email'])){
             
                    session(['admin' => 1]);
                }else{
                    session(['admin' => 0]);
                }
                session(['email' => $email]);
                return redirect()->to('/ingresardatos')->send();

            } else {
            }
            
        } else {
        }
    } else {
        $email="";
        $password="";
    }
    
?>

    @include('inc/header')
        @include('inc/nav')
        
                    <?php 
                        if (isset($_SESSION['error'])) {
                            foreach ($session['error'] as $msg) {
                                echo "<p class='bg-danger text-center'>{$msg}</p>";
                            }
                        }
                    ?>
    <div class="display: flex" style="text-align:center;">
        <div class=" d-inline-flex flex-column justify-content-center" style='width: 350px'>
            <form id="login-form"  method="post" role="form" style="display: block;">
                {{ csrf_field() }}
                <div class="form-group p-2">
                    <input type="text" name="email" id="email" tabindex="1" class="form-control" placeholder="Email" value='<?php echo $email; ?>' required>
                </div>
                <div class="form-group p-2">
                    <input type="password" name="password" id="login-
                password" tabindex="2" class="form-control" placeholder="Contraseña" value='<?php echo $password; ?>' required>
                </div>
                
                <div class="form-group pt-2 pb-2 pl-5 pr-5 ">
                    <div class="row">
                            <input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-success p-15" value="Log In">
                    </div>
                </div>
                <div class="form-group p-2">
                    <div class="row justify-content-center" style='text-align:center;'>
                            <a href="reset_1.php" tabindex="5" class="btn btn-success p-15">Reiniciar su contraseña</a>
                    </div>
                </div>
            </form>
                               
        </div>
        </div>
        @include('inc/footer')
   