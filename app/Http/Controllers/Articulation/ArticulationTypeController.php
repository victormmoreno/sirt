<?php

namespace App\Http\Controllers\Articulation;

use App\Models\ArticulationSubtype;
use App\User;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Entidad;
use App\Models\ArticulationType;
use App\Repositories\Repository\Articulation\ArticulationTypeRepository;
use App\Http\Requests\Articulation\ArticulationTypeRequest;
use Illuminate\Support\Facades\Validator;

class ArticulationTypeController extends Controller
{
    private $articulationTypeRepository;

    public function __construct(ArticulationTypeRepository $articulationTypeRepository)
    {
        $this->middleware(['auth']);
        $this->articulationTypeRepository = $articulationTypeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->user()->can('index', ArticulationType::class)) {
            if (request()->ajax()) {
                return $this->articulationTypeRepository->filterSupports($request);
            }
            return view('articulation-type.index');
        }
        alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
        return redirect()->route('home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (request()->user()->can('create', ArticulationType::class)) {
            return view('articulation-type.create');
        }
        alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
        return redirect()->route('home');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (request()->user()->can('create', ArticulationType::class)) {
            $req = new ArticulationTypeRequest;
            $validator = Validator::make($request->all(), $req->rules(), $req->messages());
            if ($validator->fails()) {
                return response()->json([
                    'fail' => true,
                    'errors' => $validator->errors(),
                    'message' => 'Estas ingresando mal los datos',
                    'redirect_url' => null,
                ]);
            }
            $result = $this->articulationTypeRepository->storeTypeArticulation($request);
            if (!$result) {
                return response()->json([
                    'fail' => true,
                    'errors' => $this->articulationTypeRepository->getError(),
                    'message' => 'Vuelve a intentarlo',
                    'redirect_url' => null,
                ]);
            }
            return response()->json([
                'fail' => false,
                'errors' => null,
                'message' => "Registro extioso",
                'redirect_url' => url(route('tipoarticulaciones.index')),
            ]);
        }
        alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int   $typeArticulation
     * @return \Illuminate\Http\Response
     */
    public function show( $typeArticulation)
    {
        if (request()->user()->can('show', ArticulationType::class)) {
            $typeArticulation = ArticulationType::query()->with('articulationsubtypes')->findOrFail($typeArticulation);
            return view('articulation-type.show', ['typeArticulation' => $typeArticulation]);
        }
        alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
        return redirect()->route('home');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $typeArticulation
     * @return \Illuminate\Http\Response
     */
    public function edit($typeArticulation)
    {
        if (request()->user()->cannot('edit', ArticulationType::class)) {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $typeArticulation = ArticulationType::findOrFail($typeArticulation);
        $nodos = Entidad::has('nodo')->orderBy('nombre')->get()->pluck('nombre', 'nodo.id');
        return view('articulation-type.edit', ['typeArticulation' => $typeArticulation, 'nodos' => $nodos]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $typeArticulation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $typeArticulation)
    {
        if (request()->user()->cannot('edit', ArticulationType::class)) {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $typeArticulation = ArticulationType::findOrFail($typeArticulation);
        $req       = new ArticulationTypeRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'fail' => true,
                'errors' => $validator->errors(),
                'message' => 'Estas ingresando mal los datos',
                'redirect_url' => null,
            ]);
        }
        $result = $this->articulationTypeRepository->updateTypeArticulation($request, $typeArticulation);
        if (!$result) {
            return response()->json([
                'fail'         => true,
                'errors'       => $this->articulationTypeRepository->getError(),
                'message' => 'Vuelve a intentarlo',
                'redirect_url' => null,
            ]);
        }
        return response()->json([
            'fail'         => false,
            'errors'       => null,
            'message' => "Actualización Exitosa",
            'redirect_url' => url(route('tipoarticulaciones.index')),
        ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $typeArticulation
     * @return \Illuminate\Http\Response
     */
    public function destroy($typeArticulation)
    {
        if (request()->user()->cannot('destroy', ArticulationType::class)) {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $typeArticulation = ArticulationType::findOrFail($typeArticulation);
        if($typeArticulation->articulationsubtypes->count() > 0 ){
            return response()->json([
                'fail'         => true,
                'redirect_url' => route('tipoarticulaciones.show', $typeArticulation->id),
            ]);
        }
        $typeArticulation->delete();
        return response()->json([
            'fail'         => false,
            'redirect_url' => route('tipoarticulaciones.index'),
        ]);
    }

    public function filterArticulationType($articulationType)
    {
        $node = $this->checkRoleAuth()['node'];
        $articulationSubtypes = ArticulationSubtype::query()
            ->where('state', ArticulationSubtype::mostrar())
            ->nodeForRole($node, User::IsArticulador())
            ->where('articulation_type_id', $articulationType)->get();
        if(request()->ajax()){
            return response()->json([
                'data' => $articulationSubtypes
            ]);
        }
        alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
        return redirect()->route('home');
    }

    /**
     * method to validate the authenticated role
     * @return void
     */
    private function checkRoleAuth()
    {
        $talent = null;
        $node = null;
        switch (\Session::get('login_role')) {
            case User::IsAdministrador():
                $node = null;
                break;
            case User::IsActivador():
                $node = null;
                break;
            case User::IsDinamizador():
                $node = auth()->user()->dinamizador->nodo_id;
                break;
            case User::IsArticulador():
                $node = auth()->user()->articulador->nodo_id;
                break;
            default:
                $node = null;
                break;
        }
        return ['node' => $node];
    }
}
