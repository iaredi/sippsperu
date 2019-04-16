import React from "react";

class Editable extends React.Component {
    constructor(props) {
		super(props);
		this.handleChange = this.handleChange.bind(this);
	}

	handleChange (event) {
		this.props.updateValue(event.target.name.split('*')[0], event.target.name.split('*')[2], event.target.value)
	  };
	
    render() {
		const keyColumns = Object.keys(this.props.rows["row0"])
		keyColumns.sort((a,b)=>{
			if(a.includes('fin')) return 1;
			if(b.includes('fin')) return -1;
		})

        return (
			<div className='p-2'>
				<input type="hidden" name="mode" value={this.props.selectedItem==='Nuevo'?'Datos Nuevos':'Datos Existentes'}/>
				<input type="hidden" name="table" value={this.props.table}/>
				<input type="hidden" name="selectedcolumn" value={this.props.selectedColumn}/>
				<input type="hidden" name="_token" value={csrf_token}/>

				<div>
					<span className='overflowSpan'>
						{
							keyColumns.map((keyColumn) => {
								return(
									<label 
										key={keyColumn}
										className='reactColumns'
									>{keyColumn}</label>
								)
							})
						}
					</span>
				</div>
			<div>
				{Object.entries(this.props.rows).map((row) => 
					(
					<span className='overflowSpan' key={row[0]}>
						{
							keyColumns.map((keyColumn)=>{ 
							const notNullValue = row[1][keyColumn]==null?'':row[1][keyColumn]						
							return(
								<input 
									key={row[0]+keyColumn}
									type='text'
									className='reactColumns '
									//className={runValidator(this.props.row[keyColumn])}
									name={row[0]+'*'+this.props.table+'*'+keyColumn}
									value={notNullValue}
									onChange={this.handleChange}
									>
								</input>
							) 
							})
						}
					</span>	
					
					)
				)}
				</div>
            </div>
        );
    }
}

export default Editable;
