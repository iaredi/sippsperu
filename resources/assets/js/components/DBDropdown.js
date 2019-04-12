import React from "react";
import fetchData from "../fetchData";

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
            <div>
                <select
                    value={this.props.selectedItem}
                    onChange={
						e =>
                        this.props.setFromSelect(e.target.value, this.props.nameInState)
					}
					name={this.props.nameInState}
                >
                    {this.props.items.map(item => (
                        <option key={item} value={item}>
                            {item}
                        </option>
                    ))}
                </select>
            </div>
        );
    }
}

export default DBDropdown;
