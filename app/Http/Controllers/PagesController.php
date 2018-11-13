<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){
        return view('pages/index');
    }

    public function login(){
        return view('pages/login');
    }
    public function admin(){
        return view('pages/admin');
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
    public function ingresarexcel(){
        return view('pages/ingresarexcel');
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
   
}

