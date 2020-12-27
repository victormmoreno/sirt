<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\{EmpresaFormRequest, ContactoEntidadFormRequest};
use App\Models\{Empresa, Sector, TamanhoEmpresa, TipoEmpresa};
use App\Repositories\Repository\{EmpresaRepository, UserRepository\UserRepository, ContactoEntidadRepository, EntidadRepository};
use Illuminate\Support\Facades\{DB, Validator};
use App\Helpers\ArrayHelper;
Use App\User;

class EmpresaController extends Controller
{
  private $empresaRepository;
  private $userRepository;
  private $contactoEntidadRepository;
  private $entidadRepository;

  public function __construct(EmpresaRepository $empresaRepository, UserRepository $userRepository, ContactoEntidadRepository $contactoEntidadRepository, EntidadRepository $entidadRepository)
  {
    $this->empresaRepository = $empresaRepository;
    $this->userRepository = $userRepository;
    $this->contactoEntidadRepository = $contactoEntidadRepository;
    $this->entidadRepository = $entidadRepository;
    $this->middleware([
        'auth',
    ]);

  }

  /**
   * consulta los datos de un empresa según el ID DE ENTIDAD (ENTIDAD_ID)
   * @param int id Id de la entidad, por el cual se consultará la empresa
   * @return Response
   * @author Victor Manuel Moreno Vega
   */
  public function consultarEmpresaPorIdEntidad($id)
  {
    return response()->json([
      'detalles' => $this->entidadRepository->consultarEmpresaEntidadRepository($id),
    ]);
  }

  public function updateContactosEmpresa(Request $request, $id)
  {
    $req = new ContactoEntidadFormRequest;
    $validator = Validator::make($request->all(), $req->rules(), $req->messages(), $req->attributes());
    if ($validator->fails())
    return response()->json([
      'fail' => true,
      'errors' => $validator->errors(),
      // 'aditional' => $validator->parseData($validator->attributes()),
    ]);
    $result = $this->contactoEntidadRepository->update($request, $id);
    if ($result == false) {
      return response()->json([
          'fail' => false
      ]);
    }
  }

  // Consulta los contactos que tiene un empresa, según el id de la ENTIDAD y el nodo
  public function contactosDeLaEmpresaPorNodo($id)
  {
    if (request()->ajax()) {
      $idnodo_user = "";
      if (\Session::get('login_role') == User::IsGestor()) {
        $idnodo_user = auth()->user()->gestor->nodo_id;
      } else {
        $idnodo_user = auth()->user()->dinamizador->nodo_id;
      }

      $contactos = $this->empresaRepository->consultarContactosPorNodoDeUnaEmpresa($id, $idnodo_user)->toArray();

      $contactos = ArrayHelper::validarDatoNullDeUnArray($contactos);
      // dd($contactos);
      return response()->json([
        'contactos' => $contactos,
        'route' => url('/empresa/updateContactoDeUnaEmpresa') . '/' . $id,
      ]);
    }
  }

  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  * @author Victor Manuel Moreno Vega
  */
  public function index()
  {
    switch (\Session::get('login_role')) {
      case User::IsGestor():
        return view('empresa.gestor.index');
        break;
      case User::IsDinamizador():
        return view('empresa.dinamizador.index');
        break;
      case User::IsAdministrador():
        return view('empresa.administrador.index');
        break;
      default:

        break;
    }
  }
  // Datatable que muestra las empresas de tecnoparque por parte del dinamizador

