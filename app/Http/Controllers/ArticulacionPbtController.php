<?php

namespace App\Http\Controllers;

use App\Models\ArticulacionPbt;
use App\Models\Fase;
use App\Models\Entidad;
use App\Models\AlcanceArticulacion;
// use App\Models\TipoArticulacion;
use App\User;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\{Facades\Session, Facades\Validator};
use Illuminate\Http\{Request, Response};
use App\Http\Requests\ArticulacionPbt\{ArticulacionFaseInicioFormRequest, ArticulacionFaseCierreFormRequest, ArticulacionMiembrosFormRequest};
use App\Repositories\Repository\ArticulacionPbtRepository;
use App\Exports\ArticulacionesPbt\ArticulacionesPbtExport;
use App\Repositories\Repository\UserRepository\UserRepository;


class ArticulacionPbtController extends Controller
{
    private $articulacionPbtRepository;

    public function __construct(ArticulacionPbtRepository $articulacionPbtRepository)
    {
        $this->setArticulacionRepository($articulacionPbtRepository);
        $this->middleware(['auth']);
    }

    /**
     * Asigna un valor a $articulacionPbtRepository
     * @param object $articulacionPbtRepository
     * @return void type
     * @author devjul
     */
    private function setArticulacionRepository($articulacionPbtRepository)
    {
        $this->articulacionPbtRepository = $articulacionPbtRepository;
    }

    /**
     * Retorna el valor de $articulacionPbtRepository
     * @return object
     * @author devjul
     */
    private function getArticulacionRepository()
    {
        return $this->articulacionPbtRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
            $this->authorize('index', ArticulacionPbt::class);
            $nodos = Entidad::has('nodo')->orderBy('nombre')->get()->pluck('nombre', 'nodo.id');
            $fases = Fase::orderBy('id')->whereNotIn('id', [Fase::IsPlaneacion()])->pluck('nombre', 'id');
            $alcances = AlcanceArticulacion::orderBy('nombre')->pluck('nombre', 'id');
            // $tipoarticulaciones = TipoArticulacion::orderBy('nombre')->pluck('nombre', 'id');
            return view('articulacionespbt.index', ['nodos' => $nodos, 'fases' => $fases, 'alcances' => $alcances, 'tipoarticulaciones' => []]);
    }

    public function datatableFiltros(Request $request)
    {
        $this->authorize('datatable', ArticulacionPbt::class);
        $talent = null;
        switch (\Session::get('login_role')) {
            case User::IsAdministrador():
                $nodo = $request->filter_nodo_art;
                $user = null;
                break;
            case User::IsDinamizador():
                $nodo = auth()->user()->dinamizador->nodo_id;
                $user = null;
                break;
            case User::IsArticulador():
                $nodo = auth()->user()->articulador->nodo_id;
                $user = auth()->user()->id;
                break;
            case User::IsTalento():
                $nodo = null;
                $user = null;
                $talent = auth()->user()->talento->id;
                break;
            default:
                return abort('403');
                break;
        }

        $articulaciones = [];
        if (!empty($request->filter_year_art) && !empty($request->filter_phase)  && !empty($request->filter_tipo_articulacion) && !empty($request->filter_tipo_articulacion) && !empty($request->filter_alcance_articulacion)) {

            $articulaciones =  ArticulacionPbt::with([
                'fase',
                'tipoarticulacion' => function($query){
                    $query->select('id', 'nombre');
                },
                'alcancearticulacion'=> function($query){
                    $query->select('id', 'nombre');
                },
                'asesor',
                'nodo',
                'nodo.entidad'
            ])
            ->tipoArticulacion($request->filter_tipo_articulacion)
            ->alcanceArticulacion($request->filter_alcance_articulacion)
            ->fase($request->filter_phase)
            ->nodo($nodo)
            ->asesor($user)
            ->starEndDate($request->filter_year_art)
            ->talents($talent)
            ->orderBy('created_at', 'desc')
            ->get();
        }
        return $this->datatableArticulaciones($articulaciones);
    }

