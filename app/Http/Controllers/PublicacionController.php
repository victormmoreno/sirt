<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\{Session, Validator};
use App\Http\Requests\PublicacionFormRequest;
use App\Repositories\Repository\PublicacionRepository;
use Illuminate\Http\Request;
use App\{User, Models\Role};
use Carbon\Carbon;

class PublicacionController extends Controller
{

  private $publicacionRepository;

  public function __construct(PublicacionRepository $publicacionRepository)
  {
    $this->setPublicacionRepository($publicacionRepository);
  }

  /**
   * Datatable que muestra las publicaciones/novedades
   *
   * @author dum
   * @return Response
   */
  public function datatablePublicaciones()
  {
    if ( Session::get('login_role') == User::IsDesarrollador() ) {
      $publicaciones = $this->getPublicacionRepository()->consultarPublicaciones()->get();
    } else {
      $publicaciones = $this->getPublicacionRepository()->consultarPublicaciones()->limit(5)->where('roles.name', Session::get('login_role'))->get();
    }
    $now = Carbon::now()->isoFormat('YYYY-MM-DD');
    return $this->printDatatablePublicaciones($publicaciones, $now);
  }

  /**
   * Consulta los detalles de una publicación
   *
   * @param string $codigo
   * @return Response
   */
  public function show(string $codigo)
  {
    // $publicacion =
    return view('publicaciones.show');
  }

  /**
   * Página index para las publicaciones
   *
   * @param type var Description
   * @author dum
   */
  public function index()
  {
    if ( Session::get('login_role') == User::IsDesarrollador() ) {
      return view('publicaciones.desarrollador.index');
    }
  }

  /**
  * Método para mostrar la vista del registro de una publicación
  *
  * @return Response
  * @author dum
  */
  public function create()
  {
    if ( Session::get('login_role') == User::IsDesarrollador() ) {
      return view('publicaciones.desarrollador.create', [
        'roles' => Role::all()->pluck('name', 'id')
      ]);
    }
  }

  /**
   * Método que registra una pubicación
   *
   * @param Request $request
   * @return Response
   * @author dum
   */
  public function store(Request $request)
  {
    $req = new PublicacionFormRequest;
    $validator = Validator::make($request->all(), $req->rules(), $req->messages());
    if ($validator->fails()) {
      return response()->json([
      'fail'   => true,
      'errors' => $validator->errors(),
      ]);
    }
    $result = $this->getPublicacionRepository()->store($request);
    if ($result == false) {
      return response()->json([
      'fail' => false,
      'redirect_url' => false,
      ]);
    } else {
      return response()->json([
      'fail' => false,
      'redirect_url' => url(route('publicacion.index')),
      ]);
    }
  }

  /**
  * Método que pinta la datatable de las publicaciones
  *
  * @param Collection $proyecto Proyectos
  * @param Request $request
  * @return Response
  * @author dum
  */
  private function printDatatablePublicaciones($publicaciones, $now)
  {
    return datatables()->of($publicaciones)
    ->addColumn('detalle', function ($data) {
      $detalle = '
      <a class="btn light-blue m-b-xs" href="'.route('publicacion.show', $data->id).'">
        <i class="material-icons">info</i>
      </a>
      ';
      return $detalle;
    })->addColumn('edit', function ($data) {
      $edit = '
      <a class="btn light-blue m-b-xs">
        <i class="material-icons">info</i>
      </a>
      ';
      return $edit;
    })->addColumn('update', function ($data) {
      $update = '
      <a class="btn light-blue m-b-xs">
        <i class="material-icons">info</i>
      </a>
      ';
      return $update;
    })->editColumn('fecha_inicio', function ($data) use ($now) {
      if ($data->fecha_inicio <= $now && $data->fecha_fin >= $now) {
        return $data->fecha_inicio;
      } else {
        return $data->fecha_inicio;
      }
    })->rawColumns(['detalle', 'fecha_inicio', 'edit', 'update'])->make(true);
  }

  /**
   * Asigna un valor a $publicacionRepository
   *
   * @param PublicacionRepository $publicacionRepository
   * @return void
   * @author dum
   */
  private function setPublicacionRepository(PublicacionRepository $publicacionRepository)
  {
    $this->publicacionRepository = $publicacionRepository;
  }

  /**
   * Retorna el valor de publicacionRepository
   *
   * @return PublicacionRepository
   * @author dum
   */
  public function getPublicacionRepository()
  {
    return $this->publicacionRepository;
  }


}
