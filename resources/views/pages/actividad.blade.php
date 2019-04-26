@include('inc/php_functions')
@include('inc/checkdata')
@include('inc/saveactividad')

<?php
	if (!session('email')){
		return redirect()->to('/login')->send();
	}
	if (!session('readpp')){
		return redirect()->to('/privacidad')->send();
	}
	if ($_SERVER['REQUEST_METHOD']=="POST" && sizeof(session('error'))==0  && (!session('visitante'))){
		$saveworked = saveactividad($_POST,session('email'));
		// if($saveworked=="true"){
		// 	redirect()->to('/thanks')->send();
		// }
    
	}
?>

@include('inc/header')
@include('inc/nav')
<img src="{{ asset('img/popo.jpg') }}"  alt="Italian Trulli" style="height:250px; width:380px;">
	<div class=" warnings">
		<?php
			$hintlist = [
				"Si no sabe con certeza algún dato, ingrese 00.",
				"Todos los medidas son de 3 grados de precision. Por ejemplo 1.792",
				"Todos las coordenadas son de 4 grados de precision. Por ejemplo -110.8170"
			];
			foreach ($hintlist as $hint) {
				echo "<p class='text-dark text-center'style='background-color: lightsteelblue;'>{$hint}</p>";
			}
			foreach (session('error') as $msg) {
				echo "<p class='bg-danger2 text-center'>{$msg}</p>";
			}
		?>
</div>
	<script> 

		var csrf_token = '<?php echo csrf_token(); ?>'; 
	</script>
	<div id="app"></div>
	

<link rel="stylesheet" href="leaflet_assets/leaflet.css">
<script>
	var infotype ='actividad'
</script>
<script src="{{ asset('js/index.js') }}"></script>

@include('inc/footer')