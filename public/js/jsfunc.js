!function(e){var t={};function n(o){if(t[o])return t[o].exports;var a=t[o]={i:o,l:!1,exports:{}};return e[o].call(a.exports,a,a.exports,n),a.l=!0,a.exports}n.m=e,n.c=t,n.d=function(e,t,o){n.o(e,t)||Object.defineProperty(e,t,{configurable:!1,enumerable:!0,get:o})},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=102)}({102:function(e,t,n){e.exports=n(103)},103:function(e,t,n){"use strict";function o(e,t){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"Form";t||(t="measurement");var o=document.getElementById(t+"TBody"+n),a=document.createElement("select");a.id=t+e+n,a.name="select"+e,a.className="form-control";var r=document.createElement("tr");r.id="row"+e;var i=document.createElement("LABEL");i.setAttribute("for",t+e+n);var l=e.split("_").join(" ");i.textContent=l.charAt(0).toUpperCase()+l.slice(1),i.className="dropDownTitles";var c=document.createElement("td");if(c.appendChild(a),r.appendChild(i),r.appendChild(c),"Form"===n){var m=d(e,t,tabletoColumns[e],0),s=document.createElement("td");s.innerHTML="&nbsp;";var u=document.createElement("td");u.innerHTML="&nbsp;";var p=document.createElement("td");p.innerHTML="&nbsp;";var v=document.createElement("td");v.innerHTML="&nbsp;",m[0].prepend(s),m[0].prepend(u),m[1].prepend(p),m[1].prepend(v);var f=document.createElement("tr");f.className="myspacer";for(var h=0;h<9;h++)f.appendChild(s.cloneNode(!0));var b=document.createElement("tr");b.appendChild(s.cloneNode(!0)),m[1].id=e+"inputrow",m[0].id=e+"columnsrow",m[1].className=m[1].className+" hiddenrows",m[0].className=m[0].className+" hiddenrows",o.prepend(b),o.prepend(f),o.prepend(m[1]),o.prepend(m[0]),o.prepend(r)}else{var E=document.createElement("tr");E.id="spacer"+e;var C=document.createElement("td");C.innerHTML="&nbsp;",E.appendChild(C),o.prepend(E),o.prepend(r)}}function a(e,t){var n=!(arguments.length>2&&void 0!==arguments[2])||arguments[2],o=arguments.length>3&&void 0!==arguments[3]?arguments[3]:"Form",a=arguments.length>4&&void 0!==arguments[4]?arguments[4]:[],r=arguments.length>5&&void 0!==arguments[5]&&arguments[5],d=!(arguments.length>6&&void 0!==arguments[6])||arguments[6],i=r?"row"+p+e+"Form":t+e+o;if("observaciones"===e&&(i="measurementobservacionesObservaciones"),"medicion"===e&&(i="measurementmedicionMedicion"),"linea_mtp"===e&&(i="measurementlinea_mtpSelect"),"municipio"===e){d=!1;var l=muninames.map(function(e){return e.nomgeo});completetitlevallist[e]=l}if(document.getElementById(i)){var c=document.getElementById(i);"observacion"===e.split("_")[0]&&(e=e.replace("observacion","especie"));var m=completetitlevallist[e];m="observaciones"===e?["ave","arbol","arbusto","mamifero","herpetofauna","hierba"]:m;var s=document.createDocumentFragment(),u=void 0;if((u=s.appendChild(document.createElement("option"))).value="notselected",u.innerHTML=" ",d&&((u=s.appendChild(document.createElement("option"))).value="Nuevo",u.innerHTML="Nuevo"),!1===n)for(var v=0;v<a[e].length;v++)(u=s.appendChild(document.createElement("option"))).value=m[a[e][v]],u.innerHTML=m[a[e][v]];else for(var f=0;f<m.length;f++)(u=s.appendChild(document.createElement("option"))).value=m[f],u.innerHTML=m[f];for(;c.hasChildNodes();)c.removeChild(c.lastChild);c.appendChild(s)}}function r(e,t){e||(e="measurement");var n=document.getElementById(e+"TBody"+t);if(n)for(;n.hasChildNodes();)n.removeChild(n.lastChild)}function d(e,t,n,o){var a=arguments.length>4&&void 0!==arguments[4]&&arguments[4],r=arguments.length>5&&void 0!==arguments[5]?arguments[5]:[],d=[],i=document.createElement("tr"),l=document.createElement("tr");if(l.class="dataRows",n.sort(function(e,t){return e<t?-1:e>t?1:0}),n.sort(function(e,t){return"notas"==e?1:"notas"==t?-1:-1!==e.indexOf("omienzo")?-1:-1!==t.indexOf("omienzo")?1:-1!==e.indexOf("long")?-1:-1!==t.indexOf("long")?1:-1!==e.indexOf("lat")?-1:-1!==t.indexOf("lat")?1:-1!==e.indexOf("hora")?-1:-1!==t.indexOf("hora")?1:-1!==e.indexOf("fecha")?-1:-1!==t.indexOf("fecha")?1:1==e.length?1:1==t.length?-1:2==e.length?1:2==t.length?-1:0}),r.length>=1&&(n=r),a){if("observacion_arbol"==e||"observacion_arbusto"==e){var c=document.createElement("td");c.textContent="Cuadrante",c.className="formcolumnlabels";var m=document.createElement("td"),s=document.createElement("INPUT");s.setAttribute("type","text"),s.name="row"+o+"*"+e+"*cuadrante",s.id="row"+o+"cuadrante",s.value=1,s.className="cuadranteinput",m.appendChild(s),m.className="cuadrante",i.appendChild(c),l.appendChild(m)}var u=e.replace("observacion","especie"),p=document.createElement("td");p.innerText=u,p.className="formcolumnlabels",i.appendChild(p);var v=document.createElement("SELECT");v.id="row"+o+e+"Form",v.setAttribute("class",u),v.classList.add("allinputs"),v.classList.add("form-control"),v.name="row"+o+"*"+e+"*species";var f=document.createElement("td");f.appendChild(v),l.appendChild(f);var h=document.createElement("td");h.textContent="Nuevo Nombre Comun",h.className="formcolumnlabels",i.appendChild(h);var b=document.createElement("td");b.textContent="Nuevo Nombre Cientifico",b.className="formcolumnlabels",i.appendChild(b);var E=document.createElement("INPUT");E.setAttribute("type","text"),E.classList.add("row"+o+"disableme"),E.classList.add("allinputs"),E.classList.add("form-control"),E.disabled=!0,E.name="row"+o+"*"+e+"*comun";var C=document.createElement("td");C.appendChild(E),l.appendChild(C);var g=document.createElement("INPUT");g.setAttribute("type","text"),g.classList.add("row"+o+"disableme"),g.classList.add("allinputs"),g.classList.add("form-control"),g.disabled=!0,g.name="row"+o+"*"+e+"*cientifico";var N=document.createElement("td");N.appendChild(g),l.appendChild(N)}if(n.forEach(function(t){var n=!1;if(void 0!==allPhp2[e].fKeyCol&&(n=!!allPhp2[e].fKeyCol.find(function(e){return e==t})),!t.includes("iden")&&!n){var r=document.createElement("td"),d=t.split("_").join(" ");r.innerText=d.charAt(0).toUpperCase()+d.slice(1),r.className="formcolumnlabels",i.appendChild(r),i.className=e+"columnrow";var c=document.createElement("INPUT");"fecha"==t.substring(0,5).toLowerCase()?(c.classList.add("fechainputs"),c.setAttribute("type","date")):"hora"===t.substring(0,4).toLowerCase()?(c.classList.add("horainputs"),c.setAttribute("type","time")):c.setAttribute("type","text"),c.id=e+t,c.classList.add(e+t),a&&c.classList.add("row"+o+"*"+e),c.classList.add("allinputs"),c.classList.add("form-control"),c.name=("row"+o+"*"+e+"*"+t).toLowerCase();var m=document.createElement("td");m.appendChild(c),l.className=e+"inputrow","Foto"!==t&&l.appendChild(m)}}),a){var y=document.createElement("INPUT");y.setAttribute("type","file"),y.name=("row"+o+"*"+e+"*foto").toLowerCase(),y.id=e+"foto";var B=document.createElement("td");return B.appendChild(y),l.appendChild(B),[i,l,d]}return[i,l,d]}function i(e,t,n){var o=arguments.length>3&&void 0!==arguments[3]&&arguments[3],r=arguments.length>4&&void 0!==arguments[4]&&arguments[4],i=arguments.length>5&&void 0!==arguments[5]?arguments[5]:[],c=!(arguments.length>6&&void 0!==arguments[6])||arguments[6];t||(t="measurement");var m=document.getElementById(t+"TBodyForm"),s=tabletoColumns[e],u=document.createElement("tr");u.className="formtitles",u.innerHTML="<br> ","none"!==n&&(u.innerHTML=n);var v=document.createElement("tr"),f=document.createElement("INPUT");f.setAttribute("type","submit"),f.id=t+e+"Submit",f.className="mySubmit",document.getElementsByClassName("mySubmit").length>0&&(f=document.getElementsByClassName("mySubmit")[0]);var h=d(e,t,s,0,r,i),b=document.createElement("BUTTON");b.setAttribute("type","button"),b.id="addElementRow"+e;var E=document.createElement("BUTTON");E.setAttribute("type","button"),E.id="subtractElementRow",b.innerText="+",E.innerText="-",b.onclick=function(){return function(e,t,n,o){var r=arguments.length>4&&void 0!==arguments[4]?arguments[4]:[],i="selection",c=document.getElementById(t+"bottomspacer"),m=d(t,i,n,++p,o,r);m[1].class="addedRow",m[1].id="addedRow",e.insertBefore(m[1],c),o&&(l(t,i,p),a(t,i,!0,"Form",[],!0))}(m,e,s,r,i)},E.onclick=function(){return function(e,t){e.childNodes.forEach(function(n,o){if(n.id==t+"bottomspacer"){var a=e.childNodes[o-1];"addedRow"==a.id&&(e.removeChild(a),p--)}})}(m,e)};var C=document.createElement("td");C.appendChild(b),C.appendChild(E),v.appendChild(C);var g=document.createElement("td");g.innerHTML="&nbsp;";var N=document.createElement("tr");N.className="myspacer";for(var y=0;y<h[0].childElementCount;y++)N.appendChild(g.cloneNode(!0));var B=document.createElement("tr");B.appendChild(g.cloneNode(!0));var w=document.createElement("tr");w.id=e+"bottomspacer",w.appendChild(g.cloneNode(!0)),"medicion"!=e&&c?o?(m.appendChild(f),m.insertBefore(N,f),m.insertBefore(B,f),m.insertBefore(u,f),m.insertBefore(v,f),m.insertBefore(h[0],f),m.insertBefore(h[1],f),m.insertBefore(w,f)):(m.appendChild(f),m.insertBefore(u,f),m.insertBefore(v,f),m.insertBefore(h[0],f),m.insertBefore(h[1],f),m.insertBefore(w,f)):(m.appendChild(f),m.insertBefore(h[0],f),m.insertBefore(h[1],f)),r&&(a(e,t,!0,"Form",[],!0),l(e,t,0))}function l(e,t,n){document.getElementById("row"+n+e+"Form").onchange=function(){!function(e,t){var n=document.getElementById("row"+t+e+"Form").value,o=document.getElementsByClassName("row"+t+"*"+e),a=document.getElementsByClassName("row"+t+"disableme");if("Nuevo"===n?(a[0].disabled=!1,a[1].disabled=!1):(a[0].disabled=!0,a[1].disabled=!0,a[0].value="",a[1].value=""),"0000"===n)for(var r=0;r<o.length;r++)o[r].name.includes("hora")?o[r].value="00:01":o[r].name.includes("fecha")?o[r].value="1000-01-01":o[r].value="0000";if("000"===n)for(var d=0;d<o.length;d++)o[d].value="000"}(e,n)}}var c,m,s,u,p=0;"admin"===window.location.href.substr(-5)?(o("usuario","measurement","Select"),a("usuario","measurement",!0,"Select",[],!1,!1),o("usuario_permitido","measurement","Medicion"),a("usuario_permitido","measurement",!0,"Medicion",[],!1,!1),(u=document.getElementById("table_option")).onchange=function(){!function(e,t){for(var n=u.value,o=document.getElementById("field_option"),a=tabletoColumns[n],r=document.createDocumentFragment(),d=void 0,i=0;i<a.length;i++)a[i].includes("iden")||((d=r.appendChild(document.createElement("option"))).value=a[i],d.innerHTML=a[i]);for(;o.hasChildNodes();)o.removeChild(o.lastChild);o.appendChild(r)}()}):(o("linea_mtp","measurement","Select"),a("linea_mtp","measurement",!0,"Select"),c="linea_mtp",m="measurement",s=function(e,t){var n=document.getElementById(t+e+"Select").value;r(t,"Form"),"Nuevo"==n?(r(t,"Medicion"),r(t,"Observaciones"),r(t,"Numero"),r(t,"Form"),i("linea_mtp",t,"Coordenadas de Linea"),["predio","municipio","estado"].forEach(function(e){o(e,t,"Form"),a(e,t),function(e,t){var n=document.getElementById(t+e+"Form");n.onchange=function(){!function(e,t){var o=n.value,a=document.getElementById(e+"inputrow"),r=document.getElementById(e+"columnsrow");"Nuevo"===o?(r.classList.remove("hiddenrows"),a.classList.remove("hiddenrows")):(r.classList.add("hiddenrows"),a.classList.add("hiddenrows"))}(e)}}(e,t)})):(r(t,"Observaciones"),r(t,"Medicion"),o("medicion",t,"Medicion"),a("medicion",t),function(e,t){var n=function(e,t){var n,d=document.getElementById(t+e+"Medicion").value;"Nuevo"===d?(r(t,"Observaciones"),r(t,"Numero"),r(t,"Form"),i("medicion",t),i("personas",t,"Brigada"),i("gps",t,"GPS",!0),i("camara",t,"Camara",!0)):(r(t,"Observaciones"),r(t,"Numero"),r(t,"Form"),o("observaciones",t,"Observaciones"),a("observaciones",t,!0,"Form",[],!1,!1),n=function(e,t){var n="observacion_"+document.getElementById("measurementobservacionesObservaciones").value;if(p=0,r(t,"Numero"),r(t,"Form"),"notselected"!==n){var a=4,d="Transecto";if("observacion_ave"!=n&&"observacion_mamifero"!=n||(d="Punto",a=5),"observacion_arbol"==n||"observacion_arbusto"==n){o("Punto",t,"Numero");var l=document.getElementById("measurementPuntoNumero"),c=document.createDocumentFragment(),m=void 0;(m=c.appendChild(document.createElement("option"))).value="notselected",m.innerHTML=" ";for(var s=1;s<=8;s++)(m=c.appendChild(document.createElement("option"))).value=s,m.innerHTML=s;l.appendChild(c)}o(d,t,"Numero");var u=document.getElementById("measurement"+d+"Numero"),v=document.createDocumentFragment(),f=void 0;(f=v.appendChild(document.createElement("option"))).value="notselected",f.innerHTML=" ";for(var h=1;h<=a;h++)(f=v.appendChild(document.createElement("option"))).value=h,f.innerHTML=h;for(;u.hasChildNodes();)u.removeChild(u.lastChild);u.appendChild(v),r(t,"Form"),function(e,t){var n="punto";if("observacion_hierba"!=e&&"observacion_herpetofauna"!=e||(n="transecto"),i(n+"_"+e.split("_")[1],t," ",!1,!1,[],!1),i(e,t," ",!0,!0,[]),"observacion_arbol"==e||"observacion_arbusto"==e){var o=document.getElementById("addElementRow"+e),a=document.getElementById("subtractElementRow"),r=document.getElementById("row0cuadrante");r.setAttribute("readonly",!0);for(var d=0;d<7;d++){o.onclick();var l=document.getElementById("row"+(d+1)+"cuadrante");l.value=Math.floor(d/2+1.5),l.setAttribute("readonly",!0)}p=0,o.disabled=!0,a.disabled=!0}}(n,t)}},document.getElementById("measurementobservacionesObservaciones").onchange=function(e,t){n(e,t)})};document.getElementById(t+e+"Medicion").onchange=function(){n(e,t)}}("medicion",t))},document.getElementById(m+c+"Select").onchange=function(){s(c,m)})}});