<?php 
if (!session('admin')){
    return redirect()->to('/login')->send();
}
?>
@include('inc/saveadmin')
@include('inc/setuppage')
@include('inc/header')
@include('inc/nav')

   <img src="{{ asset('img/popo.jpg') }}"  alt="Italian Trulli" style="height:250px; width:380px;">
   <div>
        <div class="row">
            <div class="warnings">
                <?php
                    if (session('adminerror')) {
                        $msg=session('adminerror');
                        echo "<p class='bg-info text-center'>{$msg}</p>";
                        
                    }
                    session(['adminerror'=>'']);

                ?>
            </div>
        </div>

<div class="wrapper2" id="startMenuDiv">
    
<div class='border border-dark p-2 m-2'>
    <form id="measurementform" method="post">
            {{ csrf_field() }}

        <h3 id="measurement3">Cambiar Usuario Activo</h3>
        <table class="mytable" >
            <tbody id="measurementTBodySelect">
            </tbody>
        </table>
        <input type="radio" name="admin_option" value="add_admin"> Dar Privilegio Admin<br>
        <input type="radio" name="admin_option" value="remove_admin"> Borrar Privilegio Admin<br>
        <input type="radio" name="admin_option" value="delete_user"> Borrar Ususario
        <br>
        <br>
        <input type="hidden" name="action" value="activo">
        <input type="submit" id="measurementlinea_mtpSubmit" class="mySubmit">

    </form>
</div>
        <br>
        <br>
<div class='border border-dark p-2 m-2'>
    <form id="measurementform" method="post">
        {{ csrf_field() }}

        <h3 id="measurement3">Cambiar Emails Permitidos</h3>
        <table class="mytable">
            <tbody id="measurementTBodyMedicion">
            </tbody>
        </table>

        <input type="radio" name="admin_option" value="remove_email"> Borrar Email <br>
        <input type="radio" name="admin_option" value="add_email"> Añadir Email Nuevo
        <input type="text"  name="email_input">
        <input type="checkbox" name="visitante" value="1"> *Visitante<br>
        
        <br>
        <br>
        <input type="hidden" name="action" value="permitido">
        <input type="submit" id="measurementlinea_mtpSubmit" class="mySubmit">
    </form>
</div>
<br>
<br>
<div class='border border-dark p-2 m-2'>
    <form id="measurementform" method="post">
            {{ csrf_field() }}
            <h3 id="measurement3">Cambiar Campos</h3>
            <br>

            <br>
            <h5 class="font-weight-bold">Borrar Campo<h5>
            <div class="row">
                <div class="form-group col-6 border border-secondary p-1 mx-3">
                    <label for="table_option">Eliger Tabla</label>
                    <select name='table_option' id='table_option' class='table_option form-control'>
                        <option value="not_selected"></option>
                        <option value="transecto_hierba">transecto_hierba</option>
                        <option value="transecto_herpetofauna">transecto_herpetofauna</option>
                        <option value="punto_arbol">punto_arbol</option>
                        <option value="punto_arbusto">punto_arbusto</option>
                        <option value="punto_mamifero">punto_mamifero</option>
                        <option value="punto_ave">punto_ave</option>
                        <option value="observacion_hierba">observacion_hierba</option>
                        <option value="observacion_herpetofauna">observacion_herpetofauna</option>
                        <option value="observacion_arbol">observacion_arbol</option>
                        <option value="observacion_arbusto">observacion_arbusto</option>
                        <option value="observacion_mamifero">observacion_mamifero</option>
                        <option value="observacion_ave">observacion_ave</option>
                    </select>
              
                    <label for="field_option">Eliger Campo</label>
                    <select name='field_option' id='field_option'  class='field_option form-control'></select>
                    <input type="hidden" name="action" value="delete_field">
                    <input type="submit" id="deletecampo" class="mySubmit">
                </div>
            </div>
            
    </form>
    
            
            <br>
             <form id="measurementform" method="post">
            {{ csrf_field() }}
            <h5 class="font-weight-bold">Guardar Campo<h5>
            <div class="row">
                <div class="form-group col-6 border border-secondary p-1 mx-3">
                
                <input type="text"  name="field_input" placeholder="Nombre del Campo"><br>
                <label for="table_option2">Eliger Tabla</label>
                <select name='table_option2' id='table_option2' class='table_option2 form-control'>
                    <option value="not_selected"></option>
                    <option value="transecto_hierba">transecto_hierba</option>
                    <option value="transecto_herpetofauna">transecto_herpetofauna</option>
                    <option value="punto_arbol">punto_arbol</option>
                    <option value="punto_arbusto">punto_arbusto</option>
                    <option value="punto_mamifero">punto_mamifero</option>
                    <option value="punto_ave">punto_ave</option>
                    <option value="observacion_hierba">observacion_hierba</option>
                    <option value="observacion_herpetofauna">observacion_herpetofauna</option>
                    <option value="observacion_arbol">observacion_arbol</option>
                    <option value="observacion_arbusto">observacion_arbusto</option>
                    <option value="observacion_mamifero">observacion_mamifero</option>
                    <option value="observacion_ave">observacion_ave</option>
                </select>
                <label for="datatype">Eliger Tipo de data</label>
                <select name='datatype' id='datatype' class='table_option form-control'>
                    <option value="not_selected"></option>
                    <option value="varchar">varchar</option>
                </select>
            <input type="hidden" name="action" value="add_field">
            <input type="submit" id="campo" class="mySubmit">
                </div>
            </div>
            <br>
            <br>
            
    </form>
    
</div >


<div class='border border-dark p-2 m-2'>
        <form id="measurementform" method="post">
            {{ csrf_field() }}
    
            <h3 id="measurement3">Cambiar Capas</h3>
            <table class="mytable">
                <tbody id="measurementTBodycargar">      
                </tbody>
            </table>
            <input type="checkbox" name="deletetable" value="1"> Borrar completamente<br>

            <div>
                <label for="displayname" class=" h6 displayname">Nombre para Mostrar</label>
                <input type="text" required name="displayname" id="displayname">
            </div>
            <div>
              <label for="campoclick" class=" h6 displayname">Campo Click</label>
              <input type="text" required name="campoclick" id="campoclick">
          </div>
            <div>
                <label for="fillcolor" class=" h6 shapenombre">Fill Color</label>
                <input type="color" required name="fillcolor" id="fillcolor">
            </div>
            <div>
                <label for="lineacolor" class=" h6 shapenombre">Linea Color</label>
                <input type="color"  required name="lineacolor" id="lineacolor">
            </div>
            <div>
                <label for="fillopacidad" class=" h6 shapenombre">Fill Opacidad</label>
                <input type="number" min=0 max=1 step = 0.1 required name="fillopacidad" id="fillopacidad">
            </div>
            <div>
                <label for="lineaopacidad" class=" h6 shapenombre">Linea Opacidad</label>
                <input type="number" min=0 max=1 step = 0.1 required name="lineaopacidad" id="lineaopacidad">
            </div>
            <div>
                <label for="lineaanchura" class=" h6 shapenombre">Linea Anchura</label>
                <input type="number" min=0 max=5 step = 0.1 required name="lineaanchura" id="lineaanchura">
            </div>
            <br>
            
            <input type="hidden" name="action" value="cargarshape">
            <input type="submit" id="measurementlinea_mtpSubmit" class="mySubmit">
        </form>
        <div style='text-align:center;'> 
            <a id="cargarbutton" href="/cargarshapesadmin" role="button">Cargar Shapefile</a>
        </div> 
    </div>

</div >
<script src="{{ asset('js/jsfunc.js') }}" >
</script>
@include('inc/footer')
   