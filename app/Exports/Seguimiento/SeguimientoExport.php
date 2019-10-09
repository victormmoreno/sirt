<?php

namespace App\Exports\Seguimiento;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Events\{AfterSheet};
use Illuminate\Contracts\View\View;
use App\Exports\FatherExport;

class SeguimientoExport implements WithMultipleSheets
{

  use Exportable;

  private $queryInicio;
  private $queryPF;
  private $queryPMV;
  private $querySuspendidos;
  private $queryPlaneacion;
  private $queryEjecucion;
  private $queryArticulacionGrupos;
  private $queryArticulacionEmpresas;
  private $queryArticulacionEmprendedores;

  public function __construct($queryInicio, $queryPlaneacion, $queryEjecucion, $queryPF, $queryPMV, $querySuspendidos, $queryArticulacionGrupos, $queryArticulacionEmpresas, $queryArticulacionEmprendedores)
  {
    $this->setQueryInicio($queryInicio);
    $this->setQueryPlaneacion($queryPlaneacion);
    $this->setQueryEjecucion($queryEjecucion);
    $this->setQueryPF($queryPF);
    $this->setQueryPMV($queryPMV);
    $this->setQuerySuspendidos($querySuspendidos);
    $this->setQueryArticulacionGrupos($queryArticulacionGrupos);
    $this->setQueryArticulacionEmpresas($queryArticulacionEmpresas);
    $this->setQueryArticulacionEmprendedores($queryArticulacionEmprendedores);
  }

  /**
   * @return array
   */
  public function sheets(): array
  {
      $sheets = [];

      $sheets[] = new SeguimientoProyectosSheetExport($this->getQueryInicio(), 'Inicio');
      $sheets[] = new SeguimientoProyectosSheetExport($this->getQueryPlaneacion(), 'Planeacion');
      $sheets[] = new SeguimientoProyectosSheetExport($this->getQueryEjecucion(), 'Ejecucion');
      $sheets[] = new SeguimientoProyectosSheetExport($this->getQueryPF(), 'Cierre PF');
      $sheets[] = new SeguimientoProyectosSheetExport($this->getQueryPMV(), 'Cierre PMV');
      $sheets[] = new SeguimientoProyectosSheetExport($this->getQuerySuspendidos(), 'Suspendidos');
      $sheets[] = new SeguimientoArticulacionesSheetExport($this->getQueryArticulacionGrupos(), 'G.I');
      $sheets[] = new SeguimientoArticulacionesSheetExport($this->getQueryArticulacionEmpresas(), 'Empresas');
      $sheets[] = new SeguimientoArticulacionesSheetExport($this->getQueryArticulacionEmprendedores(), 'Emprendedores');

      return $sheets;
  }

  /**
   * Asigna un valor a $queryPF
   * @param Collection $queryPF
   * @return void
   * @author dum
   */
  private function setQueryPF($queryPF)
  {
    $this->queryPF = $queryPF;
  }

  /**
   * Retorna el valor de $queryPF
   * @author dum
   * @return Collection
   */
  private function getQueryPF()
  {
    return $this->queryPF;
  }

  /**
   * Asigna un valor a $queryPMV
   * @param Collection $queryPMV
   * @return void
   * @author dum
   */
  private function setQueryPMV($queryPMV)
  {
    $this->queryPMV = $queryPMV;
  }

  /**
   * Retorna el valor de $queryPMV
   * @author dum
   * @return Collection
   */
  private function getQueryPMV()
  {
    return $this->queryPMV;
  }

  /**
   * Asigna un valor a $querySuspendidos
   * @param Collection $querySuspendidos
   * @return void
   * @author dum
   */
  private function setQuerySuspendidos($querySuspendidos)
  {
    $this->querySuspendidos = $querySuspendidos;
  }

  /**
   * Retorna el valor de $querySuspendidos
   * @return Collection
   * @author dum
   */
  private function getQuerySuspendidos()
  {
    return $this->querySuspendidos;
  }

  /**
   * Asigna un valor a $queryInicio
   * @param Collection $queryInicio
   * @return void
   * @author dum
   */
  private function setQueryInicio($queryInicio)
  {
    $this->queryInicio = $queryInicio;
  }

  /**
   * Retorna el valor de $queryInicio
   * @author dum
   * @return Collection
   */
  private function getQueryInicio()
  {
    return $this->queryInicio;
  }


  /**
  * Get the value of Query Planeacion
  *
  * @return Collection
  */
  private function getQueryPlaneacion()
  {
    return $this->queryPlaneacion;
  }

  /**
  * Set the value of Query Planeacion
  *
  * @param Collection queryPlaneacion
  *
  * @return void
  */
  private function setQueryPlaneacion($queryPlaneacion)
  {
    $this->queryPlaneacion = $queryPlaneacion;
  }


  /**
  * Get the value of Query Ejecucion
  *
  * @return Collection
  */
  private function getQueryEjecucion()
  {
    return $this->queryEjecucion;
  }

  /**
  * Set the value of Query Ejecucion
  *
  * @param Collection queryEjecucion
  *
  * @return void
  */
  private function setQueryEjecucion($queryEjecucion)
  {
    $this->queryEjecucion = $queryEjecucion;
  }


  /**
  * Get the value of Query Articulacion Grupos
  * @return Collection
  */
  public function getQueryArticulacionGrupos()
  {
    return $this->queryArticulacionGrupos;
  }

  /**
  * Set the value of Query Articulacion Grupos
  * @param Collection queryArticulacionGrupos
  * @return void
  */
  public function setQueryArticulacionGrupos($queryArticulacionGrupos)
  {
    $this->queryArticulacionGrupos = $queryArticulacionGrupos;
  }

  /**
  * Get the value of Query Articulacion Empresas
  * @return mixed
  */
  public function getQueryArticulacionEmpresas()
  {
    return $this->queryArticulacionEmpresas;
  }

  /**
  * Set the value of Query Articulacion Empresas
  * @param Collection queryArticulacionEmpresas
  * @return void
  */
  public function setQueryArticulacionEmpresas($queryArticulacionEmpresas)
  {
    $this->queryArticulacionEmpresas = $queryArticulacionEmpresas;
  }

  /**
  * Get the value of Query Articulacion Emprendedores
  * @return Collection
  */
  public function getQueryArticulacionEmprendedores()
  {
    return $this->queryArticulacionEmprendedores;
  }

  /**
  * Set the value of Query Articulacion Emprendedores
  * @param Collection queryArticulacionEmprendedores
  * @return void
  */
  public function setQueryArticulacionEmprendedores($queryArticulacionEmprendedores)
  {
    $this->queryArticulacionEmprendedores = $queryArticulacionEmprendedores;
  }

}
