<?php

namespace App\Http\Controllers;

use App\Models\Laboratorio;
use App\Models\Nodo;
use App\Repositories\Repository\LaboratorioRepository;
use App\Repositories\Repository\LineaRepository;
use App\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Repositories\Repository\NodoRepository;

class LaboratorioController extends Controller
{

    public $laboratorioRepository;
    public $nodoRepository;

    public function __construct(LaboratorioRepository $laboratorioRepository, NodoRepository $nodoRepository)
    {
        $this->middleware('auth');
        $this->laboratorioRepository = $laboratorioRepository;
        $this->nodoRepository        = $nodoRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('index', Laboratorio::class);

        if (request()->ajax()) {
            if (session()->has('login_role') && session()->get('login_role') == User::IsDinamizador()) {
                return datatables()->of($this->laboratorioRepository->findLaboratorioForNodo(auth()->user()->dinamizador->nodo->id))
                    ->addColumn('materiales', function ($data) {

                        $button = '<a class="  btn tooltipped blue-grey m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Ver materiales de formación" href="#" onclick=""><i class="material-icons">info_outline</i></a>';

                        return $button;
                    })
                    ->editColumn('estado', function ($data) {
                        if ($data->estado == Laboratorio::IsActive()) {
                            return $data->estado = 'Habilitado';
                        } else {
                            return $data->estado = 'Inhabilitado ';
                        }
                    })
                    ->editColumn('lineatecnologica', function ($data) {
                        return $data->lineatecnologica->nombre;
                    })
                    ->editColumn('participacion_costos', function ($data) {
                        return $data->participacion_costos . ' %';
                    })

                    ->addColumn('edit', function ($data) {

                        $button = '<a href="' . route("laboratorio.edit", $data->id) . '" class=" btn tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';

                        return $button;
                    })
                    ->rawColumns(['materiales', 'estado', 'lineatecnologica', 'participacion_costos', 'edit'])
                    ->make(true);
            }

        }

        return view('laboratorio.index', [
            'nodos' => $this->nodoRepository->getSelectNodo(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(LineaRepository $lineaRepository)
    {

        $this->authorize('create', Laboratorio::class);

        if (session()->get('login_role') == User::IsAdministrador()) {

            return view('laboratorio.create', [
                'nodos' => $this->nodoRepository->getSelectNodo(),
            ]);
        } else if (session()->get('login_role') == User::IsDinamizador()) {

            $nodo = auth()->user()->dinamizador->nodo->id;

            return view('laboratorio.create', [
                'lineas' => $lineaRepository->findLineasByIdNameForNodo($nodo),
            ]);
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
        $this->validateLaboratorio($request);

        $laboratorio = $this->laboratorioRepository->create($request->all());

        if ($laboratorio == true) {
            Alert::success('Registro Exitoso!', 'El laboratorio se ha registrado exitosamente')->showConfirmButton('Ok', '#3085d6');
        } else {
            Alert::error("Registro Erróneo", 'El laboratorio  no se ha creado.')->showConfirmButton('Ok', '#3085d6');
        }
        return redirect()->route('laboratorio.index');
    }

    protected function validateLaboratorio(Request $request)
    {

        if (session()->get('login_role') == User::IsAdministrador()) {
            $request->validate([
                'txtnombre' => 'required|string|min:3|max:45',
                'txtnodo'   => 'required|integer',
                'txtlinea'  => 'required|integer',
                'txtcostos' => 'required|regex:/^[0-9]+([.][0-9]{1}+)?$/|numeric|between:0,100',
            ], $this->messagesValidationLaboratorio());
        } else if (session()->get('login_role') == User::IsDinamizador()) {
            $request->validate([
                'txtnombre' => 'required|string|min:3|max:45',
                'txtlinea'  => 'required|integer',
                'txtcostos' => 'required|regex:/^[0-9]+([.][0-9]{1}+)?$/|numeric|between:0,100',
            ], $this->messagesValidationLaboratorio());
        }

    }

    protected function messagesValidationLaboratorio()
    {
        return [
            'txtnombre.required' => 'El nombre del laboratorio es obligatorio',
            'txtnombre.min'      => 'El nombre debe ser minimo 3 caracteres',
            'txtnombre.max'      => 'El nombre debe ser máximo 45 caracteres',
            'txtnodo.required'   => 'El nodo es obligatorio',
            'txtlinea.required'  => 'La linea es obligatoria',
            'txtcostos.required' => 'El costo administrativo es obligatorio',
            'txtcostos.regex'    => 'El formato de costo administrativo  es inválido',
            'txtcostos.numeric'  => 'El costo administrativo  debe ser un valor númerico',
            'txtcostos.between'  => 'El costo administrativo  tiene que estar entre 0 - 100',
        ];
    }

/**
 * Display the specified resource.
 *
 * @param  \App\Laboratorio  $laboratorio
 * @return \Illuminate\Http\Response
 */
    public function show(Laboratorio $laboratorio)
    {
        //
    }

/**
 * Show the form for editing the specified resource.
 *
 * @param  \App\Laboratorio  $laboratorio
 * @return \Illuminate\Http\Response
 */
    public function edit(LineaRepository $lineaRepository, $id)
    {
        $laboratorio = $this->laboratorioRepository->findLaboratorioById($id);
        $this->authorize('edit', $laboratorio);

        if (session()->get('login_role') == User::IsAdministrador()) {

            return view('laboratorio.edit', [
                'nodos'       => $this->nodoRepository->getSelectNodo(),
                'laboratorio' => $laboratorio,
            ]);
        } else if (session()->get('login_role') == User::IsDinamizador()) {

            $nodo = auth()->user()->dinamizador->nodo->id;

            return view('laboratorio.edit', [
                'lineas'      => $lineaRepository->findLineasByIdNameForNodo($nodo),
                'laboratorio' => $laboratorio,
            ]);
        }

    }

/**
 * Update the specified resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  \App\Laboratorio  $id
 * @return \Illuminate\Http\Response
 */
    public function update(Request $request, $id)
    {

        $laboratorio = $this->laboratorioRepository->findLaboratorioById($id);
        $this->authorize('update', $laboratorio);
        $this->validateLaboratorio($request);

        if ((!$request->input('txtnodo')) && session()->has('login_role') && session()->get('login_role') == User::IsDinamizador()) {

            $request['txtnodo'] = auth()->user()->dinamizador->nodo->id;
            dd($request->all());
        }

        $laboratorio = $this->laboratorioRepository->update($laboratorio, $request->all());

        if ($laboratorio == true) {
            Alert::success('Modificación Exitosa', "El laboratorio ha sido  modificado exitosamente.", "success");
        } else {
            Alert::error('Modificación Errónea', "El laboratorio no se ha modificado.", "error");
        }

        return redirect()->route('laboratorio.index');

    }

    /**
     * devolver datatables laboratorio por nodo.
     *
     * @param  int nodo
     * @return \Illuminate\Http\Response
     */
    public function getLaboratorioPorNodo($nodo)
    {

        if (request()->ajax()) {
            return datatables()->of($this->laboratorioRepository->findLaboratorioForNodo($nodo))
                ->addColumn('materiales', function ($data) {

                    $button = '<a class="  btn tooltipped blue-grey m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Ver materiales de formación" href="#"><i class="material-icons">info_outline</i></a>';

                    return $button;
                })
                ->editColumn('estado', function ($data) {
                    if ($data->estado == Laboratorio::IsActive()) {
                        return $data->estado = 'Habilitado';
                    } else {
                        return $data->estado = 'Inhabilitado ';
                    }
                })
                ->editColumn('lineatecnologica', function ($data) {
                    return $data->lineatecnologica->nombre;
                })
                ->editColumn('participacion_costos', function ($data) {
                    return $data->participacion_costos . ' %';
                })

                ->addColumn('edit', function ($data) {

                    $button = '<a href="' . route("laboratorio.edit", $data->id) . '" class=" btn tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';

                    return $button;
                })
                ->rawColumns(['materiales', 'estado', 'lineatecnologica', 'participacion_costos', 'edit'])
                ->make(true);
        }
    }

}
