import React from "react";
import fetchData from "../fetchData";
import DBDropdown from "./DBDropdown";
import Editable from "./Editable";

class Linea extends React.Component {
    constructor(props) {
		super(props);
		this.setFromSelect = this.setFromSelect.bind(this);
		this.updateValue = this.updateValue.bind(this);

        this.state = {
			linea:'',
			lineaList:[],
			email:useremail,
			values:[]
		};
	}
	
	setFromSelect(choice,nameInState){
		this.setState({
			[nameInState]:choice
		})
		
		let wherevalue = choice 
		let limit = 'null'
		if(choice==='Nueva'){
			wherevalue = '%'
			limit='1'
		}

		fetchData('getList',{table:'linea_mtp', column:'*',where:'nombre_iden', wherevalue:wherevalue,limit:limit}).then(returnData => {
			console.log(returnData)
			const filteredDate = returnData.map((row) => {
				const newrow = {}
				Object.keys(row).forEach(key => {
					if(!key.includes('iden')){
						newrow[key] = row[key]
						if(choice==='Nueva'){
							newrow[key] = ''
						}
					}
				});
				return newrow
			})
			this.setState({
				values:filteredDate,
			})
		})
		console.log(this.state.values)
	}

	updateValue(row,column, value){
		const oldValues = this.state.values
		oldValues[row][column]=value
		this.setState({
			values:oldValues
		});
	}

	componentDidMount(){
		const emailvalue = admin==1 ? '%' : useremail
		fetchData('getList',{table:'linea_mtp', column:'nombre_iden',where:'iden_email', wherevalue:emailvalue }).then(returnData => { 	
			const dataArray = returnData.map((row)=>row.nombre_iden)
			this.setState({
				lineaList:['','Nueva',...dataArray]
			})
		})
	}

    render() {
        return (
            <div>
                <div className="h4 titleHeaders">
                    <h4>Nueva Linea MTP</h4>
				</div>

				<DBDropdown
					items={this.state.lineaList}
					nameInState='linea'
					setFromSelect={this.setFromSelect}
					selectedItem={this.state.linea}
				/>

				{this.state.values!==[] &&
					<Editable
						table='linea_mtp'
						selectedColumn='nombre_iden'
						selectedValue={this.state.linea}
						updateValue={this.updateValue}
						values={this.state.values}
					/>
				}



            </div>
        );
    }
}

export default Linea;
