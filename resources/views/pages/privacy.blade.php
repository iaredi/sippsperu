@include('inc/php_functions')
<?php 

if ($_SERVER['REQUEST_METHOD']=="POST"){
  if (isset($_POST['agree'])){
    $sql = "update usuario set readpp='true' where email=?";
    $result = DB::update($sql, [session('email')]);
    session(['readpp' => 1]);
    return redirect()->to('/mostrarmapas')->send();
  }
}
?>
@include('inc/header')
@include('inc/nav')
<div class='bodycontainer' id="main">
    <section class="three">
        <div class="container">
            <div id='pptext'>
                <h3 id='privacyHeader'>Política de Privacidad  </h3>
                <br />
                <p>Se ha generado, en colaboración con múltiples actores de los sectores social, académico y gubernamental, el Sistema Integral para la Planeación de los Paisajes Sostenibles, iniciativa que busca unificar métodos de monitoreo, datos pre existentes de información cartográfica base (de acceso abierto), para generar información en tres niveles (predio, ecosistema y paisaje), con el objetivo de que los datos recabados (a cualquier nivel) sean compatibles y comparables entre sí, pero además, se puedan vincular a bases de datos nacionales preexistentes, facilitando su análisis y conduciendo a una mejor gestión territorial en favor del aprovechamiento sustentable de los recursos naturales.</p><br />
                <p>Se informa que los datos personales recabados de usted, son utilizados para las siguientes finalidades:</p>
                <br />
                <h4>Primarias:</h4>
                <p>
                    <ul>
                        <li>Análisis de la información proporcionada para el cálculo de índices de diversidad.</li>
                        <li>Registro de las especies [flora y fauna] existentes en las diversas unidades de paisaje bajo estudio.</li>
                        <li>Cotejo con los listados de biodiversidad.</li>
                        <li>Elaboración de estadísticas.</li>
                    </ul>
                </p>
                <br />
                <h4>Secundarias:</h4>
                <p>Construcción de una base de datos de colaboradores. El objetivo del Sistema en la recogida de información de identificación personal es vincular los datos reportados a usuarios específicos, es necesario aclarar que esta información no se divulga ni se comparte con terceros, las únicas excepciones son los programadores del sitio.</p><br />
                <p>Para llevar a cabo las finalidades descritas en el presente aviso de privacidad, utilizaremos los siguientes datos personales: nombre completo y correo electrónico. En caso de que no desee que sus datos personales sean tratados para estos fines, deberá presentar la solicitud respectiva en el correo de contacto de este sitio (sipps.peru@gmail.com). Usted tiene derecho a conocer qué datos personales tenemos de usted, para qué los utilizamos y las condiciones del uso que les damos (Acceso). Asimismo, es su derecho solicitar la corrección de su información personal en caso de que esté desactualizada, sea inexacta o incompleta (Rectificación); que la eliminemos de nuestros registros o bases de datos cuando considere que la misma no está siendo utilizada conforme a los principios, deberes y obligaciones previstas en la normativa (Cancelación); así como oponerse al uso de sus datos personales para fines específicos (Oposición). Estos derechos se conocen como derechos ARCO. Para el ejercicio de cualquiera de los derechos ARCO, usted deberá presentar la solicitud respectiva en el correo de contacto de este sitio (sipps.peru@gmail.com).</p><br />
                <p>El presente aviso de privacidad puede sufrir modificaciones, cambios o actualizaciones derivadas de nuevos requerimientos legales; de nuestras propias necesidades; de nuestras prácticas de privacidad o por otras causas. Nos comprometemos a mantenerlo informado sobre los cambios que pueda sufrir el presente aviso de privacidad, a través de este mismo medio. Si usted ha leído el presente aviso de privacidad y protección de datos y está de acuerdo con los términos le suplicamos acepte en el siguiente recuadro.</p><br />
                <p>*El presente aviso de Privacidad y Protección de Datos fue elaborado el [12 de Agosto del 2021] y no ha tenido actualizaciones.</p>
            </div>


            <div class="wrapper2" id="startMenuDiv">
                <form id="measurementform" method="post">
                    {{ csrf_field() }}
                    <input id='agreeCheckBox' type="checkbox" name="agree" value="1">   Otorgo mi consentimiento para que mis datos personales sean tratados conforme a lo señalado en el presente aviso de privacidad. <br>
                    <br>
                    <input type="submit" id="measurementlinea_mtpSubmit" class="boton mySubmit" value="Enviar">

                </form>
            </div >
        </div><!-- container-->
        @include('inc/footer')    
    </section><!-- section three-->