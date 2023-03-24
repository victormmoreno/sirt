<?php

namespace App\Http\Controllers\Excel;

use App\Exports\Equipo\{EquipoToImport};
use Excel;
use App\Repositories\Repository\EquipoRepository;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\Models\Equipo;
use App\Imports\EquipoImport;

class EquipoController extends Controller
{
    private $query;
    private $equipoRepository;

  public function __construct(EquipoRepository $equipoRepository)
  {
    $this->equipoRepository = $equipoRepository;
  }

  /**
   * Descagar el listado de equipos de un nodo
   * 
   * @return Excel
   * @author dum
   */
  public function download()
  {
    if(!request()->user()->can('import', Equipo::class)) {
        alert('No autorizado', 'No puedes descargar la información de los equipos de este nodo', 'error')->showConfirmButton('Ok', '#3085d6');
        return back();
    }
    $equipos = $this->equipoRepository->consultar();
    if (session()->get('login_role') == User::IsAdministrador() || session()->get('login_role') == User::IsActivador()) {
        $equipos = $equipos->get();
    } else {
        if (session()->get('login_role') == User::IsExperto()) {
            $equipos = $equipos->where('n.id', request()->user()->getNodoUser())->where('lt.id', request()->user()->gestor->nodo_id)->get();
        } else {
            $equipos = $equipos->where('n.id', request()->user()->getNodoUser())->get();
        }
    }
    return Excel::download(new EquipoToImport($equipos), 'Equipos.xlsx');
  }

  /**
   * Importar los equipos a partir de un excel
   *
   * @param Request $request
   * @return type
   * @throws conditon
   **/
  public function import(Request $request)
  {
    session()->put('errorMigracion', null);
    Excel::import(new EquipoImport(request()->user()->getNodoUser()), $request->file('nombreArchivo'));
    if (session()->get('errorMigracion') == null) {
        alert()->success('Migración Exitosa!', 'La información se ha migrado exitósamente!')->showConfirmButton('Ok', '#3085d6');
    } else {
        alert()->error('Migración Errónea!', session()->get('errorMigracion'))->showConfirmButton('Ok', '#3085d6');
    }
    session()->put('errorMigracion', null);
    return back();
  }

}
