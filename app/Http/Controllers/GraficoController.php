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
  private $edtRepository;

  public function __construct(ArticulacionRepository $articulacionRepository, GestorRepository $gestorRepository, LineaRepository $lineaRepository, EdtRepository $edtRepository)
  {
    $this->articulacionRepository = $articulacionRepository;
    $this->gestorRepository = $gestorRepository;
    $this->lineaRepository = $lineaRepository;
    $this->edtRepository = $edtRepository;
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
  * Retorna la cantidad de edts por tipo de un gestor
  * @param int $id Id del gestor
  * @param string $fecha_inicio Primera fecha de cierre
  * @param string $fecha_fin Segunda fecha de cierre
  * @return Response
  * @author Victor Manuel Moreno Vega
  **/
  // public function edtsGestorGrafico($id, $fecha_inicio, $fecha_fin)
  // {
  //   $datosGestor = $this->gestorRepository->consultarGestorPorIdGestor($id);
  //   $datosCompletos['gestor'] = $datosGestor->gestor;
  //   for ($i=0; $i < 3 ; $i++) {
  //     $articulacionesCantidad = $this->articulacionRepository->consultarCantidadDeEdtsPorTipoDeEdtsYGestor($id, $i, $fecha_inicio, $fecha_fin);
  //     $datosCompletos = $this->condicionarConsultaDeEdts($i, $datosCompletos, $articulacionesCantidad);
  //   }
  //   return response()->json([
  //     'consulta' => $datosCompletos
  //   ]);
  // }

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
      $datosCompletos = $this->devolverArrayConDatosDeEdts($gestoresDelNodo, $fecha_inicio, $fecha_fin);
      // dd($gestoresDelNodo);
      // echo json_encode(['2']);
      return response()->json([
      'consulta' => $datosCompletos
      ]);
    }
  }

  /**
  * Retorna el array con los datos para mostrar en la vista (Gráfico de los Edt's por fechas)
  * @param array $gestoresDelNodo Gestores del nodo asociado al dinamizador
  * @param string $fecha_inicio Primera fecha (para consultar las edts)
  * @param string $fecha_fin Segunda fecha (para consultar las edts)
  * @return array
  * @author Victor Manuel Moreno Vega
  */
  private function devolverArrayConDatosDeEdts($gestoresDelNodo, $fecha_inicio, $fecha_fin) {
    $datosCompletos = array();
    // dd($gestoresDelNodo);
    $tiposEdt = TipoEdt::select('id', 'nombre')->get()->toArray();
    foreach ($gestoresDelNodo as $key => $value) {
      // dd($tiposEdt[$i]['nombre']);
      // echo '... </br>';
      $gestor = $value->nombres;
      $array = array('gestor' => $gestor);
      array_push($datosCompletos, $array);
      for ($i=0; $i < 3 ; $i++) {
        // echo $tiposEdt[$i]['nombre'] . '</br>';
        // dd($value->id);
        // exit();
        $edtArr = $this->edtRepository->consultarCantidadDeEdtsPorTiposDeEdtGestorYAnho($value->id, $tiposEdt[$i]['nombre'], $fecha_inicio, $fecha_fin);
        // dd($edtArr);
        // dd($edtArr);
        // dd($edtArr);
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
   * Consulta las acntidades de edts por nodo y año
   * @param int $id Id del nodo
   * @param string $anho Año por el que se consultarán las cantidades de edts
   * @return Response
   * @author Victor Manuel Moreno Vega
   */
  public function articulacionesPorNodoYAnho_Controller($id, $anho)
  {
    $datosCompletos = array();
    for ($i=0; $i < 3 ; $i++) {
      $articulacionesCantidad =$this->articulacionRepository->consultarCantidadDeArticulacionesPorTipoYNodoYAnho($id, $anho, $i);
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
    $idnodoMethod = "";

    if ( Session::get('login_role') == User::IsDinamizador() ) {
      $idnodoMethod = auth()->user()->dinamizador->nodo_id;
    } else {
      $idnodoMethod = $idnodo;
    }

    $datosLinea = LineaTecnologica::findOrFail($id);
    $datosCompletos['lineatecnologica'] = $datosLinea->nombre;

    for ($i=0; $i < 3; $i++) {
      $articulacionesCantidad = $this->articulacionRepository->consultarCantidadDeArticulacionesPorLineaTecnologicaYFecha_Repository($idnodoMethod, $id, $i, $fecha_inicio, $fecha_fin);
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
    $datosGestor = $this->gestorRepository->consultarGestorPorIdGestor($id);
    $datosCompletos['gestor'] = $datosGestor->gestor;
    for ($i=0; $i < 3 ; $i++) {
      $articulacionesCantidad = $this->articulacionRepository->consultarCantidadDeArticulacionesPorTipoDeArticulacionYGestor($id, $i, $fecha_inicio, $fecha_fin);
      $datosCompletos = $this->condicionarConsultaDeArticulaciones($i, $datosCompletos, $articulacionesCantidad);
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
      'lineas' => $this->lineaRepository->getAllLineaNodo(auth()->user()->dinamizador->nodo_id)->lineas->pluck('nombre', 'id')
      ]);
    }
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
