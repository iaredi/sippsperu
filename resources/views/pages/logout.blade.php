
<?php
    $result=DB::statement("delete from puntosmtp_udas where iden_uda in (SELECT gid FROM usershapes WHERE iden_email='".session('email')."' and temp_shape=true);");
    $result=DB::statement("delete from usershapes where iden_email='".session('email')."' and temp_shape=true;");
    
    session_start();
    session(['email' => '']);
    session(['readpp' => '']);
    session(['admin' => '0']);
    session_destroy();
    return redirect()->to('/login')->send();
?>