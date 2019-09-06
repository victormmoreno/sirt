<?php

namespace App\Http\Controllers\Graficos;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Session};
use App\Repositories\Repository\{ArticulacionRepository, UserRepository\GestorRepository};
use App\{User, Models\Gestor, Models\LineaTecnologica};
use App\Http\Controllers\Controller;

class ArticulacionController extends Controller
{

  private $articulacionRepository;

  public function __construct(ArticulacionRepository $articulacionRepository, GestorRepository $gestorRepository)
  {
    $this->setArticulacionRepository($articulacionRepository);
    $this->setGestorRepository($gestorRepository);
  }

  /**
  * Consulta las acntidades de edts por nodo y año
  * @param int $id Id del nodo
  * @param string $anho Año por el que se consultarán las cantidades de edts
  * @return Response
  * @author Victor Manuel Moreno Vega
  */
  public function articulacionesPorNodoYAnho_Controller($id, $anho)
  {
    $idnodo = $id;
    if ( Session::get('login_role') == User::IsDinamizador() ) {
      $idnodo = auth()->user()->dinamizador->nodo_id;
    }
    $datosCompletos = array();
    for ($i = 0; $i < 3 ; $i++) {
      $articulacionesCantidad =$this->getArticulacionRepository()->consultarCantidadDeArticulacionesPorTipoYNodoYAnho($idnodo, $anho, $i);
      $datosCompletos = $this->condicionarConsultaDeArticulaciones($i, $datosCompletos, $articulacionesCantidad);
    }
    return response()->json([
      'consulta' => $datosCompletos
    ]);
  }


  /**
  * Consulta las articulaciones por línea tecnológica y nodo
  * @param int $id Id de la línea tecnológica
  * @param string $fecha_inicio Primera fecha de cierre
  * @param string $fecha_fin Segunda fecha de cierre
  * @return Response
  * @author Victor Manuel Moreno Vega
  */
  public function articulacionesLineaTecnologicaYFechaGrafico($idnodo, $id, $fecha_inicio, $fecha_fin)
  {
    $idnodoMethod = $idnodo;

    if ( Session::get('login_role') == User::IsDinamizador() ) {
      $idnodoMethod = auth()->user()->dinamizador->nodo_id;
    }

    // dd($idnodoMethod);

    $datosLinea = LineaTecnologica::findOrFail($id);
    $datosCompletos['lineatecnologica'] = $datosLinea->nombre;

    for ($i=0; $i < 3; $i++) {
      $articulacionesCantidad = $this->getArticulacionRepository()->consultarCantidadDeArticulacionesPorLineaTecnologicaYFecha_Repository($idnodoMethod, $id, $i, $fecha_inicio, $fecha_fin);
      $datosCompletos = $this->condicionarConsultaDeArticulaciones($i, $datosCompletos, $articulacionesCantidad);
    }

    return response()->json([
    'consulta' => $datosCompletos
    ]);
  }

  /**
  * Método que según el caso, agregar el valor de la consulta al array, o agrega 0 en caso de no encontrar nada
  * @param int $id Tipo de la articulacion
  * @param array $datosCompletos Array con los datos de la grafica
  * @param object $articulacionesCantidad Consulta con la cantidad de articulaciones por tipo
  * @return array
  * @author Victor Manuel Moreno Vega
  */
  private function condicionarConsultaDeArticulaciones($i, $datosCompletos, $articulacionesCantidad) {
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
    return $datosCompletos;
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
    $datosGestor = $this->getGestorRepository()->consultarGestorPorIdGestor($id);
    $datosCompletos['gestor'] = $datosGestor->gestor;
    for ($i=0; $i < 3 ; $i++) {
      $articulacionesCantidad = $this->getArticulacionRepository()->consultarCantidadDeArticulacionesPorTipoDeArticulacionYGestor($id, $i, $fecha_inicio, $fecha_fin);
      $datosCompletos = $this->condicionarConsultaDeArticulaciones($i, $datosCompletos, $articulacionesCantidad);
    }
    return response()->json([
    'consulta' => $datosCompletos
    ]);
  }
  /**
  * Retorna el array con los datos para mostrar en la vista
  * @param array $gestorDelNodo Array con los gestores del nodo
  * @param string $fecha_inicio Primera fecha de cierre de las articulaciones
  * @param string $fecha_fin Segunda fecha de cierre de las articulaciones
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
        $articulacionesArr = $this->getArticulacionRepository()->consultarCantidadDeArticulacionesPorTipoDeArticulacionYGestor($value->id, $i, $fecha_inicio, $fecha_fin);
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
  * Consulta las articulacion de un nodo por tipo
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

  /**
   * Retorna el valor de $gestorRepository
   *
   * @return object
   * @author dum
   */
  public function getGestorRepository()
  {
    return $this->gestorRepository;
  }

  /**
   * Asgina un valor a $gestorRepository
   *
   * @param object $gestorRepository
   * @return void
   * @author dum
   */
  private function setGestorRepository($gestorRepository)
  {
    $this->gestorRepository = $gestorRepository;
  }

  /**
   * Asginar un valor a $articulacionRepository
   *
   * @param object $articulacionRepository
   * @return void
   * @author dum
   */
  private function setArticulacionRepository($articulacionRepository)
  {
    $this->articulacionRepository = $articulacionRepository;
  }

  /**
   * Retorna el valor de $articulacionRepository
   * @return object
   * @author dum
   */
  private function getArticulacionRepository()
  {
    return $this->articulacionRepository;
  }

}
