<?php

namespace App\Exports\Seguimiento;

use Illuminate\Contracts\View\View;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use App\Exports\FatherExport;
use Maatwebsite\Excel\Events\{AfterSheet};
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Models\Proyecto;

class SeguimientoSheetExport extends FatherExport
{

  private $title;

  public function __construct($query, $title)
  {
    $this->setTitle($title);
    $this->setQuery($query);
    $this->setCount($this->getQuery()->count() + 7);
    $this->setRangeHeadingCell('A7:AG7');
  }

  public function registerEvents(): array
  {
    $columnPar = $this->styleArrayColumnsPar();
    $columnImPar = $this->styleArrayColumnsImPar();
    $styles = array('pares' => $columnPar, 'impares' => $columnImPar);
    return [
      AfterSheet::class => function(AfterSheet $event) use ($styles) {
        $event->sheet->getStyle($this->getRangeHeadingCell())->getFont()->setSize(14)->setBold(1);
        $event->sheet->mergeCells('W6:AF6');
        $event->sheet->mergeCells('A1:V6');
        $event->sheet->mergeCells('W1:AF5');
        $event->sheet->mergeCells('AG1:AG6');
        $event->sheet->setCellValue('W6', 'Entregables')->getStyle('M6');
        $event->sheet->getStyle('W6:AF6')->applyFromArray($this->styleArray());
        $event->sheet->getStyle('W6')->applyFromArray($styles['impares'])->getFont()->setBold(1);
        $event->sheet->getStyle('W6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $init = 'A';
        for ($i=0; $i < 33 ; $i++) {
          $temp = $init++;
          $coordenadas = $temp . '7:'. $temp . $this->getCount();
          $event->sheet->getStyle($coordenadas)->applyFromArray($this->styleArray());
          if ( $i % 2 == 0 ) {
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
    return view('exports.seguimiento.proyectos', [
      'proyectos' => $this->getQuery()
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
    return 'Proyectos - ' . $this->getTitle();
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
