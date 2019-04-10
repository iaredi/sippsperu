<?php
class layer
{
    public $tableName;
    public $displayName;
    public $color;
    public $fillColor;
    public $opacity;
    public $weight;
	public $fillOpacity;
	public $category;
}
$email=session('email');
$dbemail = session('admin') == 1 ? "%" : $email;
$layer1 = new layer();
$layer1->tableName = 'udp_puebla_4326';
$layer1->displayName = 'Unidad de Paisaje';
$layer1->featureColumn = 'iden';
$layer1->color = 'black';
$layer1->fillColor = 'blue';
$layer1->opacity = 1;
$layer1->weight = 0.3;
$layer1->fillOpacity = 0.5;
$layer1->sql ="SELECT *, ST_AsGeoJSON(geom_count62.geom, 5) AS geojson FROM geom_count62
LEFT JOIN onlyemail ON geom_count62.iden = onlyemail.iden"
;
$layer1->category='Referencial';

$layer2 = new layer();
$layer2->tableName = 'linea_mtp';
$layer2->displayName = 'Linea MTP';
$layer2->featureColumn = 'nombre_iden';
$layer2->color = 'blue';
$layer2->fillColor = 'black';
$layer2->opacity = 1;
$layer2->weight = 5;
$layer2->fillOpacity = 1;
$layer2->sql = "SELECT *, linea_mtp.nombre_iden, ST_AsGeoJSON(geom, 5) AS geojson FROM geom_count62_linea
LEFT JOIN linea_mtp ON geom_count62_linea.iden = linea_mtp.iden
where geom_count62_linea.iden_email like '{$dbemail}'";
$layer2->category='Monitoreo Activo';


$layer3 = new layer();
$layer3->tableName = 'usershapes';
$layer3->displayName = 'Predios';
$layer3->featureColumn = 'nombre';
$layer3->color = 'black';
$layer3->fillColor = 'orange';
$layer3->opacity = 0.5;
$layer3->weight = 1;
$layer3->fillOpacity = 0.5;
$layer3->sql = "SELECT nombre, ST_AsGeoJSON(geom, 5) AS geojson FROM usershapes where iden_email like '{$dbemail}'";
$layer3->category='Monitoreo Activo';


$layer4 = new layer();
$layer4->tableName = 'municipio_puebla_4326';
$layer4->displayName = 'Municipios';
$layer4->featureColumn = 'nomgeo';
$layer4->color = 'black';
$layer4->fillColor = 'purple';
$layer4->opacity = 0.5;
$layer4->weight = 1;
$layer4->fillOpacity = 0.5;
$layer4->sql = "SELECT geometry_id,nomgeo, ST_AsGeoJSON(level_3, 5) AS geojson FROM muni_geometries_simplified";
$layer4->category='Referencial';

$layersArray = array($layer1, $layer2, $layer3, $layer4);
$addlayers = DB::select("SELECT * FROM additional_layers",[]);

foreach($addlayers as $singlerow) {
    $templayer = new layer();
    $templayer->tableName = $singlerow->tablename;
    $templayer->displayName = $singlerow->displayname;
    $templayer->featureColumn = $singlerow->featurecolumn;
    $templayer->color = $singlerow->color;
    $templayer->fillColor = $singlerow->fillcolor;
    $templayer->opacity =$singlerow->opacity;
    $templayer->weight =$singlerow->weight;
    $templayer->fillOpacity = $singlerow->fillopacity;
    $templayer->sql = "SELECT {$singlerow->featurecolumn}, ST_AsGeoJSON(geom, 5) AS geojson FROM {$singlerow->tablename}";
	$templayer->category = $singlerow->category;
    $lowername=strtolower($templayer->tableName);
    $lowercolumn=strtolower($templayer->featureColumn);
    $checkfeaturesql= "SELECT * 
      FROM information_schema.columns 
      WHERE table_name='{$lowername}' and column_name='{$lowercolumn}'";
    if (sizeof(DB::select($checkfeaturesql,[]))>0 || $templayer->tableName == 'suelo_geometries_simplified' ){
      $layersArray[]=$templayer;
    }
}
foreach ($layersArray as $layer) {
    $features=[];
    $dslist=[];
    $tolist=[];
    $dsmax=[];
    $tomax=[];
    if (session('admin') && $layer->tableName=='usershapes'){
        $layer->sql = "SELECT nombre, ST_AsGeoJSON(geom, 5) AS geojson FROM usershapes";
    }
    $result = DB::select($layer->sql,[]);

	$categorylist=['ave','arbol', 'arbusto', 'mamifero', 'herpetofauna', 'hierba'];
	foreach($categorylist as $cat){
		$dslist[]="distinct_species_{$cat}";
		$tolist[]="total_observaciones_{$cat}";
		$defaultmax["total_observaciones_{$cat}"]=0;
		$defaultmax["distinct_species_{$cat}"]=0;
	}
	if (isset($result[0])){
		foreach($result AS $row) {
			if (isset($row->geom)){
				unset($row->geom);
			}
			$geometry=$row->geojson=json_decode($row->geojson);
			unset($row->geojson);
			$row->name=$layer->tableName;
			$row->displayName=$layer->displayName;
			$row->featureColumn=$layer->featureColumn;
			if ($layer->tableName=='udp_puebla_4326'){




				foreach($dslist as $ds){
					if($defaultmax[$ds]<$row->$ds){
					$defaultmax[$ds]=$row->$ds;
					}
				}
				foreach($tolist as $to){
					if($defaultmax[$to]<$row->$to){
						$defaultmax[$to]=$row->$to;
					}
				}
			}

			$feature=["type"=>"Feature", "geometry"=>$geometry, "properties"=>$row];
			array_push($features, $feature);
			$featureCollection=["type"=>"FeatureCollection", "features"=>$features];
		}   
	$layer->geom=$featureCollection;
	unset($features);
	unset($featureCollection);
	$defaultmaxjson[$layer->tableName]=json_encode($defaultmax);
	}
}

$geojson=json_encode($layersArray);

?>
<script>
    var something = {!! $geojson !!};
    var defaultmax = {!! $defaultmaxjson['udp_puebla_4326'] !!};     
</script>



