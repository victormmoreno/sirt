<?php

namespace App\Repositories\Repository;

use App\Models\{Visitante, IngresoVisitante};
use Illuminate\Support\Facades\{DB};
use Carbon\Carbon;

class IngresoVisitanteRepository
{

  /**
  * Consulta los ingreso de un nodo por el año actual
  * @param int $id Id del nodo
  * @return Collection
  */
  public function consultarIngresosDeUnNodoRepository($id)
  {
    return IngresoVisitante::select('ingresos_visitantes.id',
    'servicios.nombre AS servicio',
    'visitantes.email',
    'hora_salida',
    'ingresos_visitantes.descripcion',
    'tiposvisitante.nombre AS tipovisitante',
    'fecha_ingreso')
    ->selectRaw('concat(visitantes.documento, " - ", visitantes.nombres, " ", visitantes.apellidos) AS visitante')
    ->join('visitantes', 'visitantes.id', '=', 'ingresos_visitantes.visitante_id')
    ->join('servicios', 'servicios.id', '=', 'ingresos_visitantes.servicio_id')
    ->join('tiposvisitante', 'tiposvisitante.id', '=', 'visitantes.tipovisitante_id')
    ->join('nodos', 'nodos.id', '=', 'ingresos_visitantes.nodo_id')
    ->where('nodos.id', $id)
    ->whereYear('fecha_ingreso', Carbon::now()->isoFormat('YYYY'))
    ->get();
  }

}
