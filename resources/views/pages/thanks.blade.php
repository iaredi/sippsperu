@include('inc/header')
@include('inc/nav')

 <div class="display: flex p-5 m-5" style="text-align:center;">
    <div class=" d-inline-flex flex-column justify-content-center" style='width: 350px'>
    <p class="text-center h5">Sus datos se han guardado con exito. Gracias!</p>
        <a href="/ingresardatos"  class="btn btn-success p-15" >Regresar </a>
    </div>
</div>
<br>
<br>

<br>

<br>


@include('inc/footer')
<?php
    echo '<script>console.log('.json_encode(session('resultofquery')).')</script>';
    session(['resultofquery' => '']);

    ?>