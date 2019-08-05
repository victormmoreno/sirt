<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Session};
use App\Repositories\Repository\{ArticulacionRepository};
use App\{User, Models\Gestor};

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
      return view('grafico.dinamizador.index', [
        'gestores' => Gestor::ConsultarGestoresPorNodo(auth()->user()->dinamizador->nodo_id)->pluck('nombres_gestor', 'id'),
      ]);
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
  * Retorna el array con los datos para mostrar en la vista
  * @param array $datos
  * @return array
  */
  private function devolverArrayConDatosDeArticulaciones($gestoresDelNodo, $fecha_inicio, $fecha_fin) {
    $datosCompletos = array();
    foreach ($gestoresDelNodo as $key => $value) {
      $gestor = $value->nombres;
      $array = array('gestor' => $gestor);
      array_push($datosCompletos, $array);
      $articulaciones = array();
      for ($i=0; $i < 3 ; $i++) {
        $articulacionesArr = $this->articulacionRepository->consultarCantidadDeArticulacionesPorTipoDeArticulacionYGestor($value->id, $i, $fecha_inicio, $fecha_fin);
        if ($i == 0) {
          if ($articulacionesArr != null) {
            $datosCompletos[$key]['grupos'] = $articulacionesArr->cantidad;
          } else {
            $datosCompletos[$key]['grupos'] = 0;
          }
        } else if ($i == 1) {
          if ($articulacionesArr != null) {
            $datosCompletos[$key]['empresas'] = $articulacionesArr->cantidad;
          } else {
            $datosCompletos[$key]['empresas'] = 0;
          }
        } else {
          if ($articulacionesArr != null) {
            $datosCompletos[$key]['emprendedores'] = $articulacionesArr->cantidad;
          } else {
            $datosCompletos[$key]['emprendedores'] = 0;
          }
        }
      }
    }
    return $datosCompletos;
  }

  /**
  * 
  * @param int $id Id del nodo
  * @return Response
  */
  public function articulacionesNodoGrafico($id, $fecha_inicio, $fecha_fin)
  {

    if ( request()->ajax() ) {
      $gestoresDelNodo = Gestor::ConsultarGestoresPorNodo($id)->get();
      $datosCompletos = $this->devolverArrayConDatosDeArticulaciones($gestoresDelNodo, $fecha_inicio, $fecha_fin);
      return response()->json([
        'consulta' => $datosCompletos
      ]);
    }
  }
}
