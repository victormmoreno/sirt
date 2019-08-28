<?php

namespace App\Http\Controllers\Graficos;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Session};
use App\Repositories\Repository\{EdtRepository, UserRepository\GestorRepository};
use App\{User, Models\Gestor, Models\LineaTecnologica, Models\TipoEdt};
use App\Http\Controllers\Controller;

class EdtController extends Controller
{

  private $edtRepository;
  private $gestorRepository;

  public function __construct(EdtRepository $edtRepository, GestorRepository $gestorRepository)
  {
    $this->setEdtRepository($edtRepository);
    $this->setGestorRepository($gestorRepository);
  }

  /**
  * Datos para mostrar las edts por año y tipo de edt por nodo
  * @param int $idnodo Id del nodo
  * @param string $anho Año por el que se filtra la consulta
  * @return Response
  * @author Victor Manuel Moreno Vega
  */
  public function edtsPorNodoAnhoGrafico_Controller($idnodo, $anho)
  {
    $datosCompletos = array();
    $tiposEdt = TipoEdt::select('id', 'nombre')->get()->toArray();
    for ($i = 0; $i < 3 ; $i++) {
      $edtsCantidad =$this->getEdtRepository()->consultarCantidadDeEdtsPorTipoYNodoYAnho_Repository($idnodo, $anho, $tiposEdt[$i]['nombre']);
      $datosCompletos = $this->condicionarConsultaDeEdts($i, $datosCompletos, $edtsCantidad);
    }
    return response()->json([
      'consulta' => $datosCompletos
    ]);
  }

  /**
  * Consulta las edts realiazadas por nodo
  * @param int $id Id de la línea tecnológica
  * @param int $idnodo Id del nodo
  * @param string $fecha_inicio Primera fecha para filtrar
  * @param string $fecha_fin Segunda fecha para filtrar
  * @return Response
  * @author Victor Manuel Moreno Vega
  */
  public function edtsLineaGrafico($id, $idnodo, $fecha_inicio, $fecha_fin)
  {
    $idnodoMethod = "";

    if ( Session::get('login_role') == User::IsDinamizador() ) {
      $idnodoMethod = auth()->user()->dinamizador->nodo_id;
    } else {
      $idnodoMethod = $idnodo;
    }

    $datosLinea = LineaTecnologica::findOrFail($id);
    $datosCompletos['lineatecnologica'] = $datosLinea->nombre;
    $tiposEdt = TipoEdt::select('id', 'nombre')->get()->toArray();

    for ($i=0; $i < 3; $i++) {
      $edtsCantidad = $this->getEdtRepository()->consultarCantidadDeEdtsPorLineaTecnologicaYFecha_Repository($idnodoMethod, $id, $tiposEdt[$i]['nombre'], $fecha_inicio, $fecha_fin);
      $datosCompletos = $this->condicionarConsultaDeEdts($i, $datosCompletos, $edtsCantidad);
    }
    return response()->json([
    'consulta' => $datosCompletos
    ]);
  }

  /**
  * Método que según el caso, agregar el valor de la consulta al array, o agrega 0 en caso de no encontrar nada
  * @param int $id Tipo de la articulacion
  * @param array $datosCompletos Array con los datos de la grafica
  * @param object $edtsCantidad Consulta con la cantidad de edts por tipo
  * @return array
  * @author Victor Manuel Moreno Vega
  */
  private function condicionarConsultaDeEdts($i, $datosCompletos, $edtsCantidad) {
    if ( $i == 0 ) {
      if ($edtsCantidad != null) {
        $datosCompletos['tipo1'] = $edtsCantidad->cantidad;
      } else {
        $datosCompletos['tipo1'] = 0;
      }
    } else if ( $i == 1 ) {
      if ($edtsCantidad != null) {
        $datosCompletos['tipo2'] = $edtsCantidad->cantidad;
      } else {
        $datosCompletos['tipo2'] = 0;
      }
    } else {
      if ($edtsCantidad != null) {
        $datosCompletos['tipo3'] = $edtsCantidad->cantidad;
      } else {
        $datosCompletos['tipo3'] = 0;
      }
    }
    return $datosCompletos;
  }

