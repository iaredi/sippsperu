import React from "react";

class GeomEditable extends React.Component {
    constructor(props) {
		super(props);
	}

    render() {
        return (
			<div>

			{this.props.tipo_geom==='punto' &&
				<div>
				<div> 
					<span className='overflowSpan'>
						<label className='reactColumns' >longitud</label>
						<label className='reactColumns' >latitud</label>
					</span>
				</div>
				<div>
					<span className='overflowSpan'>
						<input 
							type='text'
							className='reactColumns '
							name={'row0*actividad*longitud'}
							>
						</input>

						<input 
							type='text'
							className='reactColumns '
							name={'row0*actividad*latitud'}
							>
						</input>
					</span>
				</div>
				</div>
			}
			{this.props.tipo_geom==='poligono' &&				
				<div>
				<label htmlFor='shp'>.shp</label>
				<input type="file" required name="shp" id="shp"></input>
				<br/>

				<label htmlFor='shx'>.shx</label>
				<input type="file" required name="shx" id="shx"></input>
				<br/>

				<label htmlFor='dbf'>.dbf</label>
				<input type="file" required name="dbf" id="dbj"></input>
				<br/>

				<label htmlFor='prj'>.prj</label>
				<input type="file" required name="prj" id="prj"></input>
				<br/>

				</div>
			}

			</div>
        );
    }
}

export default GeomEditable;
