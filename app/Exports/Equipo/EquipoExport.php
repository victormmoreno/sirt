<?php

namespace App\Exports\Equipo;

use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Events\{AfterSheet};
use Illuminate\Contracts\View\View;
use App\Exports\FatherExport;
use Maatwebsite\Excel\Concerns\Exportable;


class EquipoExport extends FatherExport
{
    use Exportable;
    private $request;
    private $query;


    public function __construct($request, $query)
    {
        $this->request = $request;
        $this->query = $query;
        $this->setCount($this->query->count() + 7);
        $this->setRangeHeadingCell('A7:L7');
    }

    public function registerEvents(): array
    {
        $columnPar = $this->styleArrayColumnsPar();
        $columnImPar = $this->styleArrayColumnsImPar();
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $this->mergedCells($event);
                $this->styledCells($event);
                $this->setFilters($event);
            },
        ];
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
        for ($i = 0; $i < 12; $i++) {
            $temp = $init++;
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
     * @author devjul
     */
    private function mergedCells(AfterSheet $event)
    {

        $event->sheet->mergeCells('A1:L6');
    }

    /**
     * @abstract
     */
    public function view(): View
    {
        return view('exports.equipo.index', [
            'equipos' => $this->query,
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
        return "Equipos";
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
        $drawing->setHeight(80);
        $drawing->setWidth(200);
        $drawing->setCoordinates('A1');

        return $drawing;
    }
}
