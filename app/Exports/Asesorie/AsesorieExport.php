<?php

namespace App\Exports\Asesorie;

use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Contracts\View\View;
use App\Exports\FatherExport;
use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Style\Border;


class AsesorieExport extends FatherExport
{
    use Exportable;
    private $request;
    private $query;
    const rowRangeHeading = 'A1:L1';
    public function __construct($request, $query)
    {
        $this->request = $request;
        $this->query = $query;
        $this->setCount($this->query->count() + 1);
        $this->setRangeHeadingCell(self::rowRangeHeading);
    }

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
        return view('exports.asesorias.index', [
            'asesories' => $this->query,
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
        return "Asesorias y usos";
    }
}
