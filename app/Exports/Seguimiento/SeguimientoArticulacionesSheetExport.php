<?php

namespace App\Exports\Seguimiento;

use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Events\{AfterSheet};
use Illuminate\Contracts\View\View;
use App\Exports\FatherExport;

class SeguimientoArticulacionesSheetExport extends FatherExport
{

  private $title;

  public function __construct($query, $title)
  {
    $this->setTitle($title);
    $this->setQuery($query);
    // dd($this->getQuery());
    $this->setCount($this->getQuery()->count() + 7);
    $this->setRangeHeadingCell('A7:P7');
  }

  public function registerEvents(): array
  {
    $columnPar = $this->styleArrayColumnsPar();
    $columnImPar = $this->styleArrayColumnsImPar();
    // $styles = array('pares' => $columnPar, 'impares' => $columnImPar);
    return [
      AfterSheet::class => function(AfterSheet $event) {
        $this->setCellsValues($event);
        $this->mergedCells($event);
        $this->styledCells($event);
      },
    ];
  }

  /**
   * Asigna valores a celdas
   * @param AfterSheet $event
   * @return void
   */
  private function setCellsValues(AfterSheet $event)
  {
    $event->sheet->setCellValue('K6', 'Entregables');
  }

  /**
   * Aplica estilos a las celdas
   * @param AfterSheet $event
   * @return void
   * @author dum
   */
  private function styledCells(AfterSheet $event)
  {
    // Estilos para la centa de Entregables
    $event->sheet->getStyle('K6:P6')->applyFromArray($this->styleArray());
    $event->sheet->getStyle('K6')->applyFromArray($this->styleArrayColumnsImPar())->getFont()->setBold(1);
    $event->sheet->getStyle('K6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    // Estilos para los nombres de las columnas
    $event->sheet->getStyle($this->getRangeHeadingCell())->getFont()->setSize(14)->setBold(1);
    // Estilos para los registros de la consulta
    $init = 'A';
    for ($i=0; $i < 16 ; $i++) {
      $temp = $init++;
      $coordenadas = $temp . '7:'. $temp . $this->getCount();
      $event->sheet->getStyle($coordenadas)->applyFromArray($this->styleArray());
      if ( $i % 2 == 0 ) {
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
    // Celdas combinadas de los entregables
    $event->sheet->mergeCells('K6:P6');
    // Celdas combinadas hasta donde inician los entregables
    $event->sheet->mergeCells('A1:J6');
    // Celdas combinadas arribas de los entregables
    $event->sheet->mergeCells('K1:P5');
  }

  /**
  * @abstract
  */
  public function view(): View
  {
    return view('exports.seguimiento.articulaciones', [
      'articulaciones' => $this->getQuery()
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
    return 'Articulacion - ' . $this->getTitle();
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
    $drawing2->setCoordinates('F1');
    return [$drawing, $drawing2];
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
