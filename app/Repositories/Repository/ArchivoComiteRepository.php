<?php

namespace App\Repositories\Repository;

use Illuminate\Support\Facades\DB;
use App\Models\{Comite, RutaModel};

class ArchivoComiteRepository
{
  /**
  * @param int $id Id del comité
  * @param string $fileUrl Ruta del archivo
  * @return Collection
  * @author dum
  */
  public function store($id, $fileUrl)
  {
    $comite = Comite::find($id);
    $comite->rutamodel()->create([
      'ruta' => $fileUrl,
    ]);
  }

  /**
  * Consulta los datos de un archivo del comité
  * @param int $id Id del archivo
  * @return Collecion
  * @author dum
  */
  public function consultarRutaDeArchivoPorId($id)
  {
    return RutaModel::find($id);
  }
}
