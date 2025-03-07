<?php

namespace App\Exports\Seguimiento;

use Maatwebsite\Excel\Events\{AfterSheet};
use Illuminate\Contracts\View\View;
use App\Exports\FatherExport;

class SeguimientoTalentosProyectosSheetExport extends FatherExport
{
    public function __construct($query)
    {
        $this->setQuery($query);
        $this->setCount($this->getQuery()->count() + 1);
        $this->setRangeHeadingCell('A1:F1');
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
     * Aplica estilos a las celdas
     * @param AfterSheet $event
     * @return void
     * @author dum
     */
    private function styledCells(AfterSheet $event)
    {
        // Estilos para los nombres de las columnas
        $event->sheet->getStyle($this->getRangeHeadingCell())->getFont()->setSize(14)->setBold(1);
        // Estilos para los registros de la consulta
        $init = 'A';
        for ($i=0; $i < 6 ; $i++) {
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
        return view('exports.seguimiento.talentos_proyectos', [
        'talentos' => $this->getQuery()
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
        return 'Talentos';
    }
}
