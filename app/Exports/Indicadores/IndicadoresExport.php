<?php

namespace App\Exports\Indicadores;

use Maatwebsite\Excel\Concerns\{FromArray, WithCustomStartCell, ShouldAutoSize, WithEvents};
use PhpOffice\PhpSpreadsheet\Style\{Border, Fill};
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Events\{AfterSheet};
use Illuminate\Contracts\View\View;
// use App\Exports\FatherExport;

class IndicadoresExport implements FromArray, WithCustomStartCell, ShouldAutoSize, WithEvents
{

  protected $datos;
  private $count;
  private $rangeHeadingCell;
  private $rangeBodyCell;

  public function __construct(array $datos)
  {
    $this->datos = $datos;
    $this->count = 52;
    $this->rangeHeadingCell = 'A4:B4';
    $this->rangeBodyCell = 'A5:B52';
  }

  public function array(): array
  {
    return $this->datos;
  }

  private function styleArrayColumnsPar(){
    return [
      'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'color' => ['rgb' => 'C6E0B4'],
      ],
    ];
  }

  protected function styleArrayColumnsImPar(){
    return [
      'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'color' => ['rgb' => 'B4C6E7'],
      ],
    ];
  }

  public function registerEvents(): array
  {
    $columnPar = $this->styleArrayColumnsPar();
    $columnImPar = $this->styleArrayColumnsImPar();
    // $styles = array('pares' => $columnPar, 'impares' => $columnImPar);
    return [
      AfterSheet::class => function(AfterSheet $event) {
        $this->setCellsValues($event);
        $this->styledCells($event);
      },
    ];
  }

  private function styleArray() {
    return [
      'borders' => [
        'allBorders' => [
          'borderStyle' => Border::BORDER_THIN,
          'color' => ['argb' => '000000'],
        ],
      ],
    ];
  }

  private function setCellsValues(AfterSheet $event)
  {
    $event->sheet->setCellValue('A4', 'Indicador');
    $event->sheet->setCellValue('B4', 'Total');
  }

  private function styledCells($event)
  {
    $event->sheet->getStyle($this->rangeHeadingCell)->applyFromArray($this->styleArray())->getFont()->setSize(14)->setBold(1);
    $event->sheet->getStyle($this->rangeBodyCell)->applyFromArray($this->styleArray());

    $event->sheet->getStyle('A4:A'.$this->count)->applyFromArray($this->styleArrayColumnsPar());
    $event->sheet->getStyle('B4:B'.$this->count)->applyFromArray($this->styleArrayColumnsImPar());
  }

  public function startCell(): string
  {
    return 'A5';
  }

}
