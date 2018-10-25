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
    
  }
  handleMapClick(event) {
    //e.preventDefault();
    const mylat=  event.latlng.lat
    const mylong=  event.latlng.lng
    const error = this.props.handleMapClick(mylat,mylong);

  }
  
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

    const get_shp =(item,mymap)=>{
      let c2 = L.geoJson(item.geom, {
        style: {
          weight: item.weight,
          color: item.color,
          opacity: item.opacity,
          fillColor: item.fillColor,
          fillOpacity: item.fillOpacity
        }
      }).addTo(mymap);
      return c2;
    }
    const processArray=(array, mymap, mybaseMaps)=>{
      const overlayMaps=this.overlayMaps || {};
      array.forEach(function(item){
        let myLayer = get_shp(item,mymap);
        if (item.tableName =='udp_puebla_4326'){
          mymap.fitBounds(myLayer.getBounds())
        }
        overlayMaps[item.tableName]=myLayer;
      });
      L.control.layers(mybaseMaps, overlayMaps).addTo(mymap);
    }
    processArray(something, this.map, this.baseMaps)

    this.map.on("click", this.handleMapClick);
    this.map.scrollWheelZoom.disable()
    
    
  }
  componentDidUpdate({ markerPosition }) {
    // check if position has changed
    // if (this.props.markerPosition !== markerPosition) {
    //   this.marker.setLatLng(this.props.markerPosition);
    // }
  }
  render() {
    return <div id="map" style={style} />;
  }
}

export default Map;
