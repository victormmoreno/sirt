<?php

namespace App\Exports\Materiales;

use Illuminate\Contracts\View\View;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use App\Exports\FatherExport;
use Maatwebsite\Excel\Events\{AfterSheet};

class MaterialesExport extends FatherExport implements WithColumnWidths
{
    public function __construct($query) {
        $this->setQuery($query);
        $this->setRangeHeadingCell('A1:M1');
    }

    public function view(): View
    {
        return view('exports.materiales.index', [
            'materiales' => $this->getQuery()
        ]);
    }

    /**
     * Método para aplicar estilos al archivo excel después de que se genera la hoja de excel
     * @return array
     * @abstract
     * @author dum
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $this->setFilters($event);
            },
        ];
    }

    public function columnWidths(): array
    {
        return [
            'D' => 35,
            'L' => 25,
            'M' => 25
        ];
    }
    
    /**
     * Asigna el nombre para la hoja de excel
     * @return string
     * @abstract
     * @author dum
     */
    public function title(): String
    {
        return 'Materiales';
    }
    
}