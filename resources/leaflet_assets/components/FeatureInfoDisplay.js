import React from "react";
import BootstrapTable from 'react-bootstrap-table-next';
import 'react-bootstrap-table-next/dist/react-bootstrap-table2.min.css';

class FeatureInfoDisplay extends React.Component {
    constructor(props) {
        super(props);
    }
    

    render(){
        const allproducts=[];
        if(!this.props.featureInfo.properties.message){
            let mya1= ['ave','arbol','arbusto','hierba', 'herpetofauna','mamifero','juntos']
            let mya2=['total_observaciones','distinct_species','dominancia','shannon']
            
            mya1.map((life)=>{
                let oneproduct={}
                oneproduct['name']= life=='herpetofauna'?'herpeto fauna':life

                mya2.map((category,ind)=>{
                    if (life=='juntos'){
                        let mysum= +this.props.featureInfo.properties[`${category}_ave`] + +this.props.featureInfo.properties[`${category}_hierba`] + +this.props.featureInfo.properties[`${category}_arbusto`] + +this.props.featureInfo.properties[`${category}_arbol`] + +this.props.featureInfo.properties[`${category}_herpetofauna`] + +this.props.featureInfo.properties[`${category}_mamifero`]                                
                        if (ind>1) mysum=(mysum/6).toPrecision(4)
                        oneproduct[category]=mysum
                    }else{
                        let newCat=category.replace(`_${life}`,'')
                        let myValue=  ind>1 ? (+this.props.featureInfo.properties[`${category}_${life}`]).toPrecision(4):this.props.featureInfo.properties[`${category}_${life}`]
                        oneproduct[newCat]=myValue
                    }
                })
                allproducts.push(oneproduct)
            })
        }
        const columns = [{
            dataField: 'name',
            text: 'Nombre'
            },{
            dataField: 'total_observaciones',
            text: 'Especies Total'
            }, {
            dataField: 'distinct_species',
            text: 'Especie Distinctos'
            }, {
            dataField: 'dominancia',
            text: 'Domin ancia',
            classes: 'testme'
              
            }, {
            dataField: 'shannon',
            text: 'Shannon'
            }];
            console.log(this.props.markerPosition)
        return(
            
        <div>
            <div className="container">
                <div className='flex-column d-flex justify-content-around align-items-center p-3'>

                    <div>
                        Ultimo Click:
                    </div>
                    <div>
                        lat: {this.props.markerPosition.lat.toPrecision(7)}, lng: {this.props.markerPosition.lng.toPrecision(7)}
                    </div>
                    <div>
                        {this.props.featureInfo.properties.displayName} = {this.props.featureInfo.properties[this.props.featureInfo.properties.featureColumn]}
                    </div>
                </div>
            </div>

                <BootstrapTable 
                    keyField='name' 
                    data={ allproducts } 
                    columns={ columns } 
                    bordered={ true }
                    classes={ 'featureInfoTable' }
                    striped
                    hover
                    condensed
                    noDataIndication={ 'Click for data' }
                />
        </div>
        )
    }
}

export default FeatureInfoDisplay;