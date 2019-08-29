<?php

namespace App\Exports\Articulaciones;

use Illuminate\Contracts\View\View;
use App\Exports\FatherExport;
use Maatwebsite\Excel\Concerns\{FromView, ShouldAutoSize, WithTitle, WithEvents};
use Maatwebsite\Excel\Events\{AfterSheet, BeforeSheet};
use App\Repositories\Repository\ArticulacionRepository;


// use Maatwebsite\Excel\Concerns\FromCollection;

class ArticulacionesNodoExport extends FatherExport implements FromView, ShouldAutoSize, WithTitle, WithEvents
{

  private $rticulacionRepository;
  private $id;

  public function __construct(ArticulacionRepository $articulacionRepository, $id)
  {
    $this->articulacionRepository = $articulacionRepository;
    $this->id = $id;
    $this->query = $this->articulacionRepository->consultarArticulacionesDeUnNodo( $this->id );
    $this->setCount($this->getQuery()->count() + 1);
    $this->setRangeHeadingCell('A1:P1');
    $this->setRangeBodyCell('A1:P'.$this->getCount());
  }

  public function view(): View
  {
    $query = $this->query;
    return view('exports.articulacion.nodo', [
      'articulacion' => $query
    ]);
  }

  /**
  * Método para aplicar estilos al archivo excel después de que se genera la hoja de excel
  * @return array
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

        $event->sheet->getStyle('A1:A'.$this->getCount())->applyFromArray($styles['pares']);
        $event->sheet->getStyle('B1:B'.$this->getCount())->applyFromArray($styles['impares']);
        $event->sheet->getStyle('C1:C'.$this->getCount())->applyFromArray($styles['pares']);
        $event->sheet->getStyle('D1:D'.$this->getCount())->applyFromArray($styles['impares']);
        $event->sheet->getStyle('E1:E'.$this->getCount())->applyFromArray($styles['pares']);
        $event->sheet->getStyle('F1:F'.$this->getCount())->applyFromArray($styles['impares']);
        $event->sheet->getStyle('G1:G'.$this->getCount())->applyFromArray($styles['pares']);
        $event->sheet->getStyle('H1:H'.$this->getCount())->applyFromArray($styles['impares']);
        $event->sheet->getStyle('I1:I'.$this->getCount())->applyFromArray($styles['pares']);
        $event->sheet->getStyle('J1:J'.$this->getCount())->applyFromArray($styles['impares']);
        $event->sheet->getStyle('K1:K'.$this->getCount())->applyFromArray($styles['pares']);
        $event->sheet->getStyle('L1:L'.$this->getCount())->applyFromArray($styles['impares']);
        $event->sheet->getStyle('M1:M'.$this->getCount())->applyFromArray($styles['pares']);
        $event->sheet->getStyle('N1:N'.$this->getCount())->applyFromArray($styles['impares']);
        $event->sheet->getStyle('O1:O'.$this->getCount())->applyFromArray($styles['pares']);
        $event->sheet->getStyle('P1:P'.$this->getCount())->applyFromArray($styles['impares']);
      },
      // BeforeSheet::class => function(BeforeSheet $event) use ($styles) {
      //   // $event->sheet->getStyle('A2:A'.$this->getCount(). ';C2:C'. $this->getCount())->applyFromArray($styles['pares']);
      // },
    ];
  }

  /**
  * Asigna el nombre para la hoja de excel
  * @return string
  * @author dum
  */
  public function title(): String
  {
    return 'Articulaciones';
  }

}
