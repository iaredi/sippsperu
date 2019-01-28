import React from "react";
//import BootstrapTable from 'react-bootstrap-table-next';

import UDPMapa from "./udpMapa";
import Legend from "./Legend";
import ParchesTable from "./ParchesTable";
import UdpTitle from "./UdpTitle";
import UdpDiversity from "./UdpDiversity";



class UDPMapapp extends React.Component {
  constructor(props) {
    super(props);
    this.setSoils = this.setSoils.bind(this);
    this.setStateBounds = this.setStateBounds.bind(this);
    this.setText = this.setText.bind(this);

    this.state = {
      mytext: "Cargando...",
      speciesResult: [],
      bounds: "Cargando...",
      boundsobtained: false,
      soils: [{ color: "rgb:000", descripcio: "Cargando..." }],
      udpsoils: [{ color: "rgb:000", descripcio: "Cargando..." }],
      previous: 0,
      udp: 0,
      markerPosition: { lat: 18.69349, lng: 360 - 98.16245 },
      mapSettings: {
        distinctOrTotal: "total_observaciones",
        myObsType: "ave",
        fillOpacity: 0.6,
        maxValue: 99
      },
      featureInfo: {
        properties: { message: "click somewhere", displayName: "Cargando..." }
      },
      table: [{ tableName: "udp_puebla_4326", color: "blue" }]
    };
  }
  setText(mytext) {
    if (mytext != this.state.mytext) {
      this.setState(prevState => ({
        mytext: mytext
      }));
    }
  }
  setSoils(soils, udpsoils) {
    if (soils != this.state.soils) {
      this.setState(prevState => ({
        soils: soils
      }));
    }
    if (udpsoils != this.state.udpsoils) {
      this.setState(prevState => ({
        udpsoils: udpsoils
      }));
    }
    if (!this.state.boundsobtained) {
      this.setState(prevState => ({
        boundsobtained: true
      }));
    }
  }

  setStateBounds(bounds) {
    if (bounds != this.state.bounds) {
      this.setState(prevState => ({
        bounds: bounds
      }));
    }
  }

  updateMarkers(markersData) {
    this.layer.clearLayers();
    markersData.forEach(marker => {
      L.marker(marker.latLng, { title: marker.title }).addTo(this.layer);
    });
  }

  render() {
    
    return (
      <div>
        <div className="udplayout">
          <div id="udpmapdiv" className="border border-dark">
            <UDPMapa
              setStateBounds={this.setStateBounds}
              setSoils={this.setSoils}
            />
          </div>

          <div id="legenddiv">
            <Legend 
            soils={this.state.soils} 
            />
          </div>

          <div id="descriptiondiv">
            <h6 id="descripcionheader">DESCRIPCIÓN </h6>
            <p id="descripciontext">{this.state.mytext}</p>
          </div>

          <div id="parchestable">
            {this.state.boundsobtained ? (
              <UdpTitle
              udpsoils={this.state.udpsoils}
              />
              ) : (
                <p>Cargando...</p>
            )}

            {this.state.boundsobtained ? (
              <ParchesTable
                udpsoils={this.state.udpsoils}
                setText={this.setText}
              />
            ) : (
              <p>Cargando...</p>
            )}
          </div>
          <div id="biodivreport">
          
            <UdpDiversity
            />
            </div>
        </div>
      </div>
    );
  }
}

export default UDPMapapp;
