<?php

namespace App\Repositories\Repository;

use Illuminate\Support\Facades\DB;
use App\Models\{ArchivoArticulacion, ArchivoProyecto, ArchivoEntrenamiento, ArchivoEdt, ArchivoCharlaInformativa, ArchivoArticulacionProyecto};

class ArchivoRepository
{


  /**
  * Consulta la ruta de un archivo de una charla informativa
  * @param int id Id del archivo
  * @return Collection
  */
  public function consultarRutaDeArchivoDeUnaCharlaInformativaPorId($id)
  {
    return ArchivoCharlaInformativa::select('id', 'ruta')->where('id', $id)->get()->last();
  }

  /**
  * Guarda la ruta del archivo de la charla informativa en la base de datos
  * @param int id Id del entrenamiento
  * @param string fileUrl Ruta con la que se guardará el arcivo en el servidor
  * @return void
  */
  public function storeFileCharlaInformativaRepository($id, $fileUrl)
  {
    return ArchivoCharlaInformativa::create([
      'charlainformativa_id' => $id,
      'ruta' => $fileUrl
    ]);
  }

  /**
  * Guarda la ruta del archivo de una edt en la base de datos
  * @param int id Id de la edt
  * @param string fileUrl Ruta con la que se guardará el arcivo en el servidor
  * @return void
  */
  public function storeFileEdt($id, $fileUrl)
  {
    return ArchivoEdt::create([
      'edt_id' => $id,
      'ruta' => $fileUrl,
    ]);
  }

  /**
  * Consulta la ruta de un archivo de una edt
  * @param int id Id del archivo
  * @return Collection
  */
  public function consultarRutaDeArchivoDeUnaEdtPorId($id)
  {
    return ArchivoEdt::select('id', 'ruta')->where('id', $id)->get()->last();
  }

  /**
   * Consulta la ruta de un archivo por id
   * @param int id Id del archivo de la tabla archivosentrenamiento
   * @return Collection
   */
  public function consultarRutaDeArchivoDeUnEntrenamientoPorId($id)
  {
    return ArchivoEntrenamiento::select('id', 'ruta')->where('id', $id)->get()->last();
  }

  /**
  * Guarda la ruta del archivo del entrenamiento en la base de datos
  * @param int id Id del entrenamiento
  * @param string fileUrl Ruta con la que se guardará el arcivo en el servidor
  * @return return void
  */
  public function storeFileEntrenamiento($id, $fileUrl)
  {
    return ArchivoEntrenamiento::create([
      'entrenamiento_id' => $id,
      'ruta' => $fileUrl,
    ]);
  }

  /**
  * Consulta la ruta de un archivo de la articulacion_proyecto según su id (Principalmente para descargarlo)
  * @param int $id Id del archivo
  * @return Collection
  * @author Victor Manuel Moreno Vega
  */
  public function consultarRutaDeArchivoDeUnaArticulacionProyectoPorId($id)
  {
    return ArchivoArticulacionProyecto::select('id', 'ruta')->where('id', $id)->get()->last();
  }

  /**
   * Consuta los archivos de una articulacion_proyecto
   * @param int $id Id de la articulacion_proyecto
   * @return Collection
   * @author Victor Manuel Moreno Vega
   */
  public function consultarRutasArchivosDeUnaArticulacionProyecto($id)
  {
    return ArchivoArticulacionProyecto::select('ruta', 'archivos_articulacion_proyecto.id', 'fases.nombre AS fase')
    ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'archivos_articulacion_proyecto.articulacion_proyecto_id')
    ->join('fases', 'fases.id', '=', 'archivos_articulacion_proyecto.fase_id')
    ->where('articulacion_proyecto.id', $id)
    ->get();
  }

  /**
  * @param int $id Id de la tabla articulacion_proyecto
  * @param int $fase Id de la fase del archivo
  * @param string $fileUrkl Url donde se guardó el archivo
  * @return Collection
  * @author Victor Manuel Moreno Vega
  */
  public function storeFileArticulacionProyecto($id, $fase, $fileUrl)
  {
    return ArchivoArticulacionProyecto::create([
      'articulacion_proyecto_id' => $id,
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
