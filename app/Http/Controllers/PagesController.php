<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){
        return view('pages/mostrarmapas');
    }
    public function login(){
        return view('pages/login');
	}
	public function cambiarlinea(){
        return view('pages/cambiarlinea');
	}
	public function actividad(){
        return view('pages/actividad');
    }
    public function cultivo(){
        return view('pages/cultivo');
    }
    public function admin(){
        return view('pages/admin');
	}
	public function dlexample(){
        return view('pages/dlexample');
    }
    public function logout(){
        return view('pages/logout');
    }
    public function register(){
        return view('pages/register');
    }
    public function ingresardatos(){
        return view('pages/ingresardatos');
    }
    public function descargar(){
        return view('pages/descargar');
	}
	public function descargarfile(){
        return view('pages/descargarfile');
    }
    public function descargarespecie(){
      return view('pages/descargarespecie');
    }
    public function cargarshapesadmin(){
        return view('pages/cargarshapesadmin');
    }
    public function udpmapa(){
        return view('pages/udpmapa');
    }
    public function ingresarexcel(){
        return view('pages/ingresarexcel');
    }
    public function mostrarnormas(){
      return view('pages/mostrarnormas');
  }
    public function mostrarmapas(){
        return view('pages/mostrarmapas');
    }
    public function thanks(){
        return view('pages/thanks');
    }
    public function reset_1(){
        return view('pages/reset_1');
    }
    public function reset_2(){
        return view('pages/reset_2');
    }
    public function cargarshapes(){
        return view('pages/cargarshapes');
    }  
    public function privacy(){
      return view('pages/privacy');
    }
    public function processUsershapes(){
        return view('pages/processUsershapes');
    }
    public function contaminantes(){
        return view('pages/contaminantes');
    }
}

