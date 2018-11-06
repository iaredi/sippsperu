import React from 'react';
import Map from './Map';
import MapControl from './MapControl';
import FeatureInfoDisplay from './FeatureInfoDisplay';

class Mapapp extends React.Component {
  constructor(props){
        super(props)
        this.handleMapClick = this.handleMapClick.bind(this);
        this.handleSpeciesChange = this.handleSpeciesChange.bind(this);
        this.handleTotalDistinctChange = this.handleTotalDistinctChange.bind(this);
        this.handleOpacityChange = this.handleOpacityChange.bind(this);
        this.handleMaxChange = this.handleMaxChange.bind(this);
        this.handleFeatureClick = this.handleFeatureClick.bind(this);
        this.state={
            previous:0,
            udp:0,
            markerPosition: { lat: 18.69349, lng: 360-98.16245 },
            mapSettings:{distinctOrTotal:"total_observaciones", myObsType:"ave", fillOpacity:1, maxValue:6},
            featureInfo: { name:'click somewhere', properties:{message:'click somewhere'}},
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

    // const rawResponse = await fetch('http://localhost:3000/api/getudp', {
    //   method: 'POST',
    //   headers: {
    //     'Accept': 'application/json',
    //     "Content-Type": "application/json;",
    //   },
    //   body: JSON.stringify({
    //     "lat": mylat,
    //     "lng":mylong
    //   })
    // });
    //   let currentudp = await rawResponse.json()
    //   this.setState((prevState) => ({
    //     udp:currentudp
    //   }));
    
  }
  handleSpeciesChange(value) {

    this.setState((prevState) => ({
      mapSettings: {
        distinctOrTotal:prevState.mapSettings.distinctOrTotal,
        myObsType:value,
        fillOpacity:prevState.mapSettings.fillOpacity,
        maxValue:prevState.mapSettings.maxValue
      }
    }));
  }
  handleFeatureClick(event) {
      console.log(event.target)
    if (this.state.previous){
        this.state.previous.setStyle({
            'color': 'black',
            'weight': .3,
            'opacity': 1
        });
        this.state.previous.setStyle(event.target.defaultOptions.style);
    }

    this.setState((prevState) => ({
        previous: event.target
        }));
        
    var highlight = {
        'color': 'blue',
        'weight': 3,
        'opacity': 1
    };
      event.target.setStyle(highlight);
      
      
      
      let name = event.target.feature.geometry.type=='MultiPolygon'?'Unidad de Paisaje':'Linea MTP'
    this.setState((prevState) => ({
        featureInfo: {
            name:name,
            properties:event.target.feature.properties
        }
        }));
  }

  handleTotalDistinctChange(value) {
    this.setState((prevState) => ({
      mapSettings: {
        distinctOrTotal:value,
        myObsType:prevState.mapSettings.myObsType,
        fillOpacity:prevState.mapSettings.fillOpacity,
        maxValue:prevState.mapSettings.maxValue
      }
    }));
  }

  handleOpacityChange(value) {
    this.setState((prevState) => ({
      mapSettings: {
        distinctOrTotal:prevState.mapSettings.distinctOrTotal,
        myObsType:prevState.mapSettings.myObsType,
        fillOpacity:value,
        maxValue:prevState.mapSettings.maxValue
      }
    }));
  }

  handleMaxChange(value) {
    this.setState((prevState) => ({
      mapSettings: {
        distinctOrTotal:prevState.mapSettings.distinctOrTotal,
        myObsType:prevState.mapSettings.myObsType,
        fillOpacity:prevState.mapSettings.fillOpacity,
        maxValue:value
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
            handleFeatureClick={this.handleFeatureClick}

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
          handleOpacityChange={this.handleOpacityChange}
          handleMaxChange={this.handleMaxChange}
          mapSettings={this.state.mapSettings} 
          />
        </div>
          
          <FeatureInfoDisplay
          featureInfo={this.state.featureInfo} 
          />
          
      </div>
    );
  }
}


export default Mapapp;
