<?php

namespace App\Repositories\Repository;

use Illuminate\Support\Facades\DB;
use App\Models\{Edt, TipoEdt};
use Carbon\Carbon;

class EdtRepository
{

  /**
  * Consulta las cantidad de tipos de articulación por gestor
  * @param int $idgestor Id del gestor
  * @param int $tipo_edt Nombre del tipo de edt (Tipo 1, Tipo 2, Tipo 3)
  * @param string $fecha_inicio
  * @param string $fecha_fin
  * @return Collection
   */
  public function consultarCantidadDeEdtsPorTiposDeEdtGestorYAnho($idgestor, $tipo_edt, $fecha_inicio, $fecha_fin)
  {
    return Edt::select('tiposedt.nombre')
    ->selectRaw('concat(users.nombres, " ", users.apellidos) AS gestor')
    ->selectRaw('count(edts.id) AS cantidad')
    ->join('gestores', 'gestores.id', '=', 'edts.gestor_id')
    ->join('users', 'users.id', '=', 'gestores.user_id')
    ->join('nodos', 'nodos.id', '=', 'gestores.nodo_id')
    ->join('tiposedt', 'tiposedt.id', '=', 'edts.tipoedt_id')
    ->where('gestores.id', $idgestor)
    ->where('tiposedt.id', TipoEdt::select('id')->where('nombre', $tipo_edt)->get()->first()->id)
    ->whereBetween('fecha_fin', [$fecha_inicio, $fecha_fin])
    ->groupBy('gestores.id', 'tiposedt.nombre')
    ->get()
    ->last();
  }

  /**
  * consulta los archivos de una edt
  * @param int id Id de la EDT por el cual se consultaran sus archivos
  * @return Collection
  */
  public function consultarArchivosDeUnaEdt($id)
  {
    return Edt::select('ruta', 'edt_id', 'archivosedt.id')
    ->join('archivosedt', 'archivosedt.edt_id', '=', 'edts.id')
    ->where('edts.id', $id)
    ->get();
  }

  /**
   * Modifica los entregables de una edt
   * @param Request request
   * @param int id
   * @return boolean
   */
  public function updateEntregableRepository($request, $id)
  {
    DB::beginTransaction();
    try {
      $fotografias = "";
      $listado_asistencia = "";
      $informe_final = "";

      isset($request->txtfotografias) ? $fotografias = 1 : $fotografias = 0;
      isset($request->txtlistado_asistencia) ? $listado_asistencia = 1 : $listado_asistencia = 0;
      isset($request->txtinforme_final) ? $informe_final = 1 : $informe_final = 0;

      $edt = Edt::find($id);

      $update = $edt->update([
        'fotografias' => $fotografias,
        'listado_asistencia' => $listado_asistencia,
        'informe_final' => $informe_final
      ]);
      DB::commit();
      return true;
    } catch (\Exception $e) {
      DB::rollback();
      return false;
    }

  }

  /**
   * Consulta el detalle de una edt
   * @param int id Id de la edt
   * @return Collection
   */
  public function consultarDetalleDeUnaEdt($id)
  {
    return Edt::select('edts.codigo_edt',
    'edts.fecha_inicio',
    'edts.observaciones',
    'edts.empleados',
    'edts.instructores',
    'edts.aprendices',
    'edts.publico',
    'tiposedt.nombre AS tipoedt',
    'areasconocimiento.nombre AS areaconocimiento',
    'edts.id',
    'edts.tipoedt_id',
    'edts.areaconocimiento_id',
    'edts.nombre')
    ->selectRaw('IF(edts.estado = '.Edt::IsActive().', "Activo", "Inactivo") AS estado')
    ->selectRaw('IF(edts.fotografias = 0, "No", "Si") AS fotografias')
    ->selectRaw('IF(edts.listado_asistencia = 0, "No", "Si") AS listado_asistencia')
    ->selectRaw('IF(edts.informe_final = 0, "No", "Si") AS informe_final')
    ->selectRaw('concat(users.nombres, " ", users.apellidos) AS gestor')
    ->join('tiposedt', 'tiposedt.id', '=', 'edts.tipoedt_id')
    ->join('areasconocimiento', 'areasconocimiento.id', '=', 'edts.areaconocimiento_id')
    ->join('gestores', 'gestores.id', '=', 'edts.gestor_id')
    ->join('users', 'users.id', '=', 'gestores.user_id')
    ->where('edts.id', $id)
    ->get()
    ->last();
  }

  /**
   * Consulta las entidades de una edts
   * @param int id Id de la edt
   * @return Collection
   */
  public function entidadesDeUnaEdt($id)
  {
    // return Edt::with(['entidades.empresa'])->find($id);
    return Edt::select('entidades.nombre',
    'entidades.id',
    'empresas.nit')
    ->join('edt_entidad', 'edt_entidad.edt_id', '=', 'edts.id')
    ->join('entidades', 'entidades.id', '=', 'edt_entidad.entidad_id')
    ->join('empresas', 'empresas.entidad_id', '=', 'entidades.id')
    ->where('edts.id', $id)
    ->get();
  }

  /**
   * Consulta las edts por nodo
   * @param int id Id del nodo
   * @return Collection
   */
  public function consultarEdtsDeUnNodo($id)
  {
    return Edt::select('codigo_edt',
    'tiposedt.nombre AS tipo_edt',
    'areasconocimiento.nombre AS area_conocimiento',
    'edts.id',
    'edts.nombre')
    ->selectRaw('CONCAT(users.nombres, " ", users.apellidos) AS gestor')
    ->selectRaw('IF(edts.estado = '. Edt::IsActive() .', "Activa", "Inactiva") AS estado')
    ->join('tiposedt', 'tiposedt.id', '=', 'edts.tipoedt_id')
    ->join('areasconocimiento', 'areasconocimiento.id', '=', 'edts.areaconocimiento_id')
    ->join('gestores', 'gestores.id', '=', 'edts.gestor_id')
    ->join('users', 'users.id', '=', 'gestores.user_id')
    ->join('nodos', 'nodos.id', '=', 'gestores.nodo_id')
    ->where('nodos.id', $id)
    ->get();
  }

  /**
   * Consulta las edts de un gestor
   * @param int id Id del gestor
   * @return Collection
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

  /**
   * undocumented function summary
   * @param Request request Datos del formulario de edt (create)
   * @param int id Id del edt que se va a editar
   * @return boolean
   */
  public function updateEdtRepository($request, $id)
  {
    DB::beginTransaction();
    try {
      $edt = Edt::find($id);

      $fecha_fin = $edt->fecha_fin;
      $estado = 1;
      if ( isset($request->txtestado) ) {
        $estado = 0;
        $fecha_fin = $request->txtfecha_fin;
      }

      $update = $edt->update([
        'fecha_inicio' => $request->txtfecha_inicio,
        'fecha_fin' => $fecha_fin,
        'estado' => $estado,
        'nombre' => $request->txtnombre,
        'areaconocimiento_id' => $request->txtareaconocimiento_id,
        'tipoedt_id' => $request->txttipo_edt,
        'observaciones' => $request->txtobservaciones,
        'empleados' => $request->txtempleados,
        'instructores' => $request->txtinstructores,
        'aprendices' => $request->txtaprendices,
        'publico' => $request->txtpublico,
      ]);

      $edt->entidades()->sync($request->get('entidades'), true);
      DB::commit();
      return true;
    } catch (\Exception $e) {
      DB::rollback();
      return false;
    }


  }

}
