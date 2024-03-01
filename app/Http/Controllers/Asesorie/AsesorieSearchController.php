<?php

namespace App\Http\Controllers\Asesorie;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Asesorie\AsesorieSearchRequest;
use App\Models\Fase;
use App\Models\Idea;
use App\Models\Articulation;
use App\Models\LineaTecnologica;
use App\Models\Equipo;
use App\Models\Material;
use App\Models\Proyecto;
use App\Models\UsoInfraestructura;
use App\Repositories\Repository\AsesorieRepository;
use App\User;

class AsesorieSearchController extends Controller
{
    private $asesorieRepository;
    public function __construct(
        AsesorieRepository $asesorieRepository
    ) {
        $this->asesorieRepository = $asesorieRepository;
    }
    /**
     * Display the view for to search specified resource (user).
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|Response|\Illuminate\View\View
     */
    public function showFormSearch()
    {
        if (request()->user()->cannot('search', UsoInfraestructura::class)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $modules = [];
        switch(session()->get('login_role')){
            case User::IsAdministrador():
                $modules = [
                    class_basename(UsoInfraestructura::class) => "Código Asesoria",
                    class_basename(Proyecto::class) => 'Código '.__('Projects'),
                    class_basename(Articulation::class) => 'Código '.__('Articulations'),
                    class_basename(Idea::class) => 'Código '.__('Ideas')
                ];
                break;
            case User::IsActivador():
                $modules = [
                    class_basename(UsoInfraestructura::class) => "Código Asesoria",
                    class_basename(Proyecto::class) => 'Código '.__('Projects'),
                    class_basename(Articulation::class) => 'Código '.__('Articulations'),
                    class_basename(Idea::class) => 'Código '.__('Ideas')
                ];
                break;
            case User::IsDinamizador():
                $modules = [
                    class_basename(UsoInfraestructura::class) => "Código Asesoria",
                    class_basename(Proyecto::class) => 'Código '.__('Projects'),
                    class_basename(Articulation::class) => 'Código '.__('Articulations'),
                    class_basename(Idea::class) => 'Código '.__('Ideas')
                ];
                break;
            case User::IsExperto():
                $modules = [
                    class_basename(UsoInfraestructura::class) => "Código Asesoria",
                    class_basename(Proyecto::class) => 'Código '.__('Projects'),
                ];
                break;
            case User::IsArticulador():
                $modules = [
                    class_basename(UsoInfraestructura::class) => "Código Asesoria",
                    class_basename(Articulation::class) => 'Código '.__('Articulations'),
                    class_basename(Idea::class) => 'Código '.__('Ideas')
                ];
                break;
            case User::IsApoyoTecnico():
                $modules = [
                    class_basename(UsoInfraestructura::class) => "Código Asesoria",
                    class_basename(Proyecto::class) => 'Código '.__('Projects'),
                ];
                break;
            case User::IsTalento():
                $modules = [
                    class_basename(UsoInfraestructura::class) => "Código Asesoria",
                    class_basename(Proyecto::class) => 'Código '.__('Projects'),
                    class_basename(Articulation::class) => 'Código '.__('Articulations')
                ];
                break;
            default:
                $modules = [];
                break;
        }
        return view('asesorias.search', [
            'modules' => $modules
        ]);
    }

    /**
     * Search specified resource (user).
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|Response|\Illuminate\View\View
     */
    public function queryAsesorieSearch(Request $request)
    {
        if (!request()->ajax() || request()->user()->cannot('search', UsoInfraestructura::class)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $req = new AsesorieSearchRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'fail' => true,
                'errors' => $validator->errors(),
            ]);
        }
        $model = $this->checkRoleAuth($request)['model'];


