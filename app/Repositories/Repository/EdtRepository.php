<?php

namespace App\Repositories\Repository;

use Illuminate\Support\Facades\DB;
use App\Models\{Edt, Entidad};
use Carbon\Carbon;

class EdtRepository
{

  /**
   * Consulta las entidades de una edts
   * @param int id Id de la edt
   * @return Collection
   */
  public function entidadesDeUnaEdt($id)
  {
    return Edt::with(['entidades.empresa'])->find($id);
  }

  /**
   * Consulta las edts de un gestor
   * @param int id Id del gestor
   * @return Collection type
   */
  public function consultarEdtsDeUnGestor($id)
  {
    return Edt::select('codigo_edt',
    'tiposedt.nombre AS tipo_edt',
    'areasconocimiento.nombre AS area_conocimiento',
    'edts.id',
    'edts.nombre')
    ->selectRaw('CONCAT(users.nombres, " ", users.apellidos) AS gestor')
    ->selectRaw('IF(edts.estado = '.Edt::IsActive().', "Activa", "Inactiva") AS estado')
    ->join('tiposedt', 'tiposedt.id', '=', 'edts.tipoedt_id')
    ->join('areasconocimiento', 'areasconocimiento.id', '=', 'edts.areaconocimiento_id')
    ->join('gestores', 'gestores.id', '=', 'edts.gestor_id')
    ->join('users', 'users.id', '=', 'gestores.user_id')
    ->where('gestores.id', $id)
    ->get();
  }

  /**
   * Registrar una edt en la base de datos
   * @param Request request Datos del formulario de edt (create)
   * @return boolean
   */
  public function storeEdtRepository($request)
  {
    // $anho = Carbon::parse($request->txtfecha_inicio);
    // $anho = $anho->isoFormat('YYYY');
    DB::beginTransaction();
    try {

      $codigo_edt = "";
      $anho = Carbon::now()->isoFormat('YYYY');

      $idnodo = sprintf("%02d", auth()->user()->gestor->nodo_id);
      $linea = auth()->user()->gestor->lineatecnologica_id;
      $gestor = sprintf("%03d", auth()->user()->gestor->id);
      $idEdt = Edt::selectRaw('MAX(id+1) AS max')->get()->last();
      $idEdt->max == null ? $idEdt->max = 1 : $idEdt->max = $idEdt->max;
      $idEdt->max = sprintf("%04d", $idEdt->max);

      $codigo_edt = 'E'. $anho . '-' . $idnodo . $linea . $gestor . '-' . $idEdt->max;
      $edt = Edt::create([
        'fecha_inicio' => $request->txtfecha_inicio,
        'nombre' => $request->txtnombre,
        'codigo_edt' => $codigo_edt,
        'gestor_id' => auth()->user()->gestor->id,
        'areaconocimiento_id' => $request->txtareaconocimiento_id,
        'tipoedt_id' => $request->txttipo_edt,
        'observaciones' => $request->txtobservaciones,
        'empleados' => $request->txtempleados,
        'instructores' => $request->txtinstructores,
        'aprendices' => $request->txtaprendices,
        'publico' => $request->txtpublico,
        'estado' => Edt::IsActive()
      ]);

      $edt->entidades()->sync($request->get('entidades'), false);

      DB::commit();
      return true;
    } catch (\Exception $e) {
      DB::rollback();
      return false;
    }

  }

}
