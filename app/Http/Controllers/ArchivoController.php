<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\{ArchivoArticulacion, Fase, Proyecto, ArchivoProyecto};
use App\Repositories\Repository\{ArticulacionRepository, ArchivoRepository, ProyectoRepository};
use Illuminate\Support\Facades\Storage;
Use App\User;

class ArchivoController extends Controller
{

  private $articulacionRepository;
  private $archivoRepository;
  private $proyectoRepository;

  public function __construct(ArticulacionRepository $articulacionRepository, ArchivoRepository $archivoRepository, ProyectoRepository $proyectoRepository)
  {
    $this->articulacionRepository = $articulacionRepository;
    $this->archivoRepository = $archivoRepository;
    $this->proyectoRepository = $proyectoRepository;
    $this->middleware([
      'auth',
    ]);
  }

  // Sube los archivos de la articulación
  public function uploadFileProyecto(Request $request, $id)
  {
    if (request()->ajax()) {
      $this->validate(request(), [
        'nombreArchivo' => 'max:50000|mimes:jpeg,png,jpg,docx,doc,pdf,exe,xlsl,xlsx,xls,pptx,sldx,ppsx,exe,zip',
      ],
      [
        'nombreArchivo.mimes' => 'El tipo de archivo no es permitido',
        'nombreArchivo.max' => 'El tamaño del archivo no puede superar las 50MB'
      ]);
      $file = request()->file('nombreArchivo');
      // La ruta con la se guardan los archivos de un proyecto es la siguiente:
      // id_nodo/anho_de_la_fecha_de_inicio_del_proyecto/Proyectos/linea_tecnológica/id_gestor/id_del_proyecto/fase_del_archivo/max_id_archivo_proyecto_nombre_del_archivo.extension
      $idArchivoProyecto = ArchivoProyecto::selectRaw('MAX(id+1) AS max')->get()->last();
      $fileName = $idArchivoProyecto->max . '_' . $file->getClientOriginalName();
      // Creando la ruta
      $proyecto = $this->proyectoRepository->consultarDetallesDeUnProyectoRepository($id);
      $route = "";
      $nodo = sprintf("%02d", auth()->user()->gestor->nodo_id);
      $anho = $proyecto->fecha_inicio->isoFormat('YYYY');
      $linea = $proyecto->lineatecnologica_id;
      $gestor = sprintf("%03d", $proyecto->gestor_id);
      $idproyecto = $proyecto->id;
      $fase = Fase::select('id', 'nombre')->where('nombre', $request->fase)->get()->last();
      $fase_id = $fase->id;
      $fase = $fase->nombre;
      $route = 'public/' . $nodo . '/' . $anho . '/Proyectos' . '/' . $linea . '/' . $gestor . '/' . $idproyecto . '/' . $fase;
      $fileUrl = $file->storeAs($route, $fileName);
      $this->archivoRepository->storeFileProyecto($id, $fase_id, Storage::url($fileUrl));
      // exit($route);
    }
  }

  // Borra el archivo de la articulación del servidor
  public function destroyFileArticulacion($idFile)
  {
    $file = ArchivoArticulacion::find($idFile);
    $file->delete();
    $filePath = str_replace('storage', 'public', $file->ruta);
    Storage::delete($filePath);
    toast('El Archivo se ha eliminado con éxito!','success')->autoClose(2000)->position('top-end');
    return back();
  }

  // Borra el archivo de un proyecto del servidor
  public function destroyFileProyecto($idFile)
  {
    $file = ArchivoProyecto::find($idFile);
    $file->delete();
    $filePath = str_replace('storage', 'public', $file->ruta);
    Storage::delete($filePath);
    toast('El Archivo se ha eliminado con éxito!','success')->autoClose(2000)->position('top-end');
    return back();
  }

  // Descarga el archivo de un proyecto
  public function downloadFileProyecto($idFile)
  {
    $ruta = $this->archivoRepository->consultarRutaDeArchivoDeUnProyectoPorId($idFile);
    $path = str_replace('storage', 'public', $ruta->ruta);
    return Storage::download($path);
  }

  // Descarga el archivo de la articulación
  public function downloadFileArticulacion($idFile)
  {
    $ruta = $this->archivoRepository->consultarRutaDeArchivoDeLaArticulacionPorId($idFile);
    $path = str_replace('storage', 'public', $ruta->ruta);
    return Storage::download($path);
  }

