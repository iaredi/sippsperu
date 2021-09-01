<?php
    if (!session('email')){
        return redirect()->to('/login')->send();
    }
    if (!session('readpp')){
      return redirect()->to('/privacidad')->send();
    }
    $useremail=json_encode(session('email'));
?>
<script>
var useremail = {!! $useremail !!};
</script>
@include('inc/php_functions')
@include('inc/setuppage')
@include('inc/savedata')
@include('inc/checkexceldata')
@include('inc/header')
@include('inc/nav')
<div class='bodycontainer' id="main">
    <section class="four">
        <div class="container">
        <header><h2>Ingresar Excel</h2></header>
            <div class="warnings">
                <?php
                    $hintlist = [
                                "Si no hizo la observación, escriba 0000.",
                                "Si hizo la observación y no hubo especies, escriba 000.",
                                "Si no sabe con certeza algún dato, escriba 00.",
                                "Escriba las medidas con 3 grados de precision. Ejemplo: 1.792.",
                                "Escriba las coordenadas con 4 grados de precision. Ejemplo: -110.8170.",
                                "No use la palabra 'false'. En su lugar use 'falso' o 'no'.",
                                "Sólo los campos 'notas' e 'iden_fotos' se puede dejar vacíos.",
                                "Use nombres de columnos exactos.",
                                "Si al hacer clic en \"Descargar Excel Ejemplo\" se descarga en formato HTML, haga clic de nuevo."
                            ];
                    foreach ($hintlist as $hint) {
                        echo "<div>{$hint}</div>";
                    }
                ?>
            </div>
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

            <div class="wrapper2" id="startMenuDiv">
                <form id="measurementform" method="post" , action="/dlexample">
                    <div class="row">
                        <div class="col-12">
                            <input type="submit" id="excelSubmit" name="descargarexcel" value="Descargar Excel Ejemplo">
                        </div>
                        {{ csrf_field() }}
                    </div>
                </form>
            </div>

            <h3 id="measurement3">Eligir L&iacute;nea de Monitoreo Transecto Punto(MTP)</h3>
            <div style="font-size:28px;">Metodología TIM Perú</div>
            <div class="wrapper2" id="startMenuDiv">    
                <form id="measurementform" method="post" , enctype="multipart/form-data">
                    {{ csrf_field() }}

                    
                    <div class="">
                        <table class="mytable">
                            <tbody id="measurementTBodySelect">
                            </tbody>
                        </table>
                    </div>
                    <div class="">
                        <table class="mytable">
                            <tbody id="measurementTBodyMedicion">
                            </tbody>
                        </table>
                    </div>
                    <div class="">
                        <label for="excelFromUser" class="dropDownTitles">Excel (.xls)</label>
                        <input type="file" name="excelFromUser" id="excelFromUser" placeholder="Excel (.xls)">
                    </div>
                    <br>
                    <div class="">
                        <label for="photosFromUser" class="dropDownTitles">Fotos</label>
                        <input type="file" name="photosFromUser[]" id="photosFromUser" multiple>
                    </div>
                    <br>
                    <div class="col-12">
                        <input type="submit" name="ingresarexcel" id="excelSubmit" value="Enviar">
                    </div>
                </form>
            </div>

            <script src="{{ asset('js/jsfunc.js') }}"></script>
        </div>
        @include('inc/footer')
    </section>