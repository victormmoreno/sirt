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

class AdminUserExport extends FatherExport implements Responsable, WithDrawings
{

    use Exportable, createDrawingsExcel;

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

        $this->setRangeHeadingCell('A7:U7');
        $this->setRangeBodyCell('A8:O' . $this->getCount());
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo Tecnoparque');
        $drawing->setPath(public_path('/img/logonacional_Negro.png'));
        $drawing->setResizeProportional(false);
        $drawing->setHeight(90);
        $drawing->setWidth(300);
        $drawing->setCoordinates('B2');

        $drawing2 = new Drawing();
        $drawing2->setName('Logo Sennova');
        $drawing2->setPath(public_path('/img/sennova.png'));
        $drawing2->setResizeProportional(false);
        $drawing2->setHeight(90);
        $drawing2->setWidth(300);
        $drawing2->setCoordinates('K2');
        return [$drawing, $drawing2];
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
                $event->sheet->setCellValue('D3', "Administradores " . config('app.name'))->getStyle('H3');
                $event->sheet->getStyle('D3:H3')->applyFromArray($this->styleArray());
                $event->sheet->getStyle('D3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('D3')->applyFromArray($styles['impares'])->getFont()->setSize(20)->setBold(1);

                $event->sheet->mergeCells('D4:H5');

                $event->sheet->mergeCells('I1:U5');

                $event->sheet->mergeCells('A6:M6');
                $event->sheet->setCellValue('A6', 'Información Personal')->getStyle('M6');
                $event->sheet->getStyle('A6:M6')->applyFromArray($this->styleArray());
                $event->sheet->getStyle('A6')->applyFromArray($styles['impares'])->getFont()->setBold(1);
                $event->sheet->getStyle('A6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $event->sheet->mergeCells('N6:O6');
                $event->sheet->setCellValue('N6', 'EPS')->getStyle('O6');
                $event->sheet->getStyle('N6:O6')->applyFromArray($this->styleArray());
                $event->sheet->getStyle('N6')->applyFromArray($styles['impares'])->getFont()->setBold(1);
                $event->sheet->getStyle('N6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $event->sheet->mergeCells('P6:S6');
                $event->sheet->setCellValue('P6', 'Último estudio')->getStyle('S6');
                $event->sheet->getStyle('P6:S6')->applyFromArray($this->styleArray());
                $event->sheet->getStyle('P6')->applyFromArray($styles['impares'])->getFont()->setBold(1);
                $event->sheet->getStyle('P6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $event->sheet->mergeCells('T6:U6');
                $event->sheet->setCellValue('T6', 'Ocupaciones')->getStyle('U6');
                $event->sheet->getStyle('T6:U6')->applyFromArray($this->styleArray());
                $event->sheet->getStyle('T6')->applyFromArray($styles['impares'])->getFont()->setBold(1);
                $event->sheet->getStyle('T6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

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
        return 'Administradores';
    }

}
