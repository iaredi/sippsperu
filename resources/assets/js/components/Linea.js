import React from "react";
import fetchData from "../fetchData";
import DBDropdown from "./DBDropdown";
import Editable from "./Editable";

class UpdateBuilder extends React.Component {
    constructor(props) {
		super(props);
		this.setFromSelect = this.setFromSelect.bind(this);
		this.updateValue = this.updateValue.bind(this);
		this.handleSubmit = this.handleSubmit.bind(this);

        this.state = {
			table:this.props.table,
			choiceList:[],
			selectedItem:'',
			values:{},
			email:useremail,
			submitDisabled:true
		};
	}
	
	setFromSelect(choice){
		this.setState({
			selectedItem:choice
		})
		let wherevalue = choice 
		let limit = 'null'
		if(choice==='Nuevo'){
			wherevalue = '%'
			limit='1'
		}
		fetchData('getList',{table:this.state.table, column:'*',where:'nombre_iden', wherevalue:wherevalue,limit:limit}).then(returnData => {
			const filteredDate = returnData.map((row) => {
				const newrow = {}
				Object.keys(row).forEach(key => {
					if(!key.includes('iden')){
						newrow[key] = row[key]
						if(choice==='Nuevo'){
							newrow[key] = ''
						}
					}
				});
				return newrow
			})
			const arrayToObject = (arr) => Object.assign({}, ...arr.map((item,i) => ({['row'+i]: item})))
			this.setState({
				values : arrayToObject(filteredDate)
			})
		})
	}

	updateValue(rowId,column, value){
		this.setState((prevState) => (
			{
				values:{
					...prevState.values,
					[rowId]:{
						...prevState.values[rowId],
						[column]:value
					}
				}
			}
		));
	}

	handleSubmit(e){
		//const local ={[this.state.currentSelect]:this.state.values}
		localStorage.setItem(this.state.table, JSON.stringify({[this.state.selectedItem]:this.state.values}));
	}
	
	componentDidMount(){
		const emailvalue = admin==1 ? '%' : useremail
		fetchData('getList',{table:this.state.table, column:'nombre_iden',where:'iden_email', wherevalue:emailvalue }).then(returnData => { 	
			const dataArray = returnData.map((row)=>row.nombre_iden)

			//Deal with local storage
			const oldSelectionObject = localStorage.getItem(this.state.table)
				? JSON.parse(localStorage.getItem(this.state.table))
				:null
			const oldSelectionName= oldSelectionObject ? Object.keys(oldSelectionObject)[0]:null

			const oldValues = oldSelectionName && dataArray.includes(oldSelectionName) ? oldSelectionObject[oldSelectionName] : {}

			this.setState({
				choiceList:['',...dataArray],
				selectedItem: oldSelectionName,
				values:oldValues
			})
		})
	}

    render() {
        return (
			<div>
			<form 
				id="measurementform" 
				method="post"
				onSubmit={this.handleSubmit} 
			>

                <div className="h4 titleHeaders">
                    <h4> {this.props.table} Existente</h4>
				</div>

				{Object.keys(this.state.choiceList).length>0 &&
					<DBDropdown
						items={this.state.choiceList}
						table={this.state.table}
						setFromSelect={this.setFromSelect}
						selectedItem={this.state.selectedItem}
					/>
				}
					{Object.keys(this.state.values).length>0 &&
						<div>
							<Editable
								table={this.state.table}
								selectedColumn='nombre_iden'
								selectedItem={this.state.selectedItem}
								updateValue={this.updateValue}
								handleSubmit={this.handleSubmit}
								rows={this.state.values} 
							/>
							<input 
								type="submit" 
								className=""
							/>
						</div>
					}
					</form>

            </div>
        );
    }
}

export default UpdateBuilder;
