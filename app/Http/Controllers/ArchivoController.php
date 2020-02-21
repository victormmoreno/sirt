<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Fase, Proyecto, ArchivoArticulacionProyecto, Articulacion, RutaModel};
use App\Repositories\Repository\{ArticulacionRepository, ArchivoRepository, ProyectoRepository, EntrenamientoRepository, EdtRepository, CharlaInformativaRepository};
use Illuminate\Support\Facades\Storage;
use App\User;
use Carbon\Carbon;

class ArchivoController extends Controller
{

  private $articulacionRepository;
  private $archivoRepository;
  private $proyectoRepository;
  private $entrenamientoRepository;
  private $edtRepository;
  private $charlaInformativaRepository;

  public function __construct(ArticulacionRepository $articulacionRepository, ArchivoRepository $archivoRepository, ProyectoRepository $proyectoRepository, EntrenamientoRepository $entrenamientoRepository, EdtRepository $edtRepository, CharlaInformativaRepository $charlaInformativaRepository)
  {
    $this->articulacionRepository = $articulacionRepository;
    $this->archivoRepository = $archivoRepository;
    $this->proyectoRepository = $proyectoRepository;
    $this->entrenamientoRepository = $entrenamientoRepository;
    $this->edtRepository = $edtRepository;
    $this->charlaInformativaRepository = $charlaInformativaRepository;
    $this->middleware([
      'auth',
    ]);
  }

  /**
  * Método que elimina un archivo del servidor y su registro de la base de datos (archivoscharlasinformativas)
  * @param int id Id del archivo de la charla informativa que se usará para eliminarlo del almacenamiento y de la base de datos
  * @return Response
  * @author Victor Manuel Moreno Vega
  */
  public function destroyFileCharlaInformartiva($id)
  {
    $file = RutaModel::find($id);
    $file->delete();
    $filePath = str_replace('storage', 'public', $file->ruta);
    Storage::delete($filePath);
    toast('El Archivo se ha eliminado con éxito!','success')->autoClose(2000)->position('top-end');
    return back();
  }

  /**
  * Método para descargar un archivo de una charla informativa
  * @param int idFile id del archivo que se va a descargar
  * @return Storage
  */
  public function downloadFileCharlaInformativa($idFile)
  {
    $ruta = $this->archivoRepository->consultarRutaDeArchivoDeUnaCharlaInformativaPorId($idFile);
    $path = str_replace('storage', 'public', $ruta->ruta);
    return Storage::response($path);
  }

  /**
  * Sube un archivo de las charlas informativas al servidor, además de que lo registra en la base de datos
  * @param Request
  * @param int $id Id de la edt con el que se le subirá el archivo
  * @return void
  */
  public function uploadFileCharlaInformartiva(Request $request, $id)
  {
    if (request()->ajax()) {
      $this->validate(request(), [
        'nombreArchivo' => 'max:50000|mimes:jpeg,png,jpg,docx,doc,pdf,exe,xlsl,xlsx,xls,pptx,sldx,ppsx,zip',
      ],
      [
        'nombreArchivo.mimes' => 'El tipo de archivo no es permitido',
        'nombreArchivo.max' => 'El tamaño del archivo no puede superar las 50MB'
      ]);
      $file = request()->file('nombreArchivo');
      $route = "";
      // La ruta con la se guardan los archivos de una es la siguiente:
      // id_nodo/anho_de_la_fecha_de_incio/Edts/id_gestor/edt_id/max_id_archivo_proyecto_nombre_del_archivo.extension
      $idArchivoCharlaInformativa = RutaModel::selectRaw('MAX(id+1) AS max')->get()->last();
      $fileName = $idArchivoCharlaInformativa->max . '_' . $file->getClientOriginalName();
      // Creando la ruta
      $charla = $this->charlaInformativaRepository->consultarInformacionDeUnaCharlaInformativaRepository($id);
      $nodo = sprintf("%02d", auth()->user()->infocenter->nodo_id);
      $anho = Carbon::parse($charla->fecha)->isoFormat('YYYY');
      // $anho = $edt->fecha_inicio->isoFormat('YYYY');
      $route = 'public/' . $nodo . '/' . $anho . '/Charlas' . '/' . $id;
      $fileUrl = $file->storeAs($route, $fileName);
      $this->archivoRepository->storeFileCharlaInformativaRepository($id, Storage::url($fileUrl));
    }
  }

