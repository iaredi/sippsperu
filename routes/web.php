<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/index', 'PagesController@index');
Route::get('/ingresardatos', 'PagesController@ingresardatos');
Route::get('/login', 'PagesController@login');
Route::get('/logout', 'PagesController@logout');
Route::get('/register', 'PagesController@register');
Route::get('/ingresarexcel', 'PagesController@ingresarexcel');
Route::get('/descargar', 'PagesController@descargar');
Route::get('/mostrarmapas', 'PagesController@mostrarmapas');
Route::get('/admin', 'PagesController@admin');
Route::get('/', 'PagesController@login');
Route::get('/thanks', 'PagesController@thanks');
Route::get('/reset_1', 'PagesController@reset_1');
Route::get('/reset_2', 'PagesController@reset_2');
Route::get('/cargarshapes', 'PagesController@cargarshapes');
Route::get('/cargarshapesadmin', 'PagesController@cargarshapesadmin');
Route::get('/privacidad', 'PagesController@privacy');
Route::get('/cambiarlinea', 'PagesController@cambiarlinea');
Route::get('/actividad', 'PagesController@actividad');


Route::get('/mostrarnormas/{infotype}/{idenudpraw}', function ($infotype,$idenudpraw){
  return view('pages/mostrarnormas',['infotype'=>$infotype,'idenudp'=>$idenudpraw]);
});
Route::get('/udpmapa/{maptype}/{idennum}/{shannon}', function ($maptype,$idennum,$shannon){
  return view('pages/udpmapa',['maptype'=>$maptype,'idennum'=>$idennum,'shannon'=>$shannon]);
});



Route::post('/', 'PagesController@login');
Route::post('/admin', 'PagesController@admin');
Route::post('/descargarfile', 'PagesController@descargarfile');
Route::post('/login', 'PagesController@login');
Route::post('/register', 'PagesController@register');
Route::post('/ingresardatos', 'PagesController@ingresardatos');
Route::post('/reset_1', 'PagesController@reset_1');
Route::post('/reset_2', 'PagesController@reset_2');
Route::post('/cargarshapes', 'PagesController@cargarshapes');
Route::post('/cargarshapesadmin', 'PagesController@cargarshapesadmin');
Route::post('/udpmapa', 'PagesController@udpmapa');
Route::post('/ingresarexcel', 'PagesController@ingresarexcel');
Route::post('/mostrarnormas', 'PagesController@mostrarnormas');
Route::post('/privacidad', 'PagesController@privacy');
Route::post('/cambiarlinea', 'PagesController@cambiarlinea');
Route::post('/actividad', 'PagesController@actividad');




Route::get('getspecieslist/{lifeform}', function ($lifeform) {
  $orignallifeform = $lifeform;
  $originaltargetob='especie_'. $lifeform;
  
    ////
    $extra='';
    if ($lifeform =='reptil'){
      $lifeform ='herpetofauna';
      $extra="and especie_{$lifeform}.iden_anfibio='false'";
    }
    if ($lifeform =='anfibio'){
      $lifeform ='herpetofauna';
      $extra="and especie_{$lifeform}.iden_anfibio='true'";
    }
    if ($lifeform =='cactus'){
      $lifeform ='arbol';
      $extra="and especie_{$lifeform}.iden_cactus='true'";
    }
    if ($lifeform =='arbol'){
      $extra="and especie_{$lifeform}.iden_cactus='false'";
    }
    ////

    $targetob='especie_'.$lifeform;
    $rawfile= "C:\\Users\\fores\\Desktop\\sql\\raw{$originaltargetob}.xml";
    $finalfile= "C:\\Users\\fores\\Desktop\\sql\\{$originaltargetob}.xml";
    
    if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
      $rawfile= "/postgres/raw{$originaltargetob}.xml";
      $finalfile= "/postgres/{$originaltargetob}.xml";
    } 

    $transpunto='punto';
    if ($lifeform=='hierba' || $lifeform=='herpetofauna'){
        $transpunto='transecto';
    }
    

    $newsql = "copy( 
                (SELECT 
                  XMLELEMENT(name quadrant, 
                                  XMLATTRIBUTES(udp_id as id),
                    XMLELEMENT(name LOOKUPTABLE,
                        XMLATTRIBUTES('especie_{$orignallifeform}' as NAME ),
                      XMLAGG({$lifeform}_group))
                          )
                FROM (
                    SELECT newudp as udp_id,
                              XMLAGG(XMLELEMENT(name item,
                                XMLATTRIBUTES(newespecie as value))) as {$lifeform}_group 
                    FROM 
                      (select distinct especie_{$lifeform}.cientifico as newespecie, 
                      udp_puebla_4326.iden as newudp
                        FROM udp_puebla_4326
                      
                          left JOIN
                            {$transpunto}_{$lifeform} ON udp_puebla_4326.iden = {$transpunto}_{$lifeform}.iden_udp
                          
                          left JOIN
                            observacion_{$lifeform} ON {$transpunto}_{$lifeform}.iden = observacion_{$lifeform}.iden_{$transpunto}
                        
                          left JOIN
                            especie_{$lifeform} ON observacion_{$lifeform}.iden_especie = especie_{$lifeform}.iden
                      
                            where especie_{$lifeform}.cientifico!='0000' and especie_{$lifeform}.cientifico!='000' and especie_{$lifeform}.cientifico!='00' {$extra}
                            GROUP BY udp_puebla_4326.iden, especie_{$lifeform}.cientifico)p
                                GROUP BY p.newespecie, p.newudp
                            )t								
                            GROUP BY udp_id)
            )TO '{$rawfile}'
            ";


    //$result = DB::select($sql, []);
    $newresult = DB::select($newsql, []);




$size = filesize($rawfile); 

if($size>0){
  session(['speciesabsent' => 'false']);
  $file = fopen($rawfile, "r"); 
  $text = fread($file, $size); 
  fclose($file); 
  $myfile = fopen($finalfile, "w") or die("Unable to open file!");
  $txt = '<?xml version="1.0" encoding="UTF-8"?><LOOKUPTABLES>'.$text.'</LOOKUPTABLES>';
  fwrite($myfile, $txt);
  fclose($myfile);
  if (file_exists($finalfile)) {
        header('Content-Description: File Transfer');
        header('Content-Type: Document');
        header('Content-Disposition: attachment; filename="'.basename($finalfile).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($finalfile));
        readfile($finalfile);
        exit;
    }
 

  //return response()->download($finalfile);

}else{
  echo "No hay especies para {$orignallifeform}";
}


    



});