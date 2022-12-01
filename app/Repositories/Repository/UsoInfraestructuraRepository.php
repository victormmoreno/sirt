<?php

namespace App\Repositories\Repository;

use App\Models\Actividad;
use App\Models\CostoAdministrativo;
use App\Models\Equipo;
use App\Models\EquipoMantenimiento;
use App\Models\Material;
use App\Models\{Nodo, Proyecto};
use App\Models\UsoInfraestructura;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Session;

class UsoInfraestructuraRepository
{

    /**
     * retorna registro de un uso de infraestructura
     * @return bool
     * @param $request
     * @author devjul
     */
    public function storeUsoInfraestructuraProyecto($request)
    {
        $model = null;
        $asesorable = null;

        if (Session::get('login_role') == User::IsGestor() || Session::get('login_role') == User::IsTalento() || Session::get('login_role') == User::IsApoyoTecnico()) {
            $asesorable = Actividad::where('codigo_actividad', explode(" - ", $request->txtactividad)[0])
            ->first();
            $model = $asesorable->articulacion_proyecto->proyecto;
            // Agrego esto para solucionar un problema de merge

        } else if (Session::get('login_role') == User::IsArticulador() || Session::get('login_role') == User::IsTalento()) {
            if($request->filled('txttipousoinfraestructura') && $request->txttipousoinfraestructura == UsoInfraestructura::IsIdea()){
                $asesorable = \App\Models\Idea::where('codigo_idea', explode(" - ", $request->txtactividad)[0])
                    ->first();
            }else if($request->filled('txttipousoinfraestructura') && $request->txttipousoinfraestructura == UsoInfraestructura::IsArticulacion())
                $asesorable = \App\Models\Articulation::where('code', explode(" - ", $request->txtactividad)[0])
                    ->first();
            $model = $asesorable;
        }
        //llamado de metodo para guardar un uso de infraestructura
        $usoInfraestructura = $this->storeUsoInfraestructura($model, $request);
        //llamado de metodo para guardar talentos asociados al uso de infraestructura
        $this->storeTalentoToUsoInfraestructura($usoInfraestructura, $request);
        //llamado de metodo para guardar Gestores y horas de asesoria asociados al uso de infraestructura
        $this->storeGestorUsoToUsoInfraestructura($usoInfraestructura, $request);
        //llamado de metodo para guardar materiales y costos de material asociados al uso de infraestructura
        $this->storeMaterialUsoToUsoInfraestructura($usoInfraestructura, $request);

        $this->storeEquipoUsoToUsoInfraestructura($usoInfraestructura, $request);
        DB::beginTransaction();
        try {

            DB::commit();
            return 'true';
        } catch (\Exception $e) {
            DB::rollback();
            return 'false';
        }
    }

    /**
     * retorna registro de uso de infraestructura
     * @param $usoInfraestructura
     * @param $request
     * @author devjul
     */
    private function storeUsoInfraestructura($model, $request)
    {
        return $model->asesorias()->create([
            'fecha'                   => $request->txtfecha,
            'descripcion'             => $request->txtdescripcion,
            'compromisos'             => $request->get('txtcompromisos'),
            'estado'                  => 1,
        ]);
    }

    /**
     * retorna registro de talentos al uso de infraestrucutra
     * @param $usoInfraestructura
     * @param $request
     * @author devjul
     */
    private function storeTalentoToUsoInfraestructura($usoInfraestructura, $request)
    {
        if ($request->filled('talento')) {
            $usoInfraestructura->usotalentos()->sync($request->get('talento'), false);
        } else {
            $usoInfraestructura->usotalentos()->sync([]);
        }
        return $usoInfraestructura;
    }

    /**
     * retorna registro de gestores_uso al uso de infraestrucutra
     * @param $usoInfraestructura
     * @param $request
     * @author devjul
     */
    private function storeGestorUsoToUsoInfraestructura($usoInfraestructura, $request)
    {

        if ($request->filled('gestor')) {
            $syncData = $this->calculateCostoHorasAsesoria($usoInfraestructura,$request);
            $usoInfraestructura->usogestores()->sync($syncData);
        } else {
            $usoInfraestructura->usogestores()->sync([]);
        }
        return $usoInfraestructura;
    }

