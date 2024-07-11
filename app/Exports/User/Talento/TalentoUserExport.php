<?php

namespace App\Exports\User\Talento;

use Maatwebsite\Excel\Events\{AfterSheet};
use Illuminate\Contracts\View\View;
use App\Exports\FatherExport;

class TalentoUserExport extends FatherExport
{

    private $title;
    public function __construct($query, $title)
    {
        $this->setTitle($title);
        $this->setQuery($query);
        $this->setCount($this->getQuery()->count() + 1);
        $this->setRangeHeadingCell('A1:AP1');
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
        return view('exports.users.talento.proyectos', [
            'users' => $this->getQuery()
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
        return 'Talentos - ' . $this->getTitle();
    }

    private function setTitle(string $title) {
        $this->title = $title;
    }

    private function getTitle() {
        return $this->title;
    }
}
