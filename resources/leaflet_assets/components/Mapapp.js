import React from 'react';
import BootstrapTable from 'react-bootstrap-table-next';

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
            featureInfo: { properties:{message:'click somewhere'}},
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
        let myColor='green'
        let myWeight=5
        let myOpacity=5
      
        if (this.state.previous){
            something.forEach((thing)=>{
                if (thing.tableName==this.state.previous.feature.properties.name){
                    myColor=thing.color
                    myWeight=thing.weight
                    myOpacity=thing.opacity
            }
          })
            this.state.previous.setStyle({
                'color': myColor,
                'weight': myWeight,
                'opacity': myOpacity
            });
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
    return (
      <div>
        <div className='container p-0 m-0'>
            <div className='row border border-dark justify-content-around'>
            <div className='col-8 p-0'>
                <Map
                    handleMapClick={this.handleMapClick}
                    handleFeatureClick={this.handleFeatureClick}
                    mapSettings={this.state.mapSettings} 
                    table = {this.state.table}
                    />
            </div>
            
            <div className='col-4 p-3'>
                <FeatureInfoDisplay 
                    markerPosition={this.state.markerPosition} 
                    featureInfo={this.state.featureInfo}
                />
            </div>
            </div>
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
          
        
          
      </div>
    );
  }
}


export default Mapapp;
