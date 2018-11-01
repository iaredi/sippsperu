/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 145);
/******/ })
/************************************************************************/
/******/ ({

/***/ 145:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(146);


/***/ }),

/***/ 146:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


function buildDropdowns(tableName, menu) {
    var jsTable = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : "Form";

    if (!menu) {
        menu = 'measurement';
    }
    var myTBody = document.getElementById(menu + "TBody" + jsTable);

    var selectList = document.createElement("select");
    selectList.id = menu + tableName + jsTable;
    selectList.name = "select" + tableName;
    selectList.className = 'form-control';
    var newTR = document.createElement("tr");
    newTR.id = "row" + tableName;
    // const dataName = document.createElement("td");
    // dataName.textContent=tableName;
    // dataName.className="dropDownTitles";

    ////
    var dataLabel = document.createElement("LABEL");
    dataLabel.setAttribute("for", menu + tableName + jsTable);
    var lowerCaseTitle = tableName.split("_").join(" ");
    dataLabel.textContent = lowerCaseTitle.charAt(0).toUpperCase() + lowerCaseTitle.slice(1);
    dataLabel.className = "dropDownTitles";
    //////

    var dataSelect = document.createElement("td");
    dataSelect.appendChild(selectList);

    //newTR.appendChild(dataName);
    newTR.appendChild(dataLabel);
    newTR.appendChild(dataSelect);

    if (jsTable === "Form") {

        var myCols = tabletoColumns[tableName];
        var newColRows = createRows(tableName, menu, myCols, 0);
        var spacer1 = document.createElement("td");
        spacer1.innerHTML = "&nbsp;";
        var spacer2 = document.createElement("td");
        spacer2.innerHTML = "&nbsp;";
        var spacer3 = document.createElement("td");
        spacer3.innerHTML = "&nbsp;";
        var spacer4 = document.createElement("td");
        spacer4.innerHTML = "&nbsp;";
        newColRows[0].prepend(spacer1);
        newColRows[0].prepend(spacer2);
        newColRows[1].prepend(spacer3);
        newColRows[1].prepend(spacer4);

        var spacerTR1 = document.createElement("tr");
        spacerTR1.className = "myspacer";
        for (var i = 0; i < 9; i++) {
            spacerTR1.appendChild(spacer1.cloneNode(true));
        }
        var spacerTR2 = document.createElement("tr");
        spacerTR2.appendChild(spacer1.cloneNode(true));

        newColRows[1].id = tableName + "inputrow";
        newColRows[0].id = tableName + "columnsrow";
        newColRows[1].className = newColRows[1].className + " hiddenrows";
        newColRows[0].className = newColRows[0].className + " hiddenrows";

        myTBody.prepend(spacerTR2);
        myTBody.prepend(spacerTR1);
        myTBody.prepend(newColRows[1]);
        myTBody.prepend(newColRows[0]);
        myTBody.prepend(newTR);
    } else {
        var spacerTR = document.createElement("tr");
        spacerTR.id = "spacer" + tableName;
        var _spacer = document.createElement("td");
        _spacer.innerHTML = "&nbsp;";
        spacerTR.appendChild(_spacer);
        myTBody.prepend(spacerTR);
        myTBody.prepend(newTR);
    }
}

//////////////////////////////////////////////////////////////////////////////////////                

