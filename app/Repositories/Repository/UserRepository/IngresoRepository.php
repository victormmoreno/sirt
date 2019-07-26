<?php

namespace App\Repositories\Repository\UserRepository;

use App\User;

class IngresoRepository
{

    /*===============================================================================
    =            meotodo para consultar los usuarios ingreso por nodo            =
    ===============================================================================*/

    public function getAllUsersIngresoForNodo($nodo)
    {

        return User::InfoUserDatatable()
            ->Join('ingresos', 'ingresos.user_id', '=', 'users.id')
            ->Join('nodos', 'nodos.id', '=', 'ingresos.nodo_id')
            ->role(User::IsIngreso())
            ->where('nodos.id', '=', $nodo)
            ->orderby('users.created_at', 'desc')
            ->get();

    }

    /*=====  End of meotodo para consultar los usuarios ingreso por nodo  ======*/

}
