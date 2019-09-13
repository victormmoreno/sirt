<?php

namespace App\Http\Controllers;

use Alert;
use App\Helpers\ArrayHelper;use App\Http\Requests\ArticulacionFormRequest;
use App\Models\Articulacion;
use App\Models\Gestor;
use App\Models\Nodo;
use App\Models\TipoArticulacion;
use App\Repositories\Repository\ArticulacionProyectoRepository;
use App\Repositories\Repository\ArticulacionRepository;
use App\Repositories\Repository\EmpresaRepository;
use App\Repositories\Repository\GrupoInvestigacionRepository;
use App\Repositories\Repository\UserRepository\GestorRepository;
use App\User;use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ArticulacionController extends Controller
{

    private $articulacionRepository;
    private $empresaRepository;
    private $grupoInvestigacionRepository;
    private $articulacionProyectoRepository;
    private $gestorRepository;

    public function __construct(GestorRepository $gestorRepository, ArticulacionRepository $articulacionRepository, EmpresaRepository $empresaRepository, GrupoInvestigacionRepository $grupoInvestigacionRepository, ArticulacionProyectoRepository $articulacionProyectoRepository)
    {
        $this->articulacionRepository         = $articulacionRepository;
        $this->empresaRepository              = $empresaRepository;
        $this->grupoInvestigacionRepository   = $grupoInvestigacionRepository;
        $this->articulacionProyectoRepository = $articulacionProyectoRepository;
        $this->gestorRepository               = $gestorRepository;
        $this->middleware(['auth']);
    }

    /**
     * Función para mostrar las datatables de las articulaciones
     * @param Collection $query Consulta
     * @return Reponse
     */
    private function datatablesArticulaciones($request, $query)
    {
        return datatables()->of($query)
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('codigo_articulacion'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['codigo_articulacion'], $request->get('codigo_articulacion')) ? true : false;
                    });
                }
                if (!empty($request->get('nombre'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['nombre'], $request->get('nombre')) ? true : false;
                    });
                }
                if (!empty($request->get('tipo_articulacion'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['tipo_articulacion'], $request->get('tipo_articulacion')) ? true : false;
                    });
                }
                if (!empty($request->get('nombre_completo_gestor'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['nombre_completo_gestor'], $request->get('nombre_completo_gestor')) ? true : false;
                    });
                }
                if (!empty($request->get('estado'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['estado'], $request->get('estado')) ? true : false;
                    });
                }
                if (!empty($request->get('search'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        if (Str::contains(Str::lower($row['codigo_articulacion']), Str::lower($request->get('search')))) {
                            return true;
                        } else if (Str::contains(Str::lower($row['nombre']), Str::lower($request->get('search')))) {
                            return true;
                        } else if (Str::contains(Str::lower($row['tipo_articulacion']), Str::lower($request->get('search')))) {
                            return true;
                        } else if (Str::contains(Str::lower($row['nombre_completo_gestor']), Str::lower($request->get('search')))) {
                            return true;
                        } else if (Str::contains(Str::lower($row['estado']), Str::lower($request->get('search')))) {
                            return true;
                        }

                        return false;
                    });
                }
            })
            ->addColumn('details', function ($data) {
                $button = '
      <a class="btn light-blue m-b-xs" onclick="detallesDeUnaArticulacion(' . $data->id . ')">
      <i class="material-icons">info</i>
      </a>
      ';
                return $button;
            })->addColumn('edit', function ($data) {
            $edit = '<a class="btn m-b-xs" href=' . route('articulacion.edit', $data->id) . '><i class="material-icons">edit</i></a>';
            return $edit;
        })->addColumn('entregables', function ($data) {
            $button = '
      <a class="btn blue-grey m-b-xs" href=' . route('articulacion.entregables', $data->id) . '>
      <i class="material-icons">library_books</i>
      </a>
      ';
            return $button;
        })->editColumn('estado', function ($data) {
            if ($data->estado == 'Inicio') {
                return $data->estado . '</br><div class="progress grey lighten-2"><div class="determinate red" style="width: 33%"></div></div>';
            } else if ($data->estado == 'Ejecución' || $data->estado == 'Co-Ejecución') {
                return $data->estado . '</br><div class="progress grey lighten-2"><div class="determinate yellow" style="width: 66%"></div></div>';
            } else {
                return $data->estado . '</br><div class="progress grey lighten-2"><div class="determinate green" style="width: 100%"></div></div>';
            }
        })->editColumn('revisado_final', function ($data) {
            if ($data->revisado_final == 'Por Evaluar') {
                return '<div class="card-panel blue lighten-4"><span><i class="material-icons left">query_builder</i>' . $data->revisado_final . '</span></div>';
            } else if ($data->revisado_final == 'Aprobado') {
                return '<div class="card-panel green lighten-4"><span><i class="material-icons left">done_all</i>' . $data->revisado_final . '</span></div>';
            } else {
                return '<div class="card-panel red lighten-4"><span><i class="material-icons left">close</i>' . $data->revisado_final . '</span></div>';
            }
            return '<span class="red-text">' . $data->revisado_final . '</span>';
        })->rawColumns(['details', 'edit', 'entregables', 'revisado_final', 'estado'])->make(true);
    }

    /**
     * Consulta el detalle de la entidad asociada a la articulación
     * @param int $id id de la articulación
     * @return dum
     * @author dum
     */
    public function consultarEntidadDeLaArticulacion($id)
    {
        $articulacionObj = Articulacion::findOrFail($id);
        $articulacion    = $this->articulacionRepository->consultarArticulacionPorId($id)->last()->toArray();
        $entidad         = null;
        if ($articulacionObj->tipo_articulacion == Articulacion::IsEmpresa()) {
            $entidad = $this->empresaRepository->consultarDetallesDeUnaEmpresa($articulacionObj->articulacion_proyecto->entidad->empresa->id)->toArray();
            $entidad = ArrayHelper::validarDatoNullDeUnArray($entidad);
        } else if ($articulacionObj->tipo_articulacion == Articulacion::IsGrupo()) {
            $entidad = $this->grupoInvestigacionRepository->consultarDetalleDeUnGrupoDeInvestigacion($articulacionObj->articulacion_proyecto->entidad->grupoinvestigacion->id)->toArray();
            $entidad = ArrayHelper::validarDatoNullDeUnArray($entidad);
        } else {
            $entidad = $this->articulacionProyectoRepository->consultarTalentosDeUnaArticulacionProyectoRepository($articulacionObj->articulacion_proyecto->id)->toArray();
        }
        return response()->json([
            'detalles'     => $entidad,
            'articulacion' => $articulacion,
        ]);
    }

    // Consulta los detalles de los entregables de una articulacion (Solo los checkboxes)
    public function detallesDeLosEntregablesDeUnaArticulacion($id)
    {
        $entregables  = $this->articulacionRepository->consultaEntregablesDeUnaArticulacion($id)->last()->toArray();
        $entregables  = ArrayHelper::validarEntregablesNullDeUnArrayString($entregables);
        $articulacion = $this->articulacionRepository->consultarArticulacionPorId($id)->last()->toArray();
        return response()->json([
            'entregables'  => $entregables,
            'articulacion' => $articulacion,
        ]);
    }

    /**
     * Consulta los datos de una articulación por su id
     * @param int $id Id de la articulación
     * @return Response
     * @author dum
     */
    public function detallesDeUnArticulacion($id)
    {
        $detalles = $this->articulacionRepository->consultarArticulacionPorId($id)->last()->toArray();
        $detalles = ArrayHelper::validarDatoNullDeUnArray($detalles);
        return response()->json([
            'detalles' => $detalles,
        ]);
    }

    /**
     * Modifica los entregables de una articulación
     * @param Request $request
     * @param int $id Id de la articulación
     * @return Response
     * @author Victor Manuel Moreno Vega
     */
    public function updateEntregables(Request $request, $id)
    {
        if (\Session::get('login_role') == User::IsGestor()) {
            !isset($request['entregable_acta_inicio']) ? $request['entregable_acta_inicio']                                                 = 0 : $request['entregable_acta_inicio']                                                 = 1;
            !isset($request['entregable_acuerdo_confidencialidad_compromiso']) ? $request['entregable_acuerdo_confidencialidad_compromiso'] = 0 : $request['entregable_acuerdo_confidencialidad_compromiso'] = 1;
            !isset($request['entregable_acta_seguimiento']) ? $request['entregable_acta_seguimiento']                                       = 0 : $request['entregable_acta_seguimiento']                                       = 1;
            !isset($request['entregable_acta_cierre']) ? $request['entregable_acta_cierre']                                                 = 0 : $request['entregable_acta_cierre']                                                 = 1;
            !isset($request['entregable_informe_final']) ? $request['entregable_informe_final']                                             = 0 : $request['entregable_informe_final']                                             = 1;
            !isset($request['entregable_encuesta_satisfaccion']) ? $request['entregable_encuesta_satisfaccion']                             = 0 : $request['entregable_encuesta_satisfaccion']                             = 1;
            !isset($request['entregable_otros']) ? $request['entregable_otros']                                                             = 0 : $request['entregable_otros']                                                             = 1;
            $entregablesArticulacion                                                                                                        = $this->articulacionRepository->updateEntregablesArticulacion($request, $id);
            alert()->success('Modificación Exitosa!', 'Los entregables de la articulación se han modificado con éxito.')->showConfirmButton('Ok', '#3085d6');
            return redirect('articulacion');
        } else {
            $articulacion = $this->articulacionRepository->consultarArticulacionPorId($id)->last();
            // dd($articulacion->estado);
            if ($request['txtrevisado_final'] == 0) {
                $articulacionRevisadoFinal = $this->articulacionRepository->updateRevisadoFinalArticulacion($request, $id);
                alert()->success('Modificación Exitosa!', 'El revisado final de la articulación se ha modificado con éxito.')->showConfirmButton('Ok', '#3085d6');
                return redirect('articulacion');
            } else {
                if ($articulacion->estado != 'Ejecución') {
                    alert()->warning('Advertencia!', 'Para cambiar el revisado final de una articulación, esta debe estar en estado de Ejecución.')->showConfirmButton('Ok', '#3085d6');
                    return back();
                } else {
                    $articulacionRevisadoFinal = $this->articulacionRepository->updateRevisadoFinalArticulacion($request, $id);
                    alert()->success('Modificación Exitosa!', 'El revisado final de la articulación se ha modificado con éxito.')->showConfirmButton('Ok', '#3085d6');
                    return redirect('articulacion');
                }
            }
        }
    }

    /**
     * Vista para subir y ver los entregables de una articulación*
     * @param int $id Id de la articulacion
     * @return Response
     * @author Victor Manuel Moreno Vega
     */
    public function entregables($id)
    {
        $articulacion = $this->articulacionRepository->consultarArticulacionPorId($id)->last();
        $view         = "";
        if (\Session::get('login_role') == User::IsGestor()) {
            $view = 'articulaciones.gestor.entregables';
        } else if (\Session::get('login_role') == User::IsDinamizador()) {
            $view = 'articulaciones.dinamizador.entregables';
        } else {
            $view = 'articulaciones.administrador.entregables';
        }
        return view($view, [
            'articulacion' => $articulacion,
        ]);

    }

    // Datatable para mostrar las articulaciones POR NODO
    public function datatableArticulacionesPorNodo(Request $request, $id)
    {
        if (request()->ajax()) {
            if (\Session::get('login_role') == User::IsDinamizador()) {
                $articulaciones = $this->articulacionRepository->consultarArticulacionesDeUnNodo(auth()->user()->dinamizador->nodo_id);
            } else {
                $articulaciones = $this->articulacionRepository->consultarArticulacionesDeUnNodo($id);
            }
            return $this->datatablesArticulaciones($request, $articulaciones);
        }
    }

    /**
     * Consulta las articulaciones de un gestor
     * @param Request $request
     * @param int $id Id del gestor
     * @return Response
     * @author Victor Manuel Moreno Vega
     */
    public function datatableArticulacionesPorGestor(Request $request, $id)
    {
        if (request()->ajax()) {
            $idgestor = $id;
            if (Session::get('login_role') == User::IsGestor()) {
                $idgestor = auth()->user()->gestor->id;
            }

            $articulaciones = $this->articulacionRepository->consultarArticulacionesDeUnGestor($idgestor);
            return $this->datatablesArticulaciones($request, $articulaciones);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        switch (\Session::get('login_role')) {
            case User::IsAdministrador():
                return view('articulaciones.administrador.index', [
                    'nodos' => Nodo::SelectNodo()->get(),
                ]);
                break;
            case User::IsDinamizador():
                return view('articulaciones.dinamizador.index', [
                    'gestores' => Gestor::ConsultarGestoresPorNodo(auth()->user()->dinamizador->nodo_id)->pluck('nombres_gestor', 'id'),
                ]);
                break;
            case User::IsGestor():
                return view('articulaciones.gestor.index');
                break;

            default:
                return back();
                break;
        }
    }

    // Consulta los tipos de articulaciones que se pueden realizar con grupos de investigación, empresas ó emprendedores
    public function consultarTipoArticulacion($tipo)
    {
        $tiposarticulacion = "";
        if ($tipo == 0) {
            $tiposarticulacion = TipoArticulacion::ConsultarTipoArticulacionConGruposDeInvestigacion()->get();
        } else {
            $tiposarticulacion = TipoArticulacion::ConsultarTipoArticulacionConEmpresasEmprendedores()->get();
        }
        return response()->json([
            'tiposarticulacion' => $tiposarticulacion,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (\Session::get('login_role') == User::IsGestor()) {
            return view('articulaciones.gestor.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $req       = new ArticulacionFormRequest;
        $validator = \Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'fail'   => true,
                'errors' => $validator->errors(),
            ]);
        }
        $result = $this->articulacionRepository->create($request);
        if ($result == false) {
            return response()->json([
                'fail'         => false,
                'redirect_url' => false,
            ]);
        } else {
            return response()->json([
                'fail'         => false,
                'redirect_url' => url(route('articulacion')),
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author Victor Manuel Moreno Vega
     */
    public function edit($id)
    {
        $articulacion = Articulacion::find($id);
        if ($articulacion->estado == Articulacion::IsCierre()) {
            alert()->warning('Advertencia!', 'No se puede realizar esta acción por el estado de la articulación es Cierre.')->showConfirmButton('Ok', '#3085d6');
            return back();
        } else {
            $pivot = array();
            if (Articulacion::find($id)->tipo_articulacion == Articulacion::IsEmprendedor()) {
                $pivot = $this->articulacionProyectoRepository->consultarTalentosDeUnaArticulacionProyectoRepository($articulacion->articulacion_proyecto_id);
            }
            if (\Session::get('login_role') == User::IsGestor()) {
                return view('articulaciones.gestor.edit', [
                    'articulacion' => $articulacion,
                    'pivot'        => $pivot,
                ]);
            } else {
                // dd($articulacion->articulacion_proyecto->actividad->gestor->lineatecnologica->id);
                $gestores = $this->gestorRepository->consultarGestoresPorLineaTecnologicaYNodoRepository($articulacion->articulacion_proyecto->actividad->gestor->lineatecnologica->id, auth()->user()->dinamizador->nodo_id)->pluck('gestor', 'id');
                return view('articulaciones.dinamizador.edit', [
                    'articulacion' => $articulacion,
                    'gestores'     => $gestores,
                ]);
            }

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author Victor Manuel Moreno Vega
     */
    public function update(Request $request, $id)
    {
        if (Session::get('login_role') == User::IsGestor()) {
            $req       = new ArticulacionFormRequest;
            $validator = \Validator::make($request->all(), $req->rules(), $req->messages());
            if ($validator->fails()) {
                return response()->json([
                    'fail'   => true,
                    'errors' => $validator->errors(),
                ]);
            }
            $result = $this->articulacionRepository->update($request, $id);
            // exit;
            if ($result == false) {
                return response()->json([
                    'fail'         => false,
                    'redirect_url' => false,
                ]);
            } else {
                return response()->json([
                    'fail'         => false,
                    'redirect_url' => url(route('articulacion')),
                ]);
            }
        } else {
            $validator = Validator::make($request->all(), [
                'txtgestor_id' => 'required',
            ], ['txtgestor_id.required' => 'El Gestor es obligatorio.']);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            $update = $this->articulacionRepository->updateGestorArticulacion_Repository($request, $id);
            if ($update) {
                Alert::success('Modificación Existosa!', 'El gestor de la articulación se ha cambiado!')->showConfirmButton('Ok', '#3085d6');
                return redirect('articulacion');
            } else {
                Alert::error('Modificación Errónea!', 'El gestor de la articulación no se ha cambiado!')->showConfirmButton('Ok', '#3085d6');
                return back();
            }
        }
    }

    /*===========================================================================
    =            metodo para consultar las articulaciones por gestor            =
    ===========================================================================*/

    public function ArticulacionForGestor($id, int $tipoArticulacion = 0)
    {
        $articulaciones = Articulacion::articulacionesForEstado($tipoArticulacion)->EstadoOfArticulaciones([
            Articulacion::IsInicio(),
            Articulacion::IsEjecucion(),
            Articulacion::IsCierre(),
        ])->get();

        return response()->json([
            'articulaciones' => $articulaciones,
        ]);
    }

}
