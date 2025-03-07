<?php

namespace App\Repositories\Repository;

use App\Models\Entidad;

class CentroRepository
{
    public function getAllCentrosRegional($regional)
    {
        return Entidad::join('centros', 'entidades.id', 'centros.entidad_id')
            ->join('regionales', 'regionales.id', 'centros.regional_id')
            ->where('centros.regional_id', $regional)
            ->pluck('entidades.nombre', 'centros.id');
    }
}
