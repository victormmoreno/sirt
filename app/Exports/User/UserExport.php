<?php

namespace App\Exports\User;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Contracts\View\View;
use App\Exports\FatherExport;
use PhpOffice\PhpSpreadsheet\Style\Border;


class UserExport extends FatherExport
{
    use Queueable,Exportable, SerializesModels;
    private $request;
    private $query;
    const rowRangeHeading = 'A1:Y1';

    public function __construct($request, $query)
    {
        $this->request = $request;
        $this->query = $query;
        $this->setCount($this->query->count() + 1);
        $this->setRangeHeadingCell(Self::rowRangeHeading);
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
                $event->sheet->mergeCells('A1:A2');
                $event->sheet->mergeCells('B1:B2');
                $event->sheet->mergeCells('C1:C2');
                $event->sheet->mergeCells('D1:D2');
                $event->sheet->mergeCells('E1:E2');
                $event->sheet->mergeCells('F1:F2');
                $event->sheet->mergeCells('G1:G2');
                $event->sheet->mergeCells('H1:H2');
                $event->sheet->mergeCells('I1:I2');
                $event->sheet->mergeCells('J1:J2');
                $event->sheet->mergeCells('K1:K2');
                $event->sheet->mergeCells('L1:L2');
                $event->sheet->mergeCells('M1:M2');
                $event->sheet->mergeCells('N1:N2');
                $event->sheet->mergeCells('O1:O2');
                $event->sheet->mergeCells('P1:P2');
                $event->sheet->mergeCells('Q1:Q2');
                $event->sheet->mergeCells('R1:R2');
                $event->sheet->mergeCells('S1:S2');
                $event->sheet->mergeCells('T1:T2');
                $event->sheet->mergeCells('U1:U2');
                $event->sheet->mergeCells('V1:V2');
                $event->sheet->mergeCells('W1:W2');
                $event->sheet->mergeCells('X1:X2');
                $event->sheet->mergeCells('Y1:Y2');
                $event->sheet->mergeCells('Z1:AF1');

                // $this->setFilters($event);
                $event->sheet->setAutoFilter('A2:AF2');
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
                    ->getFont()
                    ->setBold(true);

                $event->sheet->getDelegate()->getStyle(Self::rowRangeHeading)
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                $event->sheet->getDelegate()->getStyle('Z1:AF2')
                    ->getFont()
                    ->setBold(true);

                $event->sheet->getDelegate()->getStyle('Z1:AF2')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);


            },
        ];
    }

    /**
     * @abstract
     */
    public function view(): View
    {
        return view('exports.users.index', [
            'users' => $this->query,
        ]);
    }

    /**
     * Asigna el nombre para la hoja de excel
     * @return string
     * @abstract
     */
    public function title(): String
    {
        return "Usuarios";
    }
}
