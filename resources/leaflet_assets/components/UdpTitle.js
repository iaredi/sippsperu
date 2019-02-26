import React from "react";

function UdpTitle(props) {
  const munilist = 
      props.munilist.map(item => {
        return `${item.nomgeo.toUpperCase()}, `;
      })
    
    
  

  return (
    <div>
      <h6 id="updtitle">
        {" "}
        PROPUESTA DE MONITOREO ARTICULADO DE LA BIODIVERSIDAD (MTP + SMC):
        SECTOR FORESTAL
      </h6>

      <div id="updmunititle">
        <h6 id="framentation"> MAPA DE FRAGMENTACIÓN AMBIENTAL</h6>
        <h6 id="muniudp">
          {" "}
          MUNICIPIO DE {munilist} PUEBLA, UNIDAD DE PAISAJE {idennum}
        </h6>
      </div>
    </div>
  );
}

export default UdpTitle;
