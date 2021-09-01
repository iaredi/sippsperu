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
  
  if(!isset($headerType)){
    $headerType='u';
  }

  //si el headertype es un número es porque
if ($headerType=='p'){
    $resultsTableName="ageom_count62";
    $tableName="usershapes";
    $displayName="Pol&iacute;gono";
    $featureColumn="gid";
}else if($headerType=='u'){
    $resultsTableName="geom_count62";
    $tableName="udp_puebla_4326";
    $displayName="Unidad de Paisaje";
    $featureColumn="iden";
}

$email=session('email');
$layer1 = new layer();
$layer1->tableName = $tableName;
$layer1->displayName = $displayName;
$layer1->featureColumn = $featureColumn;
$layer1->color = 'black';
$layer1->fillColor = 'black';
$layer1->opacity = 1;
$layer1->weight = 2;
$layer1->fillOpacity = 0;
$layer1->sql ="SELECT *, ST_AsGeoJSON(geom, 5) AS geojson FROM {$tableName} where {$featureColumn} = '{$idennum}'";
  
$layer2 = new layer();
$layer2->tableName = 'infra_punto';
$layer2->displayName = 'infra_punto';
$layer2->featureColumn = 'tipo';
$layer2->color = 'black';
$layer2->fillColor = 'yellow';
$layer2->opacity = 1;
$layer2->weight = 1;
$layer2->fillOpacity = 1;
$layer2->sql ="SELECT tipo, ST_AsGeoJSON(geom, 5) AS geojson FROM infra_punto
WHERE ST_Intersects(geom,  (select geom FROM {$tableName} where {$featureColumn} = '{$idennum}'))";


$layer3 = new layer();
$layer3->tableName = 'infra_linea';
$layer3->displayName = 'infra_linea';
$layer3->featureColumn = 'tipo';
$layer3->color = 'black';
$layer3->fillColor = 'orange';
$layer3->opacity = 1;
$layer3->weight = 0.1;
$layer3->fillOpacity = 1;
$layer3->headerType=$headerType;
$layer3->sql ="SELECT color, dash, weight, tipo, ST_AsGeoJSON(geom, 5) AS geojson FROM infra_linea
WHERE ST_Intersects(geom,  (select geom FROM {$tableName} where {$featureColumn} = '{$idennum}'))
and geografico IN ('AFIRMADO', 'ASFALTADO', 'PAVIMENTO BASICO', 'PAVIMENTO RIGIDO', 'PROYECTADO', 'SIN AFIRMAR','RED VECINAL SIN INFORMACION','TROCHA')
";

$layersArray = array();
$layersArray[] = $layer1;
if ($maptype=='inf'){
    $layersArray[] = $layer2;
    $layersArray[] = $layer3;
}


    if ($maptype=='sue'||$maptype=='suep'){
        $addlayers = DB::select("SELECT * FROM additional_layers",[]);
        foreach($addlayers as $singlerow) {
            if ($singlerow->tablename=='suelo_geometries_simplified'){
                $templayer = new layer();
                $templayer->tableName = "usos_de_suelo4";
                $templayer->displayName = $singlerow->displayname;
                $templayer->featureColumn = $singlerow->featurecolumn;
                $templayer->color = $singlerow->color;
                $templayer->fillColor = $singlerow->fillcolor;
                $templayer->opacity =$singlerow->opacity;
                $templayer->weight =$singlerow->weight;
                $templayer->fillOpacity = $singlerow->fillopacity;
                $templayer->headerType=$headerType;
                $templayer->sql = "SELECT color, {$singlerow->featurecolumn}, ST_AsGeoJSON(geom, 5) AS geojson FROM usos_de_suelo4 WHERE ST_Intersects(geom,  (select geom FROM {$tableName} where {$featureColumn} = '{$idennum}'))";
                $layersArray[]=$templayer;
            }
        }
    }
    
    foreach ($layersArray as $layer) {
        $features=[];
        $result = DB::select($layer->sql,[]);      
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
                
                $feature=["type"=>"Feature", "geometry"=>$geometry, "properties"=>$row];

                array_push($features, $feature);
                $featureCollection=["type"=>"FeatureCollection", "features"=>$features];
            }

            $layer->geom=$featureCollection;
            unset($features);
            unset($featureCollection);
        }
    }
    $geojson=json_encode($layersArray);
    ?>
<script>
  var udpsomething = {!! $geojson !!};
</script>