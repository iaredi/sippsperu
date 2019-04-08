<!DOCTYPE html>
<html lang="sp">

<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" type="image/png" href="/plant.png">
  <meta charset="UTF-8">
  <title>MTP Biodiversidad</title>

  <link rel="stylesheet" href="{{asset('css/app.css')}}">
  <script src="/js/app.js"></script>

  <?php
	if(null!==(session('email'))){
		$geojsonuseremail = json_encode(session('email'));
		$geojsonadmin = json_encode(session('admin'));
	}else{
		$geojsonuseremail = json_encode('');
		$geojsonadmin = json_encode('');
	}
  ?>
  <script>
	var useremail = {!! $geojsonuseremail !!};
	var admin = {!! $geojsonadmin !!};
  </script>
</head>

<body>