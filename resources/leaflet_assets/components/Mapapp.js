import React from 'react';
import Map from './Map';
import MapControl from './MapControl';

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
            udp:0,
            markerPosition: { lat: 18.69349, lng: 360-98.16245 },
            mapSettings:{distinctOrTotal:"total_observaciones", myObsType:"ave", fillOpacity:1, maxValue:6},
            featureInfo: { name:'click somewhere', properties:['click somewhere']},
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
  handleFeatureClick(target) {
      console.log(target)
      const propertiesArray=[]
      Object.entries(target.feature.properties).forEach(
        ([key, value]) => propertiesArray.push(key, value)
    );
    console.log(propertiesArray)
    const name = (target.feature.geometry.type=='MultiPolygon'?'UPD':'Linea-MTP')
    const properties= propertiesArray;

    this.setState((prevState) => ({
        featureInfo: {
            name:name,
            properties:properties
           
        }
        }));
    console.log(target)
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
          featureInfo={this.state.featureInfo} 
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
