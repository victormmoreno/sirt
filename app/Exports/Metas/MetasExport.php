<?php

namespace App\Exports\Metas;

use Illuminate\Contracts\View\View;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use App\Exports\FatherExport;
use Maatwebsite\Excel\Events\{AfterSheet};

class MetasExport extends FatherExport
{

    public function __construct($query)
    {
        $this->setQuery($query);
        $this->setCount($this->getQuery()->count() + 1);
        $this->setRangeHeadingCell('A1:AB1');
    }

    /**
     * @abstract
     */
    public function view(): View
    {
        return view('exports.metas.metas', [
            'metas' => $this->getQuery()
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
                // $this->setFilters($event);
                $this->combinarCeldas($event);
                $this->settingValues($event);
            },
        ];
    }

    public function combinarCeldas($event)
    {
        $event->sheet->mergeCells('A1:A2');
        $event->sheet->mergeCells('B1:B2');
        $event->sheet->mergeCells('C1:C2');
        $event->sheet->mergeCells('D1:D2');
        $event->sheet->mergeCells('E1:E2');
        $event->sheet->mergeCells('F1:F2');
        $event->sheet->mergeCells('G1:R1');
        $event->sheet->mergeCells('S1:AD1');
        $event->sheet->mergeCells('AE1:AE2');
    }

    public function settingValues($event)
    {
        $event->sheet->setCellValue('G1', 'Proyectos TRL6 finalizados del nodo');
        $event->sheet->setCellValue('G2', 'enero');
        $event->sheet->setCellValue('H2', 'febrero');
        $event->sheet->setCellValue('I2', 'marzo');
        $event->sheet->setCellValue('J2', 'abril');
        $event->sheet->setCellValue('K2', 'mayo');
        $event->sheet->setCellValue('L2', 'junio');
        $event->sheet->setCellValue('M2', 'julio');
        $event->sheet->setCellValue('N2', 'agosto');
        $event->sheet->setCellValue('O2', 'septiembre');
        $event->sheet->setCellValue('P2', 'octubre');
        $event->sheet->setCellValue('Q2', 'noviembre');
        $event->sheet->setCellValue('R2', 'diciembre');
        $event->sheet->setCellValue('S1', 'Proyectos TRL7 y TRL8 finalizados del nodo');
        $event->sheet->setCellValue('S2', 'enero');
        $event->sheet->setCellValue('T2', 'febrero');
        $event->sheet->setCellValue('U2', 'marzo');
        $event->sheet->setCellValue('V2', 'abril');
        $event->sheet->setCellValue('W2', 'mayo');
        $event->sheet->setCellValue('X2', 'junio');
        $event->sheet->setCellValue('Y2', 'julio');
        $event->sheet->setCellValue('Z2', 'agosto');
        $event->sheet->setCellValue('AA2', 'septiembre');
        $event->sheet->setCellValue('AB2', 'octubre');
        $event->sheet->setCellValue('AC2', 'noviembre');
        $event->sheet->setCellValue('AD2', 'diciembre');
        $event->sheet->setCellValue('AE1', 'Total de proyectos finalizados del nodo');
        
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
