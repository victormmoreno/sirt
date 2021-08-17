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
        $edit = '<a class="btn m-b-xs" href='.route('visitante.edit', $data->id).'><i class="material-icons">edit</i></a>';
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
        if ( Session::get('login_role') == User::IsIngreso() ) {
        return view('visitante.ingreso.index');
        } else if ( Session::get('login_role') == User::IsDinamizador() ) {
        return view('visitante.dinamizador.index');
        } else {
        return view('visitante.administrador.index');
        }
    }

    /**
     * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view('visitante.ingreso.create', [
        'tiposdocumento' => TipoDocumento::all()->pluck('nombre', 'id'),
        'tiposvisitante' => TipoVisitante::all()->pluck('nombre', 'id')
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
        return view('visitante.ingreso.edit', [
        'visitante' => $this->visitanteRepository->consultarVisitante($id),
        'tiposdocumento' => TipoDocumento::all()->pluck('nombre', 'id'),
        'tiposvisitante' => TipoVisitante::all()->pluck('nombre', 'id')
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
