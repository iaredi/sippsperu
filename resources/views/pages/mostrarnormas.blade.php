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
$myheader= 'Especies en peligro de extinción de UDP '. $idenudp;
$disclaimer= '';
$headertype=substr($idenudp, -1);
if ($infotype=='normas'){
    $headertype=$headertype == 'u' ? 'UDP' : ($headertype=='p' ? 'Pol&iacute;gono' : 'L&iacute;nea TIM');
    $myheader= 'Especies en peligro de extinción de '.$headertype.' '. substr($idenudp, 0, -1);
    $disclaimer= 'En este reporte el sistema indica, para el caso de que así sea aplicable, cuáles especies
        están incluidas en la lista de riesgo considerada como referente (Lista Roja de la UICN). Es
        necesario verificar si el organismo reportado pertenece a alguna subespecie con categoría
        diferente, pues el sistema hace el análisis sólo a nivel de especie. Si se muestra una especie
        sin categoría es porque no se halla presente en la Lista de Riesgo.';
}elseif ($infotype=='ae'){
	$headertype= $headertype=='u'?'UDP '.substr($idenudp, 0, -1):  ($headertype=='p'?'Pol&iacute;gono '.substr($idenudp, 0, -1):'Linea TIM ' . explode("*",askforkey('linea_mtp','nombre_iden', 'iden', substr($idenudp, 0, -1)))[0]);
    $myheader= 'Atributos Ecol&oacute;gicos de '.$headertype;

} else if ($infotype=='in'){
    $idenudpTmp=substr($idenudp, 0, -1);
    
    if(!is_numeric($idenudpTmp)){
        $idenudp=substr($idenudp, 0, -1);
    }
    
    $myheader='Instrumentos de Gesti&oacute;n Territorial de ';
    $myheader.= is_numeric($headertype) ? 'UDP '.$idenudp : ($headertype=='p'?'Pol&iacute;gono '.$idenudp:'');
} 
?>
  <script>
    var idennum = {!! $geojsonidennum !!};
    var infotype = {!! $geojsoninfotype !!};
  </script>

  @include('inc/header')
  @include('inc/nav')
  <div class='bodycontainer' id="main">
    <section class="three">
        <div class="container">
            <h3 class="text-center"><?php echo $myheader ?></h3>
            <h6 class="text-center">
                <?php echo $disclaimer ?>
            </h6>

            <article><div id="app"></div></article>
        </div>

    
    <script src="{{ asset('js/index.js') }}"></script>
    @include('inc/footer')
</section>
  