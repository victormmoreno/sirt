<?php

namespace App\Exports\Accompaniment;

use Illuminate\Contracts\View\View;
use App\Exports\FatherExport;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;

class AccompanimentExport extends FatherExport
{
    use Exportable;

    public function __construct($query)
    {
        $this->setQuery($query);
        $this->setCount($this->getQuery()->count() + 1);
        $this->setRangeHeadingCell('A1:O1');
    }

    /**
     * @abstract
     */
    public function view(): View
    {
        return view('exports.accompaniment.index', [
            'accompaniments' => $this->getQuery()
        ]);
    }

    /**
     * Método para aplicar estilos al archivo excel después de que se genera la hoja de excel
     * @return array
     * @abstract
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
     */
    public function title(): String
    {
        return 'Acompañamientos';
    }

}
