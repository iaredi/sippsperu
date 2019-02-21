
<?php
       
        $sessionlist=['linea_mtp','medicion'];
        foreach($sessionlist as $sessiondropdown){
            if (session()->has('my_'.$sessiondropdown)){



                echo "<script>document.getElementsByName(".json_encode('select'.$sessiondropdown).")[0].value=".json_encode(session('my_'.$sessiondropdown))."</script>";


                echo "<script>document.getElementsByName(".json_encode('select'.$sessiondropdown).")[0].onchange()</script>";
            

            }
        }

    if (sizeof(session('error'))>0 && isset($_POST['mode']) ) {
        echo '<script>var newold='.json_encode($_POST['mode']).'</script>';

        if (isset($_POST['hiddenlocation'])){
            echo '<script>var hiddenlocationvalue='.json_encode($_POST['hiddenlocation']).'</script>';
        }
        $dropdownlist=['selectlinea_mtp','selectestado','selectmunicipio','selectpredio','selectmedicion','selectobservaciones','selectTransecto','selectPunto'];
        foreach($dropdownlist as $dropdown){
            if (isset($_POST[$dropdown])){

                echo "<script>document.getElementsByName(".json_encode($dropdown).")[0].value=".json_encode($_POST[$dropdown])."</script>";


                if ($dropdown!='selectTransecto' && $dropdown!='selectPunto'){

                    
                    echo "<script>document.getElementsByName(".json_encode($dropdown).")[0].onchange()</script>";
                }
            }
        }
        if (isset($_POST['selectobservaciones'])){
            echo "<script>document.getElementById('readybutton').click()</script>";
            
            
        }
        
        $alreadyhasrows=true;

        foreach( $_POST as $postkey2=> $postval2) {
            if (substr_count($postkey2, '*')==2){
                $rowandnum=explode("*" , $postkey2)[0];
                $tablename= explode("*" , $postkey2)[1];
                $columnname= explode("*" , $postkey2)[2];
                $needrowsadded=["row0*personas*nombre","row0*gps*anio","row0*camara*anio","row0*linea_mtp*comienzo_latitud"];
                if (in_array($postkey2, $needrowsadded )){
                    $alreadyhasrows=false;
                }
                if ($postkey2=="row0*{$tablename}*notas") {
                    $alreadyhasrows=false;
                }

                if ($tablename=='observacion_arbol'||$tablename=='observacion_arbusto'){
                    $alreadyhasrows=true;
                }

                if (!$alreadyhasrows){
                    for ($x = 1; $x < countrows($_POST, $tablename); $x++){
                        echo "<script>document.getElementById('addElementRow'+".json_encode($tablename).").onclick()</script>";
                        
                    }
                    $alreadyhasrows=true;
                }
                echo "<script>document.getElementsByName(".json_encode($postkey2).")[0].value=".json_encode($postval2)."</script>";
         
                if ($columnname=="species"){
                    echo "<script>document.getElementsByName(".json_encode($postkey2).")[0].onchange()</script>";
                }

                if ($columnname=="invasor" && $postval2=="true"){
                    echo "<script>document.getElementsByName(".json_encode($postkey2).")[0].checked=true</script>";
                }
                if ($columnname=="cactus" && $postval2=="true"){
                    echo "<script>document.getElementsByName(".json_encode($postkey2).")[0].checked=true</script>";
                }
                if ($columnname=="anfibio" && $postval2=="true"){
                    echo "<script>document.getElementsByName(".json_encode($postkey2).")[0].checked=true</script>";
                }
            }
        }
    }
  
?>