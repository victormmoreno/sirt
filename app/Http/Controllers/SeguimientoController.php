<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\{Session};
use Illuminate\Http\Request;
use App\Models\Gestor;
use App\User;

class SeguimientoController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {

    if ( Session::get('login_role') == User::IsDinamizador() ) {
      return view('seguimiento.dinamizador.index', [
        'gestores' => Gestor::ConsultarGestoresPorNodo(auth()->user()->dinamizador->nodo_id)->pluck('nombres_gestor', 'id'),
        // 'lineas' => $this->getLineaRepository()->getAllLineaNodo(auth()->user()->dinamizador->nodo_id)->lineas->pluck('nombre', 'id')
      ]);
    }

  }

}
