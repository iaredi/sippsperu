<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('tester8', function(Request $request) {
    $layer=[];
    $table =  $request->table;
    $obstype =  $request->obstype;
    //$table="linea_mtp";
    // If the Content-Type and Accept headers are set to 'application/json', 
    // this will return a JSON structure. This will be cleaned up later.
    $sql="SELECT iden, ST_AsGeoJSON(geom, 5) AS geojson FROM {$table}";
    $result = DB::select($sql,[]);
    $features=[];
    foreach($result AS $row) {
        unset($row->geom);
        $geometry=$row->geojson=json_decode($row->geojson);
        unset($row->geojson);
        //$pointtable='punto_ave';
        //$sql = "SELECT {$pointtable}.iden FROM ointtable} WHERE ST_Intersects({$pointtable}.geom,  ST_GeomFromText('POINT({$mylng} {$mylat})',4326))";
        //$result = DB::select($sql, []);

        $row->$obstype='oktest';
        $feature=["type"=>"Feature", "geometry"=>$geometry, "properties"=>$row];
        array_push($features, $feature);
        
    }
    $featureCollection=["type"=>"FeatureCollection", "features"=>$features];
    $layer['geom']=$featureCollection;
    //$geojson= json_encode($featureCollection);
    $geojson=json_encode($layer);
    return $geojson;

});


Route::post('getudp', function(Request $request) {
    $lineamtp = $request->lineamtp;
    $medicion = $request->medicion;
    $observacion = $request->observacion;
    $punto = $request->punto;
    $transecto = $request->transecto;
    $useremail = $request->useremail;
    $lifeform=explode('_',$observacion)[1];

    //get linea ID
    $sql = "SELECT iden FROM linea_mtp WHERE nombre_iden=:lineamtp";
    $result = DB::select($sql, [':lineamtp'=>$lineamtp]);
    $lineanumber=$result[0]->iden;
    //get medicion ID
    $sql = "SELECT iden FROM medicion WHERE iden_linea_mtp=:lineanumber and iden_nombre=:medicion";
    $result = DB::select($sql, [':lineanumber'=>$lineanumber,':medicion'=>$medicion]);
    $medicionnumber=$result[0]->iden;
    //get medicion ID
    $sql = "SELECT iden FROM medicion WHERE iden_linea_mtp=:lineanumber and iden_nombre=:medicion";
    $result = DB::select($sql, [':lineanumber'=>$lineanumber,':medicion'=>$medicion]);
    $medicionnumber=$result[0]->iden;
    $locationinfo='non'; 
    $obresult=[];
    
    if ($lifeform=='ave' || $lifeform=='mamifero'){
        $sql = "SELECT * FROM punto_{$lifeform} WHERE iden_medicion=:medicionnumber and iden_sampling_unit=:punto and iden_email=:useremail";
        $result = DB::select($sql, [':medicionnumber'=>$medicionnumber,':punto'=>$punto,':useremail'=>$useremail]);
        if ($result){  
            $sql = "SELECT * FROM observacion_{$lifeform} JOIN especie_{$lifeform} ON observacion_{$lifeform}.iden_especie = especie_{$lifeform}.iden WHERE observacion_{$lifeform}.iden_punto=:punto and observacion_{$lifeform}.iden_email=:useremail";
            $obresult = DB::select($sql, [':punto'=>$result[0]->iden,':useremail'=>$useremail]);
        }
    }
    if ($lifeform=='hierba' || $lifeform=='herpetofauna'){
        $sql = "SELECT * FROM transecto_{$lifeform} WHERE iden_medicion=:medicionnumber and iden_sampling_unit=:transecto and iden_email=:useremail";
        $result = DB::select($sql, [':medicionnumber'=>$medicionnumber,':transecto'=>$transecto,':useremail'=>$useremail]);
        if ($result){ 
            $sql = "SELECT * FROM observacion_{$lifeform} JOIN especie_{$lifeform} ON observacion_{$lifeform}.iden_especie = especie_{$lifeform}.iden WHERE observacion_{$lifeform}.iden_transecto=:transecto and observacion_{$lifeform}.iden_email=:useremail";
            $obresult = DB::select($sql, [':transecto'=>$result[0]->iden,':useremail'=>$useremail]);
        }
    }
    if ($lifeform=='arbol' || $lifeform=='arbusto'){
        $sql = "SELECT * FROM punto_{$lifeform} WHERE iden_medicion=:medicionnumber and iden_sampling_unit=:transecto and iden_numero_punto62=:punto and iden_email=:useremail";
        $result = DB::select($sql, [':medicionnumber'=>$medicionnumber,':transecto'=>$transecto,':punto'=>$punto,':useremail'=>$useremail]);
        if ($result){ 
            $sql = "SELECT * FROM observacion_{$lifeform} JOIN especie_{$lifeform} ON observacion_{$lifeform}.iden_especie = especie_{$lifeform}.iden WHERE observacion_{$lifeform}.iden_punto=:punto and observacion_{$lifeform}.iden_email=:useremail";
            $obresult = DB::select($sql, [':punto'=>$result[0]->iden,':useremail'=>$useremail]);
        }
    }

    //$sql = "SELECT udp_puebla_4326.iden FROM udp_puebla_4326 WHERE ST_Intersects(udp_puebla_4326.geom,  ST_GeomFromText('POINT({$mylng} {$mylat})',4326))";
    //$result = DB::select($sql, []);
    //$result=[$lineamtp,$medicion,$observacion,$punto,$transecto];
    //return json_encode($request->lng);
    //return json_encode($result[0]->iden);
     
    $finalresults=[$result,$obresult];
    return json_encode($finalresults);
});



