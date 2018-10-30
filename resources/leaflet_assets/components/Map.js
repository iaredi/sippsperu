import React from "react";
import L from "leaflet";

const style = {
  width: "70%",
  height: "500px"
};

class Map extends React.Component {
  constructor(props) {
    super(props);
    this.handleMapClick = this.handleMapClick.bind(this);
    this.getColor = this.getColor.bind(this);

  }
  handleMapClick(event) {
    this.props.handleMapClick(event.latlng.lat,event.latlng.lng);
  }
  getColor(x) {

    return x < 1     ?    '#ffffcc':
           x < 2     ?   '#d9f0a3':
           x < 3     ?   '#addd8e':
           x < 4     ?   '#78c679':
           x < 5     ?   '#31a354':
           x < 6     ?   '#006837':
                            '#ffffb2' ;
  };

 
  
  componentDidMount() {  
    // create map
    this.map = L.map("map", {
      center: [18.69349,360-98.16245],
      zoom: 8,
      layers: []
    });


    
    const streets = L.tileLayer("http://{s}.tile.osm.org/{z}/{x}/{y}.png", {
      attribution:
        '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(this.map);
  
    const imagery = L.tileLayer(
    'http://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
    attribution: '&copy; <a href="http://www.esri.com/">Esri</a>i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community',
    maxZoom: 18,
    });

    this.baseMaps = {
      
      "Imagery":imagery,
      "Streets": streets
  };

  

    const get_shp =(item,mymap,getColor)=>{
      let myStyle={};
      

      const targetProperty = `${this.props.mapSettings.distinctOrTotal}_${this.props.mapSettings.myObsType}`;
      
      if (item.colorGradient){
        myStyle=function (feature) {
          return {
           "fillColor": getColor(feature.properties[targetProperty]),
           "opacity": 1,
           "weight": .3,
           "color": "black",
           "fillOpacity": 0.9
          }
        } 
      }else{
        myStyle={
          weight: item.weight,
          color: item.color,
          opacity: item.opacity,
          fillColor: item.fillColor,
          fillOpacity: item.fillOpacity
        } 
      }
      
      let c2 = L.geoJson(item.geom, {
        style: myStyle
      }).addTo(mymap);
      return c2;
    }
    const processArray=(array, mymap, mybaseMaps,getColor)=>{
      var dynamicLayer='notset'
      const overlayMaps=this.overlayMaps || {};
      array.forEach(function(item){
        let myLayer = get_shp(item,mymap,getColor);
        if (item.tableName =='udp_puebla_4326'){
          dynamicLayer=myLayer
          mymap.fitBounds(myLayer.getBounds())
        }
        overlayMaps[item.displayName]=myLayer;
      });
      L.control.layers(mybaseMaps, overlayMaps).addTo(mymap);
      return dynamicLayer
    }

    this.dynamicLayer=processArray(something, this.map, this.baseMaps, this.getColor)

    this.map.on("click", this.handleMapClick);
    this.map.scrollWheelZoom.disable()
    
    
  }
  componentDidUpdate({ mapSettings }) {
    // check if position has changed
    if (this.props.mapSettings !== mapSettings) {
      const getColor=this.getColor;
     
      const targetProperty = `${this.props.mapSettings.distinctOrTotal}_${this.props.mapSettings.myObsType}`;
      let myStyle={};
      myStyle=function (feature) {
        return {
         "fillColor": getColor(feature.properties[targetProperty]),
         "opacity": 1,
         "weight": .3,
         "color": "black",
         "fillOpacity": 0.9
        }
      } 
      this.dynamicLayer.setStyle(myStyle)
    }
  }
  render() {
    return <div id="map" style={style} />;
  }
}

export default Map;