  /**
  * Retorna la cantidad de edts por tipo de un gestor
  * @param int $id Id del gestor
  * @param string $fecha_inicio Primera fecha de cierre
  * @param string $fecha_fin Segunda fecha de cierre
  * @return Response
  * @author Victor Manuel Moreno Vega
  **/
  public function edtsGestorGrafico($id, $idnodo, $fecha_inicio, $fecha_fin)
  {
    $nodo = $idnodo;
    if ( Session::get('login_role') == User::IsDinamizador() ) {
      $nodo = auth()->user()->dinamizador->nodo_id;
    }
    $datosGestor = $this->gestorRepository->consultarGestorPorIdGestor($id);
    $datosCompletos['gestor'] = $datosGestor->gestor;
    $tiposEdt = TipoEdt::select('id', 'nombre')->get()->toArray();
    for ($i=0; $i < 3 ; $i++) {
      $edtsCantidad = $this->getEdtRepository()->consultarCantidadDeEdtsPorTiposDeEdtGestorYAnho($id, $tiposEdt[$i]['nombre'], $nodo, $fecha_inicio, $fecha_fin);
      // var_dump($nodo);
      $datosCompletos = $this->condicionarConsultaDeEdts($i, $datosCompletos, $edtsCantidad);
    }
    return response()->json([
    'consulta' => $datosCompletos
    ]);
  }

  /**
  * Consulta las edts realizadas entre fechas
  * @param int $idnodo Id del nodo
  * @param string $fecha_inicio Primera fecha de la edt
  * @param string $fecha_fin Segunda fecha de la edt
  * @return Response
  * @author Victor Manuel Moreno Vega
  */
  public function edtsNodoGrafico($idnodo, $fecha_inicio, $fecha_fin)
  {
    if ( request()->ajax() ) {
      $id = "";
      if ( Session::get('login_role') == User::IsDinamizador() ) {
        $id = auth()->user()->dinamizador->nodo_id;
      } else {
        $id = $idnodo;
      }
      $datosCompletos = array();

      $gestoresDelNodo = Gestor::ConsultarGestoresPorNodo($id)->get();
      $datosCompletos = $this->devolverArrayConDatosDeEdts($gestoresDelNodo, $id, $fecha_inicio, $fecha_fin);
      return response()->json([
      'consulta' => $datosCompletos
      ]);
    }
  }

  /**
  * Retorna el array con los datos para mostrar en la vista (Gráfico de los Edt's por fechas)
  * @param array $gestoresDelNodo Gestores del nodo asociado al dinamizador
  * @param int $id Id del nodo
  * @param string $fecha_inicio Primera fecha (para consultar las edts)
  * @param string $fecha_fin Segunda fecha (para consultar las edts)
  * @return array
  * @author Victor Manuel Moreno Vega
  */
  private function devolverArrayConDatosDeEdts($gestoresDelNodo, $idnodo, $fecha_inicio, $fecha_fin) {
    $datosCompletos = array();
    $tiposEdt = TipoEdt::select('id', 'nombre')->get()->toArray();
    foreach ($gestoresDelNodo as $key => $value) {
      $gestor = $value->nombres;
      $array = array('gestor' => $gestor);
      array_push($datosCompletos, $array);
      for ($i=0; $i < 3 ; $i++) {
        $edtArr = $this->getEdtRepository()->consultarCantidadDeEdtsPorTiposDeEdtGestorYAnho($value->id, $tiposEdt[$i]['nombre'], $idnodo, $fecha_inicio, $fecha_fin);
        if ($i == 0) {
          if ($edtArr != null) {
            $datosCompletos[$key]['tipos1'] = $edtArr->cantidad;
          } else {
            $datosCompletos[$key]['tipos1'] = 0;
          }
        } else if ($i == 1) {
          if ($edtArr != null) {
            $datosCompletos[$key]['tipos2'] = $edtArr->cantidad;
          } else {
            $datosCompletos[$key]['tipos2'] = 0;
          }
        } else {
          if ($edtArr != null) {
            $datosCompletos[$key]['tipos3'] = $edtArr->cantidad;
          } else {
            $datosCompletos[$key]['tipos3'] = 0;
          }
        }
      }
    }
    return $datosCompletos;
  }

  /**
   * Asigna un valor a $gestorRepository
   *
   * @param object $gestorRepository
   * @return void
   * @author
   */
  private function setGestorRepository($gestorRepository)
  {
    $this->gestorRepository = $gestorRepository;
  }

  /**
   * retorna el valor de $gestorRepository
   *
   * @return object
   * @author dum
   */
  private function getGestorRepository()
  {
    return $this->gestorRepository;
  }

  /**
   * Asigna un valor a $edtRepository
   *
   * @param object $edtRepository
   * @return void
   * @author dum
   */
  private function setEdtRepository($edtRepository)
  {
    $this->edtRepository = $edtRepository;
  }

  /**
   * Retorna el valor de $edtRepository
   *
   * @return object
   * @author dum
   */
  private function getEdtRepository()
  {
    return $this->edtRepository;
  }

}
