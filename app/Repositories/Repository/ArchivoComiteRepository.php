<?php

namespace App\Repositories\Repository;

use Illuminate\Support\Facades\DB;
use App\Models\ArchivoComite;
use App\Models\Comite;

class ArchivoComiteRepository
{
  // Hace el registro de un comité
  public function store($id, $fileUrl)
  {
    return ArchivoComite::create([
      'comite_id' => $id,
      'ruta' => $fileUrl,
    ]);
  }

  // Selecciona el máximo id de las imágenes
  public function maxIdArchivoComite()
  {
    return ArchivoComite::selectRaw('MAX(archivoscomites.id)+1 AS maxId')->get()->last();;
  }

  // Consulta la ruta de un archivo según su id
  public function consultarRutaDeArchivoPorId($id)
  {
    return ArchivoComite::select('id', 'ruta')->where('id', $id)->get()->last();
  }
}
