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
$email=session('email');
//$idennum = explode(" : " , $_POST['udpbutton'])[1];
$idennum= 55;
$layer1 = new layer();
$layer1->tableName = 'udp_puebla_4326';
$layer1->displayName = 'Unidad de Paisaje';
$layer1->featureColumn = 'iden';
$layer1->color = 'black';
$layer1->fillColor = 'black';
$layer1->opacity = 1;
$layer1->weight = 2;
$layer1->fillOpacity = 0;
$layer1->sql ="SELECT *, ST_AsGeoJSON(geom, 5) AS geojson FROM geom_count6_email where iden = '{$idennum}'";

$layersArray = array($layer1);
$addlayers = DB::select("SELECT * FROM additional_layers",[]);

foreach($addlayers as $singlerow) {
    if ($singlerow->tablename=='usos_de_suelo4'){
        $templayer = new layer();
        $templayer->tableName = $singlerow->tablename;
        $templayer->displayName = $singlerow->displayname;
        $templayer->featureColumn = $singlerow->featurecolumn;
        $templayer->color = $singlerow->color;
        $templayer->fillColor = $singlerow->fillcolor;
        $templayer->opacity =$singlerow->opacity;
        $templayer->weight =$singlerow->weight;
        $templayer->fillOpacity = $singlerow->fillopacity;
        $templayer->sql = "SELECT color, {$singlerow->featurecolumn}, ST_AsGeoJSON(geom, 5) AS geojson FROM {$singlerow->tablename}";
        $layersArray[]=$templayer;
    }
}

foreach ($layersArray as $layer) {
    $features=[];
    $dslist=[];
    $tolist=[];
    $dsmax=[];
    $tomax=[];
    
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
    var udpsomething = {!! $geojson !!};
    var udpdefaultmax = {!! $defaultmaxjson['udp_puebla_4326'] !!};     
</script>



