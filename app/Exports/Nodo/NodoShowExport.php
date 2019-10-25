<?php

namespace App\Exports\Nodo;

use App\Exports\FatherExport;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class NodoShowExport extends FatherExport
{
    public function __construct($query)
    {
        $this->setQuery($query);
        $this->setCount($this->getQuery()->count() + 7);
        $this->setRangeHeadingCell('A7:I7');

    }

    /**
     * @abstract
     */
    public function view(): View
    {
        return view('exports.nodo.showExport', [
            'nodos' => $this->getQuery(),
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
        $columnPar   = $this->styleArrayColumnsPar();
        $columnImPar = $this->styleArrayColumnsImPar();
       
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $this->styledCells($event);
                $this->mergedCells($event);
                $this->setFilters($event);
                $event->sheet->mergeCells('D2:G2');
                $event->sheet->mergeCells('C1:C6');
                $event->sheet->mergeCells('D1:G1');
                $event->sheet->mergeCells('D5:G6');
                $event->sheet->mergeCells('H1:J6');
                $event->sheet->mergeCells('A1:B6');
            
                $event->sheet->getStyle('D2:G4')->applyFromArray($this->styleArray());
                $event->sheet->setCellValue('D3', 'Tecnoparque Nodo')->getStyle('D3')->getFont()->setBold(1);
                $event->sheet->setCellValue('E3', 'Corrreo Elctrónico')->getStyle('E3')->getFont()->setBold(1);
                $event->sheet->setCellValue('F3', 'Dirección')->getStyle('F3')->getFont()->setBold(1);
                $event->sheet->setCellValue('G3', 'Telefono')->getStyle('G3')->getFont()->setBold(1);
                $event->sheet->setCellValue('D4', $this->getQuery()->entidad->nombre);
                $event->sheet->setCellValue('E4', $this->getQuery()->entidad->email_entidad);
                $event->sheet->setCellValue('F4', $this->getQuery()->direccion);
                $event->sheet->setCellValue('G4', $this->getQuery()->telefono);
                
            },
        ];
    }

    /**
     * Asigna el nombre para la hoja de excel
     * @return string
     * @abstract
     * @author dum
     */
    public function title(): String
    {
        return 'Nodos';
    }

    /**
     * Método para pinta imágenes en el archivo de Excel
     * @return object
     * @abstract
     * @author dum
     */
    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo Tecnoparque');
        $drawing->setPath(public_path('/img/logonacional_Negro.png'));
        $drawing->setResizeProportional(false);
        $drawing->setHeight(104);
        $drawing->setWidth(120);
        $drawing->setCoordinates('A1');

        $drawing2 = new Drawing();
        $drawing2->setName('Logo Sennova');
        $drawing2->setPath(public_path('/img/sennova.png'));
        $drawing2->setResizeProportional(false);
        $drawing2->setHeight(104);
        $drawing2->setWidth(180);
        $drawing2->setCoordinates('H1');
        return [$drawing, $drawing2];
    }

    /**
     * Asigna valores a celdas
     * @param AfterSheet $event
     * @return void
     */
    private function setCellsValues(AfterSheet $event)
    {
        $event->sheet->setCellValue('D2', 'NODO');
    }

    /**
     * Aplica estilos a las celdas
     * @param AfterSheet $event
     * @return void
     * @author dum
     */
    private function styledCells(AfterSheet $event)
    {

        // Estilos para los nombres de las columnas
        $event->sheet->getStyle($this->getRangeHeadingCell())->getFont()->setSize(14)->setBold(1);
        // Estilos para los registros de la consulta
        $init = 'A';
        for ($i = 0; $i < 9; $i++) {
            $temp        = $init++;
            $coordenadas = $temp . '7:' . $temp . $this->getCount();
            $event->sheet->getStyle($coordenadas)->applyFromArray($this->styleArray());
            if ($i % 2 == 0) {
                $event->sheet->getStyle($coordenadas)->applyFromArray($this->styleArrayColumnsPar());
            } else {
                $event->sheet->getStyle($coordenadas)->applyFromArray($this->styleArrayColumnsImPar());
            }
        }
    }

    /**
     * Funcion para la combinación de celdas
     * @param AfterSheet $event
     * @return void
     * @author dum
     */
    private function mergedCells(AfterSheet $event)
    {

        // // Celdas combinadas hasta donde inician los entregables
        $event->sheet->mergeCells('A1:C6');

    }

    /**
     * Asigna un valor a $title
     * @param string $title
     * @return void
     * @author dum
     */
    private function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Retorna el valor de $title
     * @return string
     * @author dum
     */
    private function getTitle()
    {
        return $this->title;
    }
}
