<?php

namespace App\Repositories\Repository;

use Illuminate\Support\Facades\DB;
use App\Models\{ArchivoArticulacion, ArchivoProyecto};

class ArchivoRepository
{

  // Consulta la ruta de un archivo de la articulación según su id (Principalmente para descargarlo)
  public function consultarRutaDeArchivoDeLaArticulacionPorId($id)
  {
    return ArchivoArticulacion::select('id', 'ruta')->where('id', $id)->get()->last();
  }

  // Consulta la ruta de un archivo de la articulación según su id (Principalmente para descargarlo)
  public function consultarRutaDeArchivoDeUnProyectoPorId($id)
  {
    return ArchivoProyecto::select('id', 'ruta')->where('id', $id)->get()->last();
  }

  // Consulta los archivos de un proyecto
  public function consultarRutasArchivosDeUnProyecto($id)
  {
    return ArchivoProyecto::select('ruta', 'archivosproyecto.id', 'fases.nombre AS fase')
    ->join('proyectos', 'proyectos.id', '=', 'archivosproyecto.proyecto_id')
    ->join('fases', 'fases.id', '=', 'archivosproyecto.fase_id')
    ->where('proyectos.id', $id)
    ->get();
  }

  // Consulta los archivos de una articulación
  public function consultarRutasArchivosDeUnaArticulacion($id)
  {
    return ArchivoArticulacion::select('ruta', 'archivosarticulaciones.id', 'fases.nombre AS fase')
    ->join('articulaciones', 'articulaciones.id', '=', 'archivosarticulaciones.articulacion_id')
    ->join('fases', 'fases.id', '=', 'archivosarticulaciones.fase_id')
    ->where('articulaciones.id', $id)
    ->get();
  }

  // Guarda las rutas de los archivos que se registran de un proyecto
  public function storeFileProyecto($id, $fase, $fileUrl)
  {
    return ArchivoProyecto::create([
      'proyecto_id' => $id,
      'fase_id' => $fase,
      'ruta' => $fileUrl,
    ]);
  }

  // Guarda las rutas de los archivos que se registran de una articulación
  public function storeFileArticulacion($id, $fase, $fileUrl)
  {
    return ArchivoArticulacion::create([
      'articulacion_id' => $id,
      'fase_id' => $fase,
      'ruta' => $fileUrl,
    ]);
  }

}
