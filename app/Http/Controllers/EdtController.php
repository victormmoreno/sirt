<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Session, Validator};
use App\Http\Requests\{EdtFormRequest};
use App\Repositories\Repository\EdtRepository;
use App\Models\{Edt, TipoEdt, AreaConocimiento, Nodo};
use App\User;
use App\Helpers\ArrayHelper;
use RealRashid\SweetAlert\Facades\Alert;

class EdtController extends Controller
{


    private $edtRepository;

    public function __construct(EdtRepository $edtRepository)
    {
        $this->edtRepository = $edtRepository;
        $this->middleware('auth');
    }

    /**
     * Elimina una edt de la base de datos
     *
     * @param int $id Id de la edt
     * @return Response
     * @author dum
     */
    public function eliminarEdt(int $id)
    {
        if ( Session::get('login_role') == User::IsDinamizador() ) {
        $delete = $this->edtRepository->eliminarEdt_Repository($id);
        return response()->json([
            'retorno' => $delete
        ]);
        } else {
        abort('403');
        }
    }

    /**
     * función para consultar las entidades (empresas) de una edt
    * @param int id Id de la edt
    * @param boolean tipo Tipo de petición que se hace (si es 1, se consultará para mostrar la entidades, si es 0 se consultará para mostrar información de la edt)
    * @return Response
    * @author Victor Manuel Moreno Vega
    */
    public function consultarDetallesDeUnaEdt($id, $tipo)
    {
        if (request()->ajax()) {
        $edt = $this->edtRepository->consultarDetalleDeUnaEdt($id)->toArray();
        $edt = ArrayHelper::validarDatoNullDeUnArray($edt);
        if ($tipo = 1) {
            $entidades = $this->edtRepository->entidadesDeUnaEdt($id);
            return response()->json([
            'entidades' => $entidades,
            'edt' => $edt
            ]);
        } else {
            return response()->json([
            'edt' => $edt,
            ]);
        }
        }
    }

    /**
     * Entregables de una edt
     * @param int id Id de la edt
     * @return Response
     * @author Victor Manuel Moreno Vega
     */
    public function entregables($id)
    {

        $edt = $this->edtRepository->consultarDetalleDeUnaEdt($id);

        if ( Session::get('login_role') == User::IsExperto() ) {
        return view('edt.gestor.evidencias', [
            'edt' => $edt,
        ]);
        } else if ( Session::get('login_role') == User::IsDinamizador() ) {
        return view('edt.dinamizador.evidencias', [
            'edt' => $edt
        ]);
        } else {
        return view('edt.dinamizador.evidencias', [
            'edt' => $edt
        ]);
        }
    }

    /**
     * Datatable que muestra las edts
    * @param object consulta Consulta la cual se generará la datatable
    * @return Response
    * @author Victor Manuel Moreno Vega
    */
    private function datatableEdts($consulta)
    {
        return datatables()->of($consulta)
        ->addColumn('details', function ($data) {
        $details = '
        <a class="btn light-blue m-b-xs" onclick="detallesDeUnaEdt(' . $data->id . ')">
            <i class="material-icons">info</i>
        </a>
        ';
        return $details;
        })->addColumn('edit', function ($data) {
        if ( $data->estado == 'Inactiva') {
            $edit = '<a class="btn m-b-xs" disabled><i class="material-icons">edit</i></a>';
        } else {
            $edit = '<a class="btn m-b-xs" href='.route('edt.edit', $data->id).'><i class="material-icons">edit</i></a>';
        }
        return $edit;
        })->addColumn('entregables', function ($data) {
        $entregables = '
        <a class="btn blue-grey m-b-xs" href='. route('edt.entregables', $data->id) .'>
            <i class="material-icons">library_books</i>
        </a>
        ';
        return $entregables;
        })->addColumn('business', function ($data) {
        $empresas = '
        <a class="btn cyan m-b-xs" onclick="verEntidadesDeUnaEdt(' . $data->id . ')">
            <i class="material-icons">business</i>
        </a>
        ';
        return $empresas;
        })->addColumn('delete', function ($data) {
        $disabled = 'disabled';
        if (Session::get('login_role') == User::IsDinamizador()) {
            $disabled = '';
        }
        $delete = '
        <a class="btn red lighten-3 m-b-xs" '.$disabled.' onclick="eliminarEdtPorId_event(' . $data->id . ', event)">
            <i class="material-icons">delete_sweep</i>
        </a>
        ';
        return $delete;
        })->rawColumns(['details', 'edit', 'business', 'entregables', 'delete'])->make(true);
    }

