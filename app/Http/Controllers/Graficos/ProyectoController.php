<?php

namespace App\Http\Controllers\Graficos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{Session};
use App\{User, Models\Gestor, Models\LineaTecnologica};
use App\Repositories\Repository\{ProyectoRepository};

class ProyectoController extends Controller
{

  private $proyectoRepository;
  private $idnodo;

  public function __construct(ProyectoRepository $proyectoRepository)
  {
    $this->setProyectoRepository($proyectoRepository);
  }

  /**
   * Suma las cantidades de proyectos
   *
   * @param Collection $query
   * @return int
   */
  private function sumarCantidadesProyectos($query)
  {
    $suma = 0;
    foreach ($query as $key => $value) {
      $suma += $value->cantidad;
    }
    return $suma;
  }

  /**
   * Array con los datos de una consulta (únicamente para consultar agrupadaas)
   * @param Collection $query
   * @return array
   * @author dum
   */
  public function getDatosProyectoAgrupados($query)
  {
    $cantidades = array();
    $labels = array();
    foreach ($query as $key => $value) {
      $cantidades[$key] = $value->cantidad;
      $labels[$key] = $value->nombre;
    }
    return array('cantidades' => $cantidades, 'labels' => $labels);
  }

  /**
  * Método para retorna el array para mostrar los datos en la gráfica
  *
  * @param Collection $query
  * @param int $suma Suma de la cantidad total de proyectos
  * @return array
  * @author dum
  */
  private function getDatosGrafico($query, $suma)
  {
    $cantidades = array();
    $meses = array();
    $promedios = array();
    foreach ($query as $key => $value) {
      $cantidades[$key] = $value->cantidad;
      $meses[$key] = $value->mes;
      $promedios[$key] = round($value->cantidad / $suma * 100, 1);
    }

    return array('cantidades' => $cantidades, 'meses' => $meses, 'promedios' => $promedios);
  }

  /**
  * Consulta los proyectos inscritos por año en un nodo (Agrupados por mes)
  *
  * @param int $id Id del nodo
  * @param string $anho Año para fitrar la búsqueda
  * @return Response
  */
  public function proyectosFinalizadosPorNodoYAnho_Controller($id, $anho)
  {
    $this->condicionalSobreElIdNodo($id);
    $proyectos = $this->getProyectoRepository()->proyectosFinalizadosPorMesDeUnNodo_Repository($this->getIdNodo())
    ->join('estadosproyecto', 'estadosproyecto.id', '=', 'proyectos.estadoproyecto_id')
    ->whereYear('fecha_cierre', $anho)
    ->whereIn('estadosproyecto.nombre', ['Cierre PF', 'Cierre PMV'])
    ->get();
    // dd($proyectos->toArray());
    $suma = $this->sumarCantidadesProyectos($proyectos);
    $datos = $this->getDatosGrafico($proyectos, $suma);
    return response()->json([
      'proyectos' => $datos
    ]);
  }

  /**
   * Consulta la cantidad de proyectos que tiene un nodo agrupados por tipos de proyectos de un nodo
   * @param int $id Id del nodo
   * @param string $fecha_inicio Primera fecha para realizar el filtro
   * @param string $fecha_fin Segunda fecha para realizar el filtro
   * @return Response\Json
   * @author dum
   */
  public function proyectosPorTipoProyectoNodo_Controller($id, $fecha_inicio, $fecha_fin)
  {
    $this->condicionalSobreElIdNodo($id);
    $proyectos = $this->getProyectoRepository()->consultarCantidadDeProyectosInscritosPorTipoProyecto_Repository($this->getIdNodo(), $fecha_inicio, $fecha_fin)->get();
    // dd($proyectos);
    $datos = $this->getDatosProyectoAgrupados($proyectos);
    return response()->json([
      'proyectos' => $datos
    ]);
  }


  /**
   *
   * @param type var Description
   * @return Response
   */
  public function proyectosInscritosConEmpresasPorMesDeUnNodo_Controller($id, $anho)
  {
    $this->condicionalSobreElIdNodo($id);
    $proyectos = $this->getProyectoRepository()->proyectosInscritosConEmpresasPorMesDeUnNodo_Repository($this->getIdNodo(), $anho);
    $suma = $this->sumarCantidadesProyectos($proyectos);
    $datos = $this->getDatosGrafico($proyectos, $suma);
    return response()->json([
      'proyectos' => $datos
    ]);
  }

  /**
   * Condición para asignarle un valor a $idnodo
   *
   * @param int $id Id del nodo
   * @return void
   * @author dum
   */
  private function condicionalSobreElIdNodo($id)
  {
    $this->setIdNodo($id);
    if ( Session::get('login_role') == User::IsDinamizador() ) {
      $this->setIdNodo(auth()->user()->dinamizador->nodo_id);
    }
  }

  /**
   * Consulta los proyectos inscritos por año en un nodo (Agrupados por mes)
   *
   * @param int $id Id del nodo
   * @param string $anho Año para fitrar la búsqueda
   * @return Response
   */
  public function proyectosPorFechaInicioNodoYAnhoGrafico_Controller($id, $anho)
  {
    $this->condicionalSobreElIdNodo($id);
    $proyectos = $this->getProyectoRepository()->proyectosInscritosPorMesDeUnNodo_Repository($this->getIdNodo(), $anho)->whereYear('fecha_inicio', $anho)->get();
    $suma = $this->sumarCantidadesProyectos($proyectos);
    $datos = $this->getDatosGrafico($proyectos, $suma);
    return response()->json([
      'proyectos' => $datos
    ]);
  }


  /**
   * Asgina un valor a $idnodo
   *
   * @param int $idnodo Description
   * @return void
   * @author dum
   */
  public function setIdNodo($idnodo)
  {
    $this->idnodo = $idnodo;
  }

  /**
   * Retorna el valor de $idnodo
   * @return int
   * @author dum
   */
  private function getIdNodo()
  {
    return $this->idnodo;
  }

  /**
   * Asgina un valor a $proyectoRepository
   *
   * @param object $proyectoRepository
   * @return void
   * @author dum
   */
  public function setProyectoRepository($proyectoRepository)
  {
    $this->proyectoRepository = $proyectoRepository;
  }

  /**
   * Retorna el valor de $proyectoRepository
   *
   * @return object
   * @author dum
   */
  public function getProyectoRepository()
  {
    return $this->proyectoRepository;
  }

}
