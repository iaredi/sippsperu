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
session_start();
//cargo las especies guardadas en el sistema
$sql="SELECT nombre, iden FROM especies;";
$catEspeciesId= DB::select($sql, []);
$catEspecies=array_column($catEspeciesId, 'nombre');
$catEspeciesId=array_column($catEspeciesId, 'iden');

$email=session('email');
$dbemail = session('admin') == 1 ? "%" : $email;
$layer1 = new layer();
$layer1->tableName = 'udp_puebla_4326';
$layer1->displayName = 'Unidad de Paisaje';
$layer1->featureColumn = 'iden';
$layer1->color = 'black';
$layer1->fillColor = 'blue';
$layer1->opacity = 0.3;
$layer1->weight = 0.3;
$layer1->fillOpacity = 0.5;
$layer1->sql ="SELECT *, ST_AsGeoJSON(geom_count62.geom, 5) AS geojson FROM geom_count62
LEFT JOIN onlyemail ON geom_count62.iden = onlyemail.iden"
;
$layer1->category='Referencial';

$layer2 = new layer();                              
$layer2->tableName = 'linea_mtp';
$layer2->displayName = 'Linea TIM';
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
$layer3->displayName = 'Poligonos';
$layer3->featureColumn = 'iden';
$layer3->color = 'black';
$layer3->fillColor = 'blue';
$layer3->opacity = 1;
$layer3->weight = 0.3;
$layer3->fillOpacity = 0.5;
$layer3->sql ="SELECT ac.iden,ac.*,ST_AsGeoJSON(ac.geom, 5) AS geojson, us.iden_email FROM ageom_count62 ac
LEFT JOIN onlyemail ON ac.iden = onlyemail.iden left join usershapes us on us.gid=ac.iden where iden_email like '{$dbemail}' AND us.temp_shape=true;";
$layer3->category='Referencial';

$layer4 = new layer();
$layer4->tableName = 'municipio';
$layer4->displayName = 'Distritos';
$layer4->featureColumn = 'nomgeo';
$layer4->color = 'black';
$layer4->fillColor = 'purple';
$layer4->opacity = 0.5;
$layer4->weight = 1;
$layer4->fillOpacity = 0.5;
$layer4->sql = "SELECT geometry_id,nomgeo, ST_AsGeoJSON(level_3, 5) AS geojson FROM muni_geometries_simplified";
$layer4->category='Referencial';

$layer5 = new layer();
$layer5->tableName = 'actividad';
$layer5->displayName = 'Acciones_punto';
$layer5->featureColumn = 'descripcion';
$layer5->color = 'black';
$layer5->fillColor = 'yellow';
$layer5->opacity = 0.9;
$layer5->weight = 1;
$layer5->fillOpacity = 0.5;
$layer5->sql = "SELECT concat(descripcion,', Organización: ',organizacion,', Número de beneficiarios: ', numero_beneficiarios_directos) AS descripcion, iden_geom, ST_AsGeoJSON(iden_geom, 5) AS geojson FROM actividad where tipo_geom='punto'";
$layer5->category='Referencial';

$layer6 = new layer();
$layer6->tableName = 'actividad';
$layer6->displayName = 'Acciones_poli';
$layer6->featureColumn = 'descripcion';
$layer6->color = 'black';
$layer6->fillColor = 'yellow';
$layer6->opacity = 0.9;
$layer6->weight = 1;
$layer6->fillOpacity = 0.5;
$layer6->sql = "SELECT concat(descripcion,', Organización: ',organizacion,', Número de beneficiarios: ', numero_beneficiarios_directos) AS descripcion, iden_geom, ST_AsGeoJSON(iden_geom, 5) AS geojson FROM actividad where tipo_geom='poligono'";
$layer6->category='Referencial';

$layer7 = new layer();
$layer7->tableName = 'usershapes';
$layer7->displayName = 'Microcuencas';
$layer7->featureColumn = 'iden';
$layer7->color = 'red';
$layer7->fillColor = 'red';
$layer7->opacity = 1;
$layer7->weight = 0.3;
$layer7->fillOpacity = 0.5;
$layer7->sql ="SELECT ac.iden,ac.*,ST_AsGeoJSON(ac.geom, 5) AS geojson, us.iden_email FROM ageom_count62 ac
    LEFT JOIN onlyemail ON ac.iden = onlyemail.iden left join usershapes us on us.gid=ac.iden where us.temp_shape=false;";
$layer7->category='Referencial';

