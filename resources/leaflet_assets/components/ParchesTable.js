import React from "react";
import BootstrapTable from "react-bootstrap-table-next";
import "react-bootstrap-table-next/dist/react-bootstrap-table2.min.css";

class ParchesTable extends React.Component {
  constructor(props) {
    super(props);
  }
  render() {

    const allParches = this.props.udpsoils.map(parche=>{
      parche.continuidad = parche.aislado? "Aislado":"Continuo"
      parche.cobertura = (100 * parche.area / parche.totalarea).toPrecision(4)
      parche.area =(parche.area * (25 / 0.00218206963154496)).toPrecision(4)
      
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
        text: "Area"
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
      </div>
    );
  }
}
export default ParchesTable;
