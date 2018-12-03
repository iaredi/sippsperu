<<<<<<< HEAD
!function(e){var t={};function n(r){if(t[r])return t[r].exports;var o=t[r]={i:r,l:!1,exports:{}};return e[r].call(o.exports,o,o.exports,n),o.l=!0,o.exports}n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{configurable:!1,enumerable:!0,get:r})},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=102)}({102:function(e,t,n){e.exports=n(103)},103:function(e,t,n){"use strict";var r,o=n(14),a=(r=o)&&r.__esModule?r:{default:r},i=function(){return function(e,t){if(Array.isArray(e))return e;if(Symbol.iterator in Object(e))return function(e,t){var n=[],r=!0,o=!1,a=void 0;try{for(var i,c=e[Symbol.iterator]();!(r=(i=c.next()).done)&&(n.push(i.value),!t||n.length!==t);r=!0);}catch(e){o=!0,a=e}finally{try{!r&&c.return&&c.return()}finally{if(o)throw a}}return n}(e,t);throw new TypeError("Invalid attempt to destructure non-iterable instance")}}();function c(e,t){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"Form",r=arguments.length>3&&void 0!==arguments[3]&&arguments[3];t||(t="measurement");var o=document.getElementById(t+"TBody"+n),a=document.createElement("select");a.id=t+e+n,a.name="select"+e,a.className="form-control";var i=document.createElement("tr");i.id="row"+e;var c=document.createElement("LABEL");c.setAttribute("for",t+e+n);var d=e.split("_").join(" ");c.textContent=r?"#":d.charAt(0).toUpperCase()+d.slice(1),c.className="dropDownTitles";var l=document.createElement("td");if(l.appendChild(a),i.appendChild(c),i.appendChild(l),"Form"===n){var s=u(e,t,tabletoColumns[e],0),m=document.createElement("td");m.innerHTML="&nbsp;";var p=document.createElement("td");p.innerHTML="&nbsp;";var f=document.createElement("td");f.innerHTML="&nbsp;";var v=document.createElement("td");v.innerHTML="&nbsp;",s[0].prepend(m),s[0].prepend(p),s[1].prepend(f),s[1].prepend(v);var h=document.createElement("tr");h.className="myspacer";for(var y=0;y<9;y++)h.appendChild(m.cloneNode(!0));var g=document.createElement("tr");g.appendChild(m.cloneNode(!0)),s[1].id=e+"inputrow",s[0].id=e+"columnsrow",s[1].className=s[1].className+" hiddenrows",s[0].className=s[0].className+" hiddenrows",o.prepend(g),o.prepend(h),o.prepend(s[1]),o.prepend(s[0]),o.prepend(i)}else{var b=document.createElement("tr");b.id="spacer"+e;var E=document.createElement("td");E.innerHTML="&nbsp;",b.appendChild(E),o.prepend(b),"datos"==e?o.append(i):o.prepend(i)}}function d(e,t){var n=!(arguments.length>2&&void 0!==arguments[2])||arguments[2],r=arguments.length>3&&void 0!==arguments[3]?arguments[3]:"Form",o=arguments.length>4&&void 0!==arguments[4]?arguments[4]:[],a=arguments.length>5&&void 0!==arguments[5]&&arguments[5],i=!(arguments.length>6&&void 0!==arguments[6])||arguments[6],c=a?"row"+b+e+"Form":t+e+r;if("observaciones"===e&&(c="measurementobservacionesObservaciones"),"medicion"===e&&(c="measurementmedicionMedicion"),"linea_mtp"===e&&(c="measurementlinea_mtpSelect"),"municipio"===e){i=!1;var d=muninames.map(function(e){return e.nomgeo});completetitlevallist[e]=d}if(document.getElementById(c)){var l=document.getElementById(c);"observacion"===e.split("_")[0]&&(e=e.replace("observacion","especie"));var u=completetitlevallist[e];u="observaciones"===e?["ave","arbol","arbusto","mamifero","herpetofauna","hierba"]:u;var s=document.createDocumentFragment(),m=void 0;if((m=s.appendChild(document.createElement("option"))).value="notselected",m.innerHTML=" ",i&&((m=s.appendChild(document.createElement("option"))).value="Nuevo",m.innerHTML="Nuevo"),!1===n)for(var p=0;p<o[e].length;p++)(m=s.appendChild(document.createElement("option"))).value=u[o[e][p]],m.innerHTML=u[o[e][p]];else for(var f=0;f<u.length;f++)"medicion"==e&&u[f].split("*")[0]!=document.getElementById("measurementlinea_mtpSelect").value.split(" (")[0]||((m=s.appendChild(document.createElement("option"))).value=u[f],m.innerHTML=u[f]);for(;l.hasChildNodes();)l.removeChild(l.lastChild);l.appendChild(s)}}function l(e,t){e||(e="measurement");var n=document.getElementById(e+"TBody"+t);if(n)for(;n.hasChildNodes();)n.removeChild(n.lastChild)}function u(e,t,n,r){var o=arguments.length>4&&void 0!==arguments[4]&&arguments[4],a=arguments.length>5&&void 0!==arguments[5]?arguments[5]:[],i=[],c=document.createElement("tr"),d=document.createElement("tr");if(d.class="dataRows",n.sort(function(e,t){return e<t?-1:e>t?1:0}),n.sort(function(e,t){return"notas"==e?1:"notas"==t?-1:-1!==e.indexOf("omienzo")?-1:-1!==t.indexOf("omienzo")?1:-1!==e.indexOf("long")?-1:-1!==t.indexOf("long")?1:-1!==e.indexOf("lat")?-1:-1!==t.indexOf("lat")?1:-1!==e.indexOf("hora")?-1:-1!==t.indexOf("hora")?1:-1!==e.indexOf("fecha")?-1:-1!==t.indexOf("fecha")?1:-1!==e.indexOf("sexo")?-1:-1!==t.indexOf("sexo")?1:-1!==e.indexOf("estadio")?-1:-1!==t.indexOf("estadio")?1:-1!==e.indexOf("actividad")?-1:-1!==t.indexOf("actividad")?1:-1!==e.indexOf("distancia")?-1:-1!==t.indexOf("distancia")?1:-1!==e.indexOf("azimut")?-1:-1!==t.indexOf("azimut")?1:-1!==e.indexOf("altura")?-1:-1!==t.indexOf("altura")?1:-1!==e.indexOf("dn")?-1:-1!==t.indexOf("dn")?1:-1!==e.indexOf("dc1")?-1:-1!==t.indexOf("dc1")?1:-1!==e.indexOf("dc2")?-1:-1!==t.indexOf("dc2")?1:1==e.length?1:1==t.length?-1:2==e.length?1:2==t.length?-1:0}),a.length>=1&&(n=a),o){if("observacion_arbol"==e||"observacion_arbusto"==e){var l=document.createElement("td");l.textContent="Cuadrante",l.className="formcolumnlabels";var u=document.createElement("td"),s=document.createElement("INPUT");s.setAttribute("type","text"),s.name="row"+r+"*"+e+"*cuadrante",s.id="row"+r+"cuadrante",s.value=1,s.className="cuadranteinput",u.appendChild(s),u.className="cuadrante",c.appendChild(l),d.appendChild(u);var m=document.createElement("td");m.textContent="#",m.className="formcolumnlabels octothorp";var p=document.createElement("td"),f=document.createElement("INPUT");f.setAttribute("type","text"),f.name="row"+r+"*"+e+"*cuadnum",f.id="row"+r+"cuadnum",f.value=1,f.className="cuadranteinput",p.appendChild(f),p.className="cuadrante",c.appendChild(m),d.appendChild(p)}var v=e.replace("observacion","especie"),h=document.createElement("td");h.innerText=v,h.className="formcolumnlabels",c.appendChild(h);var y=document.createElement("SELECT");y.id="row"+r+e+"Form",y.setAttribute("class",v),y.classList.add("allinputs"),y.classList.add("form-control"),y.name="row"+r+"*"+e+"*species";var g=document.createElement("td");g.appendChild(y),d.appendChild(g);var b=document.createElement("td");b.textContent="Nuevo Nombre Comun",b.className="formcolumnlabels",c.appendChild(b);var E=document.createElement("td");E.textContent="Nuevo Nombre Cientifico",E.className="formcolumnlabels",c.appendChild(E);var w=document.createElement("INPUT");w.setAttribute("type","text"),w.classList.add("row"+r+"disableme"),w.classList.add("allinputs"),w.classList.add("form-control"),w.disabled=!0,w.name="row"+r+"*"+e+"*comun";var x=document.createElement("td");x.appendChild(w),d.appendChild(x);var C=document.createElement("INPUT");C.setAttribute("type","text"),C.classList.add("row"+r+"disableme"),C.classList.add("allinputs"),C.classList.add("form-control"),C.disabled=!0,C.name="row"+r+"*"+e+"*cientifico";var N=document.createElement("td");N.appendChild(C),d.appendChild(N)}if(n.forEach(function(t){var n=!1;if(void 0!==allPhp2[e].fKeyCol&&(n=!!allPhp2[e].fKeyCol.find(function(e){return e==t})),!t.includes("iden")&&!n){var a=document.createElement("td"),i=t.split("_").join(" ");a.innerText=i.charAt(0).toUpperCase()+i.slice(1),a.className="formcolumnlabels",c.appendChild(a),c.className=e+"columnrow";var l=document.createElement("INPUT");"fecha"==t.substring(0,5).toLowerCase()?(l.classList.add("fechainputs"),l.setAttribute("type","date")):"hora"===t.substring(0,4).toLowerCase()?(l.classList.add("horainputs"),l.setAttribute("type","time")):l.setAttribute("type","text"),l.id=e+t,l.classList.add(e+t),o&&l.classList.add("row"+r+"*"+e),l.classList.add("allinputs"),l.classList.add("form-control"),l.name=("row"+r+"*"+e+"*"+t).toLowerCase();var u=document.createElement("td");u.appendChild(l),d.className=e+"inputrow","Foto"!==t&&d.appendChild(u)}}),o){var B=document.createElement("INPUT");B.setAttribute("type","file"),B.name=("row"+r+"*"+e+"*foto").toLowerCase(),B.id=e+"foto";var L=document.createElement("td");return L.appendChild(B),d.appendChild(L),[c,d,i]}return[c,d,i]}function s(e,t,n){var r=arguments.length>3&&void 0!==arguments[3]&&arguments[3],o=arguments.length>4&&void 0!==arguments[4]&&arguments[4],a=arguments.length>5&&void 0!==arguments[5]?arguments[5]:[],i=!(arguments.length>6&&void 0!==arguments[6])||arguments[6];t||(t="measurement");var c=document.getElementById(t+"TBodyForm"),l=tabletoColumns[e],s=document.createElement("tr");s.className="formtitles",s.innerHTML="<br> ","none"!==n&&(s.innerHTML=n);var m=document.createElement("tr"),f=document.createElement("INPUT");f.setAttribute("type","submit"),f.id=t+e+"Submit",f.className="mySubmit p-2 m-2",f.value="Enviar",document.getElementsByClassName("mySubmit").length>0&&(f=document.getElementsByClassName("mySubmit")[0]);var v=u(e,t,l,0,o,a),h=document.createElement("BUTTON");h.setAttribute("type","button"),h.id="addElementRow"+e;var y=document.createElement("BUTTON");y.setAttribute("type","button"),y.id="subtractElementRow",h.innerText="+",y.innerText="-",h.onclick=function(){return function(e,t,n,r){var o=arguments.length>4&&void 0!==arguments[4]?arguments[4]:[],a="selection",i=document.getElementById(t+"bottomspacer"),c=u(t,a,n,++b,r,o);c[1].class="addedRow",c[1].id="addedRow",e.insertBefore(c[1],i),r&&(p(t,a,b),d(t,a,!0,"Form",[],!0))}(c,e,l,o,a)},y.onclick=function(){return function(e,t){e.childNodes.forEach(function(n,r){if(n.id==t+"bottomspacer"){var o=e.childNodes[r-1];"addedRow"==o.id&&(e.removeChild(o),b--)}})}(c,e)};var g=document.createElement("td");g.appendChild(h),g.appendChild(y),m.appendChild(g);var E=document.createElement("td");E.innerHTML="&nbsp;";var w=document.createElement("tr");w.className="myspacer";for(var x=0;x<v[0].childElementCount;x++)w.appendChild(E.cloneNode(!0));var C=document.createElement("tr");C.appendChild(E.cloneNode(!0));var N=document.createElement("tr");N.id=e+"bottomspacer",N.appendChild(E.cloneNode(!0)),"medicion"!=e&&i?r?(c.appendChild(f),c.insertBefore(w,f),c.insertBefore(C,f),c.insertBefore(s,f),c.insertBefore(m,f),c.insertBefore(v[0],f),c.insertBefore(v[1],f),c.insertBefore(N,f)):(c.appendChild(f),c.insertBefore(s,f),c.insertBefore(m,f),c.insertBefore(v[0],f),c.insertBefore(v[1],f),c.insertBefore(N,f)):(c.appendChild(f),c.insertBefore(v[0],f),c.insertBefore(v[1],f)),o&&(d(e,t,!0,"Form",[],!0),p(e,t,0))}function m(e){var t,n,r=(t=a.default.mark(function e(){var t,n;return a.default.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,fetch("https://biodiversidadpuebla.online/api/getudp",{method:"POST",headers:{Accept:"application/json","Content-Type":"application/json;",mode:"cors"},body:JSON.stringify({lineamtp:document.getElementById("measurementlinea_mtpSelect").value,medicion:document.getElementById("measurementmedicionMedicion").value,observacion:c,punto:d?d.value:"0",transecto:u?u.value:"0",useremail:useremail})});case 2:return t=e.sent,e.next=5,t.json();case 5:return n=e.sent,e.abrupt("return",n);case 7:case"end":return e.stop()}},e,this)}),n=function(){var e=t.apply(this,arguments);return new Promise(function(t,n){return function r(o,a){try{var i=e[o](a),c=i.value}catch(e){return void n(e)}if(!i.done)return Promise.resolve(c).then(function(e){r("next",e)},function(e){r("throw",e)});t(c)}("next")})},function(){return n.apply(this,arguments)}),o="measurement",c="observacion_"+document.getElementById("measurementobservacionesObservaciones").value,d=(document.getElementById("measurementdatosNumero"),document.getElementById("measurementPuntoNumero")),u=document.getElementById("measurementTransectoNumero"),s=document.getElementById("measurementlinea_mtpSelect"),m=document.getElementById("measurementmedicionMedicion");if(s&&"notselected"==s.value)alert("Elige Linea MTP");else if(d&&"notselected"==d.value)alert("Elige Punto");else if(m&&"notselected"==m.value)alert("Elige Medicion");else if(u&&"notselected"==u.value)alert("Elige Transecto");else if(e.offsetX>0)r().then(function(e){if(l(o,"Form"),e[0].length>0){var t=document.getElementById(o+"TBodyForm"),n=document.createElement("input");n.setAttribute("type","hidden"),n.name="hiddenlocation",n.value=e[0][0].iden,n.id="hiddenlocation",t.append(n),f(c,o,"Datos Existentes");var r="punto";(c.includes("hierba")||c.includes("herpetofauna"))&&(r="transecto");var a=document.getElementById("measurementobservacionesObservaciones").value,d=Object.entries(e[0][0]),u=!0,s=!1,m=void 0;try{for(var p,v=d[Symbol.iterator]();!(u=(p=v.next()).done);u=!0){var h=p.value,y=i(h,2),g=y[0],b=y[1],E=document.getElementById(r+"_"+a+g);E&&(E.value=b)}}catch(e){s=!0,m=e}finally{try{!u&&v.return&&v.return()}finally{if(s)throw m}}e[1].forEach(function(e,t){if(t>0){var n=document.getElementById("addElementRow"+c);c.includes("arbol")||c.includes("arbusto")||n.onclick()}var r=Object.entries(e),o=!0,a=!1,d=void 0;try{for(var l,u=r[Symbol.iterator]();!(o=(l=u.next()).done);o=!0){var s=l.value,m=i(s,2),p=m[0],f=m[1];if("comun_cientifico"==p)document.getElementsByName("row"+t+"*"+c+"*species")[0].value=f;var v=document.getElementsByName("row"+t+"*"+c+"*"+p);v[0]&&(v[0].value=f)}}catch(e){a=!0,d=e}finally{try{!o&&u.return&&u.return()}finally{if(a)throw d}}})}else f(c,o,"Datos Nuevos")});else if("Datos Nuevos"==newold)f(c,o,"Datos Nuevos");else{f(c,o,"Datos Existentes");var p=document.getElementById(o+"TBodyForm"),v=document.createElement("input");v.setAttribute("type","hidden"),v.name="hiddenlocation",v.value=hiddenlocationvalue,v.id="hiddenlocation",p.append(v)}}function p(e,t,n){document.getElementById("row"+n+e+"Form").onchange=function(){!function(e,t){var n=document.getElementById("row"+t+e+"Form").value,r=document.getElementsByClassName("row"+t+"*"+e),o=document.getElementsByClassName("row"+t+"disableme");if("Nuevo"===n?(o[0].disabled=!1,o[1].disabled=!1):(o[0].disabled=!0,o[1].disabled=!0,o[0].value="",o[1].value=""),"0000"===n)for(var a=0;a<r.length;a++)r[a].name.includes("hora")?r[a].value="00:01":r[a].name.includes("fecha")?r[a].value="1000-01-01":r[a].value="0000";if("000"===n)for(var i=0;i<r.length;i++)r[i].value="000"}(e,n)}}function f(e,t,n){var r="punto";if("observacion_hierba"!=e&&"observacion_herpetofauna"!=e||(r="transecto"),s(r+"_"+e.split("_")[1],t," ",!1,!1,[],!1),s(e,t," ",!0,!0,[]),"observacion_arbol"==e||"observacion_arbusto"==e){var o=document.getElementById("addElementRow"+e),a=document.getElementById("subtractElementRow");document.getElementById("row0cuadrante").setAttribute("readonly",!0);for(var i=0;i<7;i++){o.onclick();var c=document.getElementById("row"+(i+1)+"cuadrante");c.value=Math.floor(i/2+1.5),c.setAttribute("readonly",!0);var d=document.getElementById("row"+(i+1)+"cuadnum");d.value=i+2,d.setAttribute("readonly",!0)}b=0,o.disabled=!0,a.disabled=!0}var l=document.getElementById(t+"TBodyForm"),u=document.createElement("input");u.setAttribute("type","text"),u.name="mode",u.value=n,u.id="mode",u.className="btn modeButton text-dark text-center",u.setAttribute("readonly",!0),l.prepend(u)}var v,h,y,g,b=0;"admin"===window.location.href.substr(-5)?(c("usuario","measurement","Select"),d("usuario","measurement",!0,"Select",[],!1,!1),c("usuario_permitido","measurement","Medicion"),d("usuario_permitido","measurement",!0,"Medicion",[],!1,!1),(g=document.getElementById("table_option")).onchange=function(){!function(e,t){for(var n=g.value,r=document.getElementById("field_option"),o=tabletoColumns[n],a=document.createDocumentFragment(),i=void 0,c=0;c<o.length;c++)o[c].includes("iden")||((i=a.appendChild(document.createElement("option"))).value=o[c],i.innerHTML=o[c]);for(;r.hasChildNodes();)r.removeChild(r.lastChild);r.appendChild(a)}()}):(c("linea_mtp","measurement","Select"),d("linea_mtp","measurement",!0,"Select"),v="linea_mtp",h="measurement",y=function(e,t){var n=document.getElementById(t+e+"Select").value;l(t,"Form"),"Nuevo"==n?(l(t,"Medicion"),l(t,"Observaciones"),l(t,"Numero"),l(t,"Form"),s("linea_mtp",t,"Coordenadas de Linea"),["predio","municipio","estado"].forEach(function(e){c(e,t,"Form"),d(e,t),function(e,t){var n=document.getElementById(t+e+"Form");n.onchange=function(){!function(e,t){var r=n.value,o=document.getElementById(e+"inputrow"),a=document.getElementById(e+"columnsrow");"Nuevo"===r?(a.classList.remove("hiddenrows"),o.classList.remove("hiddenrows")):(a.classList.add("hiddenrows"),o.classList.add("hiddenrows"))}(e)}}(e,t)})):(l(t,"Observaciones"),l(t,"Medicion"),c("medicion",t,"Medicion"),d("medicion",t),function(e,t){var n=function(e,t){var n=document.getElementById(t+e+"Medicion").value;"Nuevo"===n?(l(t,"Observaciones"),l(t,"Numero"),l(t,"Form"),s("medicion",t),s("personas",t,"Brigada"),s("gps",t,"GPS",!0),s("camara",t,"Camara",!0)):(l(t,"Observaciones"),l(t,"Numero"),l(t,"Form"),c("observaciones",t,"Observaciones"),d("observaciones",t,!0,"Form",[],!1,!1),document.getElementById("measurementobservacionesObservaciones").onchange=function(e,t){!function(e,t){var n="observacion_"+document.getElementById("measurementobservacionesObservaciones").value;if(b=0,l(t,"Numero"),l(t,"Form"),"notselected"!==n){var r=4,o="Transecto";if("observacion_ave"!=n&&"observacion_mamifero"!=n||(o="Punto",r=5),"observacion_arbol"==n||"observacion_arbusto"==n){c("Punto",t,"Numero");var a=document.getElementById("measurementPuntoNumero");a.addEventListener("change",function(){l("","Form")});var i=document.createDocumentFragment(),d=void 0;(d=i.appendChild(document.createElement("option"))).value="notselected",d.innerHTML=" ";for(var u=1;u<=8;u++)(d=i.appendChild(document.createElement("option"))).value=u,d.innerHTML=u;a.appendChild(i)}var s="observacion_hierba"==n;c(o,t,"Numero",s);var p=document.getElementById("measurement"+o+"Numero");p.addEventListener("change",function(){l("","Form")});var f=document.createDocumentFragment(),v=void 0;(v=f.appendChild(document.createElement("option"))).value="notselected",v.innerHTML=" ";for(var h=1;h<=r;h++)(v=f.appendChild(document.createElement("option"))).value=h,v.innerHTML=h;for(;p.hasChildNodes();)p.removeChild(p.lastChild);p.appendChild(f);var y=document.createElement("button");y.textContent="Cargar Formulario",y.className="p-2 m-2 cargarformulario",y.type="button",y.id="readybutton",y.addEventListener("click",m);var g=document.getElementById("measurementTBodyNumero");g.append(y)}}(0,t)})};document.getElementById(t+e+"Medicion").onchange=function(){n(e,t)}}("medicion",t))},document.getElementById(h+v+"Select").onchange=function(){y(v,h)})},14:function(e,t,n){e.exports=n(15)},15:function(e,t,n){var r=function(){return this}()||Function("return this")(),o=r.regeneratorRuntime&&Object.getOwnPropertyNames(r).indexOf("regeneratorRuntime")>=0,a=o&&r.regeneratorRuntime;if(r.regeneratorRuntime=void 0,e.exports=n(16),o)r.regeneratorRuntime=a;else try{delete r.regeneratorRuntime}catch(e){r.regeneratorRuntime=void 0}},16:function(e,t){!function(t){"use strict";var n,r=Object.prototype,o=r.hasOwnProperty,a="function"==typeof Symbol?Symbol:{},i=a.iterator||"@@iterator",c=a.asyncIterator||"@@asyncIterator",d=a.toStringTag||"@@toStringTag",l="object"==typeof e,u=t.regeneratorRuntime;if(u)l&&(e.exports=u);else{(u=t.regeneratorRuntime=l?e.exports:{}).wrap=E;var s="suspendedStart",m="suspendedYield",p="executing",f="completed",v={},h={};h[i]=function(){return this};var y=Object.getPrototypeOf,g=y&&y(y(F([])));g&&g!==r&&o.call(g,i)&&(h=g);var b=N.prototype=x.prototype=Object.create(h);C.prototype=b.constructor=N,N.constructor=C,N[d]=C.displayName="GeneratorFunction",u.isGeneratorFunction=function(e){var t="function"==typeof e&&e.constructor;return!!t&&(t===C||"GeneratorFunction"===(t.displayName||t.name))},u.mark=function(e){return Object.setPrototypeOf?Object.setPrototypeOf(e,N):(e.__proto__=N,d in e||(e[d]="GeneratorFunction")),e.prototype=Object.create(b),e},u.awrap=function(e){return{__await:e}},B(L.prototype),L.prototype[c]=function(){return this},u.AsyncIterator=L,u.async=function(e,t,n,r){var o=new L(E(e,t,n,r));return u.isGeneratorFunction(t)?o:o.next().then(function(e){return e.done?e.value:o.next()})},B(b),b[d]="Generator",b[i]=function(){return this},b.toString=function(){return"[object Generator]"},u.keys=function(e){var t=[];for(var n in e)t.push(n);return t.reverse(),function n(){for(;t.length;){var r=t.pop();if(r in e)return n.value=r,n.done=!1,n}return n.done=!0,n}},u.values=F,_.prototype={constructor:_,reset:function(e){if(this.prev=0,this.next=0,this.sent=this._sent=n,this.done=!1,this.delegate=null,this.method="next",this.arg=n,this.tryEntries.forEach(T),!e)for(var t in this)"t"===t.charAt(0)&&o.call(this,t)&&!isNaN(+t.slice(1))&&(this[t]=n)},stop:function(){this.done=!0;var e=this.tryEntries[0].completion;if("throw"===e.type)throw e.arg;return this.rval},dispatchException:function(e){if(this.done)throw e;var t=this;function r(r,o){return c.type="throw",c.arg=e,t.next=r,o&&(t.method="next",t.arg=n),!!o}for(var a=this.tryEntries.length-1;a>=0;--a){var i=this.tryEntries[a],c=i.completion;if("root"===i.tryLoc)return r("end");if(i.tryLoc<=this.prev){var d=o.call(i,"catchLoc"),l=o.call(i,"finallyLoc");if(d&&l){if(this.prev<i.catchLoc)return r(i.catchLoc,!0);if(this.prev<i.finallyLoc)return r(i.finallyLoc)}else if(d){if(this.prev<i.catchLoc)return r(i.catchLoc,!0)}else{if(!l)throw new Error("try statement without catch or finally");if(this.prev<i.finallyLoc)return r(i.finallyLoc)}}}},abrupt:function(e,t){for(var n=this.tryEntries.length-1;n>=0;--n){var r=this.tryEntries[n];if(r.tryLoc<=this.prev&&o.call(r,"finallyLoc")&&this.prev<r.finallyLoc){var a=r;break}}a&&("break"===e||"continue"===e)&&a.tryLoc<=t&&t<=a.finallyLoc&&(a=null);var i=a?a.completion:{};return i.type=e,i.arg=t,a?(this.method="next",this.next=a.finallyLoc,v):this.complete(i)},complete:function(e,t){if("throw"===e.type)throw e.arg;return"break"===e.type||"continue"===e.type?this.next=e.arg:"return"===e.type?(this.rval=this.arg=e.arg,this.method="return",this.next="end"):"normal"===e.type&&t&&(this.next=t),v},finish:function(e){for(var t=this.tryEntries.length-1;t>=0;--t){var n=this.tryEntries[t];if(n.finallyLoc===e)return this.complete(n.completion,n.afterLoc),T(n),v}},catch:function(e){for(var t=this.tryEntries.length-1;t>=0;--t){var n=this.tryEntries[t];if(n.tryLoc===e){var r=n.completion;if("throw"===r.type){var o=r.arg;T(n)}return o}}throw new Error("illegal catch attempt")},delegateYield:function(e,t,r){return this.delegate={iterator:F(e),resultName:t,nextLoc:r},"next"===this.method&&(this.arg=n),v}}}function E(e,t,n,r){var o=t&&t.prototype instanceof x?t:x,a=Object.create(o.prototype),i=new _(r||[]);return a._invoke=function(e,t,n){var r=s;return function(o,a){if(r===p)throw new Error("Generator is already running");if(r===f){if("throw"===o)throw a;return M()}for(n.method=o,n.arg=a;;){var i=n.delegate;if(i){var c=O(i,n);if(c){if(c===v)continue;return c}}if("next"===n.method)n.sent=n._sent=n.arg;else if("throw"===n.method){if(r===s)throw r=f,n.arg;n.dispatchException(n.arg)}else"return"===n.method&&n.abrupt("return",n.arg);r=p;var d=w(e,t,n);if("normal"===d.type){if(r=n.done?f:m,d.arg===v)continue;return{value:d.arg,done:n.done}}"throw"===d.type&&(r=f,n.method="throw",n.arg=d.arg)}}}(e,n,i),a}function w(e,t,n){try{return{type:"normal",arg:e.call(t,n)}}catch(e){return{type:"throw",arg:e}}}function x(){}function C(){}function N(){}function B(e){["next","throw","return"].forEach(function(t){e[t]=function(e){return this._invoke(t,e)}})}function L(e){var t;this._invoke=function(n,r){function a(){return new Promise(function(t,a){!function t(n,r,a,i){var c=w(e[n],e,r);if("throw"!==c.type){var d=c.arg,l=d.value;return l&&"object"==typeof l&&o.call(l,"__await")?Promise.resolve(l.__await).then(function(e){t("next",e,a,i)},function(e){t("throw",e,a,i)}):Promise.resolve(l).then(function(e){d.value=e,a(d)},i)}i(c.arg)}(n,r,t,a)})}return t=t?t.then(a,a):a()}}function O(e,t){var r=e.iterator[t.method];if(r===n){if(t.delegate=null,"throw"===t.method){if(e.iterator.return&&(t.method="return",t.arg=n,O(e,t),"throw"===t.method))return v;t.method="throw",t.arg=new TypeError("The iterator does not provide a 'throw' method")}return v}var o=w(r,e.iterator,t.arg);if("throw"===o.type)return t.method="throw",t.arg=o.arg,t.delegate=null,v;var a=o.arg;return a?a.done?(t[e.resultName]=a.value,t.next=e.nextLoc,"return"!==t.method&&(t.method="next",t.arg=n),t.delegate=null,v):a:(t.method="throw",t.arg=new TypeError("iterator result is not an object"),t.delegate=null,v)}function I(e){var t={tryLoc:e[0]};1 in e&&(t.catchLoc=e[1]),2 in e&&(t.finallyLoc=e[2],t.afterLoc=e[3]),this.tryEntries.push(t)}function T(e){var t=e.completion||{};t.type="normal",delete t.arg,e.completion=t}function _(e){this.tryEntries=[{tryLoc:"root"}],e.forEach(I,this),this.reset(!0)}function F(e){if(e){var t=e[i];if(t)return t.call(e);if("function"==typeof e.next)return e;if(!isNaN(e.length)){var r=-1,a=function t(){for(;++r<e.length;)if(o.call(e,r))return t.value=e[r],t.done=!1,t;return t.value=n,t.done=!0,t};return a.next=a}}return{next:M}}function M(){return{value:n,done:!0}}}(function(){return this}()||Function("return this")())}});
=======
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
/******/ 	return __webpack_require__(__webpack_require__.s = 103);
/******/ })
/************************************************************************/
/******/ ({

/***/ 103:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(104);


/***/ }),

