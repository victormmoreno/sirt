<?php

namespace App\Http\Controllers;

use App\Models\Gestor;
use App\Models\Articulacion;
use App\Models\Nodo;
use App\User;
use Illuminate\Http\Request;
use App\Helpers\ArrayHelper;
use App\Http\Requests\ArticulacionFormRequest;
use App\Repositories\Repository\{IntervencionRepository, ArticulacionRepository, UserRepository\GestorRepository};
use Illuminate\Support\{Str, Facades\Session, Facades\Validator};
use Alert;

class IntervencionEmpresaController extends Controller
{

    private $intervencionRepository;
    private $intervencionProyectoRepository;
    private $gestorRepository;

    public function __construct(GestorRepository $gestorRepository, IntervencionRepository $intervencionRepository, ArticulacionRepository $articulacionRepository)
    {
        $this->intervencionRepository = $intervencionRepository;
        $this->articulacionRepository = $articulacionRepository;
        $this->gestorRepository = $gestorRepository;
        $this->middleware(['auth']);
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
                return view('intervencion.administrador.index', [
                    'nodos' => Nodo::SelectNodo()->get(),
                ]);

                break;
            case User::IsDinamizador():
                return view('intervencion.dinamizador.index', [
                    'gestores' => Gestor::ConsultarGestoresPorNodo(auth()->user()->dinamizador->nodo_id)->pluck('nombres_gestor', 'id'),
                ]);
                break;
            case User::IsGestor():
                return view('intervencion.gestor.index');
                break;

            default:
                return back();
                break;
        }
    }


    // Datatable para mostrar las articulaciones POR NODO
    public function datatableIntervencionesPorNodo(Request $request, $id, $anho)
    {
        if (request()->ajax()) {
            if (\Session::get('login_role') == User::IsDinamizador()) {
                $intervenciones = $this->intervencionRepository->consultarIntervencionesAEmpresasDeUnNodo(auth()->user()->dinamizador->nodo_id, $anho);
            } else {
                $intervenciones = $this->intervencionRepository->consultarIntervencionesAEmpresasDeUnNodo($id, $anho);
            }
            // return $intervenciones;
            return $this->datatablesIntervencionAEmpresas($request, $intervenciones);
        }
    }

    /**
     * Función para mostrar las datatables de las articulaciones
     * @param Collection $query Consulta
     * @return Reponse
     */
    private function datatablesIntervencionAEmpresas($request, $query)
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
                            <a class="btn light-blue m-b-xs" onclick="detallesDeUnaIntervencion(' . $data->id . ')">
                            <i class="material-icons">info</i>
                            </a>
                            ';
                return $button;
            })->addColumn('edit', function ($data) {
                $edit = '<a class="btn m-b-xs" href=' . route('intervencion.edit', $data->id) . '><i class="material-icons">edit</i></a>';
                return $edit;
            })->addColumn('entregables', function ($data) {
                $button = '
                        <a class="btn blue-grey m-b-xs" href=' . route('intervencion.entregables', $data->id) . '>
                        <i class="material-icons">library_books</i>
                        </a>
                        ';
                return $button;
            })->addColumn('delete', function ($data) {
                $delete = '<a class="btn red lighten-3 m-b-xs" onclick="eliminarIntervencionEmpresaPorId_event(' . $data->id . ', event)">
                                <i class="material-icons">delete_sweep</i>
                            </a>
                ';
                return $delete;
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
            })->rawColumns(['details', 'edit', 'entregables', 'revisado_final', 'estado', 'delete'])->make(true);
    }

    /**
     * Consulta las intervenciones a empresas de un gestor
     * @param Request $request
     * @param int $id Id del gestor
     * @param string $anho Año de inicio de las articulaciones
     * @return Response
     * @author devjul
     */
    public function datatableIntervencionesAempresasPorGestor(Request $request, $id, $anho)
    {
        if (request()->ajax()) {
            $idgestor = $id;
            if (Session::get('login_role') == User::IsGestor()) {
                $idgestor = auth()->user()->gestor->id;
            }

            $intervenciones = $this->intervencionRepository->consultarIntervencionesDeUnGestor($idgestor, $anho);
            return $this->datatablesintervencion($request, $intervenciones);
        }
    }


    /**
     * Función para mostrar las datatables de las articulaciones
     * @param Collection $query Consulta
     * @return Reponse
     */
    private function datatablesintervencion($request, $query)
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
      <a class="btn light-blue m-b-xs" onclick="detallesDeUnaIntervencion(' . $data->id . ')">
      <i class="material-icons">info</i>
      </a>
      ';
                return $button;
            })->addColumn('edit', function ($data) {
                $edit = '<a class="btn m-b-xs" href=' . route('intervencion.edit', $data->id) . '><i class="material-icons">edit</i></a>';
                return $edit;
            })->addColumn('entregables', function ($data) {
                $button = '
      <a class="btn blue-grey m-b-xs" href=' . route('intervencion.entregables', $data->id) . '>
      <i class="material-icons">library_books</i>
      </a>
      ';
                return $button;
            })->addColumn('delete', function ($data) {
                $delete = '
      <a class="btn red lighten-3 m-b-xs" onclick="eliminarIntervencionEmpresaPorId_event(' . $data->id . ', event)">
      <i class="material-icons">delete_sweep</i>
      </a>
      ';
                return $delete;
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
            })->rawColumns(['details', 'edit', 'entregables', 'revisado_final', 'estado', 'delete'])->make(true);
    }


    /**
     * Consulta los datos de una articulación por su id
     * @param int $id Id de la articulación
     * @return Response
     * @author devjul
     */
    public function detallesDeUnaIntervencion($id)
    {
        $detalles = $this->intervencionRepository->consultarIntervencionPorId($id)->last()->toArray();
        $detalles = ArrayHelper::validarDatoNullDeUnArray($detalles);
        return response()->json([
            'detalles' => $detalles,
        ]);
    }

    /**
     * Elimina una intervencion a empresas de la base de datos
     *
     * @param int $id Id de la intervencion
     * @return Response
     * @author devjul
     */
    public function eliminarIntervencionEmpresa(int $id)
    {
        if (Session::get('login_role') == User::IsDinamizador()) {
            $delete = $this->articulacionRepository->eliminarArticulacion_Repository($id);
            return response()->json([
                'retorno' => $delete
            ]);
        } else {
            abort('403');
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
        $view = "";
        if (\Session::get('login_role') == User::IsGestor()) {
            $view = 'intervencion.gestor.entregables';
        } else if (\Session::get('login_role') == User::IsDinamizador()) {
            $view = 'intervencion.dinamizador.entregables';
        } else {
            $view = 'intervencion.administrador.entregables';
        }
        return view($view, [
            'articulacion' => $articulacion
        ]);
    }


    /**
     * Modifica los entregables de una intervencion a empresas
     * @param Request $request
     * @param int $id Id de la articulación
     * @return Response
     * @author devjul
     */
    public function updateEntregables(Request $request, $id)
    {
        if (\Session::get('login_role') == User::IsGestor()) {
            !isset($request['entregable_acta_inicio']) ? $request['entregable_acta_inicio'] = 0 : $request['entregable_acta_inicio'] = 1;
            !isset($request['entregable_acuerdo_confidencialidad_compromiso']) ? $request['entregable_acuerdo_confidencialidad_compromiso'] = 0 : $request['entregable_acuerdo_confidencialidad_compromiso'] = 1;
            !isset($request['entregable_acta_seguimiento']) ? $request['entregable_acta_seguimiento'] = 0 : $request['entregable_acta_seguimiento'] = 1;
            !isset($request['entregable_acta_cierre']) ? $request['entregable_acta_cierre'] = 0 : $request['entregable_acta_cierre'] = 1;
            !isset($request['entregable_informe_final']) ? $request['entregable_informe_final'] = 0 : $request['entregable_informe_final'] = 1;
            !isset($request['entregable_encuesta_satisfaccion']) ? $request['entregable_encuesta_satisfaccion'] = 0 : $request['entregable_encuesta_satisfaccion'] = 1;
            !isset($request['entregable_otros']) ? $request['entregable_otros'] = 0 : $request['entregable_otros'] = 1;
            $entregablesArticulacion = $this->articulacionRepository->updateEntregablesArticulacion($request, $id);
            alert()->success('Modificación Exitosa!', 'Los entregables de la Intervención a Empresa se han modificado con éxito.')->showConfirmButton('Ok', '#3085d6');
            return redirect()->route('intervencion.index');
        } else {
            $articulacion = $this->articulacionRepository->consultarArticulacionPorId($id)->last();
            if ($request['txtrevisado_final'] == 0) {
                $articulacionRevisadoFinal = $this->articulacionRepository->updateRevisadoFinalArticulacion($request, $id);
                alert()->success('Modificación Exitosa!', 'El revisado final de la Intervención a Empresa se ha modificado con éxito.')->showConfirmButton('Ok', '#3085d6');
                return redirect()->route('intervencion.index');
            } else {
                if ($articulacion->estado != 'Ejecución') {
                    alert()->warning('Advertencia!', 'Para cambiar el revisado final de una Intervención a Empresa, esta debe estar en estado de Ejecución.')->showConfirmButton('Ok', '#3085d6');
                    return back();
                } else {
                    $articulacionRevisadoFinal = $this->articulacionRepository->updateRevisadoFinalArticulacion($request, $id);
                    alert()->success('Modificación Exitosa!', 'El revisado final de la Intervención a Empresa se ha modificado con éxito.')->showConfirmButton('Ok', '#3085d6');
                    return redirect()->route('intervencion.index');
                }
            }
        }
    }

    /**
     * Consulta las intevenciones a empresas de un gestor
     * @param Request $request
     * @param int $id Id del gestor
     * @param string $anho Año de inicio de las articulaciones
     * @return Response
     * @author devjul
     */
    public function datatableIntervencionesEmpresaPorGestor(Request $request, $id, $anho)
    {
        if (request()->ajax()) {
            $idgestor = $id;
            if (Session::get('login_role') == User::IsGestor()) {
                $idgestor = auth()->user()->gestor->id;
            }

            $intervenciones = $this->articulacionRepository->consultarIntervencionesEmpresasDeUnGestor($idgestor, $anho);
            return $this->datatablesintervencion($request, $intervenciones);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (\Session::get('login_role') == User::IsGestor()) {
            return view('intervencion.gestor.create');
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
        $req = new ArticulacionFormRequest;
        $validator = \Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'fail' => true,
                'errors' => $validator->errors(),
            ]);
        }
        $result = $this->articulacionRepository->create($request);
        if ($result == false) {
            return response()->json([
                'fail' => false,
                'redirect_url' => false
            ]);
        } else {
            return response()->json([
                'fail' => false,
                'redirect_url' => url(route('intervencion.index'))
            ]);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $articulacion = Articulacion::find($id);

        if ($articulacion->estado == Articulacion::IsCierre()) {
            alert()->warning('Advertencia!', 'No se puede realizar esta acción por el estado de la Intervención a empresa es Cierre.')->showConfirmButton('Ok', '#3085d6');
            return back();
        } else {
            $pivot = array();
            if (Articulacion::find($id)->tipo_articulacion == Articulacion::IsEmprendedor()) {
                $pivot = $articulacion->emprendedores;
            }
            if (\Session::get('login_role') == User::IsGestor()) {
                return view('intervencion.gestor.edit', [
                    'articulacion' => $articulacion,
                    'pivot' => $pivot,
                ]);
            } else {
                $gestores = $this->gestorRepository->consultarGestoresPorLineaTecnologicaYNodoRepository($articulacion->articulacion_proyecto->actividad->gestor->lineatecnologica->id, auth()->user()->dinamizador->nodo_id)->pluck('gestor', 'id');
                return view('intervencion.dinamizador.edit', [
                    'articulacion' => $articulacion,
                    'gestores' => $gestores
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
     */
    public function update(Request $request, $id)
    {

        if (Session::get('login_role') == User::IsGestor()) {
            $req = new ArticulacionFormRequest;
            $validator = \Validator::make($request->all(), $req->rules(), $req->messages());
            if ($validator->fails()) {
                return response()->json([
                    'fail' => true,
                    'errors' => $validator->errors(),
                ]);
            }
            $result = $this->articulacionRepository->update($request, $id);

            if ($result == false) {
                return response()->json([
                    'fail' => false,
                    'redirect_url' => false
                ]);
            } else {
                return response()->json([
                    'fail' => false,
                    'redirect_url' => url(route('intervencion.index'))
                ]);
            }
        } else {
            $validator = Validator::make($request->all(), [
                'txtgestor_id' => 'required'
            ], ['txtgestor_id.required' => 'El Gestor es obligatorio.']);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            $update = $this->articulacionRepository->updateGestorArticulacion_Repository($request, $id);
            if ($update) {
                Alert::success('Modificación Exitosa!', 'El gestor de la articulación se ha cambiado!')->showConfirmButton('Ok', '#3085d6');
                return redirect('intervencion');
            } else {
                Alert::error('Modificación Errónea!', 'El gestor de la articulación no se ha cambiado!')->showConfirmButton('Ok', '#3085d6');
                return back();
            }
        }
    }

}
