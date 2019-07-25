<?php

namespace App\Repositories\Repository\UserRepository;

use App\User;

class TalentoRepository
{
	/*===============================================================================
	=            metodo para mostrar todos usuarios talentos del sistema            =
	===============================================================================*/
	
	public function getAllTalentos()
	{
		return User::InfoUserDatatable()
            ->Join('talentos', 'talentos.user_id', '=', 'users.id')
            ->role(User::IsTalento())
            ->orderby('users.created_at', 'desc')
            ->get();

	}
	
	/*=====  End of metodo para mostrar todos usuarios talentos del sistema  ======*/
	
}