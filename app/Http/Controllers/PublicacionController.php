<?php

namespace App\Http\Controllers;

use App\Repositories\Repository\PublicacionRepository;
use Illuminate\Support\Facades\{Session, Validator};
use App\{User, Models\Role, Models\Publicacion};
use App\Http\Requests\PublicacionFormRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PublicacionController extends Controller
{

  private $publicacionRepository;

  public function __construct(PublicacionRepository $publicacionRepository)
  {
    $this->setPublicacionRepository($publicacionRepository);
  }

  /**
   * Vista para editar un publicación
   *
   * @param string $codigo
   * @return Response
   */
  public function edit(string $codigo)
  {
    if ( Session::get('login_role') == User::IsDesarrollador() ) {
      $publicacion = $this->getPublicacionRepository()->buscarPublicacionPorCodigo($codigo)->first();
      return view('publicaciones.desarrollador.edit', [
        'publicacion' => $publicacion,
        'roles' => Role::all()->pluck('name', 'id')
      ]);
    } else {
      abort('403');
    }
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
      $publicaciones = $this->getPublicacionRepository()->consultarPublicaciones()->where('publicaciones.estado', Publicacion::IsActiva())->limit(5)->orderBy('fecha_inicio')->where('roles.name', Session::get('login_role'))->get();
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
    $publicacion = $this->getPublicacionRepository()->buscarPublicacionPorCodigo($codigo)->first();
    // dd($publicacion->role);
    return view('publicaciones.show', [
      'publicacion' => $publicacion
    ]);
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
   * Modifica una publicación
   *
   * @param Request $request
   * @param int $id Id de la publicación
   * @return Response
   * @author dum
   */
  public function update(Request $request, int $id)
  {
    $req = new PublicacionFormRequest;
    $validator = Validator::make($request->all(), $req->rules(), $req->messages());
    if ($validator->fails()) {
      return response()->json([
      'fail'   => true,
      'errors' => $validator->errors(),
      ]);
    }
    $result = $this->getPublicacionRepository()->update($request, $id);
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
   * Cambia el estado de una publicación
   *
   * @param int $id Id de la publicacion
   * @param int $estado Estado al cual se va a cambiar el estado
   * @return boolean
   * @author dum
   */
  public function updateEstado($id, $estado)
  {
    if ( Session::get('login_role') == User::IsDesarrollador() ) {
      $update = $this->getPublicacionRepository()->updateEstado($id, $estado);
      if ( $update ) {
        return response()->json(true);
      } else {
        return response()->json(false);
      }
    } else {
      abort('403');
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
      <a class="btn light-blue m-b-xs" href="'.route('publicacion.show', $data->codigo_publicacion).'">
        <i class="material-icons">info</i>
      </a>
      ';
      return $detalle;
    })->addColumn('edit', function ($data) {
      $edit = '
      <a class="btn m-b-xs" href=' . route('publicacion.edit', $data->codigo_publicacion) . '>
        <i class="material-icons">edit</i>
      </a>
      ';
      return $edit;
    })->addColumn('update', function ($data) {
      if ( $data->estado == Publicacion::IsActiva() ) {
        $update = '
        <a class="btn red lighten-3 m-b-xs" onclick="updateEstadoPublicacion(' . $data->id . ', ' . Publicacion::IsInactiva() . ', event)"><i class="material-icons">close</i></a>
        ';
      } else {
        $update = '
        <a class="btn blue lighten-3 m-b-xs" onclick="updateEstadoPublicacion(' . $data->id . ', ' . Publicacion::IsActiva() . ', event)"><i class="material-icons">add</i></a>
        ';
      }
      return $update;
    })->editColumn('titulo', function ($data) use ($now) {
      if ($data->fecha_inicio <= $now && $data->fecha_fin >= $now) {
        return $data->titulo . '<i class="material-icons left amber-text">new_releases</i>';
      } else {
        return $data->titulo;
      }
    })->rawColumns(['detalle', 'titulo', 'edit', 'update'])->make(true);
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
