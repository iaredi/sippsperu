import React from "react";
//import BootstrapTable from 'react-bootstrap-table-next';

import UDPMapa from "./udpMapa";
import Legend from "./Legend";
import ParchesTable from "./ParchesTable";


class UDPMapapp extends React.Component {
  constructor(props) {
    super(props);
    this.setSoils = this.setSoils.bind(this);
    this.setStateBounds = this.setStateBounds.bind(this);

    this.state = {
      speciesResult: [],
      bounds: "none",
      boundsobtained:false,
      soils: [{ color: "rgb:000", descripcio: "None" }],
      udpsoils: [{ color: "rgb:000", descripcio: "None" }],
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
        properties: { message: "click somewhere", displayName: "none" }
      },
      table: [{ tableName: "udp_puebla_4326", color: "blue" }]
    };
  }

  setSoils(soils,udpsoils) {
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
          </div>

          <div id="parchestable">
            {
              this.state.boundsobtained ?
                (<ParchesTable udpsoils={this.state.udpsoils} />) : 
                <p>'none'</p>
            }
          </div>
          <div id="biodivreport">
          </div>


        </div>
      </div>

    );
  }
}

export default UDPMapapp;
