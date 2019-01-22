import React from 'react';


function Alist(props) {
    return (
        <div>
        <div className ="legendColorBox" style={{ backgroundColor: props.color }} ></div>
        <p className="legendp">{props.descripcio}</p>
        </div>
    );
  }




function Legend(props){
        const listItems = props.soils.map((soil) =>
            <Alist key={soil.descripcio+'both'}
                color={soil.color}
                descripcio={soil.descripcio}/>
        );
    return(
        <ul>
            {listItems}
        </ul>
    )
    }


export default Legend;