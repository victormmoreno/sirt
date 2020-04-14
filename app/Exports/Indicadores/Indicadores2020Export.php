<?php

namespace App\Exports\Indicadores;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Proyectos\{ProyectosExport};
use App\Exports\Articulaciones\{ArticulacionesExport};
use App\Exports\Empresas\{EmpresasExport};
use App\Exports\GruposInvestigacion\{GruposExport};
use App\Exports\User\Talento\TalentoUserExport;

class Indicadores2020Export implements WithMultipleSheets
{
    private $queryProyectos;
    private $queryTalentos;
    private $queryArticulacion;
    private $queryEmpresasPropietarias;
    private $queryGruposPropietarios;
    private $queryTalentosPropietarios;

    public function __construct($queryProyectos, $queryTalentos, $queryArticulacion, $queryEmpresasPropietarias, $queryGruposPropietarios, $queryTalentosPropietarios) {
        $this->setQueryProyectos($queryProyectos);
        $this->setQueryTalentos($queryTalentos);
        $this->setQueryArticulacion($queryArticulacion);
        $this->setQueryEmpresasPropietarias($queryEmpresasPropietarias);
        $this->setQueryTalentosPropietarios($queryTalentosPropietarios);
        $this->setQueryGruposPropietarios($queryGruposPropietarios);
    }
  /**
   * @return array
   */
  public function sheets(): array
  {
      $sheets = [];

      $sheets[] = new ProyectosExport($this->getQueryProyectos());
      $sheets[] = new TalentoUserExport($this->getQueryTalentos(), 'Proyectos');
      $sheets[] = new EmpresasExport($this->getQueryEmpresasPropietarias(), 'propietarias');
      $sheets[] = new GruposExport($this->getQueryGruposPropietarios(), 'propietarios');
      $sheets[] = new TalentoUserExport($this->getQueryTalentosPropietarios(), 'Propietarios');
      $sheets[] = new ArticulacionesExport($this->getQueryArticulacion());


      return $sheets;
  }

  private function setQueryProyectos($queryProyectos) {
    $this->queryProyectos = $queryProyectos;
  }

  private function getQueryProyectos() {
    return $this->queryProyectos;
  }

  private function setQueryTalentos($queryTalentos) {
    $this->queryTalentos = $queryTalentos;
  }

  private function getQueryTalentos() {
    return $this->queryTalentos;
  }

  private function setQueryArticulacion($queryArticulacion) {
    $this->queryArticulacion = $queryArticulacion;
  }

  private function getQueryArticulacion() {
    return $this->queryArticulacion;
  }

  private function setQueryEmpresasPropietarias($queryEmpresasPropietarias) {
    $this->queryEmpresasPropietarias = $queryEmpresasPropietarias;
  }

  private function getQueryEmpresasPropietarias() {
    return $this->queryEmpresasPropietarias;
  }

  private function setQueryGruposPropietarios($queryGruposPropietarios) {
    $this->queryGruposPropietarios = $queryGruposPropietarios;
  }

  private function getQueryGruposPropietarios() {
    return $this->queryGruposPropietarios;
  }

  private function setQueryTalentosPropietarios($queryTalentosPropietarios) {
    $this->queryTalentosPropietarios = $queryTalentosPropietarios;
  }

  private function getQueryTalentosPropietarios() {
    return $this->queryTalentosPropietarios;
  }
}