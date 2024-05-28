<?php

namespace App\Exports\Encuestas;

use Illuminate\Contracts\View\View;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use App\Exports\FatherExport;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Events\{AfterSheet};
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ResultadosEncuestaExport extends FatherExport implements WithColumnWidths, ShouldAutoSize
{

    public function __construct($query = null)
    {
        $this->setQuery($query);
        $this->setCount($this->getQuery()->count() + 1);
        $this->setRangeHeadingCell('A1:AW1');
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
        return view('exports.encuestas.resultados_proyecto', [
            'resultados' => $this->getQuery()
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
                // $this->combinarCeldas($event);
                // $this->settingValues($event);
                $this->setFilters($event);
                // $chart = $this->charts();
                // $event->sheet->getDelegate()->addChart($chart);
            },
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 35,
            'B' => 35,
            'C' => 35,
            'M' => 55,
            'P' => 55,
            'Q' => 85,
            'R' => 60,
            'S' => 70,
            'T' => 80,
            'U' => 50,
            'V' => 45,
            'W' => 85,
            'X' => 60,
            'Y' => 80,
            'Z' => 65,
            'AA' => 60,
            'AB' => 92,
            'AC' => 90,
            'AD' => 86,
            'AE' => 75,
            'AF' => 71,
            'AG' => 65,
            'AD' => 70,
            'AH' => 50,
            'AI' => 65,
            'AJ' => 75,
            'AK' => 68,
            'AL' => 75,
            'AM' => 95,
            'AN' => 68,
            'AO' => 47,
            'AP' => 81,
            'AQ' => 80,
            'AR' => 75,
            'AS' => 80,
            'AT' => 72,
            'AU' => 65,
            'AV' => 93,
            'AW' => 73,
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
        return 'Resultados';
    }
}
