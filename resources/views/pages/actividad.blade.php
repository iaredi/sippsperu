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
		if($saveworked=="true"){
			redirect()->to('/thanks')->send();
		}
    
	}
?>

@include('inc/header')
@include('inc/nav')
<div class='bodycontainer' id="main">
    <section class="four">
        <div class="container">
            <header><h2>Monitoreo de Acciones</h2></header>
                <div class=" warnings">
                    <?php
                        $hintlist = [
                            "Si no sabe con certeza algún dato, ingrese 00.",
                            "Escriba las medidas con 3 grados de precision. Ejemplo: 1.792.",
                            "Escriba las coordenadas con 4 grados de precision. Ejemplo: -110.8170."
                        ];
                        foreach ($hintlist as $hint) {
                            echo "<div class=''>{$hint}</div>";
                        }
                        if (count(session("error"))>0){
                            echo "<div class='bg-danger2 text-center'>";
                            foreach (session('error') as $msg) {
                                echo "<span>{$msg}</span>";
                            }
                            echo "</div>";
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
        </div>
        @include('inc/footer')
    </section>