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
use Illuminate\Http\Response;
use Repositories\Repository\NodoRepository;
use App\Exports\Equipo\EquipoExport;

class EquipoController extends Controller
{

    public $equipoRepository;
    public $lineaRepository;
    public $nodoRepository;
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
        if(!request()->user()->can('view', Equipo::class)) {
            alert('No autorizado', 'No puedes ver equipos', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        if (request()->ajax()) {
            $nodo = request()->user()->getNodoUser() == null ? $request->filter_nodo : request()->user()->getNodoUser();
            $linea = $this->getEquipoRepository()->getLineaRole();
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

        return view('equipo.index', [
            'nodos' =>  Entidad::whereHas('nodo', function ($query) {
                return $query->where('estado', 1);
            })
            ->orderBy('nombre')
            ->get()
            ->pluck('nombre', 'nodo.id'),
        ]);
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
            if (session()->get('login_role') == User::IsActivador() || session()->get('login_role') == User::IsAdministrador()) {
                $nodo_id = $nodo;
            }
            if (session()->get('login_role') == User::IsDinamizador() || session()->get('login_role') == User::IsExperto() || session()->get('login_role') == User::IsApoyoTecnico()) {
                $nodo_id = request()->user()->getNodoUser();
            }

            if (session()->get('login_role') == User::IsExperto()) {
                if(isset($lineatecnologica)){
                    $linea_id = $lineatecnologica;
                }else{
                    $linea_id = auth()->user()->experto->linea_id;
                }
            }
            if (session()->get('login_role') == User::IsAdministrador() || session()->get('login_role') == User::IsActivador() || session()->get('login_role') == User::IsDinamizador() || session()->get('login_role') == User::IsApoyoTecnico()) {
                $linea_id = $lineatecnologica;
            }

            if (session()->get('login_role') == User::IsActivador() || session()->get('login_role') == User::IsAdministrador() || session()->get('login_role') == User::IsDinamizador() || session()->get('login_role') == User::IsApoyoTecnico()) {
                $equipos = $this->getEquipoRepository()->getInfoDataEquipos()
                ->where('nodo_id', $nodo_id)
                ->where('lineatecnologica_id', $linea_id)
                ->get();
            }
            if (session()->get('login_role') == User::IsExperto()) {
                $equipos = $this->getEquipoRepository()->getInfoDataEquipos()
                ->where('nodo_id', $nodo_id)
                ->where('lineatecnologica_id', $linea_id)
                ->get();
            }
            if (session()->get('login_role') == User::IsTalento()) {
                $equipos = $this->getEquipoRepository()->getInfoDataEquipos()
                ->where('nodo_id', $nodo)
                ->where('lineatecnologica_id', $lineatecnologica)
                ->get();
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

        if(!request()->user()->can('create', Equipo::class)) {
            alert('No autorizado', 'No puedes registrar equipos', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        $nodos = $this->getNodoRepository()->getSelectNodo();
        $nodo = request()->user()->getNodoUser() == null ? $nodos->first()->id : request()->user()->getNodoUser();
        $lineastecnologicas = $this->getLineaTecnologicaRepository()->getAllLineaNodo($nodo);
        // dd($lineastecnologicas);
        return view('equipo.create', [
            'lineastecnologicas' => $lineastecnologicas,
            'year' => Carbon::now()->isoFormat('YYYY'),
            'nodos' => $nodos
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EquipoFormRequest $request)
    {
        if(!request()->user()->can('create', Equipo::class)) {
            alert('No autorizado', 'No puedes registrar equipos', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        $equipoCreate = $this->getEquipoRepository()->storeEquipo($request);

        if ($equipoCreate) {
            alert()->success('Registro Exitoso.', 'El equipo ha sido registrado satisfactoriamente');
        } else {
            alert()->error('Registro Erróneo.', 'El equipo no se ha registrado.');
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

        $equipo = Equipo::with(['lineatecnologica', 'nodo.entidad'])->withTrashed()->find($id);
        if(!request()->user()->can('edit', $equipo)) {
            alert('No autorizado', 'No puedes cambiar la información de este equipo', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        $nodos = $this->getNodoRepository()->getSelectNodo();
        $lineastecnologicas = $this->getLineaTecnologicaRepository()->getAllLineaNodo($equipo->nodo_id);
        // $nodo               = auth()->user()->dinamizador->nodo->id;
        // $lineastecnologicas = $this->getLineaTecnologicaRepository()->findLineasByIdNameForNodo($nodo);

        return view('equipo.edit', [
            'year'               => Carbon::now()->isoFormat('YYYY'),
            'lineastecnologicas' => $lineastecnologicas,
            'equipo'             => $equipo,
            'nodos' => $nodos
        ]);
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
        if(!request()->user()->can('edit', $equipo)) {
            alert('No autorizado', 'No puedes cambiar la información de este equipo', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        $equipoUpdate = $this->getEquipoRepository()->updateEquipo($request, $equipo);
        if ($equipoUpdate == true) {
            alert()->success("El equipo ha sido  modificado.", 'Modificación Exitosa', "success");
        } else {
            alert()->error("El equipo no ha sido  modificado.", 'Modificación Errónea', "error");
        }

        return redirect()->route('equipo.index');
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
        // dd($equipo);
        if(!request()->user()->can('edit', $equipo)) {
            alert('No autorizado', 'No puedes cambiar la información de este equipo', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        if ($equipo->trashed()) {
            $equipo->restore();
        } else {
            $equipo->delete();
            $equipo->update(['destacado' => $equipo->NoDestacado()]);
        }
        return response()->json([
            'statusCode' => Response::HTTP_OK,
            'message' => 'estado cambiado',
            'route' => route('equipo.index')
        ], Response::HTTP_OK);
    }

    /**
     * Método que destacar o deja de destacar un equipo
     *
     * @param int $id Id del equipo
     * @return Response
     * @author dum
     **/
    public function destacarEquipo(int $id)
    {
        $equipo = Equipo::find($id);
        if(!request()->user()->can('destacar', $equipo)) {
            alert('No autorizado', 'No puedes destacar este equipo', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        // dd($equipo);
        $destacar = $this->getEquipoRepository()->destacar($equipo);
        return response()->json([
            'state' => $destacar['state'],
            'type' => $destacar['type'],
            'title' => $destacar['title'],
            'equipo' => $equipo,
            'message' => $destacar['msj']
        ]);
    }

    public function export(Request $request, $extension = 'xlsx')
    {
        $this->authorize('view', Equipo::class);

        switch (\Session::get('login_role')) {
            case User::IsAdministrador():
                $nodo = $request->filter_nodo;
                $linea = null;
                break;
            case User::IsActivador():
                $nodo = $request->filter_nodo;
                $linea = null;
                break;
            case User::IsAdministrador():
                $nodo = $request->filter_nodo;
                $linea = null;
                break;
            case User::IsDinamizador():
                $nodo = request()->user()->dinamizador->nodo_id;
                $linea = null;
                break;
            case User::IsApoyoTecnico():
                $nodo = request()->user()->apoyotecnico->nodo_id;
                $linea = null;
                break;
            case User::IsExperto():
                $nodo = request()->user()->experto->nodo_id;
                $linea = request()->user()->experto->linea_id;
                break;
            case User::IsInfocenter():
                $nodo = request()->user()->infocenter->nodo_id;
                $linea = null;
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

    /**
     * Formulario para importar equipos
     *
     * @return Response
     * @author dum
     **/
    public function importar()
    {
        if(!request()->user()->can('import', Equipo::class)) {
            alert('No autorizado', 'No puedes importar equipos de este nodo', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        return view('equipo.import');
    }

}
