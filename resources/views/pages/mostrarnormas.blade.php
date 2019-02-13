<?php
if (!session('email')){
    return redirect()->to('/login')->send();
}

//$idennum = explode(" : " , $_POST['normasbutton'])[1];
$idennum=55;
$geojsonidennum=json_encode($idenudp);
?>
<script>
    var idennum = {!! $geojsonidennum !!};
</script>


@include('inc/loadlayers')
@include('inc/header')
@include('inc/nav')

        <div class="container">
            <h1 class="text-center">Mostrar Mapas</h1>
            <p></p>
        </div> <!--Container-->
        
    
        <div id="app"></div>
        <link rel="stylesheet" href="leaflet_assets/leaflet.css"> 
        <script src="{{ asset('leaflet_assets/normasindex.js') }}" ></script>  

        @include('inc/footer')


