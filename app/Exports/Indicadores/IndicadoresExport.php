<?php

namespace App\Exports\Indicadores;

use PhpOffice\PhpSpreadsheet\Style\{Border, Fill};
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Proyectos\{ProyectosExport};
use App\Exports\Empresas\{EmpresasExport};
use App\Exports\GruposInvestigacion\{GruposExport};
use App\Exports\User\Talento\TalentoUserExport;

// use App\Exports\FatherExport;

class IndicadoresExport implements WithMultipleSheets
{

    private $queries;
    private $hoja;

    public function __construct($queries, $hoja) {
        $this->queries = $queries;
        $this->hoja = $hoja;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        if ($this->hoja == 'all') {
            $sheets[] = new ProyectosExport($this->queries['proyectos']->get());
            $sheets[] = new TalentoUserExport($this->queries['talentos_ejecutores']->get(), 'Ejecutores');
            $sheets[] = new EmpresasExport($this->queries['empresas_duenhas']->get(), 'propietarias');
            $sheets[] = new GruposExport($this->queries['grupos_duenhos']->get(), 'propietarios');
            $sheets[] = new TalentoUserExport($this->queries['personas_duenhas']->get(), 'Propietarios');
        } else {
            abort('404');
        }
        return $sheets;
    }

}