        $asesories = $this->asesorieRepository->getListAsesories()
            ->selectAsesoria($model)
            ->joins($model)
            ->where(function($subquery) use($model, $request){
                if($model == class_basename(UsoInfraestructura::class)){
                    $subquery->where('usoinfraestructuras.codigo', 'LIKE', "%$request->search_asesorie%");
                }else if($model == class_basename(Proyecto::class)){
                    $subquery->where('proyectos.codigo_proyecto', 'like', "%$request->search_asesorie%");
                }else if($model == class_basename(Articulation::class)){
                    $subquery->where('articulations.code', 'like', "%$request->search_asesorie%");
                }else if($model == class_basename(Idea::class)){
                    $subquery->where('ideas.codigo_idea', 'like', "%$request->search_asesorie%");
                }
            })
            ->groupBy('usoinfraestructuras.id')
            ->get();
        if(empty($asesories)){
            return response()->json([
                'users' => null,
                'status' => Response::HTTP_ACCEPTED,
                'message' => 'No se encontraron asesorias asociadas al valor ingresado',
                'url' => route('registro'),
            ], Response::HTTP_ACCEPTED);
        }
        $urls = [];
        foreach($asesories as $asesorie){
            $urls[] = route('asesorias.show', $asesorie->codigo);
        };
        return response()->json([
            'asesories' => $asesories   ,
            'message' => "tienes {$asesories->count()} asesorias",
            'status' => Response::HTTP_OK,
            'urls' => $urls,
        ], Response::HTTP_OK);
    }

    /**
     * method to validate the authenticated role
     * @return void
     */
    private function checkRoleAuth($request)
    {
        $user = null;
        $model = null;
        switch (\Session::get('login_role')) {
            case User::IsAdministrador():
                $node = null;
                $model = $request->type_search;
                break;
            case User::IsActivador():
                $node = null;
                $model = $request->type_search;
                break;
            case User::IsDinamizador():
                $node = [auth()->user()->dinamizador->nodo_id];
                $model = $request->type_search;
                break;
            case User::IsArticulador():
                $node = [auth()->user()->articulador->nodo_id];
                $model = $request->type_search;
                break;
            case User::IsExperto():
                $node = [auth()->user()->experto->nodo_id];
                $user = auth()->user()->id;
                $model = class_basename(Proyecto::class);
                break;
            case User::IsApoyoTecnico():
                $node = [auth()->user()->apoyotecnico->nodo_id];
                $user = auth()->user()->id;
                $model = class_basename(Proyecto::class);
                break;
            case User::IsTalento():
                $node = null;
                $user = auth()->user()->id;
                $model = $request->type_search;
                break;
            default:
                $user = null;
                $node = null;
                $model = null;
                break;
        }
        return ['user' => $user, 'node' => $node, 'model' => $model];
    }

    /**
     * retorna query con los proyectos en fase Inicio, planeacion, En ejecucion por usuarios
    //  * @return object
     */
    public function projectsForUser()
    {
        $projects = $this->asesorieRepository->getDataProjectsForUser();
        if (request()->ajax()) {

            return datatables()->of($projects)
                ->addColumn('checkbox', function ($data) {
                    $checkbox = '<a class="btn cyan m-b-xs" onclick="asociarProyectoAUsoInfraestructura(' . $data->id . ', \'' . $data->codigo_proyecto . '\', \'' . $this->asesorieRepository->reemplezarComillas($data->nombre) . '\')">
                        <i class="material-icons">done_all</i>
                    </a>';
                    return $checkbox;
                })->editColumn('codigo', function ($data) {
                    return $data->codigo_proyecto;
                })
                ->editColumn('nombre', function ($data) {
                    return $data->nombre;
                })
                ->editColumn('fase', function ($data) {
                    return $data->present()->proyectoFase();
                })
                ->rawColumns(['checkbox', 'codigo', 'nombre','fase'])->make(true);
        } else {
            abort('403');
        }
    }

    /**
     * retorna query con las articulaciones en fase Inicio, En ejecuci車n por usuarios
     * @return collection
     */
    public function articulationsForUser()
    {
        $articulations = $this->asesorieRepository->getDataArticulations();
        if (request()->ajax()) {
            return datatables()->of($articulations)
                ->addColumn('checkbox', function ($data) {
                    $checkbox = '
                    <a class="btn cyan m-b-xs" onclick="asociarArticulacionAUsoInfraestructura(' . $data->id . ', \'' . $data->present()->articulationCode() . '\', \'' . $this->asesorieRepository->reemplezarComillas($data->present()->articulationName()) . '\')">
                        <i class="material-icons">done_all</i>
                    </a>';
                    return $checkbox;
                })->editColumn('codigo', function ($data) {
                    return $data->present()->articulationCode();
                })
                ->editColumn('nombre', function ($data) {
                    return $data->present()->articulationName();
                })
                ->editColumn('fase', function ($data) {
                    return $data->present()->articulationPhase();
                })
                ->rawColumns(['checkbox', 'codigo', 'nombre', 'fase'])->make(true);
        } else {
            abort('403');
        }
    }

    /**
     * retorna query con las ideas
     * @return collection
     */
    public function ideasForNode()
    {
        $ideas = $this->asesorieRepository->getDataIdeas();
        if (request()->ajax()) {
            return datatables()->of($ideas)
                ->addColumn('checkbox', function ($data) {
                    $checkbox = '
                    <a class="btn cyan m-b-xs" onclick="asociarIdeaAUsoInfraestructura(' . $data->id . ', \'' . $data->present()->ideaCode() . '\', \'' . $this->asesorieRepository->reemplezarComillas($data->present()->ideaName()) . '\')">
                        <i class="material-icons">done_all</i>
                    </a>';
                    return $checkbox;
                })->editColumn('codigo_idea', function ($data) {
                    return $data->present()->ideaCode();
                })
                ->editColumn('nombre_proyecto', function ($data) {
                    return $data->present()->ideaName();
                })
                ->editColumn('estadoIdea', function ($data) {
                    return $data->estadoIdea->nombre;
                })
                ->rawColumns(['checkbox', 'codigo_idea', 'nombre_proyecto', 'estadoIdea'])->make(true);
        } else {
            abort('403');
        }
    }

    /**
     * devuelve consulta con los talentos por proyecto
     * @param int $id
     * @return collection
     */
    public function talentosPorProyecto(int $id)
    {
        if (request()->ajax()) {
            $phase = [
                Fase::IsInicio(),
                Fase::IsPlaneacion(),
                Fase::IsEjecucion(),
            ];
            $nodeProject = Proyecto::findOrFail($id)->nodo_id;
            $projectTalent = Proyecto::select('proyectos.id as proyecto_id','proyectos.experto_id as asesor_id',
            'proyectos.nodo_id as nodo_id', 'proyectos.codigo_proyecto as codigo_model', 'proyectos.nombre as nombre_model',
            'user_nodo.linea_id as asesor_linea_id', 'user_nodo.honorarios', 'asesores.id as user_id', 'asesores.documento', 'asesores.nombres',
            'asesores.apellidos', 'nodos.id as nodo_id', 'lineastecnologicas.abreviatura', 'lineastecnologicas.id as linea_id',
            'lineastecnologicas.nombre as lineatecnologica_nombre')
                ->join('fases', 'fases.id', '=', 'proyectos.fase_id')
                ->join('users as asesores', 'asesores.id', '=', 'proyectos.experto_id')
                ->join('user_nodo',function ($join) {
                    $join->on('asesores.id', '=', 'user_nodo.user_id')
                    ->where('user_nodo.role', User::IsExperto());
                })
                ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'user_nodo.linea_id')
                ->join('nodos', 'nodos.id', '=', 'proyectos.nodo_id')
                ->whereIn('fases.id', $phase)
                ->findOrFail($id);

            $lines = LineaTecnologica::query()
                ->join('lineastecnologicas_nodos', 'lineastecnologicas_nodos.linea_tecnologica_id', '=', 'lineastecnologicas.id')
                ->where('lineastecnologicas_nodos.nodo_id', $nodeProject)
                ->get();

            $experts = User::query()
                        ->select('users.id', 'lineastecnologicas.id as lineatecnologica_id', 'lineastecnologicas.abreviatura', 'lineastecnologicas.nombre as lineatecnologica_nombre', 'users.documento', 'users.nombres', 'users.apellidos')
                        ->join('user_nodo',function ($join) {
                            $join->on('users.id', '=', 'user_nodo.user_id')
                            ->where('user_nodo.role', User::IsExperto());
                        })
                        ->join('lineastecnologicas', 'lineastecnologicas.id', 'user_nodo.linea_id')
                        ->where('lineastecnologicas.id', $projectTalent->asesor_linea_id)
                        ->where('user_nodo.nodo_id', $nodeProject)
                        ->where('users.id', '!=', $projectTalent->user_id)
                        ->where('users.estado', User::IsActive())
                        ->where('users.deleted_at', null)
                        ->get();

            $devices = Equipo::where('lineatecnologica_id', $projectTalent->asesor_linea_id)
                ->where('nodo_id', $nodeProject)
                ->get();

            $materials = Material::select('materiales.id as material_id', 'materiales.codigo_material', 'materiales.nombre as material_nombre', 'materiales.marca as material_marca', 'presentaciones.nombre as presentacion_nombre', 'medidas.nombre as medida_nombre')
                ->join('presentaciones', 'presentaciones.id', 'materiales.presentacion_id')
                ->join('medidas', 'medidas.id', 'materiales.medida_id')
                ->where('materiales.lineatecnologica_id', $projectTalent->asesor_linea_id)
                ->where('materiales.nodo_id', $nodeProject)
                ->where('materiales.estado', 1)
                ->get();

            $talents = User::select('users.id', 'users.documento', 'users.nombres', 'users.apellidos')
            ->join('proyecto_talento', 'proyecto_talento.user_id', '=', 'users.id')
            ->join('proyectos', 'proyectos.id', '=', 'proyecto_talento.proyecto_id')
            ->where('proyectos.id', $projectTalent->proyecto_id)
            ->withTrashed()->get();

            return response()->json([
                'proyecto'        => $projectTalent,
                'lineastecnologicas'           => $lines,
                'gestores'         => $experts,
                'equipos'         => $devices,
                'materiales'      => $materials,
                'talentos'        => $talents,
            ]);
        } else {
            abort('403');
        }
    }

    /**
     * devuelve consulta con los talentos por artculacion
     * @param int $id
     * @return collection
     */
    public function talentosPorArticulacion(int $id)
    {
        if (request()->ajax()) {
            $nodeArticulation = Articulation::findOrFail($id)->articulationstage->node->id;
            $phase = [
                Fase::IsInicio(),
                Fase::IsEjecucion(),
                Fase::IsCierre(),
            ];

            $articulation = Articulation::with([
                'articulationstage.createdBy'=> function($query){
                    $query->select('id', 'documento', 'nombres', 'apellidos');
                }])
                ->whereIn('phase_id', $phase)
                ->findOrFail($id);

            $lines = LineaTecnologica::join('lineastecnologicas_nodos', 'lineastecnologicas_nodos.linea_tecnologica_id', '=', 'lineastecnologicas.id')
                ->where('lineastecnologicas_nodos.nodo_id', $nodeArticulation)
                ->get();

            $devices = Equipo::where('nodo_id', $nodeArticulation)->get();

            $materials = Material::select('materiales.id as material_id', 'materiales.codigo_material', 'materiales.nombre as material_nombre', 'materiales.marca as material_marca', 'presentaciones.nombre as presentacion_nombre', 'medidas.nombre as medida_nombre')
                ->join('presentaciones', 'presentaciones.id', 'materiales.presentacion_id')
                ->join('medidas', 'medidas.id', 'materiales.medida_id')
                ->where('materiales.nodo_id', $nodeArticulation)
                ->get();

            $talents = $articulation->users()->get();

            return response()->json([
                'articulacion'       => $articulation,
                'lineastecnologicas' => $lines,
                'equipos'            => $devices,
                'materiales'         => $materials,
                'talentos' => $talents
            ]);
        } else {
            abort('403');
        }
    }

    public  function infoidea(int $id)
    {
        if (request()->ajax()) {
            $relations = [
                'estadoIdea'                => function ($query) {
                    $query->select('id', 'nombre');
                },
            ];
            $idea = $this->asesorieRepository->getIdeasForUser($relations)
                ->findOrFail($id);
            return response()->json([
                'idea'       => $idea,
            ]);
        } else {
            abort('403');
        }
    }
}
