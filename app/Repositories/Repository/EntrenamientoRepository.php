<?php

namespace App\Repositories\Repository;

use App\Models\{Entrenamiento, EntrenamientoIdea,  RutaModel, Movimiento, EstadoIdea};
use Illuminate\Support\Facades\{DB, Storage, Session};
use Carbon\Carbon;

class EntrenamientoRepository
{

    /**
     * Consulta un entrenamiento por su id
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function getById(int $id)
    {
        return Entrenamiento::findOrFail($id);
    }
    /**
     * Permite eliminar los archivos almacenados en la base de datos (por el id de un entrenamiento)
     * @param int id Id del archivo del entrenamiento del cual se le van a borrar los archivos (ruta de la base de datos)
     * @return void
     */
    public function deleteArchivoEntrenamientoPorEntrenamiento($id)
    {
        $file = RutaModel::find($id);
        $file->delete();
        $filePath = str_replace('storage', 'public', $file->ruta);
        Storage::delete($filePath);
    }

    /**
     * Permite eliminar un entrenamiento de la base de datos
     * @param int id Id del entrenamiento que se va a eliminar de la base de datos
     * @return boolean
     */
    public function deleteEntrenamiento($id)
    {
        return Entrenamiento::where('id', $id)->delete();
    }

    /**
     * Elimina los datos de la tabla entre entrenamientos e ideas (entrenamiento_idea) por el id del entrenamiento
     * @param int id Id del entrenamiento pro el cual se va a eliminar los datos
     * @return boolean
     */
    public function deleteEntrenamientoIdea($id)
    {
        return EntrenamientoIdea::where('entrenamiento_id', $id)->delete();
    }

