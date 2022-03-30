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
    private $queryEdts;
    private $queryTalentos;
    private $queryEmpresas;
    private $queryGruposInvestigacion;

    public function __construct($queryInicio, $queryPlaneacion, $queryEjecucion, $queryPF, $queryPMV, $querySuspendidos, $queryArticulacionGrupos, $queryArticulacionEmpresas, $queryArticulacionEmprendedores, $queryEdts, $queryTalentos, $queryEmpresas, $queryGruposInvestigacion)
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
        $this->setQueryEdts($queryEdts);
        $this->setQueryTalentos($queryTalentos);
        $this->setQueryEmpresas($queryEmpresas);
        $this->setQueryGruposInvestigacion($queryGruposInvestigacion);
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
        $sheets[] = new SeguimientoEdtsSheetExport($this->getQueryEdts());
        $sheets[] = new SeguimientoTalentosProyectosSheetExport($this->getQueryTalentos());
        $sheets[] = new SeguimientoEmpresasSheetExport($this->getQueryEmpresas());
        $sheets[] = new SeguimientoGruposInvestigacionSheetExport($this->getQueryGruposInvestigacion());


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
     * Get the value of Query Edts
    *
    * @return Collection
    */
    private function getQueryEdts()
    {
        return $this->queryEdts;
    }

    /**
     * Set the value of Query Edts
    *
    * @param Collection queryEdts
    * @return void
    */
    private function setQueryEdts($queryEdts)
    {
        $this->queryEdts = $queryEdts;
    }


    /**
     * Get the value of Query Talentos
    * @return Collection
    */
    private function getQueryTalentos()
    {
        return $this->queryTalentos;
    }

    /**
     * Set the value of Query Talentos
    * @param mixed queryTalentos
    * @return void
    */
    private function setQueryTalentos($queryTalentos)
    {
        $this->queryTalentos = $queryTalentos;
    }

    /**
     * Get the value of Query Empresas
    * @return Collection
    */
    private function getQueryEmpresas()
    {
        return $this->queryEmpresas;
    }

    /**
     * Set the value of Query Empresas
    * @param Collection queryEmpresas
    */
    private function setQueryEmpresas($queryEmpresas)
    {
        $this->queryEmpresas = $queryEmpresas;
    }

    /**
     * Get the value of Query gruposinvestigacion
    * @return Collection
    */
    private function getQueryGruposInvestigacion()
    {
        return $this->queryGruposInvestigacion;
    }

    /**
     * Set the value of Query Grupos de Investigacion
    * @param Collection query Grupos Investigacion
    */
    private function setQueryGruposInvestigacion($queryGruposInvestigacion)
    {
        $this->queryGruposInvestigacion = $queryGruposInvestigacion;
    }

}