function selectOptionsCreate(tableName, menu) {
    var preApproved = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : true;
    var jsTable = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : "Form";
    var approvedList = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : [];
    var withRows = arguments.length > 5 && arguments[5] !== undefined ? arguments[5] : false;
    var withNuevo = arguments.length > 6 && arguments[6] !== undefined ? arguments[6] : true;

    var myId = withRows ? "row" + numRows + tableName + "Form" : menu + tableName + jsTable;
    if (tableName === "observaciones") myId = "measurementobservacionesObservaciones";
    if (tableName === "medicion") myId = "measurementmedicionMedicion";
    if (tableName === "linea_mtp") myId = "measurementlinea_mtpSelect";

    if (!!document.getElementById(myId)) {
        "row" + numRows + tableName + "Form";
        var mySelection = document.getElementById(myId);
        if (tableName.split('_')[0] === "observacion") tableName = tableName.replace("observacion", "especie");
        var mycurrentlist = completetitlevallist[tableName];
        var frag = document.createDocumentFragment(),
            elOption = void 0;
        elOption = frag.appendChild(document.createElement('option'));
        elOption.value = "notselected";
        elOption.innerHTML = " ";
        if (withNuevo) {
            elOption = frag.appendChild(document.createElement('option'));
            elOption.value = "Nuevo";
            elOption.innerHTML = "Nuevo";
        }

        if (preApproved === false) {
            for (var i = 0; i < approvedList[tableName].length; i++) {
                elOption = frag.appendChild(document.createElement('option'));
                elOption.value = mycurrentlist[approvedList[tableName][i]];
                elOption.innerHTML = mycurrentlist[approvedList[tableName][i]];
            }
        } else {
            for (var _i = 0; _i < mycurrentlist.length; _i++) {
                elOption = frag.appendChild(document.createElement('option'));
                elOption.value = mycurrentlist[_i];
                elOption.innerHTML = mycurrentlist[_i];
            }
        }
        while (mySelection.hasChildNodes()) {
            mySelection.removeChild(mySelection.lastChild);
        }
        mySelection.appendChild(frag);
    }
}

//////////////////////////////////////////////////////////////////////////////////////        

function clearForm(menu, jsTable) {
    if (!menu) {
        menu = 'measurement';
    }
    var myTBody = document.getElementById(menu + "TBody" + jsTable);
    if (!!myTBody) {
        while (myTBody.hasChildNodes()) {
            myTBody.removeChild(myTBody.lastChild);
        }
    }
}

//////////////////////////////////////////////////////////////////////////////////////      

function addOnChangeMTP(tableName, menu) {
    var currentFunction = function currentFunction(tableName, menu) {
        var myChoice = document.getElementById(menu + tableName + "Select").value;
        clearForm(menu, "Form");
        if (myChoice == "Nuevo") {
            clearForm(menu, "Medicion");
            clearForm(menu, "Observaciones");
            clearForm(menu, "Numero");
            clearForm(menu, "Form");
            buildForm("linea_mtp", menu, "Coordenadas de Linea");
            var newMTPdropdowns = ["predio", "municipio", "estado"];
            newMTPdropdowns.forEach(function (newTable) {
                buildDropdowns(newTable, menu, "Form");
                selectOptionsCreate(newTable, menu);
                addOnChangeFKey(newTable, menu);
            });
        } else {
            //This is when an old linea_mtp is selected
            clearForm(menu, "Observaciones");
            clearForm(menu, "Medicion");
            buildDropdowns("medicion", menu, "Medicion");
            selectOptionsCreate("medicion", menu);
            addOnChangeMedicion('medicion', menu);
        }
    };
    var currentOnChange = function currentOnChange() {
        currentFunction(tableName, menu);
    };

    var getSelection = document.getElementById(menu + tableName + "Select");
    getSelection.onchange = currentOnChange;
}

//////////////////////////////////////////////////////////////////////////////////////          

function addOnChangeFKey(tableName, menu) {
    var getSelection = document.getElementById(menu + tableName + "Form");
    var currentFunction3 = function currentFunction3(tableName, menu) {
        var myChoice = getSelection.value;
        var inputRow = document.getElementById(tableName + "inputrow");
        var colRow = document.getElementById(tableName + "columnsrow");
        if (myChoice === "Nuevo") {
            colRow.classList.remove("hiddenrows");
            inputRow.classList.remove("hiddenrows");
        } else {
            colRow.classList.add("hiddenrows");
            inputRow.classList.add("hiddenrows");
        }
    };
    var currentOnChange3 = function currentOnChange3() {
        currentFunction3(tableName, menu);
    };
    getSelection.onchange = currentOnChange3;
}

