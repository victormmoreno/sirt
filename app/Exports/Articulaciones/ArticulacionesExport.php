<?php

namespace App\Exports\Articulaciones;

// use App\Models\{Articulacion, ArticulacionProyecto};
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\{FromView, ShouldAutoSize, WithTitle, WithDrawings, WithEvents};
use Maatwebsite\Excel\Events\{AfterSheet, BeforeSheet};
use App\Exports\FatherExport;
use Illuminate\Contracts\View\View;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use App\Repositories\Repository\ArticulacionRepository;

class ArticulacionesExport extends FatherExport implements FromView, ShouldAutoSize, WithTitle, WithEvents, WithDrawings
{

  private $rticulacionRepository;
  private $id;

  public function __construct(ArticulacionRepository $articulacionRepository, $id)
  {
    $this->articulacionRepository = $articulacionRepository;
    $this->id = $id;
    $this->query = $this->articulacionRepository->consultarArticulacionesDeUnGestor($this->id);
    $this->setCount($this->getQuery()->count() + 1);
    $this->setRangeHeadingCell('A1:P1');
    $this->setRangeBodyCell('A1:P'.$this->getCount());
  }

  public function view(): View
  {
    $query = $this->query;
    return view('exports.articulacion.gestor', [
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
    // $coordsPar = [
    //   'A2:A'.$this->getCount(),
    //   'C2:C'.$this->getCount(),
    //   'E2:E'.$this->getCount(),
    //   'G2:G'.$this->getCount(),
    //   'I2:I'.$this->getCount(),
    //   'K2:K'.$this->getCount(),
    //   'M2:M'.$this->getCount(),
    //   'O2:O'.$this->getCount()
    // ];
    // $coordsPar = implode(',', $coordsPar);
    // dd($coordsPar);
    return [
      AfterSheet::class => function(AfterSheet $event) use ($styles, $coordsPar) {
        $event->sheet->getStyle($this->getRangeHeadingCell())->applyFromArray($this->styleArray())->getFont()->setSize(14)->setBold(1);
        $event->sheet->getStyle($this->getRangeBodyCell())->applyFromArray($this->styleArray());

        $event->sheet->getStyle('A2:A'.$this->getCount())->applyFromArray($styles['pares']);
        $event->sheet->getStyle('B2:B'.$this->getCount())->applyFromArray($styles['impares']);
        $event->sheet->getStyle('C2:C'.$this->getCount())->applyFromArray($styles['pares']);
        $event->sheet->getStyle('D2:D'.$this->getCount())->applyFromArray($styles['impares']);
        $event->sheet->getStyle('E2:E'.$this->getCount())->applyFromArray($styles['pares']);
        $event->sheet->getStyle('F2:F'.$this->getCount())->applyFromArray($styles['impares']);
        $event->sheet->getStyle('G2:G'.$this->getCount())->applyFromArray($styles['pares']);
        $event->sheet->getStyle('H2:H'.$this->getCount())->applyFromArray($styles['impares']);
        $event->sheet->getStyle('I2:I'.$this->getCount())->applyFromArray($styles['pares']);
        $event->sheet->getStyle('J2:J'.$this->getCount())->applyFromArray($styles['impares']);
        $event->sheet->getStyle('K2:K'.$this->getCount())->applyFromArray($styles['pares']);
        $event->sheet->getStyle('L2:L'.$this->getCount())->applyFromArray($styles['impares']);
        $event->sheet->getStyle('M2:M'.$this->getCount())->applyFromArray($styles['pares']);
        $event->sheet->getStyle('N2:N'.$this->getCount())->applyFromArray($styles['impares']);
        $event->sheet->getStyle('O2:O'.$this->getCount())->applyFromArray($styles['pares']);
        $event->sheet->getStyle('P2:P'.$this->getCount())->applyFromArray($styles['impares']);
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

  /**
  * Método para pinta imágenes en el archivo de Excel
  * @return object
  * @author dum
  */
  public function drawings()
  {
    $drawing = new Drawing();
    $drawing->setName('Logo');
    $drawing->setDescription('This is my logo');
    $drawing->setPath(public_path('/img/logonacional_Negro.png'));
    $drawing->setHeight(90);
    $drawing->setCoordinates('S10');
    return $drawing;
  }

}
