<?php

namespace App\Http\Controllers\Excel;

use App\Exports\Proyectos\{ProyectosGestorAnhoExport, ProyectosNodoAnhoExport};
use App\Repositories\Repository\ProyectoRepository;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use Excel;

class ProyectoController extends Controller
{
  private $query;
  private $proyectoRepository;

  public function __construct(ProyectoRepository $proyectoRepository)
  {
    $this->setProyectoRepository($proyectoRepository);
  }

  /**
   * Método para validar el id del nodo que llega
   */
  private function idNodo($id) {
    $idnodo = $id;

    if ( Session::get('login_role') == User::IsDinamizador() ) {
      $idnodo = auth()->user()->dinamizador->nodo_id;
    }
    return $idnodo;
  }

  /**
   * Genera el excel de los proyectos de un nodo por año
   *
   * @param int $id Id del nodo
   * @param string $anho Año para realizar el filtro
   * @return Response
   */
  public function consultarProyectosDeUnNodoPorAnho($id, $anho)
  {
    $idnodo = $this->idNodo($id);
    $query = $this->getProyectoRepository()->ConsultarProyectosPorNodoYPorAnho($idnodo, $anho);
    $this->setQuery($query);
    return Excel::download(new ProyectosNodoAnhoExport($this->getQuery(), 1), 'Proyectos.xls');
  }

  /**
   * Excel para generar los proyectos de un gestor por año
   *
   * @param int $id Id del gestor
   * @param string $anho Año para realizar el filtro
   * @return Response
   */
  public function consultarProyectosDeUnGestorPorAnho($id, $anho)
  {
    $query = $this->getProyectoRepository()->ConsultarProyectosPorGestorYPorAnho($id, $anho);
    $this->setQuery($query);
    // dd($this->getQuery());
    // exit();
    return Excel::download(new ProyectosGestorAnhoExport($this->getQuery()), 'Proyectos.xls');
  }

  /**
   * Excel para generar los proyectos que se inscriben por año y nodo con el tipo de articulacion de Empresas
   *
   * @param int $id Id del nodo
   * @param string $anho Año para realizar el filtro
   * @return Response
   * @author dum
   */
  public function consultarProyectosInscritosConEmpresasPorAnhoYAnho($id, $anho)
  {
    $idnodo = $this->idNodo($id);
    $query = $this->getProyectoRepository()->consultarProyectosInscritosConEmpresasPorAnhoYAnho_Repository($idnodo, $anho);
    $this->setQuery($query);
    return Excel::download(new ProyectosNodoAnhoExport($this->getQuery(), 0), 'Proyectos.xls');
  }

  /**
   * Excel para generar los proyectos que se inscriben en un año por nodo
   *
   * @param int $id Id del nodo
   * @param string $anho Año
   * @return Response
   * @author dum
   */
  public function proyectosInscritosPorAnhosDeUnNodo($id, $anho)
  {
    $idnodo = $this->idNodo($id);

    $query = $this->getProyectoRepository()->consultarProyectosInscritosPorAnhoYNodo_Repository($idnodo, $anho);
    $this->setQuery($query);
    return Excel::download(new ProyectosNodoAnhoExport($this->getQuery(), 0), 'Proyectos.xls');
  }


  /**
   * Asigna un valor a $proyectoRepository
   *
   * @param object $proyectoRepository
   * @return void
   * @author dum
   */
  private function setProyectoRepository($proyectoRepository)
  {
    $this->proyectoRepository = $proyectoRepository;
  }

  /**
   * Retorna el valor de $proyectoRepository
   *
   * @return object
   * @author dum
   */
  private function getProyectoRepository()
  {
    return $this->proyectoRepository;
  }

  /**
   * Asgina un valor a $query
   *
   * @param Collection $query
   * @return void
   * @author dum
   */
  private function setQuery($query) {
    $this->query = $query;
  }

  /**
   * Retorna el valor de $query
   *
   * @return Collection
   * @author dum
   */
  private function getQuery()
  {
    return $this->query;
  }

}
