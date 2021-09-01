<?php
    if ($_SERVER['REQUEST_METHOD']=="POST"){
        if(isset($_POST['descargarexcel'])) {//Monitoreo de biodiversidad
            $filename="ingresarexcel.xlsx";
        }elseif(isset($_POST['descargarexcelRP'])){//Registros Previos
            $filename="registrosPrevios.xlsx";
        }elseif(isset($_POST['descargarexcelEP'])){//Peligro de Extinción
            $filename="peligroExtincion.xlsx";
        }
        $myfile= "C:\\wamp64\\www\\lsapp3\\public\\storage\\{$filename}";
        if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
            $myfile= "/var/www/html/lsapp3/public/storage/{$filename}";
        }

        if (file_exists($myfile)) {
            ob_clean();
            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment; filename='.$filename);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Content-Length: ' . filesize($myfile));
            header('Content-Transfer-Encoding: binary');
            header('Pragma: public');
            readfile($myfile);
            exit();
            ob_clean();
        }
    }
?>

@include('inc/header')
@include('inc/nav')
<div class='bodycontainer'>
    @include('inc/footer')   