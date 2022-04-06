<?php

namespace App\Exports\Nodo;

use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Events\{AfterSheet};
use Illuminate\Contracts\View\View;
use App\Exports\FatherExport;

class NodoLineaSheetExport extends FatherExport
{

    private $title;
    private $nodo;

    public function __construct($query, $nodo, $title)
    {
        $this->setTitle($title);
        $this->setNodo($nodo);
        $this->setQuery($query);
        $this->setCount(collect($this->getQuery())->count() + 1);
        $this->setRangeHeadingCell('A1:C1');
    }



    /**
     * Método para aplicar estilos al archivo excel después de que se genera la hoja de excel
     * @return array
     * @abstract
     * @author devjul
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
     * @abstract
     */
    public function view(): View
    {
        return view('exports.nodo.nodoLinea', [
            'lineas' => $this->getQuery()
        ]);
    }

    /**
     * Asigna el nombre para la hoja de excel
     * @return string
     * @abstract
     * @author devjul
     */
    public function title(): String
    {
        return $this->getTitle();
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

    /**
     * Asigna un valor a $title
     * @param string $title
     * @return void
     * @author dum
     */
    private function setNodo($nodo)
    {
        $this->nodo = $nodo;
    }

    /**
     * Retorna el valor de $title
     * @return string
     * @author dum
     */
    private function getNodo()
    {
        return $this->nodo;
    }
}
