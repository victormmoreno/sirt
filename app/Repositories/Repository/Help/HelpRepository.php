<?php

namespace App\Repositories\Repository\Help;

use App\Models\Centro;
use App\Models\Ciudad;

class HelpRepository
{
    public function getAllCiudadDepartamento($departamento)
    {
        return Ciudad::allCiudadDepartamento($departamento)->get();
    }
    public function getAllCentrosRegional($regional)
    {
        return Centro::AllCentrosRegional($regional)->get();
    }
}


