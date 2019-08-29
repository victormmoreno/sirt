<?php

namespace App\Http\Controllers\Excel;

use App\Exports\Proyectos\ProyectosInscritosAnhoExport;
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
   * Excel para generar los proyectos que se inscriben en un año por nodo
   *
   * @param int $id Id del nodo
   * @param string $anho Año
   * @return Response
   * @author dum
   */
  public function proyectosInscritosPorAnhosDeUnNodo($id, $anho)
  {
    $idnodo = $id;

    if ( Session::get('login_role') == User::IsDinamizador() ) {
      $idnodo = auth()->user()->dinamizador->nodo_id;
    }

    $query = $this->getProyectoRepository()->consultarProyectosInscritosPorAnhoYNodo_Repository($idnodo, $anho);
    $this->setQuery($query);
    return Excel::download(new ProyectosInscritosAnhoExport($this->getQuery()), 'Proyectos.xls');
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