$layer8 = new layer();
$layer8->tableName = 'cultivo';
$layer8->displayName ='Cultivos - Punto';
$layer8->featureColumn = 'cadena_productiva';
$layer8->color = 'black';
$layer8->fillColor = 'blue';
$layer8->opacity = 0.9;
$layer8->weight = 1;
$layer8->fillOpacity = 0.5;
$layer8->sql = "SELECT concat(cadena_productiva,', Sistema de producción:',sistema_de_produccion, ', Plagas y enfermedades: ', plagas_y_enfermedades, ', Certificaciones: ',certificaciones) as cadena_productiva,iden_geom, ST_AsGeoJSON(iden_geom, 5) AS geojson FROM cultivo where tipo_geom='punto'";
$layer8->category='Referencial';

$layer9 = new layer();
$layer9->tableName = 'cultivo';
$layer9->displayName = 'Cultivos - Área';
$layer9->featureColumn = 'cadena_productiva';
$layer9->color = 'black';
$layer9->fillColor = 'blue';
$layer9->opacity = 0.9;
$layer9->weight = 1;
$layer9->fillOpacity = 0.5;
$layer9->sql = "SELECT concat(cadena_productiva,', Sistema de producción:',sistema_de_produccion, ', Plagas y enfermedades: ', plagas_y_enfermedades, ', Certificaciones: ',certificaciones) as cadena_productiva,iden_geom, ST_AsGeoJSON(iden_geom, 5) AS geojson FROM cultivo where tipo_geom='poligono'";
$layer9->category='Referencial';

$layersArray = array($layer1, $layer2, $layer3, $layer4, $layer5, $layer6, $layer7, $layer8, $layer9);
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
    
    //Verifica que exista la tabla con el nombre de la capa
    $checkfeaturesql= "SELECT * 
      FROM information_schema.columns 
      WHERE table_name='{$lowername}' and column_name='{$lowercolumn}'";
    if (sizeof(DB::select($checkfeaturesql,[]))>0 || $templayer->tableName == 'suelo_geometries_simplified' ){
      $layersArray[]=$templayer;
    }
}
$udpprocessed=[];
$lineaprocessed=[];
$incompletelines['test']=false;
 
