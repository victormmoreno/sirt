<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EmpresaFormRequest;
use App\Models\Empresa;
use App\Models\Sector;
use App\Models\Entidad;
use App\Repositories\Repository\EmpresaRepository;
use Illuminate\Support\Facades\DB;
use App\Repositories\Repository\UserRepository\UserRepository;

class EmpresaController extends Controller
{
  private $empresaRepository;
  private $userRepository;

  public function __construct(EmpresaRepository $empresaRepository, UserRepository $userRepository)
  {
    $this->empresaRepository = $empresaRepository;
    $this->userRepository = $userRepository;
  }
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    if (auth()->user()->rol()->first()->nombre == 'Gestor') {
      return view('empresa.gestor.index');
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
          <a class="btn light-blue m-b-xs modal-trigger" href="#modal1" onclick="empresaIndex.consultarDetallesDeUnaEmpresa('. $data->id .')">
          <i class="material-icons">info</i>
          </a>
          ';
          return $button;
        })->addColumn('edit', function ($data) {
          $edit = '<a href="'. route("empresa.edit", $data->id) .'" class="btn m-b-xs"><i class="material-icons">edit</i></a>';
          return $edit;
        })->rawColumns(['details', 'edit'])->make(true);
      }
    }
  }

  // Consulta que muestra los detalles de una empresa
  public function detalleDeUnaEmpresa($id)
  {
    $detalles  = $this->empresaRepository->consultarDetallesDeUnaEmpresa($id);
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
    if ($empresa != null) {
      // DB::transaction(function () {
        $empresaUpdate = $this->empresaRepository->update($request, $empresa);
      // });
      alert()->success("La empresa ha sido modificada.",'Modificación Exitosa',"success");
    }else{
      alert()->error("La empresa no se ha modificado.", 'Modificación Errónea', "error");
    }

    return redirect()->route('empresa');

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
}