    private function datatableArticulaciones($articulaciones)
    {
        return datatables()->of($articulaciones)
        ->editColumn('nodo', function ($data) {
            if (isset($data->nodo->entidad)) {
                return $data->nodo->entidad->nombre;
            }
            return "No registra";
        })
        ->editColumn('codigo_articulacion', function ($data) {
            if (isset($data->codigo)) {
                return $data->codigo;
            }
            return "No registra";
        })
        ->editColumn('nombre_articulacion', function ($data) {
            if (isset($data->nombre)) {
                return "{$data->nombre}";
            }
            return "No registra";
        })
        ->editColumn('articulador', function ($data) {
            if (isset($data->asesor)) {
                return "{$data->asesor->nombres} {$data->asesor->apellidos}";
            }
            return "No registra";
        })
        ->editColumn('fase', function ($data) {
            if (isset($data->fase)) {
                return $data->fase->nombre;
            }
            return "No registra";
        })
        ->editColumn('starDate', function ($data) {
            if (isset($data->created_at)) {
                return  $data->created_at->isoFormat('DD/MM/YYYY');
            }
            return "No registra";


        })->addColumn('show', function ($data) {
            $info = '<a class="btn m-b-xs modal-trigger" href='.route('articulaciones.show', $data->id).'>
            <i class="material-icons">search</i>
            </a>';
                return $info;
        })->rawColumns(['nodo','codigo_articulacion','nombre_articulacion','articulador','fase','starDate',  'show'])->make(true);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', ArticulacionPbt::class);
        $alcances = AlcanceArticulacion::orderBy('nombre')->pluck('nombre', 'id');
        // $tipoarticulaciones = TipoArticulacion::orderBy('nombre')->pluck('nombre', 'id');
        return view('articulacionespbt.create',  ['alcances' => $alcances, 'tipoarticulaciones' => []]);
        return abort('403');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('store', ArticulacionPbt::class);
        $req = new ArticulacionFaseInicioFormRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'state'   => 'error_form',
                'errors' => $validator->errors(),
            ]);
        } else {
            $response = $this->getArticulacionRepository()->store($request);
            if ($response != null) {
                return response()->json([
                    'data' => $response,
                    'url' => route('articulaciones.show', $response->id),
                    'status_code' => Response::HTTP_CREATED,
                ], Response::HTTP_CREATED);
            } else {
                return response()->json(['status_code' => Response::HTTP_NOT_FOUND]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $articulacion = ArticulacionPbt::where('id', $id)->firstOrFail();
        $this->authorize('show', ArticulacionPbt::class);
        return view('articulacionespbt.show', ['articulacion' =>$articulacion]);
    }

    /**
     * Update the fase inicio specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $req = new ArticulacionFaseInicioFormRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'state'   => 'error_form',
                'errors' => $validator->errors(),
            ]);
        } else {

            $response = $this->getArticulacionRepository()->updateInicio($request, $id);
            if ($response != null) {
                return response()->json([
                    'data' => $response,
                    'url' => route('articulaciones.show', $response->id),
                    'status_code' => Response::HTTP_CREATED,
                ], Response::HTTP_CREATED);
            } else {
                return response()->json(['status_code' => Response::HTTP_NOT_FOUND]);
            }
        }
    }

    /**
     * Modifica los cambios de la fase de ejecución
     * @param Request $request
     * @param int $id id de la articulacion
     * @return Response
     * @author devjul
     **/
    public function updateEjecucion(Request $request, $id)
    {
        $response = $this->getArticulacionRepository()->updateEntregablesEjecucionRepository($request, $id);
        if ($response != null) {
            Alert::success('Modificación Exitosa!', 'Los entregables de la articulación en la fase de ejecución se han modificado!')->showConfirmButton('Ok', '#3085d6');
            return redirect()->route('articulaciones.show', $response->id);
        } else {
            Alert::error('Modificación Errónea!', 'Los entregables de la articulación en la fase de ejecución no se han modificado!')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
    }

    /**
     * Display the specified resource of talents.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function filterTalento($documento)
    {
        $user = User::withTrashed()
        ->with(['talento'])
        ->role(User::IsTalento())
        ->where('documento', $documento)
        ->first();

        if (request()->ajax()) {

            if($user != null){
                return response()->json([
                    'data' => [
                        'user' => $user,
                        'status_code' => Response::HTTP_OK
                    ]
                ],Response::HTTP_OK);
            }

            return response()->json([
                'data' => [
                    'user' => null,
                    'status_code' => Response::HTTP_NOT_FOUND,
                ]
            ]);
        }
        return view('users.show', ['user' => $user]);
    }

    public function showFaseInicioArticulacion($id){
        $articulacion = ArticulacionPbt::where('id', $id)->firstOrFail();

        $ultimo_movimiento = $articulacion->historial->last();

        $alcances = AlcanceArticulacion::orderBy('nombre')->pluck('nombre', 'id');
        // $tipoarticulaciones = TipoArticulacion::orderBy('nombre')->pluck('nombre', 'id');

        switch (Session::get('login_role')) {
            case User::IsArticulador():
                return view('articulacionespbt.articulador.fase_inicio', ['articulacion' =>$articulacion, 'alcances' => $alcances, 'tipoarticulaciones' => [], 'ultimo_movimiento' => $ultimo_movimiento]);
                break;

            case User::IsDinamizador():
                return view('articulacionespbt.dinamizador.fase_inicio', ['articulacion' =>$articulacion, 'alcances' => $alcances, 'tipoarticulaciones' => [], 'ultimo_movimiento' => $ultimo_movimiento]);
                break;

            case User::IsTalento():
                return view('articulacionespbt.talento.fase_inicio', ['articulacion' =>$articulacion, 'alcances' => $alcances, 'tipoarticulaciones' => [], 'ultimo_movimiento' => $ultimo_movimiento]);
                break;
            default:
                return abort(Response::HTTP_FORBIDDEN);
                break;
        }
    }



    public function showFaseEjecucionArticulacion($id){
        $articulacion = ArticulacionPbt::where('id', $id)->firstOrFail();


        $ultimo_movimiento = $articulacion->historial->last();

        $alcances = AlcanceArticulacion::orderBy('nombre')->pluck('nombre', 'id');
        // $tipoarticulaciones = TipoArticulacion::orderBy('nombre')->pluck('nombre', 'id');

        switch (Session::get('login_role')) {
            case User::IsArticulador():
                return view('articulacionespbt.articulador.fase_ejecucion', ['articulacion' =>[], 'alcances' => $alcances, 'tipoarticulaciones' => [], 'ultimo_movimiento' => $ultimo_movimiento]);
                break;

            case User::IsDinamizador():
                return view('articulacionespbt.dinamizador.fase_ejecucion', ['articulacion' =>[], 'alcances' => $alcances, 'tipoarticulaciones' => [], 'ultimo_movimiento' => $ultimo_movimiento]);
                break;

            case User::IsTalento():
                return view('articulacionespbt.talento.fase_ejecucion', ['articulacion' =>[], 'alcances' => $alcances, 'tipoarticulaciones' => [], 'ultimo_movimiento' => $ultimo_movimiento]);
                break;
            default:
                return abort(Response::HTTP_FORBIDDEN);
                break;
        }
    }

    public function showFaseCierreArticulacion($id)
    {
        $articulacion = ArticulacionPbt::where('id', $id)->firstOrFail();
        $ultimo_movimiento = $articulacion->historial->last();

        $alcances = AlcanceArticulacion::orderBy('nombre')->pluck('nombre', 'id');
        // $tipoarticulaciones = TipoArticulacion::orderBy('nombre')->pluck('nombre', 'id');

        switch (Session::get('login_role')) {
            case User::IsArticulador():
                return view('articulacionespbt.articulador.fase_cierre', ['articulacion' =>$articulacion, 'alcances' => $alcances, 'tipoarticulaciones' => [], 'ultimo_movimiento' => $ultimo_movimiento]);
                break;

            case User::IsDinamizador():
                return view('articulacionespbt.dinamizador.fase_cierre', ['articulacion' =>$articulacion, 'alcances' => $alcances, 'tipoarticulaciones' => [], 'ultimo_movimiento' => $ultimo_movimiento]);
                break;

            case User::IsTalento():
                return view('articulacionespbt.talento.fase_cierre', ['articulacion' =>$articulacion, 'alcances' => $alcances, 'tipoarticulaciones' => [], 'ultimo_movimiento' => $ultimo_movimiento]);
                break;

            default:
                return abort(Response::HTTP_FORBIDDEN);
                break;
        }
    }

    public function entregablesInicio($id){
        $articulacion = ArticulacionPbt::where('id', $id)->firstOrFail();
        return view('articulacionespbt.entregables.entregables-inicio', ['articulacion' =>$articulacion]);
    }

    /**
     * modifica los entregables de una articulacion
     *
     * @param Request $request
     * @param int $id Id de la articulacion
     * @return Response
     * @author devjul
     */
    public function updateEntregables(Request $request, $id)
    {
        $this->authorize('updateEntregable', ArticulacionPbt::class);
        $update = $this->getArticulacionRepository()->updateEntregablesInicioArticulacon($request, $id);
        if ($update != null) {
            Alert::success('Modificación Exitosa!', 'Los entregables de la articulación se han modificado!')->showConfirmButton('Ok', '#3085d6');
            return redirect()->route('articulacion.show.inicio', $update->id);
        } else {
            Alert::error('Modificación Errónea!', 'Los entregables de la articulación no se han modificado!')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
    }

    /**
     * Notifica al talento interlocutor para que apruebe el proyecto en la fase de inicio
     *
     * @param int $id id de la articulacion
     * @return Response
     * @author devjul
     */
    public function solicitar_aprobacion(int $id, string $fase)
    {
        $notificacion = $this->getArticulacionRepository()->notificarAlTalento($id, $fase);

        if ($notificacion) {
            Alert::success('Notificación Exitosa!', 'Se le ha enviado una notificación al talento para que apruebe la fase de ' . $fase . ' de la articulación!')->showConfirmButton('Ok', '#3085d6');
        } else {
            Alert::error('Notificación Errónea!', 'No se le ha enviado una notificación al talento para que apruebe la fase de ' . $fase . ' de la articulación!')->showConfirmButton('Ok', '#3085d6');
        }
        return back();
    }

    /**
     * Gestionar la aprobación de una fase de la articulación
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @param  string $fase Fase que se está aprobando
     * @return \Illuminate\Http\Response
     */
    public function gestionarAprobacion(Request $request, $id, $fase)
    {
        $fase = nameFase($fase);
        $update = $this->getArticulacionRepository()->aprobacionFase($request, $id, $fase);

        if ($update['state']) {
            Alert::success($update['title'], $update['mensaje'])->showConfirmButton('Ok', '#3085d6');
            return redirect()->route('articulaciones.show', $update['data']->id);
        } else {
            Alert::error($update['title'], $update['mensaje'])->showConfirmButton('Ok', '#3085d6');
            return back();
        }
    }

    /**
     * Vista para suspender una articulacion
     *
     * @param int $id Id de la articulación
     * @return Response
     * @author devjul
     **/
    public function suspender(int $id)
    {

        $articulacion = ArticulacionPbt::where('id', $id)->firstOrFail();

        $ultimo_movimiento = $articulacion->historial->last();
        switch (Session::get('login_role')) {
            case User::IsArticulador():
                return view('articulacionespbt.articulador.fase_suspendido', [
                    'articulacion' => $articulacion,
                    'ultimo_movimiento' => $ultimo_movimiento
                ]);
                break;

            case User::IsDinamizador():

                return view('articulacionespbt.dinamizador.fase_suspendido', [
                    'articulacion' => $articulacion,
                    'ultimo_movimiento' => $ultimo_movimiento
                ]);
                break;
            default:
                return abort(Response::HTTP_FORBIDDEN);
                break;
        }
    }

    /**
     * Cambia los datos de la articulacion en la fase de cierre
     *
     * @param Request $request
     * @param int $id id de la articulacion
     * @author devjul
     */
    public function updateCierre(Request $request, int $id)
    {

        if (Session::get('login_role') == User::IsArticulador()) {
            $articulacion = ArticulacionPbt::findOrFail($id);
            if ($articulacion->aprobacion_dinamizador == 1) {


            } else {
                $req = new ArticulacionFaseCierreFormRequest;
                $validator = Validator::make($request->all(), $req->rules(), $req->messages());
                if ($validator->fails()) {
                    return response()->json([
                        'state'   => 'error_form',
                        'errors' => $validator->errors(),
                    ]);
                } else {
                    $update = $this->getArticulacionRepository()->updateCierreArticulacion($request, $id);
                    if ($update != null) {
                        return response()->json(['state' => 'update', 'data' => $update ]);
                    } else {
                        return response()->json(['state' => 'no_update' , 'data' => null]);
                    }
                }
            }
        }
    }

    /**
     * Notifica al dinamizador para que una articulacion se suspenda
     * @param int $id Id de la articulacion
     * @return Reponse
     * @author devjul
     **/
    public function notificarSuspendido(int $id)
    {
        $notificacion = $this->getArticulacionRepository()->notificarAlDinamziador_Suspendido($id);
        if ($notificacion) {
            Alert::success('Notificación Exitosa!', 'Se le ha enviado una notificación al dinamizador para que apruebe la suspensión del proyecto!')->showConfirmButton('Ok', '#3085d6');
        } else {
            Alert::error('Notificación Errónea!', 'No se le ha enviado una notificación al dinamizador para que apruebe la suspensión del proyecto!')->showConfirmButton('Ok', '#3085d6');
        }
        return back();
    }

    /**
     * Cambia el estado de una articulacion a suspendido
     *
     * @param Request $request
     * @param int $id
     * @return Response
     * @author devjul
     **/
    public function updateSuspendido(Request $request, int $id)
    {
        $articulacion = ArticulacionPbt::findOrFail($id);

        $response = $this->getArticulacionRepository()->suspenderArticulacion($request, $articulacion);
        if ($response != null) {
            Alert::success('Modificación Exitosa!', 'La fase de suspendido de la articulación se aprobó!')->showConfirmButton('Ok', '#3085d6');
            return redirect()->route('articulaciones.show', $response->id);
        } else {
            Alert::error('Modificación Errónea!', 'La fase de suspendido de la articulación no se aprobó!')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
    }

    /**
     * Reversa la articulacion de fase
     *
     * @param Request $request
     * @param int $id Id de la articulacion
     * @param string $fase Fase a la que se va a reversar la articulación
     * @return Response
     * @author devjul
     **/
    public function updateReversar(Request $request, int $id, string $fase)
    {
        $articulacion = ArticulacionPbt::findOrFail($id);
        if ($articulacion->fase->nombre == $fase) {
            Alert::warning('El proyecto ya se encuentra en fase de '.$fase.'!', 'Modificación Errónea!')->showConfirmButton('Ok', '#3085d6');
            return back();
        } else {
            if ($articulacion->fase->nombre == 'Suspendido') {
                $update = $this->getArticulacionRepository()->reversarArticulacion($articulacion, $fase);
                if ($update != null) {
                    Alert::success('La articulación se ha reversado a la fase '.$fase.'!', 'Modificación Exitosa!')->showConfirmButton('Ok', '#3085d6');
                    return redirect()->route('articulaciones.show', $update->id);
                } else {
                    Alert::error('La articulación no se ha reversado!', 'Modificación Errónea!')->showConfirmButton('Ok', '#3085d6');
                    return back();
                }
            } else {
                if (($articulacion->fase->nombre == 'Planeación' && $fase == 'Inicio')) {
                    $update = $this->getArticulacionRepository()->reversarArticulacion($articulacion, $fase);
                    if ($update != null) {
                        Alert::success('La fase de la articulación se ha reversado a '.$fase.'!', 'Modificación Exitosa!')->showConfirmButton('Ok', '#3085d6');
                        return redirect()->route('articulaciones.show', $update->id);
                    } else {
                        Alert::error('La articulación no se ha reversado!', 'Modificación Errónea!')->showConfirmButton('Ok', '#3085d6');
                        return back();
                    }
                } else {
                    if (($articulacion->fase->nombre == 'Ejecución' && $fase == 'Planeación') || ($articulacion->fase->nombre == 'Ejecución' && $fase == 'Inicio')) {
                        $update = $this->getArticulacionRepository()->reversarArticulacion($articulacion, $fase);
                        if ($update != null) {
                            Alert::success('La fase de la articulación se ha reversado a '.$fase.'!', 'Modificación Exitosa!')->showConfirmButton('Ok', '#3085d6');
                            return redirect()->route('articulaciones.show', $update->id);
                        } else {
                            Alert::error('La articulación no se ha reversado!', 'Modificación Errónea!')->showConfirmButton('Ok', '#3085d6');
                            return back();
                        }
                    } else {
                        if (($articulacion->fase->nombre == 'Cierre' && $fase == 'Ejecución') || ($articulacion->fase->nombre == 'Cierre' && $fase == 'Planeación') || ($articulacion->fase->nombre == 'Cierre' && $fase == 'Inicio')) {
                            $update = $this->getArticulacionRepository()->reversarArticulacion($articulacion, $fase);
                            if ($update != null) {
                                Alert::success('La fase de la articulación se ha reversado a '.$fase.'!', 'Modificación Exitosa!')->showConfirmButton('Ok', '#3085d6');
                                return redirect()->route('articulaciones.show', $update->id);
                            } else {
                                Alert::error('La articulación no se ha reversado!', 'Modificación Errónea!')->showConfirmButton('Ok', '#3085d6');
                                return back();
                            }
                        } else {
                            Alert::warning('La articulación no se puede reversar a la fase de '.$fase.'!', 'Modificación Errónea!')->showConfirmButton('Ok', '#3085d6');
                            return back();
                        }
                    }
                }
            }
        }
    }

    /**
     * listado de talentos que participan de la articulacion
     *
     * @param int $id Id de la articulacion
     * @return Response
     * @author devjul
     **/
    public function miembros($id)
    {
        $articulacion = ArticulacionPbt::where('id', $id)->firstOrFail();

        $historico =  $articulacion->historial;

        return view('articulacionespbt.miembros', [
            'articulacion' => $articulacion,
            'historico' => $historico
        ]);



    }


    /**
     * Update los miembros de una articulaion.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateMiembros(Request $request, $id)
    {

        $req = new ArticulacionMiembrosFormRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'state'   => 'error_form',
                'errors' => $validator->errors(),
            ]);
        } else {

            $response = $this->getArticulacionRepository()->updateMiembros($request, $id);
            if ($response != null) {
                return response()->json([
                    'data' => $response,
                    'url' => route('articulaciones.show', $response->id),
                    'status_code' => Response::HTTP_CREATED,
                ], Response::HTTP_CREATED);
            } else {
                return response()->json(['status_code' => Response::HTTP_NOT_FOUND]);
            }
        }
    }

    public function export(Request $request, $extension = 'xlsx')
    {
        // $this->authorize('view', ArticulacionPbt::class);
        $talent = null;
        switch (\Session::get('login_role')) {
            case User::IsAdministrador():
                $nodo = $request->filter_nodo_art;
                break;
            case User::IsDinamizador():
                $nodo = auth()->user()->dinamizador->nodo_id;
                break;
            case User::IsArticulador():
                $nodo = auth()->user()->articulador->nodo_id;
                break;
            case User::IsTalento():
                $nodo = null;
                $talent = auth()->user()->talento->id;
                break;
            default:
                return abort('403');
                break;
        }

        $articulaciones =  ArticulacionPbt::with([
            'fase',
            'tipoarticulacion' => function($query){
                $query->select('id', 'nombre');
            },
            'alcancearticulacion'=> function($query){
                $query->select('id', 'nombre');
            },
            'asesor' => function($query){
                $query->select('id', 'documento',  'nombres', 'apellidos');
            },
            'nodo',
            'nodo.entidad'=> function($query){
                $query->select('id', 'ciudad_id',  'nombre', 'slug');
            }
        ])
        ->tipoArticulacion($request->filter_tipo_articulacion)
        ->alcanceArticulacion($request->filter_alcance_articulacion)
        ->fase($request->filter_phase)
        ->nodo($nodo)
        ->starEndDate($request->filter_year_art)
        ->talents($talent)
        ->orderBy('created_at', 'desc')
        ->get();

        return (new ArticulacionesPbtExport($articulaciones))->download("Articulaciones PBT - " . config('app.name') . ".{$extension}");
    }

    /**
    * Formulario para cambiar el gestor de un proyecto
    *
    * @param int $id Id del proyecto
    * @return type
    * @throws conditon
    **/
    public function changeArticulador(UserRepository $userRepository, int $id)
    {
        $articulacion = ArticulacionPbt::where('id', $id)->firstOrFail();

        $historico =  $articulacion->historial;

        $articuladores = $userRepository->getArticuladorForNode($articulacion->nodo_id)->pluck('articulador', 'id');

        return view('articulacionespbt.dinamizador.cambiar_articulador', [
            'articulacion' => $articulacion,
            'historico' => $historico,
            'articuladores' => $articuladores
        ]);
    }

    /**
    * Cambiar el articulador de una articulacion
    * @param Request $request
    * @param int $id
    * @return Response
    * @author devjul
    **/
    public function updateArticulador(Request $request, int $id)
    {
        $messages = [
            'txtgestor.required' => 'El Articulador es obligatorio.',
        ];

        $validator = Validator::make($request->all(), [
            'txtgestor' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $update = $this->getArticulacionRepository()->updateArticulador($request, $id);
        if ($update != null) {
            Alert::success('Se ha cambiado el articulador de la articulación!', 'Modificación Exitosa!')->showConfirmButton('Ok', '#3085d6');
            return redirect()->route('articulaciones.show', $update->id);
        } else {
            Alert::error('No se ha cambiado el articulador de la articulación!', 'Modificación Errónea!')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
    }

}
