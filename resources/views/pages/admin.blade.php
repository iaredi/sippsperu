<?php 
	if (!session('admin')){
		return redirect()->to('/login')->send();
	}
	$allcolumns=[];
	$addcolumnssql = "SELECT tablename, displayname FROM additional_layers WHERE tablename!='suelo_geometries_simplified'";
	$addcolumns = DB::select($addcolumnssql,[]);
	foreach ($addcolumns as $table) {
		$tablename=$table->tablename;
		$displayname=$table->displayname;
		$featurecolumnsql = "SELECT column_name FROM information_schema.columns WHERE table_name=?";
		$allcolumns[$displayname]=DB::select($featurecolumnsql,[strtolower($tablename)]);
	}
	$allcolumns['Uso de Suelo'] =[['column_name'=>'descripcio']];
	
	
	$geojson=json_encode($allcolumns);
	
	?>
<script>
	var allcolumns = {!! $geojson !!};
</script>
@include('inc/saveadmin')
@include('inc/setuppage')
@include('inc/header')
@include('inc/nav')

<div class='bodycontainer' id="main">
    <section class="four">
        <div class="container">
            <header>
                <h2>Admin</h2>
            </header>
            <div>
                <?php 
                $msgClass=session('msgType');
                if ($_SERVER['REQUEST_METHOD']=='POST' && (session('msgType')=='okMsg' || session('msgType')=='warningMsg')) {
                    $index=count(session('adminerror'));
                    $msg=session('adminerror')[$index-1];
                   echo "<div class='okMsg'>{$msg}</div>";
                }
                if(session('adminerror') && (session('msgType')=='warningMsg' || session('msgType')=='errorMsg')){
                    echo "<div class='$msgClass'>";
                    foreach(session('adminerror') as $error){
                        echo "<div>$error</div>";
                    }
                    echo '</div>';
                }
                session(['adminerror'=>'']);
                session(['msgType'=>'']);
                ?>
            </div>
        </div>
    </section>
    <!--<div class="wrapper2" id="startMenuDiv">-->
        <section class="two">
            <div class="container">
                <form id="measurementform" method="post">
                    {{ csrf_field() }}
                    <h3 id="measurement3">Cambiar Usuario Activo</h3><br />
                    <table class="mytable">
                        <tbody id="measurementTBodySelect"></tbody>
                    </table>
                    <div class="leftAlign">
                        <input type="radio" name="admin_option" value="add_admin"> Dar Privilegio Admin<br>
                        <input type="radio" name="admin_option" value="remove_admin"> Borrar Privilegio Admin<br>
                        <input type="radio" name="admin_option" value="cambio"> Permitir cambio de contraseña (el código del usuario es su email)<br>
                        <input type="radio" name="admin_option" value="delete_user"> Borrar Ususario
                        <input type="hidden" name="action" value="activo"><br>
                        <input type="submit" id="measurementlinea_mtpSubmit" class="boton mySubmit" value="Guardar">
                    <div>
                </form>
            </div>
        </section>
        <section class="three">
            <div class="container">
                <form id="measurementform" method="post">
                    {{ csrf_field() }}
                    <h3 id="measurement3">Cambiar Emails Permitidos</h3><br />
                    <table class="mytable">
                        <tbody id="measurementTBodyMedicion"></tbody>
                    </table>
                    <div class="leftAlign">
                        <input type="radio" name="admin_option" value="remove_email"> Borrar Email <br>
                        <input type="radio" name="admin_option" value="add_email"> Añadir Email Nuevo
                        <input type="text" name="email_input">
                        <input type="checkbox" name="visitante" value="1"> *Visitante<br>
                        <input type="hidden" name="action" value="permitido">
                        <input type="submit" id="measurementlinea_mtpSubmit" class="boton mySubmit" value="Guardar">
                    </div>
                </form>
            </div>
        </section>
        <section class="four">
            <div class="container">
                <form id="measurementform" method="post">
                    {{ csrf_field() }}
                    <h3 id="measurement3">Borrar Medici&oacute;n</h3><br />
                    <table class="mytable">
                        <tbody id="measurementTBodyborrarmedicion"></tbody>
                    </table>
                    <div class="divFormulario">
                        <span class='dropDownTitles' style="white-space:nowrap; padding-right: 157px;">Tipo</span>
                        <select id='borrar_forma_de_vida' name='borrar_forma_de_vida' class='narrowSelect'>
                            <option value="not_selected"></option>
                            <option value="medicion_completa">medicion completa</option>
                            <option value="ave">ave</option>
                            <option value="arbol">arbol</option>
                            <option value="arbusto">arbusto</option>
                            <option value="heirba">heirba</option>
                            <option value="mamifero">mamifero</option>
                            <option value="herpetofauna">herpetofauna</option>
                        </select>
                    </div>
                    <input type="hidden" name="action" value="borrarmedicion">
                    <input type="submit" value= 'Borrar' id="measurementlinea_mtpSubmit" class="boton mySubmit" value="Guardar">
                </form>
            </div>
        </section>
        <section class="two">
            <div class="container">
                <form id="measurementform" method="post">
                    {{ csrf_field() }}
                    <h3 id="measurement3">Cambiar Especie</h3><br />
                    <div class="divFormulario">
                        <label class='dropDownTitles' style="white-space:nowrap">Tipo</label><!-- it was span instead of label -->
                        <select id='cambiar_especie' name='cambiar_especie' ><!-- class="narrowSelect" -->
                            <option value="not_selected"></option>
                            <option value="especie_ave">ave</option>
                            <option value="especie_arbol">arbol</option>
                            <option value="especie_arbusto">arbusto</option>
                            <option value="especie_heirba">heirba</option>
                            <option value="especie_mamifero">mamifero</option>
                            <option value="especie_herpetofauna">herpetofauna</option>
                        </select>
                    </div>
                    <input type="hidden" name="action" value="cambiar_especie">
                    <input type="submit" value= 'Cambiar especie' class="boton mySubmit">
                </form>
            </div>
        </section>
        <section class="three">
            <div class="container">
                <form id="measurementform" method="post">
                    {{ csrf_field() }}
                    <h3 id="measurement3">Borrar Campo</h3>
                    <div class="divFormulario">
                        <label for="table_option">Elegir Tabla</label>
                        <select name='table_option' id='table_option' class=''>
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
                    </div>
                    <div class="divFormulario">
                        <label for="field_option">Elegir Campo</label>
                        <select name='field_option' id='field_option' class=''></select>
                        <input type="hidden" name="action" value="delete_field"><br>
                        <input type="submit" id="deletecampo" class="boton mySubmit" value="Borrar">
                    </div><!-- row -->
                </form>
            </div>
        </section>
        <section class="four">
            <div class="container">
                <form id="measurementform" method="post">
                    {{ csrf_field() }}
                    <h3 id="measurement3">Guardar Campo</h3><br />
                    <div class="divFormulario">
                        <label>Nombre del campo</label>
                        <input type="text" name="field_input" placeholder="Nombre del Campo">
                    </div>
                    <div class="divFormulario">
                        <label for="table_option2">Elegir Tabla</label>
                        <select name='table_option2' id='table_option2' class=''>
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
                    </div>
                    <div class="divFormulario">
                        <label for="datatype">Elegir Tipo de Datos</label>
                        <select name='datatype' id='datatype' class=''>
                            <option value="not_selected"></option>
                            <option value="varchar">varchar</option>
                        </select>
                    </div>
                    <input type="hidden" name="action" value="add_field"><br>
                    <input type="submit" id="campo" class="mySubmit boton" value="Guardar">
                    
                </form>
            </div>
        </section>
        <section class="two">
            <div class="container">
                <form id="measurementform" method="post">
                    {{ csrf_field() }}
                    <h3 id="measurement3">Cambiar Capas</h3><br />
                    <table class="mytable">
                        <tbody id="measurementTBodycargar"></tbody>
                    </table>
                    <input type="checkbox" name="deletetable" value="1"> Borrar completamente<br>
                    <div class="divFormulario">
                        <label for="displayname">Nombre para Mostrar</label>
                        <input type="text" required name="displayname" id="displayname">
                    </div>
                    <div class="divFormulario">
                        <label for="campoclick">Campo Click</label>
                        <select required name="campoclick" id="campoclick"></select>
                    </div>
                    <div class="divFormulario">
                        <label for="fillcolor">Fill Color</label>
                        <input type="color" required name="fillcolor" id="fillcolor">
                    </div>
                    <div class="divFormulario">
                        <label for="lineacolor">Linea Color</label>
                        <input type="color" required name="lineacolor" id="lineacolor">
                    </div>
                    <div class="divFormulario">
                        <label for="fillopacidad">Fill Opacidad</label>
                        <input type="number" min=0 max=1 step=0 .1 required name="fillopacidad" id="fillopacidad">
                    </div>
                    <div class="divFormulario">
                        <label for="lineaopacidad" >Linea Opacidad</label>
                        <input type="number" min=0 max=1 step=0 .1 required name="lineaopacidad" id="lineaopacidad">
                    </div>
                    <div class="divFormulario">
                        <label for="lineaanchura" >Linea Anchura</label>
                        <input type="number" min=0 max=5 step=0 .1 required name="lineaanchura" id="lineaanchura">
                    </div>
                    <div class="divFormulario">
                        <label for="category" >Category</label>
                        <select id ='category' name ='category'>
                            <option value="Referencial">Referencial</option>
                            <option value="Monitoreo Activo">Monitoreo Activo</option>
                            <option value="Gestion del Territorio">Gestion del Territorio</option>
                        </select>
                    </div>
                    <br>
                    <input type="hidden" name="action" value="cargarshape">
                    <a class="button" href="/cargarshapesadmin" role="button">Cargar pol&iacute;gono</a>
                    <input type="submit" id="measurementlinea_mtpSubmit" class="boton mySubmit" value="Guardar">
                </form>
            </div>
        </section>
        <!--</div><!-- startMenuDiv -->
        <section class="four">
            <div class="container">
            <h3 id="measurement3">Especies en Registros Previos</h3>
            <p><b>ADVERTENCIA</b>: Al cargar un nuevo archivo se sustituir&aacute; la lista de <i>Especies en Registros Previos</i> actual.</p>
            <div>
            <form id="measurementform" method="post" , action="/dlexample">
                <div class="row">
                    <div class="col-12">
                        <input type="submit" id="excelSubmit" name="descargarexcelRP" value="Descargar Excel Ejemplo" class="botoncito">
                    </div>
                    {{ csrf_field() }}
                </div>
            </form>
            <form id="measurementform" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="col-6 col-12-mobile">
                        <label for="excelFromUser" class="dropDownTitles">Excel (.xls)</label>
                        <input type="file" name="excelFromUser" id="excelFromUser" placeholder="Excel (.xls)">
                        <input type="hidden" name="action" value="guardarRegistrosPrevios">
                    </div>
                    <div class="col-12">
                        <input type="submit" name="ingresarexcel" id="espRegistroPrevioSubmit" value="Guardar">
                    </div>
                </form>
            </div>
        </section>
        <section class="two">
            <div class="container">
            <h3 id="measurement3">Especies en Peligro de Extinci&oacute;n</h3>
            <p><b>ADVERTENCIA</b>: Al cargar un nuevo archivo se sustituir&aacute; la lista de <i>Especies en Peligro de Extinci&oacute;n</i> actual.</p>
            <div>
            <form id="measurementform" method="post" , action="/dlexample">
                <div class="row">
                    <div class="col-12">
                        <input type="submit" id="excelSubmit" name="descargarexcelEP" value="Descargar Excel Ejemplo" class="botoncito">
                    </div>
                    {{ csrf_field() }}
                </div>
            </form>
            <form id="measurementform" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="col-6 col-12-mobile">
                        <label for="excelFromUser" class="dropDownTitles">Excel (.xls)</label>
                        <input type="file" name="excelFromUser" id="excelFromUser" placeholder="Excel (.xls)">
                        <input type="hidden" name="action" value="guardarEspeciesPeligro">
                    </div>
                    <div class="col-12">
                        <input type="submit" name="ingresarexcel" id="espPeligroExtincionSubmit" value="Guardar">
                    </div>
                </form>
            </div>
        </section>
        

    <script src="{{ asset('js/jsfunc.js') }}"></script>
    <script>
        var mySelection = document.getElementById('measurementadditional_layerscargar')
        mySelection.addEventListener("change", function (){
            var tableName = mySelection.value
            if (tableName=='notselected') return
            let frag = document.createDocumentFragment(),elOption;
            for (let i = 0; i<allcolumns[tableName].length; i++){
                elOption = frag.appendChild(document.createElement('option'));
                elOption.value = allcolumns[tableName][i]['column_name'];
                elOption.innerHTML = allcolumns[tableName][i]['column_name'];
            }
            var campoClick = document.getElementById('campoclick')
            while (campoClick.hasChildNodes()) {
                campoClick.removeChild(campoClick.lastChild);
            }
            campoClick.appendChild(frag)
        })
    </script>

@include('inc/footer')