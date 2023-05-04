<?php

namespace App\Exports\Articulation;

use Illuminate\Contracts\View\View;
use App\Exports\FatherExport;
use Maatwebsite\Excel\Events\{AfterSheet};
use PhpOffice\PhpSpreadsheet\Style\Border;

class ArticulationParticipantExport extends FatherExport
{
    const rowRangeHeading = 'A1:AE1';
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
                $this->setFilters($event);
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
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('FF32CD32');
                $event->sheet->getDelegate()->getStyle(Self::rowRangeHeading)
                    ->getFont()
                    ->setBold(true);
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
        return view('exports.articulations.articulations', [
            'articulations' => $this->getQuery()
        ]);
    }

    /**
     * Asigna el nombre para la hoja de excel
     * @return string
     * @abstract
     */
    public function title(): String
    {
        return "Talentos";
    }
}
