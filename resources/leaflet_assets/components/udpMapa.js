import React from "react";
import L from "leaflet";

const style = {
  width: "400px",
  height: "300px"
};

class UDPMapa extends React.Component {
    constructor(props) {
        super(props);
        this.getColor = this.getColor.bind(this);
    }
    getColor(x) {        
        return x == "ZONA URBANA"      ?    '#edf8fb':
            
                                                         '#005824' ;
    };
   
    
  componentDidMount() {
    // create map
    this.map = L.map("map", {
      center: [18.69349,360-98.16245],
      zoom: 9,
      layers: [],
      zoomControl:false 

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
        const myStyle= (feature )=> {
            return {
            "fillColor": getColor(feature.properties['descripcio']),
            "opacity": item.opacity,
            "weight": item.weight,
            "color":  item.color,
            "fillOpacity": item.fillOpacity
            }
          } 
        
      
        let c2 = L.geoJson(item.geom, {
            style: myStyle
        })
        
        c2.addTo(mymap)
        
        return c2;
    }
    
    const processArray=(array, mymap, mybaseMaps,getColor,getOutline)=>{
        var dynamicLayer='notset'
        const overlayMaps=this.overlayMaps || {};
        array.forEach(function(item){
          let myLayer = get_shp(item,mymap,getColor,getOutline);
          if (item.tableName =='udp_puebla_4326'){
              dynamicLayer=myLayer
              mymap.fitBounds(myLayer.getBounds())
              ////ASYNC HERE 
                //ask the api what layers are in frame so they can be colored and list
                //later we will get the metrics of soils in our udp square.




          }
          overlayMaps[item.displayName]=myLayer;
        });
        L.control.layers(mybaseMaps, overlayMaps).addTo(mymap);
        return dynamicLayer
      }
    this.dynamicLayer=processArray(udpsomething, this.map, this.baseMaps, this.getColor,this.getOutline)
    this.map.scrollWheelZoom.disable()
    console.log (this.map.getBounds())
    console.log(udpsomething)
    var lyrcont = document.getElementsByClassName("leaflet-control-layers")[0]
    var lyratt = document.getElementsByClassName("leaflet-control-attribution")[0]
    lyrcont.style.visibility = 'hidden';
    lyratt.style.visibility = 'hidden';
    this.map.dragging.disable()
    this.map.doubleClickZoom.disable()
    /////////////////////////////////////////////////////
        
  }

    componentDidUpdate({ mapSettings }) {
        
    }
  render() {
    return <div id="map" style={style} />;
  }
}
export default UDPMapa;
