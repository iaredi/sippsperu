<?php
if (!session('email')){
    return redirect()->to('/login')->send();
}
if (!session('readpp')){
    return redirect()->to('/privacidad')->send();
}
$geojsonidennum=json_encode($idenudp);
$geojsoninfotype=json_encode($infotype);
$myheader= 'Especies y Normas 059 de UDP '. $idenudp;
if ($infotype=='ae'){
	$headertype= substr($idenudp, -1)=='u'?'UDP':'Linea MTP';
  $myheader= 'Attributos Ecologicos de '.$headertype.' '. substr($idenudp, 0, -1);
} 
if ($infotype=='in'){
  $myheader= 'Instrumentos de Gestion Territorial de UDP '.$idenudp;
} 
?>
  <script>
    var idennum = {!! $geojsonidennum !!};
    var infotype = {!! $geojsoninfotype !!};
  </script>

  @include('inc/header')
  @include('inc/nav')

  <div class="container">
    <h3 class="text-center">
      <?php echo $myheader ?>
    </h3>
  </div>

  <div id="app"></div>
  <script src="{{ asset('/js/index.js') }}"></script>
  @include('inc/footer')