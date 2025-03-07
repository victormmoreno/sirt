<?php

namespace App\Repositories\Repository;

use App\Models\{Actividad, Edt, TipoEdt, UsoInfraestructura, RutaModel};
use Illuminate\Support\Facades\{DB, Storage};
use Carbon\Carbon;

class EdtRepository
{

    public function consultarArchivosDeUnaEdt($id)
    {
        return Edt::find($id)->rutamodel;
    }

    /**
     * Método que retorna el directorio de los archivos que tiene una articulación en el servidor
     * @param int $id Id de la edt
     * @return mixed
     * @author dum
     */
    private function returnDirectoryEdtFiles($id)
    {
        // consulta los archivos de una edt (registro de la base de datos)
        $tempo = $this->consultarArchivosDeUnaEdt($id)->first();
        if ($tempo == null) {
        return false;
        } else {
        // Función para dividir la cadena en un array (Partiendolos con el delimitador /)
        $route = preg_split("~/~", $tempo->ruta, 8);
        // Extrae el último elemento del array
        array_pop($route);
        // Une el array en un string, dicho string se separa por /
        $route = implode("/", $route);
        // Reemplaza storage por public en la routa
        $route = str_replace('storage', 'public', $route);
        // Retorna el directorio de los archivos de la articulación
        return $route;
        }

    }


    public function eliminarEdt_Repository($id)
    {
        DB::beginTransaction();
        try {
        $edt = Edt::find($id);
        $padre = $edt->actividad;
        // dd($padre);
        // Se usa el método sync sin nada para eliminar los datos de las relaciones muchos a muchos
        $edt->entidades()->sync([]);
        // Directorio del proyecto
        $directory = $this->returnDirectoryEdtFiles($edt->id);
        if ($directory != false) {
            // Elimina los archivos del servidor
            Storage::deleteDirectory($directory);
            // Elimina los registros de la tabla de ruta_model relacionado con los edts
            Edt::find($id)->rutamodel()->delete();
        }
        // Elimina el registro de la tabla edts
        $edt->delete();
        // Elimina los registros de la tabla material_uso
        UsoInfraestructura::deleteUsoMateriales($padre);
        // Elimina los registros de la tabla uso_talentos
        UsoInfraestructura::deleteParticipantes($padre);
        // Elimina los registros de la tabla gestor_uso
        UsoInfraestructura::deleteAsesores($padre);
        // Elimina los registros de la tabla equipo_uso
        UsoInfraestructura::deleteUsoEquipos($padre);
        // Elimina los registros de la tabla usoinfraestructuras
        $padre->usoinfraestructuras()->delete();
        // Elimina la tabla de actividades
        // exit();
        $padre->delete();
        DB::commit();
        return true;
        } catch (\Exception $e) {
        DB::rollback();
        return false;
        }
    }

