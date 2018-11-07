import React from "react";

class MapControl extends React.Component {
  constructor(props) {
    super(props);
    this.handleSpeciesChange = this.handleSpeciesChange.bind(this);
    this.handleTotalDistinctChange = this.handleTotalDistinctChange.bind(this);
    this.handleOpacityChange = this.handleOpacityChange.bind(this);
    this.handleMaxChange = this.handleMaxChange.bind(this);

}

handleSpeciesChange(event) {
    const error = this.props.handleSpeciesChange(event.target.value);
}
handleTotalDistinctChange(event) {
    this.props.handleTotalDistinctChange(event.target.value);
  }
  handleOpacityChange(event) {
    this.props.handleOpacityChange(event.target.value);
  }
  handleOpacityChange(event) {
    this.props.handleOpacityChange(event.target.value);
  }
  handleMaxChange(event) {
    this.props.handleMaxChange(event.target.value);
  }
    
    render(){
        return(
        <div>
            <div className="row">
                <div className="form-group col-3 border border-secondary p-1 mx-3">
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
                <div className="form-group col-3 border border-secondary p-1 mx-3">
                    <label className="table_option">Eliger Total Observaciones o Especies Distintos </label>
                    <select name='table_option' id='table_option' onChange={this.handleTotalDistinctChange} className='table_option form-control '>
                        <option value="total_observaciones">Total</option>
                        <option value="distinct_species">Distinct</option>
                    </select>
                </div>
            </div>
            <div className="row">
                <div className="form-group col-3 border border-secondary p-1 mx-3">
                    <label className="style_option">Eliger Max Numero por colores</label>
                    <input name='maxNumber' type="number" min="6" value={this.props.mapSettings.maxValue} id='table_optionOpacity' onChange={this.handleMaxChange} className='table_option form-control '/> 
                </div>
            </div>
            <div className="row">
                <div className="form-group col-3 border border-secondary p-1 mx-3">
                    <label className="style_option">Eliger Opacidad</label>
                    <select name='table_option' id='table_optionOpacity' onChange={this.handleOpacityChange} className='table_option form-control '>
                        <option value="1.0">1.0</option>
                        <option value="0.8">0.8</option>
                        <option value="0.6">0.6</option>
                        <option value="0.4">0.4</option>
                        <option value="0.2">0.2</option>
                    </select>
                </div>
            </div>
            
            
            
            
        </div>
        )
    }
}

export default MapControl;