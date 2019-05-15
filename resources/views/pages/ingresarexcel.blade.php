<?php
    if (!session('email')){
        return redirect()->to('/login')->send();
      }
    if (!session('readpp')){
      return redirect()->to('/privacidad')->send();
    }
      $useremail=json_encode(session('email'));
  
 

//   if ($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['descargarexcel'])) {
//     $myfile= "C:\\wamp64\\www\\lsapp3\\public\\storage\\ingresarexcel.xlsx";
//     if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
//       $myfile= "/var/www/html/lsapp3/public/storage/ingresarexcel.xlsx";
//     } 
//     if (file_exists($myfile)) {
// 		echo($myfile);
//       header('Content-Description: File Transfer');
//       header('Content-Disposition: attachment; filename=ingresarexcel.xlsx');
//       header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
// 	  header('Expires: 0');
// 	  header('Cache-Control: must-revalidate');
//       header('Content-Length: ' . filesize($myfile));
//       header('Content-Transfer-Encoding: binary');
//       header('Pragma: public');
//       readfile($myfile);
//       exit();
//     }
//   }
?>
  <script>
    var useremail = {!! $useremail !!};
  </script>
  @include('inc/php_functions')
  @include('inc/setuppage')
  @include('inc/savedata')
  @include('inc/checkexceldata')
  @include('inc/header')
  @include('inc/nav')

  <img src="{{ asset('img/popo.jpg') }}" alt="Italian Trulli" style="height:250px; width:380px;">
  <div class="warnings">
	<?php
	$hintlist = [
					"Si no hizo la observacion, ingrese 0000.",
					"Si hiciera observacion y no hubiera especies, ingrese 000.",
					"Si no sabe con certeza algún dato, ingrese 00.",
					"Todos los medidas son de 3 grados de precision. Por ejemplo 1.792.",
					"Todos las coordenadas son de 4 grados de precision. Por ejemplo -110.8170.",
					"No usa la palabra 'false'. Se puede usar 'falso' o 'no'.",
					"Solo 'notas' y 'iden_fotos' se puede dejar vacios.",
					"Hay que usar nombres de columnos exactos."
				];
				foreach ($hintlist as $hint) {
					echo "<p class='text-dark text-center'style='background-color: lightsteelblue;'>{$hint}</p>";
				}
      foreach (session('error') as $msg) {
        echo "<p class='bg-danger2 text-center'>{$msg}</p>";
      }
    ?>
  </div>

  <div class="wrapper2" id="startMenuDiv">
    <form id="measurementform" method="post" , action="/dlexample">
      {{ csrf_field() }}
      <input type="submit" id="excelSubmit" name="descargarexcel" class="border border-secondary btn btn-success mySubmit p-2 m-2"
        value="Descargar Excel Ejemplo">
    </form>
  </div>

  <div class="wrapper2" id="startMenuDiv">
    <h3 id="measurement3">Eligir Linea_MTP</h3>
    <form id="measurementform" method="post" , enctype="multipart/form-data">
      {{ csrf_field() }}
      <table class="mytable">
        <tbody id="measurementTBodySelect">
        </tbody>
      </table>
      <table class="mytable">
        <tbody id="measurementTBodyMedicion">
        </tbody>
      </table>
      <label for="excelFromUser" class="dropDownTitles">Excel (.xls)</label>
      <input type="file" name="excelFromUser" id="excelFromUser">
      <br>
      <label for="photosFromUser" class="dropDownTitles">Fotos</label>
      <input type="file" name="photosFromUser[]" id="photosFromUser" multiple>
      <br>
      <input type="submit" name="ingresarexcel" id="excelSubmit" class="border border-secondary btn btn-success mySubmit p-2 m-2" value="Enviar">
    </form>
  </div>


  <script src="{{ asset('js/jsfunc.js') }}"></script>
  @include('inc/footer')