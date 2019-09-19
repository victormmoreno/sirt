<?php

namespace App\Repositories\Repository;

use App\Models\Actividad;
use App\Models\Edt;
use App\Models\TipoEdt;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EdtRepository
{

  /**
   * Consultaas las edts que se cerraron entre dos fecha (de cierre) y un nodo
   * @param string $fecha_inicio Primera fecha para realizar el filtro
   * @param string $fecha_fin Segunda fecha para realizar el filtro
   * @return DB
   * @author dum
   */
  public function consultarEdtPorFechaDeCierre_Repository($fecha_inicio, $fecha_fin)
  {
    return Edt::select('codigo_actividad AS codigo_edt',
    'tiposedt.nombre AS tipo_edt',
    'areasconocimiento.nombre AS area_conocimiento',
    'edts.id',
    'fecha_inicio',
    'fecha_cierre',
    'edts.observaciones',
    'empleados',
    'instructores',
    'aprendices',
    'publico',
    'actividades.nombre')
    ->selectRaw('CONCAT(users.nombres, " ", users.apellidos) AS gestor')
    ->selectRaw('IF(edts.estado = '. Edt::IsActive() .', "Activa", "Inactiva") AS estado')
    ->join('tiposedt', 'tiposedt.id', '=', 'edts.tipoedt_id')
    ->join('areasconocimiento', 'areasconocimiento.id', '=', 'edts.areaconocimiento_id')
    ->join('actividades', 'actividades.id', '=', 'edts.actividad_id')
    ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
    ->join('users', 'users.id', '=', 'gestores.user_id')
    ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
    ->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin]);
  }

  /**
   * Consulta las edts por tipos de un nodo y por año (de la fecha de cierre)
   * @param int $idnodo Id del nodo
   * @param string $anho Año por el que se filtran las edts (Fecha de Cierre)
   * @param string $tipoEdt Tipo de la edt
   * @return Collection
   * @author dum
   */
  public function consultarCantidadDeEdtsPorTipoYNodoYAnho_Repository($idnodo, $anho, $tipoEdt)
  {
    return Edt::select('edts.tipoedt_id')
    ->selectRaw('count(edts.id) AS cantidad')
    ->join('actividades', 'actividades.id', '=', 'edts.actividad_id')
    ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
    ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
    ->join('tiposedt', 'tiposedt.id', '=', 'edts.tipoedt_id')
    ->where('nodos.id', $idnodo)
    ->where('tiposedt.id', TipoEdt::select('id')->where('nombre', $tipoEdt)->get()->first()->id)
    ->whereYear('fecha_cierre', $anho)
    ->groupBy('nodos.id', 'edts.tipoedt_id')
    ->get()
    ->last();
  }


  /**
  * Consulta las cantidad de tipos de articulación por gestor
  * @param int $idgestor Id del gestor
  * @param string $tipo_edt Nombre del tipo de edt (Tipo 1, Tipo 2, Tipo 3)
  * @param int $idnodo Id del nodo
  * @param string $fecha_inicio
  * @param string $fecha_fin
  * @return Collection
  * @author dum
  */
  public function consultarCantidadDeEdtsPorTiposDeEdtGestorYAnho($idgestor, $tipo_edt, $idnodo, $fecha_inicio, $fecha_fin)
  {
    return Edt::select('tiposedt.nombre')
    ->selectRaw('concat(users.nombres, " ", users.apellidos) AS gestor')
    ->selectRaw('count(edts.id) AS cantidad')
    ->join('actividades', 'actividades.id', '=', 'edts.actividad_id')
    ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
    ->join('users', 'users.id', '=', 'gestores.user_id')
    ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
    ->join('tiposedt', 'tiposedt.id', '=', 'edts.tipoedt_id')
    ->where('gestores.id', $idgestor)
    ->where('nodos.id', $idnodo)
    ->where('tiposedt.id', TipoEdt::select('id')->where('nombre', $tipo_edt)->get()->first()->id)
    ->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin])
    ->groupBy('gestores.id', 'tiposedt.nombre')
    ->get()
    ->last();
  }


  /**
   * Consulta la cantidad de edts que tiene una línea tecnológica
   * @param int $idnodo Id del nodo
   * @param int $idlinea Id de la línea tecnológica
   * @param string $tipoEdt Tipo de edt por el que se buscarán las articulaciones
   * @param string $fecha_inicio Primera fecha por la que se filtrará la consulta
   * @param string $fecha_fin Segunda fecha por la que se filtrará la consulta
   * @return Collection
   * @author dum
   * @since
   */
  public function consultarCantidadDeEdtsPorLineaTecnologicaYFecha_Repository($idnodo, $idlinea, $tipoEdt, $fecha_inicio, $fecha_fin)
  {
    return Edt::select('edts.tipoedt_id')
    ->selectRaw('count(edts.id) AS cantidad')
    ->join('actividades', 'actividades.id', '=', 'edts.actividad_id')
    ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
    ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'gestores.lineatecnologica_id')
    ->join('lineastecnologicas_nodos', 'lineastecnologicas_nodos.linea_tecnologica_id', '=', 'lineastecnologicas.id')
    ->join('nodos', 'nodos.id', '=', 'lineastecnologicas_nodos.nodo_id')
    ->join('tiposedt', 'tiposedt.id', '=', 'edts.tipoedt_id')
    ->where('nodos.id', $idnodo)
    ->where('lineastecnologicas.id', $idlinea)
    ->where('tiposedt.id', TipoEdt::select('id')->where('nombre', $tipoEdt)->get()->first()->id)
    ->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin])
    ->groupBy('lineastecnologicas.id', 'edts.tipoedt_id', 'nodos.id')
    ->get()
    ->last();
  }

  /**
   * Cambia el gestor de una edt
   * @param Request $request
   * @param int $id Id de la edt
   * @return boolean
   * @author dum
   */
  public function updateGestorEdt_Repository($request, $id)
  {
    DB::beginTransaction();
    try {
      $edt = Edt::find($id);
      $edt->actividad()->update([
        'gestor_id' => $request->txtgestor_id
      ]);
      DB::commit();
      return true;
    } catch (\Exception $e) {
      DB::rollback();
      return false;

    }
  }

    /**
     * Modifica los entregables de una edt
     * @param Request request
     * @param int id
     * @return boolean
     * @author dum
     */
    public function updateEntregableRepository($request, $id)
    {
        DB::beginTransaction();
        try {
            $fotografias        = "";
            $listado_asistencia = "";
            $informe_final      = "";

            isset($request->txtfotografias) ? $fotografias               = 1 : $fotografias               = 0;
            isset($request->txtlistado_asistencia) ? $listado_asistencia = 1 : $listado_asistencia = 0;
            isset($request->txtinforme_final) ? $informe_final           = 1 : $informe_final           = 0;

            $edt = Edt::find($id);

            $update = $edt->update([
                'fotografias'        => $fotografias,
                'listado_asistencia' => $listado_asistencia,
                'informe_final'      => $informe_final,
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
     * @author dum
     */
    public function consultarDetalleDeUnaEdt($id)
    {
        return Edt::select('codigo_actividad AS codigo_edt',
            'fecha_inicio',
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
            'actividades.fecha_cierre',
            'gestores.id AS gestor_id',
            'lineastecnologicas.id AS linea_id',
            'lineastecnologicas.nombre AS nombre_linea',
            'actividades.nombre')
            ->selectRaw('IF(edts.estado = ' . Edt::IsActive() . ', "Activa", "Inactiva") AS estado')
            ->selectRaw('IF(edts.fotografias = 0, "No", "Si") AS fotografias')
            ->selectRaw('IF(edts.listado_asistencia = 0, "No", "Si") AS listado_asistencia')
            ->selectRaw('IF(edts.informe_final = 0, "No", "Si") AS informe_final')
            ->selectRaw('concat(users.nombres, " ", users.apellidos) AS gestor')
            ->join('tiposedt', 'tiposedt.id', '=', 'edts.tipoedt_id')
            ->join('areasconocimiento', 'areasconocimiento.id', '=', 'edts.areaconocimiento_id')
            ->join('actividades', 'actividades.id', '=', 'edts.actividad_id')
            ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
            ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'gestores.lineatecnologica_id')
            ->join('users', 'users.id', '=', 'gestores.user_id')
            ->where('edts.id', $id)
            ->get()
            ->last();
    }

    /**
     * Consulta las entidades de una edts
     * @param int id Id de la edt
     * @return Collection
     * @author dum
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
     * @author dum
     */
    public function consultarEdtsDeUnNodo($id)
    {
        return Edt::select('codigo_actividad AS codigo_edt',
            'tiposedt.nombre AS tipo_edt',
            'areasconocimiento.nombre AS area_conocimiento',
            'edts.id',
            'fecha_inicio',
            'fecha_cierre',
            'edts.observaciones',
            'empleados',
            'instructores',
            'aprendices',
            'publico',
            'actividades.nombre')
            ->selectRaw('CONCAT(users.nombres, " ", users.apellidos) AS gestor')
            ->selectRaw('IF(edts.estado = ' . Edt::IsActive() . ', "Activa", "Inactiva") AS estado')
            ->join('tiposedt', 'tiposedt.id', '=', 'edts.tipoedt_id')
            ->join('areasconocimiento', 'areasconocimiento.id', '=', 'edts.areaconocimiento_id')
            ->join('actividades', 'actividades.id', '=', 'edts.actividad_id')
            ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
            ->join('users', 'users.id', '=', 'gestores.user_id')
            ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
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
        return Edt::select('codigo_actividad AS codigo_edt',
            'tiposedt.nombre AS tipo_edt',
            'areasconocimiento.nombre AS area_conocimiento',
            'edts.id',
            'fecha_inicio',
            'fecha_cierre',
            'edts.observaciones',
            'empleados',
            'instructores',
            'aprendices',
            'publico',
            'actividades.nombre')
            ->selectRaw('CONCAT(users.nombres, " ", users.apellidos) AS gestor')
            ->selectRaw('IF(edts.estado = ' . Edt::IsActive() . ', "Activa", "Inactiva") AS estado')
            ->join('tiposedt', 'tiposedt.id', '=', 'edts.tipoedt_id')
            ->join('areasconocimiento', 'areasconocimiento.id', '=', 'edts.areaconocimiento_id')
            ->join('actividades', 'actividades.id', '=', 'edts.actividad_id')
            ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
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
        DB::beginTransaction();
        try {

            $codigo_edt = "";
            $anho       = Carbon::now()->isoFormat('YYYY');

            $idnodo                           = sprintf("%02d", auth()->user()->gestor->nodo_id);
            $linea                            = auth()->user()->gestor->lineatecnologica_id;
            $gestor                           = sprintf("%03d", auth()->user()->gestor->id);
            $idEdt                            = Edt::selectRaw('MAX(id+1) AS max')->get()->last();
            $idEdt->max == null ? $idEdt->max = 1 : $idEdt->max = $idEdt->max;
            $idEdt->max                       = sprintf("%04d", $idEdt->max);

            $codigo_edt = 'E' . $anho . '-' . $idnodo . $linea . $gestor . '-' . $idEdt->max;

            $actividad = Actividad::create([
                'gestor_id'        => auth()->user()->gestor->id,
                'nodo_id'          => auth()->user()->gestor->nodo_id,
                'codigo_actividad' => $codigo_edt,
                'nombre'           => $request->txtnombre,
                'fecha_inicio'     => $request->txtfecha_inicio,
            ]);

            $edt = Edt::create([
                'actividad_id'        => $actividad->id,
                'areaconocimiento_id' => $request->txtareaconocimiento_id,
                'tipoedt_id'          => $request->txttipo_edt,
                'observaciones'       => $request->txtobservaciones,
                'empleados'           => $request->txtempleados,
                'instructores'        => $request->txtinstructores,
                'aprendices'          => $request->txtaprendices,
                'publico'             => $request->txtpublico,
                'estado'              => Edt::IsActive(),
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
     * @author dum
     */
    public function updateEdtRepository($request, $id)
    {
        DB::beginTransaction();
        try {
            $edt = Edt::find($id);

            $fecha_fin = $edt->fecha_fin;
            $estado    = 1;
            if (isset($request->txtestado)) {
                $estado    = 0;
                $fecha_fin = $request->txtfecha_fin;
            }

            $edt->actividad()->update([
                'nombre'       => $request->txtnombre,
                'fecha_inicio' => $request->txtfecha_inicio,
                'fecha_cierre' => $fecha_fin,
            ]);

            $edt->update([
                'areaconocimiento_id' => $request->txtareaconocimiento_id,
                'tipoedt_id'          => $request->txttipo_edt,
                'observaciones'       => $request->txtobservaciones,
                'empleados'           => $request->txtempleados,
                'instructores'        => $request->txtinstructores,
                'aprendices'          => $request->txtaprendices,
                'publico'             => $request->txtpublico,
                'estado'              => $estado,
            ]);

            $edt->entidades()->sync($request->get('entidades'), true);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    /**
     * retorna edt por usuario --- gestor // talento ---
     * @param array id Id del edt que se va a editar
     * @return collection
     * @author devjul
     */

    public function findEdtByUser(array $relations)
    {
        return Edt::infoEdt($relations);
    }

}
