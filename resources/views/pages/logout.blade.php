
<?php
    session(['email' => '']);
    session(['readpp' => '']);
    session(['admin' => '0']);
    return redirect()->to('/login')->send();
?>
