<?php
if (!session('email')){
    return redirect()->to('/login')->send();
}
?>
@include('inc/php_functions')
@include('inc/setuppage')
@include('inc/checkdata')
@include('inc/header')
@include('inc/nav')
@include('inc/savedata')

<body>
    <img src="{{ asset('img/malinche.jpg') }}"  alt="Italian Trulli" style="width:500px;height:200px;">
    <div>
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
                <?php
                $hint1="Si no hizo la observacion, ingrese 0000.";
                $hint2="Si hiciera observacion y no hubiera especies, ingrese 000.";
                $hint3="Si no sabe con certeza algún dato, ingrese 00.";
                echo "<p class='bg-info text-center'>{$hint1}</p>";
                echo "<p class='bg-info text-center'>{$hint2}</p>";
                echo "<p class='bg-info text-center'>{$hint3}</p>";
                        foreach (session('error') as $msg) {
                            echo "<p class='bg-danger text-center'>{$msg}</p>";
                        }
                ?>
            </div>
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

</body>
</html>
