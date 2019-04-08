import React from "react";

class MakeRow extends React.Component {
    constructor(props) {
		super(props);
		this.handleChange = this.handleChange.bind(this);
	}

	handleChange (event) {
		this.props.updateValue(this.props.i, event.target.name, event.target.value)
	  };

    render() {
		const rowKeys = Object.keys(this.props.row)
		rowKeys.sort((a,b)=>{
			if(a.includes('fin')) return 1;
			if(b.includes('fin')) return -1;
		})
	
        return (
			<div>
				{rowKeys.map((keyColumn,i2)=>{ 
					const notNullValue = this.props.row[keyColumn]==null?'':this.props.row[keyColumn]						
					return(
						<div key={this.props.i+keyColumn}>
							<label >{keyColumn}</label>
							<input 
								type='text' 
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