    /**
     * datatable para mostrar las edts de un nodo por año
     * @param int idnodo Id del nodo
     * @param string $anho Año de la fecha de inicio del edt
     * @return Collection
     */
    public function consultarEdtsDeUnNodo($idnodo, $anho)
    {
        $id = "";
        if ( Session::get('login_role') == User::IsDinamizador() ) {
        $id = auth()->user()->dinamizador->nodo_id;
        } else {
        $id = $idnodo;
        }
        $edts = $this->edtRepository->consultarEdtsDeUnNodo($id, $anho);
        return $this->datatableEdts($edts);
    }

    /**
     * Muestra las edts de un gestor
     * @param int id Id de un gestor
     * @param $anho Año de la fecha de inicio de la edt
     * @return Response
     * @author dum
     */
    public function consultarEdtsDeUnGestor($idgestor, $anho)
    {
        $id = "";
        if ( Session::get('login_role') == User::IsExperto() ) {
        $id = auth()->user()->experto->id;
        }
        $edts = $this->edtRepository->consultarEdtsDeUnGestor($id, $anho);
        return $this->datatableEdts($edts);
    }

    /**
     * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        if ( Session::get('login_role') == User::IsExperto() ) {
        return view('edt.gestor.index');
        } else if ( Session::get('login_role') == User::IsDinamizador() ) {
        return view('edt.dinamizador.index');
        } else {
        return view('edt.administrador.index', [
            'nodos' => Nodo::SelectNodo()->get()
        ]);
        }
    }

    /**
     * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view('edt.gestor.create', [
        'areasconocimiento' => AreaConocimiento::all()->pluck('nombre', 'id'),
        'tiposedt' => TipoEdt::all(),
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

        $req = new EdtFormRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
        return response()->json([
            'fail' => true,
            'errors' => $validator->errors(),
        ]);
        }
        $result = $this->edtRepository->storeEdtRepository($request);
        if ($result == false) {
        return response()->json([
            'fail' => false,
            'redirect_url' => "false"
        ]);
        } else {
        return response()->json([
            'fail' => false,
            'redirect_url' => url(route('edt'))
        ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    * @author Victor Manuel Moreno Vega
    *
    */
    public function edit($id)
    {
        if ( Session::get('login_role') == User::IsExperto() ) {
        return view('edt.gestor.edit', [
            'edt' => $this->edtRepository->consultarDetalleDeUnaEdt($id),
            'areasconocimiento' => AreaConocimiento::all()->pluck('nombre', 'id'),
            'tiposedt' => TipoEdt::all(),
            'entidades' => $this->edtRepository->entidadesDeUnaEdt($id)
        ]);
        } else {
        $edt = $this->edtRepository->consultarDetalleDeUnaEdt($id);
        $gestores = $this->gestorRepository->consultarGestoresPorLineaTecnologicaYNodoRepository($edt->linea_id, auth()->user()->dinamizador->nodo_id)->pluck('gestor', 'id');
        return view('edt.dinamizador.edit', [
            'edt' => $edt,
            'gestores' => $gestores
        ]);
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
        if ( Session::get('login_role') == User::IsExperto() ) {
        $req = new EdtFormRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
            'fail' => true,
            'errors' => $validator->errors(),
            ]);
        }
        $result = $this->edtRepository->updateEdtRepository($request, $id);
        if ($result == false) {
            return response()->json([
            'fail' => false,
            'redirect_url' => "false"
            ]);
        } else {
            return response()->json([
            'fail' => false,
            'redirect_url' => url(route('edt'))
            ]);
        }
        } else {
        $validator = Validator::make($request->all(), [
            'txtgestor_id' => 'required'
        ], ['txtgestor_id.required' => 'El Gestor es obligatorio.']);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $update = $this->edtRepository->updateGestorEdt_Repository($request, $id);
        if ($update) {
            Alert::success('Modificación Exitosa!', 'El gestor de la edt se ha cambiado!')->showConfirmButton('Ok', '#3085d6');
            return redirect('edt');
        } else {
            Alert::error('Modificación Errónea!', 'El gestor de la edt no se ha cambiado!')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        }

    }

    /**
     * Modifica los entregables de una edt
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function updateEntregables(Request $request, $id)
    {
        $result = $this->edtRepository->updateEntregableRepository($request, $id);
        if ($result) {
        Alert::success('Los entregables de la EDT se han modificado exitosamente!', 'Modificación Exitosa!')->showConfirmButton('Ok', '#3085d6');
        return redirect('edt');
        } else {
        Alert::error('Los entregables de la EDT no se han modificado!', 'Modificación Errónea!')->showConfirmButton('Ok', '#3085d6');
        }
    }
}
