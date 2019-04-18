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
			console.log(myspeciesResult)
		  newObject["speciesResult" + item] = myspeciesResult;
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
        <div className="speciesdisplay">
          <h4 className="normaTitles">Mamifero</h4>
          <SpeciesDisplay
            speciesResult={this.state.speciesResultMamifero}
            lifeform="mamifero"
          />
        </div>
        <div className="speciesdisplay">
          <h4 className="normaTitles">Herpetofauna</h4>
          <SpeciesDisplay
            speciesResult={this.state.speciesResultHerpetofauna}
            lifeform="herpetofauna"
          />
        </div>
        <div className="speciesdisplay">
          <h4 className="normaTitles">Arbol</h4>
          <SpeciesDisplay
            speciesResult={this.state.speciesResultArbol}
            lifeform="arbol"
          />
        </div>
        <div className="speciesdisplay">
          <h4 className="normaTitles">Arbusto</h4>
          <SpeciesDisplay
            speciesResult={this.state.speciesResultArbusto}
            lifeform="arbusto"
          />
        </div>
        <div className="speciesdisplay">
          <h4 className="normaTitles">Hierba</h4>
          <SpeciesDisplay
            speciesResult={this.state.speciesResultHierba}
            lifeform="hierba"
          />
        </div>
      </div>
    );
  }
}

export default Normaapp;
