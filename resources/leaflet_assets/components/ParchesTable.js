import React from "react";
import BootstrapTable from "react-bootstrap-table-next";
import "react-bootstrap-table-next/dist/react-bootstrap-table2.min.css";

class ParchesTable extends React.Component {
  constructor(props) {
    super(props);
  }
  render() {
    const descripcioSet = new Set();
    const continuoList =[]
    const allParches = this.props.udpsoils.map(parche=>{
      parche.continuidad = parche.aislado? "Aislado":"Continuo"
      parche.cobertura = ((100 * parche.area / parche.totalarea).toPrecision(4)).toString()+"%"
      parche.area =(parche.area * (25 / 0.00218206963154496)).toPrecision(4)
      descripcioSet.add(parche.descripcio)
      if (!parche.aislado) continuoList.push(parche.descripcio)
      return parche
    })

    function compare(a,b) {
      if (a.descripcio < b.descripcio)
        return -1;
      if (a.descripcio > b.descripcio)
        return 1;
      return 0;
    }
    
    allParches.sort(compare);


    
    const columns = [
      {
        dataField: "descripcio",
        text: "Tipo de Parche"
      },
      {
        dataField: "cobertura",
        text: "Cobertura"
      },
      {
        dataField: "continuidad",
        text: "Continuidad"
      },
      {
        dataField: "area",
        text: "Area (km)"
      }
    ];

    const allParchesSum=[
      {name:"REQUEZA DE TIPOS DE PARCHE",number:descripcioSet.size},
      {name:"ABUNDANCIA DE PARCHEA",number:allParches.length},
      {name:"PARCHES CONTINUOS",number: continuoList.length},
      {name:"RAZON DE CONTINUIDAD DE PARCHES",number:(continuoList.length / allParches.length).toPrecision(4)},
      {name:"DOMINANCIA ENTRE TAMANOS DE PARCHE",number:0},
      {name:"DOMINANCIA ENTRE TIPOS DE PARCHE",number:0}
    ]
    const columnsSum = [
      {
        dataField: "name",
        text: " "
      },
      {
        dataField: "number",
        text: " "
      }
    ];
    const agualength =(allParches[0].agualength * (20 / 0.186914851250046)).toPrecision(4)
    const dataAguaLinea=[
      {elemento:"Corriente  de agua",longitud:agualength, area:"-",densidad:"-"},
      {elemento:"Cuerpo de agua",longitud:"-", area:"-",densidad:"-"},
      {elemento:"Manantial",longitud: "-", area:"-",densidad:"-"},
      {elemento:"TOTAL",longitud:agualength, area:"-",densidad:"-"}
    ]
    const columnsAguaLinea = [
      {
        dataField: "elemento",
        text: "ELEMENTO"
      },
      {
        dataField: "longitud",
        text: "LONGITUD (m)"
      },
      {
        dataField: "area",
        text: "AREA (m^2)"
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
              keyField="gid"
              data={allParches}
              columns={columns}
              bootstrap4={false}
              bordered={true}
              classes={"bsparchtable"}
              striped
              hover
              condensed
              noDataIndication={"No hay datos"}
            />
          </div>
        </div>

        <div className="container">
          <div className="flex-column d-flex justify-content-around align-items-center p-3">
            <BootstrapTable
              keyField="name"
              data={allParchesSum}
              columns={columnsSum}
              bootstrap4={false}
              bordered={true}
              classes={"bsparchtable"}
              striped
              hover
              condensed
              noDataIndication={"No hay datos"}
            />
          </div>
        </div>

        <div className="container">
          <div className="flex-column d-flex justify-content-around align-items-center p-3">
            <BootstrapTable
              keyField="elemento"
              data={dataAguaLinea}
              columns={columnsAguaLinea}
              bootstrap4={false}
              bordered={true}
              classes={"bsparchtable"}
              striped
              hover
              condensed
              noDataIndication={"No hay datos"}
            />
          </div>
        </div>

      </div>
    );
  }
}
export default ParchesTable;
