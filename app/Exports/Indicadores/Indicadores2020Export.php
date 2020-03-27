<?php

namespace App\Exports\Indicadores;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Events\{AfterSheet};
use Illuminate\Contracts\View\View;
use App\Exports\FatherExport;
use App\Exports\Proyectos\{Proyectos};
use App\Exports\User\Talento\TalentoUserExport;

class Indicadores2020Export implements WithMultipleSheets
{
    private $queryProyectos;

    public function __construct($queryProyectos, $queryTalentos) {
        $this->setQueryProyectos($queryProyectos);
        $this->setQueryTalentos($queryTalentos);
    }
  /**
   * @return array
   */
  public function sheets(): array
  {
      $sheets = [];

      $sheets[] = new Proyectos($this->getQueryProyectos());
      $sheets[] = new TalentoUserExport($this->getQueryTalentos(), 'Proyectos');


      return $sheets;
  }

  private function setQueryProyectos($queryProyectos) {
    $this->queryProyectos = $queryProyectos;
  }

  private function getQueryProyectos() {
    return $this->queryProyectos;
  }

  private function setQueryTalentos($queryTalentos) {
    $this->queryTalentos = $queryTalentos;
  }

  private function getQueryTalentos() {
    return $this->queryTalentos;
  }
}