//////////////////////////////////////////////////////////////////////////////////////       
function addOnChangeMedicion(tableName, menu) {
    var getSelection = document.getElementById(menu + tableName + "Medicion");
    var currentFunctionMedicion = function currentFunctionMedicion(tableName, menu) {
        var myChoice = document.getElementById(menu + tableName + "Medicion").value;
        if (myChoice === "Nuevo") {
            clearForm(menu, "Observaciones");
            clearForm(menu, "Numero");
            clearForm(menu, "Form");
            buildForm("medicion", menu);
            buildForm("personas", menu, "Brigada");
            buildForm("gps", menu, "GPS", true);
            buildForm("camara", menu, "Camara", true);
        } else {
            clearForm(menu, "Observaciones");
            clearForm(menu, "Numero");
            clearForm(menu, "Form");
            buildDropdowns("observaciones", menu, "Observaciones");
            selectOptionsCreate("observaciones", menu, true, "Form", [], false, false);
            addOnChangeObservaciones(menu);
        }
    };
    var currentOnChangeMedicion = function currentOnChangeMedicion() {
        currentFunctionMedicion(tableName, menu);
    };
    getSelection.onchange = currentOnChangeMedicion;
}

//////////////////////////////////////////////////////////////////////////////////////         

function createRows(tableName, menu, myCols, myNumRow) {
    var obs = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : false;
    var customList = arguments.length > 5 && arguments[5] !== undefined ? arguments[5] : [];


    var speciesTable = [];
    var columnRowOld = document.createElement("tr");
    var firstDataRow = document.createElement("tr");
    firstDataRow.class = "dataRows";

    myCols.sort(function (a, b) {
        if (a < b) return -1;
        if (a > b) return 1;
        return 0;
    });
    myCols.sort(function (a, b) {
        if (a == 'notas') return 1;
        if (b == 'notas') return -1;
        if (a.indexOf('long') !== -1) return -1;
        if (b.indexOf('long') !== -1) return 1;
        if (a.indexOf('lat') !== -1) return -1;
        if (b.indexOf('lat') !== -1) return 1;
        if (a.indexOf('hora') !== -1) return -1;
        if (b.indexOf('hora') !== -1) return 1;
        if (a.indexOf('fecha') !== -1) return -1;
        if (b.indexOf('fecha') !== -1) return 1;
        if (a.length == 1) return 1;
        if (b.length == 1) return -1;
        if (a.length == 2) return 1;
        if (b.length == 2) return -1;
        return 0;
    });

    if (customList.length >= 1) myCols = customList;

    if (obs) {
        if (tableName == 'observacion_arbol' || tableName == 'observacion_arbusto') {
            var cuadranteLabel = document.createElement("td");
            cuadranteLabel.textContent = "Cuadrante";
            cuadranteLabel.className = "formcolumnlabels";
            var cuadranteBox = document.createElement("td");
            var cuadranteInput = document.createElement("INPUT");
            cuadranteInput.setAttribute("type", "text");
            cuadranteInput.name = "row" + myNumRow + '*' + tableName + '*cuadrante';
            cuadranteInput.id = "row" + myNumRow + "cuadrante";
            cuadranteInput.value = 1;
            cuadranteInput.className = "cuadranteinput";
            cuadranteBox.appendChild(cuadranteInput);
            cuadranteBox.className = "cuadrante";
            columnRowOld.appendChild(cuadranteLabel);
            firstDataRow.appendChild(cuadranteBox);
        }
        var _speciesTable = tableName.replace("observacion", "especie");
        //Species drop Label
        var speciesLabelDrop = document.createElement("td");
        speciesLabelDrop.innerText = _speciesTable;
        speciesLabelDrop.className = "formcolumnlabels";
        columnRowOld.appendChild(speciesLabelDrop);
        //Species drop 
        var speciesInput = document.createElement("SELECT");
        speciesInput.id = "row" + myNumRow + tableName + "Form"; //this needs to
        speciesInput.setAttribute("class", _speciesTable);
        speciesInput.classList.add('allinputs');
        speciesInput.classList.add('form-control');

        speciesInput.name = "row" + myNumRow + "*" + tableName + "*" + "species";
        var inputBox = document.createElement("td");
        inputBox.appendChild(speciesInput);
        firstDataRow.appendChild(inputBox);
        //Species comun Label
        var speciesLabelComun = document.createElement("td");
        speciesLabelComun.textContent = "Nuevo Nombre Comun";
        speciesLabelComun.className = "formcolumnlabels";
        columnRowOld.appendChild(speciesLabelComun);
        //Species cien Label
        var speciesLabelCien = document.createElement("td");
        speciesLabelCien.textContent = "Nuevo Nombre Cientifico";
        speciesLabelCien.className = "formcolumnlabels";
        columnRowOld.appendChild(speciesLabelCien);
        //Species comun inputbox
        var speciesBoxComun = document.createElement("INPUT");
        speciesBoxComun.setAttribute("type", "text");
        speciesBoxComun.classList.add("row" + myNumRow + "disableme");
        speciesBoxComun.classList.add('allinputs');
        speciesBoxComun.classList.add('form-control');

        speciesBoxComun.disabled = true;
        speciesBoxComun.name = "row" + myNumRow + "*" + tableName + "*" + "comun";
        var boxContainerComun = document.createElement("td");
        boxContainerComun.appendChild(speciesBoxComun);
        firstDataRow.appendChild(boxContainerComun);
        //Species cien inputbox
        var speciesBoxCien = document.createElement("INPUT");
        speciesBoxCien.setAttribute("type", "text");

        speciesBoxCien.classList.add("row" + myNumRow + "disableme");
        speciesBoxCien.classList.add('allinputs');
        speciesBoxCien.classList.add('form-control');

        speciesBoxCien.disabled = true;
        speciesBoxCien.name = "row" + myNumRow + "*" + tableName + "*" + "cientifico";
        var boxContainerCien = document.createElement("td");
        boxContainerCien.appendChild(speciesBoxCien);
        firstDataRow.appendChild(boxContainerCien);
    }
    myCols.forEach(function (val) {
        var found = false;
        if (typeof allPhp2[tableName]["fKeyCol"] !== "undefined") {
            found = !!allPhp2[tableName]["fKeyCol"].find(function (element) {
                return element == val;
            });
        }
        if (!val.includes("iden") && !found) {
            var nameBox = document.createElement("td");
            var spacedval = val.split("_").join(" ");
            nameBox.innerText = spacedval.charAt(0).toUpperCase() + spacedval.slice(1);
            nameBox.className = "formcolumnlabels";

            columnRowOld.appendChild(nameBox);
            columnRowOld.className = tableName + "columnrow";
            var textInput = document.createElement("INPUT");
            if (val.substring(0, 5).toLowerCase() == "fecha") {
                textInput.classList.add('fechainputs');

                textInput.setAttribute("type", "date");
            } else if (val.substring(0, 4).toLowerCase() === "hora") {
                textInput.classList.add('horainputs');
                textInput.setAttribute("type", "time");
            } else {
                textInput.setAttribute("type", "text");
            }
            textInput.id = tableName + val;
            textInput.classList.add(tableName + val);
            if (obs) {
                textInput.classList.add("row" + myNumRow + "*" + tableName);
            }
            textInput.classList.add('allinputs');
            textInput.classList.add('form-control');

            textInput.name = ("row" + myNumRow + "*" + tableName + "*" + val).toLowerCase();
            var _inputBox = document.createElement("td");
            _inputBox.appendChild(textInput);
            firstDataRow.className = tableName + "inputrow";
            if (val !== 'Foto') {
                firstDataRow.appendChild(_inputBox);
            }
        }
    });
    if (obs) {
        var fotoInput = document.createElement("INPUT");
        fotoInput.setAttribute("type", "file");
        fotoInput.name = ("row" + myNumRow + "*" + tableName + "*" + 'foto').toLowerCase();
        fotoInput.id = tableName + 'foto';
        var fotoInputBox = document.createElement("td");
        fotoInputBox.appendChild(fotoInput);

        firstDataRow.appendChild(fotoInputBox);
        return [columnRowOld, firstDataRow, speciesTable];
    }

    return [columnRowOld, firstDataRow, speciesTable];
}

