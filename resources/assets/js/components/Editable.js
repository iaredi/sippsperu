import React from "react";
import MakeRow from "./MakeRow"

class Editable extends React.Component {
    constructor(props) {
        super(props);
	}
	
    render() {
        return (
			<div>
				{this.props.values.map((row,i) => 
					(
						<MakeRow 
							key={i}
							row={row}
							i={i}
							updateValue={this.props.updateValue}
						/>
					)
				)}
            </div>
        );
    }
}

export default Editable;
