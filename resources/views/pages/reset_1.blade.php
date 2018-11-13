<?php
    session_start();
    session(['error' => []]);

    if ($_SERVER['REQUEST_METHOD']=='POST') {
        $email=$_POST['email'];
       if (DB::select('select email from usuario where email = ?', [$_POST['email']])){

            $length=10;
            $token = bin2hex(random_bytes($length));

            $from_email = "admin@imgenv.com";
            $reply_email = "admin@imgenv.com";
            $to=$email;
            $subject='forgot password';
            $body = "Code is : {$token}";
            $headers = "From: {$from_email}"."\r\n"."Reply-To: {$reply_email} "." \r\n "."X-Mailer: PHP/".phpversion();
            mail($to, $subject, $body, $headers);
            session(['mail' => [$to, $subject, $body, $headers]]);

            session(['token' => $token]);
            session(['emailreset' => $email]);
            return redirect()->to('/reset_2')->send();

        } else {
            session(['error' => ['email no existe']]);
        }
    } else {
        $email="";
        
    }
    
?>

    @include('inc/header')
        @include('inc/nav')
       
                    
    <div class="display: flex" style="text-align:center;">
        <div class=" d-inline-flex flex-column justify-content-center" style='width: 350px'>
            <?php 
                if (session('error')) {
                    foreach (session('error') as $msg) {
                        echo "<p class='bg-danger text-center'>{$msg}</p>";
                    }
                }
            ?>
            <form id="login-form"  method="post" role="form" style="display: block;">
                {{ csrf_field() }}
                <div class="form-group p-2">
                    <input type="text" name="email" id="email" tabindex="1" class="form-control" placeholder="Email" value='<?php echo $email; ?>' required>
                </div>

            <div class="form-group pt-2 pb-2 pl-5 pr-5 ">
                <div class="row">
                        <input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-success p-15" value="Mandar email">
                </div>
            </div>

            
            
                
            </form>
                               
        </div>
        </div>
        @include('inc/footer')
   