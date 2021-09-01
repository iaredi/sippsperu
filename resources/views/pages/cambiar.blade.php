@include('inc/php_functions')
@include('inc/checkdata')
@include('inc/savedata')


<?php

$jsoninfotype=json_encode($infotype);
	if (!session('email')){
		return redirect()->to('/login')->send();
	}
	if (!session('readpp')){
		return redirect()->to('/privacidad')->send();
	}
	if ($_SERVER['REQUEST_METHOD']=="POST" && sizeof(session('error'))==0  && (!session('visitante'))){
		$saveworked = savedata($_POST,session('email'));
		if($saveworked=="true"){
			//redirect()->to('/thanks')->send();
		}
    
	}
?>

@include('inc/header')
@include('inc/nav')
<div class='bodycontainer' id="main">
    <section class="four">
        <div class="container">
            @include('inc/checkdata')
            <h3 id="measurement3">L&iacute;nea de Monitoreo Transecto Punto(MTP)</h3>
            <div style="font-size:28px;">Metodología TIM Perú</div>
            <div class=" warnings">
                <?php
                    $hintlist = [
                        "Las medidas son de 3 grados de precisión. Ejemplo: 1.792",
                        "Las coordenadas son de 4 grados de precisión. Ejemplo: -110.8170"
                    ];
                    foreach ($hintlist as $hint) {
                        echo "<div class='' '>{$hint}</div>";
                    }
                    foreach (session('error') as $msg) {
                        echo "<div class='bg-danger2 text-center'>{$msg}</div>";
                    }
                ?>
            </div>
            <script> 

                var csrf_token = '<?php echo csrf_token(); ?>'; 
            </script>
            <div id="app"></div>
                

            <link rel="stylesheet" href="leaflet_assets/leaflet.css">
            <script>
                var infotype = {!! $jsoninfotype !!};
            </script>
            <script src="{{ asset('js/index.js') }}"></script>
        </div>

        @include('inc/footer')
    </section>