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
        $this->setRangeHeadingCell('A1:AU1');
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
            'O' => 85,
            'P' => 60,
            'Q' => 70,
            'R' => 80,
            'U' => 85,
            'W' => 80,
            'Z' => 90,
            'AA' => 90,
            'AB' => 85,
            'AC' => 75,
            'AD' => 70,
            'AH' => 80,
            'AI' => 65,
            'AJ' => 75,
            'AK' => 90,
            'AL' => 70,
            'AO' => 85,
            'AP' => 75,
            'AQ' => 80,
            'AR' => 72,
            'AS' => 65,
            'AT' => 93,
            'AU' => 73,
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
