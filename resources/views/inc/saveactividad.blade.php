<?php
	function saveactividad($newpost, $useremail){
		$resultofquery=[];
			if ($_POST['selectactividad']!='Nuevo'){
				//Delete old one
				$sql = "DELETE FROM actividad WHERE descripcion= ?";
                $numrows =DB::delete($sql, [$_POST['selectactividad']]);
			}



		// $actividadcolumns=array(
		// 		"clave"=> $newpost['row0*estado*clave'],
		// 		"nombre"=> $newpost['row0*estado*nombre']
		// 	);
			$unitcolumns=buildcolumnsarray($newpost,"actividad", "row0");
			$unitcolumns["iden_estado"]=askforkey("estado", "clave", "nombre", $newpost['selectestado']);

			$unitcolumns["iden_municipio"]=askforkey("municipio", "gid", "nombre", $newpost['selectmunicipio']); 

			$resultofquery[]= savenewentry("actividad", $unitcolumns);
			$actividadkey = getserialmax("actividad");

			if($newpost['row0*actividad*tipo_geom']=='punto'){
				$updatesql = "UPDATE actividad set iden_geom = (SELECT ST_GeomFromText('POINT(
							{$newpost['row0*actividad*longitud']} {$newpost['row0*actividad*latitud']}
							)',4326)) WHERE iden = ?";
				$updatedgeom = DB::update($updatesql, [$actividadkey]); 
			}
			if($newpost['row0*actividad*tipo_geom']=='poligono'){
				uploadshape('shp');
				uploadshape('shx');
				uploadshape('dbf');
				uploadshape('prj');
				$shpfile=$_FILES['shp']["name"];
				$sridshell= shell_exec("ogr2ogr -t_srs EPSG:4326 ../storage/shp/{$shpfile}2 ../storage/shp/{$shpfile}");
				$shapenombre=$_POST['shapenombre'];
				if (env("APP_ENV", "somedefaultvalue")=='production'){
				
					//load to temp table 
					$db = env("DB_PASSWORD", "somedefaultvalue");
					$dbname = env("DB_DATABASE", "somedefaultvalue");
					$loadshp="shp2pgsql -I -s 4326:4326 ../storage/shp/{$shpfile}2 {$shapenombre} | PGPASSWORD='{$db}' psql -U postgres -h localhost -d {$dbname}";
					
					$output= shell_exec($loadshp);
					$output2= shell_exec("rm -rf ../storage/shp/*");

						if (strpos($output, 'ROLLBACK') == false) {
							//insert into geom usertable
							$copyshp = "UPDATE actividad set iden_geom = ? where iden = ? ";
							$geom= DB::select("select geom from {$shapenombre}", []);
							if (isset($geom[0])){
								$results = DB::update($copyshp, [$geom[0]->geom,$actividadkey]); 
								DB::statement("drop table {$shapenombre}");
							//return redirect()->to('/thanks')->send();
						}else{
							$errorlist[]= "Su shape no tiene polygono";
						}
					}else{
						$errorlist[]= "Por favor, cambie el nombre de su shape ";
					}
				} 
			}
					  
			

	
	}
  
?>