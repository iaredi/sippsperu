import React from "react";
import BootstrapTable from 'react-bootstrap-table-next';
import 'react-bootstrap-table-next/dist/react-bootstrap-table2.min.css';

class SpeciesDisplay extends React.Component {
    constructor(props) {
        super(props);
    }
    render(){

        const oldspeciesResult=this.props.speciesResult
        console.log(oldspeciesResult)
        //ADD (2) to prevent duplicate keys 
        const newA={}
        const speciesResult = oldspeciesResult.map((spec) => {
            let newObject = {...spec}
            if(newA[spec.cientifico]){
                 if (newA[spec.cientifico]==2){
                    newObject = {...spec, cientifico: spec.cientifico + '(2)'}
                }else{
                    newObject = {...spec, cientifico: `${spec.cientifico.slice(0,-3)}(${String(newA[spec.cientifico])})`}
                }
                newA[spec.cientifico]++;
            }else{  
                 newA[spec.cientifico]=2;
            }
            return newObject
        })

        const speciesResultInvador =  speciesResult.filter((item) => {
            return item.invasor=='true'
        })

        const speciesResultNoInvador =  speciesResult.filter((item) => {
            return item.invasor=='false'
        })
        
        const columns = [{
            dataField: 'comun',
            text: 'Comun',
            },{
            dataField: 'cientifico',
            text: 'Cientifico'
            }, {
            dataField: 'total_cientifico',
            text: 'Cantidad'
            }, {
            dataField: 'subespecie',
            text: 'Subespecie Enlistada'
            }, {
            dataField: 'categoria',
            text: 'Categoria '
            }, {
            dataField: 'distribution',
            text: 'Distribution '
            }, {
            dataField: 'ivi100',
            text: 'Valor de Importancia'
            }, {
            dataField: 'densidad',
            text: 'Densidad '
            }, {
            dataField: 'dominancia',
            text: 'Dominancia '
            }, {
            dataField: 'frequencia',
            text: 'Frequencia '
            },
        ];
        return(
        <div>
            <div className="container">
                <div className='flex-column d-flex justify-content-around align-items-center p-3'>

                    <BootstrapTable 
                    keyField='cientifico' 
                    data={ speciesResultNoInvador } 
                    columns={ columns } 
                    bootstrap4={ true }
                    bordered={ true }
                    classes={ 'speciesTable' }
                    striped
                    hover
                    condensed
                    noDataIndication={ 'No hay datos' }
                    />
                    <h3>Invasores</h3>
                    <BootstrapTable 
                    keyField='cientifico' 
                    data={ speciesResultInvador } 
                    columns={ columns } 
                    bootstrap4={ true }
                    bordered={ true }
                    classes={ 'speciesTable' }
                    striped
                    hover
                    condensed
                    noDataIndication={ 'No hay datos' }
                    />
                </div>
            </div>                
        </div>
        )
    }
}
export default SpeciesDisplay;