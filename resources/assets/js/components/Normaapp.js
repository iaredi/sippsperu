import React from "react";
import SpeciesDisplay from "./SpeciesDisplay";
import fetchData from "../fetchData";

class Normaapp extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      speciesResultAve: [],
      speciesResultHierba: [],
      speciesResultArbol: [],
      speciesResultArbusto: [],
      speciesResultHerpetofauna: [],
      speciesResultMamifero: []
    };
  }

  componentDidMount() {

	const idennumforapi = idennum.slice(0,-1);
	const idtype = idennum.slice(-1)=='u' ? 'udp' : 'linea_mtp';
    const processArray = async array => {
      for (const item of array) {
        fetchData('getspecies',{lifeform:item.toLowerCase(), idtype:idtype, idnumber:idennumforapi,useremail: document.getElementById("useremail").textContent}).then(myspeciesResult => {
			const newObject = {};
			console.log(myspeciesResult[1])
		  newObject["speciesResult" + item] = myspeciesResult[0];
          this.setState(prevState => newObject);
		});
		
      }
    };
    processArray([
      "Ave",
      "Arbol",
      "Arbusto",
      "Herpetofauna",
      "Hierba",
      "Mamifero"
    ]);
  }

  render() {
    return (
      <div>
        <div className="speciesdisplay">
          <h4 className="normaTitles">Ave</h4>
          <SpeciesDisplay
            speciesResult={this.state.speciesResultAve}
            lifeform="ave"
          />
		</div>
		<br/>
		
        <div className="speciesdisplay">
          <h4 className="normaTitles">Mamifero</h4>
          <SpeciesDisplay
            speciesResult={this.state.speciesResultMamifero}
            lifeform="mamifero"
          />
		</div>
		<br/>
		
        <div className="speciesdisplay">
          <h4 className="normaTitles">Herpetofauna</h4>
          <SpeciesDisplay
            speciesResult={this.state.speciesResultHerpetofauna}
            lifeform="herpetofauna"
          />
		</div>
		<br/>
		
        <div className="speciesdisplay">
          <h4 className="normaTitles">Arbol</h4>
          <SpeciesDisplay
            speciesResult={this.state.speciesResultArbol}
            lifeform="arbol"
          />
		</div>
		<br/>
		
        <div className="speciesdisplay">
          <h4 className="normaTitles">Arbusto</h4>
          <SpeciesDisplay
            speciesResult={this.state.speciesResultArbusto}
            lifeform="arbusto"
          />
		</div>
		<br/>
        <div className="speciesdisplay">
          <h4 className="normaTitles">Hierba</h4>
          <SpeciesDisplay
            speciesResult={this.state.speciesResultHierba}
            lifeform="hierba"
          />
		</div>

		<p>*Promedio</p>
		<p>**En base a la muestra</p>
		<p>***En base al promedio de las distancias</p>
		<p>****En base a una Ha y las abundancias detectadas en la muestra</p>


      </div>
    );
  }
}

export default Normaapp;
