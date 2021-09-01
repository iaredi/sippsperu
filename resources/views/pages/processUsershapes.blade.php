@include('inc/php_functions')
<?php 

if ($_SERVER['REQUEST_METHOD']=="POST"){

}
?>

@include('inc/header')
@include('inc/nav')

<?php
$usershapes= DB::select("select gid, geom from usershapes where processed=false", []);
if (isset($usershapes[0])){
    foreach($usershapes as $usershape){
        
        //identifica los puntos que intersecan al shape
        $sql="SELECT iden,iden_medicion,ap.iden_email,catespecie_iden
            FROM all_puntos ap JOIN usershapes 
            ON ST_Intersects(geom, ST_SetSRID(ST_MakePoint(longitud_gps, latitud_gps),4326)) 
            WHERE gid={$usershape->gid};";
        $intersectedPoints = DB::select($sql, []);
        if(sizeof($intersectedPoints)>0){
            $cols=[];
            $cols['iden_uda']=$usershape->gid;
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
        $updatesql = "UPDATE usershapes set processed = true WHERE gid={$usershape->gid};";
        $updatedUsershape = DB::update($updatesql, []);
    }
}
?>

@include('inc/footer')