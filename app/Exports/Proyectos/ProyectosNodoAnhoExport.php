<?php

namespace App\Exports\Proyectos;

use Illuminate\Contracts\View\View;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use App\Exports\FatherExport;
use Maatwebsite\Excel\Events\{AfterSheet};
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ProyectosNodoAnhoExport extends FatherExport
{

    private $type;

    public function __construct($query, $type)
    {
        $this->setQuery($query);
        $this->setCount($this->getQuery()->count() + 1);
        $this->setRangeHeadingCell('A1:AG1');
        $this->type = $type;
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
            $event->sheet->getStyle($this->getRangeHeadingCell())->getFont()->setSize(14)->setBold(1);
            $init = 'A';
            for ($i=0; $i < 33 ; $i++) {
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
     * @abstract
    */
    public function view(): View
    {
        if ($this->type == 1) {
        return view('exports.proyectos.anho.nodo2', [
            'proyectos' => $this->getQuery()
        ]);
        } else {
        return view('exports.proyectos.anho.nodo', [
            'proyectos' => $this->getQuery()
        ]);
        }
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
