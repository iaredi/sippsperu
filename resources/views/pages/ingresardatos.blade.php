@include('inc/php_functions')
@include('inc/checkdata')
@include('inc/savedata')
<?php

    if (!session('email')){
        return redirect()->to('/login')->send();
    }
    if (!session('readpp')){
      return redirect()->to('/privacidad')->send();
    }
    $useremail=json_encode(session('email'));
    if ($_SERVER['REQUEST_METHOD']=="POST"){
      $saveworked = savedata($_POST,$useremail);
      if($saveworked=="true"){
        redirect()->to('/thanks')->send();
      }
    }
?>

<script>
    var useremail = {!! $useremail !!};
</script>
@include('inc/setuppage')
@include('inc/header')
@include('inc/nav')
<div class='bodycontainer' id="main">
    <section class="four">
        <header><h2>Monitoreo de Biodiversidad</h2></header>
        <div class="container">
            <div class=" warnings">
                <?php
                    $hintlist = [
                        "Si no hizo la observación, escriba 0000.",
                        "Si hizo la observación y no hubo especies, escriba 000.",
                        "Si no sabe con certeza algún dato, ingescriba 00.",
                        "Escriba las medidas con 3 grados de precision. Ejemplo: 1.792.",
                        "Escriba las coordenadas con 4 grados de precision. Ejemplo: -110.8170."
                    ];
                    
                    foreach ($hintlist as $hint) {
                        echo "<div>{$hint}</div>";
                    }
                ?>
            
                <?php
                if(count(session('error'))>0){
                ?>
                    <div class="bg-danger2 text-center">
                        <?php
                            foreach (session('error') as $msg) {
                                echo "<div>{$msg}</div>";
                            } 
                        ?>
                    </div>
                    
                <?php
                }
                ?>
            </div>
            <div id="startMenuDiv">
                <h3 id="measurement3">Eligir L&iacute;nea de Monitoreo Transecto Punto(MTP)</h3>
                <div style="font-size:28px;">Metodología TIM Perú</div>
                <form id="measurementform" method="post", enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <table class="mytable" >
                        <tbody id="measurementTBodySelect">
                        </tbody>
                    </table>
                    <table class="mytable">
                        <tbody id="measurementTBodyMedicion">
                        </tbody>
                    </table>

                    <table class="mytable">
                        <tbody id="measurementTBodyObservaciones">
                        </tbody>
                    </table>
                    
                    <table class="mytable">
                        <tbody id="measurementTBodyNumero">
                        </tbody>
                    </table>
                    <table class="mytable">
                        <tbody id="botonReady">
                        </tbody>
                    </table>
            <br />
                    <div class="overflowDiv">
                        <table class="formtable">
                            <tbody id="measurementTBodyForm">
                            </tbody>
                        </table>
                    </div>
                </form>
            </div >

            <script src="{{ asset('js/jsfunc.js') }}" ></script>
        </div>
        @include('inc/repopulate')
        @include('inc/footer')
    </section>


