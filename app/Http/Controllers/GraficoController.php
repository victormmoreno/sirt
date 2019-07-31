<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Session};
use App\{User};

class GraficoController extends Controller
{
  /**
  * Página inicial de gráficos
  * @return Response
  */
  public function index()
  {
    if ( Session::get('login_role') == User::IsDinamizador() ) {
      return view('grafico.dinamizador.index');
    }
  }

  /**
   * Vista de gráficos para las articulaciones
   * @return Response
   */
  public function articulacionesGraficos()
  {
    if ( Session::get('login_role') == User::IsDinamizador() ) {
      return view('grafico.dinamizador.articulacion');
    }
  }

  /**
   *
   * @param int $id Id del nodo
   * @return Response
   */
  public function articulacionesNodoGrafico($id)
  {
    if ( request()->ajax() ) {
      
    }
  }
}
