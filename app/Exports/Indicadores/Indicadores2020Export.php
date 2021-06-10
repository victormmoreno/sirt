<?php

namespace App\Exports\Indicadores;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Proyectos\{ProyectosExport};
// use App\Exports\Articulaciones\{ArticulacionesExport};
use App\Exports\Empresas\{EmpresasExport};
use App\Exports\GruposInvestigacion\{GruposExport};
use App\Exports\User\Talento\TalentoUserExport;

class Indicadores2020Export implements WithMultipleSheets
{
    private $query;

    public function __construct($queryProyectos) {
        $this->setQuery($queryProyectos);
    }
    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new ProyectosExport($this->getQuery());
        $sheets[] = new TalentoUserExport($this->getQuery(), 'Ejecutores');
        $sheets[] = new EmpresasExport($this->getQuery(), 'propietarias');
        $sheets[] = new GruposExport($this->getQuery(), 'propietarios');
        $sheets[] = new TalentoUserExport($this->getQuery(), 'Propietarios'); 
        // $sheets[] = new ArticulacionesExport($this->getQueryArticulacion());
        return $sheets;
    }

    private function setQuery($query) {
        $this->query = $query;
    }

    private function getQuery() {
        return $this->query;
    }

}
