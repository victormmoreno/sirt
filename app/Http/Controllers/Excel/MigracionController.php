<?php

namespace App\Http\Controllers\Excel;

// use Maatwebsite\Excel\Excel;
use Excel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\Imports\CaracterizacionImport;

class MigracionController extends Controller
{
//     private $query;
//     private $equipoRepository;

//   public function __construct(EquipoRepository $equipoRepository)
//   {
//     $this->equipoRepository = $equipoRepository;
//   }

  /**
   * Importar la caracterización de los proyectos desde un archivo excel
   *
   * @param Request $request
   * @return type
   * @throws conditon
   **/
  public function import_caracterizacion_proyectos(Request $request)
  {
    // $excel = new Excel();
    session()->put('errorMigracion', null);
    Excel::import(new CaracterizacionImport(), $request->file('nombreArchivo'));
    if (session()->get('errorMigracion') == null) {
        alert()->success('Migración Exitosa!', 'La información se ha migrado exitósamente!')->showConfirmButton('Ok', '#3085d6');
    } else {
        alert()->error('Migración Errónea!', session()->get('errorMigracion'))->showConfirmButton('Ok', '#3085d6');
    }
    session()->put('errorMigracion', null);
    return back();
  }

}
