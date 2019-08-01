<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Session};
use App\Repositories\Repository\{ArticulacionRepository};
use App\{User};

class GraficoController extends Controller
{

  private $articulacionRepository;

  public function __construct(ArticulacionRepository $articulacionRepository)
  {
    $this->articulacionRepository = $articulacionRepository;
  }
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
      $datos = $this->articulacionRepository->tiposArticulacionesPorGestorYNodo($id);
      $tipos_articulacion = array('Grupos de Investigación', 'Empresas', 'Emprendedores');
      // $tipos_articulacion = ['Grupos de Investigación', 'Empresas', 'Emprendedores'];
      return response()->json([
        'datos' => $datos,
        'tipos_articulacion' => $tipos_articulacion
      ]);
    }
  }
}
