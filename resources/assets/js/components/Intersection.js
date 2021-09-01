import React from "react";
import BootstrapTable from "react-bootstrap-table-next";
import "react-bootstrap-table-next/dist/react-bootstrap-table2.min.css";
import fetchData from "../fetchData";

class Normaapp extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
		objects:[]
    };
  }

  componentDidMount() {
	fetchData('getintersection',{udpiden: idennum}).then(intersectionResult => {
		this.setState({objects:intersectionResult});        
	});
  }

  render() {
	const columns = [
        {
          dataField: "object",
          text: "Instrumento"
        },
        {
          dataField: "name",
          text: "Nombre"
        }
	  ];
    return (
      <div>
		<div className="container">
			<div className="flex-column d-flex justify-content-around align-items-center p-3">
				<BootstrapTable
				keyField="name"
				data={this.state.objects}
				columns={columns}
				bootstrap4={false}
				bordered={true}
				classes={"bsparchtable"}
				striped
				hover
				condensed
				noDataIndication={"..."}
				/>
			</div>
		</div>
      </div>
    );
  }
}

export default Normaapp;
