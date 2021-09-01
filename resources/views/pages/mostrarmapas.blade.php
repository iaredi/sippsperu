<?php
	if (!session('email')){
		return redirect()->to('/login')->send();
	}
	if (!session('readpp')){
		return redirect()->to('/privacidad')->send();
	}
?>

	@include('inc/loadlayers')
	@include('inc/header')
	@include('inc/nav')
    <div class='bodycontainer' id="main">
        <section class="four">
            <div class="container">
                <header><h2>Monitoreo de Paisaje</h2></header>
                <div id="app"></div>
                <link rel="stylesheet" href="{{asset('leaflet_assets/leaflet.css')}}">
                <script>
                    var infotype ='map'
                </script>
                <script src="{{ asset('js/index.js') }}"></script>
            </div>
            @include('inc/footer')
        </section>