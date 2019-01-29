import React from "react";
import BootstrapTable from "react-bootstrap-table-next";
import "react-bootstrap-table-next/dist/react-bootstrap-table2.min.css";

class ParchesTable extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      columns1 : [ { dataField: "gid", text: "Tipo de Parche1" }],
      allParches:[{ area: "test1" }],
      columnsSum:[{ dataField: "name", text: "Tipo de Parche2" }],
      allParchesSum:[{ name: "test2" }],
      columnsAguaLinea:[{ dataField: "elemento", text: "Tipo de Parche3" }],
      dataAguaLinea:[{ elemento: "test3" }]

    }
    this.setText = this.setText.bind(this);

  }
  setText(text) {
      this.props.setText(text);
    }

  componentDidMount(){
    const descripcioSet = new Set();
    const continuoList =[]
    let maxarea = 0
    let parchetotal ={}
    let largestTypeArea=0
    let largestTypeName =''
    let largestTypeCobertura = 0
    let maxname = ''
    let listofareas= {}
    const allParches = this.props.udpsoils.map(parche=>{
      parche.continuidad = parche.aislado? "Aislado":"Continuo"
      parche.cobertura = ((100 * parseFloat(parche.area) / parche.totalarea).toPrecision(4)).toString()+"%"
      parche.area =parseFloat((parseFloat(parche.area) * (2500 / 0.00218206963154496)).toPrecision(4))
      
      
      descripcioSet.add(parche.descripcio)
      maxarea = ((parche.area>maxarea)?parche.area:maxarea)
      maxname = ((parche.area>maxarea)?parche.descripcio:maxname)
      if (parchetotal[parche.descripcio]){
        parchetotal[parche.descripcio] = parseFloat(parche.area) + parchetotal[parche.descripcio]
      }else{
        parchetotal[parche.descripcio]= parseFloat(parche.area)
      }
      

      if (listofareas[parche.descripcio]){
        listofareas[parche.descripcio].push(parche.area.toString())
      }else{
        listofareas[parche.descripcio]=[parche.area.toString()]
      }
      if (parchetotal[parche.descripcio]>largestTypeArea){
        largestTypeName =parche.descripcio
        largestTypeArea = parchetotal[parche.descripcio]
        largestTypeCobertura= largestTypeArea/25
      }
      // largestTypeName = parchetotal[parche.descripcio]>largestTypeArea?parche.descripcio:largestTypeName
      // largestTypeCobertura = parchetotal[parche.descripcio]>largestTypeArea?(largestTypeArea/25):largestTypeCobertura
      // largestTypeArea = parchetotal[parche.descripcio]>largestTypeArea? parchetotal[parche.descripcio]:largestTypeArea
      if (!parche.aislado) continuoList.push(parche.descripcio)
      return parche
    })
    
    function compare(a,b) {
      if (a.descripcio < b.descripcio)
        return -1;
      if (a.descripcio > b.descripcio)
        return 1;
      return 0;
    }
    
    allParches.sort(compare);
    this.setState(prevState => ({
      allParches: allParches
    }));

    
    const columns1 = [
      {
        dataField: "descripcio",
        text: "Parche"
      },
      {
        dataField: "cobertura",
        text: "Cobertura"
      },
      {
        dataField: "continuidad",
        text: "Continuidad"
      },
      {
        dataField: "area",
        text: "Area (h)"
      }
    ];
    this.setState(prevState => ({
      columns1: columns1
    }));
    
    const allParchesSum=[
      {name:"REQUEZA DE TIPOS DE PARCHE",number:descripcioSet.size},
      {name:"ABUNDANCIA DE PARCHEA",number:allParches.length},
      {name:"PARCHES CONTINUOS",number: continuoList.length},
      {name:"RAZON DE CONTINUIDAD DE PARCHES",number:(continuoList.length / allParches.length).toPrecision(4)},
      {name:"DOMINANCIA ENTRE TAMANOS DE PARCHE",number:(maxarea / 2500).toPrecision(4) },
      {name:"DOMINANCIA ENTRE TIPOS DE PARCHE",number:(largestTypeArea / 2500).toPrecision(4) }
    ]
    this.setState(prevState => ({
      allParchesSum: allParchesSum
    }));
    const columnsSum = [
      {
        dataField: "name",
        text: " "
      },
      {
        dataField: "number",
        text: " "
      }
    ];
    this.setState(prevState => ({
      columnsSum: columnsSum
    }));
    const agualength =(allParches[0].agualength * (2000 / 0.186914851250046)).toPrecision(4)
    const aguacount = allParches[0].aguacount;
    const aguaarea = (allParches[0].aguaarea * (2500 / 0.00218206963154496)).toPrecision(4)
    

    const dataAguaLinea=[
      {elemento:"Corriente  de agua",longitud:agualength, area:"-",densidad:"-"},
      {elemento:"Cuerpo de agua",longitud:"-", area:aguaarea,densidad:"-"},
      {elemento:"Manantial",longitud: "-", area:"-",densidad:aguacount},
      {elemento:"TOTAL",longitud:agualength, area:aguaarea,densidad:aguacount}
    ]
    this.setState(prevState => ({
      dataAguaLinea: dataAguaLinea
    }));
    const columnsAguaLinea = [
      {
        dataField: "elemento",
        text: "ELEMENTO"
      },
      {
        dataField: "longitud",
        text: "LONGITUD (h)"
      },
      {
        dataField: "area",
        text: "AREA (h^2)"
      },
      {
        dataField: "densidad",
        text: "DENSIDAD (unidades)"
      }
    ];
    this.setState(prevState => ({
      columnsAguaLinea: columnsAguaLinea
    }));
    console.log(allParches)
    const mystring = `La Unidad de Paisaje ${idennum} \
      (UP) ${idennum}  presenta una riqueza de parches igual a ${descripcioSet.size} y una abundancia de parches \
      igual a ${allParches.length}. De estos parches, ${continuoList.length} son continuos presentando \
      una razón de continuidad de${(continuoList.length / allParches.length).toPrecision(4)}. Dentro de los aproximadamente 25 Km2 que \
      conforman la UP , el Uso de Suelo y Vegetación (USV) más dominante es ${largestTypeName} que representa el ${largestTypeCobertura.toPrecision(4)}% \ 
      del área total de la unidad y está dividido en \
      ${listofareas[largestTypeName].length} parches de ${listofareas[largestTypeName]} hectares respectivamente. Sin embargo, el parche de mayor \
      tamaño corresponde al USV de ${maxarea} un área de\
      aproximadamente ${maxarea} hectares. La dominancia entre tamaños de parche dentro de esta UP es \
      de ${(maxarea / 2500).toPrecision(4)}, mientras que la dominancia entre tipos de parche es igual \
      a ${(largestTypeArea / 2500).toPrecision(4)}. Esta UP presenta además una razón de dispersión hídrica de 0.00096 \
      con corrientes de agua que cubren un total de ${agualength} kilometros lineales; así  \
      como una densidad de cuerpos de agua de ${(aguaarea / 2500).toPrecision(4)} y un área de ${aguaarea} hectares.`

    this.setText(mystring)
  }


  render() {
    return (
      <div>
        <div className="container">
          <div className="flex-column d-flex justify-content-around align-items-center p-3">
            <BootstrapTable
              keyField="area"
              data={this.state.allParches}
              columns={this.state.columns1}
              bootstrap4={false}
              bordered={true}
              classes={"bsparchtable"}
              striped
              hover
              condensed
              noDataIndication={"Cargando..."}
            />
          </div>
        </div>

        <div className="container">
          <div className="flex-column d-flex justify-content-around align-items-center p-3">
            <BootstrapTable
              keyField="name"
              data={this.state.allParchesSum}
              columns={this.state.columnsSum}
              bootstrap4={false}
              bordered={true}
              classes={"bsparchtable"}
              striped
              hover
              condensed
              noDataIndication={"No hay datos"}
            />
          </div>
        </div>

        <div className="container">
          <div className="flex-column d-flex justify-content-around align-items-center p-3">
            <BootstrapTable
              keyField="elemento"
              data={this.state.dataAguaLinea}
              columns={this.state.columnsAguaLinea}
              bootstrap4={false}
              bordered={true}
              classes={"bsparchtable"}
              striped
              hover
              condensed
              noDataIndication={"No hay datos"}
            />
          </div>
        </div>

      </div>
    );
  }
}
export default ParchesTable;