    /**
     * metodo retorna costo de horas de asesoria
     *
     * @param $request
     * @author devjul
     */
    private function calculateCostoHorasAsesoria($usoInfraestructura,$request)
    {

        $syncData            = [];
        $honorario           = [];
        $horasAsesoriaGestor = [];
        $asesor = null;

        foreach ($request->get('gestor') as $id => $value) {
            $asesor = null;
            if($usoInfraestructura->asesorable_type == Proyecto::class){
                $asesor = User::where('id', $value)->first();
            }else if($usoInfraestructura->asesorable_type == \App\Models\Articulation::class){
                $asesor = User::where('id', $value)->first();
            }else if($usoInfraestructura->asesorable_type == \App\Models\Idea::class){
                $asesor = User::where('id', $value)->first();
            }
            if(isset($asesor->gestor) && \Session::get('login_role') == User::IsGestor()){
                $honorarioAsesor = $asesor->gestor->honorarios;
            }else if(isset($asesor->articulador) && \Session::get('login_role') == User::IsArticulador()){
                $honorarioAsesor = $asesor->articulador->honorarios;
            }else if(isset($asesor->apoyotecnico) && \Session::get('login_role') == User::IsApoyoTecnico()){
                $honorarioAsesor = $asesor->apoyotecnico->honorarios;
            }else{
                $honorarioAsesor = 0;
            }
            //suma de las horas de asesoria directa y horas de asesoria indirecta
            $horasAsesoriaGestor[$id] = $request->get('asesoriadirecta')[$id] + $request->get('asesoriaindirecta')[$id];

            //calculo de honorario de valor hora del gestor * horas de asesoriria
            $honorario[$id] = round(($honorarioAsesor / CostoAdministrativo::DIAS_AL_MES / CostoAdministrativo::HORAS_AL_DIA) * (int) $horasAsesoriaGestor[$id]);

            //array que almacena los datos a guardar
            $syncData[$id] = [
                'asesorable_id' => $asesor->id,
                'asesorable_type' => User::class,
                'asesoria_directa'   => $request->get('asesoriadirecta')[$id] != null ? $request->get('asesoriadirecta')[$id] : 0,
                'asesoria_indirecta' => $request->get('asesoriaindirecta')[$id] != null ? $request->get('asesoriaindirecta')[$id] : 0,
                'costo_asesoria'     => $honorario[$id],
            ];
        }
        return $syncData;
    }

    /**
     * retorna registro de material_uso al uso de infraestrucutra
     * @param $usoInfraestructura
     * @param $request
     * @author devjul
     */
    private function storeMaterialUsoToUsoInfraestructura($usoInfraestructura, $request)
    {
        if ($request->filled('material')) {
            $syncData = $this->calculateCostoMateriales($request);
            $usoInfraestructura->usomateriales()->sync($syncData);
        } else {
            $usoInfraestructura->usomateriales()->sync([]);
        }
        return $usoInfraestructura;
    }

    /**
     * metodo retorna costo de materiales
     * @param $request
     * @author devjul
     */
    private function calculateCostoMateriales($request)
    {
        $syncData       = [];
        $dataMateriales = [];
        foreach ($request->get('material') as $id => $value) {
            //busqueda  del material por el id
            $material = Material::where('id', $value)->first();
            //calculo de costos de materiales
            if (isset($material)) {
                $dataMateriales[$id] = round(($material->valor_compra / $material->cantidad) * (float) $request->get('cantidad')[$id]);
            } else {
                $dataMateriales[$id] = 0;
            }

            //array que almacena los datos en material_costos
            $syncData[$id] = [
                'material_id'    => $value,
                'costo_material' => $dataMateriales[$id],
                'unidad'         => $request->get('cantidad')[$id],
            ];
        }
        return $syncData;
    }

