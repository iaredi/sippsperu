@include('inc/php_functions')
<?php 
if (!session('email')){
    return redirect()->to('/login')->send();
}
session(['speciesabsent' => 'false']);

if ($_SERVER['REQUEST_METHOD']=="POST"){
 
    $lifeform= $_POST['dl_option'];
    $targetob='especie_'.$lifeform;
    $email = session('email');
    $name=  explode("@" , $email)[0];
    $rawfile= "C:\\Users\\fores\\Desktop\\sql\\raw{$targetob}.xml";
    $finalfile= "C:\\Users\\fores\\Desktop\\sql\\{$targetob}.xml";
    
    if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
        $rawfile= "/psotgres/raw{$targetob}.xml";
        $finalfile= "/postgres/{$targetob}.xml";
    } 

    $transpunto='punto';
    if ($_POST['dl_option']=='hierba' || $_POST['dl_option']=='herpetofauna'){
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
  $txt = '<?xml version="1.0" encoding="UTF-8"?><LOOKUPTABLES>'.$text."</LOOKUPTABLES>";
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
}else{
  $nospecies = "No hay especies para {$lifeform}";
  session(['speciesabsent' => 'true']);
}


    

}


?>

@include('inc/header')
@include('inc/nav')



   
   <img src="{{ asset('img/popo.jpg') }}"  alt="Italian Trulli" style="height:250px; width:380px;">
   <div>
        

        <div class="wrapper2" id="startMenuDiv">
    

    <form id="measurementform" method="post">
            {{ csrf_field() }}

        <h3 id="measurement3">Descargar lista de especies</h3>
        
        <input type="radio" name="dl_option" value="ave"> ave<br>
        <input type="radio" name="dl_option" value="arbol"> arbol<br>
        <input type="radio" name="dl_option" value="arbusto"> arbusto<br>
        <input type="radio" name="dl_option" value="herpetofauna"> herpetofauna<br>
        <input type="radio" name="dl_option" value="hierba"> hierba<br>
        <input type="radio" name="dl_option" value="mamifero"> mamifero<br>
        <input type="submit" id="measurementlinea_mtpSubmit" class="mySubmit">

    </form>

    


</div >

@include('inc/footer') 


<?php



  if (session('speciesabsent')=='true') {
    echo $nospecies;
  }
?>
