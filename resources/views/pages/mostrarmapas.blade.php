@include('inc/header')
@include('inc/nav')
@include('inc/loadlayers')










    <body>

        <div class="container">
            <h1 class="text-center">Pagina de Mapas</h1>
            <p></p>
        </div> <!--Container-->
        
    <body>
        <div id="app"></div>
        <link rel="stylesheet" href="leaflet_assets/leaflet.css"> 
        <script src="{{ asset('leaflet_assets/index.js') }}" ></script>  

        @include('inc/footer')
    </body>
</html>

