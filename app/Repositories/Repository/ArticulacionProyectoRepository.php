<?php

namespace App\Repositories\Repository;

use Illuminate\Support\Facades\DB;
use App\Models\{ArticulacionProyecto};
use Carbon\Carbon;

class ArticulacionProyectoRepository
{

  /**
  * @param int $id Id de la actividad
  * @return Collection
  * @author dum
  */
  public function consultarTalentosDeUnaArticulacionProyectoRepository($id)
  {
    return ArticulacionProyecto::select('actividades.codigo_actividad',
    'articulacion_proyecto_talento.talento_lider',
    'users.documento',
    'articulacion_proyecto_talento.talento_id')
    ->selectRaw('concat(users.documento, " - ", users.nombres, " ", users.apellidos) AS talento')
    ->selectRaw('concat(users.nombres, " ", users.apellidos) AS nombre_talento')
    ->selectRaw('IF(articulacion_proyecto_talento.talento_lider = 1, "Talento Líder", "Autor") AS rol')
    ->join('articulacion_proyecto_talento', 'articulacion_proyecto_talento.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
    ->join('talentos', 'talentos.id', '=', 'articulacion_proyecto_talento.talento_id')
    ->join('users', 'users.id', '=', 'talentos.user_id')
    ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
    ->where('articulacion_proyecto.id', $id)
    ->get();
  }

}
