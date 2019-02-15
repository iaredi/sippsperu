import React from "react";
import L from "leaflet";

const style = {
  width: "98%",
  height: "100%"
};

class UDPMapa extends React.Component {
  constructor(props) {
    super(props);
    this.setStateBounds = this.setStateBounds.bind(this);
    this.setSoils = this.setSoils.bind(this);
  }

  setStateBounds(bounds) {
    this.props.setStateBounds(bounds);
  }

  setSoils(soils, udpsoils) {
    this.props.setSoils(soils, udpsoils);
  }

  componentDidMount() {
    // create map
    this.map = L.map("map", {
      center: [18.69349, 360 - 98.16245],
      zoom: 10,
      layers: [],
      zoomControl: false
    });

    const get_shp = (item, mymap) => {
      let myStyle = feature => {
        return {
          fillColor: item.fillColor,
          opacity: item.opacity,
          weight: item.weight,
          color: item.color,
          fillOpacity: item.fillOpacity
        };
      };
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

      let c2 = L.geoJson(item.geom, {
        style: myStyle
      });

      c2.addTo(mymap);
      return c2;
    };

    const processArray = (array, mymap, setStateBounds, setSoils) => {
      const overlayMaps = this.overlayMaps || {};
      var bounds = "none";
      var udpiden = "none";
      array.forEach(function(item) {
        if (item.tableName !== "usos_de_suelo4") {
          let myLayer = get_shp(item, mymap);
          overlayMaps[item.displayName] = myLayer;
          if (item.tableName == "udp_puebla_4326") {
            mymap.fitBounds(myLayer.getBounds());
            bounds = mymap.getBounds();
            setStateBounds(mymap.getBounds());
            udpiden = item.sql.split("'")[1];
          }
        } else {
          async function getBoundingFeatures(bounds, udpiden) {
            let myapi =
              "https://biodiversidadpuebla.online/api/getboundingfeatures";
            if (window.location.host == "localhost:3000")
              myapi = "http://localhost:3000/api/getboundingfeatures";
            const rawResponse = await fetch(myapi, {
              method: "POST",
              headers: {
                Accept: "application/json",
                "Content-Type": "application/json;",
                mode: "cors"
              },
              body: JSON.stringify({
                north: bounds._northEast.lat,
                east: bounds._northEast.lng,
                south: bounds._southWest.lat,
                west: bounds._southWest.lng,
                udpiden: udpiden
              })
            });
            let dataResult = await rawResponse.json();
            return dataResult;
          }
          getBoundingFeatures(bounds, udpiden).then(soils => {
            setSoils(JSON.parse(soils[0]), JSON.parse(soils[1]));
            let myLayer = get_shp(item, mymap);
            overlayMaps[item.displayName] = myLayer;

            [
              JSON.parse(soils[2]),
              JSON.parse(soils[3]),
              JSON.parse(soils[4])
            ].forEach(item => {
              if (item.geom) {
                get_shp(item, mymap);
              }
            });
          });
        }
      });
    };

    processArray(udpsomething, this.map, this.setStateBounds, this.setSoils);
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
