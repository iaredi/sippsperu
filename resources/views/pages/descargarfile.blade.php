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
    $tmpDir="/var/www/html/lsapp3/storage/csvReports/";

    if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
        $myfile= "{$name}_{$_POST['dl_option']}.csv";
    }
    
    $table='punto';
    if($lifeform=='herpetofauna'||$lifeform=='hierba'){
        $table='transecto';
    }

    $consulta="select oa.* , p.nombre as Predio, mu.nomgeo as Distrito
        from observacion_{$lifeform} oa
        inner join {$table}_{$lifeform} pa on oa.iden_{$table}=pa.iden
        inner join medicion m on pa.iden_medicion=m.iden
        inner join linea_mtp lmpt on m.iden_linea_mtp=lmpt.iden
        inner join predio p on lmpt.iden_predio=p.iden
        inner join municipio mu on p.clave_municipio=mu.gid ";
    
    $sql = "COPY ({$consulta}";
    if (session('admin')!=1){
        $sql.="WHERE oa.iden_email = '{$email}'";
    }
    
    $sql.=") TO '$tmpDir$myfile' with ( format CSV, HEADER)";
    
    $result = DB::select($sql, []);
    
    if (file_exists($tmpDir.$myfile) && sizeof($result)>0) {
        header('Content-Description: File Transfer');
        header('Content-Type: Document');
        header('Content-Disposition: attachment; filename="'.basename($tmpDir.$myfile).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Content-Length: ' . filesize($tmpDir.$myfile));
        header('Pragma: public');
        readfile($tmpDir.$myfile);
        exit();
    }else{
        session(['error' => ["No hay datos de {$lifeform}"]]);
        return redirect()->to('/descargar')->send();
    }
}
?>