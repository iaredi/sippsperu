import React from "react";
import ReactDOM from "react-dom";
import Mapapp from "./components/Mapapp";
import Normaapp from "./components/Normaapp";
import Intersection from "./components/Intersection";
import UDPMapapp from "./components/udpMapapp";
import UpdateBuilder from "./components/UpdateBuilder";

import "../../leaflet_assets/leaflet.css";
import "../../leaflet_assets/images/marker-shadow.png";
import "../../leaflet_assets/images/marker-icon-2x.png";
const upstreamLinea = {estado:'nombre',municipio:'nombre',predio:'iden_muni_predio'}
const upstreamActividad = {estado:'nombre',municipio:'nombre'}
const actividadSelectObject={tipo:['','taller','platica', 'capacitacion','instalacion','reunion de coordinacion en torno', 'otro'],
    tipo_geom:['','punto','poligono']}
const upstreamCultivo = { estado: 'nombre', municipio: 'nombre' };
const cultivoSelectObject={ tipo: ['', 'parcela', 'terreno', 'jardin', 'otro'],
    tipo_geom:['','punto','poligono']}
const components = {
    udp: <UDPMapapp />,
    in: <Intersection />,
	normas: <Normaapp />,
	map: <Mapapp />,
	ae: <Normaapp />,
	linea:<UpdateBuilder
		table="linea_mtp"
		displayColumn='nombre_iden'
		upstreamTables={upstreamLinea}
		selectObject={{}}
	/>,
	actividad:<UpdateBuilder
		table="actividad"
		displayColumn='descripcion'
		upstreamTables={upstreamActividad}
		selectObject={actividadSelectObject}
		extra={true}
    />,
    cultivo:<UpdateBuilder
		table="cultivo"
		displayColumn='descripcion'
		upstreamTables={upstreamCultivo}
		selectObject={cultivoSelectObject}
		extra={true}
	/>,
};

['ave','arbol','arbusto','hierba','herpetofauna','mamifero'].forEach((lifeForm)=>{
	components[`especie_${lifeForm}`] = <UpdateBuilder
	table={`especie_${lifeForm}`}
	displayColumn='cientifico'
	upstreamTables={{}}
	selectObject={{}}
	exclusions={['comun_cientifico']}
	inclusions={['iden_cactus']}
/>

})

ReactDOM.render(components[infotype], document.getElementById("app"));
