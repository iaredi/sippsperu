@include('inc/php_functions')
<?php 
if (!session('email')){
    return redirect()->to('/login')->send();
}

if ($_SERVER['REQUEST_METHOD']=="POST"){
    

    $targetob='observacion_'.$_POST['dl_option'];
    $email = session('email');
    $name=  explode("@" , $email)[0];
    $myfile= "C:\\Users\\fores\\Desktop\\sql\\{$name}_{$_POST['dl_option']}.csv";

    

    
    $sql = "COPY (SELECT * FROM {$targetob} 
    WHERE iden_email = '{$email}') 
    TO '{$myfile}'
    with ( format CSV, HEADER)";

    $result = DB::select($sql, []);
    

    if (file_exists($myfile)) {
        header('Content-Description: File Transfer');
        header('Content-Type: Document');
        header('Content-Disposition: attachment; filename="'.basename($myfile).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($myfile));
        readfile($myfile);
        exit;
    }
    echo "!!!!ahora es admin";






}


?>

@include('inc/header')
@include('inc/nav')



   
   <img src="{{ asset('img/malinche.jpg') }}"  alt="Italian Trulli" style="width:500px;height:200px;">
   <div>
        

        <div class="wrapper2" id="startMenuDiv">
    

    <form id="measurementform" method="post">
            {{ csrf_field() }}

        <h3 id="measurement3">Descargar datos de su email</h3>
        
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