  /**
  * Consulta los archivos de una charla informativa
  * @param int $id Id de la charla informativa al cual se le consultarán lo archivos
  * @return Response
  */
  public function datatableArchivosDeUnaCharlaInformatva($id)
  {
    if (request()->ajax()) {
      $files = $this->charlaInformativaRepository->consultarArchivosDeUnaCharlaInformativaRepository($id);
      // dd($files);
      return datatables()->of($files)
      ->addColumn('download', function ($data) {
        $download = '
        <a target="_blank" href="' . route('charla.files.download', $data->id) . '" class="btn blue darken-4 m-b-xs">
        <i class="material-icons">file_download</i>
        </a>
        ';
        return $download;
      })->addColumn('delete', function ($data) {
        $delete = '<form method="POST" action="' . route('charla.files.destroy', $data->id) . '">
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

  /**
  * Sube un archivo de las edts al servidor, además de que lo registra en la base de datos
  * @param Request
  * @param int $id Id de la edt con el que se le subirá el archivo
  * @return void
  */
  public function uploadFileEdt(Request $request, $id)
  {
    if (request()->ajax()) {
      $this->validate(request(), [
        'nombreArchivo' => 'max:50000|mimes:jpeg,png,jpg,docx,doc,pdf,exe,xlsl,xlsx,xls,pptx,sldx,ppsx,zip',
      ],
      [
        'nombreArchivo.mimes' => 'El tipo de archivo no es permitido',
        'nombreArchivo.max' => 'El tamaño del archivo no puede superar las 50MB'
      ]);
      $file = request()->file('nombreArchivo');
      $route = "";
      // La ruta con la se guardan los archivos de una es la siguiente:
      // id_nodo/anho_de_la_fecha_de_incio/Edts/id_gestor/edt_id/max_id_archivo_proyecto_nombre_del_archivo.extension
      $idArchivoEdt = RutaModel::selectRaw('MAX(id+1) AS max')->get()->last();
      $fileName = $idArchivoEdt->max . '_' . $file->getClientOriginalName();
      // Creando la ruta
      $edt = $this->edtRepository->consultarDetalleDeUnaEdt($id);
      $nodo = sprintf("%02d", auth()->user()->gestor->nodo_id);
      $gestor = sprintf("%03d", auth()->user()->gestor->id);
      $anho = Carbon::parse($edt->fecha_inicio)->isoFormat('YYYY');
      // $anho = $edt->fecha_inicio->isoFormat('YYYY');
      $route = 'public/' . $nodo . '/' . $anho . '/Edts' . '/' . $gestor . '/' . $id;
      $fileUrl = $file->storeAs($route, $fileName);
      $this->archivoRepository->storeFileEdt($id, Storage::url($fileUrl));
    }
  }

  /**
  * Método para descargar un archivo de una edt
  * @param int idFile id del archivo que se va a descargar
  * @return Response
  * @author Victor Manuel Moreno Vega
  */
  public function downloadFileEdt($idFile)
  {
    $ruta = RutaModel::find($idFile);
    $path = str_replace('storage', 'public', $ruta->ruta);
    return Storage::response($path);
  }

  /**
  * Método que elimina un archivo del servidor y su registro de la base de datos (archivosedt)
  * @param int id Id del archivo de la edt que se usará para eliminarlo del almacenamiento y de la base de datos
  * @return Response
  * @author Victor Manuel Moreno Vega
  */
  public function destroyFileEdt($id)
  {
    $file = RutaModel::find($id);
    $file->delete();
    $filePath = str_replace('storage', 'public', $file->ruta);
    Storage::delete($filePath);
    toast('El Archivo se ha eliminado con éxito!','success')->autoClose(2000)->position('top-end');
    return back();
  }

  /**
  * Consulta los archivos de una edt
  * @param int $id Id del entrenamiento al cual se le consultarán lo archivos
  * @return return datatable
  */
  public function datatableArchivosDeUnaEdt($id)
  {
    if (request()->ajax()) {
      $files = $this->edtRepository->consultarArchivosDeUnaEdt($id);
      // dd($files);

      return datatables()->of($files)
      ->addColumn('download', function ($data) {
        $download = '
        <a target="_blank" href="' . route('edt.files.download', $data->id) . '" class="btn blue darken-4 m-b-xs">
        <i class="material-icons">file_download</i>
        </a>
        ';
        return $download;
      })->addColumn('delete', function ($data) {
        $delete = '<form method="POST" action="' . route('edt.files.destroy', $data->id) . '">
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

  /**
  * Método para descargar un archivo de un entrenamiento
  * @param int idFile id del archivo que se va a eliminar
  */
  public function downloadFileEntrenamiento($idFile)
  {
    $ruta = RutaModel::find($idFile);
    $path = str_replace('storage', 'public', $ruta->ruta);
    return Storage::response($path);
  }

  /**
  * Método que elimina un archivo del servidor y su registro de la base de datos (archivosentrenamiento)
  * @param int id Id del archivo del entrenamiento que se usará para eliminarlo del almacenamiento y de la base de datos
  * @return Response
  */
  public function destroyFileEntrenamiento($id)
  {
    $file = RutaModel::find($id);
    $file->delete();
    $filePath = str_replace('storage', 'public', $file->ruta);
    Storage::delete($filePath);
    toast('El Archivo se ha eliminado con éxito!','success')->autoClose(2000)->position('top-end');
    return back();
  }

  /**
  * Consulta los archivos de un entrenamiento
  * @param int $id Id del entrenamiento al cual se le consultarán lo archivos
  * @return return datatable
  * @author Victor Manuel Moreno Vega
  */
  public function datatableArchivosDeUnEntrenamiento($id)
  {
    if (request()->ajax()) {
      $files = $this->entrenamientoRepository->consultarArchivosDeUnEntrenamiento($id);
      // dd($files);
      return datatables()->of($files)
      ->addColumn('download', function ($data) {
        $download = '
        <a target="_blank" href="' . route('entrenamientos.files.download', $data->id) . '" class="btn blue darken-4 m-b-xs">
        <i class="material-icons">file_download</i>
        </a>
        ';
        return $download;
      })->addColumn('delete', function ($data) {
        $delete = '<form method="POST" action="' . route('entrenamientos.files.destroy', $data) . '">
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

  /**
  * Sube un archivo de los entrenamientos al servidor, además de que lo registra en la base de datos
  * @param Request
  * @param int $id Id del entrenamiento con el que se le subirá el archivo
  * @return void
  * @author Victor Manuel Moreno Vega
  */
  public function uploadFileEntrenamiento(Request $request, $id)
  {
    if (request()->ajax()) {
      $this->validate(request(), [
        'nombreArchivo' => 'max:50000|mimes:jpeg,png,jpg,docx,doc,pdf,exe,xlsl,xlsx,xls,pptx,sldx,ppsx,zip',
      ],
      [
        'nombreArchivo.mimes' => 'El tipo de archivo no es permitido',
        'nombreArchivo.max' => 'El tamaño del archivo no puede superar las 50MB'
      ]);
      $file = request()->file('nombreArchivo');
      // La ruta con la se guardan los archivos de un entrenamiento es la siguiente:
      // id_nodo/anho_de_la_fecha_de_sesion_1/entrenamientos/max_id_archivo_proyecto_nombre_del_archivo.extension
      $idArchivoEntrenamiento = RutaModel::selectRaw('MAX(id+1) AS max')->get()->last();
      $fileName = $idArchivoEntrenamiento->max . '_' . $file->getClientOriginalName();
      // Creando la ruta
      $entrenamiento = $this->entrenamientoRepository->consultarEntrenamientoPorId($id);
      $route = "";
      $nodo = sprintf("%02d", auth()->user()->infocenter->nodo_id);
      $anho = $entrenamiento->fecha_sesion1->isoFormat('YYYY');
      $route = 'public/' . $nodo . '/' . $anho . '/Entrenamientos' . '/' . $id;
      $fileUrl = $file->storeAs($route, $fileName);
      $this->archivoRepository->storeFileEntrenamiento($id, Storage::url($fileUrl));
    }
  }

  /**
  * @param Request $request
  * @param int $id Id del proyecto
  * @return void
  * @author Victor Manuel Moreno Vega
  */
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
      // dd(request()->file('nombreArchivo'));
      // exit();
      // La ruta con la se guardan los archivos de un proyecto es la siguiente:
      // id_nodo/anho_de_la_fecha_de_inicio_del_proyecto/Proyectos/linea_tecnológica/id_gestor/id_del_proyecto/fase_del_archivo/max_id_archivo_proyecto_nombre_del_archivo.extension
      $idArchivoArtulacionProyecto = ArchivoArticulacionProyecto::selectRaw('MAX(id+1) AS max')->get()->last();
      $fileName = $idArchivoArtulacionProyecto->max . '_' . $file->getClientOriginalName();
      // Creando la ruta
      $proyecto = Proyecto::findOrFail($id);
      $route = "";
      $nodo = sprintf("%02d", auth()->user()->gestor->nodo_id);
      $anho = Carbon::parse($proyecto->fecha_inicio)->isoFormat('YYYY');
      $linea = $proyecto->sublinea->lineatecnologica_id;
      $gestor = sprintf("%03d", $proyecto->articulacion_proyecto->actividad->gestor_id);
      $idproyecto = $proyecto->id;
      $fase = Fase::select('id', 'nombre')->where('nombre', $request->fase)->get()->last();
      $fase_id = $fase->id;
      $fase = $fase->nombre;
      $route = 'public/' . $nodo . '/' . $anho . '/Proyectos' . '/' . $linea . '/' . $gestor . '/' . $idproyecto . '/' . $fase;
      $fileUrl = $file->storeAs($route, $fileName);
      $id = $proyecto->articulacion_proyecto_id;
      $this->archivoRepository->storeFileArticulacionProyecto($id, $fase_id, Storage::url($fileUrl));
    }
  }

  /**
  * @param int $idFile Id del archivo de la tabla archivos_articulacion_proyecto
  * @return Response
  * @author Victor Manuel Moreno Vega
  */
  public function destroyFileProyecto($idFile)
  {
    $file = ArchivoArticulacionProyecto::find($idFile);
    $file->delete();
    $filePath = str_replace('storage', 'public', $file->ruta);
    Storage::delete($filePath);
    toast('El Archivo se ha eliminado con éxito!','success')->autoClose(2000)->position('top-end');
    return back();
  }

  // Descarga el archivo de un proyecto
  public function downloadFileProyecto($idFile)
  {
    $ruta = $this->archivoRepository->consultarRutaDeArchivoDeUnaArticulacionProyectoPorId($idFile);
    $path = str_replace('storage', 'public', $ruta->ruta);
    return Storage::response($path);
  }

  // Descarga el archivo de la articulación
  public function downloadFileArticulacion($idFile)
  {
    $ruta = $this->archivoRepository->consultarRutaDeArchivoDeLaArticulacionPorId($idFile);
    $path = str_replace('storage', 'public', $ruta->ruta);
    return Storage::response($path);
  }

  /**
   * Muestra los archivos de una articulacion
   */
  public function datatableArchivosDeUnaArticulacion($id)
  {
    if (request()->ajax()) {
      $articulacion = Articulacion::findOrFail($id);
      $archivosDeLaArticulacion = $this->archivoRepository->consultarRutasArchivosDeUnaArticulacionProyecto($articulacion->articulacion_proyecto_id);
      return $this->datatableArchivosArticulacionProyecto($archivosDeLaArticulacion);
    }
  }


  /**
  * Tabla para mostrar los archivos de una articulacion_proyecto
  * @param int $id Id de la articulacion_proyecto
  * @return Reponse
  * @author Victor Manuel Moreno Vega
  */
  public function datatableArchivosArticulacionProyecto($query)
  {
    return datatables()->of($query)
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

  /**
  * Muestra la datatable de los arcivos de un proyecto
  * @param int $id Id del proyecto
  * @param string $fase Nombre de la fase
  * @return Datatable
  * @author Victor Manuel Moreno Vega
  */
  public function datatableArchivosDeUnProyecto($id, $fase)
  {
    if (request()->ajax()) {
      $proyecto = Proyecto::findOrFail($id);
      $archivosDeUnProyecto = $this->archivoRepository->consultarRutasArchivosDeUnaArticulacionProyecto($proyecto->articulacion_proyecto_id, $fase)->get();
      return $this->datatableArchivosArticulacionProyecto($archivosDeUnProyecto);
    }
  }

  /**
   * Subida de un arcivo al servidor
   * @param Request
   * @param int $id Id de la articulación
   * @return void
   * @author Victor Manuel Moreno Vega
   */
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
      $idArchivoArticulacion = ArchivoArticulacionProyecto::selectRaw('MAX(id+1) AS max')->get()->last();
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
      // Id de articulacion proyecto
      $id = Articulacion::find($id);
      $id = $id->articulacion_proyecto_id;
      $fileUrl = $file->storeAs("public/".$tecnoparque.'/'.$anhoFechaInicio.'/'.$articulacion.'/'.$folderTipoArticulacion.'/'.$id.'/'.$fase->nombre, $fileName);
      $this->archivoRepository->storeFileArticulacionProyecto($id, $fase->id, Storage::url($fileUrl));
    }
  }

}
