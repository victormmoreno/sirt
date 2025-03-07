<?php

namespace App\Repositories\Repository;

use App\Models\{RutaModel, ArchivoArticulacionProyecto, Edt, CharlaInformativa, Entrenamiento};

class ArchivoRepository
{

    /**
     * Consulta la ruta de un archivo de una charla informativa
    * @param int id Id del archivo
    * @return Collection
    * @author dum
    */
    public function consultarRutaDeArchivoDeUnaCharlaInformativaPorId($id)
    {
        return RutaModel::find($id);
    }

    /**
     * Guarda la ruta del archivo de la charla informativa en la base de datos
    * @param int id Id del entrenamiento
    * @param string fileUrl Ruta con la que se guardará el arcivo en el servidor
    * @return void
    */
    public function storeFileCharlaInformativaRepository($id, $fileUrl, $size)
    {
        $charla = CharlaInformativa::find($id);
        $charla->rutamodel()->create([
            'ruta' => $fileUrl,
            'filesize' => $size
        ]);
    }

    /**
     * Guarda la ruta del archivo de una edt en la base de datos
    * @param int id Id de la edt
    * @param string fileUrl Ruta con la que se guardará el arcivo en el servidor
    * @return void
    */
    public function storeFileEdt($id, $fileUrl, $size)
    {
        $edt = Edt::find($id);
        $edt->rutamodel()->create([
            'ruta' => $fileUrl,
            'filesize' => $size
        ]);
    }

    /**
     * Guarda la ruta del archivo del entrenamiento en la base de datos
    * @param int id Id del entrenamiento
    * @param string fileUrl Ruta con la que se guardará el arcivo en el servidor
    * @return void
    * @author dum
    */
    public function storeFileEntrenamiento($id, $fileUrl, $size)
    {
        $entrenamiento = Entrenamiento::find($id);
        $entrenamiento->rutamodel()->create([
            'ruta' => $fileUrl,
            'filesize' => $size
        ]);
    }

    /**
     * Consulta la ruta de un archivo de la articulacion_proyecto según su id (Principalmente para descargarlo)
    * @param int $id Id del archivo
    * @return Collection
    * @author dum
    */
    public function consultarRutaDeArchivoDeUnaArticulacionProyectoPorId($id)
    {
        return ArchivoArticulacionProyecto::where('id', $id)->get()->last();
    }

    /**
     * Consuta los archivos de una articulacion_proyecto
     * @param int $id Id de la articulacion_proyecto
     * @param string $fase Nombre de la fase
     * @return Collection
     * @author dum
     */
    public function consultarRutasArchivosDeUnaArticulacionProyecto($id, $fase = null)
    {
            if($fase == null){
            return ArchivoArticulacionProyecto::select('ruta', 'archivos_articulacion_proyecto.id', 'fases.nombre AS fase')
            ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'archivos_articulacion_proyecto.articulacion_proyecto_id')
            ->join('fases', 'fases.id', '=', 'archivos_articulacion_proyecto.fase_id')
            ->where('articulacion_proyecto.id', $id);

            }else{
            return ArchivoArticulacionProyecto::select('ruta', 'archivos_articulacion_proyecto.id', 'fases.nombre AS fase')
            ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'archivos_articulacion_proyecto.articulacion_proyecto_id')
            ->join('fases', 'fases.id', '=', 'archivos_articulacion_proyecto.fase_id')
            ->where('articulacion_proyecto.id', $id)
            ->where('fases.nombre', $fase);
            }
        }


    /**
     * @param int $id Id de la tabla articulacion_proyecto
    * @param int $fase Id de la fase del archivo
    * @param string $fileUrkl Url donde se guardó el archivo
    * @return Collection
    * @author dum
    */
    public function storeFileArticulacionProyecto($id, $fase, $fileUrl)
    {
        return ArchivoArticulacionProyecto::create([
            'articulacion_proyecto_id' => $id,
            'fase_id' => $fase,
            'ruta' => $fileUrl,
        ]);
    }
}
