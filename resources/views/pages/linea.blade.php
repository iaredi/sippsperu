<?php
	if (!session('email')){
		return redirect()->to('/login')->send();
	}
	if (!session('readpp')){
		return redirect()->to('/privacidad')->send();
	}
?>

	@include('inc/header')
	@include('inc/nav')

	<div id="app"></div>
	<link rel="stylesheet" href="leaflet_assets/leaflet.css">
	<script>
		var infotype ='linea'
	</script>
	<script src="{{ asset('js/index.js') }}"></script>
	@include('inc/footer')