    /**
     * retorna registro de equipos_uso al uso de infraestrucutra
     * @param $usoInfraestructura
     * @param $request
     * @author devjul
     */
    private function storeEquipoUsoToUsoInfraestructura($usoInfraestructura, $request)
    {
        if ($request->filled('equipo')) {
            $syncData = array();

            $syncData = $this->calculateCostoEquipos($request);

            $usoInfraestructura->usoequipos()->sync($syncData);
        } else {
            $usoInfraestructura->usoequipos()->sync([]);
        }

        return $usoInfraestructura;
    }

    /**
     * metodo retorna costo de equipos
     *
     * @param object $request
     * @author devjul
     */
    private function calculateCostoEquipos($request)
    {
        $syncData            = [];
        $depreciacionEquipo  = [];
        $mantenimientoEquipo = [];
        $costoAdministracion = [];
        $totalEquipos        = [];
        $anioActual          = Carbon::now()->year;
        foreach ($request->get('equipo') as $id => $value) {
            $equipo = Equipo::with(['equiposmantenimientos', 'lineatecnologica', 'nodo'])->where('id', $value)->first();

            if (($anioActual - $equipo->anio_compra) < $equipo->vida_util) {
                if ($equipo->vida_util == 0 || $equipo->horas_uso_anio == 0 || $equipo->costo_adquisicion == 0) {
                    $depreciacionEquipo[$id] = 0;
                } else {
                    $depreciacionEquipo[$id] = ($equipo->costo_adquisicion / $equipo->vida_util / $equipo->horas_uso_anio) * (double) $request->get('tiempouso')[$id];
                }
            } else {
                $depreciacionEquipo[$id] = 0;
            }
            //llamado de metodo para calcular el costo de Mantenimiento de equipo

            $equiposmantenimiento = EquipoMantenimiento::where('equipo_id', $value)->where('ultimo_anio_mantenimiento', $anioActual)->first();

            if (isset($equiposmantenimiento)) {
                //formula para calcular el valor del mantenimiento del equipo * tiempo uso infraestructura
                $mantenimientoEquipo[$id] = round(($equiposmantenimiento->valor_mantenimiento / $equiposmantenimiento->equipo->vida_util / $equiposmantenimiento->equipo->horas_uso_anio) * (double) $request->get('tiempouso')[$id]);
            } else {
                $mantenimientoEquipo[$id] = 0;
            }
            //costo total de equippos
            $totalEquipos[$id] = $depreciacionEquipo[$id] + $mantenimientoEquipo[$id];

            $costo = CostoAdministrativo::select(DB::raw('SUM(nodo_costoadministrativo.valor) as valor_costo_administrativo'))
                ->join('nodo_costoadministrativo', 'nodo_costoadministrativo.costo_administrativo_id', '=', 'costos_administrativos.id')
                ->join('nodos', 'nodos.id', '=', 'nodo_costoadministrativo.nodo_id')
                ->where('nodo_costoadministrativo.nodo_id', $equipo->nodo->id)
                ->first();

            $nodolineas   = Nodo::AllLineasPorNodo($equipo->nodo->id);
            $countlineas  = $nodolineas->lineas->count();
            $countequipos = $nodolineas->equipos->count();

            if ($costo->valor_costo_administrativo == 0) {
                $costoAdministracion[$id] = 0;
            } else {
                $costoAdministracion[$id] = round((($costo->valor_costo_administrativo / CostoAdministrativo::DIAS_AL_MES / CostoAdministrativo::HORAS_AL_DIA / $countlineas / CostoAdministrativo::DEDICACION)
                    * (100 / ($countequipos) * (int) $request->get('tiempouso')[$id]) / 100));
            }


            $syncData[$id] = array(
                'equipo_id'            => $value,
                'tiempo'               => $request->get('tiempouso')[$id],
                'costo_equipo'         => $totalEquipos[$id],
                'costo_administrativo' => $costoAdministracion[$id],
            );
        }
        return $syncData;
    }

