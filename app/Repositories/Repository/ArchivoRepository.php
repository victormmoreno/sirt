<?php

namespace App\Repositories\Repository;

use Illuminate\Support\Facades\DB;
use App\Models\{ArchivoArticulacion, ArchivoProyecto, ArchivoEntrenamiento, ArchivoEdt, ArchivoCharlaInformativa};

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
