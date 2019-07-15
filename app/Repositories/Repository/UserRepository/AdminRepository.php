<?php

namespace App\Repositories\Repository\UserRepository;

use App\Models\Eps;
use App\Models\Ocupacion;
use App\Models\Rols;
use App\User;

class AdminRepository
{

    /*=======================================================================
    =            metodo para consultar todos los administradores            =
    =======================================================================*/

    public function getAllAdministradores()
    {
        return User::select('users.id', 'tiposdocumentos.nombre as tipodocumento', 'users.documento', 'users.email', 'users.direccion', 'users.celular', 'users.telefono', 'users.estado')
            ->selectRaw("CONCAT(users.nombres,' ',users.apellidos) as nombre")
            ->Join('tiposdocumentos', 'tiposdocumentos.id', '=', 'users.tipodocumento_id')
            ->role(User::IsAdministrador())
            ->orderby('users.created_at', 'desc')
            ->get();
    }

    /*=====  End of metodo para consultar todos los administradores  ======*/


}
