<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\{Articulation,
//     ArticulationStage,
//     Fase,
//     Proyecto,
//     ArchivoArticulacionProyecto,
//     RutaModel,
//     ArchivoModel};
// use App\Repositories\Repository\{ArticulacionProyectoRepository,
//     ArchivoRepository,
//     Articulation\ArticulationStageRepository,
//     ProyectoRepository,
//     EntrenamientoRepository,
//     EdtRepository,
//     CharlaInformativaRepository};
use Illuminate\Support\Str;
use App\Models\{Fase, Proyecto, ArchivoArticulacionProyecto, Articulation, RutaModel, ArticulationStage, ArchivoModel, Entrenamiento, Entrenamienton, Nodo};
use App\Repositories\Repository\{Articulation\ArticulationStageRepository, ArchivoRepository, ProyectoRepository, EntrenamientoRepository, EdtRepository, CharlaInformativaRepository};
use Illuminate\Support\Facades\{Storage, Session};
use App\User;
use Carbon\Carbon;

class ArchivoController extends Controller
{

    private $articulacionStateRepository;
    private $archivoRepository;
    private $proyectoRepository;
    private $entrenamientoRepository;
    private $edtRepository;
    private $charlaInformativaRepository;

    public function __construct(ArticulationStageRepository $articulacionStateRepository, ArchivoRepository $archivoRepository, ProyectoRepository $proyectoRepository, EntrenamientoRepository $entrenamientoRepository, EdtRepository $edtRepository, CharlaInformativaRepository $charlaInformativaRepository)
    {
        $this->articulacionStateRepository = $articulacionStateRepository;
        $this->archivoRepository = $archivoRepository;
        $this->proyectoRepository = $proyectoRepository;
        $this->entrenamientoRepository = $entrenamientoRepository;
        $this->edtRepository = $edtRepository;
        $this->charlaInformativaRepository = $charlaInformativaRepository;
        $this->middleware(['auth']);
    }

    /**
     * Método que elimina un archivo del servidor y su registro de la base de datos (RutaModel)
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
        try {
            $ruta = $this->archivoRepository->consultarRutaDeArchivoDeUnaCharlaInformativaPorId($idFile);
            $path = str_replace('storage', 'public', $ruta->ruta);
            return Storage::response($path);
        } catch (\Exception $e) {
            return abort(404, $e->getMessage());
        }

    }

    /**
     * Sube un archivo de las charlas informativas al servidor, además de que lo registra en la base de datos
    * @param Request $request
    * @param int $id Id de la charla con el que se le subirá el archivo
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
            $charla = $this->charlaInformativaRepository->consultarInformacionDeUnaCharlaInformativaRepository($id);
            $nodo_id = $charla->nodo_id;
            $file = request()->file('nombreArchivo');
            $route = "";
            // La ruta con la se guardan los archivos de una es la siguiente:
            // id_nodo/anho_de_la_fecha_de_incio/Edts/id_gestor/edt_id/max_id_archivo_proyecto_nombre_del_archivo.extension
            $idArchivoCharlaInformativa = RutaModel::selectRaw('MAX(id+1) AS max')->get()->last();
            $fileName = $idArchivoCharlaInformativa->max . '_' . $file->getClientOriginalName();
            // Creando la ruta
            $nodo = sprintf("%02d", $nodo_id);
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
        try {
            $ruta = RutaModel::find($idFile);
            $path = str_replace('storage', 'public', $ruta->ruta);
            return Storage::response($path);
        } catch (\Exception $e) {
            return abort(404, $e->getMessage());
        }
    }

    /**
     * Método que elimina un archivo del servidor y su registro de la base de datos (RutaModel)
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
        try {
            $ruta = RutaModel::find($idFile);
            $path = str_replace('storage', 'public', $ruta->ruta);
            return Storage::response($path);
        } catch (\Exception $e) {
            return abort(404, $e->getMessage());
        }

    }

    /**
     * Método que elimina un archivo del servidor y su registro de la base de datos (RutaModel)
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
        return datatables()->of($files)
        ->addColumn('download', function ($data) {
            $download = '
            <a target="_blank" href="' . route('taller.files.download', $data->id) . '" class="btn blue darken-4 m-b-xs">
            <i class="material-icons">file_download</i>
            </a>
            ';
            return $download;
        })->addColumn('delete', function ($data) {
            if (request()->user()->can('delete', Entrenamiento::class)) {
                $delete = '<form method="POST" action="' . route('taller.files.destroy', $data) . '">
                ' . method_field('DELETE') . '' .  csrf_field() . '
                <button class="btn red darken-4 m-b-xs">
                <i class="material-icons">delete_forever</i>
                </button>
                </form>';
            } else {
                $delete = '<button class="btn disabled darken-4 m-b-xs">
                <i class="material-icons">delete_forever</i>
                </button>';
            }
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
                'nombreArchivo' => 'max:50000',
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
            $nodo = sprintf("%02d", auth()->user()->articulador->nodo_id);
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
        // La ruta con la se guardan los archivos de un proyecto es la siguiente:
        // id_nodo/anho_de_la_fecha_de_inicio_del_proyecto/Proyectos/linea_tecnológica/id_gestor/id_del_proyecto/fase_del_archivo/max_id_archivo_proyecto_nombre_del_archivo.extension
        $idArchivoModel = ArchivoModel::selectRaw('MAX(id+1) AS max')->get()->last();
        $fileName = $idArchivoModel->max . '_' . $file->getClientOriginalName();
        // dd($fileName);
        // Creando la ruta
        $proyecto = Proyecto::findOrFail($id);
        $route = "";
        $nodo = sprintf("%02d", $proyecto->nodo_id);
        $anho = Carbon::parse($proyecto->fecha_inicio)->isoFormat('YYYY');
        $linea = $proyecto->sublinea->lineatecnologica_id;
        $gestor = sprintf("%03d", $proyecto->experto_id);
        $idproyecto = $proyecto->id;
        $fase = Fase::select('id', 'nombre')->where('nombre', $request->fase)->get()->last();
        $fase_id = $fase->id;
        $fase = $fase->nombre;
        $route = 'public/' . $nodo . '/' . $anho . '/Proyectos' . '/' . $linea . '/' . $gestor . '/' . $idproyecto . '/' . $fase;
        $fileUrl = $file->storeAs($route, $fileName);
        $id = $proyecto->id;
        $proyecto->archivos()->create([
            'ruta' => Storage::url($fileUrl),
            'fase_id' => $fase_id
        ]);
        }
    }

    /**
     * @param int $idFile Id del archivo
     * @return Response
     * @author Victor Manuel Moreno Vega
     */
    public function destroyFileProyecto($idFile)
    {
        $file = ArchivoModel::find($idFile);
        if(!request()->user()->can('delete_files', [$file->model, $file->model->fase->nombre])) {
            toast('No tienes permisos para borrar este archivo!','success')->autoClose(2000)->position('top-end');
        } else {
            $file->delete();
            $filePath = str_replace('storage', 'public', $file->ruta);
            Storage::delete($filePath);
            toast('El Archivo se ha eliminado con éxito!','success')->autoClose(2000)->position('top-end');
        }
        return back();
    }

    // Descarga el archivo de un proyecto
    public function downloadFileProyecto($idFile)
    {
        try {
            $ruta = ArchivoModel::find($idFile);
            if (!$this->verificarAccesoADescarga($ruta)) {
                toast('No haces parte de este proyecto, por lo que no lo puedes descargar!','warning')->autoClose(2000)->position('top-end');
                return back();
            }
            $path = str_replace('storage', 'public', $ruta->ruta);
            return Storage::response($path);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }



    public function verificarAccesoADescarga($file)
    {
        if (session()->get('login_role') == User::IsDinamizador()) {
            if ($file->model->nodo_id != auth()->user()->dinamizador->nodo_id) {
                return false;
            }
        }
        if (session()->get('login_role') == User::IsInfocenter()) {
            if ($file->model->nodo_id != auth()->user()->infocenter->nodo_id) {
                return false;
            }
        }
        if (session()->get('login_role') == User::IsExperto()) {
            if ($file->model->asesor_id != auth()->user()->id) {
                return false;
            }
        }
        if (session()->get('login_role') == User::IsArticulador()) {
            if ($file->model->nodo_id != auth()->user()->articulador->nodo_id) {
                return false;
            }
        }
        if (session()->get('login_role') == User::IsTalento()) {
            $talento = $file->model->talentos()->wherePivot('user_id', auth()->user()->id)->first();
            if ($talento == null) {
                return false;
            }
        }
        if (session()->get('login_role') == User::IsAdministrador() || session()->get('login_role') == User::IsArticulador())
            return true;

        return true;
    }


    // Descarga el archivo de la articulación
    public function downloadFileArticulation($idFile)
    {
        try {
            $archivo = ArchivoModel::select('id', 'ruta')->where('id', $idFile)->first();
            $path = str_replace('storage', 'public', $archivo->ruta);
            return Storage::response($path);
        } catch (\Exception $e) {
            return abort(404, $e->getMessage());
        }
    }
      /**
     * Tabla para mostrar los archivos de una articulacion_proyecto
    * @param int $id Id de la articulacion_proyecto
    * @return Reponse
    * @author Victor Manuel Moreno Vega
    */
    public function datatableArchivosArticulacionProyecto($query, $proyecto)
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
            $archivosDeUnProyecto =  $proyecto->archivos()->whereHas('fase', function($query) use($fase) {
                $query->where('nombre', $fase);
            })->get();
            return $this->datatableArchivosArticulacionProyecto($archivosDeUnProyecto, $proyecto);
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
                'nombreArchivo' => 'max:50000|mimes:jpeg,png,jpg,docx,doc,pdf,exe,xlsl,xlsx,xls,pptx,sldx,ppsx,exe,zip',
            ],
                [
                    'nombreArchivo.mimes' => 'El tipo de archivo no es permitido',
                    'nombreArchivo.max' => 'El tamaño del archivo no puede superar las 50MB'
                ]);
            $file = request()->file('nombreArchivo');

            $archivo = ArchivoModel::selectRaw('MAX(id+1) AS max')->get()->last();
            $fileName = $archivo->max . '_' . $file->getClientOriginalName();
            $route = "";
            switch ($request->type){
                case "ArticulationStage":
                    $articulation = ArticulationStage::query()->findOrFail($id);
                    $node = sprintf("%02d", $articulation->node_id);
                    $year = Carbon::parse($articulation->start_date)->isoFormat('YYYY');
                    $route = "public/{$node}/{$year}/".Str::slug(__('articulation-stage'))."/{$articulation->present()->articulationStageCode()}";
                    break;
                case "Articulation":
                    $articulation = Articulation::query()->findOrFail($id);
                    $node = sprintf("%02d", $articulation->articulationstage->node_id);
                    $year = Carbon::parse($articulation->articulationstage->start_date)->isoFormat('YYYY');
                    if(isset($request->phase)){
                        $phase = strtolower($request->phase);
                        $route = "public/{$node}/{$year}/". Str::slug(__('articulation-stage'))."/{$articulation->articulationstage->present()->articulationStageCode()}/{$articulation->code}/{$phase}";
                    }else{
                        $route = "public/{$node}/{$year}/". Str::slug(__('articulation-stage'))."/{$articulation->articulationstage->present()->articulationStageCode()}/{$articulation->code}";
                    }
                    break;
                default:
                    break;
            }
            $fileUrl = $file->storeAs($route, $fileName);
            if(isset($request->phase)){
                $phase = Fase::where('nombre',$request->phase)->first();
                $articulation->archivomodel()->create([
                    'ruta' => Storage::url($fileUrl),
                    'fase_id' => isset($phase)? $phase->id : null
                ]);
            }else{
                $articulation->archivomodel()->create([
                    'ruta' => Storage::url($fileUrl)
                ]);
            }
        }
    }

    /**
     * Muestra la datatable de los arcivos de una articulacion
     * @param int $id id de la articulacion
     * @param string $fase nombre de la fase
     * @return Datatable
     */
    public function datatableArchiveArticulations(Request $request,$id)
    {
        if (request()->ajax()) {
            switch ($request->type){
                case "ArticulationStage":
                    $articulation = ArticulationStage::findOrFail($id);
                    $archive =  $articulation->archivomodel()->get();
                    return $this->datatableFilesArticulation($archive);
                    break;
                case "Articulation":
                    $articulation = Articulation::findOrFail($id);
                    if(isset($request->phase)){
                        $archive =  $articulation->archivomodel()->whereHas('fase', function($query) use($request){
                            $query->where('nombre', $request->phase);
                        })->get();
                    }else{
                        $archive =  $articulation->archivomodel()->get();
                    }
                    return $this->datatableFilesArticulation($archive);
                    break;
                default:
                    return $this->datatableFilesArticulation([]);
                    break;
            }
        }
    }

    // Descarga el archivo de la articulación
    public function downloadFileNode($idFile)
    {
        try {
            $archivo = ArchivoModel::select('id', 'ruta')->where('id', $idFile)->first();
            $path = str_replace('storage', 'public', $archivo->ruta);
            return Storage::response($path);
        } catch (\Exception $e) {
            return abort(404, $e->getMessage());
        }
    }

    /**
     * Subida de un arcivo al servidor
     * @param Request
     * @param string $node nodo
     * @return void
     */
    public function uploadFileNode(Request $request, $node)
    {

        if (request()->ajax()) {
            $this->validate($request, [
                'nombreArchivo' => 'max:50000|mimes:jpeg,png,jpg,docx,doc,pdf,exe,xlsl,xlsx,xls,pptx,sldx,ppsx,exe,zip',
            ],
                [
                    'nombreArchivo.mimes' => 'El tipo de archivo no es permitido',
                    'nombreArchivo.max' => 'El tamaño del archivo no puede superar las 50MB'
                ]);

            $file = request()->file('nombreArchivo');

            $archivo = ArchivoModel::selectRaw('MAX(id+1) AS max')->get()->last();
            $fileName = $archivo->max . '_' . $file->getClientOriginalName();
            $route = "";

            switch ($request->type){
                case "Nodo":
                    $node = Nodo::query()->findOrFailNodo($node);
                    $nodeid = sprintf("%02d", $node->id);
                    $year = Carbon::now()->isoFormat('YYYY');
                    $route = "public/{$nodeid}/{$year}/nodos";
                    break;
                default:
                    return;
                    break;
            }
            $fileUrl = $file->storeAs($route, $fileName);
            $node->model()->create([
                'ruta' => Storage::url($fileUrl)
            ]);
        }
    }

    /**
     * Muestra la datatable de los arcivos de un nodo
     * @param int $id id de la articulacion
     * @param string $fase nombre de la fase
     * @return Datatable
     * @author devjul
     */
    public function datatableArchivesNodes(Request $request, $node)
    {
        if (request()->ajax()) {
            switch ($request->type){
                case "Nodo":
                    $node= Nodo::query()->findOrFailNodo($node);
                    if(isset($request->year) && $request->year != 'all'){
                        $archive = $node->model()->whereYear('created_at', $request->year)->get();
                    }else{
                        $archive =  $node->model()->get();
                    }

                    return $this->datatableFilesNode($archive);
                    break;
                default:
                    return $this->datatableFilesNode([]);
                    break;
            }
        }
    }


    private function datatableFilesNode($query)
    {
        return datatables()->of($query)
            ->addColumn('download', function ($data) {
                return "<a target='_blank' href='".route('nodo.files.download', $data->id)."' class='btn blue darken-4 m-b-xs'>
                                <i class='material-icons'>file_download</i>
                            </a>";
            })->addColumn('delete', function ($data) {
                $delete = '<form method="POST" action="' . route('nodo.files.destroy', [$data->id]) . '">
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
     * Tabla para mostrar los archivos de una articulacion_pbt
     * @param int $id id de la articulacion
     * @return Reponse
     * @author devjul
     */
    private function datatableFilesArticulation($query)
    {
        return datatables()->of($query)
            ->addColumn('download', function ($data) {
                return "<a target='_blank' href='".route('articulation.files.download', $data->id)."' class='btn blue darken-4 m-b-xs'>
                                <i class='material-icons'>file_download</i>
                            </a>";
            })->addColumn('delete', function ($data) {
                $delete = '<form method="POST" action="' . route('articulation.files.destroy', [$data->id]) . '">
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
     * @param int $idFile Id del archivo artilacion
     * @return Response
     */
    public function destroyFileArticulation($idFile)
    {
        $file = ArchivoModel::find($idFile);
        $file->delete();
        $filePath = str_replace('storage', 'public', $file->ruta);
        Storage::delete($filePath);
        toast('El Archivo se ha eliminado con éxito!','success')->autoClose(2000)->position('top-end');
        return back();
    }

    public function destroyFileNode($idFile)
    {
        $file = ArchivoModel::find($idFile);
        $file->delete();
        $filePath = str_replace('storage', 'public', $file->ruta);
        Storage::delete($filePath);
        toast('El Archivo se ha eliminado con éxito!','success')->autoClose(2000)->position('top-end');
        return back();
    }

}
