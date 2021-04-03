<?php

namespace App\Exports\Articulaciones;

use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\{FromView, ShouldAutoSize, WithTitle, WithDrawings, WithEvents};
use Maatwebsite\Excel\Events\{AfterSheet, BeforeSheet};
use App\Exports\FatherExport;
use Illuminate\Contracts\View\View;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ArticulacionesExport extends FatherExport
{

    public function __construct($queryArticulacion)
    {
        $this->setQuery($queryArticulacion);
        $this->setCount($this->getQuery()->count() + 1);
        $this->setRangeHeadingCell('A1:J1');
    }

    public function view(): View
    {
        return view('exports.articulacion.articulaciones', [
        'articulaciones' => $this->getQuery()
        ]);
    }

    /**
     * Método para aplicar estilos al archivo excel después de que se genera la hoja de excel
    * @return array
    * @author dum
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

    private function styledCells(AfterSheet $event) {
        $event->sheet->getStyle($this->getRangeHeadingCell())->getFont()->setSize(14)->setBold(1);
        $init = 'A';
        for ($i = 0; $i < 10; $i++) {
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
    * @author dum
    */
    public function title(): String
    {
        return 'Articulaciones';
    }

}
