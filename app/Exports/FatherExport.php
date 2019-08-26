<?php

namespace App\Exports;

use Illuminate\Contracts\Queue\ShouldQueue;
use PhpOffice\PhpSpreadsheet\Style\{Border, Fill};

class FatherExport
{

  private $RangeHeadingCell;
  private $RangeBodyCell;
  private $count;

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

}
