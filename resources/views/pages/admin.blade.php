<?php 
if (!session('admin')){
    return redirect()->to('/login')->send();
}
?>
@include('inc/saveadmin')
@include('inc/setuppage')
@include('inc/header')
@include('inc/nav')


   <img src="{{ asset('img/malinche.jpg') }}"  alt="Italian Trulli" style="width:500px;height:200px;">
   <div>
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
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
        <input type="radio" name="admin_option" value="add_admin"> Add Admin<br>
        <input type="radio" name="admin_option" value="remove_admin"> Remove Admin<br>
        <input type="radio" name="admin_option" value="delete_user"> Delete User
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

        <input type="radio" name="admin_option" value="remove_email"> Remove Email <br>
        <input type="radio" name="admin_option" value="add_email"> Add New Email
        <input type="text"  name="email_input" placeholder="">
        
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
                
                <input type="text"  name="field_input" placeholder="Nombre del Campo">
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
                        <option value="int">int</option>
                        <option value="real">double</option>
                        </select>
            <input type="hidden" name="action" value="add_field">
            <input type="submit" id="campo" class="mySubmit">
                </div>
            </div>
            <br>
            <br>
            
    </form>
    
</div >


</div >
<script src="{{ asset('js/jsfunc.js') }}" >
</script>
@include('inc/footer')
   