@include('inc/php_functions')
<?php 
if (!session('email')){
    return redirect()->to('/login')->send();
}

if ($_SERVER['REQUEST_METHOD']=="POST"){
	$lifeform=$_POST['dl_option'];
    $targetob='observacion_'.$lifeform;
    $email = session('email');
    $name=  explode("@" , $email)[0];
	$myfile= "C:\\Users\\fores\\Desktop\\sql\\{$name}_{$_POST['dl_option']}.csv";
    
    if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
        $myfile= "/postgres/{$name}_{$_POST['dl_option']}.csv";
    } 
    
    $sql = "COPY (SELECT * FROM {$targetob} 
    WHERE iden_email = '{$email}')
    TO '{$myfile}'
	with ( format CSV, HEADER)";

    $result = DB::select($sql, []);
	
    if (file_exists($myfile) && sizeof($result)>0) {
        header('Content-Description: File Transfer');
        header('Content-Type: Document');
        header('Content-Disposition: attachment; filename="'.basename($myfile).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Content-Length: ' . filesize($myfile));
        header('Pragma: public');
        readfile($myfile);
        exit();
    }else{
		session(['error' => ["No hay datos de {$lifeform}"]]);
		return redirect()->to('/descargar')->send();
	}
}
?>