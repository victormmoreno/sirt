<?php

namespace App\Http\Controllers\Asesorie;

use App\Http\Controllers\Controller;
use App\Repositories\Repository\{LineaRepository, ProyectoRepository,  AsesorieRepository};
use App\Repositories\Repository\Articulation\ArticulationRepository;
use App\User;
use App\Models\UsoInfraestructura;
use App\Models\Fase;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Asesorie\AsesorieRequest;

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
    public function showForm()
    {
        // if (!request()->user()->cannot('create', UsoInfraestructura::class)) {
        //     alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
        //     return redirect()->back();
        // }
        $sumasArray   = [];
        $date         = Carbon::now()->format('Y-m-d');
        switch (\Session::get('login_role')) {
            case User::IsExperto():
                $projects     = $this->asesorieRepository->getDataProjectsForUser()->count();
                $sumasArray = ['projects'=> $projects];
                $countModel = array_sum($sumasArray);
                $user             = auth()->user()->id;
                $nodo             = auth()->user()->experto->nodo_id;
                $experts         = User::consultarFuncionarios($nodo, User::IsExperto())
                                        ->where('users.id', '!=', $user)
                                        ->get();
                $lineastecnologicas = $this->lineRepository->findLineasByIdNameForNodo($nodo);
                break;
            case User::IsArticulador():
                $artulaciones = 0;
                $sumasArray = [
                    'articulaciones' => $artulaciones,
                    'ideas' => 1
                ];
                $countModel = array_sum($sumasArray);

                $user             = auth()->user()->id;
                $nodo             = auth()->user()->articulador->nodo->id;
                $experts         = User::consultarFuncionarios($nodo, User::IsExperto())
                                        ->where('users.id', '!=', $user)
                                        ->get();
                $lineastecnologicas = $this->lineRepository->findLineasByIdNameForNodo($nodo);
                break;
            case User::IsApoyoTecnico():
                $projects     = $this->asesorieRepository->getDataProjectsForUser()->count();
                $sumasArray = [
                    'projects'       => $projects,
                ];
                $countModel = array_sum($sumasArray);

                $user             = auth()->user()->id;
                $nodo             = auth()->user()->apoyotecnico->nodo->id;
                $experts         = User::ConsultarFuncionarios($nodo, User::IsExperto())
                                        ->where('users.id', '!=', $user)
                                        ->get();
                $lineastecnologicas = $this->lineRepository->findLineasByIdNameForNodo($nodo);
                break;
            case User::IsTalento():
                $projects     = $this->asesorieRepository->getDataProjectsForUser()->count();
                $sumasArray = [
                    'projects'       => $projects,
                ];
                $countModel = array_sum($sumasArray);
                return view('asesorias.create', [
                    'date'                => $date,
                    'countModel' => $countModel,
                ]);
                break;
            default:
                return abort('403');
                break;
        }

        return view('asesorias.create', [
            'experts'            => $experts,
            'lineastecnologicas'  => $lineastecnologicas,
            'date'                => $date,
            'countModel' => $countModel,
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

        // if (request()->user()->cannot('create',UsoInfraestructura::class)) {
        //     alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
        //     return redirect()->back();
        // }
        $req       = new AsesorieRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'fail'   => true,
                'errors' => $validator->errors(),
            ]);
        }
        $response = $this->asesorieRepository->store($request);

        if (!$response) {
            return response()->json([
                'fail'         => false,
                'message'      => 'Error al registrar la asesoria',
                'redirect_url' => false,
            ]);
        } else {
            return response()->json([
                'fail'         => false,
                'message'      => 'Registro exitoso',
                'redirect_url' => url(route('asesorias.index')),
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $code
     * @return \Illuminate\Http\Response
     */
    public function edit($code)
    {
        $asesorie = UsoInfraestructura::with(
            ['participantes'=> function($query){
                $query->withTrashed();
            },'asesores' => function($query){
                $query->withTrashed();
            }]
        )->where('codigo', $code)->firstOrFail();
        if (request()->user()->cannot('update',$asesorie)) {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->back();
        }
        $devices = [];
        if ($asesorie->has('usoequipos')) {
            $devices = $asesorie->usoequipos()->withTrashed()->get();
        }
        $date = Carbon::now()->format('Y-m-d');
        switch (\Session::get('login_role')) {
            case User::IsExperto():
                $projects     = $this->asesorieRepository->getDataProjectsForUser()->count();
                $sumasArray = ['projects'=> $projects];
                $countModel = array_sum($sumasArray);
                $user             = auth()->user()->id;
                $nodo             = auth()->user()->experto->nodo_id;
                $experts         = User::consultarFuncionarios($nodo, User::IsExperto())
                                        ->where('users.id', '!=', $user)
                                        ->get();
                $lineastecnologicas = $this->lineRepository->findLineasByIdNameForNodo($nodo);
                break;
            case User::IsArticulador():
                $artulaciones = 0;
                $sumasArray = [
                    'articulaciones' => $artulaciones,
                    'ideas' => 1
                ];
                $countModel = array_sum($sumasArray);

                $user             = auth()->user()->id;
                $nodo             = auth()->user()->articulador->nodo->id;
                $experts         = User::consultarFuncionarios($nodo, User::IsExperto())
                                        ->where('users.id', '!=', $user)
                                        ->get();
                $lineastecnologicas = $this->lineRepository->findLineasByIdNameForNodo($nodo);
                break;
            case User::IsApoyoTecnico():
                $projects     = $this->asesorieRepository->getDataProjectsForUser()->count();
                $sumasArray = [
                    'projects'       => $projects,
                ];
                $countModel = array_sum($sumasArray);

                $user             = auth()->user()->id;
                $nodo             = auth()->user()->apoyotecnico->nodo->id;
                $experts         = User::ConsultarFuncionarios($nodo, User::IsExperto())
                                        ->where('users.id', '!=', $user)
                                        ->get();
                $lineastecnologicas = $this->lineRepository->findLineasByIdNameForNodo($nodo);
                break;
            case User::IsTalento():
                $projects     = $this->asesorieRepository->getDataProjectsForUser()->count();
                $sumasArray = [
                    'projects'       => $projects,
                ];
                $countModel = array_sum($sumasArray);
                return view('asesorias.edit', [
                    'date'                => $date,
                    'countModel' => $countModel,
                    'asesorie' => $asesorie,
                    'equipos' => $devices
                ]);
                break;
            default:
                return abort('403');
                break;
        }

        return view('asesorias.edit', [
            'asesorie' => $asesorie,
            'experts'            => $experts,
            'lineastecnologicas'  => $lineastecnologicas,
            'equipos' => $devices,
            'date'               => $date,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        $usoinfraestructura = UsoInfraestructura::findOrFail($id);
        if (request()->user()->cannot('update',$usoinfraestructura)) {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->back();
        }
        $req       = new AsesorieRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());

        if ($validator->fails()) {
            return response()->json([
                'fail'   => true,
                'errors' => $validator->errors(),
            ]);
        }

        $result = $this->asesorieRepository->update($request, $id);

        if ($result == false) {
            return response()->json([
                'fail'         => false,
                'redirect_url' => false,
            ]);
        } else if ($result == true) {
            return response()->json([
                'fail'         => false,
                'redirect_url' => url(route('asesorias.index')),
            ]);
        }
    }
}