foreach ($layersArray as $layer) {

    $features=[];
    $dslist=[];
    $tolist=[];
    $dsmax=[];
    $tomax=[];
    /*if (session('admin') && $layer->tableName=='usershapes'){
        $layer->sql = "SELECT nombre, ST_AsGeoJSON(geom, 5) AS geojson FROM usershapes ";
    }*/
    //$result = DB::select($layer->sql,[]);
    $loadedFromSession=false;
    try{
        if(isset($_SESSION['capas'][$layer->displayName])){
            $result=$_SESSION['capas'][$layer->displayName];
            $loadedFromSession=true;
        }else{
            $result = DB::select($layer->sql,[]);
            if(sizeof($result)>0){
                $_SESSION['capas'][$layer->displayName]=$result;
            }
        }
    }catch(Exception $e){

    }
    
    $categorylist=['arbol','arbusto','mamifero','ave','herpetofauna','hierba'];
    $minpuntos=['ave'=>5,'arbol'=>32, 'arbusto'=>32, 'mamifero'=>5, 'herpetofauna'=>4, 'hierba'=>4];

    $displayList=['total_observaciones', 'distinct_species', 'shannon', 'dominancia'];
    foreach($categorylist as $cat){
        $dslist[]="distinct_species_{$cat}";
        $tolist[]="total_observaciones_{$cat}";
        $defaultmax["total_observaciones_{$cat}"]=0;
        $defaultmax["distinct_species_{$cat}"]=0;
    }
    
    //si hay alguna capa de usuario
    if (isset($result[0])){
        foreach($result AS $row) {

            if(is_string($row->geojson)){
                $geometry=$row->geojson=json_decode($row->geojson);
                //unset($row->geojson);
            }else{
                $geometry=$row->geojson;
            }

            if ($layer->tableName=='udp_puebla_4326'|| $layer->tableName=='usershapes'){
                foreach($dslist as $ds){
                    if($row->$ds!='NM' && $defaultmax[$ds]<$row->$ds){
                        $defaultmax[$ds]=$row->$ds;
                    }
                }
                foreach($tolist as $to){
                    if($row->$to!='NM' && $defaultmax[$to]<$row->$to){
                        $defaultmax[$to]=$row->$to;
                    }
                }
            }

            if(!$loadedFromSession){
                if (isset($row->geom)){
                    unset($row->geom);
                }
                $row->name=$layer->tableName;
                $row->displayName=$layer->displayName;
                $row->featureColumn=$layer->featureColumn;
                //si la tabla es la de la cuadricula

                if ((($layer->tableName=='udp_puebla_4326'||$layer->tableName=='usershapes') && !in_array($row->iden, $udpprocessed))){
                    foreach ($categorylist as $empty_lifeform) {
                        $complete_life="complete_{$empty_lifeform}";
                        $row->$complete_life='true'; 
                        $row->complete_life='true'; 

                        if($layer->tableName=='udp_puebla_4326'){
                            $emptysql="SELECT count(iden) from empty_medida_{$empty_lifeform} where iden=?";
                            $emptyresult= DB::select($emptysql,[$row->iden]);
                        }else{
                            $idEspecie=array_search($empty_lifeform,$catEspecies);
                            $idEspecie=$catEspeciesId[$idEspecie];
                            $emptysql="SELECT count(iden_uda) from aempty_medida where iden_uda=? and catespecie_iden=?;";
                            $emptyresult= DB::select($emptysql,[$row->iden,$idEspecie]);
                        }
                        
                        $distinct_species="distinct_species_{$empty_lifeform}"; 
                        if(intval($row->$distinct_species)==0 && $emptyresult[0]->count==0){ 
                            foreach ($displayList as $displaycolumn) {
                                $column_to_change= "{$displaycolumn}_{$empty_lifeform}";
                                $row->$column_to_change='NM';
                            }
                        }
                    }
                    $udpprocessed[]=$row->iden;
                }
                
                if ($layer->tableName=='linea_mtp' && !in_array($row->iden, $lineaprocessed)){
                    foreach ($categorylist as $empty_lifeform) {
                        $emptysql="SELECT count(iden) from empty_medida_linea_{$empty_lifeform} where iden=?";
                        $emptyresult= DB::select($emptysql,[$row->iden]);
                        $distinct_species="distinct_species_{$empty_lifeform}"; 
                        if(intval($row->$distinct_species)==0 && $emptyresult[0]->count==0){ 
                            foreach ($displayList as $displaycolumn) {
                                $column_to_change= "{$displaycolumn}_{$empty_lifeform}";
                                $row->$column_to_change='NM';
                            }
                        }
                        $complete_life="complete_{$empty_lifeform}";
                        $row->$complete_life='false';

                        $transpunto='punto';
                        if ($empty_lifeform=='hierba'||$empty_lifeform=='herpetofauna'){
                            $transpunto='transecto';
                        }
                        $arbolextra="";

                        if($empty_lifeform=='arbol' ||$empty_lifeform=='arbusto'){
                            $arbolextra=",punto_{$empty_lifeform}.iden_numero_punto62";
                        }
                        
                        $iscompletesql= "SELECT 
                        count(DISTINCT(observacion_{$empty_lifeform}.iden_{$transpunto}{$arbolextra}))
                        FROM especie_{$empty_lifeform}
                            JOIN
                        observacion_{$empty_lifeform} ON especie_{$empty_lifeform}.iden = observacion_{$empty_lifeform}.iden_especie
                            JOIN
                            {$transpunto}_{$empty_lifeform} ON observacion_{$empty_lifeform}.iden_{$transpunto} = {$transpunto}_{$empty_lifeform}.iden
                            JOIN medicion ON {$transpunto}_{$empty_lifeform}.iden_medicion = medicion.iden
                        where iden_linea_mtp=? and especie_{$empty_lifeform}.cientifico!='0000'";

                        $emptyresult= DB::select($iscompletesql,[$row->iden]);
                        
                        if(sizeof($emptyresult)>0 && $emptyresult[0]->count >= $minpuntos[$empty_lifeform]){
                            $row->$complete_life='true'; 
                        }else{
                            $row->$complete_life='false'; 
                            $udpsql = "SELECT udp_puebla_4326.iden, udp_puebla_4326.geom FROM udp_puebla_4326 WHERE 
                            ST_Intersects(udp_puebla_4326.geom, (SELECT iden_geom from linea_mtp where iden = ?))";
                            $udpresult= DB::select($udpsql,[$row->iden]);
                            foreach ($udpresult as $udp) {
                                $incompletelines[$udp->iden] = "false";
                            }

                        }
                    }
                    $lineaprocessed[]=$row->iden;
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
foreach($layersArray[0]->geom['features'] as $row4) {
	$currentiden = $row4['properties']->iden;
	if (isset($incompletelines[$currentiden])){
		$row4['properties']->complete_life='false';
	}
}

$geojson=json_encode($layersArray);

?>
<script>
    var something = <?php echo $geojson; ?>;
    var defaultmax = <?php echo $defaultmaxjson['udp_puebla_4326']; ?>;     
</script>