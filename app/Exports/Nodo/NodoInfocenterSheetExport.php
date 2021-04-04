<?php

namespace App\Exports\Nodo;

use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Contracts\View\View;
use App\Exports\FatherExport;

class NodoInfocenterSheetExport extends FatherExport
{

    private $title;
    private $nodo;

    public function __construct($query, $nodo, $title)
    {
        $this->setTitle($title);
        $this->setNodo($nodo);
        $this->setQuery($query);
        $this->setCount(collect($this->getQuery())->count() + 1);
        $this->setRangeHeadingCell('A1:Y1');
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
                $this->styledCells($event);
                $this->setFilters($event);
            },
        ];
    }

    /**
     * Aplica estilos a las celdas
     * @param AfterSheet $event
     * @return void
     * @author devjul
     */
    private function styledCells(AfterSheet $event)
    {

        // Estilos para los nombres de las columnas
        $event->sheet->getStyle($this->getRangeHeadingCell())->getFont()->setSize(14)->setBold(1);
        // Estilos para los registros de la consulta
        $init = 'A';
        for ($i = 0; $i < 25; $i++) {
            $temp        = $init++;
            $coordenadas = $temp . '1:' . $temp . $this->getCount();
            $event->sheet->getStyle($coordenadas)->applyFromArray($this->styleArray());
            if ($i % 2 == 0) {
                $event->sheet->getStyle($coordenadas)->applyFromArray($this->styleArrayColumnsPar());
            } else {
                $event->sheet->getStyle($coordenadas)->applyFromArray($this->styleArrayColumnsImPar());
            }
        }
    }

    /**
     * @abstract
     */
    public function view(): View
    {
        return view('exports.nodo.nodoInfocenter', [
            'infocenters' => $this->getQuery()
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
