<?php

namespace App\Exports\ArticulacionesPbt;

use App\Exports\FatherExport;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;

class ArticulacionesPbtExport extends FatherExport
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
        return view('exports.articulacionpbt.index', [
            'articulaciones' => $this->getQuery()
        ]);
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


    private function styledCells(AfterSheet $event)
    {
        $event->sheet->getStyle($this->getRangeHeadingCell())->getFont()->setSize(14)->setBold(1);
        $init = 'A';
        for ($i = 0; $i < 15; $i++) {
            $temp = $init++;
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
     * Asigna el nombre para la hoja de excel
     * @return string
     * @abstract
     * @author devjul
     */
    public function title(): String
    {
        return 'Articulaciones PBT';
    }
}
