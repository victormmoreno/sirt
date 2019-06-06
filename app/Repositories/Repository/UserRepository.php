<?php

namespace App\Repositories\Repository;

use App\Models\Rols;
use App\User;
use Illuminate\Support\Facades\DB;

class UserRepository
{
	/*=======================================================================
	=            metodo para consultar todos los administradores            =
	=======================================================================*/
	
	public function getAllAdministradores()
    {
        return User::select('users.id','tiposdocumentos.nombre as tipodocumento', 'users.documento','rols.nombre as rol','users.email','users.direccion','users.celular','users.telefono','users.estado')
        ->selectRaw("CONCAT(users.nombres,' ',users.apellidos) as nombre")
            ->Join('tiposdocumentos', 'tiposdocumentos.id', '=', 'users.rol_id')
            ->Join('rols', 'rols.id', '=', 'users.tipodocumento_id')
            ->where('rols.nombre','=',Rols::IsAdministrador())
            ->get();
    }
	
	/*=====  End of metodo para consultar todos los administradores  ======*/

	/*==================================================================
	=            metodo para consultar el usuario por su id            =
	==================================================================*/
	
	public function findByid($id)
    {

        return User::select('users.id','tiposdocumentos.nombre as tipodocumento', 'users.documento','rols.nombre as rol','users.email','users.direccion','users.celular','users.telefono','users.estado')
        ->selectRaw("CONCAT(users.nombres,' ',users.apellidos) as nombre")
            ->Join('tiposdocumentos', 'tiposdocumentos.id', '=', 'users.rol_id')
            ->Join('rols', 'rols.id', '=', 'users.tipodocumento_id')
            ->findOrFail($id);

    }
	
	
	/*=====  End of metodo para consultar el usuario por su id  ======*/
	
	
} 