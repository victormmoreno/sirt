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

  public function __construct(ProyectoRepository $proyectoRepository)
  {
    $this->setProyectoRepository($proyectoRepository);
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
    $idnodo = $id;

    if ( Session::get('login_role') == User::IsDinamizador() ) {
      $idnodo = auth()->user()->dinamizador->nodo_id;
    }
    // dd($idnodo);

    // dd($this->getProyectoRepository());
    $proyectos = $this->getProyectoRepository()->proyectosInscritosPorMesDeUnNodo_Repository($idnodo, $anho);
    $cantidades = array();
    $meses = array();
    foreach ($proyectos as $key => $value) {
      // var_dump($value . '<br>');
      $cantidades[$key] = $value->cantidad;
      $meses[$key] = $value->mes;
    }
    $datos = array('cantidades' => $cantidades, 'meses' => $meses);
    // dd($datos);
    // dd($proyectos);
    return response()->json([
      'proyectos' => $datos
    ]);
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
