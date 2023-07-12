<?php

namespace App\Http\Controllers\Asesorie;

use App\Http\Controllers\Controller;
use App\Http\Requests\Asesorie\AsesorieRequest;
use App\Models\{Articulation,
    Idea,
    UsoInfraestructura,
    Proyecto,
    Nodo,
    Fase};
use App\Datatables\AsesorieDatatable;
use App\Repositories\Repository\{LineaRepository, ProyectoRepository,  AsesorieRepository};
use App\Repositories\Repository\Articulation\ArticulationRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Exports\Asesorie\AsesorieExport;

class AsesorieController extends Controller
{
    private $asesorieRepository;
    private $projectRepository;
    private $articulationRepository;
    private $lineRepository;

    public function __construct(
        AsesorieRepository $asesorieRepository,
        ProyectoRepository $projectRepository,
        ArticulationRepository $articulationRepository,
        LineaRepository $lineRepository
    ) {
        $this->asesorieRepository = $asesorieRepository;
        $this->projectRepository = $projectRepository;
        $this->articulationRepository = $articulationRepository;
        $this->lineRepository = $lineRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->user()->cannot('index', UsoInfraestructura::class)) {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $nodes = null;
        $modules = null;
        if(request()->user()->can('listNodes', UsoInfraestructura::class)) {
            $nodes = Nodo::SelectNodo()->get();
        }
        if(request()->user()->can('moduleType', UsoInfraestructura::class)) {
            switch(session()->get('login_role')){
                case User::IsAdministrador():
                    $modules = [
                        class_basename(Proyecto::class) => __('Projects'),
                        class_basename(Articulation::class) => __('Articulations'),
                        class_basename(Idea::class) => __('Ideas')
                    ];
                    break;
                case User::IsActivador():
                    $modules = [
                        class_basename(Proyecto::class) => __('Projects'),
                        class_basename(Articulation::class) => __('Articulations'),
                        class_basename(Idea::class) => __('Ideas')
                    ];
                    break;
                case User::IsDinamizador():
                    $modules = [
                        class_basename(Proyecto::class) => __('Projects'),
                        class_basename(Articulation::class) => __('Articulations'),
                        class_basename(Idea::class) => __('Ideas')
                    ];
                    break;
                case User::IsExperto():
                    $modules = [
                        class_basename(Proyecto::class) => __('Projects'),
                    ];
                    break;
                case User::IsArticulador():
                    $modules = [
                        class_basename(Articulation::class) => __('Articulations'),
                        class_basename(Idea::class) => __('Ideas')
                    ];
                    break;
                case User::IsTalento():
                    $modules = [
                        class_basename(Proyecto::class) => __('Projects'),
                        class_basename(Articulation::class) => __('Articulations')
                    ];
                    break;
                default:
                    $modules = [];
                    break;
            }
        }
        return view('asesorias.index', [
            'nodos' => $nodes,
            'modules' => $modules
        ]);
    }

    /**
     * method to show return the datatables asesories
     * @return void
     */
    public function datatableFiltros(Request $request, AsesorieDatatable $asesorieDatatable)
    {
        if (request()->ajax() && request()->user()->cannot('index', UsoInfraestructura::class)) {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return $asesorieDatatable->indexDatatable([]);
        }
        $asesor = $this->checkRoleAuth($request)['user'];
        $node = $this->checkRoleAuth($request)['node'];
        $model = $this->checkRoleAuth($request)['model'];

        $asesories = [];
        if (isset($request->filter_module) || isset($request->filter_node) || isset($request->filter_start_date) || isset($request->filter_end_date)) {
            $asesories = $this->asesorieRepository->getListAsesories()
            ->selectAsesoria($model)
            ->joins($model)
            ->node($model, $node)
            ->betweenDate($request->filter_start_date, $request->filter_end_date)
            ->asesor($model,$asesor)
            ->groupBy('usoinfraestructuras.id')
            ->orderBy('usoinfraestructuras.updated_at', 'desc')
            ->get();
        }
        return $asesorieDatatable->indexDatatable($asesories);
    }

