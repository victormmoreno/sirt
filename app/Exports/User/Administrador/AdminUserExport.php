<?php

namespace App\Exports\User\Administrador;

use App\Exports\FatherExport;
use App\User;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class AdminUserExport extends FatherExport implements Responsable, WithDrawings
{

    use Exportable;

    private $fileName = 'administradores.xlsx';
    /**
     * @return \Illuminate\Support\Collection
     */

    public function __construct($query)
    {
        $this->setQuery($query);
        if ($this->getQuery() == null) {
            $this->setCount(0);
        } else {
            $this->setCount($this->getQuery()->count() + 7);
        }

        $this->setRangeHeadingCell('A7:O7');
        $this->setRangeBodyCell('A8:O' . $this->getCount());
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('/img/logonacional_Negro.png'));
        $drawing->setHeight(90);
        $drawing->setCoordinates('A1');

        return $drawing;
    }

    /**
     * Método para aplicar estilos al archivo excel después de que se genera la hoja de excel
     * @return array
     * @abstract
     * @author dum
     */
    public function registerEvents(): array
    {
        $columnPar   = $this->styleArrayColumnsPar();
        $columnImPar = $this->styleArrayColumnsImPar();
        $styles      = array('pares' => $columnPar, 'impares' => $columnImPar);
        return [
            AfterSheet::class => function (AfterSheet $event) use ($styles) {
                $event->sheet->getStyle($this->getRangeHeadingCell())->applyFromArray($this->styleArray())->getFont()->setSize(14)->setBold(1);
                $event->sheet->getStyle($this->getRangeBodyCell())->applyFromArray($this->styleArray());

                // $event->sheet->mergeCells('A1:B6');
                // $event->sheet->mergeCells('I5:L5');
                // $event->sheet->mergeCells('M5:O5');

                $event->sheet->setCellValue('L6', 'Asistentes')->getStyle('L6');
                $event->sheet->mergeCells('A6:L6');
                $event->sheet->getStyle('A6:L6')->applyFromArray($this->styleArray())->getFont()->setBold(1);
                // $event->sheet->getStyle('I6:O5')->applyFromArray($this->styleArray())->getFont()->setBold(1);
                // $event->sheet->setCellValue('I5', 'Asistentes')->getStyle('I6');

                // $event->sheet->mergeCells('A1:H5');
                // $event->sheet->mergeCells('I1:O5');

                $event->sheet->getStyle('I6:O5')->applyFromArray($styles['pares'])->getFont()->setBold(1);
                

                $event->sheet->setCellValue('M5', 'Entregables')->getStyle('M6');
                $event->sheet->getStyle('M5:O5')->applyFromArray($styles['impares'])->getFont()->setBold(1);
                $event->sheet->getStyle('I5:M5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // $event->sheet->getStyle('A7:A' . $this->getCount())->applyFromArray($styles['pares']);
                // $event->sheet->getStyle('B7:B' . $this->getCount())->applyFromArray($styles['impares']);
                // $event->sheet->getStyle('C7:C' . $this->getCount())->applyFromArray($styles['pares']);
                // $event->sheet->getStyle('D7:D' . $this->getCount())->applyFromArray($styles['impares']);
                // $event->sheet->getStyle('E7:E' . $this->getCount())->applyFromArray($styles['pares']);
                // $event->sheet->getStyle('F7:F' . $this->getCount())->applyFromArray($styles['impares']);
                // $event->sheet->getStyle('G7:G' . $this->getCount())->applyFromArray($styles['pares']);
                // $event->sheet->getStyle('H7:H' . $this->getCount())->applyFromArray($styles['impares']);
                // $event->sheet->getStyle('I7:I' . $this->getCount())->applyFromArray($styles['pares']);
                // $event->sheet->getStyle('J7:J' . $this->getCount())->applyFromArray($styles['impares']);
                // $event->sheet->getStyle('K7:K' . $this->getCount())->applyFromArray($styles['pares']);
                // $event->sheet->getStyle('L7:L' . $this->getCount())->applyFromArray($styles['impares']);
                // $event->sheet->getStyle('M7:M' . $this->getCount())->applyFromArray($styles['pares']);
                // $event->sheet->getStyle('N7:N' . $this->getCount())->applyFromArray($styles['impares']);
                // $event->sheet->getStyle('O7:O' . $this->getCount())->applyFromArray($styles['pares']);

            },
        ];
    }

    /**
     * @abstract
     */
    public function view(): View
    {

        return view('exports.users.administrador.administrador', [
            'users' => $this->getQuery(),
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
        return 'Administrador';
    }

}
