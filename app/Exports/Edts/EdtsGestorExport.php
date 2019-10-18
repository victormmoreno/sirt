<?php

namespace App\Exports\Edts;

use Illuminate\Contracts\View\View;
use App\Models\Articulacion;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use App\Exports\FatherExport;
// use Maatwebsite\Excel\Concerns\{FromView, ShouldAutoSize, WithEvents, WithDrawings};
use Maatwebsite\Excel\Events\{AfterSheet};
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class EdtsGestorExport extends FatherExport
{

  public function __construct($query)
  {
    $this->setQuery($query);
    $this->setCount($this->getQuery()->count() + 7);
    $this->setRangeHeadingCell('A7:P7');
    $this->setRangeBodyCell('A8:P'.$this->getCount());
  }

  /**
   * @abstract
   */
  public function view(): View
  {
    // dd($this->getQuery());
    return view('exports.edt.gestor', [
      'edts' => $this->getQuery()
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
        $event->sheet->mergeCells('J6:M6');
        $event->sheet->mergeCells('N6:P6');

        $event->sheet->mergeCells('A1:H6');
        $event->sheet->mergeCells('I1:P5');

        $event->sheet->getStyle('J6:M6')->applyFromArray($styles['pares'])->getFont()->setBold(1);
        $event->sheet->getStyle('J6:M6')->applyFromArray($this->styleArray())->getFont()->setBold(1);
        $event->sheet->setCellValue('J6', 'Asistentes')->getStyle('J6');

        $event->sheet->setCellValue('N6', 'Entregables')->getStyle('N6');
        $event->sheet->getStyle('N6:P6')->applyFromArray($styles['impares'])->getFont()->setBold(1);
        $event->sheet->getStyle('J6:P6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

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
        $event->sheet->getStyle('P7:P'.$this->getCount())->applyFromArray($styles['impares']);
        // $event->sheet->getStyle('P7:P8')->applyFromArray($styles['impares']);
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
    return 'Edts';
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
    $drawing->setName('Logo');
    $drawing->setDescription('This is my logo');
    $drawing->setPath(public_path('/img/logonacional_Negro.png'));
    $drawing->setResizeProportional(false);
    $drawing->setHeight(104);
    $drawing->setWidth(120);
    $drawing->setCoordinates('A1');
    return $drawing;
  }

}
