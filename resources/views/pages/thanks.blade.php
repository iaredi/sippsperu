@include('inc/header')
  @include('inc/nav')

<div class="display: flex p-5 m-5" style="text-align:center;">
  <div class=" d-inline-flex flex-column justify-content-center" style='width: 350px'>
    <h5 class="text-center h5">Sus datos se han guardado con exito.</h5>
    <br>
    <h5 class="text-center h5">Gracias!</h5>

    {{--<a href="/ingresardatos" class="btn btn-success p-15">Regresar </a>--}}
  </div>
</div>
<br>
<br>

<br>

<br>
  @include('inc/footer')
<?php
  if (null!==(session('testvar'))){
    echo '<script>console.log('.json_encode(session('testvar')).')</script>';
  }
  echo '<script>console.log('.json_encode(session('resultofquery')).')</script>';
  $emptyarray=[];
  session(['resultofquery' => $emptyarray]);
?>