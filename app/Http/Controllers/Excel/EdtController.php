<?php

namespace App\Http\Controllers\Excel;

use App\Exports\Edts\{EdtsGestorExport, EdtsNodoExport, EdtsUnicaExport};
use App\Repositories\Repository\{EdtRepository};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Excel;

class EdtController extends Controller
{

  private $edtRepository;
  private $query;
  public function __construct(EdtRepository $edtRepository)
  {
    $this->setEdtRepository($edtRepository);
  }

  /**
   * Genera el excel para as edts de un gestor
   * @param int $id Id del gestor
   * @return Response
   * @author dum
   */
  public function edtsDeUnGestor($id)
  {
    $query = $this->getEdtRepository()->consultarEdtsDeUnGestor($id);
    $this->setQuery($query);
    return Excel::download(new EdtsGestorExport($this->getQuery()), 'Edt.xls');
  }

  /**
   * General el excel para las edts de un nodo
   * @param int $id Id del nodo
   * @return Response
   * @author dum
   */
  public function edtsDeUnNodo($id)
  {
    $query = $this->getEdtRepository()->consultarEdtsDeUnNodo($id);
    $this->setQuery($query);
    return Excel::download(new EdtsNodoExport($this->getQuery()), 'Edt.xls');
  }

  /**
   * Genera el excel de una edt
   * @param int $id Id de la edt
   * @return Response
   * @author dum
   */
  public function edtsPorId($id)
  {
    $query = $this->getEdtRepository()->consultarDetalleDeUnaEdt($id);
    $this->setQuery($query);
    $entidades = $this->getEdtRepository()->entidadesDeUnaEdt($id);
    return Excel::download(new EdtsUnicaExport($this->getQuery(), $entidades), 'Edt ' . $this->getQuery()->codigo_edt . '.xls');
  }

  /**
   * Inicio del encapsulamiento
   */

  /**
   * Asigna un valor a $edtRepository
   * @param object $edtRepository
   * @return void
   * @author dum
   */
  private function setEdtRepository($edtRepository) {
    $this->edtRepository = $edtRepository;
  }

  /**
   * Retorna el valor de $edtRepository
   * @return object
   * @author dum
   */
  private function getEdtRepository(){
    return $this->edtRepository;
  }

  /**
   * Asigna un valor a $query
   * @param object $query
   * @return void
   * @author dum
   */
  private function setQuery($query) {
    $this->query = $query;
  }

  /**
   * Retorna el valor de $query
   * @return object
   * @author dum
   */
  private function getQuery(){
    return $this->query;
  }
}