Route::post('getspecies', function(Request $request) {
    $lifeform = $request->lifeform;
    $idtype = $request->idtype;
    $idnumber= $request->idnumber;

    $transpunto='punto';
    if ($lifeform=='hierba'||$lifeform=='herpetofauna'){
        $transpunto='transecto';
    }
    $lifeform_riesgo=$lifeform;
    if ($lifeform=='hierba'||$lifeform=='arbol' ||$lifeform=='arbusto'){
        $lifeform_riesgo='planta';
    }

    $sql= "SELECT
    especie_{$lifeform}.comun,
    especie_{$lifeform}.cientifico,
    riesgo_{$lifeform_riesgo}.categoria,
    riesgo_{$lifeform_riesgo}.distribution,
    riesgo_{$lifeform_riesgo}.subespecie,

    count(especie_{$lifeform}.cientifico) AS total_cientifico
    FROM especie_{$lifeform}
        JOIN
    observacion_{$lifeform} ON especie_{$lifeform}.iden = observacion_{$lifeform}.iden_especie
        JOIN
        {$transpunto}_{$lifeform} ON observacion_{$lifeform}.iden_{$transpunto} = {$transpunto}_{$lifeform}.iden
        left JOIN
    riesgo_{$lifeform_riesgo} ON lower(especie_{$lifeform}.cientifico) = lower(CONCAT (riesgo_{$lifeform_riesgo}.genero,' ',riesgo_{$lifeform_riesgo}.especie))
    where iden_{$idtype}={$idnumber}
    GROUP BY especie_{$lifeform}.comun,especie_{$lifeform}.cientifico,riesgo_{$lifeform_riesgo}.categoria, riesgo_{$lifeform_riesgo}.distribution, riesgo_{$lifeform_riesgo}.subespecie";

    if ($idtype=="linea_mtp"){
        $sql="SELECT
        especie_{$lifeform}.comun,
        especie_{$lifeform}.cientifico,
        riesgo_{$lifeform_riesgo}.categoria,
        riesgo_{$lifeform_riesgo}.distribution,
        riesgo_{$lifeform_riesgo}.subespecie,

        count(especie_{$lifeform}.cientifico) AS total_cientifico
        FROM especie_{$lifeform}
            JOIN
        observacion_{$lifeform} ON especie_{$lifeform}.iden = observacion_{$lifeform}.iden_especie
            JOIN
            {$transpunto}_{$lifeform} ON observacion_{$lifeform}.iden_{$transpunto} = {$transpunto}_{$lifeform}.iden
            JOIN
        medicion ON {$transpunto}_{$lifeform}.iden_medicion = medicion.iden
        left JOIN
        riesgo_{$lifeform_riesgo} ON lower(especie_{$lifeform}.cientifico) = lower(CONCAT (riesgo_{$lifeform_riesgo}.genero,' ',riesgo_{$lifeform_riesgo}.especie))
            where iden_linea_mtp={$idnumber}
            GROUP BY especie_{$lifeform}.comun,especie_{$lifeform}.cientifico,riesgo_{$lifeform_riesgo}.categoria, riesgo_{$lifeform_riesgo}.distribution,riesgo_{$lifeform_riesgo}.subespecie";
    }   

    $obresult = DB::select($sql, []);
    return json_encode($obresult);
    
});