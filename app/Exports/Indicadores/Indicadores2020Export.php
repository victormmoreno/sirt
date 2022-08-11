<?php

namespace App\Exports\Indicadores;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Proyectos\{ProyectosExport};
// use App\Exports\ es\{ esExport};
use App\Exports\Empresas\{EmpresasExport};
use App\Exports\GruposInvestigacion\{GruposExport};
use App\Exports\User\Talento\TalentoUserExport;

class Indicadores2020Export implements WithMultipleSheets
{
    private $query;
    private $hoja;

    public function __construct($queryProyectos, $hoja) {
        $this->setQuery($queryProyectos);
        $this->hoja = $hoja;
    }
    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        if ($this->hoja == 'all') {
            $sheets[] = new ProyectosExport($this->getQuery());
            $sheets[] = new TalentoUserExport($this->getQuery(), 'Ejecutores');
            $sheets[] = new EmpresasExport($this->getQuery(), 'propietarias');
            $sheets[] = new GruposExport($this->getQuery(), 'propietarios');
            $sheets[] = new TalentoUserExport($this->getQuery(), 'Propietarios');
        } else {
            if ($this->hoja == 'proyectos') {
                $sheets[] = new ProyectosExport($this->getQuery());
            }
            if ($this->hoja == 'tal_ejecutores') {
                $sheets[] = new TalentoUserExport($this->getQuery(), 'Ejecutores');
            }
            if ($this->hoja == 'empresas_duenhas') {
                $sheets[] = new EmpresasExport($this->getQuery(), 'propietarias');
            }
            if ($this->hoja == 'grupos_duenhos') {
                $sheets[] = new GruposExport($this->getQuery(), 'propietarios');
            }
            if ($this->hoja == 'personas_duenhas') {
                $sheets[] = new TalentoUserExport($this->getQuery(), 'Propietarios');
            }
        }
        return $sheets;
    }

    private function setQuery($query) {
        $this->query = $query;
    }

    private function getQuery() {
        return $this->query;
    }

}
