import React from "react";
import BootstrapTable from "react-bootstrap-table-next";
import "react-bootstrap-table-next/dist/react-bootstrap-table2.min.css";

class FeatureInfoDisplay extends React.Component {
  constructor(props) {
    super(props);
  }
  render() {
    const allTableRows = [];
    if (
      this.props.featureInfo.properties.displayName == "Linea MTP" ||
      this.props.featureInfo.properties.displayName == "Unidad de Paisaje"
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
            let mysum = -999.99;
            if (category == "biodiversidad_verdadera") {
              mysum = Math.exp(this.props.featureInfo.properties[`shannon_ave`]) == 1 ? 0
                  : Math.exp(this.props.featureInfo.properties[`shannon_ave`]);
              mysum += Math.exp( this.props.featureInfo.properties[`shannon_hierba`] ) == 1 ? 0
                  : Math.exp( this.props.featureInfo.properties[`shannon_hierba`] );
              mysum += Math.exp( this.props.featureInfo.properties[`shannon_arbusto`] ) == 1 ? 0
                  : Math.exp( this.props.featureInfo.properties[`shannon_arbusto`] );
              mysum += Math.exp(this.props.featureInfo.properties[`shannon_arbol`]) == 1 ? 0
                  : Math.exp( this.props.featureInfo.properties[`shannon_arbol`] );
              mysum += Math.exp( this.props.featureInfo.properties[`shannon_herpetofauna`] ) == 1 ? 0
                  : Math.exp( this.props.featureInfo.properties[`shannon_herpetofauna`] );
              mysum += Math.exp( this.props.featureInfo.properties[`shannon_mamifero`] ) == 1 ? 0
                  : Math.exp( this.props.featureInfo.properties[`shannon_mamifero`] );
            } else {
              mysum =
                +this.props.featureInfo.properties[`${category}_ave`] +
                +this.props.featureInfo.properties[`${category}_hierba`] +
                +this.props.featureInfo.properties[`${category}_arbusto`] +
                +this.props.featureInfo.properties[`${category}_arbol`] +
                +this.props.featureInfo.properties[`${category}_herpetofauna`] +
                +this.props.featureInfo.properties[`${category}_mamifero`];
            }
            if (index > 1) mysum = (mysum / 6).toPrecision(4);
            oneTableRow[category] = mysum;
          } else {
            let newCat = category.replace(`_${life}`, "");
            let myValue = -999.99;
            if (newCat == "biodiversidad_verdadera") {
              myValue =
                Math.exp(oneTableRow["shannon"]).toPrecision(4) == 1
                  ? 0
                  : Math.exp(oneTableRow["shannon"]).toPrecision(4);
            } else {
              myValue =
                index > 1
                  ? (+this.props.featureInfo.properties[
                      `${category}_${life}`
                    ]).toPrecision(4)
                  : this.props.featureInfo.properties[`${category}_${life}`];
            }
            oneTableRow[newCat] = myValue;
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
          <div className="flex-column d-flex justify-content-around align-items-center p-3">
             
             {this.props.clicked && (
               <div>
                <div className="font-weight-bold">
                  {this.props.featureInfo.properties.displayName+" : "}
                  
                    {this.props.featureInfo.properties[
                      this.props.featureInfo.properties.featureColumn
                    ]
                    }
                  
                </div>
                <div>
                  lat : {this.props.clickLocation.lat.toPrecision(6)}, 
                  lng : {this.props.clickLocation.lng.toPrecision(6)}
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
      </div>
    );
  }
}

export default FeatureInfoDisplay;