    /**
     * Modifica lo entregables de un entrenamiento
     * @param Request request Datos del formulario
     * @param int id Id del entrenamiento
     * @return boolean type
     */
    public function updateEvidencias($request, $id)
    {
        DB::beginTransaction();
        try {
            $correos = 1;
            $fotos = 1;
            $listado_asistencia = 1;
            if (!isset($request->txtcorreos))
                $correos = 0;

            if (!isset($request->txtfotos))
                $fotos = 0;

            if (!isset($request->txtlistado_asistencia))
                $listado_asistencia = 0;

            $entrenamiento = Entrenamiento::findOrFail($id);

            $entrenamiento->update([
                'correos' => $correos,
                'fotos' => $fotos,
                'listado_asistencia' => $listado_asistencia
            ]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    /**
     * consulta los archivos de un entrenamiento
     * @param int id Id del entrenamiento por el cual se consultaran sus archivos
     * @return Collection
     * @author dum
     */
    public function consultarArchivosDeUnEntrenamiento($id)
    {
        return Entrenamiento::find($id)->rutamodel;
    }

    // Consulta todos los entrenamientos por nodo
    public function consultarEntrenamientosPorNodo($id)
    {
        return Entrenamiento::select('fecha_sesion1', 'fecha_sesion2', 'entrenamientos.id', 'entrenamientos.codigo_entrenamiento')
            ->selectRaw('IF(correos = 0, "No", "Si") AS correos')
            ->selectRaw('IF(fotos = 0, "No", "Si") AS fotos')
            ->selectRaw('IF(listado_asistencia = 0, "No", "Si") AS listado_asistencia')
            ->join('entrenamiento_idea', 'entrenamientos.id', '=', 'entrenamiento_idea.entrenamiento_id')
            ->join('ideas', 'ideas.id', '=', 'entrenamiento_idea.idea_id')
            ->where('ideas.nodo_id', $id)
            ->groupBy('entrenamientos.id')
            ->get();
    }
    // Consulta el entrenamiento por id
    public function consultarEntrenamientoPorId($id)
    {
        return Entrenamiento::select('fecha_sesion1', 'fecha_sesion2', 'entrenamientos.id', 'entrenamientos.codigo_entrenamiento')
            ->selectRaw('IF(correos = 0, "No", "Si") AS correos')
            ->selectRaw('IF(fotos = 0, "No", "Si") AS fotos')
            ->selectRaw('IF(listado_asistencia = 0, "No", "Si") AS listado_asistencia')
            ->where('id', $id)
            ->get()
            ->last();
    }

    public function consultarIdeasDelEntrenamiento($id)
    {
        return Entrenamiento::select('nombre_proyecto', 'fecha_sesion1', 'fecha_sesion2', 'ideas.id', 'ideas.codigo_idea')
            ->selectRaw('IF(confirmacion = 0,"No", "Si") AS confirmacion')
            ->selectRaw('IF(convocado_csibt = 0,"No", "Si") AS convocado')
            ->selectRaw('IF(canvas = 0,"No", "Si") AS canvas')
            ->selectRaw('IF(asistencia1 = 0,"No", "Si") AS asistencia1')
            ->selectRaw('IF(asistencia2 = 0,"No", "Si") AS asistencia2')
            ->join('entrenamiento_idea', 'entrenamiento_idea.entrenamiento_id', '=', 'entrenamientos.id')
            ->join('ideas', 'ideas.id', '=', 'entrenamiento_idea.idea_id')
            ->where('entrenamientos.id', $id)
            ->get();
    }

    /**
     * genera un código de entrenamiento
     * @return return string
     */
    public function generarCodigoEntrenamiento()
    {
        $anho = Carbon::now()->isoFormat('YYYY');
        $tecnoparque = sprintf("%02d", auth()->user()->articulador->nodo_id);
        $id = Entrenamiento::selectRaw('MAX(id+1) AS max')->get()->last();
        $id->max == null ? $id->max = 1 : $id->max = $id->max;
        $id->max = sprintf("%04d", $id->max);
        $infocenter = sprintf("%03d", auth()->user()->articulador->id);
        $codigo_entrenamiento = 'E' . $anho . '-' . $tecnoparque . $infocenter . '-' . $id->max;
        return $codigo_entrenamiento;
    }

    // Hace el registro en la tabla entrenamiento_idea
    // Se hace la validacion con operadores ternarios para evitar que el campo quede null
    public function storeEntrenamiento($request)
    {
        DB::beginTransaction();
        try {
            
            $codigo_entrenamiento = $this->generarCodigoEntrenamiento();
            $syncIdeas = array();
            $syncIdeas = $this->arraySyncIdeasTaller($request);
            $entrenamiento = Entrenamiento::create([
                "fecha_sesion1" => $request->input('txtfecha_sesion1'),
                "fecha_sesion2" => $request->input('txtfecha_sesion1'),
                "codigo_entrenamiento" => $codigo_entrenamiento
            ]);
            $entrenamiento->ideas()->sync($syncIdeas, false);
            // Cambiar todas las ideas del entrenamiento a estado "En registro"
            // $entrenamiento->ideas()->update(['estadoidea_id' => EstadoIdea::where('nombre', EstadoIdea::IsRegistro())->first()->id]);
            // Registra el historial de todas esas ideas
            $this->registrarHistorialIdeaTaller($entrenamiento, Movimiento::IsRegistrar());
            // $entrenamiento->ideas->registrarHistorialIdea(Movimiento::IsRegistrar(), Session::get('login_role'), null, 'en el taller de fortalecimiento ' . $codigo_entrenamiento . ' realizado el día ' . $request->input('txtfecha_sesion1'));
            DB::commit();
            return [
                'state' => true,
                'msg' => 'El taller de fortalecimiento se registró exitosamente!',
                'title' => 'Registro exitoso!',
                'type' => 'success',
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            return [
                'state' => false,
                'msg' => 'El taller de fortalecimiento no se ha registrado!',
                'title' => 'Registro erróneo!',
                'type' => 'error',
            ];
        }
    }

    private function registrarHistorialIdeaTaller($entrenamiento, $movimiento)
    {
        foreach ($entrenamiento->ideas as $key => $idea) {
            if ($movimiento == Movimiento::IsRegistrar()) {
                $idea->registrarHistorialIdea(Movimiento::IsRegistrar(), Session::get('login_role'), null, 'en el taller de fortalecimiento ' . $entrenamiento->codigo_entrenamiento . ' realizado el día ' . $entrenamiento->fecha_sesion1);
            }
        }
    }

        /**
     * Retorna array con los datos que se van a registrar en la tabla intermedia
     * @param $request Datos del formulario
     * @return array
     * @author dum
     */
    private function arraySyncIdeasTaller($request)
    {
        $syncData = array();
        foreach ($request->get('ideas_taller') as $id => $value) {
            $syncData[$id] = array('confirmacion' => $request->confirmaciones[$id], 'asistencia1' => $request->asistencias[$id], 'idea_id' => $value);
        }
        return $syncData;
    }

    // Consulta los entrenamientos que se hicieron en la fecha de la primera y segunda sesion
    public function consultarEntrenamientoPorFechas($nodo_id, $fecha_sesion1, $fecha_sesion2)
    {
        return Entrenamiento::select('entrenamientos.id', 'fecha_sesion1', 'fecha_sesion2', 'codigo_entrenamiento')
            ->join('entrenamiento_idea', 'entrenamiento_idea.entrenamiento_id', '=', 'entrenamientos.id')
            ->join('ideas', 'ideas.id', '=', 'entrenamiento_idea.idea_id')
            ->join('nodos', 'nodos.id', '=', 'ideas.nodo_id')
            ->where('nodos.id', $nodo_id)
            ->where('fecha_sesion1', $fecha_sesion1)
            ->where('fecha_sesion2', $fecha_sesion2)
            ->get();
    }
}
