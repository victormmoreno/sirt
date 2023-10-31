<?php

namespace App\Exports\Metas;

use Illuminate\Contracts\View\View;
use PhpOffice\PhpSpreadsheet\Style\Border;
use App\Exports\FatherExport;
use Maatwebsite\Excel\Events\{AfterSheet};

class MetasExport extends FatherExport
{
    const rowRangeHeading = 'A1:AD2';
    public function __construct($query)
    {
        $this->setQuery($query);
        $this->setCount($this->getQuery()->count() + 1);
        $this->setRangeHeadingCell(self::rowRangeHeading);
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
                $this->combinarCeldas($event);
                $this->settingValues($event);
                $cellRange ="A1:{$event->sheet->getHighestColumn()}{$event->sheet->getHighestRow()}";
                $event->sheet->getStyle($cellRange)->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['argb' => '000000'],
                            ],
                        ],
                    ])->getAlignment()->setWrapText(true);
                $event->sheet->getDelegate()->getStyle(Self::rowRangeHeading)
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
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
        $event->sheet->mergeCells('F1:Q1');
        $event->sheet->mergeCells('R1:AC1');
        $event->sheet->mergeCells('AD1:AD2');
    }

    public function settingValues($event)
    {
        $event->sheet->setCellValue('F1', 'Proyectos TRL6 finalizados del nodo');
        $event->sheet->setCellValue('F2', 'enero');
        $event->sheet->setCellValue('G2', 'febrero');
        $event->sheet->setCellValue('H2', 'marzo');
        $event->sheet->setCellValue('I2', 'abril');
        $event->sheet->setCellValue('J2', 'mayo');
        $event->sheet->setCellValue('K2', 'junio');
        $event->sheet->setCellValue('L2', 'julio');
        $event->sheet->setCellValue('M2', 'agosto');
        $event->sheet->setCellValue('N2', 'septiembre');
        $event->sheet->setCellValue('O2', 'octubre');
        $event->sheet->setCellValue('P2', 'noviembre');
        $event->sheet->setCellValue('Q2', 'diciembre');
        $event->sheet->setCellValue('R1', 'Proyectos TRL7 y TRL8 finalizados del nodo');
        $event->sheet->setCellValue('R2', 'enero');
        $event->sheet->setCellValue('S2', 'febrero');
        $event->sheet->setCellValue('T2', 'marzo');
        $event->sheet->setCellValue('U2', 'abril');
        $event->sheet->setCellValue('V2', 'mayo');
        $event->sheet->setCellValue('W2', 'junio');
        $event->sheet->setCellValue('X2', 'julio');
        $event->sheet->setCellValue('Y2', 'agosto');
        $event->sheet->setCellValue('Z2', 'septiembre');
        $event->sheet->setCellValue('AA2', 'octubre');
        $event->sheet->setCellValue('AB2', 'noviembre');
        $event->sheet->setCellValue('AC2', 'diciembre');
        $event->sheet->setCellValue('AD1', 'Total de proyectos finalizados del nodo');

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
