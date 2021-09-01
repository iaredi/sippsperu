import React from "react";
import L from "leaflet";
import fetchData from "../fetchData";
var addLast=[]
const style = {
  width: "98%",
  height: "100%"
};

class UDPMapa extends React.Component {
  constructor(props) {
    super(props);
    this.setStateBounds = this.setStateBounds.bind(this);
    this.setSoils = this.setSoils.bind(this);
    this.setInfra = this.setInfra.bind(this);
    this.setMuni = this.setMuni.bind(this);
  }

  setStateBounds(bounds) {
    this.props.setStateBounds(bounds);
  }

  setSoils(soils, udpsoils) {
    this.props.setSoils(soils, udpsoils);
  }

  setInfra(infInfo) {
    this.props.setInfra(infInfo);
  }

  setMuni(munilist) {
    this.props.setMuni(munilist);
  }

  componentDidMount() {
    // create map
    this.map = L.map("map", {
      
      zoomSnap: 0.1,
      layers: [],
      zoomControl: false
    });

    const get_shp = (item, mymap) => {
      let geojsonMarkerOptions = {
        radius: 4,
        fillColor: item.fillColor,
        color: item.color,
        weight: item.weight,
        opacity: item.opacity,
        fillOpacity: item.fillOpacity
    };
    if (item.tableName == "infra_punto") {
    geojsonMarkerOptions = {
      radius: 2,
      fillColor: item.fillColor,
      color: item.color,
      weight: item.weight,
      opacity: item.opacity,
      fillOpacity: item.fillOpacity
  };
    }
    let myStyle={
      weight: item.weight,
      color: item.color,
      opacity: item.opacity,
      fillColor: item.fillColor,
      fillOpacity: item.fillOpacity
    } 

    if (item.tableName == "usos_de_suelo4") {
      myStyle = feature => {
        return {
          fillColor: feature.properties["color"],
          opacity: item.opacity,
          weight: item.weight,
          color: item.color,
          fillOpacity: item.fillOpacity
        };
      };
    }

    if (item.tableName == "infra_linea") {
      myStyle = feature => {
        return {
          opacity: item.opacity,
          weight: feature.properties["weight"],
          color: feature.properties["color"],
          dashArray: feature.properties["dash"],
          fillOpacity: item.fillOpacity
        };
      };
    }

      let c2;
      if (maptype!='sue' && item.geom && item.geom.features[0].geometry.type=='Point'){
        c2 = L.geoJSON(item.geom, {
          pointToLayer: function (feature, latlng) {
            return L.circleMarker(latlng, geojsonMarkerOptions);
          },
          style: myStyle,
        })
      }else{
        c2 = L.geoJson(item.geom, {
          style: myStyle
        });
	  }
	  if (item.tableName=='udp_puebla_4326'){
		addLast.push(c2)
	  }else{
		  c2.addTo(mymap);
	  }
      return c2;
    };

    const processArray = (array, mymap, setStateBounds, setSoils, setInfra, setMuni) => {
      const overlayMaps = this.overlayMaps || {};
      var bounds = "none";
      var udpiden = "none";
      array.forEach(function(item) {
        if (item.tableName !== "usos_de_suelo4") {
          let myLayer = get_shp(item, mymap);
          overlayMaps[item.displayName] = myLayer;
          if (item.tableName == "udp_puebla_4326" || item.tableName == "usershapes") {
            mymap.fitBounds(myLayer.getBounds());
            mymap.setZoom(13.6),
            bounds = mymap.getBounds();
            setStateBounds(mymap.getBounds());
            udpiden = item.sql.split("'")[1];
          }
        }
        if (item.tableName == "usos_de_suelo4" || item.tableName == "infra_linea"){
          fetchData("get"+maptype+"features",{
			north: bounds._northEast.lat,
			east: bounds._northEast.lng,
			south: bounds._southWest.lat,
			west: bounds._southWest.lng,
			udpiden: udpiden
		  }).then(returnData => {
			setMuni(JSON.parse(returnData[returnData.length-1]))
			
			const addLastToMap = (array)=>{
				array.forEach((lastLayer)=>{
					lastLayer.addTo(mymap)
				})
			}
			
            if (maptype=='sue'){
			  setSoils(JSON.parse(returnData[0]), JSON.parse(returnData[1]));

              let myLayer = get_shp(item, mymap);
              overlayMaps[item.displayName] = myLayer;
              [JSON.parse(returnData[2]), JSON.parse(returnData[3]), JSON.parse(returnData[4]) ].forEach(item => {
                if (item.geom) {
					get_shp(item, mymap);
					addLastToMap(addLast)    
					addLast.length=0;           
				}
              });
            }else{
				addLastToMap(addLast)    
				addLast.length=0;  
			}

            if (maptype=='inf'){
              setInfra(JSON.parse(returnData[0]))
			}
			
			

          });
        }
      });
    };

    processArray(udpsomething, this.map, this.setStateBounds, this.setSoils, this.setInfra, this.setMuni);
    this.map.scrollWheelZoom.disable();
    L.control.scale({ imperial: false }).addTo(this.map);

    //Make map static
    var lyrcont = document.getElementsByClassName( "leaflet-control-attribution")[0];
   
    lyrcont.style.visibility = "hidden";
 
    var north = L.control({ position: "topright" });
    north.onAdd = function(map) {
      var div = L.DomUtil.create("div", "info legend");
      div.innerHTML = '<img id="northarrow" src="/img/north.png">';
      return div;
    };
    north.addTo(this.map);
    this.map.dragging.disable();
    this.map.doubleClickZoom.disable();
    /////////////////////////////////////////////////////
  }

  render() {
    return <div id="map" style={style} />;
  }
}
export default UDPMapa;
