<?php

namespace App\Http\Controllers\Asesorie;

use App\Http\Controllers\Controller;
use App\Repositories\Repository\{LineaRepository, ProyectoRepository,  AsesorieRepository};
use App\Repositories\Repository\Articulation\ArticulationRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UsoInfraestructura\UsoInfraestructuraFormRequest;

class AsesorieRegisterController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (request()->user()->cannot('create',UsoInfraestructura::class)) {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->back();
        }
        $sumasArray   = [];
        $date         = Carbon::now()->format('Y-m-d');
        switch (\Session::get('login_role')) {
            case User::IsExperto():
                $projects     = $this->getDataProjectsForUser()->count();
                $sumasArray = ['projects'=> $projects];
                $cantActividades = array_sum($sumasArray);
                $relations = [
                    'user'             => function ($query) {
                        $query->select('id', 'documento', 'nombres', 'apellidos');
                    },
                    'lineatecnologica' => function ($query) {
                        $query->select('id', 'nombre', 'abreviatura');
                    },
                ];
                $user             = auth()->user()->id;
                $nodo             = auth()->user()->experto->nodo->id;
                $gestores         = $this->getGestorRepository()->getInfoGestor($relations)
                    ->whereHas('user', function ($query) use ($user) {
                        $query->where('id', '!=', $user)->where('estado', User::IsActive());
                    })
                    ->whereHas('nodo', function ($query) use ($nodo) {
                        $query->where('id', $nodo);
                    })->get();
                $lineastecnologicas = $this->getLineaTecnologicaRepository()->findLineasByIdNameForNodo($nodo);
                break;
            case User::IsArticulador():
                $artulaciones = 0;
                $sumasArray = [
                    'articulaciones' => $artulaciones,
                    'ideas' => 1
                ];
                $cantActividades = array_sum($sumasArray);
                $relations = [
                    'user'             => function ($query) {
                        $query->select('id', 'documento', 'nombres', 'apellidos');
                    },
                    'lineatecnologica' => function ($query) {
                        $query->select('id', 'nombre', 'abreviatura');
                    },
                ];
                $user             = auth()->user()->id;
                $nodo             = auth()->user()->articulador->nodo->id;
                $gestores         = $this->getGestorRepository()->getInfoGestor($relations)
                    ->whereHas('user', function ($query) use ($user) {
                        $query->where('id', '!=', $user)->where('estado', User::IsActive());
                    })
                    ->whereHas('nodo', function ($query) use ($nodo) {
                        $query->where('id', $nodo);
                    })->get();
                $lineastecnologicas = $this->getLineaTecnologicaRepository()->findLineasByIdNameForNodo($nodo);
                break;
            case User::IsApoyoTecnico():
                $projects     = $this->getDataProjectsForUser()->count();
                $sumasArray = [
                    'projects'       => $projects,
                ];
                $cantActividades = array_sum($sumasArray);
                $relations = [
                    'user'             => function ($query) {
                        $query->select('id', 'documento', 'nombres', 'apellidos');
                    },
                    'lineatecnologica' => function ($query) {
                        $query->select('id', 'nombre', 'abreviatura');
                    },
                ];
                $user             = auth()->user()->id;
                $nodo             = auth()->user()->apoyotecnico->nodo->id;
                $gestores         = $this->getGestorRepository()->getInfoGestor($relations)
                    ->whereHas('user', function ($query) use ($user) {
                        $query->where('id', '!=', $user)->where('estado', User::IsActive());
                    })
                    ->whereHas('nodo', function ($query) use ($nodo) {
                        $query->where('id', $nodo);
                    })->get();
                $lineastecnologicas = $this->getLineaTecnologicaRepository()->findLineasByIdNameForNodo($nodo);
                break;
            case User::IsTalento():
                $projects     = $this->getDataProjectsForUser()->count();
                $sumasArray = [
                    'projects'       => $projects,
                ];
                $cantActividades = array_sum($sumasArray);
                return view('asesorias.create', [
                    'date'                => $date,
                    'cantidadActividades' => $cantActividades,
                ]);
                break;
            default:
                return abort('403');
                break;
        }

        return view('asesorias.create', [
            'gestores'            => $gestores,
            'lineastecnologicas'  => $lineastecnologicas,
            'date'                => $date,
            'cantidadActividades' => $cantActividades,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (request()->user()->cannot('create',UsoInfraestructura::class)) {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->back();
        }
        $req       = new UsoInfraestructuraFormRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'fail'   => true,
                'errors' => $validator->errors(),
            ]);
        }
        $result = $this->getUsoInfraestructuraRepository()->storeUsoInfraestructuraProyecto($request);
        if ($result == 'false') {
            return response()->json([
                'fail'         => false,
                'redirect_url' => false,
            ]);
        } else if ($result == 'true') {
            return response()->json([
                'fail'         => false,
                'redirect_url' => url(route('usoinfraestructura.index')),
            ]);
        }
    }
}
