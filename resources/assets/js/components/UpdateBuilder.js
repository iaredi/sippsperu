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
		this.getDropDownChoices = this.getDropDownChoices.bind(this);

        this.state = {
			choiceList:{[this.props.table]:[]},
			selectedItem:{[this.props.table]:''},
			values:{},
			email:useremail,
			submitDisabled:true,
			upstreamLoaded:false
			
		};
	}
	
	setFromSelect(table,choice){ 
		this.setState((prevState) => (
			{
				selectedItem:{
					...prevState.selectedItem,
					[table]:choice 
				}
			}
		));
		if(table==this.props.table){
			let wherevalue = choice 
			let limit = 'null'
			if(choice==='Nuevo'){
				wherevalue = '%'
				limit='1'
				if (!this.state.upstreamLoaded){
					Object.entries(this.props.upstreamTables).forEach((keyValue,i,array)=>{
						const lastInArray= (i+1)==array.length?true:false
						this.getDropDownChoices(keyValue[0],keyValue[1],true,lastInArray)
					})
				}

			}
			fetchData('getList',{table:this.props.table, column:'*',where:this.props.displayColumn, wherevalue:wherevalue,limit:limit}).then(returnData => {
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
		localStorage.setItem(this.props.table, JSON.stringify({[this.state.selectedItem[this.props.table]]:this.state.values}));
		localStorage.setItem('upstream', JSON.stringify(this.state.selectedItem));
	}

	getDropDownChoices(table,displayColumn,upstream=false, lastInArray=false){
		const emailvalue = admin==1 ? '%' : useremail
		const requestObject ={table:table, column:displayColumn}
		if (!upstream){
			requestObject['where']='iden_email'
			requestObject['wherevalue']=emailvalue
		}
		fetchData('getList',requestObject).then(returnData => {
			const dataArray = returnData.map((row)=>row[displayColumn])
			if(!upstream){
				dataArray.unshift('Nuevo')
			}
			this.setState((prevState) => (
				{
					choiceList:{
						...prevState.choiceList,
						[table]:['',...dataArray]
					}
				}
			));
			if(lastInArray){
				this.setState({upstreamLoaded:true})
			}
			
			if(!upstream){
				//Deal with local storage
				const oldSelectionObject = localStorage.getItem(this.props.table)
					? JSON.parse(localStorage.getItem(this.props.table))
					:null
				const oldSelectionName= oldSelectionObject ? Object.keys(oldSelectionObject)[0]:null
				const oldValues = oldSelectionName && dataArray.includes(oldSelectionName) ? oldSelectionObject[oldSelectionName] : {}
				if (oldSelectionObject){
					Object.entries(this.props.upstreamTables).forEach((keyValue,i,array)=>{
						const lastInArray= (i+1)==array.length?true:false
						this.getDropDownChoices(keyValue[0],keyValue[1],true,lastInArray)
					})
					this.setState((prevState) => (
						{
							selectedItem:JSON.parse(localStorage.getItem('upstream')),
							values:oldValues
						}
					));
				}
				// this.setState((prevState) => (
				// 	{
				// 		selectedItem:{
				// 			...prevState.selectedItem,
				// 			[this.props.table]:oldSelectionName 
				// 		},
				// 		values:oldValues
				// 	}
				// ));
			}
		})
	}
	

	componentDidMount(){
		this.getDropDownChoices(this.props.table, this.props.displayColumn, false)
	}

    render() {
        return (
			<div>
			<form 
				id="measurementform" 
				method="post"
				onSubmit={this.handleSubmit} 
			>

               

				{this.state.choiceList[this.props.table].length>0 &&
					<DBDropdown
						key={this.props.table}
						items={this.state.choiceList[this.props.table]}
						table={this.props.table}
						setFromSelect={this.setFromSelect}
						selectedItem={this.state.selectedItem[this.props.table]}
					/>
				}
				
				{this.state.selectedItem[this.props.table]==='Nuevo' && this.state.upstreamLoaded &&
					<div>
					{Object.keys(this.props.upstreamTables).map((upstreamTable) => {
						
						return (
							this.state.choiceList[upstreamTable] &&
							<DBDropdown
							key={upstreamTable}
							table={upstreamTable}
							items={this.state.choiceList[upstreamTable]}
							setFromSelect={this.setFromSelect}
							selectedItem={this.state.selectedItem[upstreamTable]}
							/>
							)
						})
					}
					</div>
				}
				{Object.keys(this.state.values).length>0 && !(this.state.selectedItem[this.props.table]==='Nuevo' && !this.state.upstreamLoaded) &&
					<div>
						<Editable
							
							table={this.props.table}
							selectedColumn={this.props.displayColumn}
							selectedItem={this.state.selectedItem[this.props.table]}
							updateValue={this.updateValue}
							handleSubmit={this.handleSubmit}
							rows={this.state.values} 
						/>
						<input 
							type="submit" 
							className="border border-secondary btn btn-success mySubmit p-2 m-2"
						/>
					</div>
				}
			</form>

            </div>
        );
    }
}

export default UpdateBuilder;
