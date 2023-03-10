<?php

namespace App\Exports\Equipo;

use Maatwebsite\Excel\Events\{AfterSheet};
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use App\Exports\FatherExport;
use Maatwebsite\Excel\Concerns\Exportable;


class EquipoToImport extends FatherExport implements WithColumnWidths
{
    use Exportable;
    private $query;


    public function __construct($query)
    {
        $this->query = $query;
        $this->setCount($this->query->count() + 1);
        $this->setRangeHeadingCell('A1:K1');
    }

    public function registerEvents(): array
    {
        $columnPar = $this->styleArrayColumnsPar();
        $columnImPar = $this->styleArrayColumnsImPar();
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $this->setFilters($event);
            },
        ];
    }

    /**
     * @abstract
     */
    public function view(): View
    {
        return view('exports.equipo.import', [
            'equipos' => $this->query,
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'C' => 45,
            'D' => 45
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
        return "Equipos para importar";
    }
}
