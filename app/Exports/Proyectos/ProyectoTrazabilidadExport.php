<?php

namespace App\Exports\Proyectos;

use Illuminate\Contracts\View\View;
use App\Exports\FatherExport;
use Maatwebsite\Excel\Events\{AfterSheet};

class ProyectoTrazabilidadExport extends FatherExport
{

    public $proyecto_local;
    public function __construct($historial, $proyecto)
    {
        $this->proyecto_local = $proyecto;
        $this->setQuery($historial);
        $this->setCount($this->getQuery()->count() + 1);
        $this->setRangeHeadingCell('A1:K1');
    }

    /**
     * @abstract
     */
    public function view(): View
    {
        return view('exports.proyectos.trazabilidad', [
            'historial' => $this->getQuery(),
            'proyecto' => $this->proyecto_local
        ]);
    }

    /**
     * Método para aplicar estilos al archivo excel después de que se genera la hoja de excel
     * @return array
     * @abstract
     * @author dum
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $this->setFilters($event);
            },
        ];
    }

    /**
     * Asigna el nombre para la hoja de excel
     * @return string
     * @abstract
     * @author dum
     */
    public function title(): String
    {
        return 'Trazabilidad';
    }
}
