<?php

namespace App\Exports\Indicadores;

// use App\Models\{Articulacion, ArticulacionProyecto};
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\{FromArray, WithCustomStartCell, ShouldAutoSize};
use Illuminate\Contracts\View\View;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class IndicadoresExport implements FromArray, WithCustomStartCell, ShouldAutoSize
{

  protected $datos;

  public function __construct(array $datos)
  {
    $this->datos = $datos;
  }

  public function array(): array
  {
    return $this->datos;
  }

  public function startCell(): string
  {
    return 'A5';
  }

}
