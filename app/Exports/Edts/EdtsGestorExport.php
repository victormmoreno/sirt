<?php

namespace App\Exports\Edts;

use Illuminate\Contracts\View\View;
use App\Exports\FatherExport;
use Maatwebsite\Excel\Events\{AfterSheet};

class EdtsGestorExport extends FatherExport
{

    public function __construct($query)
    {
        $this->setQuery($query);
        $this->setCount($this->getQuery()->count() + 1);
        $this->setRangeHeadingCell('A1:P1');
        $this->setRangeBodyCell('A1:P'.$this->getCount());
    }

    /**
     * @abstract
     */
    public function view(): View
    {
        // dd($this->getQuery());
        return view('exports.edt.gestor', [
        'edts' => $this->getQuery()
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
            $event->sheet->getStyle($this->getRangeHeadingCell())->applyFromArray($this->styleArray())->getFont()->setSize(14)->setBold(1);
            $event->sheet->getStyle($this->getRangeBodyCell())->applyFromArray($this->styleArray());
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
        return 'Edts';
    }
}
