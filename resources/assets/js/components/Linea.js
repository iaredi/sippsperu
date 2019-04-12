import React from "react";
import fetchData from "../fetchData";
import DBDropdown from "./DBDropdown";
import Editable from "./Editable";

class Linea extends React.Component {
    constructor(props) {
		super(props);
		this.setFromSelect = this.setFromSelect.bind(this);
		this.updateValue = this.updateValue.bind(this);
		this.handleSubmit = this.handleSubmit.bind(this);

        this.state = {
			linea:'',
			lineaList:[],
			email:useremail,
			values:[],
			submitDisabled:true
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
			const filteredDate = returnData.map((row, rowId) => {
				const newrow = {}
				Object.keys(row).forEach(key => {
					if(!key.includes('iden')){
						newrow[key] = row[key]
						newrow['rowId'] = rowId
						if(choice==='Nueva'){
							newrow[key] = ''
						}
					}
				});
				
				return newrow
			})
			const arrayToObject = (arr, keyField) => Object.assign({}, ...arr.map(item => ({[item[keyField]]: item})))
			this.setState({
				values:{
					[nameInState] : arrayToObject(filteredDate,'rowId')}
			})
		})
	}

	updateValue(nameInState, row,column, value){
		
		// this.setState({
		// 	values:oldValues
		// });
		console.log(nameInState, row,column, value)
		this.setState((prevState) => (
			{
				values:{
					...prevState.values,
					[nameInState]:{
						...prevState.values[nameInState],
						[row]:{
							...prevState.values[nameInState][row],
							[column]:value
						}
					}
				}
		  	}
		  ));

	}

	handleSubmit(e){
		console.log('submitted')
		e.preventDefault()
	}
	
	componentDidMount(){
		const emailvalue = admin==1 ? '%' : useremail
		fetchData('getList',{table:'linea_mtp', column:'nombre_iden',where:'iden_email', wherevalue:emailvalue }).then(returnData => { 	
			const dataArray = returnData.map((row)=>row.nombre_iden)
			this.setState({
				lineaList:['',...dataArray]
			})
		})
	}

    render() {
        return (
            <div>
                <div className="h4 titleHeaders">
                    <h4>Cambiar Linea Existente</h4>
				</div>
				<form onSubmit={this.handleSubmit} id="measurementform" method="post">

					<DBDropdown
						items={this.state.lineaList}
						nameInState='linea_mtp'
						setFromSelect={this.setFromSelect}
						selectedItem={this.state.linea}
					/>

					{this.state.values.linea_mtp &&
						<Editable
							nameInState='linea_mtp'
							selectedColumn='nombre_iden'
							selectedValue={this.state.linea}
							updateValue={this.updateValue}
							rows={this.state.values['linea_mtp']}
						/>
					}


					<input type="submit" id="measurementlinea_mtpSubmit" className="border border-secondary btn btn-success mySubmit p-2 m-2"/>
				</form>
            </div>
        );
    }
}

export default Linea;
