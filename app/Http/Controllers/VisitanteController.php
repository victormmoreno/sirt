<?php

namespace App\Http\Controllers;

use App\Http\Requests\VisitanteFormRequest;
use Illuminate\Support\Facades\{Session};
use App\Repositories\Repository\{VisitanteRepository};
use App\{User, Models\TipoDocumento, Models\TipoVisitante};
use RealRashid\SweetAlert\Facades\Alert;

class VisitanteController extends Controller
{

    /**
     * Objeto de la clase VisitanteRepository
     * @var object
     */
    public $visitanteRepository;
    public function __construct(VisitanteRepository $visitanteRepository)
    {
        $this->visitanteRepository = $visitanteRepository;
        $this->middleware('auth');
    }

    /**
     * Se consultan los datos del visitante por el número de documento
     * @param string doc Documento de identidad del visitante
     * @return Response
     */
    public function consultarVisitantePorDocumento($doc)
    {
        if (request()->ajax()) {
        $visitante = $this->visitanteRepository->consultarVisitantePorDocumentoRepository($doc);
        return response()->json([
            'visitante' => $visitante
        ]);
        }
    }

    /**
     * Consulta todos los visitantes del tecnoparque
     * @return Datatable
     */
    public function consultarVisitantesRedTecnoparque()
    {
        $visitantes = $this->visitanteRepository->visitantesRedTecnoparque();
        return datatables()->of($visitantes)
        ->addColumn('edit', function ($data) {
        $edit = '<a class="btn bg-warning m-b-xs" href='.route('visitante.edit', $data->id).'><i class="material-icons">edit</i></a>';
        return $edit;
        })->rawColumns(['edit'])->make(true);
    }

    /**
     * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        // if ( Session::get('login_role') == User::IsIngreso() ) {
        // return view('visitante.ingreso.index');
        // } else if ( Session::get('login_role') == User::IsDinamizador() ) {
        // return view('visitante.dinamizador.index');
        // } else {
        // }
        return view('visitante.index');
    }

    /**
     * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        if(!request()->user()->can('create', Visitante::class)) {
            alert('No autorizado', 'No tienes permisos para registrar visitantes', 'warning')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        return view('visitante.create', [
            'tiposdocumento' => TipoDocumento::orderBy('nombre')->get(),
            'tiposvisitante' => TipoVisitante::orderBy('nombre')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(VisitanteFormRequest $request)
    {
        if(!request()->user()->can('create', Visitante::class)) {
            alert('No autorizado', 'No tienes permisos para registrar visitantes', 'warning')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        $reg = $this->visitanteRepository->storeVisitanteRepository($request);
        if ($reg['reg']) {
        Alert::success('Registro Exitoso!', 'El Visitante se ha registrado satisfactoriamente')->showConfirmButton('Ok!', '#3085d6');
        return redirect('visitante');
        } else {
        Alert::error('Registro Erróneo!', 'El Visitante no se ha registrado')->showConfirmButton('Ok!', '#3085d6');
        return back()->withInput();
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
        if(!request()->user()->can('create', Visitante::class)) {
            alert('No autorizado', 'No tienes permisos para cambiar la información de los visitantes', 'warning')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        return view('visitante.edit', [
            'visitante' => $this->visitanteRepository->consultarVisitante($id),
            'tiposdocumento' => TipoDocumento::orderBy('nombre')->get(),
            'tiposvisitante' => TipoVisitante::orderBy('nombre')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(VisitanteFormRequest $request, $id)
    {
        if(!request()->user()->can('create', Visitante::class)) {
            alert('No autorizado', 'No tienes permisos para cambiar la información de los visitantes', 'warning')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        $update = $this->visitanteRepository->updateVisitanteRepository($request, $id);
        if ($update['update']) {
        Alert::success('Modificación Exitosa!', 'El Visitante se ha modificado satisfactoriamente')->showConfirmButton('Ok!', '#3085d6');
        return redirect('visitante');
        } else {
        Alert::error('Modificación Errónea!', 'El Visitante no se ha modificado')->showConfirmButton('Ok!', '#3085d6');
        return back()->withInput();
        }
    }
}
