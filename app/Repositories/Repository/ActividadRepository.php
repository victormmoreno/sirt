<?php

namespace App\Repositories\Repository;

use Illuminate\Support\Facades\DB;
use App\Models\{Actividad};

class ActividadRepository
{

  /**
  * Obtiene una actividad
  *
  * @param int $id Id de la actividad
  * @return Collection
  * @author dum
  */
  public function getActividad_Repository($id)
  {
    return Actividad::find($id);
  }


}
