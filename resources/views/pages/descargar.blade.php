@include('inc/php_functions')
@include('inc/header')
@include('inc/nav')
<div class='bodycontainer' id="main">
    <section class="four">
        <div class="container">
            <header><h2>Descargar Datos</h2></header>
            <div>                       
                <div class=" warnings">
                    <?php
                        $hintlist = [
                                "Si tu resultado sale en HTML, inténtalo de nuevo."
                            ];
                        foreach ($hintlist as $hint) {
                            echo "<div class='text-dark text-center'>{$hint}</div>";
                        }
                        if (null !== session('error') && is_array(session('error'))){
                            foreach (session('error') as $msg) {
                                echo "<div class='bg-danger2 text-center'>{$msg}</p>";
                            }
                        }
                    ?>
                </div><!-- warnings-->

                    <div>
                        <div class="wrapper2" id="startMenuDiv">
                            <form id="measurementform" method="post" action="/descargarfile">
                                    {{ csrf_field() }}
                               
                                <input type="radio" name="dl_option" value="ave"> Ave<br>
                                <input type="radio" name="dl_option" value="arbol"> Árbol<br>
                                <input type="radio" name="dl_option" value="arbusto"> Arbusto<br>
                                <input type="radio" name="dl_option" value="herpetofauna"> Herpetofauna<br>
                                <input type="radio" name="dl_option" value="hierba"> Hierba<br>
                                <input type="radio" name="dl_option" value="mamifero"> Mamífero<br>
                                <input type="submit" id="measurementlinea_mtpSubmit" class="mySubmit" value="Descargar">
                            </form>
                        </div ><!-- startMenuDiv-->
                    </div>
                </div>
            </div>
        </div><!-- container -->

        @include('inc/footer')
    </section><!-- section four-->