//////////////////////////////////////////////////////////////////////////////////////          


function buildForm(tableName, menu, myTitle) {
    var spacers = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : false;
    var obs = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : false;
    var customList = arguments.length > 5 && arguments[5] !== undefined ? arguments[5] : [];
    var buttons = arguments.length > 6 && arguments[6] !== undefined ? arguments[6] : true;

    if (!menu) {
        menu = 'measurement';
    }
    var myTBody = document.getElementById(menu + "TBodyForm");
    var myCols = tabletoColumns[tableName];
    var spaceRow = document.createElement("tr");
    spaceRow.className = "formtitles";
    spaceRow.innerHTML = "<br> ";
    if (myTitle !== "none") spaceRow.innerHTML = myTitle;
    var buttonRow = document.createElement("tr");
    var mySubmit = document.createElement("INPUT");
    mySubmit.setAttribute("type", "submit");
    mySubmit.id = menu + tableName + "Submit";
    mySubmit.className = "mySubmit";
    if (document.getElementsByClassName("mySubmit").length > 0) mySubmit = document.getElementsByClassName("mySubmit")[0];
    var newRows = createRows(tableName, menu, myCols, 0, obs, customList);

    var addElementRow = document.createElement("BUTTON");
    addElementRow.setAttribute("type", "button");
    addElementRow.id = "addElementRow" + tableName;
    //addElementRow.className = "addElementRow";
    var subtractElementRow = document.createElement("BUTTON");
    subtractElementRow.setAttribute("type", "button");

    subtractElementRow.id = "subtractElementRow";
    addElementRow.innerText = "+";
    subtractElementRow.innerText = "-";

    addElementRow.onclick = function () {
        return addRow(myTBody, tableName, myCols, obs, customList);
    };
    subtractElementRow.onclick = function () {
        return subtractRow(myTBody, tableName);
    };
    var buttonBox = document.createElement("td");
    buttonBox.appendChild(addElementRow);
    buttonBox.appendChild(subtractElementRow);
    buttonRow.appendChild(buttonBox);

    var spacer1 = document.createElement("td");
    spacer1.innerHTML = "&nbsp;";

    var spacerTR1 = document.createElement("tr");
    spacerTR1.className = "myspacer";
    for (var i = 0; i < newRows[0].childElementCount; i++) {
        spacerTR1.appendChild(spacer1.cloneNode(true));
    }
    var spacerTR2 = document.createElement("tr");
    spacerTR2.appendChild(spacer1.cloneNode(true));

    var bottomSpacer = document.createElement("tr");
    bottomSpacer.id = tableName + "bottomspacer";
    bottomSpacer.appendChild(spacer1.cloneNode(true));

    if (tableName == 'medicion' || !buttons) {
        myTBody.appendChild(mySubmit);
        myTBody.insertBefore(newRows[0], mySubmit);
        myTBody.insertBefore(newRows[1], mySubmit);
        //myTBody.insertBefore(bottomSpacer, mySubmit);
    } else {

        if (spacers) {

            myTBody.appendChild(mySubmit);
            myTBody.insertBefore(spacerTR1, mySubmit);
            myTBody.insertBefore(spacerTR2, mySubmit);
            myTBody.insertBefore(spaceRow, mySubmit);
            myTBody.insertBefore(buttonRow, mySubmit);
            myTBody.insertBefore(newRows[0], mySubmit);
            myTBody.insertBefore(newRows[1], mySubmit);
            myTBody.insertBefore(bottomSpacer, mySubmit);
        } else {

            myTBody.appendChild(mySubmit);
            myTBody.insertBefore(spaceRow, mySubmit);
            myTBody.insertBefore(buttonRow, mySubmit);
            myTBody.insertBefore(newRows[0], mySubmit);
            myTBody.insertBefore(newRows[1], mySubmit);
            myTBody.insertBefore(bottomSpacer, mySubmit);
        }
    }

    if (obs) {
        selectOptionsCreate(tableName, menu, true, "Form", [], true);

        selectSpeciesOnChange(tableName, menu, 0);

        //selectOptionsCreate(tableName, menu, true, "Form",[], 0)
    }
}

