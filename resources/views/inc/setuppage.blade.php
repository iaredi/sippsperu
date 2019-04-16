





<?php

//include 'dbconfig.php';
$ptablename='table_name';
$pcolumnname='column_name';
$constraitdef= 'pg_get_constraintdef';
$tablefrom= 'table_from';
$titlessql='SELECT name_table, name_column FROM titulos;';
$munisql='SELECT nombre FROM municipio;';

$keyssql='SELECT conrelid::regclass AS '.$tablefrom.'
, conname
, '.$constraitdef.'(c.oid)
FROM   pg_constraint c
JOIN   pg_namespace n ON n.oid = c.connamespace
WHERE  contype IN (\'f\', \'p \')
AND    n.nspname = \'public\' 
ORDER  BY conrelid::regclass::text, contype DESC;';

$tablenamesql='SELECT '.$ptablename.', '.$pcolumnname.' FROM information_schema.columns WHERE table_schema=\'public\';';
$mycollist = DB::select($tablenamesql);
$mykeylist = DB::select( $keyssql);
$alltitles = DB::select( $titlessql);
$muninames = DB::select( $munisql);

$listofcolumns= [];
$tablenamesarray=[];
$completekeyarray=[];
$completepkeyarray=[];
$completevallist=[];
$alltablenamesarray=[];
$titlenamesarray=[];
$completetitlevallist=[];

foreach($alltitles as $r){
    $titlenamesarray[$r->name_table]=$r->name_column;
    
}
unset($r);


foreach ($titlenamesarray as $key=>$value) {
    $titlevaluessql='SELECT '.$value.' FROM '.$key.';';
    $alltitlevalues = DB::select($titlevaluessql);
    $currentvallist=[];
    foreach($alltitlevalues as $r){
        array_push($currentvallist,$r->$value);
    }
    unset($r);


    $completetitlevallist[$key]=$currentvallist;

}

unset($value);


foreach($mycollist as $r){
    array_push($tablenamesarray,$r->$ptablename);
    array_push($listofcolumns,$r->$ptablename.'*'.$r->$pcolumnname);
    
}
unset($r);




foreach($mykeylist as $r){
     
    //get FKEYS Columns
    if(substr($r->$constraitdef,0,1)=="F"){
        $spiltref= explode(") REFERENCES " ,$r->$constraitdef );
        $fkeycol= explode( "(" , $spiltref[0] );
        $parenttable= explode(   "(" ,$spiltref[1] );
        array_push($completekeyarray,$r->$tablefrom, $fkeycol[1], $parenttable[0] );
        }

    //get PKEYS Columns
    if(substr($r->$constraitdef,0,1)=="P"){
        $spiltrefp= explode("(" ,$r->$constraitdef) ;
        $pkeycol= explode( ")" , $spiltrefp[1] );
        array_push($completepkeyarray,$r->$tablefrom, $pkeycol[0] );
    }

}
unset($r);

//get FKEYS Values
for ($x = 0; $x < sizeof($completekeyarray); $x=$x+3) {
    $fkeyvalssql='SELECT '.$completekeyarray[$x+1].' AS '.$completekeyarray[$x+1].'  FROM '.$completekeyarray[$x].' ;';
    $fkeyvallist = DB::select($fkeyvalssql);
    foreach($fkeyvallist as $r){
        $mycolnow=$completekeyarray[$x+1];
        array_push($completevallist,$completekeyarray[$x],$completekeyarray[$x+1],$r->{$completekeyarray[$x+1]});
    }
} 
unset($r);



    //get PKEYS Values
for ($x2 = 0; $x2 < sizeof($completepkeyarray); $x2=$x2+2) {
    $pkeyvalssql='SELECT '.$completepkeyarray[$x2+1].' FROM '.$completepkeyarray[$x2].' ;';
    $pkeyvallist = DB::select($pkeyvalssql);
    $mycurrentvalues=[];
    foreach($pkeyvallist as $r){
        array_push($mycurrentvalues, $r->{$completepkeyarray[$x2+1]});
    }
    $completePValList[$completepkeyarray[$x2]]=$mycurrentvalues;

} 
unset($r);
?>
<script>
var completevallist=<?php echo json_encode($completevallist) ; "\n";?>


var completeKeys=<?php echo json_encode($completekeyarray) ; "\n";?>


var completetitlevallist=<?php echo json_encode($completetitlevallist) ; "\n";?>


var completePValList=<?php echo json_encode($completePValList) ; "\n";?>



var muninames=<?php echo json_encode($muninames) ; "\n";?>







var allPhp2={}
for (var i= 0; i<completeKeys.length; i=i+3){

allPhp2[completeKeys[i+2]]=allPhp2[completeKeys[i+2]] || [];
allPhp2[completeKeys[i]]=allPhp2[completeKeys[i]] || [];

allPhp2[completeKeys[i+2]]["childTables"]=allPhp2[completeKeys[i]]["childTables"] || [];
allPhp2[completeKeys[i+2]]["childTables"] .push(completeKeys[i])

allPhp2[completeKeys[i]]["fKeysLink"]=allPhp2[completeKeys[i]]["fKeysLink"] || new Map;
allPhp2[completeKeys[i]]["fKeysLink"] .set(completeKeys[i+1],completeKeys[i+2])

allPhp2[completeKeys[i]]["fKeyCol"]=allPhp2[completeKeys[i]]["fKeyCol"] || [];
allPhp2[completeKeys[i]]["fKeyCol"].push(completeKeys[i+1])

}
for (var i= 0; i<completevallist.length; i=i+3){
allPhp2[completevallist[i]]=allPhp2[completevallist[i]] || [];

allPhp2[completevallist[i]]["fKeyValues"]=allPhp2[completevallist[i]]["fKeyValues"] || new Map;
var myCurrentArray=myCurrentArray || [];
myCurrentArray[completevallist[i]]=myCurrentArray[completevallist[i]] || [];
myCurrentArray[completevallist[i]][completevallist[i+1]]=myCurrentArray[completevallist[i]][completevallist[i+1]] || [];
myCurrentArray[completevallist[i]][completevallist[i+1]].push(completevallist[i+2])

allPhp2[completevallist[i]]["fKeyValues"] .set(completevallist[i+1],myCurrentArray[completevallist[i]][completevallist[i+1]])

}

var tabletoColumns={};
var allTableNames= new Set();
allTableNames.add("base de datos");
allTableNames.delete("titulos");

var tablesColumns=<?php echo json_encode($listofcolumns) ; "\n";?>;


tablesColumns.forEach(function(val){
tablesColumnsSep=val.split("*")
allTableNames.add(tablesColumnsSep[0]);
tabletoColumns[tablesColumnsSep[0]] = tabletoColumns[tablesColumnsSep[0]] || [];
tabletoColumns[tablesColumnsSep[0]].push(tablesColumnsSep[1])
})


var namesOfTables=Array.from(allTableNames);
completetitlevallist["base de datos"]=[];
namesOfTables.forEach(function(val){
        if (val!=="base de datos"){
            completetitlevallist["base de datos"].push(val);
        }
});
</script>




