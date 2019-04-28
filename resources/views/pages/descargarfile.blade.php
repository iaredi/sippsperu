@include('inc/php_functions')
<p>ok</p>
<?php 
if (!session('email')){
    return redirect()->to('/login')->send();
}

if ($_SERVER['REQUEST_METHOD']=="POST"){
    

    $targetob='observacion_'.$_POST['dl_option'];
    $email = session('email');
    $name=  explode("@" , $email)[0];
	$myfile= "C:\\Users\\fores\\Desktop\\sql\\{$name}_{$_POST['dl_option']}.csv";
	$myfile2= "C:\\Users\\fores\\Desktop\\wow.txt";
    
    if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
        $myfile= "/postgres/{$name}_{$_POST['dl_option']}.csv";
    } 
    

    
    $sql = "COPY (SELECT * FROM {$targetob} 
    WHERE iden_email = '{$email}')
    TO '{$myfile}'
	with ( format CSV, HEADER)";

	
	// $db = env("DB_PASSWORD", "somedefaultvalue");
    // $dbname = env("DB_DATABASE", "somedefaultvalue");
	
	// $sql=
	// "\copy (SELECT * FROM {$targetob} 
	// WHERE iden_email = '{$email}') to '{$myfile}' with ( format CSV, HEADER) | PGPASSWORD='{$db}' psql -U plataforma -h localhost -d {$dbname}";
	
	// $sridshell= shell_exec($sql);
    $result = DB::select($sql, []);
    
	// echo $result;
	// echo $myfile;
	// echo 'wha';
    if (file_exists($myfile)) {
        header('Content-Description: File Transfer');
        header('Content-Type: Document');
        header('Content-Disposition: attachment; filename="'.basename($myfile).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($myfile));
        readfile($myfile);
        exit();
    }






}


?>