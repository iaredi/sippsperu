import React from 'react';
import Map from './Map';
import MapControl from './MapControl';

class Mapapp extends React.Component {
  constructor(props){
    super(props)
    this.handleMapClick = this.handleMapClick.bind(this);
    this.handleSpeciesChange = this.handleSpeciesChange.bind(this);
    this.handleTotalDistinctChange = this.handleTotalDistinctChange.bind(this);


    this.state={
      udp:0,
      markerPosition: { lat: 18.69349, lng: 360-98.16245 },
      mapSettings:{distinctOrTotal:"total_observaciones", myObsType:"ave"},
     
      table: [
        {tableName:'udp_puebla_4326',color: 'blue'},
      ] 
    }
  }
  async handleMapClick(mylat,mylong) {
    this.setState((prevState) => ({
      markerPosition: {
        lat:mylat,
        lng:mylong
      }
    }));

    const rawResponse = await fetch('http://localhost:3000/api/getudp', {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        "Content-Type": "application/json;",
      },
      body: JSON.stringify({
        "lat": mylat,
        "lng":mylong
      })
    });
      let currentudp = await rawResponse.json()
      this.setState((prevState) => ({
        udp:currentudp
      }));
    
  }
  handleSpeciesChange(value) {
    this.setState((prevState) => ({
      mapSettings: {
        distinctOrTotal:prevState.mapSettings.distinctOrTotal,
        myObsType:value
      }
    }));
  }

  handleTotalDistinctChange(value) {
    this.setState((prevState) => ({
      mapSettings: {
        distinctOrTotal:value,
        myObsType:prevState.mapSettings.myObsType
      }
    }));
  }
  
  updateMarkers(markersData) {
    this.layer.clearLayers();
    markersData.forEach(marker => {
      L.marker(marker.latLng, { title: marker.title }).addTo(this.layer);
    });
  }
  
  render() {
    //const { markerPosition } = this.state.markerPosition;
    return (
      <div>
        <div>
          <Map
            handleMapClick={this.handleMapClick}
            markerPosition={this.state.markerPosition} 
            mapSettings={this.state.mapSettings} 
            table = {this.state.table}
            />
        </div>
        <div>
          Current marker Position: lat: {this.state.markerPosition.lat}, lng: {this.state.markerPosition.lng}, 
        </div>
        <div>
          Current UDP: {this.state.udp}
        </div>
        <div>
          <MapControl
          handleSpeciesChange={this.handleSpeciesChange}
          handleTotalDistinctChange={this.handleTotalDistinctChange}
          />
        </div>
          
          <button
            //onClick={this.moveMarker}
          >
            Move marker
          </button>
      </div>
    );
  }
}


export default Mapapp;
