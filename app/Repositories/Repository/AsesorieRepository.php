<?php

namespace App\Repositories\Repository;


use App\Models\UsoInfraestructura;


class AsesorieRepository
{
    /**
     * method that returns the query with all the asesories
     * @param Request $request
     */

    public function getListAsesories()
    {
        return UsoInfraestructura::query()
            ->leftJoin('uso_talentos', 'uso_talentos.usoinfraestructura_id', '=', 'usoinfraestructuras.id')
            ->leftJoin('users as participants', 'participants.id', '=', 'uso_talentos.user_id')
            ->leftJoin('gestor_uso', 'gestor_uso.usoinfraestructura_id', '=', 'usoinfraestructuras.id')
            ->leftJoin('users as asesores', 'asesores.id', '=', 'gestor_uso.asesor_id');
    }

}
