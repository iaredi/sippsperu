<?php
  function savedatareact($newpost, $useremail, $fromexcel=false){
	
		$resultofquery=[];

		if ($newpost['mode']=='Datos Existentes'){
			
			$table = $newpost['table'];
			$selection = $newpost[$table];
			$selectedcolumn = $newpost['selectedcolumn'];
			$rowarray=[];
			
			foreach ($newpost as $key => $value) {
				if (substr($key,0,3) =='row'){
					$rowandnum = explode('*',$key)[0];
					$rowarray[$rowandnum][$key]=$value;
				}
			}
			//echo var_dump($columnarray); 
			$columnsarray=[];
			$valuearray=[];
			foreach ($rowarray as $row => $keyandvalue) {
				foreach ($keyandvalue as $key2 => $value2) {
					$columnsarray[]=explode('*',$key2)[2];
					$valuearray[]=$value2;
				}
			
				$columnsarraystring = implode(',',$columnsarray);
				$valuearraystring = implode(',',$valuearray);
				if($table=='linea_mtp'){
					$name = explode("(" , $selection)[0];
					$arraytopass =['selectedvalue'=>$selection];
					
					$new_iden_nombre = "{$name}({$newpost['row0*linea_mtp*comienzo_latitud']},{$newpost['row0*linea_mtp*comienzo_longitud']}) ({$newpost['row0*linea_mtp*fin_latitud']},{$newpost['row0*linea_mtp*fin_longitud']})";
					$completesql = "UPDATE {$table} SET ({$columnsarraystring},{$selectedcolumn}) = ({$valuearraystring},'{$new_iden_nombre}') WHERE {$selectedcolumn} = :selectedvalue";
					$results = DB::update($completesql, $arraytopass);

					$updatesql = "UPDATE linea_mtp set iden_geom = (SELECT ST_GeomFromText('MultiLineString((
						{$newpost['row0*linea_mtp*comienzo_longitud']} {$newpost['row0*linea_mtp*comienzo_latitud']},
						{$newpost['row0*linea_mtp*punto_2_longitud']} {$newpost['row0*linea_mtp*punto_2_latitud']},
						{$newpost['row0*linea_mtp*punto_3_longitud']} {$newpost['row0*linea_mtp*punto_3_latitud']},
						{$newpost['row0*linea_mtp*punto_4_longitud']} {$newpost['row0*linea_mtp*punto_4_latitud']}, 
						{$newpost['row0*linea_mtp*fin_longitud']} {$newpost['row0*linea_mtp*fin_latitud']}
						))',4326)) WHERE {$selectedcolumn} = :selectedvalue";
					  $updatedgeom = DB::update($updatesql, ['selectedvalue'=>$new_iden_nombre]);
					  return true;
				}
			}
		


		}

		
	}
?>