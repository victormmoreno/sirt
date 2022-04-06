<?php

namespace App\Exports\Equipo;

use Maatwebsite\Excel\Events\{AfterSheet};
use Illuminate\Contracts\View\View;
use App\Exports\FatherExport;
use Maatwebsite\Excel\Concerns\Exportable;


class EquipoExport extends FatherExport
{
    use Exportable;
    private $request;
    private $query;


    public function __construct($request, $query)
    {
        $this->request = $request;
        $this->query = $query;
        $this->setCount($this->query->count() + 1);
        $this->setRangeHeadingCell('A1:L1');
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
        return view('exports.equipo.index', [
            'equipos' => $this->query,
        ]);
    }

    /**
     * Asigna el nombre para la hoja de excel
     * @return string
     * @abstract
     * @author dum
     */
    public function title(): String
    {
        return "Equipos";
    }
}