    /**
     * method to validate the authenticated role
     * @return void
     */
    private function checkRoleAuth($request)
    {
        $user = null;
        $node = null;
        $model = null;
        switch (\Session::get('login_role')) {
            case User::IsAdministrador():
                $node = $request->filter_nodo;
                $model = $request->filter_module;
                break;
            case User::IsActivador():
                $node = $request->filter_nodo;
                $model = $request->filter_module;
                break;
            case User::IsDinamizador():
                $node = [auth()->user()->dinamizador->nodo_id];
                $model = $request->filter_module;
                break;
            case User::IsArticulador():
                $node = [auth()->user()->articulador->nodo_id];
                $model = $request->filter_module;
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
                $model = $request->filter_module;
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        $asesorie = UsoInfraestructura::query()
        ->with(['participantes'=> function($query){
                $query->withTrashed();
            },
            'asesores' => function($query){
                $query->withTrashed();
            },
            'usoequipos'
        ])
        ->where('codigo', $code)->firstOrFail();
        if (request()->user()->cannot('show',$asesorie)) {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->back();
        }
        $devices = [];
        if ($asesorie->has('usoequipos')) {
            $devices = $asesorie->usoequipos()->withTrashed()->get();
        }
        $totalCosts = 0;
        $totalCosts = $asesorie->usoequipos->sum('pivot.costo_equipo') + $asesorie->asesores->sum('pivot.costo_asesoria') + $asesorie->usoequipos->sum('pivot.costo_administrativo') + $asesorie->usomateriales->sum('pivot.costo_material');

        return view('asesorias.show', [
            'asesorie' => $asesorie,
            'devices' => $devices,
            'totalCosts' => $totalCosts,
        ]);
    }

    public function destroy(int $id)
    {
        $usoinfraestructura = UsoInfraestructura::findOrFail($id);
        if (request()->user()->cannot('destroy',$usoinfraestructura)) {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->back();
        }
        $usoinfraestructura->usoequipos()->detach();
        $usoinfraestructura->participantes()->detach();
        $usoinfraestructura->usomateriales()->detach();
        $usoinfraestructura->asesores()->detach();
        $usoinfraestructura->delete();
        return response()->json([
            'usoinfraestructura' => 'success',
            'route' => route('asesorias.index')
        ]);
    }

    public function export(Request $request, $extension = 'xlsx')
    {
        if (request()->user()->cannot('export',UsoInfraestructura::class)) {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $asesor = $this->checkRoleAuth($request)['user'];
        $node = $this->checkRoleAuth($request)['node'];
        $model = $this->checkRoleAuth($request)['model'];

        $asesories = [];
        if (isset($request->filter_module) || isset($request->filter_node) || isset($request->filter_start_date) || isset($request->filter_end_date)) {
            $asesories = $this->asesorieRepository->getListAsesories()
            ->selectAsesoria($model)
            ->selectRaw("usoinfraestructuras.descripcion, usoinfraestructuras.compromisos")
            ->selectRaw("GROUP_CONCAT(DISTINCT CONCAT(equipos.referencia, ' - ', equipos.nombre) SEPARATOR ';') as equipos,
            GROUP_CONCAT(DISTINCT CONCAT(materiales.codigo_material, ' - ', materiales.nombre) SEPARATOR ';') as materiales")
            ->joins($model)
            ->leftJoin('equipo_uso', function ($join) {
                        $join->on('equipo_uso.usoinfraestructura_id', '=', 'usoinfraestructuras.id');
                    })->leftJoin('equipos', function ($join) {
                        $join->on('equipos.id', '=', 'equipo_uso.equipo_id');
                    })->leftJoin('material_uso', function ($join) {
                        $join->on('material_uso.usoinfraestructura_id', '=', 'usoinfraestructuras.id');
                    })->leftJoin('materiales', function ($join) {
                        $join->on('materiales.id', '=', 'material_uso.material_id');
                    })
            ->node($model, $node)
            ->betweenDate($request->filter_start_date, $request->filter_end_date)
            ->asesor($model,$asesor)
            ->groupBy('usoinfraestructuras.id')
            ->orderBy('usoinfraestructuras.updated_at', 'desc')
            ->get();
        }
        return (new AsesorieExport($request, $asesories))->download("Asesorias" . config('app.name') . ".{$extension}");
    }
}
