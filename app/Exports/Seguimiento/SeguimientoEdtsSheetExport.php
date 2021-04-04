<?php

namespace App\Exports\Seguimiento;

use Maatwebsite\Excel\Events\{AfterSheet};
use Illuminate\Contracts\View\View;
use App\Exports\FatherExport;

class SeguimientoEdtsSheetExport extends FatherExport
{

    public function __construct($query)
    {
        $this->setQuery($query);
        $this->setCount($this->getQuery()->count() + 1);
        $this->setRangeHeadingCell('A1:O1');
    }

    public function registerEvents(): array
    {
        $columnPar = $this->styleArrayColumnsPar();
        $columnImPar = $this->styleArrayColumnsImPar();
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $this->styledCells($event);
                $this->setFilters($event);
            },
        ];
    }

    /**
     * Asigna valores a celdas
     * @param AfterSheet $event
     * @return void
     */
    private function setCellsValues(AfterSheet $event)
    {
        $event->sheet->setCellValue('I6', 'Asistentes');
        $event->sheet->setCellValue('M6', 'Entregables');
    }

    /**
     * Aplica estilos a las celdas
     * @param AfterSheet $event
     * @return void
     * @author dum
     */
    private function styledCells(AfterSheet $event)
    {
        // Estilos para la celda de Entregables y Asistentes
        //$event->sheet->getStyle('I6:O6')->applyFromArray($this->styleArray());
        // Estilos para la celda de asistentes
        //$event->sheet->getStyle('I6')->applyFromArray($this->styleArrayColumnsImPar())->getFont()->setBold(1);
        //$event->sheet->getStyle('I6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        // Estilos para la celda de entregables
        //$event->sheet->getStyle('M6')->applyFromArray($this->styleArrayColumnsPar())->getFont()->setBold(1);
        //$event->sheet->getStyle('M6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        // Estilos para los nombres de las columnas
        //$event->sheet->getStyle($this->getRangeHeadingCell())->getFont()->setSize(14)->setBold(1);
        // Estilos para los registros de la consulta
        $init = 'A';
        for ($i=0; $i < 15 ; $i++) {
        $temp = $init++;
        $coordenadas = $temp . '1:'. $temp . $this->getCount();
        $event->sheet->getStyle($coordenadas)->applyFromArray($this->styleArray());
        if ( $i % 2 == 0 ) {
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
        return view('exports.seguimiento.edts', [
        'edts' => $this->getQuery()
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
        return 'Edts';
    }
}
