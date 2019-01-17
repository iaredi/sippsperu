<?php
if (!session('email')){
    return redirect()->to('/login')->send();
}
?>

@include('inc/udploadlayers')
<!DOCTYPE html>
<html lang="sp">
    
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png" href="plant.png">
        <meta charset="UTF-8">
        <title>MTP Biodiversidad</title>

    <script src="js/app.js"></script>
    </head>
    <body id="udpbody">

        <div class="container">
        </div> <!--Container-->
        <div id="app"></div>
        <link rel="stylesheet" href="leaflet_assets/leaflet.css"> 
        <script src="{{ asset('leaflet_assets/udpindex.js') }}" ></script>  
    </body>
    
</html>
        


