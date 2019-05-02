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
		const finalSpeciesResultInvador = speciesResultInvador.map((spec,ind) => {
			spec['numero']=ind+1;
            return spec
		})
		const finalSpeciesResultNoInvador = speciesResultNoInvador.map((spec,ind) => {
			spec['numero']=ind+1;
            return spec
        })
        
        const columns = [
			{
			dataField: 'numero',
			text: '#',
			},
			{
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
			if(this.props.lifeform=='arbol'||this.props.lifeform=='arbusto'){
				columns.push(
				  {
					dataField: 'dn',
					text: 'Diametro *'
				  }, {
					dataField: 'altura',
					text: 'Altura *'
				  },
				)
			  }
            columns.push(
				
              {
                dataField: 'abundancia',
                text: 'Abundancia'
              }, {
                dataField: 'abundancia_relativa',
                text: 'Abundancia Relativa'
              },   {
                dataField: 'frequencia',
                text: 'Frequencia '
              },
            )
            //This could be combined with the part below
            if(this.props.lifeform=='hierba'||this.props.lifeform=='arbol'||this.props.lifeform=='arbusto'){
              columns.push(
                
				{
					dataField: 'dominancia',
					text: 'Dominancia **'
				  },
                {
                  dataField: 'densidad_relativa',
                  text: 'Densidad Relativa ***'
				},
				{
					dataField: 'ivi100',
					text: 'Valor de Importancia'
				  }
                )
            }
            

          }

        return(
        <div>
            <div className="container">
                <div className='flex-column d-flex justify-content-around align-items-center p-3'>
					<h5>No Invasores</h5>
                    <BootstrapTable 
                    keyField='cientifico' 
                    data={ finalSpeciesResultNoInvador } 
                    columns={ columns } 
                    bootstrap4={ true }
                    bordered={ true }
                    classes={ 'speciesTable' }
                    striped
                    hover
                    condensed
                    noDataIndication={ 'No hay datos' }
                    />
                    <h5>Invasores</h5>
                    <BootstrapTable 
                    keyField='cientifico' 
                    data={ finalSpeciesResultInvador } 
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
				{(this.props.lifeform=='hierba'||this.props.lifeform=='arbol'||this.props.lifeform=='arbusto')&&this.props.speciesResult.length>0&&
				<div id='densidadTotalDiv'>
					<h6 id ='densidadTotalHeader'>Densidad total de {this.props.lifeform}: {this.props.speciesResult[0]['densidad_total']} ****</h6>
				</div>
				}
            </div>                
        </div>
        )
    }
}
export default SpeciesDisplay;