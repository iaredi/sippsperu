<?php
    if (!session('email')){
        return redirect()->to('/login')->send();
    }
    $useremail=json_encode(session('email'));
?>
<script>
  var useremail = {!! $useremail !!};
</script>
@include('inc/php_functions')
@include('inc/setuppage')
@include('inc/checkexceldata')
@include('inc/header')
@include('inc/nav')

<img src="{{ asset('img/popo.jpg') }}"  alt="Italian Trulli" style="height:250px; width:380px;">
  <div class = "warnings">
    <?php
      foreach (session('error') as $msg) {
        echo "<p class='bg-danger2 text-center'>{$msg}</p>";
      }
    ?>
</div>
<div class="wrapper2" id="startMenuDiv">
  <h3 id="measurement3">Eligir Linea_MTP</h3>
  <form id="measurementform" method="post", enctype="multipart/form-data">
    {{ csrf_field() }}
    <table class="mytable" >
      <tbody id="measurementTBodySelect">
      </tbody>
    </table>
    <table class="mytable">
      <tbody id="measurementTBodyMedicion">
      </tbody>
    </table>
    <label for="excelFromUser" class="dropDownTitles">Excel (.xls)</label>
    <input type="file" name="excelFromUser" id="excelFromUser" >
    <br>
    <label for="photosFromUser" class="dropDownTitles" >Fotos</label>
    <input type="file" name="photosFromUser" id="photosFromUser" multiple>
    <br>
    <input type="submit" id="excelSubmit" class="border border-secondary btn btn-success mySubmit p-2 m-2" value="Enviar">
  </form>
</div >
<script src="{{ asset('js/jsfunc.js') }}" ></script>
@include('inc/footer')


