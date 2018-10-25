    <nav class="navbar navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <span class="navbar-brand">MTP Biodiversidad</span>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="/descargar">Descargar</a></li>
                    <li><a href="/ingresardatos">Ingresar Datos</a></li>
                    <li><a href="/mostrarmapas">Mostrar Mapas</a></li>
                    <li><a href="/ingresarexcel">Ingresar Excel</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                <?php
                    $root_directory = "testdir";
                        if (session('email')) {
                            $useremail=session('email');
                            if (session('admin')){
                                echo "<li><a href='/admin'>Admin</a></li>";
                            }
                            echo "<li><a >{$useremail}</a></li>";
                            echo "<li><a href='/logout'>Logout</a></li>";
                        } else {
                            echo "<li><a href='/login'>Login</a></li>";
                            echo "<li><a href='/register'>Registro</a></li>";
                        }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
