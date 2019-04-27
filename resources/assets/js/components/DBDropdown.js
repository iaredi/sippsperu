import React from "react";

class DBDropdown extends React.Component {
    constructor(props) {
        super(props);
		this.state = {
			items: [],
			selectedItem: "",
			validationError: ""
		  }
	}
	
    render() {

        return (
			<div className='p-2'>
				<label className='pr-2'>{this.props.table=='actividad'?'accion':this.props.table}</label>
                <select
					value={this.props.selectedItem}
					selected={this.props.selectedItem}
                    onChange={
						e =>
                        this.props.setFromSelect(this.props.table,e.target.value)
					}
					name={"select"+this.props.table}
                >
                    { this.props.items.sort().map(item => (
                        <option key={item} value={item===''?'notselected':item}>
                            {item}
                        </option>
                    ))}
                </select>
            </div>
        );
    }
}

export default DBDropdown;
