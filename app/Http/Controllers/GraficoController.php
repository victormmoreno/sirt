<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Repositories\Repository\LineaRepository;
use App\{User, Models\Gestor};

class GraficoController extends Controller
{

  private $lineaRepository;

  public function __construct(LineaRepository $lineaRepository)
  {
    $this->setLineaRepository($lineaRepository);
  }

  /**
  * Página inicial de los gráficos
  * @return Response
  * @author dum
  */
  public function index()
  {
    if ( Session::get('login_role') == User::IsDinamizador() ) {
      return view('grafico.dinamizador.index');
    }
  }

  /**
   * undocumented function summary
   *
   * Undocumented function long description
   *
   * @param type var Description
   * @return return type
   */
  public function proyectosGraficos()
  {
    if ( Session::get('login_role') == User::IsDinamizador() ) {
      return view('grafico.dinamizador.proyecto', [
        'gestores' => Gestor::ConsultarGestoresPorNodo(auth()->user()->dinamizador->nodo_id)->pluck('nombres_gestor', 'id'),
        'lineas' => $this->getLineaRepository()->getAllLineaNodo(auth()->user()->dinamizador->nodo_id)->lineas->pluck('nombre', 'id')
      ]);
    }
  }

  /**
   * Vista para mostrar los gráficos de las edts
   * @return Response
   * @author dum
   */
  public function edtsGraficos()
  {
    if ( Session::get('login_role') == User::IsDinamizador() ) {
      return view('grafico.dinamizador.edt', [
        'gestores' => Gestor::ConsultarGestoresPorNodo(auth()->user()->dinamizador->nodo_id)->pluck('nombres_gestor', 'id'),
        'lineas' => $this->getLineaRepository()->getAllLineaNodo(auth()->user()->dinamizador->nodo_id)->lineas->pluck('nombre', 'id')
      ]);
    }
  }

  /**
  * Vista de gráficos para las articulaciones
  * @return Response
  * @author dum
  */
  public function articulacionesGraficos()
  {
    if ( Session::get('login_role') == User::IsDinamizador() ) {
      return view('grafico.dinamizador.articulacion', [
      'gestores' => Gestor::ConsultarGestoresPorNodo(auth()->user()->dinamizador->nodo_id)->pluck('nombres_gestor', 'id'),
      'lineas' => $this->getLineaRepository()->getAllLineaNodo(auth()->user()->dinamizador->nodo_id)->lineas->pluck('nombre', 'id')
      ]);
    }
  }

  /**
   * Asigna un valor a $lineaRepository
   *
   * @param object $lineaRepository
   * @return void
   * @author dum
   */
  private function setLineaRepository($lineaRepository)
  {
    $this->lineaRepository = $lineaRepository;
  }

  /**
   * Retorna el valor de $lineaRepository
   *
   * @return object
   * @author dum
   */
  private function getLineaRepository()
  {
    return $this->lineaRepository;
  }

}
