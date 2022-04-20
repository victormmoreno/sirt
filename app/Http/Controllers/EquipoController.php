<?php

namespace App\Http\Controllers;

use App\Http\Requests\EquipoFormRequest;
use App\Models\{Equipo, Entidad};
use App\Datatables\EquipoDatatable;
use App\Repositories\Repository\EquipoRepository;
use App\Repositories\Repository\LineaRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Repositories\Repository\NodoRepository;
use App\Exports\Equipo\EquipoExport;

class EquipoController extends Controller
{

    public function __construct(EquipoRepository $equipoRepository, LineaRepository $lineaRepository, NodoRepository $nodoRepository)
    {
        $this->setEquipoRepository($equipoRepository);
        $this->setLineaTecnologicaRepository($lineaRepository);
        $this->setNodoRepository($nodoRepository);
        $this->middleware('auth');
    }

    /**
     * Asigna un valor a $equipoRepository
     * @param object $equipoRepository
     * @return void
     * @author devjul
     */
    public function setEquipoRepository($equipoRepository)
    {
        $this->equipoRepository = $equipoRepository;
    }

    /**
     * Retorna el valor de $equipoRepository
     * @return object
     * @author devjul
     */
    public function getEquipoRepository()
    {
        return $this->equipoRepository;
    }

    /**
     * Asigna un valor a $lineaRepository
     * @param object $lineaRepository
     * @return void
     * @author devjul
     */
    public function setLineaTecnologicaRepository($lineaRepository)
    {
        $this->lineaRepository = $lineaRepository;
    }

    /**
     * Retorna el valor de $lineaRepository
     * @return object
     * @author devjul
     */
    public function getLineaTecnologicaRepository()
    {
        return $this->lineaRepository;
    }

    /**
     * Asigna un valor a $nodoRepository
     * @param object $nodoRepository
     * @return void
     * @author devjul
     */
    public function setNodoRepository($nodoRepository)
    {
        $this->nodoRepository = $nodoRepository;
    }

    /**
     * Retorna el valor de $nodoRepository
     * @return object
     * @author devjul
     */
    public function getNodoRepository()
    {
        return $this->nodoRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, EquipoDatatable $equipoDatatable)
    {
        $this->authorize('view', Equipo::class);

        switch (\Session::get('login_role')) {
            case User::IsAdministrador():
                $nodo = $request->filter_nodo;
                $linea = null;
                break;
            case User::IsDinamizador():
                $nodo = auth()->user()->dinamizador->nodo_id;
                $linea = null;
                break;
            case User::IsGestor():
                $nodo = auth()->user()->gestor->nodo_id;
                $linea = auth()->user()->gestor->lineatecnologica_id;
                break;
            default:
                return abort('403');
                break;
        }
        if (request()->ajax()) {

            $equipos = [];
            if (($request->filled('filter_nodo') || $request->filter_nodo == null)  && ($request->filled('filter_state') || $request->filter_state == null)) {
                $equipos = Equipo::deletedAt($request->filter_state)
                    ->nodoEquipo($nodo)
                    ->lineaEquipo($linea)
                    ->orderBy('equipos.created_at', 'desc')
                    ->get();
            }
            return $equipoDatatable->indexDatatable($equipos);
        }

        switch (Session::get('login_role')) {
            case User::IsAdministrador():
                return view('equipo.index', [
                    'nodos' =>  Entidad::has('nodo')->with('nodo')->get()->pluck('nombre', 'nodo.id'),
                ]);
                break;
            case User::IsDinamizador():
                return view('equipo.index');
                break;
            case User::IsGestor():
                return view('equipo.index');
                break;
            default:
                return abort('403');
                break;
        }
    }

