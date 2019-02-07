@include('inc/php_functions')
@include('inc/checkdata')
@include('inc/savedata')


<?php
    if (!session('email')){
        return redirect()->to('/login')->send();
    }
    $useremail=json_encode(session('email'));
    if ($_SERVER['REQUEST_METHOD']=="POST"){
      savedata($_POST,$useremail);
    }
?>

<script>
    var useremail = {!! $useremail !!};
</script>
@include('inc/setuppage')
@include('inc/header')
@include('inc/nav')

    <img src="{{ asset('img/popo.jpg') }}"  alt="Italian Trulli" style="height:250px; width:380px;">
            <div class=" warnings">
                <?php
                $hint1="Si no hizo la observacion, ingrese 0000.";
                $hint2="Si hiciera observacion y no hubiera especies, ingrese 000.";
                $hint3="Si no sabe con certeza algún dato, ingrese 00.";
                $hint3="Todos los medida son de 3 grados de precision. Por ejemplo 1.792";

                echo "<p class='text-dark text-center' style='background-color: lightsteelblue;'>{$hint1}</p>";
                echo "<p class='text-dark text-center'style='background-color: lightsteelblue;'>{$hint2}</p>";
                echo "<p class='text-dark text-center'style='background-color: lightsteelblue;'>{$hint3}</p>";
                echo "<p class='text-dark text-center'style='background-color: lightsteelblue;'>{$hint3}</p>";

                    foreach (session('error') as $msg) {
                        echo "<p class='bg-danger2 text-center'>{$msg}</p>";
                    }
                ?>
        </div>

    <div class="wrapper2" id="startMenuDiv">
        <h3 id="measurement3">Eligir Linea_MTP</h3>
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
            <table class="formtable">
                <tbody id="measurementTBodyForm">
                </tbody>
            </table>
        </form>
    </div >

<script src="{{ asset('js/jsfunc.js') }}" ></script>

@include('inc/repopulate')
@include('inc/footer')


