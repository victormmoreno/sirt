<?php

namespace App\Http\Controllers;

use Illuminate\Http\{Request, Response};
use App\Http\Requests\{EmpresaFormRequest};
use App\Models\{Empresa, Sector, TamanhoEmpresa, TipoEmpresa, Sede};
use App\Repositories\Repository\{EmpresaRepository, UserRepository\UserRepository};
use Illuminate\Support\Facades\{Session, Validator};
Use App\User;

class EmpresaController extends Controller
{
    private $empresaRepository;
    private $userRepository;

    public function __construct(EmpresaRepository $empresaRepository, UserRepository $userRepository)
    {
        $this->empresaRepository = $empresaRepository;
        $this->userRepository = $userRepository;
        $this->middleware([
            'auth',
        ]);
    }

    public function detalle(int $id)
    {
        $empresa = $this->empresaRepository->consultarDetallesDeUnaEmpresa($id);
        if (!request()->user()->can('show', $empresa)) {
            alert('No autorizado', 'No puedes ver la información de esta empresa', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        return view('empresa.show', ['empresa' => $empresa]);
    }

    public function search_empresa(Request $request)
    {
        $empresas = Empresa::where('nit', 'like', '%'.$request->txtnit_search.'%')->get();
        $urls = [];
        foreach ($empresas as $empresa) {
            $urls[] = route('empresa.detalle', $empresa->id);
        }
        return response()->json([
            'empresas' => $empresas,
            'urls' => $urls,
            'state' => 'search'
        ]);
    }

    public function search()
    {
        return view('empresa.search');
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    * @author Victor Manuel Moreno Vega
    */
    public function index()
    {
        if (!request()->user()->can('index', Empresa::class)) {
            alert('No autorizado', 'No puedes ver la información de empresas', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        return view('empresa.index');
    }

    public function datatableEmpresas($empresas)
    {
        return datatables()->of($empresas)
            ->addColumn('details', function ($data) {
            $button = '
            <a class="btn bg-info m-b-xs" href="'.route('empresa.detalle', $data->id).'">
                <i class="material-icons">search</i>
            </a>
            ';
            return $button;
            })->addColumn('add_propietario', function ($data) {
                $add_propietario = '<a onclick="addEntidadEmpresa('.$data->id.')" class="btn bg-secondary m-b-xs"><i class="material-icons">done</i></a>';
                return $add_propietario;
            })
            ->addColumn('add_company_art', function ($data) {
                $add_propietario = '<a onclick="addCompanyArticulacion('.$data->id.')" class="btn bg-secondary m-b-xs"><i class="material-icons">done</i></a>';
                return $add_propietario;
            })
            ->rawColumns(['details', 'edit', 'add_propietario', 'add_company_art'])->make(true);
    }

    // Datatable que muestra las empresas de tecnoparque por parte del dinamizador
    public function datatableEmpresasDeTecnoparque()
    {
        if (Session::get('login_role') == User::IsTalento()) {
            $empresas = $this->empresaRepository->consultarEmpresas()->where('users.id', auth()->user()->id)->get();
        } else {
            $empresas = $this->empresaRepository->consultarEmpresas()->get();
        }
        return $this->datatableEmpresas($empresas);
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    * @author Victor Manuel Moreno Vega
    */
    public function create()
    {
        if (!request()->user()->can('create', Empresa::class)) {
            alert('No autorizado', 'No puedes registrar información de empresas', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        return view('empresa.create', [
        'departamentos' => $this->userRepository->getAllDepartamentos(),
        'sectores' => Sector::SelectAllSectors()->get(),
        'tamanhos' => TamanhoEmpresa::all(),
        'tipos' => TipoEmpresa::all()
        ]);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    * @author Julian Dario Londoño Raigosa
    */
    public function store(Request $request)
    {
        if (!request()->user()->can('create', Empresa::class)) {
            alert('No autorizado', 'No puedes registrar información de empresas', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        $req = new EmpresaFormRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());

        $message = "";
        if ($validator->fails()) {
            return response()->json([
                'state'   => 'error_form',
                'fail'   => true,
                'errors' => $validator->errors(),
            ]);
        } else {
            $company = $this->empresaRepository->store($request);
            if ($company['state']) {
                $message = 'La empresa ha sido creada satisfactoriamente';
                return response()->json([
                    'state'   => 'success',
                    'message' => $message,
                    'url' => route('empresa'),
                ]);
            }
            return response()->json([
                'state'   => 'error',
                'message' => 'La empresa no se ha creado',
                'url' => false
            ]);
        }
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    * @author Victor Manuel Moreno Vega
    */
    public function edit($id)
    {
        $empresa = $this->empresaRepository->consultarDetallesDeUnaEmpresa($id);
        if (!request()->user()->can('edit', $empresa)) {
            alert('No autorizado', 'No puedes cambiar la informacion de esta empresa', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        return view('empresa.edit', [
            'empresa' => $empresa,
            'departamentos' => $this->userRepository->getAllDepartamentos(),
            'sectores' => Sector::SelectAllSectors()->get(),
            'tamanhos' => TamanhoEmpresa::all(),
            'tipos' => TipoEmpresa::all()
        ]);

    }

    public function ajaxDeUnaSede(string $id)
    {
        $sede = $this->empresaRepository->consultarSedeRepository($id)->first();
        return response()->json([
            'sede' => $sede
        ]);
    }

    public function ajaxDeUnaEmpresa(string $value, string $field)
    {
        $empresa = $this->empresaRepository->consultarEmpresaParams($value, $field)->first();
        return response()->json([
        'empresa' => $empresa
        ]);
    }

    /**
    * Formulario para cambiar la información de las sedes
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    * @author Victor Manuel Moreno Vega
    */
    public function add_sede($id)
    {
        $empresa = $this->empresaRepository->consultarDetallesDeUnaEmpresa($id);

        return view('empresa.add_sede', [
            'empresa' => $empresa,
            'departamentos' => $this->userRepository->getAllDepartamentos()
        ]);
    }

    /**
    * Formulario para cambiar la información de las sedes
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    * @author Victor Manuel Moreno Vega
    */
    public function sedes_edit($id, $id_sede)
    {
        $empresa = $this->empresaRepository->consultarDetallesDeUnaEmpresa($id);
        if (!request()->user()->can('edit', $empresa)) {
            alert('No autorizado', 'No puedes cambiar la informacion de esta empresa', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        $sede = $empresa->sedes->where('id', $id_sede)->first();
        return view('empresa.edit_sede', [
            'empresa' => $empresa,
            'sede' => $sede,
            'departamentos' => $this->userRepository->getAllDepartamentos()
        ]);
    }

    /**
    * Formulario para cambiar el responsable de la empresa
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    * @author Victor Manuel Moreno Vega
    */
    public function form_responsable($id)
    {
        $empresa = $this->empresaRepository->consultarDetallesDeUnaEmpresa($id);
        if (!request()->user()->can('edit', $empresa)) {
            alert('No autorizado', 'No puedes cambiar la informacion de esta empresa', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        return view('empresa.edit_responsable', [
            'empresa' => $empresa
        ]);
    }

    /**
    * Cambiar el responsable de la empresa
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    * @author Victor Manuel Moreno Vega
    */
    public function update_responsable(Request $request, $id)
    {
        $empresa = $this->empresaRepository->consultarDetallesDeUnaEmpresa($id);
        if (!request()->user()->can('edit', $empresa)) {
            alert('No autorizado', 'No puedes cambiar la informacion de esta empresa', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }

        if ($request->input('txttype_search') == 1) {
            $messages = [
                'txtsearch_user.required' => 'El número de documento es obligatorio.',
                'txtsearch_user.digits_between' => 'El número de documento debe tener entre 6 y 11 dígitos.',
                'txtsearch_user.numeric' => 'El número de documento debe ser numérico.'
            ];
            $validator = Validator::make($request->all(), [
                'txtsearch_user' => 'required|digits_between:6,11|numeric',
                'txttype_search' => 'required|in:1',
            ], $messages);
            if ($validator->fails()) {
                return response()->json([
                    'state'   => 'error_form',
                    'fail'   => true,
                    'errors' => $validator->errors()
                ]);
            }
        } else {
            $messages = [
                'txtsearch_user.required' => 'El correo electrónico es obligatorio.',
                'txtsearch_user.email' => 'El correo electrónico digitado no es válido.'
            ];
            $validator = Validator::make($request->all(), [
                'txtsearch_user' => 'required|email',
                'txttype_search' => 'required|in:2',
            ], $messages);
            if ($validator->fails()) {
                return response()->json([
                    'state'   => 'error_form',
                    'fail'   => true,
                    'errors' => $validator->errors()
                ]);
            }
        }

        $result = $this->empresaRepository->update_responsable($request, $empresa);
        if ($result['state']) {
            return response()->json([
                'state' => 'update',
                'url' => route('empresa.detalle', $id),
                'title' => $result['title'],
                'msg' => $result['msg'],
                'type' => $result['type']
            ]);
        } else {
            return response()->json([
                'state' => 'no_update',
                'title' => $result['title'],
                'msg' => $result['msg'],
                'type' => $result['type']
            ]);
        }

    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    * @author Victor Manuel Moreno Vega
    */
    public function update(Request $request, $id)
    {
        $empresa = $this->empresaRepository->consultarDetallesDeUnaEmpresa($id);
        if (!request()->user()->can('edit', $empresa)) {
            alert('No autorizado', 'No puedes cambiar la informacion de esta empresa', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        $req       = new EmpresaFormRequest;
        $validator = Validator::make($request->all(), $req->rules('just_comp'), $req->messages());


        if ($validator->fails()) {
            return response()->json([
                'state'   => 'error_form',
                'fail'   => true,
                'errors' => $validator->errors(),
            ]);

        } else {
            $result = $this->empresaRepository->update($request, $empresa);
            if ($result['state']) {
                return response()->json([
                    'state' => 'update',
                    'url' => route('empresa.detalle', $id),
                    'title' => $result['title'],
                    'msg' => $result['msg'],
                    'type' => $result['type']
                ]);
            } else {
                return response()->json([
                    'state' => 'no_update',
                    'title' => $result['title'],
                    'msg' => $result['msg'],
                    'type' => $result['type']
                ]);
            }
        }
    }

    public function update_sede(Request $request, $id, $id_sede)
    {
        $empresa = $this->empresaRepository->consultarDetallesDeUnaEmpresa($id);
        if (!request()->user()->can('edit', $empresa)) {
            alert('No autorizado', 'No puedes cambiar la informacion de esta empresa', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        $sede = $empresa->sedes->where('id', $id_sede)->first();

        $req       = new EmpresaFormRequest;
        $validator = Validator::make($request->all(), $req->rules('just_hq'), $req->messages());


        if ($validator->fails()) {
            return response()->json([
                'state'   => 'error_form',
                'fail'   => true,
                'errors' => $validator->errors(),
            ]);

        } else {
            $result = $this->empresaRepository->updateSedes($request, $sede);
            if ($result['state']) {
                return response()->json([
                    'state' => 'update',
                    'url' => route('empresa.detalle', $id),
                    'title' => $result['title'],
                    'msg' => $result['msg'],
                    'type' => $result['type']
                ]);
            } else {
                return response()->json([
                    'state' => 'no_update',
                    'title' => $result['title'],
                    'msg' => $result['msg'],
                    'type' => $result['type']
                ]);
            }
        }
    }

    public function store_sede(Request $request, $id)
    {
        $empresa = $this->empresaRepository->consultarDetallesDeUnaEmpresa($id);
        if (!request()->user()->can('edit', $empresa)) {
            alert('No autorizado', 'No puedes cambiar la informacion de esta empresa', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        $req       = new EmpresaFormRequest;
        $validator = Validator::make($request->all(), $req->rules('just_hq'), $req->messages());


        if ($validator->fails()) {
            return response()->json([
                'state'   => 'error_form',
                'fail'   => true,
                'errors' => $validator->errors(),
            ]);

        } else {
            $result = $this->empresaRepository->storeSede($request, $empresa);
            if ($result['state']) {
                return response()->json([
                    'state' => 'store',
                    'url' => route('empresa.detalle', $id),
                    'title' => $result['title'],
                    'msg' => $result['msg'],
                    'type' => $result['type']
                ]);
            } else {
                return response()->json([
                    'state' => 'no_store',
                    'title' => $result['title'],
                    'msg' => $result['msg'],
                    'type' => $result['type']
                ]);
            }
        }
    }

    public function filterByCode($value)
    {

        if (request()->ajax()) {
            $company = Empresa::with([
                'entidad',
                'sedes',
            ])->where('nit', $value)
            ->first();

            if($company != null){
                return response()->json([
                    'data' => [
                        'empresa' => $company,
                        'status_code' => Response::HTTP_OK
                    ]
                ],Response::HTTP_OK);
            }

            return response()->json([
                'data' => [
                    'empresa' => null,
                    'status_code' => Response::HTTP_NOT_FOUND,
                ]
            ]);
        }else{
            abort('403');
        }
    }

    public function filterSede(int $id){
        if (request()->ajax()) {
            $sede = Sede::where('id', $id)->first();

            if($sede != null){
                return response()->json([
                    'data' => [
                        'sede' => $sede,
                        'status_code' => Response::HTTP_OK
                    ]
                ],Response::HTTP_OK);
            }

            return response()->json([
                'data' => [
                    'empresa' => null,
                    'status_code' => Response::HTTP_NOT_FOUND,
                ]
            ]);
        } else {
            abort('403');
        }
    }
}
