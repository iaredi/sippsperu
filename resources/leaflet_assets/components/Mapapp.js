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
        this.setDefaultMax = this.setDefaultMax.bind(this);
        this.state={
            previous:0,
            udp:0,
            markerPosition: { lat: 18.69349, lng: 360-98.16245 },
            mapSettings:{distinctOrTotal:"total_observaciones", myObsType:"ave", fillOpacity:0.6, maxValue:99},
            featureInfo: { properties:{message:'click somewhere',displayName:'none' }},
            table: [
                {tableName:'udp_puebla_4326',color: 'blue'},
            ] 
        }
  }
  async handleMapClick(event) {
    this.setState((prevState) => ({
      markerPosition: {
        lat:event.latlng.lat,
        lng:event.latlng.lng
      }
    }));

    
  }
  handleSpeciesChange(value) {
    let max=defaultmax[`${this.state.mapSettings.distinctOrTotal}_${value}`]
    max= max<6 ? 6 :max
    this.setState((prevState) => ({
      mapSettings: {
        distinctOrTotal:prevState.mapSettings.distinctOrTotal,
        myObsType:value,
        fillOpacity:prevState.mapSettings.fillOpacity,
        maxValue:max
      }
    }));
  }

  handleTotalDistinctChange(value) {
    let max =defaultmax[`${value}_${this.state.mapSettings.myObsType}`]
    max= max<6 ? 6 :max
    this.setState((prevState) => ({
      mapSettings: {
        distinctOrTotal:value,
        myObsType:prevState.mapSettings.myObsType,
        fillOpacity:prevState.mapSettings.fillOpacity,
        maxValue:max
      }
    }));
  }

  setDefaultMax(max)  {
    max= max<6 ? 6 :max
    this.setState((prevState) => ({
      mapSettings: {
        distinctOrTotal:prevState.mapSettings.distinctOrTotal,
        myObsType:prevState.mapSettings.myObsType,
        fillOpacity:prevState.mapSettings.fillOpacity,
        maxValue:max
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

      
      
      
        this.setState((prevState) => ({
            featureInfo: {
                properties:event.target.feature.properties
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
        
            <div className='row justify-content-around'>
            <div className='col-8 p-0 border border-secondary'>
                <Map
                    handleMapClick={this.handleMapClick}
                    handleFeatureClick={this.handleFeatureClick}
                    setDefaultMax={this.setDefaultMax}
                    mapSettings={this.state.mapSettings} 
                    table = {this.state.table}
                    />
            </div>
            
            <div className='col-4 p-2'>
                <FeatureInfoDisplay 
                    markerPosition={this.state.markerPosition} 
                    featureInfo={this.state.featureInfo}
                />
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
