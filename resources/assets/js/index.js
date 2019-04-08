import React from "react";
import ReactDOM from "react-dom";
import Mapapp from "./components/Mapapp";
import Normaapp from "./components/Normaapp";
import Intersection from "./components/Intersection";
import UDPMapapp from "./components/udpMapapp";
import Linea from "./components/Linea";

import "../../leaflet_assets/leaflet.css";
import "../../leaflet_assets/images/marker-shadow.png";
import "../../leaflet_assets/images/marker-icon-2x.png";

const components = {
    udp: <UDPMapapp />,
    in: <Intersection />,
	normas: <Normaapp />,
	map: <Mapapp />,
	ae: <Normaapp />,
	linea:<Linea />
};

ReactDOM.render(components[infotype], document.getElementById("app"));
