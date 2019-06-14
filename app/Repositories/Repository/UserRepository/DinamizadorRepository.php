<?php

namespace App\Repositories\Repository\UserRepository;

use App\Models\Nodo;
use App\Models\Rols;
use App\User;

class DinamizadorRepository
{
	/*=============================================================
	=            metodo para consultar todos los nodos            =
	=============================================================*/
	
	public function getAllNodos()
	{
		return Nodo::selectNodo()->get();
	}
	
	/*=====  End of metodo para consultar todos los nodos  ======*/

	/*===============================================================================
	=            metodo para constultar todos los dinamizadores por nodo            =
	===============================================================================*/
	
	/*=======================================================================
    =            metodo para consultar todos los administradores            =
    =======================================================================*/

    public function getAllDinamizadoresPorNodo($nodo)
    {
        return User::select('users.id', 'tiposdocumentos.nombre as tipodocumento', 'users.documento', 'rols.nombre as rol', 'users.email', 'users.direccion', 'users.celular', 'users.telefono', 'users.estado')
            ->selectRaw("CONCAT(users.nombres,' ',users.apellidos) as nombre")
            ->Join('tiposdocumentos', 'tiposdocumentos.id', '=', 'users.rol_id')
            ->Join('dinamizador', 'dinamizador.user_id', '=', 'users.id')
            ->Join('nodos', 'nodos.id', '=', 'dinamizador.nodo_id')
            ->Join('rols', 'rols.id', '=', 'users.rol_id')
            ->where('rols.nombre', '=', Rols::IsDinamizador())
            ->where('nodos.id', '=', $nodo)
            ->orderby('users.created_at', 'desc')
            ->get();

        // return User::select('users.id', 'tiposdocumentos.nombre as tipodocumento', 'users.documento', 'users.email', 'users.direccion', 'users.celular', 'users.telefono', 'users.estado')
        //     ->selectRaw("CONCAT(users.nombres,' ',users.apellidos) as nombre")
        //     ->Join('tiposdocumentos', 'tiposdocumentos.id', '=', 'users.rol_id')
        //     ->role('administrador')
        //     ->orderby('users.created_at','desc')
        //     ->get();
    }
	
	/*=====  End of metodo para constultar todos los dinamizadores por nodo  ======*/
	
	
}
