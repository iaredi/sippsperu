import React from "react";

function UdpTitle(props) {
  const munilist = 
      props.munilist.map(item => {
        return item.toUpperCase();
      })
    
    
  

  return (
    <div>
      <h6 id="updtitle">
        {" "}
        SISTEMA DE INFORMACIÓN PARA LA PLANEACIÓN DE LOS PAISAJES SOSTENIBLES PROVINCIA DE OXAPAMPA PERÚ ARTICULADO DE LA BIODIVERSIDAD (TIM + SMC):
        SECTOR FORESTAL
      </h6>

      <div id="updmunititle">
        <h6 id="framentation"> MAPA DE FRAGMENTACIÓN {maptype=='sue'?'AMBIENTAL':maptype=='inf'?'INFRASTRUCTURA':null}</h6>
        <h6 id="muniudp">
          {" "}
          PROVINCIA DE {munilist} OXAPAMPA, {uAnalisis} {idennum}
        </h6>
      </div>
    </div>
  );
}

export default UdpTitle;
