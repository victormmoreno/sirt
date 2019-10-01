<?php

namespace App\Repositories\Repository;

use App\Models\Equipo;

class EquipoRepository
{
	public function getEquipoPorCodigo($codigo_equipo)
	{
		return Equipo::findCodigoEquipo($codigo_equipo);
        
	}
}