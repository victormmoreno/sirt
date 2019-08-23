<?php

namespace App\Http\Controllers\Excel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Exports\{ArticulacionesExport};
use App\Repositories\Repository\{ArticulacionRepository, EmpresaRepository, GrupoInvestigacionRepository, ArticulacionProyectoRepository, UserRepository\GestorRepository};
use Excel;

class ArticulacionController extends Controller
{

  private $articulacionRepository;

  public function __construct(ArticulacionRepository $articulacionRepository)
  {
    $this->articulacionRepository = $articulacionRepository;
  }

  // public function query($id)
  // {
  //   $articulaciones = $this->articulacionRepository->consultarArticulacionesDeUnGestor( $id );
  // }

  /**
   * Genera el excel de las articulaciones que tiene un gestor
   * @param int $id Id del gestor
   * @return Collection
   */
  public function articulacionesDeUnGestor($id)
  {
    // $articulaciones = $this->articulacionRepository->consultarArticulacionesDeUnGestor( $id );
    // return (new ArticulacionesExport)->download('invoices.xlsx');
    return Excel::download(new ArticulacionesExport, 'Datos.xls');
    // Excel::create('Articulaciones' . $id . ' ' . Carbon::now(), function ($excel) {
    //   $excel->sheet('Datos', function ($excel) use ($articulaciones) {
    //     $length = $articulaciones->count() + 1;
    //     $sheet->fromArray($articulaciones);
    //   });
    // })->download('xls');
  }

}
