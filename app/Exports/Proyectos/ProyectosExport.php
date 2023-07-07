<?php

namespace App\Exports\Proyectos;

use Illuminate\Contracts\View\View;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use App\Exports\FatherExport;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Events\{AfterSheet};
// use Maatwebsite\Excel\Concerns\WithCharts;
// use PhpOffice\PhpSpreadsheet\Chart\Chart as Charts;
// use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
// use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
// use PhpOffice\PhpSpreadsheet\Chart\Legend;
// use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
// use PhpOffice\PhpSpreadsheet\Chart\Title;
// use PhpOffice\PhpSpreadsheet\Worksheet\Chart;

class ProyectosExport extends FatherExport implements WithColumnWidths
{

    public function __construct($query = null)
    {
        $this->setQuery($query);
        $this->setCount($this->getQuery()->count() + 1);
        $this->setRangeHeadingCell('A1:AB1');
    }

    // public function charts()
    // {
    //     $label      = [new DataSeriesValues('String', 'Worksheet!$A$2', null, 1)];
    //     $categories = [new DataSeriesValues('String', 'Worksheet!$A$2:$D$2', null, 4)];
    //     $values     = [new DataSeriesValues('Number', 'Worksheet!$B$2:$D$5', null, 4)];

    //     $series = new DataSeries(DataSeries::TYPE_PIECHART, DataSeries::GROUPING_STANDARD,
    //         range(0, \count($values) - 1), $label, $categories, $values);
    //     $plot   = new PlotArea(null, [$series]);

    //     $legend = new Legend();
    //     $chart  = new Charts('chart name', new Title('chart title'), $legend, $plot);
    //     $chart->setTopLeftPosition('F12');
    //     $chart->setBottomRightPosition('M20');

    //     return $chart;
    // }

    /**
     * @abstract
     */
    public function view(): View
    {
        return view('exports.proyectos.proyectos', [
            'proyectos' => $this->getQuery()
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
                // $chart = $this->charts();
                // $event->sheet->getDelegate()->addChart($chart);
            },
        ];
    }

    public function columnWidths(): array
    {
        return [
            'E' => 45,
            'G' => 45,
            'Z' => 45,
            'AA' => 45,
            'AB' => 45
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
        return 'Proyectos';
    }
}
