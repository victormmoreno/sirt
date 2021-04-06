<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\{FromView, ShouldAutoSize, WithTitle, WithEvents};
use PhpOffice\PhpSpreadsheet\Style\{Border, Fill};
use Maatwebsite\Excel\Events\{AfterSheet};
use Illuminate\Contracts\View\View;
abstract class FatherExport implements FromView, WithTitle, WithEvents, ShouldAutoSize
{
    private $RangeHeadingCell;
    private $RangeBodyCell;
    private $query;
    private $count;

    /**
     * Asigna filtro a celdas
     * @param AfterSheet $event
     * @return void
     * @author dum
     */
    protected function setFilters($event)
    {
        $event->sheet->setAutoFilter($this->getRangeHeadingCell());
    }

    /**
     * Array de estilos para el archivo de excel
    *
    * @return array
    * @author dum
    */
    protected function styleArray() {
        return [
        'borders' => [
            'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['argb' => '000000'],
            ],
        ],
        ];
    }

    /**
     * Método para estableces los estilos de las columnas pares
    * @return array
    * @author dum
    */
    protected function styleArrayColumnsPar(){
        return [
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'color' => ['rgb' => 'C6E0B4'],
        ],
        ];
    }

    /**
     * Método que establece los estilo para las columnas impares
    * @return array
    * @author dum
    */
    protected function styleArrayColumnsImPar(){
        return [
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'color' => ['rgb' => 'B4C6E7'],
        ],
        ];
    }

    /**
     * Método para obtener las coordenadas del encabezado
     * @return string
     * @author dum
     */
    protected function getRangeHeadingCell()
    {
        return $this->RangeHeadingCell;
    }

    /**
     * Método para asignar el rango de la celdas del encabezado
    * @param string $coords
    * @return void
    * @author dum
    */
    protected function setRangeHeadingCell($coords)
    {
        $this->RangeHeadingCell = $coords;
    }

    /**
     * Método para obtener el rango de la celdas del cuerpo
    * @return string
    * @author dum
    */
    protected function getRangeBodyCell()
    {
        return $this->RangeBodyCell;
    }

    /**
     *
    * Método para asignar el rango de la celdas del cuerpo (lo que va a ocupar la consulta)
    * @param string $coords
    * @return void
    * @return void
    */
    protected function setRangeBodyCell($coords)
    {
        $this->RangeBodyCell = $coords;
    }

    /**
     * Método para obtener el tamaño de la consulta
    * @return int
    * @author dum
    */
    protected function getCount() {
        return $this->count;
    }

    /**
     * Método para establecer el tamaño de la consulta
    * @param int $count Tamaño
    * @return void
    * @author dum
    */
    protected function setCount($count) {
        $this->count = $count;
    }

    /**
     * Asigna un valor a $query
     * @param object $query
     * @return void
     * @author dum
     */
    protected function setQuery($query){
        $this->query = $query;
    }

    /**
     * Retorna un valor a $query
     * @return object
     * @author dum
     */
    protected function getQuery(){
        return $this->query;
    }

    abstract public function registerEvents(): array;

    abstract public function title(): String;

    abstract public function view(): View;

}
