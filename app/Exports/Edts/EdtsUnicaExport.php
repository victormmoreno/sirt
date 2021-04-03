<?php

namespace App\Exports\Edts;

use Illuminate\Contracts\View\View;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use App\Exports\FatherExport;
use Maatwebsite\Excel\Events\{AfterSheet};

class EdtsUnicaExport extends FatherExport
{

    private $entidades;

    public function __construct($query, $entidades)
    {
        $this->setEntidades($entidades);
        $this->setQuery($query);
        $this->setCount(8);
        $this->setRangeHeadingCell('A1:O1');
        $this->setRangeBodyCell('A1:O1');
    }

    /**
     * @abstract
    */
    public function view(): View
    {
        return view('exports.edt.id', [
        'edt' => $this->getQuery()
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
        $columnPar = $this->styleArrayColumnsPar();
        $columnImPar = $this->styleArrayColumnsImPar();
        $styles = array('pares' => $columnPar, 'impares' => $columnImPar);
        return [
        AfterSheet::class => function(AfterSheet $event) use ($styles) {
            $event->sheet->getStyle($this->getRangeHeadingCell())->applyFromArray($this->styleArray())->getFont()->setSize(14)->setBold(1);
            $event->sheet->getStyle($this->getRangeBodyCell())->applyFromArray($this->styleArray());

        },
        ];
    }

    /**
     * Muestra las entidades de una edt en el archivo Excel
     * @param AfterSheet $event
     * @param array $styles
     * @return void
     * @author dum
     */
    public function printEntidades($event, $styles)
    {
        $event->sheet->mergeCells('G11:H11');
        $event->sheet->setCellValue('G11', 'Empresas que participan');
        $event->sheet->setCellValue('G12', 'Nit');
        $event->sheet->setCellValue('H12', 'Nombre');
        $event->sheet->getStyle('G11:H12')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $row = 0;
        $inicio = 13;
        foreach ($this->getEntidades() as $key => $value) {
        $row = $inicio + $key;
        $event->sheet->setCellValue('G'.$row, $value->nit);
        $event->sheet->setCellValue('H'.$row, $value->nombre);
        }
        $event->sheet->getStyle('G11:H'.$row)->applyFromArray($styles['pares']);
        $event->sheet->getStyle('G11:H'.$row)->applyFromArray($this->styleArray())->getFont()->setBold(1);
    }

    /**
     * Asigna el nombre para la hoja de excel
    * @return string
    * @abstract
    * @author dum
    */
    public function title(): String
    {
        return 'Edt';
    }

    /**
     * Asignar un valor a entidades
     *
     * @param object $entidades
     * @return void
     * @author dum
     */
    private function setEntidades($entidades) {
        $this->entidades = $entidades;
    }

    /**
     * Retorna el valor de entidades
     * @return object
     * @author dum
     */
    public function getEntidades()
    {
        return $this->entidades;
    }

}