//////////////////////////////////////////////////////////////////////////////////////          

function addRow(myTBody, tableName, myCols, obs) {
    var customList = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : [];

    var menu = 'selection';
    var bottomSpacer = document.getElementById(tableName + "bottomspacer");
    numRows++;
    var newRows = createRows(tableName, menu, myCols, numRows, obs, customList);
    newRows[1].class = "addedRow";
    newRows[1].id = "addedRow";
    myTBody.insertBefore(newRows[1], bottomSpacer);
    if (obs) {
        selectSpeciesOnChange(tableName, menu, numRows);
        selectOptionsCreate(tableName, menu, true, "Form", [], true);
    }
}
//////////////////////////////////////////////////////////////////////////////////////          

function subtractRow(myTBody, tableName) {
    myTBody.childNodes.forEach(function (val, index) {
        if (val.id == tableName + "bottomspacer") {
            var targetNode = myTBody.childNodes[index - 1];
            if (targetNode.id == "addedRow") {
                myTBody.removeChild(targetNode);
                numRows--;
            }
        }
    });
}

//////////////////////////////////////////////////////////////////////////////////////          

function addOnChangeObservaciones(menu) {
    var getSelection = document.getElementById("measurementobservacionesObservaciones");
    var currentFunction3 = function currentFunction3(tableName, menu) {
        var myChoice = 'observacion_' + document.getElementById("measurementobservacionesObservaciones").value;
        numRows = 0;
        clearForm(menu, "Numero");
        clearForm(menu, "Form");
        if (myChoice !== 'notselected') {
            var numberPoints = 4;
            var transpunto = 'Transecto';
            if (myChoice == "observacion_ave" || myChoice == "observacion_mamifero") {
                transpunto = 'Punto';
                numberPoints = 5;
            }
            if (myChoice == "observacion_arbol" || myChoice == "observacion_arbusto") {
                buildDropdowns("Punto", menu, "Numero");
                var mySelectionPunto = document.getElementById("measurementPuntoNumero");
                //Add Number Options
                var fragPunto = document.createDocumentFragment(),
                    _elOption = void 0;
                _elOption = fragPunto.appendChild(document.createElement('option'));
                _elOption.value = "notselected";
                _elOption.innerHTML = " ";
                for (var i = 1; i <= 8; i++) {
                    _elOption = fragPunto.appendChild(document.createElement('option'));
                    _elOption.value = i;
                    _elOption.innerHTML = i;
                }
                mySelectionPunto.appendChild(fragPunto);
            }
            buildDropdowns(transpunto, menu, "Numero");
            var mySelection = document.getElementById('measurement' + transpunto + 'Numero');
            //Add Number Options

            var frag = document.createDocumentFragment(),
                elOption = void 0;
            elOption = frag.appendChild(document.createElement('option'));
            elOption.value = "notselected";
            elOption.innerHTML = " ";
            for (var _i2 = 1; _i2 <= numberPoints; _i2++) {
                elOption = frag.appendChild(document.createElement('option'));
                elOption.value = _i2;
                elOption.innerHTML = _i2;
            }
            while (mySelection.hasChildNodes()) {
                mySelection.removeChild(mySelection.lastChild);
            }
            mySelection.appendChild(frag);
            clearForm(menu, "Form");

            buildCustomForm(myChoice, menu);
        }
    };
    var currentOnChange3 = function currentOnChange3(tableName, menu) {
        currentFunction3(tableName, menu);
    };
    getSelection.onchange = currentOnChange3;
}

