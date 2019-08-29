<?php

namespace App\Exports\Proyectos;

use Illuminate\Contracts\View\View;
use App\Models\Articulacion;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use App\Exports\FatherExport;
use Maatwebsite\Excel\Events\{AfterSheet};
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ProyectosAnhoExport extends FatherExport
{

  public function __construct($query)
  {
    $this->setQuery($query);
    $this->setCount($this->getQuery()->count() + 7);
    $this->setRangeHeadingCell('A7:O7');
    $this->setRangeBodyCell('A8:O8');
  }


  /**
  * @abstract
  */
  public function view(): View
  {
    return view('exports.proyectos.anho.nodo', [
      'edt' => $this->getQuery()
    ]);
  }

}
