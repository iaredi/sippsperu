import React from "react";
import BootstrapTable from "react-bootstrap-table-next";
import "react-bootstrap-table-next/dist/react-bootstrap-table2.min.css";

class InfraTable extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      dataInfra : [
        {
          elemento: "Trocha",
          longitud: (this.props.infraInfo.bordo / 1000).toPrecision(4)
        },
        {
          elemento: "Pavimento Rigido",
          longitud: (this.props.infraInfo.pavimentoRigido / 1000).toPrecision(4)
        },
        {
          elemento: "Pavimento Basico",
          longitud: (this.props.infraInfo.pavimentoBasico / 1000).toPrecision(4)
        },
        {
          elemento: "Asfaltado",
          longitud: (this.props.infraInfo.asfaltado / 1000).toPrecision(4)
        }, 
        {
          elemento: "Edificion",
          longitud: "-",
          densidad: this.props.infraInfo.infCount
        },
        {
          elemento: "Afirmado",
          longitud: (this.props.infraInfo["linea de transmision"] / 1000).toPrecision(4)
        },
        {
          elemento: "TOTAL",
          longitud: ((
            this.props.infraInfo["linea de transmision"]+
            this.props.infraInfo.bordo+
            this.props.infraInfo.pavimentoBasico+
            this.props.infraInfo.pavimentoRigido+
            this.props.infraInfo.asfaltado
            ) / 1000).toPrecision(4),
          densidad: this.props.infraInfo.infCount
        },
        {
          elemento: "RAZÓN DE FRAGMENTACIÓN",
          longitud: (1/(
            this.props.infraInfo.afirmado+
            this.props.infraInfo.asfaltado+
            this.props.infraInfo["pavimento basico"]+
            this.props.infraInfo["pavimento rigido"]+
            this.props.infraInfo.proyectado+
            this.props.infraInfo["sin afirmar"]+
            this.props.infraInfo["red vecinal sin informacion"]+
            this.props.infraInfo.trocha
            )).toPrecision(4)
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

        var uAnalisisTxt='';
        var este='';
        if(infotype=='udp'){
            uAnalisisTxt='En esta Unidad de Paisaje (UP) ';
            este=' esta ';
        }else{
            uAnalisisTxt='En este Pol\xEDgono ';
            este=' esta ';
        }
    
        const descriptionString = uAnalisisTxt + idennum + " intervienen los siguientes elementos de infraestructura: " 
        + existingNameList + " \n. La raz\xF3n de fragmentaci\xF3n\n    de"+este+uAnalisis+"es igual a " + this.state.dataInfra[9].longitud 
        + ". De tipos de elementos lineales, lo m\xE1s\n    predominante es " + maxlinea[0] + " que ocupan " + maxlinea[1] 
        + " kilometros\n    lineales.";

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