    /**
     * devolver consulta de equipos por linea Tecnologica.
     *
     * @param  int lineatecnologica
     * @param  int nodo
     * @return \Illuminate\Http\Response
     */
    public function getEquiposPorLinea($nodo, $lineatecnologica)
    {
        if (request()->ajax()) {

            if (isset($nodo)) {
                $equipos = $this->getEquipoRepository()->getInfoDataEquipos()
                    ->where('nodo_id', $nodo)
                    ->where('lineatecnologica_id', $lineatecnologica)
                    ->get();
            } else {
                $equipos = $this->getEquipoRepository()->getInfoDataEquipos()
                    ->whereHas('lineatecnologica', function ($query) use ($lineatecnologica) {
                        $query->where('id', $lineatecnologica);
                    })->get();
            }

            return response()->json([
                'equipos' => $equipos,
            ]);
        } else {
            abort('403');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $this->authorize('create', Equipo::class);
        if (session()->has('login_role') && session()->get('login_role') == User::IsDinamizador()) {
            $nodoDinamizador = auth()->user()->dinamizador->nodo->id;

            $lineastecnologicas = $this->getLineaTecnologicaRepository()->findLineasByIdNameForNodo($nodoDinamizador);

            return view('equipo.create', [
                'lineastecnologicas' => $lineastecnologicas,
                'year'               => Carbon::now()->isoFormat('YYYY'),
            ]);
        } else {
            abort('403');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EquipoFormRequest $request)
    {
        $this->authorize('store', Equipo::class);

        $equipoCreate = $this->getEquipoRepository()->storeEquipo($request);

        if ($equipoCreate === true) {

            alert()->success('Registro Exitoso.', 'El equipo ha sido creado satisfactoriamente');
        } else {
            alert()->error('Registro Erróneo.', 'El equipo no se ha creado.');
        }
        return redirect()->route('equipo.index');
    }


    /**
     * Show a the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $equipo = Equipo::with(['lineatecnologica'])->withTrashed()->find($id);

        if ($equipo !== null) {
            $anioDepreciacion = $equipo->present()->equipoAnioDepreciacion();
            $depreciacionPorAnio = $equipo->present()->equipoDepreciacionPorAnio();

            // $anioDepreciacion = $equipo->vida_util + $equipo->anio_compra;

            // if ($equipo->vida_util > 0 && $equipo->costo_adquisicion > 0) {
            //     $depreciacionPorAnio = number_format(round($equipo->costo_adquisicion) / $equipo->vida_util, 0);
            // } else {
            //     $depreciacionPorAnio = number_format(round($equipo->costo_adquisicion), 0);
            // }

            return response()->json([
                'data' => [
                    'equipo' => $equipo,
                    'aniodepreciacion' => $anioDepreciacion,
                    'depreciacion' => $depreciacionPorAnio
                ],
                'status' => 'success',
                'statusCode' =>  Response::HTTP_OK
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'data' => [],
                'status' => 'recurso no encontrado',
                'statusCode' =>  Response::HTTP_NOT_FOUND
            ],  Response::HTTP_NOT_FOUND);
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

        if (session()->has('login_role') && session()->get('login_role') == User::IsDinamizador()) {
            $equipo = $this->getEquipoRepository()->getInfoDataEquipos()->withTrashed()->findOrFail($id);
            $this->authorize('edit', $equipo);
            $nodo               = auth()->user()->dinamizador->nodo->id;
            $lineastecnologicas = $this->getLineaTecnologicaRepository()->findLineasByIdNameForNodo($nodo);

            return view('equipo.edit', [
                'year'               => Carbon::now()->isoFormat('YYYY'),
                'lineastecnologicas' => $lineastecnologicas,
                'equipo'             => $equipo,
            ]);
        } else {
            abort('403');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EquipoFormRequest $request, $id)
    {
        $equipo = $this->getEquipoRepository()->getInfoDataEquipos()->withTrashed()->findOrFail($id);
        $this->authorize('update', $equipo);

        $equipoUpdate = $this->getEquipoRepository()->updateEquipo($request, $equipo);
        if ($equipoUpdate == true) {

            alert()->success("El equipo ha sido  modificado.", 'Modificación Exitosa', "success");
        } else {
            alert()->error("El equipo no ha sido  modificado.", 'Modificación Errónea', "error");
        }

        return redirect()->route('equipo.index');
    }

    /**
     * delete the specified resource in detroy.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $equipo = Equipo::withTrashed()->findOrFail($id);

        $cantidadUso = $equipo->usoinfraestructuras->count();
        $cantidadMantenimiento = $equipo->equiposmantenimientos->count();

        $this->authorize('destroy', $equipo);

        if ($cantidadUso > 0 || $cantidadMantenimiento > 0) {
            return response()->json([
                'equipo' => $equipo,
                'statusCode' => Response::HTTP_IM_USED,
                'message' => 'no puedes eliminar el equipo.',
            ], Response::HTTP_IM_USED);
        }
        $equipo->forceDelete();
        return response()->json([
            'statusCode' => Response::HTTP_OK,
            'message' => 'el equipo fue eliminado',
            'route' => route('equipo.index')
        ], Response::HTTP_OK);
    }
    /**
     * change state the specified resource in detroy.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeState(int $id)
    {

        $equipo = Equipo::withTrashed()->findOrFail($id);
        $this->authorize('changeState', $equipo);

        if ($equipo->trashed()) {
            $equipo->restore();
        } else {
            $equipo->delete();
        }
        return response()->json([
            'statusCode' => Response::HTTP_OK,
            'message' => 'estado cambiado',
            'route' => route('equipo.index')
        ], Response::HTTP_OK);
    }

    public function export(Request $request, $extension = 'xlsx')
    {
        $this->authorize('view', Equipo::class);

        switch (\Session::get('login_role')) {
            case User::IsAdministrador():
                $nodo = $request->filter_nodo;
                $linea = null;
                break;
            case User::IsDinamizador():
                $nodo = auth()->user()->dinamizador->nodo_id;
                $linea = null;
                break;
            case User::IsGestor():
                $nodo = auth()->user()->gestor->nodo_id;
                $linea = auth()->user()->gestor->lineatecnologica_id;
                break;
            default:
                return abort('403');
                break;
        }

        $equipos = [];
        if (($request->filled('filter_nodo') || $request->filter_nodo == null)  && ($request->filled('filter_state') || $request->filter_state == null)) {
            $equipos = Equipo::deletedAt($request->filter_state)
                ->nodoEquipo($nodo)
                ->lineaEquipo($linea)
                ->orderBy('equipos.created_at', 'desc')
                ->get();
        }

        return (new EquipoExport($request, $equipos))->download("Equipos - " . config('app.name') . ".{$extension}");
    }
}
