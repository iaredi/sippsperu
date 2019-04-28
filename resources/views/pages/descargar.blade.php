@include('inc/php_functions')
<?php 

?>

@include('inc/header')
@include('inc/nav')



   
   <img src="{{ asset('img/popo.jpg') }}"  alt="Italian Trulli" style="height:250px; width:380px;">
   <div>
        

        <div class="wrapper2" id="startMenuDiv">
    

    <form id="measurementform" method="post" action="/descargarfile">
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