//////////////////////////////////////////////////////////////////////////////////////          

function selectSpeciesOnChange(tableName, menu, numRows) {
    var currentFunction2 = function currentFunction2(tableName, numRows) {
        var myChoice = document.getElementById("row" + numRows + tableName + "Form").value;
        var allMyRows = document.getElementsByClassName("row" + numRows + "*" + tableName);
        var colRow = document.getElementsByClassName("row" + numRows + "disableme");
        if (myChoice === "Nuevo") {
            colRow[0].disabled = false;
            colRow[1].disabled = false;
        } else {
            colRow[0].disabled = true;
            colRow[1].disabled = true;
            colRow[0].value = "";
            colRow[1].value = "";
        }
        if (myChoice === "0000") {
            for (var i = 0; i < allMyRows.length; i++) {
                if (allMyRows[i].name.includes("hora")) {
                    allMyRows[i].value = "00:01";
                } else if (allMyRows[i].name.includes("fecha")) {
                    allMyRows[i].value = "1000-01-01";
                } else {
                    allMyRows[i].value = "0000";
                }
            }
        }
        if (myChoice === "000") {
            for (var _i3 = 0; _i3 < allMyRows.length; _i3++) {
                allMyRows[_i3].value = "000";
            }
        }
    };
    var currentOnChange2 = function currentOnChange2() {
        currentFunction2(tableName, numRows);
    };
    var getSelection = document.getElementById("row" + numRows + tableName + "Form");
    getSelection.onchange = currentOnChange2;
}

