<?php

namespace App\Exports\Metas;

use Illuminate\Contracts\View\View;
use App\Exports\FatherExport;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class MetasArticulationExport extends FatherExport
{
    const rowRangeHeading = 'A1:S2';
    public function __construct($query)
    {
        $this->setQuery($query);
        $this->setCount($this->getQuery()->count() + 1);
        $this->setRangeHeadingCell(self::rowRangeHeading);
    }

    /**
     * Método para aplicar estilos al archivo excel después de que se genera la hoja de excel
     * @return array
     * @abstract
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event){
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

    /**
     * @abstract
     */
    public function view(): View
    {
        return view('exports.metas.metas-articulaciones', [
            'metas' => $this->getQuery()
        ]);
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
        $event->sheet->mergeCells('S1:S2');
    }

    public function settingValues($event)
    {
        $event->sheet->setCellValue('G1', 'Articulaciones finalizadas del nodo');
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
        $event->sheet->setCellValue('S1', 'Total de Articulaciones finalizadas del nodo');
    }



    /**
     * Asigna el nombre para la hoja de excel
     * @return string
     * @abstract
     * @author dum
     */
    public function title(): String
    {
        return 'Articulaciones';
    }
}
