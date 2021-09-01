<?php
    $sustancias=['Acetaldeído','Ácido sulfhídrico','Arsénico','Arsénico (compuestos)','Benceno','Bifenilos policlorados',
    'Bióxido de Carbono','Cadmio','Cadmio (compuestos)','Cianuro inorgánico/orgánico',
    'Cromo (compuestos)','Cromo (polvos respirables, humos o vapores)','Dioxinas','Formaldehído','Furanos',
    'Mercurio','Mercurio (compuestos)','Metano','Níquel (compuestos)','Níquel (polvos respirables, humos o vapores)',
    'Plomo (compuestos)','Plomo (polvos respirables, humos o vapores)','Xileno (mezcla de isómeros)'];
?>

<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">   
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="{{asset('css/index.css')}}">
        <script src="{{ asset('js/index.js') }}"></script>
        <title>TIM Biodiversidad</title>
        
    </head>
    <body>
        <div class="contenedor">
            <header></header>
            <nav>
                <div class="leftNav">
                </div>
                <div class="righNav">
                    <img src="{{asset('images/Gobierno-de-Puebla-color.png')}}" alt="" style="margin-right:2em;" />
                    <img src="{{asset('images/Secretaria-de-Medio-Ambiente-color.png')}}" alt="" style="margin-left:2em;" />
                </div>
            </nav>
            <section class="main left">
                <div class="titlePanel2">
                    <div class="info">
                        <i class="fas fa-info-circle"></i>
                        El presente subsistema se encuentra en construcción.
                        Se muestran los datos del registro de emisiones y tranferencia de contaminantes de orden federal.
                    </div>
                </div>
                <div class="linksPanel2">
                    
                    
                    <div class="">                 
                        <button class="accordion active">
                        <i class="fas fa-chevron-down"></i>
                            Lista de contaminantes
                        </button>
                        <div class="panel" style="display:block;">
                            <?php
                            foreach($sustancias as $i=>$sustancia){
                                echo '<div class="sustancia" id="'.($i+1).'">'.html_entity_decode($sustancia).'</div>';
                            }
                                
                            ?>
                        </div>

                        <button class="accordion">
                            <i class="fas fa-chevron-down"></i>
                            Lista completa del RETC
                        </button>
                        <div class="panel">
                            <div class="tituloTabla">
                                Fecha de actualización: 27/01/2020.<br />
                                Fuente: Secretaría de Medio Ambiente y Recursos Naturales.
                            </div>
                            
                            
                            <iframe src="https://docs.google.com/spreadsheets/d/e/2PACX-1vRUd9qhxflo_bO6NEWuRv8hXuAtEauKIpidt7MP80by6R-YUKQrMAq_bHi_x8QxTA/pubhtml?gid=505826790&amp;single=true&amp;widget=true&amp;headers=false"></iframe>
                            <a class="boton" href="{{ asset('../files/retc2018.xlsx') }}">
                                Descargar archivo
                            </a>
                        </div>

                    </div>                    
                </div>
            </section>
            <aside class="rightPanel">
                <div class="rightPanelContent content2">
                    <h3 style="text-align:center;">Municipios con Presencia de contaminantes</h3>
                    <img src="{{ asset('images/sustancias/Layout1.jpg') }}" alt="" style="width:80%;" id="imgLoader" />
                </div>
            </aside>
            <footer></footer>
        </div>


        <script>
            var acc = document.getElementsByClassName("accordion");
            var imgLinks = document.getElementsByClassName("sustancia");
            var i;
            var lastSelected=imgLinks[0];
            imgLinks[0].classList.toggle("activeSus");

            for (i = 0; i < acc.length; i++) {
                acc[i].addEventListener("click", function() {
                    this.classList.toggle("active");
                    var panel = this.nextElementSibling;
                    if (panel.style.display === "block") {
                        panel.style.display = "none";
                    } else {
                        panel.style.display = "block";
                    }
                });
            }

            for (i = 0; i < imgLinks.length; i++) {
                imgLinks[i].addEventListener("click", function() {
                    lastSelected.classList.remove('activeSus');
                    this.classList.toggle("activeSus");
                    lastSelected=this;
                    document.getElementById('imgLoader').src="../../../../images/sustancias/Layout"+this.id+".jpg";
                });
            }
        </script>

    </body>
</html>