/***/ 104:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _regenerator = __webpack_require__(16);

var _regenerator2 = _interopRequireDefault(_regenerator);

var _slicedToArray = function () { function sliceIterator(arr, i) { var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"]) _i["return"](); } finally { if (_d) throw _e; } } return _arr; } return function (arr, i) { if (Array.isArray(arr)) { return arr; } else if (Symbol.iterator in Object(arr)) { return sliceIterator(arr, i); } else { throw new TypeError("Invalid attempt to destructure non-iterable instance"); } }; }();

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _asyncToGenerator(fn) { return function () { var gen = fn.apply(this, arguments); return new Promise(function (resolve, reject) { function step(key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { return Promise.resolve(value).then(function (value) { step("next", value); }, function (err) { step("throw", err); }); } } return step("next"); }); }; }

function buildDropdowns(tableName, menu) {
    var jsTable = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : "Form";
    var octothorp = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : false;

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

    var dataLabel = document.createElement("LABEL");
    dataLabel.setAttribute("for", menu + tableName + jsTable);
    var lowerCaseTitle = tableName.split("_").join(" ");
    if (octothorp) {
        dataLabel.textContent = '#';
    } else {
        dataLabel.textContent = lowerCaseTitle.charAt(0).toUpperCase() + lowerCaseTitle.slice(1);
    }
    dataLabel.className = "dropDownTitles";

    var dataSelect = document.createElement("td");
    dataSelect.appendChild(selectList);

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
        if (tableName == 'datos') {
            myTBody.append(newTR);
        } else {
            myTBody.prepend(newTR);
        }
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
    if (tableName === "medicion") {
        myId = "measurementmedicionMedicion";
    };
    if (tableName === "linea_mtp") myId = "measurementlinea_mtpSelect";
    if (tableName === "municipio") {
        withNuevo = false;
        var newmuninames = muninames.map(function (muniname) {
            return muniname['nomgeo'];
        });
        completetitlevallist[tableName] = newmuninames;
    };

    if (!!document.getElementById(myId)) {
        "row" + numRows + tableName + "Form";
        var mySelection = document.getElementById(myId);
        if (tableName.split('_')[0] === "observacion") tableName = tableName.replace("observacion", "especie");

        var mycurrentlist = completetitlevallist[tableName];
        mycurrentlist = tableName === "observaciones" ? ['ave', 'arbol', 'arbusto', 'mamifero', 'herpetofauna', 'hierba'] : mycurrentlist;

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
                if (tableName != 'medicion' || mycurrentlist[_i].split('*')[0] == document.getElementById('measurementlinea_mtpSelect').value.split(' (')[0]) {
                    elOption = frag.appendChild(document.createElement('option'));
                    elOption.value = mycurrentlist[_i];
                    elOption.innerHTML = mycurrentlist[_i];
                }
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
        if (a.indexOf('omienzo') !== -1) return -1;
        if (b.indexOf('omienzo') !== -1) return 1;
        if (a.indexOf('long') !== -1) return -1;
        if (b.indexOf('long') !== -1) return 1;
        if (a.indexOf('lat') !== -1) return -1;
        if (b.indexOf('lat') !== -1) return 1;
        if (a.indexOf('hora') !== -1) return -1;
        if (b.indexOf('hora') !== -1) return 1;
        if (a.indexOf('fecha') !== -1) return -1;
        if (b.indexOf('fecha') !== -1) return 1;
        if (a.indexOf('sexo') !== -1) return -1;
        if (b.indexOf('sexo') !== -1) return 1;
        if (a.indexOf('estadio') !== -1) return -1;
        if (b.indexOf('estadio') !== -1) return 1;
        if (a.indexOf('actividad') !== -1) return -1;
        if (b.indexOf('actividad') !== -1) return 1;
        if (a.indexOf('distancia') !== -1) return -1;
        if (b.indexOf('distancia') !== -1) return 1;
        if (a.indexOf('azimut') !== -1) return -1;
        if (b.indexOf('azimut') !== -1) return 1;
        if (a.indexOf('altura') !== -1) return -1;
        if (b.indexOf('altura') !== -1) return 1;
        if (a.indexOf('dn') !== -1) return -1;
        if (b.indexOf('dn') !== -1) return 1;
        if (a.indexOf('dc1') !== -1) return -1;
        if (b.indexOf('dc1') !== -1) return 1;
        if (a.indexOf('dc2') !== -1) return -1;
        if (b.indexOf('dc2') !== -1) return 1;

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
            //
            var cuadnumLabel = document.createElement("td");
            cuadnumLabel.textContent = "#";
            cuadnumLabel.className = "formcolumnlabels octothorp";
            var cuadnumBox = document.createElement("td");
            var cuadnumInput = document.createElement("INPUT");
            cuadnumInput.setAttribute("type", "text");
            cuadnumInput.name = "row" + myNumRow + '*' + tableName + '*cuadnum';
            cuadnumInput.id = "row" + myNumRow + "cuadnum";
            cuadnumInput.value = 1;
            cuadnumInput.className = "cuadranteinput";
            cuadnumBox.appendChild(cuadnumInput);
            cuadnumBox.className = "cuadrante";
            columnRowOld.appendChild(cuadnumLabel);
            firstDataRow.appendChild(cuadnumBox);
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
    mySubmit.className = "mySubmit p-2 m-2";
    mySubmit.value = 'Enviar';
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
                mySelectionPunto.addEventListener('change', function () {
                    clearForm('', "Form");
                });
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
            var octothorp = myChoice == 'observacion_hierba' ? true : false;
            buildDropdowns(transpunto, menu, "Numero", octothorp);
            var mySelection = document.getElementById('measurement' + transpunto + 'Numero');
            mySelection.addEventListener('change', function () {
                clearForm('', "Form");
            });
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

            var readybutton = document.createElement("button");
            readybutton.textContent = 'Cargar Formulario';
            readybutton.className = 'p-2 m-2 cargarformulario';
            readybutton.type = "button";
            readybutton.id = "readybutton";
            readybutton.addEventListener('click', clickReadyButton);
            //readybutton.onclick=function(){return clickReadyButton() }; 

            var myTBody = document.getElementById("measurementTBodyNumero");
            myTBody.append(readybutton);
        }
    };
    var currentOnChange3 = function currentOnChange3(tableName, menu) {
        currentFunction3(tableName, menu);
    };
    getSelection.onchange = currentOnChange3;
}

//////////////////////////////////////////////////////////////////////////////////////          


function clickReadyButton(e) {
    var getData = function () {
        var _ref = _asyncToGenerator( /*#__PURE__*/_regenerator2.default.mark(function _callee() {
            var myapi, rawResponse, dataResult;
            return _regenerator2.default.wrap(function _callee$(_context) {
                while (1) {
                    switch (_context.prev = _context.next) {
                        case 0:
                            myapi = 'http://localhost:3000/api/getudp';
                            //let myapi ='https://biodiversidadpuebla.online/api/getudp'

                            _context.next = 3;
                            return fetch(myapi, {
                                method: 'POST',
                                headers: {
                                    'Accept': 'application/json',
                                    "Content-Type": "application/json;"
                                },
                                body: JSON.stringify({
                                    "lineamtp": document.getElementById("measurementlinea_mtpSelect").value,
                                    "medicion": document.getElementById("measurementmedicionMedicion").value,
                                    "observacion": myChoice,
                                    "punto": selectedPunto ? selectedPunto.value : "0",
                                    "transecto": selectedTransecto ? selectedTransecto.value : "0",
                                    "useremail": useremail
                                })
                            });

                        case 3:
                            rawResponse = _context.sent;
                            _context.next = 6;
                            return rawResponse.json();

                        case 6:
                            dataResult = _context.sent;
                            return _context.abrupt("return", dataResult);

                        case 8:
                        case "end":
                            return _context.stop();
                    }
                }
            }, _callee, this);
        }));

        return function getData() {
            return _ref.apply(this, arguments);
        };
    }();

    //document.getElementById("readybutton").disabled='true'
    var menu = "measurement";
    var myChoice = 'observacion_' + document.getElementById("measurementobservacionesObservaciones").value;
    var newExist = document.getElementById("measurementdatosNumero");
    var selectedPunto = document.getElementById("measurementPuntoNumero");
    var selectedTransecto = document.getElementById("measurementTransectoNumero");
    var selectedlinea_mtp = document.getElementById("measurementlinea_mtpSelect");
    var selectedmedicion = document.getElementById("measurementmedicionMedicion");
    if (selectedlinea_mtp && selectedlinea_mtp.value == 'notselected') {
        alert('Elige Linea MTP');
        return;
    }
    if (selectedPunto && selectedPunto.value == 'notselected') {
        alert('Elige Punto');
        return;
    }
    if (selectedmedicion && selectedmedicion.value == 'notselected') {
        alert('Elige Medicion');
        return;
    }
    if (selectedTransecto && selectedTransecto.value == 'notselected') {
        alert('Elige Transecto');
        return;
    }

    if (e.offsetX > 0) {
        getData().then(function (dataResult) {
            clearForm(menu, "Form");
            if (dataResult[0].length > 0) {
                var myTBody = document.getElementById(menu + "TBody" + 'Form');
                var hiddenLocation = document.createElement('input');
                hiddenLocation.setAttribute("type", "hidden");
                hiddenLocation.name = 'hiddenlocation';
                hiddenLocation.value = dataResult[0][0]['iden'];
                hiddenLocation.id = 'hiddenlocation';
                myTBody.append(hiddenLocation);

                buildCustomForm(myChoice, menu, 'Datos Existentes');
                var formtranspunto = 'punto';
                if (myChoice.includes('hierba') || myChoice.includes('herpetofauna')) {
                    formtranspunto = 'transecto';
                }
                var lifeForm = document.getElementById("measurementobservacionesObservaciones").value;
                var puntoEntries = Object.entries(dataResult[0][0]);
                var _iteratorNormalCompletion = true;
                var _didIteratorError = false;
                var _iteratorError = undefined;

                try {
                    for (var _iterator = puntoEntries[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
                        var _ref2 = _step.value;

                        var _ref3 = _slicedToArray(_ref2, 2);

                        var cat = _ref3[0];
                        var val = _ref3[1];

                        var myElem = document.getElementById(formtranspunto + "_" + lifeForm + cat);
                        if (myElem) {
                            myElem.value = val;
                        }
                    }
                } catch (err) {
                    _didIteratorError = true;
                    _iteratorError = err;
                } finally {
                    try {
                        if (!_iteratorNormalCompletion && _iterator.return) {
                            _iterator.return();
                        }
                    } finally {
                        if (_didIteratorError) {
                            throw _iteratorError;
                        }
                    }
                }

                dataResult[1].forEach(function (row, ind) {
                    if (ind > 0) {
                        //make new row
                        var getSelectionAdd = document.getElementById("addElementRow" + myChoice);
                        if (!myChoice.includes('arbol') && !myChoice.includes('arbusto')) {
                            getSelectionAdd.onclick();
                        }
                    }
                    var obsEntries = Object.entries(row);
                    var _iteratorNormalCompletion2 = true;
                    var _didIteratorError2 = false;
                    var _iteratorError2 = undefined;

                    try {
                        for (var _iterator2 = obsEntries[Symbol.iterator](), _step2; !(_iteratorNormalCompletion2 = (_step2 = _iterator2.next()).done); _iteratorNormalCompletion2 = true) {
                            var _ref4 = _step2.value;

                            var _ref5 = _slicedToArray(_ref4, 2);

                            var _cat = _ref5[0];
                            var _val = _ref5[1];

                            if (_cat == 'comun_cientifico') {
                                var myElemSpecies = document.getElementsByName("row" + ind + "*" + myChoice + "*species");
                                myElemSpecies[0].value = _val;
                            }
                            var myElem = document.getElementsByName("row" + ind + "*" + myChoice + "*" + _cat);
                            if (myElem[0]) {
                                myElem[0].value = _val;
                            }
                        }
                    } catch (err) {
                        _didIteratorError2 = true;
                        _iteratorError2 = err;
                    } finally {
                        try {
                            if (!_iteratorNormalCompletion2 && _iterator2.return) {
                                _iterator2.return();
                            }
                        } finally {
                            if (_didIteratorError2) {
                                throw _iteratorError2;
                            }
                        }
                    }
                });
            } else {
                buildCustomForm(myChoice, menu, 'Datos Nuevos');
            }
        });
    } else {
        if (newold == 'Datos Nuevos') {
            buildCustomForm(myChoice, menu, 'Datos Nuevos');
        } else {
            buildCustomForm(myChoice, menu, 'Datos Existentes');

            var myTBody = document.getElementById(menu + "TBody" + 'Form');
            var hiddenLocation = document.createElement('input');
            hiddenLocation.setAttribute("type", "hidden");
            hiddenLocation.name = 'hiddenlocation';
            hiddenLocation.value = hiddenlocationvalue;
            hiddenLocation.id = 'hiddenlocation';
            myTBody.append(hiddenLocation);
        }
    }
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

function buildCustomForm(obName, menu, mode) {
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
            var getCuadnum = document.getElementById("row" + (i + 1) + "cuadnum");
            getCuadnum.value = i + 2;
            getCuadnum.setAttribute("readonly", true);
        }
        numRows = 0;
        getSelectionAdd.disabled = true;
        getSelectionSubtract.disabled = true;
    }
    var myTBody = document.getElementById(menu + "TBody" + 'Form');
    var datosField = document.createElement('input');
    datosField.setAttribute("type", "text");
    datosField.name = 'mode';
    datosField.value = mode;
    datosField.id = 'mode';
    datosField.className = 'btn modeButton text-dark text-center';
    datosField.setAttribute("readonly", true);
    myTBody.prepend(datosField);
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

/***/ }),

