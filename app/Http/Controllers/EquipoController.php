<?php

namespace App\Http\Controllers;

use App\Http\Requests\EquipoFormRequest;
use App\Models\Equipo;
use App\Models\Nodo;
use App\Repositories\Repository\EquipoRepository;
use App\Repositories\Repository\LineaRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Repositories\Repository\NodoRepository;

class EquipoController extends Controller
{

    public function __construct(EquipoRepository $equipoRepository, LineaRepository $lineaRepository, NodoRepository $nodoRepository)
    {
        $this->equipoRepository = $equipoRepository;
        $this->lineaRepository  = $lineaRepository;
        $this->nodoRepository   = $nodoRepository;
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {

            if (session()->has('login_role') && session()->get('login_role') == User::IsDinamizador() || session()->get('login_role') == User::IsGestor()) {

                if (session()->has('login_role') && session()->get('login_role') == User::IsDinamizador()) {
                    $nodo    = auth()->user()->dinamizador->nodo->id;
                    $equipos = $this->getEquipoRepository()->getInfoDataEquipos()->where('nodos.id', $nodo)->get();
                } elseif (session()->has('login_role') && session()->get('login_role') == User::IsGestor()) {
                    $linea   = auth()->user()->gestor->lineatecnologica->id;
                    $nodo    = auth()->user()->gestor->nodo->id;
                    $equipos = $this->getEquipoRepository()->getInfoDataEquipos()
                        ->where('nodos.id', $nodo)
                        ->where('lineastecnologicas.id', $linea)
                        ->get();
                }

                return datatables()->of($equipos)
                    ->addColumn('edit', function ($data) {
                        $button = '<a href="' . route("equipo.edit", $data->id) . '" class=" btn tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';

                        return $button;
                    })
                    ->addColumn('anio_fin_depreciacion', function ($data) {
                        return $data->vida_util + $data->anio_compra;
                    })
                    ->addColumn('depreciacion_por_anio', function ($data) {
                        return '$ ' . number_format(round($data->costo_adquisicion / $data->vida_util, 2));
                    })
                    ->editColumn('costo_adquisicion', function ($data) {
                        return '$ ' . number_format($data->costo_adquisicion);
                    })
                    ->editColumn('nombrelinea', function ($data) {
                        return $data->abreviatura . ' - ' . $data->nombrelinea;
                    })

                    ->rawColumns(['edit', 'nombrelinea', 'costo_adquisicion', 'anio_fin_depreciacion'])
                    ->make(true);
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
    public function getEquiposPorNodo($nodo)
    {

        if (request()->ajax()) {

            if (session()->has('login_role') && session()->get('login_role') == User::IsAdministrador()) {

                $equipos = $this->getEquipoRepository()->getInfoDataEquipos()->where('nodos.id', $nodo)->get();

                return datatables()->of($equipos)
                    ->addColumn('edit', function ($data) {
                        $button = '<a href="' . route("equipo.edit", $data->id) . '" class=" btn tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';

                        return $button;
                    })
                    ->addColumn('anio_fin_depreciacion', function ($data) {
                        return $data->vida_util + $data->anio_compra;
                    })
                    ->addColumn('depreciacion_por_anio', function ($data) {
                        return '$ ' . number_format(round($data->costo_adquisicion / $data->vida_util, 2));
                    })
                    ->editColumn('costo_adquisicion', function ($data) {
                        return '$ ' . number_format($data->costo_adquisicion);
                    })
                    ->editColumn('nombrelinea', function ($data) {
                        return $data->abreviatura . ' - ' . $data->nombrelinea;
                    })

                    ->rawColumns(['edit', 'nombrelinea', 'costo_adquisicion', 'anio_fin_depreciacion'])
                    ->make(true);
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
     * @param  int linea
     * @return \Illuminate\Http\Response
     */
    public function getEquiposPorLinea($linea)
    {
        if (request()->ajax()) {
            if (session()->has('login_role') && session()->get('login_role') == User::IsDinamizador()) {
                $equipos = $this->getEquipoRepository()->getInfoDataEquipos()
                    ->where('nodos.id', auth()->user()->dinamizador->nodo->id)
                    ->where('lineastecnologicas.id', $linea)
                    ->get();

                return response()->json([
                    'equipos' => $equipos,
                ]);
            }

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Asigna un valor a $equipoRepository
     * @param object $equipoRepository
     * @return void
     * @author devjul
     */
    private function setEquipoRepository($equipoRepository)
    {
        $this->equipoRepository = $equipoRepository;
    }

    /**
     * Retorna el valor de $equipoRepository
     * @return object
     * @author devjul
     */
    private function getEquipoRepository()
    {
        return $this->equipoRepository;
    }

    /**
     * Asigna un valor a $lineaRepository
     * @param object $lineaRepository
     * @return void
     * @author devjul
     */
    private function setLineaTecnologicaRepository($lineaRepository)
    {
        $this->lineaRepository = $lineaRepository;
    }

    /**
     * Retorna el valor de $lineaRepository
     * @return object
     * @author devjul
     */
    private function getLineaTecnologicaRepository()
    {
        return $this->lineaRepository;
    }

    /**
     * Asigna un valor a $nodoRepository
     * @param object $nodoRepository
     * @return void
     * @author devjul
     */
    private function setNodoRepository($nodoRepository)
    {
        $this->nodoRepository = $nodoRepository;
    }

    /**
     * Retorna el valor de $nodoRepository
     * @return object
     * @author devjul
     */
    private function getNodoRepository()
    {
        return $this->nodoRepository;
    }
}
