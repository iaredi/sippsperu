import React from 'react';
import ReactDOM from 'react-dom';
import Normaapp from './components/Normaapp'
import Intersection from './components/Intersection'
import "./leaflet.css";
import "./images/marker-shadow.png";
import "./images/marker-icon-2x.png";

ReactDOM.render(infotype=='in'?<Intersection/>:<Normaapp/>, document.getElementById('app'));