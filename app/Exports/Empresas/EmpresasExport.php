<?php

namespace App\Exports\Empresas;

use Maatwebsite\Excel\Events\{AfterSheet};
use Illuminate\Contracts\View\View;
use App\Exports\FatherExport;

class EmpresasExport extends FatherExport
{

    private $title;

    public function __construct($query, $title)
    {
        $this->setQuery($query);
        $this->setTitle($title);
        $this->setCount($this->getQuery()->count() + 1);
        $this->setRangeHeadingCell('A1:AI1');
    }

    public function registerEvents(): array
    {
        return [
        AfterSheet::class => function(AfterSheet $event) {
            $this->setFilters($event);
        },
        ];
    }

    /**
     * @abstract
    */
    public function view(): View
    {
        return view('exports.empresas.propietarias', [
        'proyectos' => $this->getQuery()
        ]);

    }

    /**
     * Asigna el nombre para la hoja de excel
    * @return string
    * @abstract
    * @author dum
    */
    public function title(): String
    {
        return 'Empresas - ' . $this->getTitle();
    }

    private function setTitle(string $title) {
        $this->title = $title;
    }

    private function getTitle() {
        return $this->title;
    }
}
