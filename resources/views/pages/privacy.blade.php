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

  <div id='pptext'>
    <h3 id='privacyHeader'>Política de Privacidad  </h3>
    <p>
      La Subdelegación de Planeación y Fomento Sectorial, perteneciente a la Delegación Puebla de la Secretaría de Medio Ambiente y Recursos Naturales, 
      ubicada en Avenida 3 poniente, Numero 2926, Colonia La Paz, Código Postal 72160, Puebla, tiene entre otras funciones evaluar el impacto de las políticas 
      de protección al ambiente, conservación, restauración y aprovechamiento sustentable de los recursos naturales; así como coordinar la instrumentación de los 
      procedimientos y sistemas informáticos que faciliten, unifiquen y hagan eficiente los procesos de planeación.
    </p>
    <p>
      Es por ello que desde 2018 se ha generado, en colaboración con múltiples actores de los sectores social, académico y gubernamental, la plataforma 
      para el Monitoreo Integrado de los Paisajes Sostenibles, iniciativa que busca <strong> unificar métodos de monitoreo, datos preexistentes e información 
      cartográfica base </strong>, para generar información en tres niveles (predio, ecosistema y paisaje), <strong>con el objetivo de que los datos
      recabados</strong> (a cualquier nivel)<strong> sean compatibles y comparables entre sí, pero además, se puedan vincular a bases de datos
      nacionales preexistentes </strong> (INFyS, SARMOD, SACMOD), facilitando su análisis y <strong>conduciendo a una mejor gestión 
      territorial</strong> en favor del aprovechamiento sustentable de los recursos naturales.
    </p>
    <p>
        En cumplimiento de la Ley General de Protección de Datos Personales en posesión de Sujetos Obligados y la Ley Federal de Datos 
        Personales en Posesión de Particulares, vigentes, se informa que los datos personales que recabamos de usted, son utilizados para las siguientes finalidades:
    </p>
    <p>
        Primarias:
      -Análisis de la información proporcionada para el cálculo de índices de diversidad.
      -Registro de las especies [flora y fauna] existentes en las diversas unidades de paisaje bajo estudio.
      -Cotejo con los listados de biodiversidad preexistentes
      -Elaboración de estadísticas.
      Secundarias:
       -Construcción de una base de datos de colaboradores.
    </p>
    <p>
      El objetivo de la plataforma para el Monitoreo Integrado de los Paisajes Sostenibles en la recogida de información de identificación personal es 
      vincular los datos reportados a usuarios específicos, es necesario aclarar que la información a continuación descrita <strong>no se divulga, ni 
      comparte</strong> con terceros, las únicas excepciones son los programadores del sitio.
    </p>
    <p>
      Para llevar a cabo las finalidades descritas en el presente aviso de privacidad, utilizaremos los siguientes datos 
      personales: nombre completo y correo electrónico particulares.
    </p>
    <p>
      En caso de que no desee que sus datos personales sean tratados para estos fines deberá presentar la solicitud respectiva en el área de contacto de este sitio.
    </p>
    <p> 
      <strong>Usted tiene derecho a conocer qué datos personales tenemos de usted</strong>, para qué los utilizamos y las condiciones del uso que les damos (Acceso). Asimismo, es su derecho <strong>solicitar la corrección de su información personal</strong> en caso de que esté desactualizada, sea inexacta o incompleta (Rectificación); <strong>que la eliminemos de nuestros registros</strong> o bases de datos cuando considere que la misma no está siendo utilizada conforme a los principios, deberes y obligaciones previstas en la normativa (Cancelación); <strong>así como oponerse al uso de sus datos personales para fines específicos</strong> (Oposición). Estos derechos se conocen como derechos ARCO. 
    </p>
    <p> 
      Para el ejercicio de cualquiera de los derechos ARCO, usted deberá presentar la solicitud respectiva en el área de contacto de este sitio.
    </p>
    <p> 
      El presente aviso de privacidad puede sufrir modificaciones, cambios o actualizaciones derivadas de nuevos requerimientos legales; de nuestras propias necesidades; de nuestras prácticas de privacidad o por otras causas. Nos comprometemos a mantenerlo informado sobre los cambios que pueda sufrir el presente aviso de privacidad, a través de este mismo medio.
    </p>
    <p> 
      Si usted considera que su derecho a la protección de sus datos personales ha sido lesionado por alguna conducta u omisión de nuestra parte, o presume alguna violación a las disposiciones previstas en la Ley Federal de Protección de Datos Personales en Posesión de los Particulares, su Reglamento y demás ordenamientos aplicables, podrá revisar los procedimientos de actuación correspondientes indicados por el Instituto Nacional de Transparencia, Acceso a la Información y Protección de Datos Personales (INAI) en la siguiente liga <a href='www.inai.org.mx'>www.inai.org.mx<a/>.
    </p>
    <p>
      Si usted ha leído el presente aviso de privacidad y protección de datos y está de acuerdo con los términos le suplicamos acepte en el siguiente recuadro.
    </p>      
    <p>  
    *El presente aviso de Privacidad y Protección de Datos fue elaborado el [20 de febrero del 2019] y sufrió la última actualización el [26 de febrero del 2019].
    </p>

  </div>


    <div class="wrapper2" id="startMenuDiv">
    <form id="measurementform" method="post">
      {{ csrf_field() }}
      <input id='agreeCheckBox' type="checkbox" name="agree" value="1">   Otorgo mi consentimiento para que mis datos personales sean tratados conforme a lo señalado en el presente aviso de privacidad. <br>
      <br>
      <input type="submit" id="measurementlinea_mtpSubmit" class="mySubmit" value="Enviar">

    </form>
</div >

@include('inc/footer')    
