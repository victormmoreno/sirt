<?php

namespace App\Exports\Articulaciones;

use Illuminate\Contracts\View\View;
use App\Exports\FatherExport;
use Maatwebsite\Excel\Concerns\{FromView, ShouldAutoSize, WithTitle, WithEvents};
use Maatwebsite\Excel\Events\{AfterSheet, BeforeSheet};
use App\Repositories\Repository\ArticulacionRepository;

class ArticulacionesTecnoparqueExport extends FatherExport implements FromView, ShouldAutoSize, WithTitle, WithEvents
{


  public function __construct(ArticulacionRepository $articulacionRepository, $id, $query)
  {
    $this->articulacionProyectoRepository = $articulacionProyectoRepository;
    $this->grupoInvestigacionRepository = $grupoInvestigacionRepository;
    $this->articulacionRepository = $articulacionRepository;
    $this->empresaRepository = $empresaRepository;
    $this->id = $id;
    $this->query = $query;
    $this->setCount($this->getQuery()->count());
    $this->setRangeHeadingCell('A7:P7');
    $this->setRangeBodyCell('A7:P8');
    $this->setObject(Articulacion::find($id));
  }

  public function view(): View
  {
    $query = $this->query;
    return view('exports.articulacion.tecnoparque', [
      'articulacion' => $query
    ]);
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
    $drawing->setResizeProportional(false);
    $drawing->setHeight(104);
    $drawing->setWidth(120);
    $drawing->setCoordinates('A1');
    return $drawing;
  }

}
