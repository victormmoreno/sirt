<?php

namespace App\Exports\Idea;

use App\Exports\FatherExport;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Events\{AfterSheet};
use Maatwebsite\Excel\Concerns\Exportable;

class IdeasIndicadorExport extends FatherExport
{
    use Exportable;

    public function __construct($query)
    {
        $this->setQuery($query);
        $this->setCount($this->getQuery()->count() + 1);
        $this->setRangeHeadingCell('A1:S1');
    }

    /**
     * @abstract
     */
    public function view(): View
    {
        return view('exports.idea.indicadores', [
            'ideas' => $this->getQuery()
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
                // $this->styledCells($event);
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
        return 'Ideas';
    }
}