  // Datatable para mostar los archivos de una articulación
  public function datatableArchivosDeUnaArticulacion($id)
  {
    if (request()->ajax()) {
      if (\Session::get('login_role') == User::IsGestor() || \Session::get('login_role') == User::IsDinamizador() || \Session::get('login_role') == User::IsAdministrador()) {
        $archivosDeLaArticulacion = $this->archivoRepository->consultarRutasArchivosDeUnaArticulacion($id);
        return datatables()->of($archivosDeLaArticulacion)
        ->addColumn('download', function ($data) {
          $download = '
          <a target="_blank" href="' . route('articulacion.files.download', $data->id) . '" class="btn blue darken-4 m-b-xs">
          <i class="material-icons">file_download</i>
          </a>
          ';
          return $download;
        })->addColumn('delete', function ($data) {
          $delete = '<form method="POST" action="' . route('articulacion.files.destroy', $data) . '">
          ' . method_field('DELETE') . '' .  csrf_field() . '
          <button class="btn red darken-4 m-b-xs">
          <i class="material-icons">delete_forever</i>
          </button>
          </form>';
          return $delete;
        })->addColumn('file', function ($data) {
          $file = '
          <i class="material-icons">insert_drive_file</i> ' . basename( url($data->ruta) ) . '
          ';
          return $file;
        })->rawColumns(['download', 'delete', 'file'])->make(true);
      }
    }
  }

  // Datatable para mostar los archivos de un proyecto
  public function datatableArchivosDeUnProyecto($id)
  {
    if (request()->ajax()) {
      if (\Session::get('login_role') == User::IsGestor() || \Session::get('login_role') == User::IsDinamizador() || \Session::get('login_role') == User::IsAdministrador()) {
        $archivosDeUnProyecto = $this->archivoRepository->consultarRutasArchivosDeUnProyecto($id);
        return datatables()->of($archivosDeUnProyecto)
        ->addColumn('download', function ($data) {
          $download = '
          <a target="_blank" href="' . route('proyecto.files.download', $data->id) . '" class="btn blue darken-4 m-b-xs">
          <i class="material-icons">file_download</i>
          </a>
          ';
          return $download;
        })->addColumn('delete', function ($data) {
          $delete = '<form method="POST" action="' . route('proyecto.files.destroy', $data) . '">
          ' . method_field('DELETE') . '' .  csrf_field() . '
          <button class="btn red darken-4 m-b-xs">
          <i class="material-icons">delete_forever</i>
          </button>
          </form>';
          return $delete;
        })->addColumn('file', function ($data) {
          $file = '
          <i class="material-icons">insert_drive_file</i> ' . basename(url($data->ruta) ) . '
          ';
          return $file;
        })->rawColumns(['download', 'delete', 'file'])->make(true);
      }
    }
  }

  // Sube los archivos de la articulación
  public function uploadFileArticulacion(Request $request, $id)
  {
    if (request()->ajax()) {
      $this->validate(request(), [
        'nombreArchivo' => 'max:50000|mimes:jpeg,png,jpg,docx,doc,pdf,exe,xlsl,xls,pptx,sldx,ppsx,exe,zip',
      ],
      [
        'nombreArchivo.mimes' => 'El tipo de archivo no es permitido',
        'nombreArchivo.max' => 'El tamaño del archivo no puede superar las 50MB'
      ]);
      $file = request()->file('nombreArchivo');
      // La ruta con la se guardan los archivos de una articulación es la siguiente:
      // id_nodo/anho_de_la_fecha_de_inicio_de_la_articulacion/Articulaciones/tipo_articulacion(AGI ó AEE)/id_de_la_articulacion/fase_del_archivo/max_id_archivo_articulacion_nombre_del_archivo.extension

      // Creando el nombre del archivo que se concatenerá con el max id de los archivos de la articulación
      $idArchivoArticulacion = ArchivoArticulacion::selectRaw('MAX(id+1) AS max')->get()->last();
      $idArchivoArticulacion->max == null ? $idArchivoArticulacion->max = 1 : $idArchivoArticulacion->max = $idArchivoArticulacion->max;
      $fileName = $idArchivoArticulacion->max . '_' . $file->getClientOriginalName();
      // Fase donde se guardará el archivo de la articulación
      $fase = Fase::select('id', 'nombre')->where('nombre', $request->fase)->get()->last();
      // Tipo de Aritculación (AGI / Si es con grupo de investigación) ó (AEE / Si es con empresa o emprendedor)
      $tipo = $this->articulacionRepository->consultarArticulacionPorId($id)->last();
      $folderTipoArticulacion = '';
      $tipo->tipo_articulacion == 'Grupo de Investigación' ? $folderTipoArticulacion = 'AGI' : $folderTipoArticulacion = 'AEE';
      // Nombre para la carpeta donde se guardaran los archivos de las articulaciones
      $articulacion = 'Articulaciones';
      // Año de la fecha de inicio de una articulación
      $anhoFechaInicio = $tipo->fecha_inicio;
      $anhoFechaInicio = $anhoFechaInicio->format('Y');
      // Id del nodo
      $tecnoparque = sprintf("%02d", auth()->user()->gestor->nodo_id);
      $fileUrl = $file->storeAs("public/".$tecnoparque.'/'.$anhoFechaInicio.'/'.$articulacion.'/'.$folderTipoArticulacion.'/'.$id.'/'.$fase->nombre, $fileName);
      $this->archivoRepository->storeFileArticulacion($id, $fase->id, Storage::url($fileUrl));
    }
  }

}
