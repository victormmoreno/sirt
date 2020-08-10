<?php

namespace App\Repositories\Repository\UserRepository;

use App\User;

class DinamizadorRepository
{
    /*===============================================================================
    =            metodo para constultar todos los dinamizadores por nodo            =
    ===============================================================================*/

    public function getAllDinamizadoresPorNodo($nodo)
    {
        return User::InfoUserDatatable()
            ->Join('dinamizador', 'dinamizador.user_id', '=', 'users.id')
            ->Join('nodos', 'nodos.id', '=', 'dinamizador.nodo_id')
            ->role(User::IsDinamizador())
            ->where('nodos.id', '=', $nodo);
    }

    /*=====  End of metodo para constultar todos los dinamizadores por nodo  ======*/
}
