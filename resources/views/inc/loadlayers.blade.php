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
$layer2->color = 'blue';
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
$layer3->fromFile = false;

$layer4 = new layer();
$layer4->tableName = 'usershapes';
$layer4->displayName = 'Predios';
$layer4->featureColumn = 'nombre';
$layer4->color = 'black';
$layer4->fillColor = 'orange';
$layer4->opacity = 0.5;
$layer4->weight = 1;
$layer4->fillOpacity = 0.5;
$layer4->fromFile = false;

$layersArray = array($layer1, $layer2, $layer3, $layer4);

foreach ($layersArray as $layer) {
    $features=[];
    $dslist=[];
    $tolist=[];
    $dsmax=[];
    $tomax=[];

        $obtype=explode('-', $layer->displayName)[0];
        
        if ($layer->tableName=='udp_puebla_4326'){
            $result = DB::select("SELECT *, ST_AsGeoJSON(geom, 5) AS geojson FROM geom_count6_email",[]);
        }elseif ($layer->tableName=='linea_mtp'){
            $result = DB::select("SELECT *, ST_AsGeoJSON(geom, 5) AS geojson FROM geom_count6_linea",[]);
        }elseif ($layer->tableName=='municipio_puebla_4326'){
            $result = DB::select("SELECT geometry_id,nomgeo, ST_AsGeoJSON(level_3, 5) AS geojson FROM muni_geometries_simplified",[]);
        }elseif ($layer->tableName=='usershapes'){
            if (session('admin')){
                $result = DB::select("SELECT nombre, ST_AsGeoJSON(geom, 5) AS geojson FROM usershapes",[]);
            }else{
                $email=session('email');
                $result = DB::select("SELECT nombre, ST_AsGeoJSON(geom, 5) AS geojson FROM usershapes where iden_email='{$email}'",[]);
            }
        }

        
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



