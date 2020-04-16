<?php

namespace App\Exports\User\Talento;

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

class InfoTalentoUserExport extends FatherExport implements Responsable, WithDrawings
{

    use Exportable, createDrawingsExcel;

    private $fileName = 'Talentos.xlsx';
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

        $this->setRangeHeadingCell('A7:U7');
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
                $event->sheet->setCellValue('D3', "Talentos " . config('app.name'))->getStyle('H3');
                $event->sheet->getStyle('D3:H3')->applyFromArray($this->styleArray());
                $event->sheet->getStyle('D3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('D3')->applyFromArray($styles['impares'])->getFont()->setSize(20)->setBold(1);

                $event->sheet->mergeCells('D4:H5');

                $event->sheet->mergeCells('I1:U5');

                $event->sheet->mergeCells('A6:N6');
                $event->sheet->setCellValue('A6', 'Información Personal')->getStyle('N6');
                $event->sheet->getStyle('A6:N6')->applyFromArray($this->styleArray());
                $event->sheet->getStyle('A6')->applyFromArray($styles['impares'])->getFont()->setBold(1);
                $event->sheet->getStyle('A6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $event->sheet->mergeCells('O6:P6');
                $event->sheet->setCellValue('O6', 'EPS')->getStyle('P6');
                $event->sheet->getStyle('O6:P6')->applyFromArray($this->styleArray());
                $event->sheet->getStyle('O6')->applyFromArray($styles['impares'])->getFont()->setBold(1);
                $event->sheet->getStyle('O6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $event->sheet->mergeCells('Q6:T6');
                $event->sheet->setCellValue('Q6', 'Último estudio')->getStyle('T6');
                $event->sheet->getStyle('Q6:T6')->applyFromArray($this->styleArray());
                $event->sheet->getStyle('Q6')->applyFromArray($styles['impares'])->getFont()->setBold(1);
                $event->sheet->getStyle('Q6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


                $event->sheet->setCellValue('U6', 'Tipo Talento')->getStyle('U6');
                $event->sheet->getStyle('U6:U6')->applyFromArray($this->styleArray());
                $event->sheet->getStyle('U6')->applyFromArray($styles['impares'])->getFont()->setBold(1);
                $event->sheet->getStyle('U6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $init = 'A';
                for ($i = 0; $i < 21; $i++) {
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
        return view('exports.users.talento.infoTalento', [
            'talentos' => $this->getQuery(),
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
