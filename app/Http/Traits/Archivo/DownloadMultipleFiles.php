<?php

namespace App\Http\Traits\Archivo;
use ZipArchive;
use App\Models\ArchivoModel;
use App\Models\Proyecto;
use Storage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Archivos\ReporteDescargaArchivos;


trait DownloadMultipleFiles
{
    public function downloadMultipleFiles($nodos, $desde, $hasta) {
        $zip = new ZipArchive;
        $query = $this->getProyectosFinalizados($nodos, $desde, $hasta);
        $finalizados = $query->get();
        $files = $this->getFilesToDownload($query)->get();
        $zipFileName = 'Actas de inicio finalizados entre '.$desde.' y '.$hasta.'.zip';
        if ($zip->open($zipFileName, ZipArchive::CREATE) === true) {
            $filesToZip = $this->getFilesToZip($files);
            $fileZip = $this->addFilesToZip($zip, $filesToZip);
            $archivo_reporte = $this->generarReporteDeDescarga($finalizados, $fileZip['files']);
            $archivo_reporte = Excel::raw(new ReporteDescargaArchivos($archivo_reporte), \Maatwebsite\Excel\Excel::XLSX);
            $zip = $fileZip['zip'];
            $zip->addFromString('Reporte.xlsx', $archivo_reporte);
            $zip->close();
            return response()->download(public_path($zipFileName))->deleteFileAfterSend(true);
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
            $reporte->push([
                'nodo' => $actividad->nombre_nodo,
                'linea' => $actividad->nombre_linea,
                'codigo' => $actividad->codigo,
                'cantidad_archivos' => $archivos_descargados->count(),
                'nombre_archivos' => $archivos_descargados->count() == 0 ? 'No se encontraron documentos' : $this->getNombreArchivosDescargados($archivos_descargados)
            ]);

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
     * @return type
     * @return Builder
     **/
    private function getFilesToDownload(Builder $query)
    {
        $proyecto_class = Proyecto::class;
        $files = $query->addSelect('archivo_model.ruta', 'proyectos.codigo_proyecto AS codigo')
        ->leftJoin('archivo_model', function($q) use ($proyecto_class) {$q->on('archivo_model.model_id', '=', 'proyectos.id')->where('archivo_model.model_type', "$proyecto_class");})
        ->join('fases as fase_archivo', 'fase_archivo.id', '=', 'archivo_model.fase_id')
        // ->where('proyectos.id', 14347)
        // ->where('proyectos.id', 13051)
        ->where('fase_archivo.nombre', Proyecto::IsInicio())
        ->whereRaw("SUBSTRING_INDEX(ruta, '/', -1) like('%inicio%') and SUBSTRING_INDEX(ruta, '/', -1) like('%acta%')")
        ->groupBy('archivo_model.ruta');
        return $files;
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
    private function getProyectosFinalizados($nodos, $desde, $hasta)
    {
        $query = null;
        $query = $this->proyectoRepository->indicadoresProyectos()->addSelect('proyectos.codigo_proyecto AS codigo');
        $query = $this->nodos($nodos, $query)
        ->whereBetween('fecha_cierre', [$desde, $hasta])
        ->whereIn('fases.nombre', [Proyecto::IsFinalizado()]);
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
                $zip->addFile(substr($file['route'], 1), $file['codigo'].'/' . basename(substr($file['route'], 1)));
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
        foreach ($files as $key => $value) {
            $filesToZip[$key]['route'] = $value->ruta;
            $filesToZip[$key]['archivo'] = basename($value->ruta);
            $filesToZip[$key]['codigo'] = $value->codigo;
        }
        return $filesToZip;
    }

    private function nodos($nodos, $query)
    {
        if ($nodos[0] != 'all' && $nodos[0] != null && $nodos[0] != 0) {
            return $query->whereIn('nodos.id', is_array($nodos) ? $nodos : [$nodos]);
        }
        return $query;
    }
}