    /**
     * retorna actualizacion de un uso de infraestructura
     *
     * @param $request
     * @author devjul
     */
    public function update($request, $id)
    {
        DB::beginTransaction();
        try {

            $usoInfraestructura = $this->updateUsoInfraestructura($id, $request);
            //llamado de metodo para guardar talentos asociados al uso de infraestructura
            $this->storeTalentoToUsoInfraestructura($usoInfraestructura, $request);
            //llamado de metodo para guardar Gestores y horas de asesoria asociados al uso de infraestructura
            $this->storeGestorUsoToUsoInfraestructura($usoInfraestructura, $request);
            //llamado de metodo para guardar materiales y costos de material asociados al uso de infraestructura
            $this->storeMaterialUsoToUsoInfraestructura($usoInfraestructura, $request);

            $this->storeEquipoUsoToUsoInfraestructura($usoInfraestructura, $request);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    /**
     * retorna registro de equipos_uso al uso de infraestrucutra
     * @param $usoInfraestructura
     * @param  $request
     * @author devjul
     */
    private function updateUsoInfraestructura($id, $request)
    {

        // $actividad = Actividad::where('codigo_actividad', explode(" - ", $request->txtactividad)[0])
        //     ->first()->id;

        $usoInfraestructura = UsoInfraestructura::find($id);

        $usoInfraestructura->update([
            // 'actividad_id'            => $actividad,
            // 'tipo_usoinfraestructura' => $request->get('txttipousoinfraestructura'),
            'fecha'                   => $request->txtfecha,
            'asesoria_directa'        => isset($request->txtasesoriadirecta) ? $request->txtasesoriadirecta : '0',
            'asesoria_indirecta'      => isset($request->txtasesoriaindirecta) ? $request->txtasesoriaindirecta : '0',
            'descripcion'             => $request->txtdescripcion,
            'compromisos'             => $request->get('txtcompromisos'),
            'estado'                  => 1,
        ]);
        return $usoInfraestructura;
    }

    /**
     * retorna query con los usos de infraestructura
     * @return collection
     * @author devjul
     */
    public function getUsoInfraestructuraForUser(array $relations)
    {

        return UsoInfraestructura::with([
            'actividad'                                                     => function ($query) {
                $query->select('id', 'gestor_id', 'nodo_id', 'codigo_actividad', 'nombre', 'fecha_inicio', 'fecha_cierre', 'created_at');
            },
            'actividad.nodo'                                                => function ($query) {
                $query->select('id', 'entidad_id', 'direccion', 'telefono');
            },
            'actividad.nodo.entidad'                                        => function ($query) {
                $query->select('id', 'ciudad_id', 'nombre', 'email_entidad');
            },
            'actividad.nodo.entidad.ciudad.departamento',
            'actividad.articulacion_proyecto'                               => function ($query) {
                $query->select('id', 'entidad_id', 'actividad_id', 'acta_cierre');
            },
            'actividad.articulacion_proyecto.proyecto'                      => function ($query) {
                $query->select('id', 'articulacion_proyecto_id', 'sublinea_id', 'areaconocimiento_id');
            },
            'actividad.articulacion_proyecto.proyecto.fase',
        ]);
    }

    /**
     * metodo retorna las relaciones con model usoinfraestructura
     * @author devjul
     */
    public function getDataIndex()
    {
        return [

            'actividad'                                                     => function ($query) {
                $query->select('id', 'gestor_id', 'nodo_id', 'codigo_actividad', 'nombre', 'fecha_inicio', 'fecha_cierre', 'created_at');
            },
            'actividad.nodo'                                                => function ($query) {
                $query->select('id', 'entidad_id', 'direccion', 'telefono');
            },
            'actividad.nodo.entidad'                                        => function ($query) {
                $query->select('id', 'ciudad_id', 'nombre', 'email_entidad');
            },
            'actividad.nodo.entidad.ciudad.departamento',
            'actividad.articulacion_proyecto'                               => function ($query) {
                $query->select('id', 'entidad_id', 'actividad_id', 'acta_cierre');
            },
            'actividad.articulacion_proyecto.talentos',
            'actividad.articulacion_proyecto.talentos.user'                 => function ($query) {
                $query->select('id', 'documento', 'nombres', 'apellidos');
            },
            'actividad.articulacion_proyecto.proyecto'                      => function ($query) {
                $query->select('id', 'articulacion_proyecto_id', 'sublinea_id', 'areaconocimiento_id');
            },
            'actividad.articulacion_proyecto.proyecto.areaconocimiento'     => function ($query) {
                $query->select('id', 'nombre');
            },
            'actividad.articulacion_proyecto.proyecto.sublinea'             => function ($query) {
                $query->select('id', 'nombre');
            },
            'actividad.gestor'                                              => function ($query) {
                $query->select('id', 'user_id', 'nodo_id', 'lineatecnologica_id');
            },
            'actividad.gestor.nodo'                                         => function ($query) {
                $query->select('id', 'entidad_id', 'direccion', 'telefono');
            },
            'actividad.gestor.nodo.entidad'                                 => function ($query) {
                $query->select('id', 'ciudad_id', 'nombre', 'email_entidad');
            },
            'actividad.gestor.nodo.entidad.ciudad.departamento',
            'actividad.gestor.lineatecnologica'                             => function ($query) {
                $query->select('id', 'nombre', 'abreviatura');
            },
            'actividad.gestor.user'                                         => function ($query) {
                $query->select('id', 'documento', 'nombres', 'apellidos');
            },
            'usotalentos',
            'usotalentos.user'                                              => function ($query) {
                $query->select('id', 'documento', 'nombres', 'apellidos');
            },
            'usogestores',
            'usogestores.lineatecnologica'                                  => function ($query) {
                $query->select('id', 'nombre', 'abreviatura');
            },
            'usogestores.user'                                              => function ($query) {
                $query->select('id', 'documento', 'nombres', 'apellidos');
            },
            'usoequipos',
            'usoequipos.nodo'                                               => function ($query) {
                $query->select('id', 'entidad_id', 'direccion', 'telefono');
            },
            'usoequipos.nodo.entidad'                                       => function ($query) {
                $query->select('id', 'ciudad_id', 'nombre', 'email_entidad');
            },
            'usoequipos.nodo.entidad.ciudad.departamento',
            'usoequipos.lineatecnologica'                                   => function ($query) {
                $query->select('id', 'nombre', 'abreviatura');
            },
        ];
    }


    public function getProyectosForUser($user)
    {
        return Proyecto::select('proyectos.id', 'actividades.codigo_actividad AS codigo_proyecto', 'fases.nombre AS nombre_fase')
            ->selectRaw('concat(actividades.codigo_actividad, " - ", actividades.nombre) AS nombre')
            ->selectRaw('concat(users.nombres, " ", users.apellidos) AS nombre_gestor')
            ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id')
            ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
            ->join('nodos', 'nodos.id', '=', 'proyectos.nodo_id')
            ->join('ideas', 'ideas.id', '=', 'proyectos.idea_id')
            ->join('gestores', 'gestores.id', '=', 'proyectos.asesor_id')
            ->join('users', 'users.id', '=', 'gestores.user_id')
            ->join('fases', 'fases.id', '=', 'proyectos.fase_id')
            ->join('articulacion_proyecto_talento', 'articulacion_proyecto_talento.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
            ->join('talentos', 'talentos.id', '=', 'articulacion_proyecto_talento.talento_id')
            ->join('users AS user_talento', 'user_talento.id', '=', 'talentos.id');
    }

    /**
     * retorna query con las ideas en fase Inicio, En ejecución por usuarios
    * @return collection
    * @author devjul
    */
    public function getIdeasForUser(array $relations)
    {
        return \App\Models\Idea::ideaWithRelations($relations);
    }
}
