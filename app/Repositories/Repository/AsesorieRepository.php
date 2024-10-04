<?php

namespace App\Repositories\Repository;



use App\Repositories\Repository\ProyectoRepository;
use App\Repositories\Repository\Articulation\ArticulationRepository;
use App\Models\Articulation;
use App\Models\CostoAdministrativo;
use App\Models\Equipo;
use App\Models\EquipoMantenimiento;
use App\Models\Fase;
use App\Models\Material;
use App\Models\Nodo;
use App\Models\UsoInfraestructura;
use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class AsesorieRepository
{
    private $projectRepository;
    private $articulationRepository;

    public function __construct(
        ProyectoRepository $projectRepository,
        ArticulationRepository $articulationRepository
    ) {
        $this->projectRepository = $projectRepository;
        $this->articulationRepository = $articulationRepository;
    }
    /**
     * method that returns the query with all the materials
     * @param Request $request
     */

    public function getListMaterials()
    {
        return UsoInfraestructura::query()
        ->join('material_uso', 'material_uso.usoinfraestructura_id', '=', 'usoinfraestructuras.id')
        ->join('materiales', 'materiales.id', '=', 'material_uso.material_id')
        ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'materiales.lineatecnologica_id')
        ->join('medidas', 'medidas.id', '=', 'materiales.medida_id');
    }
    /**
     * method that returns the query with all the devices
     * @param Request $request
     */

    public function getListDevices()
    {
        return UsoInfraestructura::query()
        ->join('equipo_uso', 'equipo_uso.usoinfraestructura_id', '=', 'usoinfraestructuras.id')
        ->join('equipos', 'equipos.id', '=', 'equipo_uso.equipo_id')
        ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'equipos.lineatecnologica_id');
    }
    /**
     * method that returns the query with all the asesories
     * @param Request $request
     */

    public function getListAsesoriesIndicators()
    {
        return UsoInfraestructura::query()
            ->leftJoin('gestor_uso', 'gestor_uso.usoinfraestructura_id', '=', 'usoinfraestructuras.id')
            ->leftJoin('users as asesores', 'asesores.id', '=', 'gestor_uso.asesor_id');
    }
    /**
     * method that returns the query with all the asesories
     * @param Request $request
     */

    public function getListAsesories()
    {
        return UsoInfraestructura::query()
            ->leftJoin('uso_talentos', 'uso_talentos.usoinfraestructura_id', '=', 'usoinfraestructuras.id')
            ->leftJoin('users as participants', 'participants.id', '=', 'uso_talentos.user_id')
            ->leftJoin('gestor_uso', 'gestor_uso.usoinfraestructura_id', '=', 'usoinfraestructuras.id')
            ->leftJoin('users as asesores', 'asesores.id', '=', 'gestor_uso.asesor_id');
    }

    public function getDataProjectsForUser()
    {
        $user = auth()->user()->documento;

        $fase = [
            Fase::IsInicio(),
            Fase::IsPlaneacion(),
            Fase::IsEjecucion(),
        ];

        $relations = [
            'asesor' ,
            'talentos' => function ($query) {
                $query->select('users.id', 'users.documento', 'users.nombres', 'users.apellidos');
            },
        ];

        if (Session::has('login_role') && Session::get('login_role') == User::IsExperto()) {

            return $this->projectRepository->getProjectsForFaseById($relations, $fase)
                ->whereHas('asesor', function ($query) use ($user) {
                    $query->where('documento', $user);
                })
                ->get();
        }else if(Session::has('login_role') && Session::get('login_role') == User::IsApoyoTecnico()){
            return $this->projectRepository->getProjectsForFaseById($relations, $fase)
                ->whereHas('nodo', function($query){
                    $query->where('id', auth()->user()->apoyotecnico->nodo->id);
                })->get();
        } else if (Session::has('login_role') && Session::get('login_role') == User::IsTalento()) {

            return $this->projectRepository->getProjectsForFaseById($relations, $fase)
                ->whereHas('talentos', function ($query) use ($user) {
                    $query->where('documento', $user);
                })
                ->get();
        }else if (Session::has('login_role') && Session::get('login_role') == User::IsArticulador()){
            return [];
        }
        else {
            return [];
        }
    }

    public function getDataArticulations()
    {
        $user = auth()->user()->documento;

        $fase = [
            Fase::IsInicio(),
            Fase::IsEjecucion(),
            Fase::IsCierre(),
        ];

        $relations = [
            'phase'                => function ($query) {
                $query->select('id', 'nombre');
            },
        ];

        if (Session::has('login_role') && Session::get('login_role') == User::IsExperto()) {
            return [];
        }elseif(Session::has('login_role') && Session::get('login_role') == User::IsArticulador()) {
            return   Articulation::query()->with($relations)
                        ->whereHas('articulationstage', function ($query) {
                            $query->where('node_id', auth()->user()->articulador->nodo_id);
                        })
                        ->whereIn('phase_id', $fase)
                        ->get();
        }
        elseif (Session::has('login_role') && Session::get('login_role') == User::IsTalento()) {
            return Articulation::query()->with($relations)
                ->whereHas('users', function ($query) use ($user) {
                    $query->where('documento', $user);
                })
                ->whereIn('fase_id', $fase)
                ->get();
        } else {
            response()->json([
                'error' => 'no tienes permisos'
            ]);
        }
    }

    public function getDataIdeas()
    {
        $fase = [
            \App\Models\EstadoIdea::IsRegistro(),
            \App\Models\EstadoIdea::IsConvocado(),
            \App\Models\EstadoIdea::IsPostulado(),
        ];
        $relations = [
            'estadoIdea'                => function ($query) {
                $query->select('id', 'nombre');
            },
        ];
        if(Session::has('login_role') && Session::get('login_role') == User::IsArticulador()) {
            $user = auth()->user()->articulador;
            return $this->getIdeasForUser($relations)
                ->whereHas('nodo', function ($query) use ($user) {
                    $query->where('id', $user->nodo_id);
                })
                ->whereHas('estadoIdea',function($query)use ($fase){
                    $query->whereIn('nombre', $fase);
                })->get();
        } else {
            response()->json([
                'error' => 'no tienes permisos'
            ]);
        }
    }


    /**
     * retorna string sin comillas dobles
     * @param string $data
     * @return string
     **/
    public function reemplezarComillas($data)
    {
        return str_replace('"', '', $data);
    }

    /**
     * retorna query con las ideas en fase Inicio, En ejecución por usuarios
    * @return collection
    */
    public function getIdeasForUser(array $relations)
    {
        return \App\Models\Idea::ideaWithRelations($relations);
    }

    /**
     * retorna registro de un uso de infraestructura
     * @return bool
     * @param $request
     */
    public function store($request)
    {
        DB::beginTransaction();
        try {
            $asesorable = null;
            if (Session::get('login_role') == User::IsExperto() || Session::get('login_role') == User::IsTalento() || Session::get('login_role') == User::IsApoyoTecnico()) {
                $asesorable = \App\Models\Proyecto::where('codigo_proyecto', explode(" - ", $request->txtactividad)[0])
                ->first();
            } else if (Session::get('login_role') == User::IsArticulador() || Session::get('login_role') == User::IsTalento()) {
                if($request->filled('txttipousoinfraestructura') && $request->txttipousoinfraestructura == UsoInfraestructura::IsIdea()){
                    $asesorable = \App\Models\Idea::where('codigo_idea', explode(" - ", $request->txtactividad)[0])
                        ->first();
                }else if($request->filled('txttipousoinfraestructura') && $request->txttipousoinfraestructura == UsoInfraestructura::IsArticulacion())
                    $asesorable = \App\Models\Articulation::where('code', explode(" - ", $request->txtactividad)[0])
                        ->first();
            }
            //llamado de metodo para guardar una asesoria
            $asesorie = $this->storeAsesorie($asesorable, $request);
            //llamado de metodo para guardar talentos asociados al uso de infraestructura
            $this->storeTalentoToAsesorie($asesorie, $request);
            // //llamado de metodo para guardar Gestores y horas de asesoria asociados al uso de infraestructura
            $this->storeAsesores($asesorie, $request);
            // //llamado de metodo para guardar materiales y costos de material asociados al uso de infraestructura
            $this->storeMaterialToAsesorie($asesorie, $request);
            $this->storeDevicesToAsesorie($asesorie, $request);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    /**
     * retorna registro de asesorie
     * @param $model
     * @param $request
     */
    private function storeAsesorie($model, $request)
    {
        return $model->asesorias()->create([
            'codigo' => $this->generateCode('ASE'),
            'fecha'                   => $request->txtfecha,
            'descripcion'             => $request->txtdescripcion,
            'compromisos'             => $request->get('txtcompromisos'),
            'estado'                  => 1,
        ]);
    }

    /**
     * retorna actualizacion de una asesoria
     * @param $request
     * @param $id
     */
    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $asesorie = $this->updateAsesorie($request, $id);
            //llamado de metodo para guardar talentos asociados al uso de infraestructura
            $this->storeTalentoToAsesorie($asesorie, $request);
            //llamado de metodo para guardar Gestores y horas de asesoria asociados al uso de infraestructura
            $this->storeAsesores($asesorie, $request);
            //llamado de metodo para guardar materiales y costos de material asociados al uso de infraestructura
            $this->storeMaterialToAsesorie($asesorie, $request);
            $this->storeDevicesToAsesorie($asesorie, $request);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }




    /**
     * Genera un código para la asesoria
     * @param string $initial
     * @return string
     */
    private function generateCode($initial = null)
    {
            $year = Carbon::now()->isoFormat('YYYY');
            $month = Carbon::now()->isoFormat('MM');
            $user = sprintf("%03d", auth()->user()->id);
            $asesorie = UsoInfraestructura::selectRaw('MAX(id+1) AS max')->get()->last();
            $asesorie->max == null ? $asesorie->max = 1 : $asesorie->max = $asesorie->max;
            $asesorie->max = sprintf("%04d", $asesorie->max);
            return "{$initial}{$year}-{$user}{$month}{$user}-{$asesorie->max}";
    }

    /**
     * retorna registro de talentos a la asesoria
     * @param $asesorie
     * @param $request
     */
    private function storeTalentoToAsesorie($asesorie, $request)
    {
        if ($request->filled('talento')) {
            $asesorie->participantes()->sync($request->get('talento'), false);
        } else {
            $asesorie->participantes()->sync([]);
        }
        return $asesorie;
    }

    /**
     * retorna actualizacion de asesoria
     * @param  $request
     * @param $id
     */
    private function updateAsesorie($request, $id)
    {

        $asesorie = UsoInfraestructura::find($id);

        $asesorie->update([
            'fecha'                   => $request->txtfecha,
            // 'asesoria_directa'        => isset($request->txtasesoriadirecta) ? $request->txtasesoriadirecta : '0',
            // 'asesoria_indirecta'      => isset($request->txtasesoriaindirecta) ? $request->txtasesoriaindirecta : '0',
            'descripcion'             => $request->txtdescripcion,
            'compromisos'             => $request->get('txtcompromisos'),
            'estado'                  => 1,
        ]);
        return $asesorie;
    }

    /**
     * retorna registro de gestores_uso a la asesoria
     * @param $asesorie
     * @param $request
     */
    private function storeAsesores($asesorie, $request)
    {

        if ($request->filled('gestor')) {
            $syncData = $this->calculateCostHourAsesorie($asesorie,$request);
            $asesorie->asesores()->sync($syncData);
        } else {
            $asesorie->asesores()->sync([]);
        }
        return $asesorie;
    }

    /**
     * retorna registro de material_uso a la asesoria
     * @param $asesorie
     * @param $request
     * @author devjul
     */
    private function storeMaterialToAsesorie($asesorie, $request)
    {
        if ($request->filled('material')) {
            $syncData = $this->calculateCostMaterials($request);
            $asesorie->usomateriales()->sync($syncData);
        } else {
            $asesorie->usomateriales()->sync([]);
        }
        return $asesorie;
    }

    /**
     * retorna registro de equipos_uso a la asesoria
     * @param $asesorie
     * @param $request
     */
    public function storeDevicesToAsesorie($asesorie, $request)
    {
        if ($request->filled('equipo')) {
            $syncData = array();

            $syncData = $this->calculateCostoEquipos($request);

            $asesorie->usoequipos()->sync($syncData);
        } else {
            $asesorie->usoequipos()->sync([]);
        }

        return $asesorie;
    }


    /**
     * metodo retorna costo de horas de asesoria
     * @param $asesorie
     * @param $request
     */
    private function calculateCostHourAsesorie($asesorie, $request)
    {
        $syncData            = [];
        $totalHonorario           = [];
        $horasAsesoriaExperto = [];
        $asesor = null;

        foreach ($request->get('gestor') as $id => $value) {
            $asesor = null;
            if($asesorie->asesorable_type == \App\Models\Proyecto::class){
                $asesor = User::where('id', $value)->withTrashed()->first();
            }else if($asesorie->asesorable_type == \App\Models\Articulation::class){
                $asesor = User::where('id', $value)->withTrashed()->first();
            }else if($asesorie->asesorable_type == \App\Models\Idea::class){
                $asesor = User::where('id', $value)->withTrashed()->first();
            }
            //suma de las horas de asesoria directa y horas de asesoria indirecta
            $horasAsesoriaExperto[$id] = $request->get('asesoriadirecta')[$id] + $request->get('asesoriaindirecta')[$id];

            if(isset($asesor->experto)){
                $honorarioAsesor = $asesor->experto->honorarios;
            }else if(isset($asesor->articulador)){
                $honorarioAsesor = $asesor->articulador->honorarios;
            }else if(isset($asesor->apoyotecnico)){
                $honorarioAsesor = $asesor->apoyotecnico->honorarios;
            }else{
                $honorarioAsesor = 0;
            }
            
            $calculateHonorariosAsesor = round(($honorarioAsesor / CostoAdministrativo::DIAS_AL_MES / CostoAdministrativo::HORAS_AL_DIA) * (double) $horasAsesoriaExperto[$id]);

            //calculo de honorario de valor hora del asesor * horas de asesoriria
            $totalHonorario[$id] = $calculateHonorariosAsesor;
            //array que almacena los datos a guardar
            $syncData[$id] = [
                'asesor_id' => $asesor->id,
                'asesoria_directa'   => $request->get('asesoriadirecta')[$id] != null ? $request->get('asesoriadirecta')[$id] : 0,
                'asesoria_indirecta' => $request->get('asesoriaindirecta')[$id] != null ? $request->get('asesoriaindirecta')[$id] : 0,
                'costo_asesoria'     => $totalHonorario[$id]
            ];
        }
        return $syncData;
    }

    /**
     * metodo retorna costo de materiales
     * @param $request
     * @author devjul
     */
    private function calculateCostMaterials($request)
    {
        $syncData       = [];
        $dataMaterials = [];
        foreach ($request->get('material') as $id => $value) {
            //busqueda  del material por el id
            $material = Material::where('id', $value)->first();
            //calculo de costos de materiales
            if (isset($material)) {
                $dataMaterials[$id] = round(($material->valor_compra / $material->cantidad) * (float) $request->get('cantidad')[$id]);
            } else {
                $dataMaterials[$id] = 0;
            }
            //array que almacena los datos en material_costos
            $syncData[$id] = [
                'material_id'    => $value,
                'costo_material' => $dataMaterials[$id],
                'unidad'         => $request->get('cantidad')[$id],
            ];
        }
        return $syncData;
    }

    /**
     * metodo retorna costo de equipos
     *
     * @param object $request
     */
    private function calculateCostoEquipos($request)
    {
        $syncData            = [];
        $depreciacionEquipo  = [];
        $mantenimientoEquipo = [];
        $costoAdministracion = [];
        $totalEquipos        = [];
        $anioActual          = Carbon::now()->year;
        $node = null;
        // if(\Session::get('login_role') == User::IsExperto()){
        //     $node = auth()->user()->experto->nodo_id;
        // }else if(\Session::get('login_role') == User::IsArticulador()){
        //     $node = auth()->user()->articulador->nodo_id;
        // }else if(\Session::get('login_role') == User::IsApoyoTecnico()){
        //     $node = auth()->user()->apoyotecnico->nodo_id;
        // }
        foreach ($request->get('equipo') as $id => $value) {
            $equipo = Equipo::with(['equiposmantenimientos', 'lineatecnologica', 'nodo'])->where('id', $value)->first();
            $node = $equipo->nodo_id;
            if ($equipo->vida_util == 0 || $equipo->horas_uso_anio == 0 || $equipo->costo_adquisicion == 0) {
                        $depreciacionEquipo[$id] = 0;
            } else {
                $depreciacionEquipo[$id] = ($equipo->costo_adquisicion / $equipo->vida_util / $equipo->horas_uso_anio) * (double) $request->get('tiempouso')[$id];
            }
            // if (($anioActual - $equipo->anio_compra) < $equipo->vida_util) {
            //     if ($equipo->vida_util == 0 || $equipo->horas_uso_anio == 0 || $equipo->costo_adquisicion == 0) {
            //         $depreciacionEquipo[$id] = 0;
            //     } else {
            //         $depreciacionEquipo[$id] = ($equipo->costo_adquisicion / $equipo->vida_util / $equipo->horas_uso_anio) * (double) $request->get('tiempouso')[$id];
            //     }
            // } else {
            //     $depreciacionEquipo[$id] = 0;
            // }
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
                ->where('nodo_costoadministrativo.anho', Carbon::now()->year)
                ->groupBy('nodos.id')
                ->first();

            $nodolineas   = Nodo::AllLineasPorNodo($equipo->nodo->id);
            $countlineas  = $nodolineas->lineas->count();
            $countequipos = $nodolineas->equipos->count();

            $dinamizadores = User::ConsultarFuncionarios($node, User::IsDinamizador())->get();
            $infocenters = User::ConsultarFuncionarios($node, User::IsInfocenter())->get();
            if(isset($dinamizadores) && $dinamizadores->count() > 0){
                $calculateHonorariosDinamizador = $dinamizadores->sum('honorarios');
            }else{
                $calculateHonorariosDinamizador = 0;
            }
            if(isset($infocenters) && $infocenters->count() > 0){
                $calculateHonorariosInfocenter = $infocenters->sum('honorarios');
            }else{
                $calculateHonorariosInfocenter = 0;
            }

            if ($costo->valor_costo_administrativo == 0) {
                $costoAdministracion[$id] = 0;
            } else {
                $costoAdministracion[$id] = round((( ($costo->valor_costo_administrativo + $calculateHonorariosDinamizador + $calculateHonorariosInfocenter) / CostoAdministrativo::DIAS_AL_MES / CostoAdministrativo::HORAS_AL_DIA / $countlineas / CostoAdministrativo::DEDICACION)
                    * (100 / ($countequipos) * (double) $request->get('tiempouso')[$id]) / 100));
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
}
