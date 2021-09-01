@include('inc/header')
@include('inc/nav')
<div class='bodycontainer' id="main">
    <section class="two">
        <div class="container">
            <header><h2>Sus datos se han guardado con &eacute;xito.</h2></header>
            <h3>&iexcl;Gracias!</h3>
            <br><br><br><br><br>

            <?php
            if(session('okButWithComments')){
                echo'<div class="warningMsg">';
                $errors=session('okButWithComments');
                foreach($errors as $error){
                    echo "<div>{$error}</div>";
                }
                echo '</div>';
            }
            ?>
        </div>
        @include('inc/footer')
    </section>
    
    
    <?php
        session(['resultofquery' => []]);
        session(['adminerror' => []]);
    ?>