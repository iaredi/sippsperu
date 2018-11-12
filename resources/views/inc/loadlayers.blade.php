<?php
$generateLayers=false;
class layer
{
    public $tableName;
    public $displayName;
    public $color;
    public $fillColor;
    public $opacity;
    public $weight;
    public $fillOpacity;
    public $fromFile;
   
}
$layer1 = new layer();
$layer1->tableName = 'udp_puebla_4326';
$layer1->displayName = 'Unidad de Paisaje';
$layer1->featureColumn = 'iden';
$layer1->color = 'black';
$layer1->fillColor = 'blue';
$layer1->opacity = 1;
$layer1->weight = 0.3;
$layer1->fillOpacity = 0.5;
$layer1->fromFile = false;

$layer2 = new layer();
$layer2->tableName = 'linea_mtp';
$layer2->displayName = 'Linea MTP';
$layer2->featureColumn = 'iden';
$layer2->color = 'red';
$layer2->fillColor = 'black';
$layer2->opacity = 1;
$layer2->weight = 5;
$layer2->fillOpacity = 1;
$layer2->fromFile = false;


$layer3 = new layer();
$layer3->tableName = 'municipio_puebla_4326';
$layer3->displayName = 'Municipio';
$layer3->featureColumn = 'nomgeo';
$layer3->color = 'black';
$layer3->fillColor = 'purple';
$layer3->opacity = 0.5;
$layer3->weight = 1;
$layer3->fillOpacity = 0.5;
$layer3->fromFile = true;


$layersArray = array($layer1, $layer2, $layer3);

foreach ($layersArray as $layer) {
    $features=[];
    $dslist=[];
    $tolist=[];
    $dsmax=[];
    $tomax=[];
    if (!$layer->fromFile || $generateLayers){

        $obtype=explode('-', $layer->displayName)[0];
        
        if ($layer->tableName=='udp_puebla_4326'){
            $result = DB::select("SELECT *, ST_AsGeoJSON(geom, 5) AS geojson FROM geom_count6",[]);
        }elseif ($layer->tableName=='linea_mtp'){
            $result = DB::select("SELECT *, ST_AsGeoJSON(geom, 5) AS geojson FROM geom_count6_linea",[]);
        }else{
            $result = DB::select("SELECT *, ST_AsGeoJSON(geom, 5) AS geojson FROM {$layer->tableName}",[]);
        }

        
        $categorylist=['ave','arbol', 'arbusto', 'mamifero', 'herpetofauna', 'hierba'];
        foreach($categorylist as $cat){
            $dslist[]="distinct_species_{$cat}";
            $tolist[]="total_observaciones_{$cat}";
            $defaultmax["total_observaciones_{$cat}"]=0;
            $defaultmax["distinct_species_{$cat}"]=0;
        }

        foreach($result AS $row) {
            unset($row->geom);
            $geometry=$row->geojson=json_decode($row->geojson);
            unset($row->geojson);
            $row->name=$layer->tableName;
            $row->displayName=$layer->displayName;
            $row->featureColumn=$layer->featureColumn;
            $row->fromFile=$layer->fromFile;
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
            if($layer->fromFile){
                $fp = fopen("{$layer->tableName}.json", 'w');
                fwrite($fp, json_encode($featureCollection));
                fclose($fp);
            }
        }   


        
    

}else{
    $featureCollection =json_decode( file_get_contents("{$layer->tableName}.json"));
}



        echo '<script>console.log('.json_encode($featureCollection).');</script>';

    $layer->geom=$featureCollection;
    unset($features);
    unset($featureCollection);
    $defaultmaxjson[$layer->tableName]=json_encode($defaultmax);

    
}


$geojson=json_encode($layersArray);
?>
<script>
    var something = {!! $geojson !!};
    var defaultmax = {!! $defaultmaxjson['udp_puebla_4326'] !!};     
</script>



