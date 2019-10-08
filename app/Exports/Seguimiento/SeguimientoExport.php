<?php

namespace App\Exports\Seguimiento;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Events\{AfterSheet};
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use App\Exports\FatherExport;
use App\Models\Proyecto;

class SeguimientoExport implements WithMultipleSheets
{

  use Exportable;

  private $queryInicio;
  private $queryPF;
  private $queryPMV;
  private $querySuspendidos;

  public function __construct($queryInicio, $queryPF, $queryPMV, $querySuspendidos)
  {
    $this->setQueryInicio($queryInicio);
    $this->setQueryPF($queryPF);
    $this->setQueryPMV($queryPMV);
    $this->setQuerySuspendidos($querySuspendidos);
  }

  /**
   * @return array
   */
  public function sheets(): array
  {
      $sheets = [];

      $sheets[] = new SeguimientoSheetExport($this->getQueryInicio(), 'Inicio');
      $sheets[] = new SeguimientoSheetExport($this->getQueryPF(), 'Cierre PF');
      $sheets[] = new SeguimientoSheetExport($this->getQueryPMV(), 'Cierre PMV');
      $sheets[] = new SeguimientoSheetExport($this->getQuerySuspendidos(), 'Suspendidos');

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
   * @author dum
   * @return Collection
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

}
