<?php

namespace App\Http\Controllers\Excel;

use App\Repositories\Repository\{ProyectoRepository};
use App\Exports\Proyectos\{ProyectosAnhoExport};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Excel;

class ProyectoController extends Controller
{
  private $query;
  private $proyectoRepository;

  public function __construct(ProyectoRepository $proyectoRepository)
  {
    $this->setProyectoRepository($proyectoRepository);
  }

  public function FunctionName($value='')
  {
    // code...
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
