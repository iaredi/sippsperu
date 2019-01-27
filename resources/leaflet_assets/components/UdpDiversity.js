import React from "react";

function Alist(props) {
  return (
    <div id ={props.type + "div"}>
      <p className="shannonp">{props.shannon}</p>
      <p className="iconp">{props.icon}</p>
    </div>
  );
}
function UdpDiversity(props) {
  const bigArray = [
    {type:'arbol',icon:'🌲',shannon:shannon.split('*')[0]},
    {type:'arbusto',icon:'🌳',shannon:shannon.split('*')[1]},
    {type:'ave',icon:'🦅',shannon:shannon.split('*')[2]},
    {type:'hierba',icon:'🌱',shannon:shannon.split('*')[3]},
    {type:'herpetofauna',icon:'🐍',shannon:shannon.split('*')[4]},
    {type:'mamifero',icon:'🦌',shannon:shannon.split('*')[5]},
  ]
  console.log(shannon)
  const listItems = bigArray.map(animal => (
    <Alist
      key={animal.type}
      icon={animal.icon}
      shannon={animal.shannon}
      type={animal.type}
    />
  ));
  
 
  return ( 
    <div>
      
    {listItems}
     <div id="udpDiversity">
        <div id="startScale" >
          <p>
            0 
          </p>
        </div>
        <div id="pngScale" >
          <img id="scaleImage" src="/img/scale.png"/>
        </div>
        <div id="endScale" >
          <p>
            100 
          </p>
        </div>

        
    </div>
  </div>
  )
}

export default UdpDiversity;
