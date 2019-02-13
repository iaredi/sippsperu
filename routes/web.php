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
//Route::get('/udpmapa', 'PagesController@udpmapa');
Route::get('/descargarespecie', 'PagesController@descargarespecie');
Route::get('/mostrarnormas/{infotype}/{idenudpraw}', function ($infotype,$idenudpraw){
  return view('pages/mostrarnormas',['infotype'=>$infotype,'idenudp'=>$idenudpraw]);
});
Route::get('/udpmapa/{infotype}/{shannon}', function ($idennum,$shannon){
  return view('pages/udpmapa',['idennum'=>$idennum,'shannon'=>$shannon]);
});



Route::post('/', 'PagesController@login');
Route::post('/admin', 'PagesController@admin');
Route::post('/descargar', 'PagesController@descargar');
Route::post('/login', 'PagesController@login');
Route::post('/register', 'PagesController@register');
Route::post('/ingresardatos', 'PagesController@ingresardatos');
Route::post('/reset_1', 'PagesController@reset_1');
Route::post('/reset_2', 'PagesController@reset_2');
Route::post('/cargarshapes', 'PagesController@cargarshapes');
Route::post('/cargarshapesadmin', 'PagesController@cargarshapesadmin');
Route::post('/udpmapa', 'PagesController@udpmapa');
Route::post('/ingresarexcel', 'PagesController@ingresarexcel');
Route::post('/descargarespecie', 'PagesController@descargarespecie');
Route::post('/mostrarnormas', 'PagesController@mostrarnormas');


Route::get('getspecieslist/{lifeform}', function ($lifeform) {
    $targetob='especie_'.$lifeform;
  
    $rawfile= "C:\\Users\\fores\\Desktop\\sql\\raw{$targetob}.xml";
    $finalfile= "C:\\Users\\fores\\Desktop\\sql\\{$targetob}.xml";
    
    if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
      $rawfile= "/postgres/raw{$targetob}.xml";
      $finalfile= "/postgres/{$targetob}.xml";
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
                        XMLATTRIBUTES('especie_{$lifeform}' as NAME ),
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
                      
                            where especie_{$lifeform}.cientifico!='0000' and especie_{$lifeform}.cientifico!='000' and especie_{$lifeform}.cientifico!='00'
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
  echo "No hay especies para {$lifeform}";
}


    



});