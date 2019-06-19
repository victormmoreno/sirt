<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Repositories\Repository\EmpresaRepository;

class EmpresaController extends Controller
{
  private $empresaRepository;

  public function __construct(EmpresaRepository $empresaRepository)
  {
    $this->empresaRepository = $empresaRepository;
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
    return json_encode([
      'detalles' => $this->empresaRepository->consultarDetallesDeUnaEmpresa($id)
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
      return view('empresa.gestor.create');
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
    //
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
    //
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
    //
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
