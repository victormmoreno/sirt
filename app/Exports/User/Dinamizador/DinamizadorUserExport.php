<?php

namespace App\Exports\User\Dinamizador;

use App\Exports\FatherExport;
use App\User;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithDrawings;

class DinamizadorUserExport extends FatherExport implements Responsable, WithDrawings
{

	use Exportable;
    
    private $fileName = 'dinamizadores.xlsx';

    public function __construct($query)
    {
        $this->setQuery($query);
        if ($this->getQuery() == null) {
            $this->setCount(0);
        } else {
            $this->setCount($this->getQuery()->count() + 7);
        }

        $this->setRangeHeadingCell('A7:U7');
        $this->setRangeBodyCell('A8:O' . $this->getCount());
    }
}