/***/ 16:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(17);


/***/ }),

/***/ 17:
/***/ (function(module, exports, __webpack_require__) {

/**
 * Copyright (c) 2014-present, Facebook, Inc.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

// This method of obtaining a reference to the global object needs to be
// kept identical to the way it is obtained in runtime.js
var g = (function() { return this })() || Function("return this")();

// Use `getOwnPropertyNames` because not all browsers support calling
// `hasOwnProperty` on the global `self` object in a worker. See #183.
var hadRuntime = g.regeneratorRuntime &&
  Object.getOwnPropertyNames(g).indexOf("regeneratorRuntime") >= 0;

// Save the old regeneratorRuntime in case it needs to be restored later.
var oldRuntime = hadRuntime && g.regeneratorRuntime;

// Force reevalutation of runtime.js.
g.regeneratorRuntime = undefined;

module.exports = __webpack_require__(18);

if (hadRuntime) {
  // Restore the original runtime.
  g.regeneratorRuntime = oldRuntime;
} else {
  // Remove the global property added by runtime.js.
  try {
    delete g.regeneratorRuntime;
  } catch(e) {
    g.regeneratorRuntime = undefined;
  }
}


/***/ }),

/***/ 18:
/***/ (function(module, exports) {

/**
 * Copyright (c) 2014-present, Facebook, Inc.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

!(function(global) {
  "use strict";

  var Op = Object.prototype;
  var hasOwn = Op.hasOwnProperty;
  var undefined; // More compressible than void 0.
  var $Symbol = typeof Symbol === "function" ? Symbol : {};
  var iteratorSymbol = $Symbol.iterator || "@@iterator";
  var asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator";
  var toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag";

  var inModule = typeof module === "object";
  var runtime = global.regeneratorRuntime;
  if (runtime) {
    if (inModule) {
      // If regeneratorRuntime is defined globally and we're in a module,
      // make the exports object identical to regeneratorRuntime.
      module.exports = runtime;
    }
    // Don't bother evaluating the rest of this file if the runtime was
    // already defined globally.
    return;
  }

  // Define the runtime globally (as expected by generated code) as either
  // module.exports (if we're in a module) or a new, empty object.
  runtime = global.regeneratorRuntime = inModule ? module.exports : {};

  function wrap(innerFn, outerFn, self, tryLocsList) {
    // If outerFn provided and outerFn.prototype is a Generator, then outerFn.prototype instanceof Generator.
    var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator;
    var generator = Object.create(protoGenerator.prototype);
    var context = new Context(tryLocsList || []);

    // The ._invoke method unifies the implementations of the .next,
    // .throw, and .return methods.
    generator._invoke = makeInvokeMethod(innerFn, self, context);

    return generator;
  }
  runtime.wrap = wrap;

  // Try/catch helper to minimize deoptimizations. Returns a completion
  // record like context.tryEntries[i].completion. This interface could
  // have been (and was previously) designed to take a closure to be
  // invoked without arguments, but in all the cases we care about we
  // already have an existing method we want to call, so there's no need
  // to create a new function object. We can even get away with assuming
  // the method takes exactly one argument, since that happens to be true
  // in every case, so we don't have to touch the arguments object. The
  // only additional allocation required is the completion record, which
  // has a stable shape and so hopefully should be cheap to allocate.
  function tryCatch(fn, obj, arg) {
    try {
      return { type: "normal", arg: fn.call(obj, arg) };
    } catch (err) {
      return { type: "throw", arg: err };
    }
  }

  var GenStateSuspendedStart = "suspendedStart";
  var GenStateSuspendedYield = "suspendedYield";
  var GenStateExecuting = "executing";
  var GenStateCompleted = "completed";

  // Returning this object from the innerFn has the same effect as
  // breaking out of the dispatch switch statement.
  var ContinueSentinel = {};

  // Dummy constructor functions that we use as the .constructor and
  // .constructor.prototype properties for functions that return Generator
  // objects. For full spec compliance, you may wish to configure your
  // minifier not to mangle the names of these two functions.
  function Generator() {}
  function GeneratorFunction() {}
  function GeneratorFunctionPrototype() {}

  // This is a polyfill for %IteratorPrototype% for environments that
  // don't natively support it.
  var IteratorPrototype = {};
  IteratorPrototype[iteratorSymbol] = function () {
    return this;
  };

  var getProto = Object.getPrototypeOf;
  var NativeIteratorPrototype = getProto && getProto(getProto(values([])));
  if (NativeIteratorPrototype &&
      NativeIteratorPrototype !== Op &&
      hasOwn.call(NativeIteratorPrototype, iteratorSymbol)) {
    // This environment has a native %IteratorPrototype%; use it instead
    // of the polyfill.
    IteratorPrototype = NativeIteratorPrototype;
  }

  var Gp = GeneratorFunctionPrototype.prototype =
    Generator.prototype = Object.create(IteratorPrototype);
  GeneratorFunction.prototype = Gp.constructor = GeneratorFunctionPrototype;
  GeneratorFunctionPrototype.constructor = GeneratorFunction;
  GeneratorFunctionPrototype[toStringTagSymbol] =
    GeneratorFunction.displayName = "GeneratorFunction";

  // Helper for defining the .next, .throw, and .return methods of the
  // Iterator interface in terms of a single ._invoke method.
  function defineIteratorMethods(prototype) {
    ["next", "throw", "return"].forEach(function(method) {
      prototype[method] = function(arg) {
        return this._invoke(method, arg);
      };
    });
  }

  runtime.isGeneratorFunction = function(genFun) {
    var ctor = typeof genFun === "function" && genFun.constructor;
    return ctor
      ? ctor === GeneratorFunction ||
        // For the native GeneratorFunction constructor, the best we can
        // do is to check its .name property.
        (ctor.displayName || ctor.name) === "GeneratorFunction"
      : false;
  };

  runtime.mark = function(genFun) {
    if (Object.setPrototypeOf) {
      Object.setPrototypeOf(genFun, GeneratorFunctionPrototype);
    } else {
      genFun.__proto__ = GeneratorFunctionPrototype;
      if (!(toStringTagSymbol in genFun)) {
        genFun[toStringTagSymbol] = "GeneratorFunction";
      }
    }
    genFun.prototype = Object.create(Gp);
    return genFun;
  };

  // Within the body of any async function, `await x` is transformed to
  // `yield regeneratorRuntime.awrap(x)`, so that the runtime can test
  // `hasOwn.call(value, "__await")` to determine if the yielded value is
  // meant to be awaited.
  runtime.awrap = function(arg) {
    return { __await: arg };
  };

  function AsyncIterator(generator) {
    function invoke(method, arg, resolve, reject) {
      var record = tryCatch(generator[method], generator, arg);
      if (record.type === "throw") {
        reject(record.arg);
      } else {
        var result = record.arg;
        var value = result.value;
        if (value &&
            typeof value === "object" &&
            hasOwn.call(value, "__await")) {
          return Promise.resolve(value.__await).then(function(value) {
            invoke("next", value, resolve, reject);
          }, function(err) {
            invoke("throw", err, resolve, reject);
          });
        }

        return Promise.resolve(value).then(function(unwrapped) {
          // When a yielded Promise is resolved, its final value becomes
          // the .value of the Promise<{value,done}> result for the
          // current iteration. If the Promise is rejected, however, the
          // result for this iteration will be rejected with the same
          // reason. Note that rejections of yielded Promises are not
          // thrown back into the generator function, as is the case
          // when an awaited Promise is rejected. This difference in
          // behavior between yield and await is important, because it
          // allows the consumer to decide what to do with the yielded
          // rejection (swallow it and continue, manually .throw it back
          // into the generator, abandon iteration, whatever). With
          // await, by contrast, there is no opportunity to examine the
          // rejection reason outside the generator function, so the
          // only option is to throw it from the await expression, and
          // let the generator function handle the exception.
          result.value = unwrapped;
          resolve(result);
        }, reject);
      }
    }

    var previousPromise;

    function enqueue(method, arg) {
      function callInvokeWithMethodAndArg() {
        return new Promise(function(resolve, reject) {
          invoke(method, arg, resolve, reject);
        });
      }

      return previousPromise =
        // If enqueue has been called before, then we want to wait until
        // all previous Promises have been resolved before calling invoke,
        // so that results are always delivered in the correct order. If
        // enqueue has not been called before, then it is important to
        // call invoke immediately, without waiting on a callback to fire,
        // so that the async generator function has the opportunity to do
        // any necessary setup in a predictable way. This predictability
        // is why the Promise constructor synchronously invokes its
        // executor callback, and why async functions synchronously
        // execute code before the first await. Since we implement simple
        // async functions in terms of async generators, it is especially
        // important to get this right, even though it requires care.
        previousPromise ? previousPromise.then(
          callInvokeWithMethodAndArg,
          // Avoid propagating failures to Promises returned by later
          // invocations of the iterator.
          callInvokeWithMethodAndArg
        ) : callInvokeWithMethodAndArg();
    }

    // Define the unified helper method that is used to implement .next,
    // .throw, and .return (see defineIteratorMethods).
    this._invoke = enqueue;
  }

  defineIteratorMethods(AsyncIterator.prototype);
  AsyncIterator.prototype[asyncIteratorSymbol] = function () {
    return this;
  };
  runtime.AsyncIterator = AsyncIterator;

  // Note that simple async functions are implemented on top of
  // AsyncIterator objects; they just return a Promise for the value of
  // the final result produced by the iterator.
  runtime.async = function(innerFn, outerFn, self, tryLocsList) {
    var iter = new AsyncIterator(
      wrap(innerFn, outerFn, self, tryLocsList)
    );

    return runtime.isGeneratorFunction(outerFn)
      ? iter // If outerFn is a generator, return the full iterator.
      : iter.next().then(function(result) {
          return result.done ? result.value : iter.next();
        });
  };

  function makeInvokeMethod(innerFn, self, context) {
    var state = GenStateSuspendedStart;

    return function invoke(method, arg) {
      if (state === GenStateExecuting) {
        throw new Error("Generator is already running");
      }

      if (state === GenStateCompleted) {
        if (method === "throw") {
          throw arg;
        }

        // Be forgiving, per 25.3.3.3.3 of the spec:
        // https://people.mozilla.org/~jorendorff/es6-draft.html#sec-generatorresume
        return doneResult();
      }

      context.method = method;
      context.arg = arg;

      while (true) {
        var delegate = context.delegate;
        if (delegate) {
          var delegateResult = maybeInvokeDelegate(delegate, context);
          if (delegateResult) {
            if (delegateResult === ContinueSentinel) continue;
            return delegateResult;
          }
        }

        if (context.method === "next") {
          // Setting context._sent for legacy support of Babel's
          // function.sent implementation.
          context.sent = context._sent = context.arg;

        } else if (context.method === "throw") {
          if (state === GenStateSuspendedStart) {
            state = GenStateCompleted;
            throw context.arg;
          }

          context.dispatchException(context.arg);

        } else if (context.method === "return") {
          context.abrupt("return", context.arg);
        }

        state = GenStateExecuting;

        var record = tryCatch(innerFn, self, context);
        if (record.type === "normal") {
          // If an exception is thrown from innerFn, we leave state ===
          // GenStateExecuting and loop back for another invocation.
          state = context.done
            ? GenStateCompleted
            : GenStateSuspendedYield;

          if (record.arg === ContinueSentinel) {
            continue;
          }

          return {
            value: record.arg,
            done: context.done
          };

        } else if (record.type === "throw") {
          state = GenStateCompleted;
          // Dispatch the exception by looping back around to the
          // context.dispatchException(context.arg) call above.
          context.method = "throw";
          context.arg = record.arg;
        }
      }
    };
  }

  // Call delegate.iterator[context.method](context.arg) and handle the
  // result, either by returning a { value, done } result from the
  // delegate iterator, or by modifying context.method and context.arg,
  // setting context.delegate to null, and returning the ContinueSentinel.
  function maybeInvokeDelegate(delegate, context) {
    var method = delegate.iterator[context.method];
    if (method === undefined) {
      // A .throw or .return when the delegate iterator has no .throw
      // method always terminates the yield* loop.
      context.delegate = null;

      if (context.method === "throw") {
        if (delegate.iterator.return) {
          // If the delegate iterator has a return method, give it a
          // chance to clean up.
          context.method = "return";
          context.arg = undefined;
          maybeInvokeDelegate(delegate, context);

          if (context.method === "throw") {
            // If maybeInvokeDelegate(context) changed context.method from
            // "return" to "throw", let that override the TypeError below.
            return ContinueSentinel;
          }
        }

        context.method = "throw";
        context.arg = new TypeError(
          "The iterator does not provide a 'throw' method");
      }

      return ContinueSentinel;
    }

    var record = tryCatch(method, delegate.iterator, context.arg);

    if (record.type === "throw") {
      context.method = "throw";
      context.arg = record.arg;
      context.delegate = null;
      return ContinueSentinel;
    }

    var info = record.arg;

    if (! info) {
      context.method = "throw";
      context.arg = new TypeError("iterator result is not an object");
      context.delegate = null;
      return ContinueSentinel;
    }

    if (info.done) {
      // Assign the result of the finished delegate to the temporary
      // variable specified by delegate.resultName (see delegateYield).
      context[delegate.resultName] = info.value;

      // Resume execution at the desired location (see delegateYield).
      context.next = delegate.nextLoc;

      // If context.method was "throw" but the delegate handled the
      // exception, let the outer generator proceed normally. If
      // context.method was "next", forget context.arg since it has been
      // "consumed" by the delegate iterator. If context.method was
      // "return", allow the original .return call to continue in the
      // outer generator.
      if (context.method !== "return") {
        context.method = "next";
        context.arg = undefined;
      }

    } else {
      // Re-yield the result returned by the delegate method.
      return info;
    }

    // The delegate iterator is finished, so forget it and continue with
    // the outer generator.
    context.delegate = null;
    return ContinueSentinel;
  }

  // Define Generator.prototype.{next,throw,return} in terms of the
  // unified ._invoke helper method.
  defineIteratorMethods(Gp);

  Gp[toStringTagSymbol] = "Generator";

  // A Generator should always return itself as the iterator object when the
  // @@iterator function is called on it. Some browsers' implementations of the
  // iterator prototype chain incorrectly implement this, causing the Generator
  // object to not be returned from this call. This ensures that doesn't happen.
  // See https://github.com/facebook/regenerator/issues/274 for more details.
  Gp[iteratorSymbol] = function() {
    return this;
  };

  Gp.toString = function() {
    return "[object Generator]";
  };

  function pushTryEntry(locs) {
    var entry = { tryLoc: locs[0] };

    if (1 in locs) {
      entry.catchLoc = locs[1];
    }

    if (2 in locs) {
      entry.finallyLoc = locs[2];
      entry.afterLoc = locs[3];
    }

    this.tryEntries.push(entry);
  }

  function resetTryEntry(entry) {
    var record = entry.completion || {};
    record.type = "normal";
    delete record.arg;
    entry.completion = record;
  }

  function Context(tryLocsList) {
    // The root entry object (effectively a try statement without a catch
    // or a finally block) gives us a place to store values thrown from
    // locations where there is no enclosing try statement.
    this.tryEntries = [{ tryLoc: "root" }];
    tryLocsList.forEach(pushTryEntry, this);
    this.reset(true);
  }

  runtime.keys = function(object) {
    var keys = [];
    for (var key in object) {
      keys.push(key);
    }
    keys.reverse();

    // Rather than returning an object with a next method, we keep
    // things simple and return the next function itself.
    return function next() {
      while (keys.length) {
        var key = keys.pop();
        if (key in object) {
          next.value = key;
          next.done = false;
          return next;
        }
      }

      // To avoid creating an additional object, we just hang the .value
      // and .done properties off the next function object itself. This
      // also ensures that the minifier will not anonymize the function.
      next.done = true;
      return next;
    };
  };

  function values(iterable) {
    if (iterable) {
      var iteratorMethod = iterable[iteratorSymbol];
      if (iteratorMethod) {
        return iteratorMethod.call(iterable);
      }

      if (typeof iterable.next === "function") {
        return iterable;
      }

      if (!isNaN(iterable.length)) {
        var i = -1, next = function next() {
          while (++i < iterable.length) {
            if (hasOwn.call(iterable, i)) {
              next.value = iterable[i];
              next.done = false;
              return next;
            }
          }

          next.value = undefined;
          next.done = true;

          return next;
        };

        return next.next = next;
      }
    }

    // Return an iterator with no values.
    return { next: doneResult };
  }
  runtime.values = values;

  function doneResult() {
    return { value: undefined, done: true };
  }

  Context.prototype = {
    constructor: Context,

    reset: function(skipTempReset) {
      this.prev = 0;
      this.next = 0;
      // Resetting context._sent for legacy support of Babel's
      // function.sent implementation.
      this.sent = this._sent = undefined;
      this.done = false;
      this.delegate = null;

      this.method = "next";
      this.arg = undefined;

      this.tryEntries.forEach(resetTryEntry);

      if (!skipTempReset) {
        for (var name in this) {
          // Not sure about the optimal order of these conditions:
          if (name.charAt(0) === "t" &&
              hasOwn.call(this, name) &&
              !isNaN(+name.slice(1))) {
            this[name] = undefined;
          }
        }
      }
    },

    stop: function() {
      this.done = true;

      var rootEntry = this.tryEntries[0];
      var rootRecord = rootEntry.completion;
      if (rootRecord.type === "throw") {
        throw rootRecord.arg;
      }

      return this.rval;
    },

    dispatchException: function(exception) {
      if (this.done) {
        throw exception;
      }

      var context = this;
      function handle(loc, caught) {
        record.type = "throw";
        record.arg = exception;
        context.next = loc;

        if (caught) {
          // If the dispatched exception was caught by a catch block,
          // then let that catch block handle the exception normally.
          context.method = "next";
          context.arg = undefined;
        }

        return !! caught;
      }

      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        var record = entry.completion;

        if (entry.tryLoc === "root") {
          // Exception thrown outside of any try block that could handle
          // it, so set the completion value of the entire function to
          // throw the exception.
          return handle("end");
        }

        if (entry.tryLoc <= this.prev) {
          var hasCatch = hasOwn.call(entry, "catchLoc");
          var hasFinally = hasOwn.call(entry, "finallyLoc");

          if (hasCatch && hasFinally) {
            if (this.prev < entry.catchLoc) {
              return handle(entry.catchLoc, true);
            } else if (this.prev < entry.finallyLoc) {
              return handle(entry.finallyLoc);
            }

          } else if (hasCatch) {
            if (this.prev < entry.catchLoc) {
              return handle(entry.catchLoc, true);
            }

          } else if (hasFinally) {
            if (this.prev < entry.finallyLoc) {
              return handle(entry.finallyLoc);
            }

          } else {
            throw new Error("try statement without catch or finally");
          }
        }
      }
    },

    abrupt: function(type, arg) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.tryLoc <= this.prev &&
            hasOwn.call(entry, "finallyLoc") &&
            this.prev < entry.finallyLoc) {
          var finallyEntry = entry;
          break;
        }
      }

      if (finallyEntry &&
          (type === "break" ||
           type === "continue") &&
          finallyEntry.tryLoc <= arg &&
          arg <= finallyEntry.finallyLoc) {
        // Ignore the finally entry if control is not jumping to a
        // location outside the try/catch block.
        finallyEntry = null;
      }

      var record = finallyEntry ? finallyEntry.completion : {};
      record.type = type;
      record.arg = arg;

      if (finallyEntry) {
        this.method = "next";
        this.next = finallyEntry.finallyLoc;
        return ContinueSentinel;
      }

      return this.complete(record);
    },

    complete: function(record, afterLoc) {
      if (record.type === "throw") {
        throw record.arg;
      }

      if (record.type === "break" ||
          record.type === "continue") {
        this.next = record.arg;
      } else if (record.type === "return") {
        this.rval = this.arg = record.arg;
        this.method = "return";
        this.next = "end";
      } else if (record.type === "normal" && afterLoc) {
        this.next = afterLoc;
      }

      return ContinueSentinel;
    },

    finish: function(finallyLoc) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.finallyLoc === finallyLoc) {
          this.complete(entry.completion, entry.afterLoc);
          resetTryEntry(entry);
          return ContinueSentinel;
        }
      }
    },

    "catch": function(tryLoc) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.tryLoc === tryLoc) {
          var record = entry.completion;
          if (record.type === "throw") {
            var thrown = record.arg;
            resetTryEntry(entry);
          }
          return thrown;
        }
      }

      // The context.catch method must only be called with a location
      // argument that corresponds to a known catch block.
      throw new Error("illegal catch attempt");
    },

    delegateYield: function(iterable, resultName, nextLoc) {
      this.delegate = {
        iterator: values(iterable),
        resultName: resultName,
        nextLoc: nextLoc
      };

      if (this.method === "next") {
        // Deliberately forget the last sent value so that we don't
        // accidentally pass it on to the delegate.
        this.arg = undefined;
      }

      return ContinueSentinel;
    }
  };
})(
  // In sloppy mode, unbound `this` refers to the global object, fallback to
  // Function constructor if we're in global strict mode. That is sadly a form
  // of indirect eval which violates Content Security Policy.
  (function() { return this })() || Function("return this")()
);


/***/ })

/******/ });
>>>>>>> editdata
