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
    //$table =  {$request->table};
    $table="linea_mtp";
    // If the Content-Type and Accept headers are set to 'application/json', 
    // this will return a JSON structure. This will be cleaned up later.
    $sql="SELECT iden, ST_AsGeoJSON(geom, 5) AS geojson FROM {$table}";
    $result = DB::select($sql, []);
    $features=[];
    foreach($result AS $row) {
        unset($row['geom']);
        $geometry=$row['geojson']=json_decode($row['geojson']);
        unset($row['geojson']);
        $feature=["type"=>"Feature", "geometry"=>$geometry, "properties"=>$row];
        array_push($features, $feature);
        
    }
    $featureCollection=["type"=>"FeatureCollection", "features"=>$features];
    
    return json_encode($featureCollection);
    return "{$request->body}";
});

Route::post('tester7', function(Request $request) {
    $mylat = $request->lat;
    $mylng = $request->lng;
    $sql = "SELECT udp_puebla_4326.iden FROM udp_puebla_4326 WHERE ST_Intersects(udp_puebla_4326.geom,  ST_GeomFromText('POINT({$mylng} {$mylat})',4326))";
    $result = DB::select($sql, []);
    //return json_encode($request->lng);
    return json_encode($result[0]->iden);
});
