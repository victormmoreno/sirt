<?php

namespace App\Exports\Nodo;

use App\Exports\FatherExport;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class NodoExport extends FatherExport
{

    public function __construct($query)
    {
        $this->setQuery($query);
        $this->setCount($this->getQuery()->count() + 1);
        $this->setRangeHeadingCell('A1:H1');

    }

    /**
     * @abstract
     */
    public function view(): View
    {
        return view('exports.nodo.indexExport', [
            'nodos' => $this->getQuery(),
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
        $columnPar   = $this->styleArrayColumnsPar();
        $columnImPar = $this->styleArrayColumnsImPar();
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
        return 'Nodos';
    }
    /**
     * Asigna un valor a $title
     * @param string $title
     * @return void
     * @author dum
     */
    private function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Retorna el valor de $title
     * @return string
     * @author dum
     */
    private function getTitle()
    {
        return $this->title;
    }

}
