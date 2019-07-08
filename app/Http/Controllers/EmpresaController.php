<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\{EmpresaFormRequest, ContactoEntidadFormRequest};
use App\Models\{Empresa, Sector, Entidad, GrupoInvestigacion, ContactoEntidad};
use App\Repositories\Repository\{EmpresaRepository, UserRepository\UserRepository, ContactoEntidadRepository};
use Illuminate\Support\Facades\DB;
use App\Helpers\ArrayHelper;
use Illuminate\Support\Facades\Validator;

class EmpresaController extends Controller
{
  private $empresaRepository;
  private $userRepository;
  private $contactoEntidadRepository;

  public function __construct(EmpresaRepository $empresaRepository, UserRepository $userRepository, ContactoEntidadRepository $contactoEntidadRepository)
  {
    $this->empresaRepository = $empresaRepository;
    $this->userRepository = $userRepository;
    $this->contactoEntidadRepository = $contactoEntidadRepository;
    $this->middleware([
        'auth',
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
      if (auth()->user()->rol()->first()->nombre == 'Gestor') {
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
      // if (auth()->user()->rol()->first()->nombre == 'Gestor') {
        // code...
      // }
    }
  }

  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    switch (auth()->user()->rol()->first()->nombre) {
      case 'Gestor':
        return view('empresa.gestor.index');
        break;
      case 'Dinamizador':
        return view('empresa.dinamizador.index');
        break;
      case 'Administrador':
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
      if (auth()->user()->rol()->first()->nombre == 'Gestor') {
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
          // $contact = '
          // <a class="btn orange lighten-3 m-b-xs modal-trigger" href="#modal1" onclick="consultarContactosDeUnaEntidad('. $data->id_entidad .')">
          // <i class="material-icons">local_phone</i>
          // </a>
          // ';
          return $contact;
        })->addColumn('edit', function ($data) {
          $edit = '<a href="'. route("empresa.edit", $data->id) .'" class="btn m-b-xs"><i class="material-icons">edit</i></a>';
          return $edit;
        })->addColumn('add_articulacion', function ($data) {
          $add = '<a onclick="addEmpresaArticulacion(' . $data->id . ')" class="btn blue m-b-xs"><i class="material-icons">done</i></a>';
          return $add;
        })->rawColumns(['details', 'edit', 'add_articulacion', 'contacts'])->make(true);
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
          // data-href="{{url('laravel-crud-search-sort-ajax-modal-form/update/'.$customer->id)}}"
        })->addColumn('contacts', function ($data) {
          $contact = '
          <a class="btn orange lighten-3 m-b-xs modal-trigger" href="#modal1" data-href='. route('empresa.contactos.nodo', $data->id_entidad) .'>
          <i class="material-icons">local_phone</i>
          </a>
          ';
          // $contact = '
          // <a class="btn orange lighten-3 m-b-xs modal-trigger" href="#modal1" onclick="consultarContactosDeUnaEntidad('. $data->id_entidad .')">
          // <i class="material-icons">local_phone</i>
          // </a>
          // ';
          return $contact;
        })->addColumn('soft_delete', function ($data) {
          $edit = '<a class="btn m-b-xs"><i class="material-icons">sweep_delete</i></a>';
          return $edit;
        })->rawColumns(['details', 'soft_delete', 'contacts'])->make(true);
      }
    }
  }

  // Consulta que muestra los detalles de una empresa
  public function detalleDeUnaEmpresa($id)
  {
    $detalles = $this->empresaRepository->consultarDetallesDeUnaEmpresa($id);
    $detalles->telefono_contacto == null ? $detalles->telefono_contacto = 'No hay información disponible' : $detalles->telefono_contacto;
    $detalles->nombre_contacto == null ? $detalles->nombre_contacto = 'No hay información disponible' : $detalles->nombre_contacto;
    $detalles->correo_contacto == null ? $detalles->correo_contacto = 'No hay información disponible' : $detalles->correo_contacto;
    $detalles->email_entidad == null ? $detalles->email_entidad = 'No hay información disponible' : $detalles->email_entidad;
    return json_encode([
      'detalles' => $detalles
    ]);
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    if (auth()->user()->rol()->first()->nombre == 'Gestor') {
      return view('empresa.gestor.create', [
      'departamentos' => $this->userRepository->getAllDepartamentos(),
      'sectores' => Sector::SelectAllSectors()->get(),
      ]);
    }
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
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
    if ( auth()->user()->rol()->first()->nombre == 'Gestor' ) {
      // dd(Empresa::find($id)->entidad->ciudad->departamento->nombre);
      return view('empresa.gestor.edit', [
      'empresa' => Empresa::find($id),
      'departamentos' => $this->userRepository->getAllDepartamentos(),
      'sectores' => Sector::SelectAllSectors()->get(),
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
  public function update(EmpresaFormRequest $request, $id)
  {
    $empresa = Empresa::find($id);
    $empresaUpdate = $this->empresaRepository->update($request, $empresa);
    alert()->success("La empresa ha sido modificada.",'Modificación Exitosa',"success")->showConfirmButton('Ok', '#3085d6');;


    return redirect()->route('empresa');

  }
}
