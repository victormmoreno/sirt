<?php

namespace App\Exports\User\Gestor;

use App\Exports\FatherExport;
use App\User;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use App\Http\Traits\ExcelTrait\createDrawingsExcel;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class GestorUserExport extends FatherExport implements Responsable, WithDrawings
{

    use Exportable, createDrawingsExcel;

    private $fileName = 'Gestores.xlsx';
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

        $this->setRangeHeadingCell('A7:X7');
        $this->setRangeBodyCell('A8:O' . $this->getCount());
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
                $event->sheet->getStyle($this->getRangeHeadingCell())->getFont()->setSize(14)->setBold(1);
                $event->sheet->mergeCells('A1:C5');

                $event->sheet->mergeCells('D1:H2');


                $event->sheet->mergeCells('D3:H3');
                $event->sheet->setCellValue('D3', "Gestores " . config('app.name'))->getStyle('H3');
                $event->sheet->getStyle('D3:H3')->applyFromArray($this->styleArray());
                $event->sheet->getStyle('D3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('D3')->applyFromArray($styles['impares'])->getFont()->setSize(20)->setBold(1);

                $event->sheet->mergeCells('D4:H5');

                $event->sheet->mergeCells('I1:X5');
                $event->sheet->mergeCells('A6:B6');
                $event->sheet->setCellValue('A6', 'TECNOPARQUES')->getStyle('B6');
                $event->sheet->getStyle('A6:B6')->applyFromArray($this->styleArray());
                $event->sheet->getStyle('A6')->applyFromArray($styles['impares'])->getFont()->setBold(1);
                $event->sheet->getStyle('A6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $event->sheet->mergeCells('C6:O6');
                $event->sheet->setCellValue('C6', 'Información Personal')->getStyle('O6');
                $event->sheet->getStyle('C6:O6')->applyFromArray($this->styleArray());
                $event->sheet->getStyle('C6')->applyFromArray($styles['impares'])->getFont()->setBold(1);
                $event->sheet->getStyle('C6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $event->sheet->mergeCells('P6:Q6');
                $event->sheet->setCellValue('P6', 'EPS')->getStyle('Q6');
                $event->sheet->getStyle('P6:Q6')->applyFromArray($this->styleArray());
                $event->sheet->getStyle('P6')->applyFromArray($styles['impares'])->getFont()->setBold(1);
                $event->sheet->getStyle('Q6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $event->sheet->mergeCells('R6:U6');
                $event->sheet->setCellValue('R6', 'Último estudio')->getStyle('U6');
                $event->sheet->getStyle('R6:U6')->applyFromArray($this->styleArray());
                $event->sheet->getStyle('R6')->applyFromArray($styles['impares'])->getFont()->setBold(1);
                $event->sheet->getStyle('R6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $event->sheet->mergeCells('V6:W6');
                $event->sheet->setCellValue('V6', 'Ocupaciones')->getStyle('W6');
                $event->sheet->getStyle('V6:W6')->applyFromArray($this->styleArray());
                $event->sheet->getStyle('V6')->applyFromArray($styles['impares'])->getFont()->setBold(1);
                $event->sheet->getStyle('V6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // $event->sheet->mergeCells('X6');
                $event->sheet->setCellValue('X6', 'Honararios')->getStyle('X6');
                $event->sheet->getStyle('X6')->applyFromArray($this->styleArray());
                $event->sheet->getStyle('X6')->applyFromArray($styles['impares'])->getFont()->setBold(1);
                $event->sheet->getStyle('X6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $init = 'A';
                for ($i = 0; $i < 24; $i++) {
                    $temp        = $init++;
                    $coordenadas = $temp . '7:' . $temp . $this->getCount();
                    $event->sheet->getStyle($coordenadas)->applyFromArray($this->styleArray());
                    if ($i % 2 == 0) {
                        $event->sheet->getStyle($coordenadas)->applyFromArray($styles['pares']);
                    } else {
                        $event->sheet->getStyle($coordenadas)->applyFromArray($styles['impares']);
                    }
                }
            },
        ];
    }

    /**
     * @abstract
     */
    public function view(): View
    {

        return view('exports.users.gestor.index', [
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
        return 'Gestores';
    }
}
