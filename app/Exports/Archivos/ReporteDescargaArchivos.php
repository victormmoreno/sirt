<?php

namespace App\Exports\Archivos;

use Maatwebsite\Excel\Events\{AfterSheet};
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use App\Exports\FatherExport;
use Maatwebsite\Excel\Concerns\Exportable;
// use Illuminate\Contracts\Support\Responsable;
// use Maatwebsite\Excel\Excel;


class ReporteDescargaArchivos extends FatherExport
{
    use Exportable;
    private $query;


    public function __construct($query)
    {
        $this->query = $query;
        $this->setCount($this->query->count() + 1);
        $this->setRangeHeadingCell('A1:F1');
    }

    //     /**
    // * It's required to define the fileName within
    // * the export class when making use of Responsable.
    // */
    // private $fileName = 'invoices.xlsx';
    
    // /**
    // * Optional Writer Type
    // */
    // private $writerType = Excel::XLSX;

    public function registerEvents(): array
    {
        // $columnPar = $this->styleArrayColumnsPar();
        // $columnImPar = $this->styleArrayColumnsImPar();
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $this->setFilters($event);
            },
        ];
    }

    /**
     * @abstract
     */
    public function view(): View
    {
        return view('exports.archivos.reporte_descarga_archivos', [
            'reporte' => $this->query,
        ]);
    }

    // public function columnWidths(): array
    // {
    //     return [
    //         'C' => 25,
    //         'D' => 25
    //     ];
    // }

    /**
     * Asigna el nombre para la hoja de excel
     * @return string
     * @abstract
     * @author dum
     */
    public function title(): String
    {
        return "Informe de descarga";
    }
}