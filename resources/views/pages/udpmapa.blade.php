<?php
if (!session('email')){
    return redirect()->to('/login')->send();
}
if (!session('readpp')){
  return redirect()->to('/privacidad')->send();
}

//si al final del iden_udp no se especifica una p, entonces se trata del despliegue de una UDP.
//Si se indica una p, entonces se trata de un poligono
$headerType=is_numeric(substr($idennum,-1))?'u':'p';
$idennum=$headerType=='p'?substr($idennum,0,-1):$idennum;
$infoType=json_encode($headerType=='p'?'poligono':'udp');
$uAnalisis=json_encode($headerType=='p'?' Polígono ':' UP ');
$geojsonidennum=json_encode($idennum);
$geojsonshannon=json_encode($shannon);
$geojsonmaptype=json_encode($maptype);
?>

<script>
    var u='u';
    var p='p';
    var idennum = {!! $geojsonidennum !!};
    var shannon = {!! $geojsonshannon !!};
    var maptype = {!! $geojsonmaptype !!};
    var headerType= {!! $headerType !!};
    var infotype= {!! $infoType !!};
    var uAnalisis={!! $uAnalisis !!}
</script>

@include('inc/udploadlayers')
<!DOCTYPE html>
<html lang="sp">
    
  <head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="/plant.png">
    <meta charset="UTF-8">
    <title>TIM Biodiversidad</title>

    <link rel="stylesheet" href="{{asset('css/print.css')}}">
    <script src="{{ asset('js/app.js') }}" ></script>  
    <!--<script src="/js/app.js"></script>-->
  </head>
  <body id="udpbody">

    <div id="app"></div>
    <link rel="stylesheet" href="/leaflet_assets/leaflet.css"> 
    <script src="{{ asset('js/index.js') }}" ></script>  
  </body>
  
</html>