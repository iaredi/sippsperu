@include('inc/php_functions')

<?php
	if (!session('email')){
		return redirect()->to('/login')->send();
	}
	if (!session('readpp')){
		return redirect()->to('/privacidad')->send();
	}
?>

<?php
    Session_start();
    $errorlist=[];
    if ($_SERVER['REQUEST_METHOD']=="POST"&& (!session('visitante'))){
        $filearray=['shp','shx','dbf','prj'];
        
        //se obtiene el catálogo de especies
        $sql="SELECT nombre, iden FROM especies;";
        $catEspecies= DB::select($sql, []);
        $catEspecies=array_column($catEspecies, 'nombre');
        $catEspeciesId=array_column($catEspecies, 'iden');
        
        $base = substr($_FILES['prj']["name"],0,-4);
        foreach( $filearray as $filetype) {
            if (!$_FILES[$filetype]["name"]) {
                $errorlist[]= "Seleccione un archivo {$filetype} ";
            }
            $test = substr($_FILES[$filetype]["name"],0,-4);
            if (substr($_FILES[$filetype]["name"],-4,4) !== ".{$filetype}" ) {
                $errorlist[]= "El archivo seleccionado en {$filetype} no tiene extension .{$filetype} ";
            }
            if (substr($_FILES[$filetype]["name"],0,-4) != $base ) {
                $message="Todos los archivos deben de tener el mismo nombre";
                if (!in_array($message, $errorlist)){
                    $errorlist[]= $message;
                }
            }
        }
        if (!$_POST['shapenombre']) {
            $errorlist[]= "Por favor escriba un nombre para el \"Shape\"";
        }
    }
    
    if ($_SERVER['REQUEST_METHOD']=="POST" && sizeof($errorlist)==0 && (!session('visitante'))  ){
        uploadshape('shp');
        uploadshape('shx');
        uploadshape('dbf');
        uploadshape('prj');
        $shpfile=$_FILES['shp']["name"];
        $tmpShpfile=substr($shpfile,0,-4);
        $sridshell= shell_exec("ogr2ogr -t_srs EPSG:4326 ../storage/shp/{$tmpShpfile}2.shp ../storage/shp/{$shpfile}");
        $shapenombre=$_POST['shapenombre'];
        if (env("APP_ENV", "somedefaultvalue")=='production'){
            //load to temp table 
            $db = env("DB_PASSWORD", "somedefaultvalue");
            $dbname = env("DB_DATABASE", "somedefaultvalue");
            //$loadshp="shp2pgsql -I -s 4326:4326 ../storage/shp/{$shpfile}2 {$shapenombre} | PGPASSWORD='{$db}' psql -U plataforma -h localhost -d {$dbname}";
            $loadshp="shp2pgsql -W LATIN1 -g geom -I -s 4326:4326 ../storage/shp/{$tmpShpfile}2.shp {$shapenombre} | PGPASSWORD='{$db}' psql -U plataforma -h localhost -d {$dbname}";
            $output= shell_exec($loadshp);
            $output2= shell_exec("rm -rf ../storage/shp/*");
                if (strpos($output, 'ROLLBACK') == false) {
                    //insert into geom usertable
                    $copyshp="insert into usershapes (nombre, iden_email, geom, temp_shape) values (:nombre, :email, :geom, true)";
                    $geom= DB::select("select geom from {$shapenombre};", []);
                    if (isset($geom[0])){
                        foreach($geom as $ge){
                            $arraytopass=array(
                                ":nombre"=> $shapenombre,
                                ":email"=> session('email'),
                                ":geom"=> $ge->geom,
                            );
                            $results = DB::insert($copyshp, $arraytopass);
                            $sql="SELECT gid FROM usershapes ORDER BY gid desc LIMIT 1;";
                            $uda_id= DB::select($sql, [])[0]->gid;
                            
                            //identifica los puntos que intersecan al shape
                            $sql="SELECT iden,iden_medicion,ap.iden_email,catespecie_iden
                                FROM all_puntos ap JOIN usershapes 
                                ON ST_Intersects(geom, ST_SetSRID(ST_MakePoint(longitud_gps, latitud_gps),4326)) 
                                WHERE gid={$uda_id} AND processed=false;";
                            $intersectedPoints = DB::select($sql, []);
                            if(sizeof($intersectedPoints)>0){
                                $cols=[];
                                $cols['iden_uda']=$uda_id;
                                //guarda los puntos que intersecan al shape en la tabla puntosmtp_udas
                                foreach($intersectedPoints as $ipoint){
                                    $cols['iden_punto']=$ipoint->iden;
                                    $cols['iden_medicion']=$ipoint->iden_medicion;
                                    //se obtiene el id de la especie, tomando en cuenta el catálogo de especies
                                    $cols['catespecie_iden']=$ipoint->catespecie_iden;
                                    
                                    //se guarda la relación uda <-> punto TIM
                                    $resultUdaXPuntoInsert=savenewentry("puntosmtp_udas", $cols,false,false);
                                }
                                //Se marca el shape como processed  
                            }
                            $updatesql = "UPDATE usershapes set processed = true WHERE gid={$uda_id};";
                            $updatedUsershape = DB::update($updatesql, []);
                        }
                    
                    DB::statement("drop table {$shapenombre}");
                    //se borra la capa de la sesión para que se vuelva a calcular.
                    unset($_SESSION['capas']['Poligonos']);

                    return redirect()->to('/thanks')->send();
                }else{
                    $errorlist[]= "Su shape no tiene polygono";
                }
            }else{
                $errorlist[]= "Por favor, cambie el nombre de su shape ";
            }
        }else{
			echo "This is not production";
		}
    }
?>

@include('inc/header')
@include('inc/nav')
<div class='bodycontainer' id="main">
    <section class="four">
        <div class="container">
            <p class="text-center h2">Cargar Shapes</p>
            <div class=" warnings">
                <?php

                $hint1="Para que la carga del shape sea exitosa, aseg&uacute;rese de que la proyección es ESPG:4326.";
                echo $hint1;
                    if (sizeof($errorlist)>0){
                        echo "<div class='bg-danger2'>";
                        foreach ($errorlist as $msg) {
                            echo "<span>{$msg}</span>";
                        }
                        echo '</div>';
                    }
                ?>
            </div>
            <form id="login-form"  method="post" role="form" style="display: block;" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="shapenombrediv">
                    <label for="shapenombre" class=" h4 shapenombre">Nombre</label>
                    <input type="text" name="shapenombre" id="shapenombre">
                </div>
                <div class="shapenombrediv">
                    <label for="shp" class="h4 shapelabel">.shp</label>
                    <input type="file" name="shp" id="shp" accept=".shp">
                </div>
                <div class="shapenombrediv">
                    <label for="shx" class="h4 shapelabel">.shx</label>
                    <input type="file" name="shx" id="shx" accept=".shx">
                </div>
                <div class="shapenombrediv">
                    <label for="dbf" class="h4 shapelabel">.dbf</label>
                    <input type="file" name="dbf" id="dbf" accept=".dbf">
                </div>
                <div class="shapenombrediv">
                    <label for="prj" class="h4 shapelabel">.prj</label>
                    <input type="file" name="prj" id="prj" accept=".prj">
                </div>
                
                <p class="separador"></p>
                <div class="">
                    <input type="submit" name="login-submit" id="login-submit" tabindex="4" class="" value="Enviar">
                </div>
            </form>
        <div>
    </section>
    @include('inc/footer')
</div>
<?php session(['resultofquery' => '']); ?>