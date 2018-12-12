import React from 'react';
//import BootstrapTable from 'react-bootstrap-table-next';

import Map from './Map';
import MapControl from './MapControl';
import FeatureInfoDisplay from './FeatureInfoDisplay';
import SpeciesDisplay from './SpeciesDisplay';


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
            speciesResult:[],
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
    // $lifeform=explode('_',$observacion)[1];
    // $idtype = $request->idtype;
    // $idnumber= $request->idnumber;
    const lifeform = this.state.mapSettings.myObsType
    const idtype =event.target.feature.properties.name=='udp_puebla_4326'?'udp':'linea_mtp'
    const idnumber = event.target.feature.properties.iden

    async function getSpecies(lifeform,idtype,idnumber){
      let myapi ='https://biodiversidadpuebla.online/api/getspecies'
      if (window.location.host=='localhost:3000') myapi ='http://localhost:3000/api/getspecies'
      const rawResponse = await fetch(myapi, {
          method: 'POST',
          headers: {
              'Accept': 'application/json',
              "Content-Type": "application/json;",
              mode: 'cors',
          },
          body: JSON.stringify({
              "lifeform": lifeform,
              "idtype":idtype,
              "idnumber":idnumber,
              "useremail" : document.getElementById('useremail').textContent
              
          })
      });
      let dataResult = await rawResponse.json()
      return dataResult
    }
    if (event.target.feature.properties.name=='udp_puebla_4326'||event.target.feature.properties.name=='linea_mtp'){
      getSpecies(lifeform,idtype,idnumber).then(myspeciesResult =>{
        this.setState((prevState) => ({
          speciesResult: myspeciesResult      
        }));
      })
    }

    /////////////////////////////////////////////////////////////////////////////////////////////
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
        <div className="container mymapcontainer">
          <div className='row justify-content-around align-items-center mapstat'>
            <div className='mymapdiv border border-dark'>
                <Map
                    handleMapClick={this.handleMapClick}
                    handleFeatureClick={this.handleFeatureClick}
                    setDefaultMax={this.setDefaultMax}
                    mapSettings={this.state.mapSettings} 
                    table = {this.state.table}
                    />
            </div>

            <div className='mystatdiv p-1'>
              <div className='withcontrol flex-column d-flex justify-content-between align-items-start'>
                  <FeatureInfoDisplay 
                    markerPosition={this.state.markerPosition} 
                    featureInfo={this.state.featureInfo}
                  />
                  <MapControl
                    handleSpeciesChange={this.handleSpeciesChange}
                    handleTotalDistinctChange={this.handleTotalDistinctChange}
                    handleOpacityChange={this.handleOpacityChange}
                    handleMaxChange={this.handleMaxChange}
                    mapSettings={this.state.mapSettings} 
                  />
                  <div className='p-2 align-self-center'>
                    <a className="btn btn-primary" href="/cargarshapes" role="button">Cargar Shapefile</a>
                  </div>
              </div>
            </div>
          </div>
          <div className="speciesdisplay">
            <SpeciesDisplay 
              speciesResult={this.state.speciesResult} 
            />
          </div>
        </div>

        
        <div>
        
        </div>
          
        
          
      </div>
    );
  }
}


export default Mapapp;
