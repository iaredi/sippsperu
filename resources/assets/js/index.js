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
const upstreamLinea = {estado:'nombre',municipio:'nombre',predio:'nombre'}
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
	/>,
};

ReactDOM.render(components[infotype], document.getElementById("app"));
