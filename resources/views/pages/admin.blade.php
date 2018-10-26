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
        <br>
        <br>

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

    


</div >
<script src="{{ asset('js/jsfunc.js') }}" >
</script>
@include('inc/footer');
   