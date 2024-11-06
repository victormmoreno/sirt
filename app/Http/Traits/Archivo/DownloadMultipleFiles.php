<?php

namespace App\Http\Traits\Archivo;

use App\Enums\DescargaArchivos;
use App\Exports\Archivos\ReporteDescargaArchivos;
use App\Models\Articulation;
use App\Models\Proyecto;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Storage;
use ZipArchive;


trait DownloadMultipleFiles
{
    public function downloadMultipleFiles(Request $request)
    {
        $zip = new ZipArchive;
        $query = $this->getQueryActividades($request);
        $actividades = $query->get();
        $files = $this->getFilesToDownload($query, $request);
        $files = $this->palabrasClaves($request, $files)->get();
        if ($files->count() == 0) {
            alert('Error!', 'No se encontraron archivos para descargar', 'warning')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        $zipFileName = $this->getZipName($request);
        if ($zip->open($zipFileName, ZipArchive::CREATE) === true) {
            $filesToZip = $this->getFilesToZip($files);
            $fileZip = $this->addFilesToZip($zip, $filesToZip);
            // dd($fileZip);
            $archivo_reporte = $this->generarReporteDeDescarga($actividades, $fileZip['files']);
            $archivo_reporte = Excel::raw(new ReporteDescargaArchivos($archivo_reporte), \Maatwebsite\Excel\Excel::XLSX);
            $zip = $fileZip['zip'];
            $zip->addFromString('A-Reporte.xlsx', $archivo_reporte);
            $zip->close();
            return response()->download(public_path($zipFileName))->deleteFileAfterSend(true);
        }
    }

    /**
     * Retorna el nombre del archivo .zip
     *
     * @param Request $request
     * @return string
     * @author dum
     **/
    private function getZipName($request)
    {
        switch ($request->archivos) {
            case DescargaArchivos::INICIO:
                return 'Actas de inicio finalizados entre ' . $request->txtdesde . ' y ' . $request->txthasta . '.zip';
                break;
            case DescargaArchivos::CIERRE:
                return 'Actas de cierre finalizados entre ' . $request->txtdesde . ' y ' . $request->txthasta . '.zip';
                break;
            case DescargaArchivos::COMPROMISO:
                return 'Acuerdos de confidencialidad y compromiso finalizados entre ' . $request->txtdesde . ' y ' . $request->txthasta . '.zip';
                break;

            default:
                # code...
                break;
        }
    }

    /**
     * Retornar el query con las actividades de las que se descargarán los archivos
     *
     * @param $request
     * @return Builder
     * @author dum
     **/
    private function getQueryActividades($request)
    {
        switch (class_basename($request->actividad)) {
            case class_basename(Proyecto::class):
                return $this->getProyectosFinalizados($request);
                break;
            case class_basename(Articulation::class):
                return $this->getAccionesArticulacionFinalizadas($request);
                break;
            default:
                break;
        }
    }

    /**
     * Genera el reporte de los archivos que se descargan
     *
     * @param $finalizados Query con las actividades
     * @param $files Archivos que se deben descargar
     * @return type
     * @author dum
     **/
    private function generarReporteDeDescarga($actividades, $files)
    {
        $reporte = new Collection();
        $files = $this->convertArrayToCollection($files);

        foreach ($actividades as $key => $actividad) {
            $files_temp = $files->where('codigo', $actividad->codigo);
            $archivos_descargados = $this->getArchivosDescargados($files_temp);
            if (isset($actividad->nombre_linea)) {
                $reporte->push([
                    'nodo' => $actividad->nombre_nodo,
                    'linea' => $actividad->nombre_linea,
                    'codigo' => $actividad->codigo,
                    'cantidad_archivos' => $archivos_descargados->count(),
                    'nombre_archivos' => $archivos_descargados->count() == 0 ? 'No se encontraron documentos' : $this->getNombreArchivosDescargados($archivos_descargados)
                ]);
            } else {
                $reporte->push([
                    'nodo' => $actividad->nombre_nodo,
                    'codigo' => $actividad->codigo,
                    'cantidad_archivos' => $archivos_descargados->count(),
                    'nombre_archivos' => $archivos_descargados->count() == 0 ? 'No se encontraron documentos' : $this->getNombreArchivosDescargados($archivos_descargados)
                ]);
            }
        }
        return $reporte;
    }

    /**
     * Retornar los nombres de los archivos que se descargaron
     *
     * @param $archivos_actividad Archivos que se descargaron de cada actividad
     * @return Collection
     * @author dum
     **/
    private function getNombreArchivosDescargados($arhivos_descargados)
    {
        return $arhivos_descargados->implode('archivo', ';');
    }

    /**
     * Retornar la cantidad de archivos descargados de una actividad
     *
     * @param $archivos_actividad Archivos que se descargaron de cada actividad
     * @return Collection
     * @author dum
     **/
    private function getArchivosDescargados($archivos_actividad)
    {
        return $archivos_actividad->where('estado');
    }


    /**
     * Convierte el array de los archivos descargados en una Collection
     *
     * @param array $files
     * @return Collection
     * @author dum
     **/
    private function convertArrayToCollection(array $files)
    {
        $collection = new Collection();
        foreach ($files as $key => $file) {
            $collection->push((object) [
                'codigo' => $file['codigo'],
                'route' => $file['route'],
                'archivo' => $file['archivo'],
                'estado' => $file['estado']
            ]);
        }

        return $collection;
    }

    /**
     * Retornar los archivos a descargar
     *
     * @param Builder $query
     * @param $request
     * @return type
     * @return Builder
     **/
    private function getFilesToDownload(Builder $query, $request)
    {
        switch (class_basename($request->actividad)) {
            case class_basename(Proyecto::class):
                $proyecto_class = Proyecto::class;
                $files = $query->addSelect('archivo_model.ruta', 'proyectos.codigo_proyecto AS codigo')
                    ->leftJoin('archivo_model', function ($q) use ($proyecto_class) {
                        $q->on('archivo_model.model_id', '=', 'proyectos.id')->where('archivo_model.model_type', "$proyecto_class");
                    })
                    ->join('fases as fase_archivo', 'fase_archivo.id', '=', 'archivo_model.fase_id')
                    // ->where('proyectos.id', 14347)
                    // ->where('proyectos.id', 13051)
                    // ->where('fase_archivo.nombre', Proyecto::IsInicio())
                    ->groupBy('archivo_model.ruta');
                break;
            case class_basename(Articulation::class):
                $articulacion_class = Articulation::class;
                $files = $query->addSelect('archivo_model.ruta', 'articulations.code AS codigo')
                    ->leftJoin('archivo_model', function ($q) use ($articulacion_class) {
                        $q->on('archivo_model.model_id', '=', 'articulations.id')->where('archivo_model.model_type', "$articulacion_class");
                    })
                    ->join('fases as fase_archivo', 'fase_archivo.id', '=', 'archivo_model.fase_id')
                    ->groupBy('archivo_model.ruta');
                break;
            default:
                # code...
                break;
        }

        return $files;
    }

    /**
     * Retorna la condicion de los archivos según las palabras claves
     *
     * @param $request
     * @param $files
     * @return Builder
     * @author dum
     **/
    private function palabrasClaves($request, $files)
    {
        switch ($request->archivos) {
            case DescargaArchivos::INICIO:
                return $files->whereRaw("SUBSTRING_INDEX(ruta, '/', -1) like('%acta%') and SUBSTRING_INDEX(ruta, '/', -1) like('%inicio%')")
                    ->where('fase_archivo.nombre', Proyecto::IsInicio());
                break;
            case DescargaArchivos::CIERRE:
                return $files->whereRaw("SUBSTRING_INDEX(ruta, '/', -1) like('%acta%') and SUBSTRING_INDEX(ruta, '/', -1) like('%cierre%')")
                    ->where('fase_archivo.nombre', Proyecto::IsCierre());
                break;
            case DescargaArchivos::COMPROMISO:
                return $files->whereRaw("( SUBSTRING_INDEX(ruta, '/', -1) like('%conf%') or SUBSTRING_INDEX(ruta, '/', -1) like('%comp%') )")
                    ->where('fase_archivo.nombre', Proyecto::IsInicio());
                break;
            default:

                break;
        }
    }

    /**
     * Retornar los proyectos finalizados
     *
     * @param $nodos
     * @param $desde
     * @param $hasta
     * @return Builder
     * @author dum
     **/
    private function getProyectosFinalizados($request)
    {
        $query = null;
        $query = $this->proyectoRepository->indicadoresProyectos()->addSelect('proyectos.codigo_proyecto AS codigo');
        $query = $this->nodos($query, $request)
            ->whereBetween('fecha_cierre', [$request->txtdesde, $request->txthasta])
            ->whereIn('fases.nombre', [Proyecto::IsFinalizado()]);
        return $query;
    }

    /**
     * Retornar los proyectos finalizados
     *
     * @param $nodos
     * @param $desde
     * @param $hasta
     * @return Builder
     **/
    private function getAccionesArticulacionFinalizadas($request)
    {
        $query = null;
        $query = $this->articulacionRepository->indicadoresAccionesArticulaciones()->addSelect('articulations.code AS codigo');
        $query = $this->nodos($query, $request)
            ->whereBetween('articulations.end_date', [$request->txtdesde, $request->txthasta])
            ->whereIn('fases.nombre', [Articulation::IsFinalizado()]);
        return $query;
    }

    /**
     * Añade los archivos al .zip
     *
     * @param ZipArchive $zip
     * @param array[] $ruotes
     * @return array
     * @author dum
     **/
    private function addFilesToZip($zip, $routes)
    {
        foreach ($routes as $key => $file) {
            if (Storage::exists(str_replace('storage', 'public', $file['route']))) {
                $zip->addFile(substr($file['route'], 1), $file['codigo'] . '/' . basename(substr($file['route'], 1)));
                $routes[$key]['estado'] = true;
            } else {
                $routes[$key]['estado'] = false;
            }
        }
        return ['zip' => $zip, 'files' => $routes];
    }

    /**
     * Retorna la rutas de los archivos que se comprimirán
     *
     * @param Collection $files Query con las rutas de los archivos que se enviarán
     * @return array
     * @author dum
     **/
    private function getFilesToZip($files)
    {
        $filesToZip = null;
        foreach ($files as $key => $value) {
            $filesToZip[$key]['route'] = $value->ruta;
            $filesToZip[$key]['archivo'] = basename($value->ruta);
            $filesToZip[$key]['codigo'] = $value->codigo;
        }
        return $filesToZip;
    }

    private function nodos($query, $request)
    {
        if ($request->selectNodos[0] != 'all' && $request->selectNodos[0] != null && $request->selectNodos[0] != 0) {
            return $query->whereIn('nodos.id', is_array($request->selectNodos) ? $request->selectNodos : [$request->selectNodos]);
        }
        return $query;
    }
}
