import React from "react";

class FeatureInfoDisplay extends React.Component {
    constructor(props) {
        super(props);
    }
    render(){
        return(
        <div>
            <div>{this.props.featureInfo.name}</div>
            <div>
            <ul>
            {
                ['0Ave','ave','0Mamifero','mamifero','0Herpetofauna','herpetofauna','0Arbol','arbol','0Arbusto','arbusto','0Hierba','hierba','0Totales','totales'].map((life,ind)=>{
                    if (!isNaN(life.slice(0,1))){
                        return <h4 key={life.slice(1)}> {life.slice(1)}</h4>

                    }else{return(
                        ['total_observaciones','distinct_species','dominancia','shannon'].map((category,ind)=>{
                            if (life==='totales'){
                                let mysum= +this.props.featureInfo.properties[`${category}_ave`] + +this.props.featureInfo.properties[`${category}_hierba`] + +this.props.featureInfo.properties[`${category}_arbusto`] + +this.props.featureInfo.properties[`${category}_arbol`] + +this.props.featureInfo.properties[`${category}_herpetofauna`] + +this.props.featureInfo.properties[`${category}_mamifero`]                                
                                if (ind>1) mysum=(mysum/6).toPrecision(4)
                                return <li key={`${category}_${life}`}> {category} :  {mysum} </li> 
                            }else{
                                return <li key={`${category}_${life}`}> {category} :  {this.props.featureInfo.properties[`${category}_${life}`]} </li> 
                            }
                        })
                      
                    )}
                })
            }
            </ul>
            </div>
            
        </div>
        )
    }
}

export default FeatureInfoDisplay;