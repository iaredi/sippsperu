import React from "react";

function Alist(props) {
  return (
    <span
      className="biodivcontainer"
      id={props.type + "span"}
    >
    <p className="shannonp">{props.shannon}</p>
    <p className="iconp">{props.icon}</p>
    </span>
  );
}
function UdpDiversity(props) {
  const bigArray = [
    { type: "arbol", icon: "🌲", shannon: parseFloat(shannon.split("*")[0]).toFixed(2) },
    { type: "arbusto", icon: "🌳", shannon: parseFloat(shannon.split("*")[1]).toFixed(2) },
    { type: "ave", icon: "🐦", shannon: parseFloat(shannon.split("*")[2]).toFixed(2) },
    { type: "hierba", icon: "🌱", shannon: parseFloat(shannon.split("*")[3]).toFixed(2) },
    { type: "herpetofauna", icon: "🐍", shannon: parseFloat(shannon.split("*")[4]).toFixed(2) },
    { type: "mamifero", icon: "🐇", shannon: parseFloat(shannon.split("*")[5]).toFixed(2) }
  ];
  function compare(a, b) {
    if (parseFloat(a.shannon) < parseFloat(b.shannon)) return -1;
    if (parseFloat(a.shannon) > parseFloat(b.shannon)) return 1;
    return 0;
  }
  bigArray.sort(compare);

  const listItems = bigArray.map((animal, ind) => {
    if (animal.shannon > 0) {
      return (
        <Alist
          key={animal.type}
          icon={animal.icon}
          shannon={animal.shannon}
          type={animal.type}
          index={ind}
        />
      );
    }
  });
  var previousAnimal = -1;

  const svgLines = bigArray.map((animal, ind) => {
    if (animal.shannon > 0) {
      previousAnimal++;
      const x1my = 37 + previousAnimal * 52;
      const x2my = 44.0 + +animal.shannon * 2.72;
      return (
        <line
          key={animal.type}
          x1={x1my}
          y1="3"
          x2={x2my}
          y2="58"
          style={{ stroke: "rgb(255,0,0)" }}
        />
      );
    }
  });

  return (
    <div id="biodivContainer">
      <h5 id="shannonTitle">Biodiversidad : Indice de Shannon</h5>
      {listItems}
      <svg height="60" width="100%">
        {svgLines}
      </svg>
      <div id="udpDiversity">
        <div id="startScale">
          <p>0</p>
        </div>
        <div id="pngScale">
          <img id="scaleImage" src="/img/scale.png" />
        </div>
        <div id="endScale">
          <p>100</p>
        </div>
      </div>
    </div>
  );
}

export default UdpDiversity;
