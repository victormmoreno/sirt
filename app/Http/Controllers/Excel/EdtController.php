<?php

namespace App\Http\Controllers\Excel;

use App\Exports\Edts\{EdtsGestorExport, EdtsNodoExport, EdtsUnicaExport};
use App\Repositories\Repository\{EdtRepository};
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
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
   * Genera el excel con las edts de un nodo por línea tecnológica entre fechas de cierre
   * @param int $id Id del nodo
   * @param int $idlinea Id de la línea tecnológica
   * @param string $fecha_inicio Primera fecha para realizar el filtro (fecha de cierre)
   * @param string $fecha_fin Segunda fecha para realizar el filtro (fecha de cierre)
   * @return Response\Excel
   * @author dum
   */
  public function edtPorFechaCierreLineaYNodo($id, $idlinea, $fecha_inicio, $fecha_fin)
  {
    $idnodo = $id;
    if ( Session::get('login_role') == User::IsDinamizador() ) {
      $idnodo = auth()->user()->dinamizador->nodo_id;
    }

    $query = $this->getEdtRepository()->consultarEdtPorFechaDeCierre_Repository($fecha_inicio, $fecha_fin)
    ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'gestores.lineatecnologica_id')
    ->where('nodos.id', $idnodo)
    ->where('lineastecnologicas.id', $idlinea)
    ->get();
    $this->setQuery($query);
    // Aunque el excel se está generando con la clase EdtsNodoExport, en realidad no importa, ya que lo único que cambia es el query
    return Excel::download(new EdtsNodoExport($this->getQuery()), 'Edt.xls');
  }

  /**
   * Genera el excel con las edts de un gestor finalizadas por fechas
   * @param int $id Id del gestor
   * @param string $fecha_inicio Primera fecha del filtro
   * @param string $fecha_cierre Segunda fecha del filtro
   * @return Response\Excel
   * @author dum
   */
  public function edtPorFechaCierreYGestor($id, $fecha_inicio, $fecha_fin)
  {
    $idgestor = $id;
    if ( Session::get('login_role') == User::IsGestor() ) {
      $idgestor = auth()->user()->gestor->id;
    }
    $query = $this->getEdtRepository()->consultarEdtPorFechaDeCierre_Repository($fecha_inicio, $fecha_fin)->where('gestores.id', $idgestor)->get();
    $this->setQuery($query);
    // Aunque el excel se está generando con la clase EdtsNodoExport, en realidad no importa, ya que lo único que cambia es el query
    return Excel::download(new EdtsNodoExport($this->getQuery()), 'Edt.xls');
  }

  /**
   * Genera el excel con las edts de un nodo finalizadas entre dos fecha (la fecha de filtro es la fecha_cierre)
   * @param int $id Id del nodo
   * @param string $fecha_inicio Primera fecha para realizar el filtro
   * @param string $fecha_fin Segunda fecha para filtrar
   * @return Response\Excel
   * @author dum
   */
  public function edtPorFechaCierreYNodo($id, $fecha_inicio, $fecha_fin)
  {
    $idnodo = $id;
    if ( Session::get('login_role') == User::IsDinamizador() ) {
      $idnodo = auth()->user()->dinamizador->nodo_id;
    }
    $query = $this->getEdtRepository()->consultarEdtPorFechaDeCierre_Repository($fecha_inicio, $fecha_fin)->where('nodos.id', $idnodo)->get();
    $this->setQuery($query);
    return Excel::download(new EdtsNodoExport($this->getQuery()), 'Edt.xls');
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
