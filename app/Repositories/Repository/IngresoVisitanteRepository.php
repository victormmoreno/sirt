<?php

namespace App\Repositories\Repository;

use App\Models\{Visitante, IngresoVisitante};
use Illuminate\Support\Facades\{DB};
use Carbon\Carbon;

class IngresoVisitanteRepository
{

  public $visitanteRepository;

  public function __construct(VisitanteRepository $visitanteRepository)
  {
    $this->visitanteRepository = $visitanteRepository;
  }

  /**
  * Registra un nuevo ingreso de visitante
  * @param Request $request Datos del formulario
  * @return array
  */
  public function storeIngresoVisitanteRepository($request)
  {
    DB::beginTransaction();
    try {

      $visitante = Visitante::where('documento', $request->txtdocumento)->first();
      if ($visitante == null) {
        $storeVisitante = $this->visitanteRepository->storeVisitanteRepository($request);
        // dd($storeVisitante['visitante']->id);
        $ingreso = IngresoVisitante::create([
          'visitante_id' => $storeVisitante['visitante']->id,
          'nodo_id' => auth()->user()->ingreso->nodo_id,
          'servicio_id' => $request->txtservicio_id,
          'fecha_ingreso' => $request->txtfecha_ingreso . " " . $request->txthora_entrada,
          'hora_salida' => $request->txthora_salida,
          'descripcion' => $request->txtdescripcion
        ]);
      } else {
        $ingreso = IngresoVisitante::create([
          'visitante_id' => $visitante->id,
          'nodo_id' => auth()->user()->ingreso->nodo_id,
          'servicio_id' => $request->txtservicio_id,
          'fecha_ingreso' => $request->txtfecha_ingreso . " " . $request->txthora_entrada,
          'hora_salida' => $request->txthora_salida,
          'descripcion' => $request->txtdescripcion
        ]);

      }
      // return array('store' => true, 'ingreso' => $ingreso);
      DB::commit();
      return array('store' => true, 'ingreso' => $ingreso);
    } catch (\Exception $e) {
      DB::rollback();
      return array('store' => false, 'ingreso' => "");
    }

  }

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
