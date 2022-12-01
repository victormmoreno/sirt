<?php

namespace App\Http\Controllers\Excel;

use App\Exports\Materiales\{MaterialesExport};
use App\Repositories\Repository\MaterialRepository;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\Models\Material;
use App\Imports\MaterialImport;
use Excel;

class MaterialController extends Controller
{
    private $query;
    private $materialRepository;

  public function __construct(MaterialRepository $materialRepository)
  {
    $this->materialRepository = $materialRepository;
  }

  /**
   * Descagar el listado de materiales de un nodo
   * 
   * @return Excel
   * @author dum
   */
  public function download()
  {
    if(!request()->user()->can('download', Material::class)) {
        alert('No autorizado', 'No puedes descargar la información de los materiales de este nodo', 'error')->showConfirmButton('Ok', '#3085d6');
        return back();
    }
    if (session()->get('login_role') == User::IsAdministrador()) {
        $materiales = $this->materialRepository->consultar()->get();
    } else {
        $materiales = $this->materialRepository->consultar('nodos.id', request()->user()->getNodoUser());
    }
    return Excel::download(new MaterialesExport($materiales), 'Materiales de formación.xlsx');
  }

  /**
   * Importar los materiales de fomración a partir de un excel
   *
   * @param Request $request
   * @return type
   * @throws conditon
   **/
  public function import(Request $request)
  {
    session()->put('errorMigracion', null);
    Excel::import(new MaterialImport(request()->user()->getNodoUser()), $request->file('nombreArchivo'));
    if (session()->get('errorMigracion') == null) {
        alert()->success('Migración Exitosa!', 'La información se ha migrado exitósamente!')->showConfirmButton('Ok', '#3085d6');
    } else {
        alert()->error('Migración Errónea!', session()->get('errorMigracion'))->showConfirmButton('Ok', '#3085d6');
    }
    session()->put('errorMigracion', null);
    return back();
  }

}
