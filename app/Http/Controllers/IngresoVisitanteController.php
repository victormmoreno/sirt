<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\IngresoVisitanteFormRequest;
use Illuminate\Support\Facades\{Session, Validator};
use App\Repositories\Repository\{IngresoVisitanteRepository, VisitanteRepository};
use App\{User, Models\TipoVisitante, Models\TipoDocumento, Models\Servicio, Models\Nodo};
use App\Exports\Ingresos\IngresosExport;
use App\Models\IngresoVisitante;

class IngresoVisitanteController extends Controller
{

    /**
     * Objeto de la clase IngresoVisitanteRepository
     * @var object
     */
    public $ingresoVisitanteRepository;

    /**
     * Objeto de la clase VisitanteRepository
     * @var object
     */
    public $visitanteRepository;

    public function __construct(IngresoVisitanteRepository $ingresoVisitanteRepository, VisitanteRepository $visitanteRepository)
    {
        $this->ingresoVisitanteRepository = $ingresoVisitanteRepository;
        $this->visitanteRepository = $visitanteRepository;
    }

    /**
     * Pinta la datatable para datos de los ingresos de visitantes
     * @param object $ingresos Datos de los cuales se mostrarán la datatable para ingresos
     * @return Response
     */
    private function datatableIngresos($ingresos)
    {
        return datatables()->of($ingresos)
        ->addColumn('edit', function ($data) {
        $edit = '<a class="btn bg-warning m-b-xs" href='.route('ingreso.edit', $data->id).'><i class="material-icons">edit</i></a>';
        return $edit;
        })->addColumn('details', function ($data) {
        $edit = '<a class="btn blue-grey m-b-xs" onclick="consultarDetalleDeUnIngreso('.$data->id.')"><i class="material-icons">info</i></a>';
        return $edit;
        })->rawColumns(['edit', 'details'])->make(true);
    }

    /**
     * Consulta los ingresos de un nodo de tecnoparque
     * @param int $id Id del nodo por el que se consultaran los ingresos de visitantes
     * @param string $start_date Primera fecha a consultar
     * @param string $end_date Segunda feha a consultar
     * @return Response
     */
    public function datatableIngresosDeUnNodo($id, $start_date, $end_date)
    {
        $id = request()->user()->getNodoUser() == null ? Nodo::first()->id : request()->user()->getNodoUser();
        $ingresos = $this->ingresoVisitanteRepository->consultarIngresosRepository()->where('nodos.id', $id)->whereBetween('fecha_ingreso', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])->get();
        return $this->datatableIngresos($ingresos);
    }
    /**
     * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return view('ingreso.index');
    }

    /**
     * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        if(!request()->user()->can('create', IngresoVisitante::class)) {
            alert('No autorizado', 'No tienes permisos para registrar ingresos de visitantes!', 'warning')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        return view('ingreso.create', [
            'tiposdocumento' => TipoDocumento::orderBy('nombre')->get(),
            'tiposvisitante' => TipoVisitante::orderBy('nombre')->get(),
            'servicios' => Servicio::orderBy('nombre')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $req = new IngresoVisitanteFormRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'fail' => true,
                'errors' => $validator->errors(),
            ]);
        }
        $result = $this->ingresoVisitanteRepository->storeIngresoVisitanteRepository($request);
        if ($result['store'] == false) {
            return response()->json([
                'fail' => false,
                'redirect_url' => false
            ]);
        } else {
            return response()->json([
                'fail' => false,
                'redirect_url' => url(route('ingreso.create'))
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
        $ingreso = $this->ingresoVisitanteRepository->consultarIngresoVisitantePorId($id);
        if(!request()->user()->can('edit', $ingreso)) {
            alert('No autorizado', 'No tienes permisos para cambiar la información de este ingreso de visitante!', 'warning')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        return view('ingreso.edit', [
            'tiposdocumento' => TipoDocumento::orderBy('nombre')->get(),
            'tiposvisitante' => TipoVisitante::orderBy('nombre')->get(),
            'servicios' => Servicio::orderBy('nombre')->get(),
            'ingreso' => $ingreso,
            'visitanteIng' => $this->visitanteRepository->consultarVisitante($ingreso->visitante_id)
        ]);
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
        $ingreso = $this->ingresoVisitanteRepository->consultarIngresoVisitantePorId($id);
        if(!request()->user()->can('edit', $ingreso)) {
            alert('No autorizado', 'No tienes permisos para cambiar la información de este ingreso de visitante', 'warning')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        $req = new IngresoVisitanteFormRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'fail' => true,
                'errors' => $validator->errors(),
            ]);
        }
        $result = $this->ingresoVisitanteRepository->updateIngresoVisitanteRepository($request, $id);
        if ($result['update'] == false) {
            return response()->json([
                'fail' => false,
                'redirect_url' => false
            ]);
        } else {
            return response()->json([
                'fail' => false,
                'redirect_url' => url(route('ingreso'))
            ]);
        }
    }

    public function export(Request $request, $extension = 'xlsx')
    {
        if(!request()->user()->can('export', IngresoVisitante::class)) {
            alert('No autorizado', 'No puedes descargar información de los ingresos de visitante', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        // dd($request->nodo);
        $ingresos = $this->ingresoVisitanteRepository->consultarIngresosRepository()->where('nodos.id', $request->nodo)->whereBetween('fecha_ingreso', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59'])->get();
        // dd($ingresos);
        // exit;
        return (new IngresosExport($ingresos))->download("Ingresos - " . $request->start_date ."-". $request->end_date .".{$extension}");
    }
}
