<!-- Header -->
<div id="header">
    <div class="top">
        <!-- Logo -->
        <div id="logo">
            <?php
            $root_directory = "testdir";
            if (session('email')) {
                $useremail=session('email');
                echo "<h1 id='title'><a class='top-link' id='useremail' href='/admin'>{$useremail}</a></h1>";
                if (session('admin')){
                    echo "<p><a class='top-link' id='useremail' href='/admin'>Herramientas de Admin</a></p>";
                    echo "<p><a class='top-link' id='okp-top' target='_blank' href='https://satoxapampa.mooo.com'>Gestor de Aplicativos</a></p>";
                }
            }else{
                echo "<h1 id='title'><a class='top-link' href='/login' style='font-size: 1.6em;'>Iniciar sesión</a></h1>";
                echo "<p id='title'><a class='top-link' href='/register' style='font-size: 1.4em;'>Registro</a></p>";
            }
                ?>
        </div><!-- logo -->

        <!-- Nav -->
        <nav id="nav">
        <?php if (session('email')) {?>
            <ul>
                <li><a href="/mostrarmapas" id="mostrarmapas"><span class="icon solid fa-map-marked-alt">Mostrar Mapas</span></a></li>
                <li><a href="/ingresardatos" id="ingresardatos-link"><span class="icon solid fa-crow">Monitoreo <br>de Biodiversidad</span></a></li>
                <li><a href="/actividad" id="actividad-link"><span class="icon solid fa-clipboard-check">Monitoreo <br>de Acciones</span></a></li>
                <li><a href="/cultivo" id="cultivo-link"><span class="icon solid fa-seedling">Monitoreo Productivo</span></a></li>
                <li><a href="/cambiar/linea" id="cambiar-linea-link"><span class="icon solid fa-code-branch">Linea TIM</span></a></li>
                <li><a href="/descargar" id="descargar-link"><span class="icon solid fa-download">Descargar Datos</span></a></li>
                <li><a href="/ingresarexcel" id="ingresarexcel-link"><span class="icon solid fa-file-excel">Ingresar Excel</span></a></li>
                <?php if (session('email')){?>
                    <li><a href="/logout" id="logout-link"><span class="icon solid fa-sign-out-alt">Cerrar sesi&oacute;n</span></a></li>
                <?php }?>
            </ul>
        <?php } ?>
        </nav> <!-- nav -->
    </div><!-- top -->

    <div class="bottom">
        <!-- Social Icons -->
        <ul class="icons">
            <?php echo "<li><a href='/privacidad' class='brands><span class='label'>Privacidad</span></a></li>"; ?>
        </ul>
    </div><!-- bottom -->
</div><!-- header -->