  public function datatableEmpresasDeTecnoparque()
  {
    if (request()->ajax()) {
      if (\Session::get('login_role') == User::IsGestor()) {
        $empresas = $this->empresaRepository->consultarEmpresasDeRedTecnoparque();
        return datatables()->of($empresas)
        ->addColumn('details', function ($data) {
          $button = '
          <a class="btn light-blue m-b-xs modal-trigger" href="#!" onclick="empresaIndex.consultarDetallesDeUnaEmpresa('. $data->id .')">
            <i class="material-icons">info</i>
          </a>
          ';
          return $button;
        })->addColumn('contacts', function ($data) {
          $contact = '
          <a class="btn orange lighten-3 m-b-xs modal-trigger" id="#contactosDeUnaEntidad_modal" onclick="consultarContactosDeUnaEntidad('.$data->id_entidad.');">
          <i class="material-icons">local_phone</i>
          </a>
          ';
          return $contact;
        })->addColumn('edit', function ($data) {
          $edit = '<a href="'. route("empresa.edit", $data->id) .'" class="btn m-b-xs"><i class="material-icons">edit</i></a>';
          return $edit;
        })->addColumn('add_articulacion', function ($data) {
          $add = '<a onclick="addEmpresaArticulacion(' . $data->id . ')" class="btn blue m-b-xs"><i class="material-icons">done</i></a>';
          return $add;
        })->addColumn('add_propietario', function ($data) {
          $add_propietario = '<a onclick="addEntidadEmpresa(' . $data->id . ')" class="btn blue m-b-xs"><i class="material-icons">done</i></a>';
          return $add_propietario;
        })->addColumn('add_empresa_a_edt', function ($data) {
          return '<a class="btn blue m-b-xs" onclick="addEmpresaAEdt('.$data->id_entidad.')"><i class="material-icons">done_all</i></a>';
        })->rawColumns(['details', 'edit', 'add_articulacion', 'contacts', 'add_empresa_a_edt', 'add_propietario'])->make(true);
      } else {
        $empresas = $this->empresaRepository->consultarEmpresasDeRedTecnoparque();
        return datatables()->of($empresas)
        ->addColumn('details', function ($data) {
          $button = '
          <a class="btn light-blue m-b-xs modal-trigger" href="#modal1" onclick="empresaIndex.consultarDetallesDeUnaEmpresa('. $data->id .')">
          <i class="material-icons">info</i>
          </a>
          ';
          return $button;
        })->addColumn('contacts', function ($data) {
          $contact = '
          <a class="btn orange lighten-3 m-b-xs modal-trigger" href="#modal1" data-href='. route('empresa.contactos.nodo', $data->id_entidad) .'>
          <i class="material-icons">local_phone</i>
          </a>
          ';
          return $contact;
        })->addColumn('soft_delete', function ($data) {
          $edit = '<a class="btn m-b-xs"><i class="material-icons">sweep_delete</i></a>';
          return $edit;
        })->rawColumns(['details', 'soft_delete', 'contacts'])->make(true);
      }
    }
  }

  /**
   * Consulta que muestra los detalles de una empresa
   * @param $param Valor del parámetro por el que se va a filtrar la empresa.
   * @param $field Nombre del campo por el que se va a filtrar
   * @return Response
   */
  public function detalleDeUnaEmpresa(string $param, string $field)
  {
    $empresa = $this->empresaRepository->consultarDetallesDeUnaEmpresa($param, $field)->first();
    return response()->json([
      'empresa' => $empresa
    ]);
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  * @author Victor Manuel Moreno Vega
  */
  public function create()
  {
    if (\Session::get('login_role') == User::IsGestor()) {
      return view('empresa.gestor.create', [
      'departamentos' => $this->userRepository->getAllDepartamentos(),
      'sectores' => Sector::SelectAllSectors()->get(),
      'tamanhos' => TamanhoEmpresa::all(),
      'tipos' => TipoEmpresa::all()
      ]);
    }
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  * @author Victor Manuel Moreno Vega
  */
  public function store(EmpresaFormRequest $request)
  {
    $reg = $this->empresaRepository->store($request);
    if ($reg) {
      alert()->success('La empresa ha sido creada satisfactoriamente','Registro Exitoso.')->showConfirmButton('Ok', '#3085d6');
      return redirect('empresa');
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
    if ( \Session::get('login_role') == User::IsGestor() ) {
      // dd(Empresa::find($id)->entidad->ciudad->departamento->nombre);
      return view('empresa.gestor.edit', [
      'empresa' => Empresa::find($id),
      'departamentos' => $this->userRepository->getAllDepartamentos(),
      'sectores' => Sector::SelectAllSectors()->get(),
      'tamanhos' => TamanhoEmpresa::all(),
      'tipos' => TipoEmpresa::all()
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
  public function update(EmpresaFormRequest $request, $id)
  {
    $empresa = Empresa::find($id);
    $empresaUpdate = $this->empresaRepository->update($request, $empresa);
    alert()->success("La empresa ha sido modificada.",'Modificación Exitosa',"success")->showConfirmButton('Ok', '#3085d6');
    return redirect()->route('empresa');

  }
}
