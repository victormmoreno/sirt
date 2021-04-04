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
    $this->setRangeHeadingCell('A1:P1');
    $this->setObject(Articulacion::find($id));
  }

  public function view(): View
  {
    $query = $this->query;
    return view('exports.articulacion.tecnoparque', [
      'articulacion' => $query
    ]);
  }

}
