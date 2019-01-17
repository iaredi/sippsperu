import React from 'react';
//import BootstrapTable from 'react-bootstrap-table-next';

import UDPMapa from './udpMapa';



class UDPMapapp extends React.Component {
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

  getOutline(properties, cat) {
    let email = document.getElementById('useremail').textContent     
    let emailArray = [properties.ave_email,properties.arbol_email,properties.arbusto_email,properties.hierba_email,properties.herpetofauna_email,properties.mamifero_email] 
    if (cat=='color'){
        return emailArray.includes(email)   ?    'purple':
        emailArray.some(el =>  el !== null)    ?   'red':
                                                        'black' ;
    }else{
        return emailArray.includes(email)   ?    3:
        emailArray.some(el =>  el !== null)    ?   3:
                                                       0.3 ;
    }
  };
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
        console.log(myspeciesResult)
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

        if (this.state.previous.feature.properties.name=="udp_puebla_4326"){
          this.state.previous.setStyle({
            "weight": this.getOutline(this.state.previous.feature.properties,'weight'),
            "color":  this.getOutline(this.state.previous.feature.properties,'color'),
            'opacity': myOpacity
          });

        }else{
          this.state.previous.setStyle({
            'color': myColor,
            'weight': myWeight,
            'opacity': myOpacity
          });
        }
      }
    this.setState((prevState) => ({
        previous: event.target
        }));
        
    var highlight = {
        'color': 'yellow',
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
                <UDPMapa
                />
            </div>
          </div>
        </div>  
      </div>
    );
  }
}


export default UDPMapapp;
