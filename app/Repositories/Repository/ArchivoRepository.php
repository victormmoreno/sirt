<?php

namespace App\Repositories\Repository;

use Illuminate\Support\Facades\DB;
use App\Models\{ArchivoArticulacion};

class ArchivoRepository
{

  // Consulta la ruta de un archivo de la articulación según su id (Principalmente para descargarlo)
  public function consultarRutaDeArchivoDeLaArticulacionPorId($id)
  {
    return ArchivoArticulacion::select('id', 'ruta')->where('id', $id)->get()->last();
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
