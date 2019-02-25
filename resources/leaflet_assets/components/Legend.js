import React from "react";

function Alist(props) {
  return (
    <div>
      <div
        className="legendColorBox"
        style={{ backgroundColor: props.color }}
      />
      <p className="legendp">{props.descripcio}</p>
    </div>
  );
}

function Blist(props) {
  return (
    <li className="legendEntryDiv">
      <div className='legendlines' id={props.descripcio}></div>
      <p className="legendp">{props.descripcio}</p>
    </li>
  );
}

function Legend(props) {
  const listItems = props.soils.map(soil => (
    <Alist
      key={soil.descripcio + "both"}
      color={soil.color}
      descripcio={soil.descripcio}
    />
  ));
  let finalItemsList=[];
  finalItemsList = 
  maptype=='sue' ? ["MANANTIAL", "CORRIENTE_DE_AGUA"]:
  maptype=='inf' ? ["CARRETERA", "CALLE","CAMINO", "LINEA_DE_TRANSMISION", "BORDO"]:
  null
    


  const finalItems = finalItemsList.map(name => (
    <Blist key={name} descripcio={name} />
  ));

  return (
    <ul>

      {maptype=='sue' && listItems}

      {finalItems}
    </ul>
  );
}

export default Legend;
