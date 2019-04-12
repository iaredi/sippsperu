import React from "react";

class MakeRow extends React.Component {
    constructor(props) {
		super(props);
		this.handleChange = this.handleChange.bind(this);
	}

	handleChange (event) {
		//updateValidation(runValidator(this.props.row[keyColumn]))
		this.props.updateValue(this.props.nameInState,this.props.rowId, event.target.name, event.target.value)
	  };

    render() {
		const keyColumns = Object.keys(this.props.row)
		keyColumns.sort((a,b)=>{
			if(a.includes('fin')) return 1;
			if(b.includes('fin')) return -1;
		})
		keyColumns.filter((keyColumn)=>{
			return !keyColumn.includes('rowId')
		})
	
        return (
			<div>
				{keyColumns.map((keyColumn,i2)=>{ 
					const notNullValue = this.props.row[keyColumn]==null?'':this.props.row[keyColumn]						
					return(
						<div key={this.props.rowId+keyColumn}>
							<label >{keyColumn}</label>
							<input 
								type='text' 
								//className={runValidator(this.props.row[keyColumn])}
								name={keyColumn}
								value={notNullValue}
								onChange={this.handleChange}
								>
							</input>
						</div>
					) 
				})
				}
			</div>
    	);
    }
}

export default MakeRow;
