import React from "react";
import BootstrapTable from 'react-bootstrap-table-next';
import 'react-bootstrap-table-next/dist/react-bootstrap-table2.min.css';

class SpeciesDisplay extends React.Component {
    constructor(props) {
        super(props);
    }
    render(){

        const oldspeciesResult=this.props.speciesResult

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
            }
          ]
          if (infotype=='normas'){
            columns.push(
              {
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
              }
            )
          }else{
            columns.push(
              {
                dataField: 'abundancia',
                text: 'Abundancia'
              }, {
                dataField: 'abundancia_relativa',
                text: 'Abundancia Relativa'
              },  {
                dataField: 'dominancia',
                text: 'Dominancia '
              }, {
                dataField: 'frequencia',
                text: 'Frequencia '
              },
            )
            //This could be combined with the part below
            if(this.props.lifeform=='hierba'||this.props.lifeform=='arbol'||this.props.lifeform=='arbusto'){
              columns.push(
                {
                  dataField: 'ivi100',
                  text: 'Valor de Importancia'
                },
                {
                  dataField: 'densidad',
                  text: 'Densidad '
                }
                )
            }
            if(this.props.lifeform=='arbol'||this.props.lifeform=='arbusto'){
              columns.push(
                {
                  dataField: 'dn',
                  text: 'Diametro'
                }, {
                  dataField: 'altura',
                  text: 'Altura'
                },
              )
            }



          }
            
            
            
        





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
                    <h6>Invasores</h6>
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