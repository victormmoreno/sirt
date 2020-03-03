<?php

namespace App\Http\Controllers;

use App\Http\Requests\EquipoFormRequest;
use App\Models\Equipo;
use App\Models\Nodo;
use App\Repositories\Datatables\EquipoDatatables;
use App\Repositories\Repository\EquipoRepository;
use App\Repositories\Repository\LineaRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Repositories\Repository\NodoRepository;

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
    public function index(EquipoDatatables $equipoDatatables)
    {

        if (request()->ajax()) {

            if (session()->has('login_role') && session()->get('login_role') == User::IsDinamizador() || session()->get('login_role') == User::IsGestor()) {

                if (session()->has('login_role') && session()->get('login_role') == User::IsDinamizador()) {
                    $nodo = auth()->user()->dinamizador->nodo->id;

                    $equipos = $this->getEquipoRepository()->getInfoDataEquipos()
                        ->whereHas('nodo', function ($query) use ($nodo) {
                            $query->where('id', $nodo);
                        })->get();

                } elseif (session()->has('login_role') && session()->get('login_role') == User::IsGestor()) {
                    $linea   = auth()->user()->gestor->lineatecnologica->id;
                    $nodo    = auth()->user()->gestor->nodo->id;
                    $equipos = $this->getEquipoRepository()->getInfoDataEquipos()
                        ->whereHas('nodo', function ($query) use ($nodo) {
                            $query->where('id', $nodo);
                        })
                        ->whereHas('lineatecnologica', function ($query) use ($linea) {
                            $query->where('id', $linea);
                        })->get();
                }

                return $equipoDatatables->indexDatatable($equipos);
            } else {
                abort('403');
            }

        }

        switch (Session::get('login_role')) {
            case User::IsAdministrador():
                return view('equipo.index', [
                    'nodos' => $this->getNodoRepository()->getSelectNodo(),
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
     * devolver datatables equipos por nodo.
     *
     * @param  int nodo
     * @return \Illuminate\Http\Response
     */
    public function getEquiposPorNodo(EquipoDatatables $equipoDatatables,$nodo)
    {

        if (request()->ajax()) {

            if (session()->has('login_role') && session()->get('login_role') == User::IsAdministrador()) {

                $equipos = $this->getEquipoRepository()->getInfoDataEquipos()
                    ->whereHas('nodo', function ($query) use ($nodo) {
                        $query->where('id', $nodo);
                    })->get();

                return $equipoDatatables->getEquiposPorNodoDatatables($equipos);
            } else {
                return response()->json(['data' => 'no response']);
            }

        } else {
            abort('403');
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
                    
                    // ->whereHas('nodo', function ($query) use ($nodo) {
                    //     $query->where('id', $nodo);
                    // })
                    // ->whereHas('lineatecnologica', function ($query) use ($lineatecnologica) {
                    //     $query->where('id', $lineatecnologica);
                    // })
                    // ->get();
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

        //metodo para guardad
        $equipoCreate = $this->getEquipoRepository()->storeEquipo($request);

        if ($equipoCreate === true) {

            alert()->success('Registro Exitoso.', 'El equipo ha sido creado satisfactoriamente');
        } else {
            alert()->error('Registro Erróneo.', 'El equipo no se ha creado.');
        }
        return redirect()->route('equipo.index');
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
            $equipo = $this->getEquipoRepository()->getInfoDataEquipos()->findOrFail($id);
            $this->authorize('edit', $equipo);
            $nodo               = auth()->user()->dinamizador->nodo->id;
            $lineastecnologicas = $this->getLineaTecnologicaRepository()->findLineasByIdNameForNodo($nodo);
            // return $lineastecnologicas;
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
        $equipo = $this->getEquipoRepository()->getInfoDataEquipos()->findOrFail($id);
        $this->authorize('update', $equipo);

        $equipoUpdate = $this->getEquipoRepository()->updateEquipo($request, $equipo);
        if ($equipoUpdate == true) {

            alert()->success("El equipo ha sido  modificado.", 'Modificación Exitosa', "success");
        } else {
            alert()->error("El equipo no ha sido  modificado.", 'Modificación Errónea', "error");
        }

        return redirect()->route('equipo.index');

    }

}
