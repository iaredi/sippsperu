import React from "react";
import BootstrapTable from "react-bootstrap-table-next";
import "react-bootstrap-table-next/dist/react-bootstrap-table2.min.css";


function FeatureInfoDisplay(props) {
	var allComplete=true
	if(props.featureInfo.properties[`complete_life`] && props.featureInfo.properties[`complete_life`]=='false'){
		allComplete=false 
	}
	const allTableRows = [];
	if (
		props.featureInfo.properties.displayName == "Linea MTP" ||
		props.featureInfo.properties.displayName == "Unidad de Paisaje"
	) {
	  	let lifeForms = [
			"arbol",
			"arbusto",
			"hierba",
			"ave",
			"herpetofauna",
			"mamifero",
			"Dato acumulado"
		];
	let categoryList = [
		"total_observaciones",
		"distinct_species",
		"dominancia",
		"shannon",
		"biodiversidad_verdadera"
	];
	let myIcons = {
		ave: "🦅",
		arbol: "🌲",
		arbusto: "🌳",
		hierba: "🌱",
		herpetofauna: "🐍",
		mamifero: "🦌"
	};

	lifeForms.map(life => {
		let oneTableRow = {};
		oneTableRow["name"] = life == "herpetofauna" ? "herpetofauna" : life;
		oneTableRow["name"] =
		  	life == "Dato acumulado"
				? oneTableRow["name"]
				: myIcons[life] + oneTableRow["name"];

		categoryList.map((category, index) => {
			if (life == "Dato acumulado") {
				let mysum = 0;
				let denominator = 0;
				lifeForms.slice(0,-1).forEach(lifeForm => {
					

					if (category == "biodiversidad_verdadera") {
						if(!isNaN(Math.exp(props.featureInfo.properties[`shannon_${lifeForm}`]))){ 
							mysum += Math.exp(props.featureInfo.properties[`shannon_${lifeForm}`]) == 1 ? 0
								: Math.exp(props.featureInfo.properties[`shannon_${lifeForm}`]);
							denominator+=1; 
						} 
					} else {
						if(!isNaN(+props.featureInfo.properties[`${category}_${lifeForm}`])){
							 
							mysum += +props.featureInfo.properties[`${category}_${lifeForm}`]
							denominator+=1; 
						}
					}
			});
				if (index > 1) mysum = (mysum / denominator).toPrecision(4);
				oneTableRow[category] = mysum;
				oneTableRow[category] = isNaN(oneTableRow[category])|| denominator==0 ? 'NM' : oneTableRow[category];

			} else {

				
				let newCat = category.replace(`_${life}`, "");
				let myValue = -999.99;
				if (newCat == "biodiversidad_verdadera") {
					myValue = 
						Math.exp(oneTableRow["shannon"]).toPrecision(4) == 1
						? 0
						: Math.exp(oneTableRow["shannon"]).toPrecision(4);
				} else {
				myValue = index > 1
					? (+props.featureInfo.properties[ `${category}_${life}` ]).toPrecision(4)
					: props.featureInfo.properties[`${category}_${life}`];
				}
				oneTableRow[newCat] = myValue;
				oneTableRow[newCat] = isNaN(oneTableRow[newCat]) ? 'NM' : oneTableRow[newCat];
				if(category=="total_observaciones" && props.featureInfo.properties[`complete_${life}`]=='false'){
					oneTableRow['total_observaciones'] = oneTableRow['total_observaciones']+'*'
					allComplete=false 
				}
				

				
			}
		});
		allTableRows.push(oneTableRow);


	  });
	}
	const columns = [
		{
			dataField: "name",
			text: "Nombre",
			headerStyle: {
				width: "128px"
			}
		},
		{
			dataField: "total_observaciones",
			text: "Individuos",
			headerStyle: {
				width: "80px"
			}
		},
		{
			dataField: "distinct_species",
			text: "Especies Distintas",
			headerStyle: {
				width: "80px"
			}
		},
		{
			dataField: "dominancia",
			headerStyle: {
				width: "92px"
			},
			text: "Dominancia",
			classes: "testme"
		},
		{
			dataField: "shannon",
			headerStyle: {
				width: "62px"
			},
			text: "Shannon"
		},
		{
			dataField: "biodiversidad_verdadera",
			headerStyle: {
				width: "92px"
			},
			text: "Biodiversidad Verdadera",
			classes: "testme"
		}
	];

	return (
	  <div>
		<div className="container">
		  <div className="flex-column d-flex justify-content-around align-items-center p-1 centeralign">
			 {props.clicked && (
			   <div>
				<div className="font-weight-bold">
				  {props.featureInfo.properties.displayName+" : "}
				  
					{props.featureInfo.properties[
					  props.featureInfo.properties.featureColumn
					]
					}
				</div>
				<div>
				  lat : {props.clickLocation.lat.toPrecision(6)}, 
				  lng : {props.clickLocation.lng.toPrecision(6)}
				  </div>
				</div>
				)
			}
		  	</div>
		</div>
		<BootstrapTable
		  keyField="name"
		  data={allTableRows}
		  columns={columns}
		  bordered={true}
		  classes={"featureInfoTable"}
		  striped
		  hover
		  condensed
		  noDataIndication={"No hay datos"}
		/>
		{(props.featureInfo.properties.displayName == "Linea MTP" ||
		props.featureInfo.properties.displayName == "Unidad de Paisaje") && !allComplete  &&
			<div className='centeralign'>
				<p className='makeBold'>{props.featureInfo.properties.displayName == "Unidad de Paisaje"?  "*Hay lineas incompletas en esta UDP*"   :'* significa que datos son de un linea MTP incompleta' }</p>
			</div>
		}
	  </div>
	  
	);
  
}

export default FeatureInfoDisplay;
