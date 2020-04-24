<?php

namespace App\Exports\User\Talento;

use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Events\{AfterSheet};
use Illuminate\Contracts\View\View;
use App\Exports\FatherExport;

class TalentoUserExport extends FatherExport
{

  private $title;
  public function __construct($query, $title)
  {
    $this->setTitle($title);
    $this->setQuery($query);
    $this->setCount($this->getQuery()->count() + 7);
    $this->setRangeHeadingCell('A7:W7');
  }

  public function registerEvents(): array
  {
    return [
      AfterSheet::class => function(AfterSheet $event) {
        $this->mergedCells($event);
        $this->styledCells($event);
        $this->setFilters($event);
        $this->setValues($event);
      },
    ];
  }

  private function setValues(AfterSheet $event) {
    $event->sheet->setCellValue('S6', 'Último estudio');

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

    $event->sheet->getStyle('S6:V6')->applyFromArray($this->styleArray());
    $event->sheet->getStyle('S6')->applyFromArray($this->styleArrayColumnsPar())->getFont()->setBold(1);
    $event->sheet->getStyle('S6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    // Estilos para los registros de la consulta
    $init = 'A';
    for ($i=0; $i < 23 ; $i++) {
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
    // Celdas combinadas arriba de los talentos
    $event->sheet->mergeCells('A1:R6');
    $event->sheet->mergeCells('S6:V6');
    $event->sheet->mergeCells('S1:V5');
    $event->sheet->mergeCells('W1:W6');
  }

  /**
  * @abstract
  */
  public function view(): View
  {
    return view('exports.users.talento.index', [
      'talentos' => $this->getQuery()
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
    return 'Talentos - ' . $this->getTitle();
  }

  private function setTitle(string $title) {
    $this->title = $title;
  }

  private function getTitle() {
    return $this->title;
  }

}
