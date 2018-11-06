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
   
}
$layer1 = new layer();
$layer1->tableName = 'udp_puebla_4326';
$layer1->displayName = 'Unidad de Paisaje';
$layer1->color = 'black';
$layer1->fillColor = 'blue';
$layer1->opacity = 1;
$layer1->weight = 0.3;
$layer1->fillOpacity = 0.5;

$layer2 = new layer();
$layer2->tableName = 'linea_mtp';
$layer2->displayName = 'Linea MTP';
$layer2->color = 'red';
$layer2->fillColor = 'black';
$layer2->opacity = 1;
$layer2->weight = 5;
$layer2->fillOpacity = 1;



$layersArray = array($layer1, $layer2);

foreach ($layersArray as $layer) {
    $obtype=explode('-', $layer->displayName)[0];
    $table=$layer->tableName;
    if ($layer->tableName=='udp_puebla_4326'){
        $result = DB::select("SELECT *, ST_AsGeoJSON(geom, 5) AS geojson FROM geom_count6",[]);
    }elseif ($layer->tableName=='linea_mtp'){
        $result = DB::select("SELECT *, ST_AsGeoJSON(geom, 5) AS geojson FROM geom_count6_linea",[]);
    }else{
        $result = DB::select("SELECT iden, ST_AsGeoJSON(geom, 5) AS geojson FROM {$table}",[]);
    }
    $features=[];
    
        foreach($result AS $row) {
            unset($row->geom);
            $geometry=$row->geojson=json_decode($row->geojson);
            unset($row->geojson);
            $feature=["type"=>"Feature", "geometry"=>$geometry, "properties"=>$row];
            array_push($features, $feature);
        }
   
        
    $featureCollection=["type"=>"FeatureCollection", "features"=>$features];
    $layer->geom=$featureCollection;
    $features=[];
    $featureCollection=[];

}
$geojson=json_encode($layersArray);
?>

<script>
var something = {!! $geojson !!};
//console.log(something[0])
</script>



