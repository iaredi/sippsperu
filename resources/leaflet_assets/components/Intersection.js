import React from "react";
import BootstrapTable from "react-bootstrap-table-next";
import "react-bootstrap-table-next/dist/react-bootstrap-table2.min.css";

class Normaapp extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
		objects:[]
    };
  }

  componentDidMount() {
    async function getIntersection(udpiden) {
      let myapi = "https://biodiversidadpuebla.online/api/getintersection";
      if (window.location.host == "localhost:3000")
        myapi = "http://localhost:3000/api/getintersection";
      const rawResponse = await fetch(myapi, {
        method: "POST",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;",
          mode: "cors"
        },
        body: JSON.stringify({
          udpiden: udpiden,
        })
      });
      let dataResult = await rawResponse.json();
      return dataResult;
    }

	getIntersection(idennum).then(intersectionResult => {
		console.log(intersectionResult)
		const objects =[{'object':'edif','name':'edif1',}]
		this.setState(() => ({
			objects:intersectionResult
		}));        
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
