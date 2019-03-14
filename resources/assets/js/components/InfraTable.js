import React from "react";
import BootstrapTable from "react-bootstrap-table-next";
import "react-bootstrap-table-next/dist/react-bootstrap-table2.min.css";

class InfraTable extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      dataInfra : [
        {
          elemento: "Bordo",
          longitud: (this.props.infraInfo.bordo / 1000).toPrecision(4),
          densidad: "-"
        },
        {
          elemento: "Calle",
          longitud: (this.props.infraInfo.calle / 1000).toPrecision(4),
          densidad: "-"
        },
        {
          elemento: "Camino",
          longitud: (this.props.infraInfo.camino / 1000).toPrecision(4),
          densidad: "-"
        },
        {
          elemento: "Carretera",
          longitud: (this.props.infraInfo.carretera / 1000).toPrecision(4),
          densidad: "-"
        }, 
        {
          elemento: "Edificion",
          longitud: "-",
          densidad: this.props.infraInfo.infCount
        },
        {
          elemento: "Linea de Transmision",
          longitud: (this.props.infraInfo["linea de transmision"] / 1000).toPrecision(4),
          densidad: "-"
        },
        {
          elemento: "TOTAL",
          longitud: ((
            this.props.infraInfo["linea de transmision"]+
            this.props.infraInfo.bordo+
            this.props.infraInfo.camino+
            this.props.infraInfo.calle+
            this.props.infraInfo.carretera
            ) / 1000).toPrecision(4),
          densidad: this.props.infraInfo.infCount
        },
        {
          elemento: "RAZÓN DE FRAGMENTACIÓN",
          longitud: ((
            this.props.infraInfo["linea de transmision"]+
            this.props.infraInfo.bordo+
            this.props.infraInfo.camino+
            this.props.infraInfo.calle+
            this.props.infraInfo.carretera
            ) / 25000000).toPrecision(4),     
          densidad: "-"
        }
      ]
    };
    this.setText = this.setText.bind(this);
  }
  setText(text) {
    this.props.setText(text);
  }

  componentDidMount(){

    const existingList = this.state.dataInfra.filter(data => {
      const calcNumber = isNaN(data.longitud) ? data.densidad : data.longitud
      return calcNumber>0 && data.elemento!='RAZÓN DE FRAGMENTACIÓN' && data.elemento!='TOTAL'
    })

    const existingNameList = existingList.map(row=>row.elemento)

    const maxlinea = existingList.reduce((acc, val) => {
      if (val.longitud != '-'){
        acc[0] = ( acc[0] === undefined || parseFloat(val.longitud) > acc[1] ) ? val.elemento : acc[0]
        acc[1] = ( acc[1] === undefined || parseFloat(val.longitud) > acc[1] ) ? parseFloat(val.longitud)  : acc[1]
      }
      return acc;
    }, []);

    
    const descriptionString = `En esta Unidad de Paisaje \
    (UP) ${idennum} intervienen los siguintes elementos de infraestructura: ${existingNameList} 
    La razón de fragmentación
    de esta UP es igual a ${this.state.dataInfra[7].longitud}. De tipos de elementos lineales, lo más
    predominante es ${maxlinea[0]} que ocupan ${maxlinea[1]} kilometros
    lineales. En esta UP intervienen también aproximadamente ${this.props.infraInfo.infCount}
    edificaciones de diferentes tipos.`;

  this.setText(descriptionString);

  }

  render() {
    const columnsInfra = [
      {
        dataField: "elemento",
        text: "ELEMENTO"
      },
      {
        dataField: "longitud",
        text: "LONGITUD (km)"
      },
      
      {
        dataField: "densidad",
        text: "DENSIDAD (unidades)"
      }
    ];

       

    return (
      <div>
        <div className="container">
          <div className="flex-column d-flex justify-content-around align-items-center p-3">
            <BootstrapTable
              keyField="elemento"
              data={this.state.dataInfra}
              columns={columnsInfra}
              bootstrap4={false}
              bordered={true}
              classes={"bsparchtable"}
              striped
              hover
              condensed
              noDataIndication={"Cargando..."}
            />
          </div>
        </div>
      </div>
    );
  }
}
export default InfraTable;
