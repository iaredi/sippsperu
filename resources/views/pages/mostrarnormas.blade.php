@include('inc/php_functions')

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
$disclaimer= '';
if ($infotype=='normas'){
	$headertype= substr($idenudp, -1)=='u'?'UDP':'Linea MTP';
	  $myheader= 'Especies y Normas 059 de '.$headertype.' '. substr($idenudp, 0, -1);
	  $disclaimer= 'En este reporte el sistema indica, para el caso de que así sea aplicable, cuales subespecies están incluidas en la lista de especies en riesgo de la NOM-059-SEMARNAT-2010. Es necesario verificar si el organismo reportado pertenece a dicha subcategoria taxonómica.
		Cuando no se muestra subespecie pero si alguna categoría de riesgo, es porque la especie es el nivel taxonómico enlistado.
		Si se muestra una especie sin categoría es porque no se haya presente en la NOM.';
}
if ($infotype=='ae'){
	$headertype= substr($idenudp, -1)=='u'?'UDP '.substr($idenudp, 0, -1):'Linea MTP ' . explode('(',askforkey('linea_mtp','nombre_iden', 'iden', substr($idenudp, 0, -1)))[0];

  $myheader= 'Atributos Ecologicos de '.$headertype;

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
	<h6 class="text-center">
		<?php echo $disclaimer ?>
	</h6>
  </div>

  <div id="app"></div>
  <script src="{{ asset('/js/index.js') }}"></script>
  @include('inc/footer')