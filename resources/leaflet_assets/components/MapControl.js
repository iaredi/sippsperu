import React from "react";

class MapControl extends React.Component {
  constructor(props) {
    super(props);
    this.handleSpeciesChange = this.handleSpeciesChange.bind(this);
    this.handleTotalDistinctChange = this.handleTotalDistinctChange.bind(this);
}

    handleSpeciesChange(event) {
    const error = this.props.handleSpeciesChange(event.target.value);
  }

    handleTotalDistinctChange(event) {
    this.props.handleTotalDistinctChange(event.target.value);
  }
    
    render(){
        return(
        <div>
            <div className="row">
                <div className="form-group col-6 border border-secondary p-1 mx-3">
                    <label className="table_option">Eliger Clase</label>
                    <select name='table_option' id='table_option' onChange={this.handleSpeciesChange} className='table_option form-control '>
                        <option value="ave">Ave</option>
                        <option value="hierba">Hierba</option>
                        <option value="herpetofauna">Herpetofauna</option>
                        <option value="arbol">Arbol</option>
                        <option value="arbusto">Arbusto</option>
                        <option value="mamifero">Mamifero</option>
                    </select>
                </div>
            </div>
            <div className="row">
                <div className="form-group col-6 border border-secondary p-1 mx-3">
                    <label className="table_option">Eliger Total Observaciones o Especies Distintos </label>
                    <select name='table_option' id='table_option' onChange={this.handleTotalDistinctChange} className='table_option form-control '>
                        <option value="total_observaciones">Total</option>
                        <option value="distinct_species">Distinct</option>
                    </select>
                </div>
            </div>
        </div>
        )
    }
}

export default MapControl;