function buildCustomForm(obName, menu) {
    var transPunto = 'punto';
    if (obName == 'observacion_hierba' || obName == 'observacion_herpetofauna') {
        transPunto = 'transecto';
    }
    var obsNameContext = transPunto + "_" + obName.split('_')[1];

    buildForm(obsNameContext, menu, ' ', false, false, [], false);

    buildForm(obName, menu, ' ', true, true, []);

    if (obName == 'observacion_arbol' || obName == 'observacion_arbusto') {
        var getSelectionAdd = document.getElementById("addElementRow" + obName);
        var getSelectionSubtract = document.getElementById('subtractElementRow');
        var getCuadrante0 = document.getElementById("row" + 0 + "cuadrante");
        getCuadrante0.setAttribute("readonly", true);
        for (var i = 0; i < 7; i++) {
            getSelectionAdd.onclick();
            var getCuadrante = document.getElementById("row" + (i + 1) + "cuadrante");
            getCuadrante.value = Math.floor(i / 2 + 1.5);
            getCuadrante.setAttribute("readonly", true);
        }
        numRows = 0;
        getSelectionAdd.disabled = true;
        getSelectionSubtract.disabled = true;
    }
}

function addOnChangeAdminTable() {
    var getSelection = document.getElementById('table_option');
    var currentFunction3 = function currentFunction3(tableName, menu) {

        var myChoice = getSelection.value;
        var mySelection = document.getElementById('field_option');
        var mycurrentlist = tabletoColumns[myChoice];
        var frag = document.createDocumentFragment(),
            elOption = void 0;

        for (var i = 0; i < mycurrentlist.length; i++) {
            if (!mycurrentlist[i].includes("iden")) {
                elOption = frag.appendChild(document.createElement('option'));
                elOption.value = mycurrentlist[i];
                elOption.innerHTML = mycurrentlist[i];
            }
        }
        while (mySelection.hasChildNodes()) {
            mySelection.removeChild(mySelection.lastChild);
        }
        mySelection.appendChild(frag);
    };
    var currentOnChange3 = function currentOnChange3() {
        currentFunction3();
    };
    getSelection.onchange = currentOnChange3;
}

var numRows = 0;
if (window.location.href.substr(-5) === 'admin') {
    buildDropdowns("usuario", "measurement", "Select");
    selectOptionsCreate("usuario", "measurement", true, "Select", [], false, false);
    buildDropdowns("usuario_permitido", "measurement", "Medicion");
    selectOptionsCreate("usuario_permitido", "measurement", true, "Medicion", [], false, false);
    addOnChangeAdminTable();
} else {
    buildDropdowns("linea_mtp", "measurement", "Select");
    selectOptionsCreate("linea_mtp", "measurement", true, "Select");
    addOnChangeMTP("linea_mtp", "measurement");
}

/***/ })

/******/ });