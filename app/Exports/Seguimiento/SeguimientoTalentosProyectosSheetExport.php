<?php

namespace App\Exports\Seguimiento;

use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Events\{AfterSheet};
use Illuminate\Contracts\View\View;
use App\Exports\FatherExport;

class SeguimientoTalentosProyectosSheetExport extends FatherExport
{


  public function __construct($query)
  {
    $this->setQuery($query);
    $this->setCount($this->getQuery()->count() + 7);
    $this->setRangeHeadingCell('A7:F7');
  }

  public function registerEvents(): array
  {
    $columnPar = $this->styleArrayColumnsPar();
    $columnImPar = $this->styleArrayColumnsImPar();
    return [
      AfterSheet::class => function(AfterSheet $event) {
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
    for ($i=0; $i < 6 ; $i++) {
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
    $event->sheet->mergeCells('A1:F6');
  }

  /**
  * @abstract
  */
  public function view(): View
  {
    return view('exports.seguimiento.talentos_proyectos', [
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
    return 'Talentos';
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

}
