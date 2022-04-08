<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Session};
use App\{User, Models\Nodo};

class IndicadorController extends Controller
{

  public function index()
  {

    if ( Session::get('login_role') == User::IsDinamizador() ) {
      return view('indicadores.dinamizador.index');
    } else if ( Session::get('login_role') == User::IsAdministrador() ) {
      return view('indicadores.administrador.index', [
        'nodos' => Nodo::SelectNodo()->get()
        ]);
    } else if (Session::get('login_role') == User::IsInfocenter()) {
      return view('indicadores.infocenter.index');
    } else {
      return view('indicadores.gestor.index');
    }

  }

  public function form_import_metas()
  {
    return view('indicadores.administrador.register_metas');
  }

}
