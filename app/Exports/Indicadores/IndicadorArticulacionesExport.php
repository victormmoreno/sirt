<?php

namespace App\Exports\Indicadores;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Articulation\{ArticulacionExport, ArticulationParticipantExport};

class IndicadorArticulacionesExport implements WithMultipleSheets
{
    private $query;
    private $hoja;

    public function __construct($query, $hoja) {
        $this->setQuery($query);
        $this->hoja = $hoja;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        // dd($this->hoja);
        $sheets = [];
        if ($this->hoja == 'all') {
            $sheets[] = new ArticulacionExport(
                $this->getQuery()
                ->groupBy('articulations.id')
                ->get()
            );
            $sheets[] = new ArticulationParticipantExport(
                $this->getQuery()
                ->groupBy('participant.documento')
                ->get(), 'Talentos'
            );
        } else {
            if ($this->hoja == 'articulaciones') {
                $sheets[] = new ArticulacionExport(
                    $this->getQuery()
                    ->groupBy('articulations.id')
                    ->get()
                );
            }
            if ($this->hoja == 'talentos') {
                $sheets[] = new ArticulationParticipantExport(
                    $this->getQuery()
                    ->groupBy('participant.id')
                    ->get(), 'Talentos'
                );
            }
        }
        return $sheets;
    }

    private function setQuery($query) {
        $this->query = $query;
    }

    private function getQuery() {
        return $this->query;
    }
}

