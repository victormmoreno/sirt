<?php

namespace App\Exports\Edts;

use Illuminate\Contracts\View\View;
use App\Models\Articulacion;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use App\Exports\FatherExport;
use Maatwebsite\Excel\Events\{AfterSheet};
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class EdtsUnicaExport extends FatherExport
{

  private $entidades;

  public function __construct($query, $entidades)
  {
    $this->setEntidades($entidades);
    $this->setQuery($query);
    $this->setCount(8);
    // dd($this->getEntidades()->count());
    $this->setRangeHeadingCell('A7:O7');
    $this->setRangeBodyCell('A8:O8');
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

        // $event->sheet->mergeCells('A1:B6');
        $event->sheet->mergeCells('I6:L6');
        $event->sheet->mergeCells('M6:O6');

        $event->sheet->mergeCells('A1:H6');
        $event->sheet->mergeCells('I1:O5');

        $event->sheet->getStyle('I6:O6')->applyFromArray($styles['pares'])->getFont()->setBold(1);
        $event->sheet->getStyle('I6:O6')->applyFromArray($this->styleArray())->getFont()->setBold(1);
        $event->sheet->setCellValue('I6', 'Asistentes')->getStyle('I6');

        $event->sheet->setCellValue('M6', 'Entregables')->getStyle('M6');
        $event->sheet->getStyle('M6:O6')->applyFromArray($styles['impares'])->getFont()->setBold(1);
        $event->sheet->getStyle('I6:M6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $event->sheet->getStyle('A7:A'.$this->getCount())->applyFromArray($styles['pares']);
        $event->sheet->getStyle('B7:B'.$this->getCount())->applyFromArray($styles['impares']);
        $event->sheet->getStyle('C7:C'.$this->getCount())->applyFromArray($styles['pares']);
        $event->sheet->getStyle('D7:D'.$this->getCount())->applyFromArray($styles['impares']);
        $event->sheet->getStyle('E7:E'.$this->getCount())->applyFromArray($styles['pares']);
        $event->sheet->getStyle('F7:F'.$this->getCount())->applyFromArray($styles['impares']);
        $event->sheet->getStyle('G7:G'.$this->getCount())->applyFromArray($styles['pares']);
        $event->sheet->getStyle('H7:H'.$this->getCount())->applyFromArray($styles['impares']);
        $event->sheet->getStyle('I7:I'.$this->getCount())->applyFromArray($styles['pares']);
        $event->sheet->getStyle('J7:J'.$this->getCount())->applyFromArray($styles['impares']);
        $event->sheet->getStyle('K7:K'.$this->getCount())->applyFromArray($styles['pares']);
        $event->sheet->getStyle('L7:L'.$this->getCount())->applyFromArray($styles['impares']);
        $event->sheet->getStyle('M7:M'.$this->getCount())->applyFromArray($styles['pares']);
        $event->sheet->getStyle('N7:N'.$this->getCount())->applyFromArray($styles['impares']);
        $event->sheet->getStyle('O7:O'.$this->getCount())->applyFromArray($styles['pares']);
        // $event->sheet->getStyle('P7:P8')->applyFromArray($styles['impares']);
        $this->printEntidades($event, $styles);

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
