<?php

namespace App\Exports\Proyectos;

use Illuminate\Contracts\View\View;
use App\Exports\FatherExport;
use Maatwebsite\Excel\Events\{AfterSheet};
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ProyectosGestorAnhoExport extends FatherExport
{
    public function __construct($query)
    {
        $this->setQuery($query);
        $this->setCount($this->getQuery()->count() + 1);
        $this->setRangeHeadingCell('A1:AF1');
    }

    /**
     * @abstract
    */
    public function view(): View
    {
        return view('exports.proyectos.anho.gestor', [
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
        $columnPar = $this->styleArrayColumnsPar();
        $columnImPar = $this->styleArrayColumnsImPar();
        $styles = array('pares' => $columnPar, 'impares' => $columnImPar);
        return [
        AfterSheet::class => function(AfterSheet $event) use ($styles) {

            $init = 'A';
            for ($i=0; $i < 32 ; $i++) {
            $temp = $init++;
            $coordenadas = $temp . '1:'. $temp . $this->getCount();
            $event->sheet->getStyle($coordenadas)->applyFromArray($this->styleArray());
            if ( $i % 2 == 0 ) {
                $event->sheet->getStyle($coordenadas)->applyFromArray($styles['pares']);
            } else {
                $event->sheet->getStyle($coordenadas)->applyFromArray($styles['impares']);
            }
            }
        },
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
