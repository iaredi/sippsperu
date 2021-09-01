import React from "react";
//import BootstrapTable from 'react-bootstrap-table-next';

import UDPMapa from "./udpMapa";
import Legend from "./Legend";
import ParchesTable from "./ParchesTable";
import InfraTable from "./InfraTable";
import UdpTitle from "./UdpTitle";
import UdpDiversity from "./UdpDiversity";

class UDPMapapp extends React.Component {
	constructor(props) {
		super(props);
		this.setSoils = this.setSoils.bind(this);
		this.setInfra = this.setInfra.bind(this);
		this.setMuni = this.setMuni.bind(this);
		this.setStateBounds = this.setStateBounds.bind(this);
		this.setText = this.setText.bind(this);

		this.state = {
			mytext: "Cargando...",
			bounds: {
				_northEast: { lat: 1, lng: 1 },
				_southWest: { lat: 1, lng: 1 }
			},
			boundsobtained: false,
			soils: [{ color: "rgb:000", descripcio: "Cargando..." }],
			munilist: ["cargando..."],
			infraInfo: { infLength: -2, infCount: -1 },
			udpsoils: [{ color: "rgb:000", descripcio: "Cargando..." }]
		};
	}

	setText(mytext) {
		if (mytext != this.state.mytext) {
			this.setState({mytext: mytext});
		}
	}

	setSoils(soils, udpsoils) {
		if (soils != this.state.soils) {
			this.setState({soils: soils});
		}
		if (udpsoils != this.state.udpsoils) {
			this.setState({udpsoils: udpsoils});
		}
		if (!this.state.boundsobtained) {
			this.setState({boundsobtained: true});
		}
	}

	setInfra(infraInfo) {
		if (infraInfo != this.state.infraInfo) {
			this.setState({infraInfo: infraInfo});
		}
		if (!this.state.boundsobtained) {
			this.setState({boundsobtained: true});
		}
	}

	setMuni(munilist) {
		if (munilist != this.state.munilist) {
			this.setState({munilist: munilist});
		}
	}

	setStateBounds(bounds) {
		if (bounds != this.state.bounds) {
			this.setState({ bounds: bounds });
		}
	}

	render() {
		const shannonBoolean =
			shannon.split("*")[0] > 0 ||
			shannon.split("*")[1] > 0 ||
			shannon.split("*")[2] > 0 ||
			shannon.split("*")[3] > 0 ||
			shannon.split("*")[4] > 0 ||
			shannon.split("*")[5] > 0;
		const westernLongitude = this.state.bounds._southWest.lng.toPrecision( 6 );
		const easternLongitude = this.state.bounds._northEast.lng.toPrecision( 6 );
		const southernLatitude = this.state.bounds._southWest.lat.toPrecision( 6 );
		const northernLatitude = this.state.bounds._northEast.lat.toPrecision( 6 );

		return (
			<div>
				<div className="udplayout">
					<div id="bbtop">
						<span className="top left">
							{northernLatitude + ", " + westernLongitude}
						</span>
						<span className="top right">
							{northernLatitude + ", " + easternLongitude}
						</span>
					</div>
					<div id="udpmapdiv" className="border border-dark">
						<UDPMapa
							setStateBounds={this.setStateBounds}
							setSoils={this.setSoils}
							setInfra={this.setInfra}
							setMuni={this.setMuni}
						/>
					</div>

					<div id="bbbottom">
						<span className="bottom left">
							{southernLatitude + ", " + westernLongitude}
						</span>
						<span className="bottom right">
							{southernLatitude + ", " + easternLongitude}
						</span>
					</div>

					<div id="legenddiv">
						<Legend soils={this.state.soils} />
					</div>

					<div id="descriptiondiv">
						<h6 id="descripcionheader">DESCRIPCIÓN </h6>
						<p id="descripciontext">{this.state.mytext}</p>
					</div>

					<div id="parchestable">

						{this.state.boundsobtained ? (
							<UdpTitle munilist={this.state.munilist} />
						) : (
							<p>Cargando...</p>
						)}

						{this.state.boundsobtained ? (
							maptype == "sue" ? (
								<ParchesTable
									udpsoils={this.state.udpsoils}
									setText={this.setText}
								/>
							) : maptype == "inf" ? (
								<InfraTable
									infraInfo={this.state.infraInfo}
									setText={this.setText}
								/>
							) : null
						) : (
							<p>Cargando...</p>
						)}
					</div>

					{shannonBoolean && (
						<div id="biodivreport">
							<UdpDiversity />
						</div>
					)}
					
				</div>
			</div>
		);
	}
}

export default UDPMapapp;
