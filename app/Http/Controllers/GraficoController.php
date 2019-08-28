<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Session};
use App\Repositories\Repository\{ArticulacionRepository, UserRepository\GestorRepository, LineaRepository, EdtRepository};
use App\{User, Models\Gestor, Models\LineaTecnologica, Models\TipoEdt};

class GraficoController extends Controller
{

  private $articulacionRepository;
  private $gestorRepository;
  private $lineaRepository;

  public function __construct(ArticulacionRepository $articulacionRepository, GestorRepository $gestorRepository, LineaRepository $lineaRepository)
  {
    $this->gestorRepository = $gestorRepository;
    $this->lineaRepository = $lineaRepository;
  }
  /**
  * Página inicial de los gráficos
  * @return Response
  * @author Victor Manuel Moreno Vega
  */
  public function index()
  {
    if ( Session::get('login_role') == User::IsDinamizador() ) {
      return view('grafico.dinamizador.index');
    }
  }

  /**
   * Vista para mostrar los gráficos de las edts
   * @return Response
   * @author Victor Manuel Moreno Vega
   */
  public function edtsGraficos()
  {
    if ( Session::get('login_role') == User::IsDinamizador() ) {
      return view('grafico.dinamizador.edt', [
        'gestores' => Gestor::ConsultarGestoresPorNodo(auth()->user()->dinamizador->nodo_id)->pluck('nombres_gestor', 'id'),
        'lineas' => $this->lineaRepository->getAllLineaNodo(auth()->user()->dinamizador->nodo_id)->lineas->pluck('nombre', 'id')
      ]);
    }
  }

  /**
  * Vista de gráficos para las articulaciones
  * @return Response
  * @author Victor Manuel Moreno Vega
  */
  public function articulacionesGraficos()
  {
    // dd($this->lineaRepository->getAllLineaNodo(auth()->user()->dinamizador->nodo_id)->lineas->pluck('nombre', 'id'));
    if ( Session::get('login_role') == User::IsDinamizador() ) {
      return view('grafico.dinamizador.articulacion', [
      'gestores' => Gestor::ConsultarGestoresPorNodo(auth()->user()->dinamizador->nodo_id)->pluck('nombres_gestor', 'id'),
      'lineas' => $this->lineaRepository->getAllLineaNodo(auth()->user()->dinamizador->nodo_id)->lineas->pluck('nombre', 'id')
      ]);
    }
  }

}
