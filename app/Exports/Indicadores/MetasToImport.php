<?php

namespace App\Exports\Indicadores;

use Maatwebsite\Excel\Events\{AfterSheet};
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use App\Exports\FatherExport;
use Maatwebsite\Excel\Concerns\Exportable;


class MetasToImport extends FatherExport implements WithColumnWidths
{
    use Exportable;
    private $query;


    public function __construct($query)
    {
        $this->query = $query;
        $this->setCount($this->query->count() + 1);
        $this->setRangeHeadingCell('A1:D1');
    }

    public function registerEvents(): array
    {
        // $columnPar = $this->styleArrayColumnsPar();
        // $columnImPar = $this->styleArrayColumnsImPar();
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
        return view('exports.metas.import', [
            'metas' => $this->query,
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'C' => 25,
            'D' => 25
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
        return "Metas para importar";
    }
}