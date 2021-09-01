
<?php
    session_start();
    session(['error' => []]);

    if ($_SERVER['REQUEST_METHOD']=='POST') {
        $email=$_POST['email'];
       if (DB::select('select email from usuario where email = ?', [$_POST['email']])){

            $length=10;
            $token = bin2hex(random_bytes($length));

            $from_email = "admin@biodiversidadpuebla.online";
            $reply_email = $from_email;
            $to=$email;
            $subject='Biodiversity Puebla - Reiniciar su contraseña';
            $body = "Code is : {$token}";
			$headers = "From: {$from_email}";
			
			$headers   = array();
			$headers[] = "MIME-Version: 1.0";
			$headers[] = "Content-type: text/plain; charset=utf-8";
			
			$headers[] = "X-Mailer: PHP/".phpversion();



			echo var_dump($to, $subject, $body, implode("\r\n",$headers));
			ini_set('sendmail_from', $from_email);
			if(mail($to, $subject, $body, implode("\r\n",$headers), "-f admin@biodiversidadpuebla.online")){
				
				session(['mailmessage' => "Hemos mandado un correo a {$to}. Por favor, verifique la carpeta de spam!"]);
			}else{
				session(['mailmessage' => "Email no enviado"]);
			}
			

            session(['token' => $token]);
            session(['emailreset' => $email]);
            //return redirect()->to('/reset_2')->send();

        } else {
            session(['error' => ['Error al iniciar sesión. Verifique sus datos.']]);
        }
    } else {
        $email="";
        
    }
    
?>

@include('inc/header')
@include('inc/nav')
    
<div class='bodycontainer' id="main">
    <section class="four">
        <div class="container">
            <header><h2>Recuperar contraseña</h2></header>      
            <div class="display: flex" style="text-align:center;">
                <div class=" d-inline-flex flex-column justify-content-center" style='width: 350px'>
                    <?php 
                        if (session('error')) {
                            foreach (session('error') as $msg) {
                                echo "<p class='bg-danger2 text-center'>{$msg}</p>";
                            }
                        }
                    ?>
                    <form id="login-form"  method="post" role="form" style="display: block;">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-12"><input type="text" name="email" id="email" placeholder="Email" value='<?php echo $email; ?>' required /></div>
                            <div class="col-12"><input type="submit" name="login-submit" id="login-submit" value="Mandar email"></div>
                        </div>
                    </form>      
                </div>
            </div>
        </div>
        @include('inc/footer')
    </section>