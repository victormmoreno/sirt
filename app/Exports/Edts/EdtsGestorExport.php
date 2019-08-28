<?php

namespace App\Exports\Edts;

use Illuminate\Contracts\View\View;
use App\Models\Articulacion;
use App\Exports\FatherExport;
use Maatwebsite\Excel\Concerns\{FromView, ShouldAutoSize, WithTitle, WithEvents, WithDrawings};
use Maatwebsite\Excel\Events\{AfterSheet};
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use App\Repositories\Repository\{EdtRepository};

class EdtsGestorExport extends FatherExport implements FromView, ShouldAutoSize, WithTitle, WithEvents, WithDrawings
{

  private object $query;
  public function __construct($query)
  {
    $this->articulacionRepository = $articulacionRepository;
    $this->id = $id;
    $this->setCount($this->getQuery()->count() + 1);
    $this->setRangeHeadingCell('A1:P1');
    $this->setRangeBodyCell('A1:P'.$this->getCount());
  }
}
