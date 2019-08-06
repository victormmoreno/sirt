<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Session};
use App\Repositories\Repository\{ArticulacionRepository, UserRepository\GestorRepository};
use App\{User, Models\Gestor};

class GraficoController extends Controller
{

  private $articulacionRepository;
  private $gestorRepository;

  public function __construct(ArticulacionRepository $articulacionRepository, GestorRepository $gestorRepository)
  {
    $this->articulacionRepository = $articulacionRepository;
    $this->gestorRepository = $gestorRepository;
  }
  /**
  * Página inicial de gráficos
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
  * Retorna la cantidad de articulaciones por tipo de un gestor
  * @param int $id Id del gestor
  * @param string $fecha_inicio Primera fecha de cierre
  * @param string $fecha_fin Segunda fecha de cierre
  * @return Response
  * @author Victor Manuel Moreno Vega
  **/
  public function articulacionesGestorGrafico($id, $fecha_inicio, $fecha_fin)
  {
    $datosGestor = $this->gestorRepository->consultarGestorPorIdGestor($id);
    $datosCompletos['gestor'] = $datosGestor->gestor;
    for ($i=0; $i < 3 ; $i++) {
      $articulacionesCantidad = $this->articulacionRepository->consultarCantidadDeArticulacionesPorTipoDeArticulacionYGestor($id, $i, $fecha_inicio, $fecha_fin);
      if ( $i == 0 ) {
        if ($articulacionesCantidad != null) {
          $datosCompletos['grupos'] = $articulacionesCantidad->cantidad;
        } else {
          $datosCompletos['grupos'] = 0;
        }
      } else if ( $i == 1 ) {
        if ($articulacionesCantidad != null) {
          $datosCompletos['empresas'] = $articulacionesCantidad->cantidad;
        } else {
          $datosCompletos['empresas'] = 0;
        }
      } else {
        if ($articulacionesCantidad != null) {
          $datosCompletos['emprendedores'] = $articulacionesCantidad->cantidad;
        } else {
          $datosCompletos['emprendedores'] = 0;
        }
      }
    }
    return response()->json([
      'consulta' => $datosCompletos
    ]);
  }

  /**
  * Vista de gráficos para las articulaciones
  * @return Response
  * @author Victor Manuel Moreno Vega
  */
  public function articulacionesGraficos()
  {
    if ( Session::get('login_role') == User::IsDinamizador() ) {
      return view('grafico.dinamizador.articulacion', [
      'gestores' => Gestor::ConsultarGestoresPorNodo(auth()->user()->dinamizador->nodo_id)->pluck('nombres_gestor', 'id'),
      ]);
    }
  }


  /**
  * Retorna el array con los datos para mostrar en la vista
  * @param array $datos
  * @return array
  * @author Victor Manuel Moreno Vega
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
  * @author Victor Manuel Moreno Vega
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
