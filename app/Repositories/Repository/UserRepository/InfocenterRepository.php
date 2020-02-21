<?php

namespace App\Repositories\Repository\UserRepository;

use App\User;

class InfocenterRepository
{

    /*===============================================================================
    =            meotodo para consultar los usuarios infocenter por nodo            =
    ===============================================================================*/

    public function getAllInfocentersForNodo($nodo)
    {

        return User::InfoUserDatatable()
            ->Join('infocenter', 'infocenter.user_id', '=', 'users.id')
            ->Join('nodos', 'nodos.id', '=', 'infocenter.nodo_id')
            ->role(User::IsInfocenter())
            ->where('nodos.id', '=', $nodo);
        
    }

    /*=====  End of meotodo para consultar los usuarios infocenter por nodo  ======*/

}