    /**
     * Consulta la edts que se inscribiron entre dos fechas
     * @param string $fecha_inicio Primera fecha para realizar el filtro
     * @param string $fecha_fin Segunda fecha para realizar el filtro
     * @return Builder
     * @author dum
     */
    public function consultarEdtsPorFecha_Detalle($fecha_inicio, $fecha_fin)
    {
        return Edt::select('codigo_actividad',
        'actividades.nombre',
        'tiposedt.nombre AS nombre_tipoedt',
        'areasconocimiento.nombre AS nombre_areaconocimiento',
        'fecha_inicio',
        'fecha_cierre',
        'edts.observaciones',
        'empleados',
        'instructores',
        'aprendices',
        'publico',
        'fotografias',
        'listado_asistencia',
        'informe_final')
        ->selectRaw('CONCAT(users.nombres, " ", users.apellidos) AS gestor')
        ->join('actividades', 'actividades.id', '=', 'edts.actividad_id')
        ->join('users', 'users.id', '=', 'edts.user_id')
        ->join('nodos', 'nodos.id', '=', 'edts.nodo_id')
        ->join('tiposedt', 'tiposedt.id', '=', 'edts.tipoedt_id')
        ->join('areasconocimiento', 'areasconocimiento.id', '=', 'edts.areaconocimiento_id')
        ->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin]);
    }

    /**
     * Consulta la cantidad de edts entre un rango de fechas (fecha_inicio)
    * @param string $fecha_inicio Primera fecha para realizar el filtro
    * @param string $fecha_fin Segunda fecha para realizar el filtro
    * @return Collection
    * @author dum
    */
    public function consultaEdtsPorFechas_Respository($fecha_inicio, $fecha_fin)
    {
        return Edt::selectRaw('COUNT(edts.id) AS cantidad')
        ->join('actividades', 'actividades.id', '=', 'edts.actividad_id')
        ->join('nodos', 'nodos.id', '=', 'edts.nodo_id')
        ->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin]);
    }

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
        ->selectRaw('GROUP_CONCAT(nit, " - ", entidades.nombre SEPARATOR "; ") AS empresas')
        ->selectRaw('IF(edts.estado = '. Edt::IsActive() .', "Activa", "Inactiva") AS estado')
        ->join('tiposedt', 'tiposedt.id', '=', 'edts.tipoedt_id')
        ->join('areasconocimiento', 'areasconocimiento.id', '=', 'edts.areaconocimiento_id')
        ->join('actividades', 'actividades.id', '=', 'edts.actividad_id')
        ->join('users', 'users.id', '=', 'edts.asesor_id')
        ->join('nodos', 'nodos.id', '=', 'edts.nodo_id')
        ->join('edt_entidad', 'edt_entidad.edt_id', '=', 'edts.id')
        ->join('entidades', 'edt_entidad.entidad_id', '=', 'entidades.id')
        ->join('empresas', 'empresas.entidad_id', '=', 'entidades.id')
        ->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin])
        ->groupBy('edts.id');
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
        ->join('nodos', 'nodos.id', '=', 'edts.nodo_id')
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
        ->join('users', 'users.id', '=', 'edts.asesor_id')
        ->join('nodos', 'nodos.id', '=', 'edts.nodo_id')
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

        isset($request->txtfotografias) ? $fotografias = 1 : $fotografias = 0;
        isset($request->txtlistado_asistencia) ? $listado_asistencia = 1 : $listado_asistencia = 0;
        isset($request->txtinforme_final) ? $informe_final = 1 : $informe_final = 0;

        $edt = Edt::find($id);

        $update = $edt->update([
        'fotografias' => $fotografias,
        'listado_asistencia' => $listado_asistencia,
        'informe_final' => $informe_final,
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
        ->selectRaw('GROUP_CONCAT(nit, " - ", entidades.nombre SEPARATOR "; ") AS empresas')
        ->selectRaw('IF(edts.listado_asistencia = 0, "No", "Si") AS listado_asistencia')
        ->selectRaw('IF(edts.informe_final = 0, "No", "Si") AS informe_final')
        ->selectRaw('concat(users.nombres, " ", users.apellidos) AS gestor')
        ->join('tiposedt', 'tiposedt.id', '=', 'edts.tipoedt_id')
        ->join('areasconocimiento', 'areasconocimiento.id', '=', 'edts.areaconocimiento_id')
        ->join('actividades', 'actividades.id', '=', 'edts.actividad_id')
        ->join('users', 'users.id', '=', 'edts.asesor_id')
        ->join('gestores', 'gestores.user_id', '=', 'users.id')
        ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'gestores.lineatecnologica_id')

        ->join('edt_entidad', 'edt_entidad.edt_id', '=', 'edts.id')
        ->join('entidades', 'edt_entidad.entidad_id', '=', 'entidades.id')
        ->where('edts.id', $id)
        ->first();
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
    public function consultarEdtsDeUnNodo($id, $anho)
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
        ->selectRaw('IF(edts.estado = ' . Edt::IsActive() . ', "Abierta", "Cerrada") AS estado')
        ->join('tiposedt', 'tiposedt.id', '=', 'edts.tipoedt_id')
        ->join('areasconocimiento', 'areasconocimiento.id', '=', 'edts.areaconocimiento_id')
        ->join('actividades', 'actividades.id', '=', 'edts.actividad_id')
        ->join('gestores', 'gestores.id', '=', 'edts.asesor_id')
        ->join('users', 'users.id', '=', 'gestores.user_id')
        ->join('nodos', 'nodos.id', '=', 'edts.nodo_id')
        ->where('nodos.id', $id)
        ->whereYear('fecha_inicio', $anho)
        ->get();
    }

  /**
  * Consulta las edts de un gestor
  * @param int id Id del gestor
  * @param string $anho Año para filtrar por la fecha de inicio
  * @return Collection
  * @author dum
  */
  public function consultarEdtsDeUnGestor($id, $anho)
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
    ->selectRaw('IF(edts.estado = ' . Edt::IsActive() . ', "Abierta", "Cerrada") AS estado')
    ->join('tiposedt', 'tiposedt.id', '=', 'edts.tipoedt_id')
    ->join('areasconocimiento', 'areasconocimiento.id', '=', 'edts.areaconocimiento_id')
    ->join('actividades', 'actividades.id', '=', 'edts.actividad_id')
    ->join('users', 'users.id', '=', 'edts.asesor_id')
    ->join('edt_entidad', 'edt_entidad.edt_id', '=', 'edts.id')
    ->join('entidades', 'edt_entidad.entidad_id', '=', 'entidades.id')
    ->where('gestores.id', $id)
    ->whereYear('fecha_inicio', $anho)
    ->groupBy('edts.id')
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

        $idnodo                           = sprintf("%02d", auth()->user()->experto->nodo_id);
        $linea                            = auth()->user()->experto->lineatecnologica_id;
        $gestor                           = sprintf("%03d", auth()->user()->experto->id);
        $idEdt                            = Edt::selectRaw('MAX(id+1) AS max')->get()->last();
        $idEdt->max == null ? $idEdt->max = 1 : $idEdt->max = $idEdt->max;
        $idEdt->max                       = sprintf("%04d", $idEdt->max);

        $codigo_edt = 'E' . $anho . '-' . $idnodo . $linea . $gestor . '-' . $idEdt->max;

        $actividad = Actividad::create([
        'gestor_id'        => auth()->user()->experto->id,
        'nodo_id'          => auth()->user()->experto->nodo_id,
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
