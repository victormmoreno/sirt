<?php

namespace App\Exports\Proyectos;

use Illuminate\Contracts\View\View;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use App\Exports\FatherExport;
use Maatwebsite\Excel\Events\{AfterSheet};

class Proyectos extends FatherExport
{

    public function __construct($query)
    {
        $this->setQuery($query);
        $this->setCount($this->getQuery()->count() + 7);
        $this->setRangeHeadingCell('A7:W7');
    }

    /**
     * @abstract
     */
    public function view(): View
    {
        return view('exports.proyectos.proyectos', [
            'proyectos' => $this->getQuery()
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
                $this->mergedCells($event);
                $this->styledCells($event);
                $this->setFilters($event);
            },
        ];
    }

    private function mergedCells(AfterSheet $event) {
        $event->sheet->mergeCells('A1:W6');
    }

    private function styledCells(AfterSheet $event) {
        $event->sheet->getStyle($this->getRangeHeadingCell())->getFont()->setSize(14)->setBold(1);
        $init = 'A';
        for ($i = 0; $i < 23; $i++) {
            $temp = $init++;
            $coordenadas = $temp . '7:' . $temp . $this->getCount();
            $event->sheet->getStyle($coordenadas)->applyFromArray($this->styleArray());
            if ($i % 2 == 0) {
                $event->sheet->getStyle($coordenadas)->applyFromArray($this->styleArrayColumnsPar());
            } else {
                $event->sheet->getStyle($coordenadas)->applyFromArray($this->styleArrayColumnsImPar());
            }
        }
    }

    /**
     * Asigna el nombre para la hoja de excel
     * @return string
     * @abstract
     * @author dum
     */
    public function title(): String
    {
        return 'Proyectos';
    }
}
