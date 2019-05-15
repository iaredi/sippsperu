<?php


if ($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['descargarexcel'])) {
    $myfile= "C:\\wamp64\\www\\lsapp3\\public\\storage\\ingresarexcel.xlsx";
    if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
      $myfile= "/var/www/html/lsapp3/public/storage/ingresarexcel.xlsx";
    } 
    if (file_exists($myfile)) {
		ob_clean();
      header('Content-Description: File Transfer');
      header('Content-Disposition: attachment; filename=ingresarexcel.xlsx');
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	  header('Expires: 0');
	  header('Cache-Control: must-revalidate');
      header('Content-Length: ' . filesize($myfile));
      header('Content-Transfer-Encoding: binary');
      header('Pragma: public');
      readfile($myfile);
      exit();
    }
  }
?>

@include('inc/header')
@include('inc/nav')




@include('inc/footer')   