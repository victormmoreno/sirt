<?php

namespace App\Repositories\Repository;

use App\Models\{Actividad, Articulacion, ArticulacionProyecto, Entidad, ArchivoArticulacionProyecto, UsoInfraestructura};
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ArticulacionRepository
{

  /**
   * Cantidad de articulaciones con grupos de investigación
   *
   * @return Builder
   * @author dum
   */
  public function consultarTotalDeArticulacionesGrupos()
  {
    return Articulacion::selectRaw('count(articulaciones.id) AS cantidad')
    ->join('tiposarticulaciones', 'tiposarticulaciones.id', '=', 'articulaciones.tipoarticulacion_id')
    ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'articulaciones.articulacion_proyecto_id')
    ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
    ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
    ->join('entidades', 'entidades.id', '=', 'articulacion_proyecto.entidad_id')
    ->join('gruposinvestigacion', 'entidades.id', '=', 'gruposinvestigacion.entidad_id')
    ->where('tipo_articulacion', Articulacion::IsGrupo());
  }

  /**
   * Cantidad de articulaciones con empresas y emprendedores
   *
   * @return Builder
   * @author dum
   */
  public function consultarTotalDeArticulacionesEmpresasEmprendedores()
  {
    return Articulacion::selectRaw('count(articulaciones.id) AS cantidad')
    ->join('tiposarticulaciones', 'tiposarticulaciones.id', '=', 'articulaciones.tipoarticulacion_id')
    ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'articulaciones.articulacion_proyecto_id')
    ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
    ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
    ->whereIn('tipo_articulacion', [Articulacion::IsEmpresa(), Articulacion::IsEmprendedor()]);
  }

  /**
   * Método que retorna el directorio de los archivos que tiene una articulación en el servidor
   * @param int $id Id de la articulacion_proyecto
   * @return mixed
   * @author dum
   */
  private function returnDirectoryArticulacionFiles($id)
  {
    // consulta los archivos de una articulacion_proyecto (registro de la base de datos)
    $tempo = ArchivoArticulacionProyecto::where('articulacion_proyecto_id', $id)->first();
    if ($tempo == null) {
      return false;
    } else {
      // Función para dividir la cadena en un array (Partiendolos con el delimitador /)
      $route = preg_split("~/~", $tempo->ruta, 9);
      // Extrae el último elemento del array
      array_pop($route);
      // Une el array en un string, dicho string se separa por /
      $route = implode("/", $route);
      // Reemplaza storage por public en la routa
      $route = str_replace('storage', 'public', $route);
      // Retorna el directorio de los archivos de la articulación
      return $route;
    }

  }

  /**
   * Elimina una articulación de la base de datos y sus anexo
   *
   * @param int $id Id de la articulación
   * @return boolean
   * @author dum
   */
  public function eliminarArticulacion_Repository(int $id)
  {
    DB::beginTransaction();
    try {
      $articulacion = Articulacion::find($id);
      $padre = $articulacion->articulacion_proyecto->actividad;
      // Se usa el método sync sin nada para eliminar los datos de las relaciones muchos a muchos
      // Elimina los datos de la tabla articulacion_proyecto_talento relacionados con la articulacion
      $articulacion->articulacion_proyecto->talentos()->sync([]);
      // Elimina los emprendedores de la articulación
      $articulacion->emprendedores()->delete();
      // Elimina el registro de la tabla de proyecto
      $padre->articulacion_proyecto->articulacion()->delete();
      // Directorio del proyecto
      $directory = $this->returnDirectoryArticulacionFiles($padre->articulacion_proyecto->id);
      if ($directory != false) {
        // Elimina los archivos del servidor
        \Storage::deleteDirectory($directory);
        // Elimina los registros de la tabla de archivos_articulacion_proyecto
        ArchivoArticulacionProyecto::where('articulacion_proyecto_id', $padre->articulacion_proyecto->id)->delete();
      }
      // Elimina el registro de la tabla la tabla de articulacion_proyecto
      $padre->articulacion_proyecto()->delete();
      // Elimina los registros de la tabla material_uso
      UsoInfraestructura::deleteUsoMateriales($padre);
      // Elimina los registros de la tabla uso_talentos
      UsoInfraestructura::deleteUsoTalentos($padre);
      // Elimina los registros de la tabla gestor_uso
      UsoInfraestructura::deleteUsoGestores($padre);
      // Elimina los registros de la tabla equipo_uso
      UsoInfraestructura::deleteUsoEquipos($padre);
      // Elimina los registros de la tabla usoinfraestructuras
      $padre->usoinfraestructuras()->delete();
      // Elimina la tabla de actividades
      $padre->delete();
      DB::commit();
      return true;
    } catch (\Exception $e) {
      DB::rollback();
      return false;
    }

  }

  /**
   * Consulta las articulaciones finalizadas entre dos fechas
   * @param string $fecha_inicio Primera fecha para relizar el filtro
   * @param string $fecha_fin Segunda fecha para realizar el filtro
   * @return Builder
   * @author dum
   */
  public function consultarArticulacionesFinalizadasPorFecha_Detalle($fecha_inicio, $fecha_fin)
  {
    return Articulacion::select('codigo_actividad',
    'actividades.nombre',
    'tiposarticulaciones.nombre AS nombre_tipoarticulacion',
    'fecha_inicio',
    'fecha_cierre',
    'articulaciones.observaciones',
    'acta_inicio',
    'acc',
    'actas_seguimiento',
    'acta_cierre',
    'informe_final',
    'pantallazo')
    ->selectRaw('IF(tipo_articulacion = ' . Articulacion::IsGrupo() . ', "Grupo de Investigación", IF(tipo_articulacion = ' . Articulacion::IsEmpresa() . ', "Empresa", "Emprendedor(es)") ) AS tipo_articulacion')
    ->selectRaw('IF(articulaciones.estado = ' . Articulacion::IsInicio() . ', "Inicio", IF(articulaciones.estado = ' . Articulacion::IsEjecucion() . ', "Ejecución", "Cierre")) AS estado')
    ->selectRaw('IF(revisado_final = ' . ArticulacionProyecto::IsPorEvaluar() . ', "Por Evaluar", IF(revisado_final = ' . ArticulacionProyecto::IsAprobado() . ', "Aprobado", "No Aprobado")) AS revisado_final')
    ->selectRaw('concat(users.nombres, " ", users.apellidos) AS gestor')
    ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'articulaciones.articulacion_proyecto_id')
    ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
    ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
    ->join('users', 'users.id', '=', 'gestores.user_id')
    ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
    ->join('tiposarticulaciones', 'tiposarticulaciones.id', '=', 'articulaciones.tipoarticulacion_id')
    ->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin])
    ->where('articulaciones.estado', Articulacion::IsCierre());
  }

  /**
   * Consulta articulaciones finalizadas entre dos fechas (de cierre)
   * @param string $fecha_inicio Primera fecha para realizar el filtro
   * @param string $fecha_fin Segunda fecha para realizar el filtro
   * @return Builder
   */
  public function consultarArticulacionesFinalizadasPorFechas_Repository($fecha_inicio, $fecha_fin)
  {
    return Articulacion::selectRaw('COUNT(articulaciones.id) AS cantidad')
    ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'articulaciones.articulacion_proyecto_id')
    ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
    ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
    ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
    ->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin])
    ->where('estado', Articulacion::IsCierre());
  }


  /**
  * Cambia el gestor que está asociado a una articulación
  * @param Request $request
  * @param int $id Id de la articulación
  * @return boolean
  * @author dum
  */
  public function updateGestorArticulacion_Repository($request, $id)
  {
    DB::beginTransaction();
    try {
      $articulacion = Articulacion::find($id);
      $articulacion->articulacion_proyecto->actividad()->update([
        'gestor_id' => $request->txtgestor_id,
      ]);
      DB::commit();
      return true;
    } catch (\Exception $e) {
      DB::rollback();
      return false;
    }
  }

  /**
  * Consulta las articulaciones que se finalizaron en un año en un nodo
  *
  * @param int $id Id del nodo
  * @param string $anho Año para realizar el filtro
  * @return Collection
  * @author dum
  */
  public function consultarArticulacionesFinalizadasPorNodoYAnho_Repository($id, $anho)
  {
    // dd($id);
    return Articulacion::select('actividades.codigo_actividad',
    'actividades.fecha_inicio',
    'actividades.fecha_cierre',
    'tiposarticulaciones.nombre AS nombre_tipoarticulacion',
    'articulaciones.observaciones',
    'actividades.nombre')
    ->selectRaw('concat(users.nombres, " ", users.apellidos) AS gestor')
    ->selectRaw('concat("Tecnoparque nodo ", entidades.nombre) AS nombre_nodo')
    ->selectRaw('IF(tipo_articulacion = ' . Articulacion::IsGrupo() . ', "Grupo de Investigación", IF(tipo_articulacion = ' . Articulacion::IsEmpresa() . ', "Empresa", "Emprendedor(es)") ) AS tipo_articulacion')
    ->selectRaw('IF(articulaciones.estado = ' . Articulacion::IsInicio() . ', "Inicio", IF(articulaciones.estado = ' . Articulacion::IsEjecucion() . ', "Ejecución", "Cierre")) AS estado')
    ->selectRaw('IF(revisado_final = ' . ArticulacionProyecto::IsPorEvaluar() . ', "Por Evaluar", IF(revisado_final = ' . ArticulacionProyecto::IsAprobado() . ', "Aprobado", "No Aprobado")) AS revisado_final')
    ->selectRaw('IF(acc = 1, "Si", "No") AS acc')
    ->selectRaw('IF(informe_final = 1, "Si", "No") AS informe_final')
    ->selectRaw('IF(pantallazo = 1, "Si", "No") AS pantallazo')
    ->selectRaw('IF(acta_inicio = 1, "Si", "No") AS acta_inicio')
    ->selectRaw('IF(actas_seguimiento = 1, "Si", "No") AS actas_seguimiento')
    ->selectRaw('IF(acta_cierre = 1, "Si", "No") AS acta_cierre')
    ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'articulaciones.articulacion_proyecto_id')
    ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
    ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
    ->join('users', 'users.id', '=', 'gestores.user_id')
    ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
    ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
    ->join('tiposarticulaciones', 'tiposarticulaciones.id', '=', 'articulaciones.tipoarticulacion_id')
    ->where('nodos.id', $id)
    ->whereYear('fecha_cierre', $anho)
    ->get();
  }

  /**
  * Consulta las articulaciones finalizadas entre fecha y linea tecnológica de un nodo
  *
  * @param int $id Id del nodo
  * @param int $idlinea Id de la línea tecnológica
  * @param string $fecha_inicio Primera fecha para realizar el filtro
  * @param string $fecha_cierre Segunda fecha para realizar el filtro
  * @return Collection
  * @author dum
  */
  public function consultarArticulacionesFinalizadasPorFechaNodoYLinea_Repository($id, $idlinea, $fecha_inicio, $fecha_cierre)
  {
    return Articulacion::select('actividades.codigo_actividad',
    'actividades.fecha_inicio',
    'actividades.fecha_cierre',
    'tiposarticulaciones.nombre AS nombre_tipoarticulacion',
    'articulaciones.observaciones',
    'actividades.nombre')
    ->selectRaw('concat(users.nombres, " ", users.apellidos) AS gestor')
    ->selectRaw('concat("Tecnoparque nodo ", entidades.nombre) AS nombre_nodo')
    ->selectRaw('IF(tipo_articulacion = ' . Articulacion::IsGrupo() . ', "Grupo de Investigación", IF(tipo_articulacion = ' . Articulacion::IsEmpresa() . ', "Empresa", "Emprendedor(es)") ) AS tipo_articulacion')
    ->selectRaw('IF(articulaciones.estado = ' . Articulacion::IsInicio() . ', "Inicio", IF(articulaciones.estado = ' . Articulacion::IsEjecucion() . ', "Ejecución", "Cierre")) AS estado')
    ->selectRaw('IF(revisado_final = ' . ArticulacionProyecto::IsPorEvaluar() . ', "Por Evaluar", IF(revisado_final = ' . ArticulacionProyecto::IsAprobado() . ', "Aprobado", "No Aprobado")) AS revisado_final')
    ->selectRaw('IF(acc = 1, "Si", "No") AS acc')
    ->selectRaw('IF(informe_final = 1, "Si", "No") AS informe_final')
    ->selectRaw('IF(pantallazo = 1, "Si", "No") AS pantallazo')
    ->selectRaw('IF(acta_inicio = 1, "Si", "No") AS acta_inicio')
    ->selectRaw('IF(actas_seguimiento = 1, "Si", "No") AS actas_seguimiento')
    ->selectRaw('IF(acta_cierre = 1, "Si", "No") AS acta_cierre')
    ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'articulaciones.articulacion_proyecto_id')
    ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
    ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
    ->join('users', 'users.id', '=', 'gestores.user_id')
    ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
    ->join('lineastecnologicas_nodos', 'lineastecnologicas_nodos.nodo_id', '=', 'nodos.id')
    ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'lineastecnologicas_nodos.linea_tecnologica_id')
    ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
    ->join('tiposarticulaciones', 'tiposarticulaciones.id', '=', 'articulaciones.tipoarticulacion_id')
    ->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_cierre])
    ->where('nodos.id', $id)
    ->where('lineastecnologicas.id', $idlinea)
    ->get();
  }

  /**
  * Consulta las articulaciones con entre fechas de cierre y nodo
  *
  * @param int $id Id del nodo
  * @param string $fecha_inicio Primera fecha para filtrar (con fecha de cierre)
  * @param string $fecha_cierre Segunda fecha para filtrar (con fecha de cierre)
  * @return Collection
  * @author dum
  */
  public function consultarArticulacionesFinalizadasPorFechaYNodo_Repository($id, $fecha_inicio, $fecha_cierre)
  {
    return Articulacion::select('actividades.codigo_actividad',
    'actividades.fecha_inicio',
    'actividades.fecha_cierre',
    'tiposarticulaciones.nombre AS nombre_tipoarticulacion',
    'articulaciones.observaciones',
    'actividades.nombre')
    ->selectRaw('concat(users.nombres, " ", users.apellidos) AS gestor')
    ->selectRaw('concat("Tecnoparque nodo ", entidades.nombre) AS nombre_nodo')
    ->selectRaw('IF(tipo_articulacion = ' . Articulacion::IsGrupo() . ', "Grupo de Investigación", IF(tipo_articulacion = ' . Articulacion::IsEmpresa() . ', "Empresa", "Emprendedor(es)") ) AS tipo_articulacion')
    ->selectRaw('IF(articulaciones.estado = ' . Articulacion::IsInicio() . ', "Inicio", IF(articulaciones.estado = ' . Articulacion::IsEjecucion() . ', "Ejecución", "Cierre")) AS estado')
    ->selectRaw('IF(revisado_final = ' . ArticulacionProyecto::IsPorEvaluar() . ', "Por Evaluar", IF(revisado_final = ' . ArticulacionProyecto::IsAprobado() . ', "Aprobado", "No Aprobado")) AS revisado_final')
    ->selectRaw('IF(acc = 1, "Si", "No") AS acc')
    ->selectRaw('IF(informe_final = 1, "Si", "No") AS informe_final')
    ->selectRaw('IF(pantallazo = 1, "Si", "No") AS pantallazo')
    ->selectRaw('IF(acta_inicio = 1, "Si", "No") AS acta_inicio')
    ->selectRaw('IF(actas_seguimiento = 1, "Si", "No") AS actas_seguimiento')
    ->selectRaw('IF(acta_cierre = 1, "Si", "No") AS acta_cierre')
    ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'articulaciones.articulacion_proyecto_id')
    ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
    ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
    ->join('users', 'users.id', '=', 'gestores.user_id')
    ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
    ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
    ->join('tiposarticulaciones', 'tiposarticulaciones.id', '=', 'articulaciones.tipoarticulacion_id')
    ->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_cierre])
    ->where('nodos.id', $id)
    ->get();
  }

  /**
  * Consulta las articulaciones con entre fechas de cierre y gestor
  *
  * @param int $id Id del gestor()
  * @param string $fecha_inicio Primera fecha para filtrar (con fecha de cierre)
  * @param string $fecha_cierre Segunda fecha para filtrar (con fecha de cierre)
  * @return Collection
  * @author dum
  */
  public function consultarArticulacionesFinalizadasPorGestorFecha_Repository($id, $fecha_inicio, $fecha_cierre)
  {
    return Articulacion::select('actividades.codigo_actividad',
    'actividades.fecha_inicio',
    'actividades.fecha_cierre',
    'tiposarticulaciones.nombre AS nombre_tipoarticulacion',
    'articulaciones.observaciones',
    'actividades.nombre')
    ->selectRaw('concat(users.nombres, " ", users.apellidos) AS gestor')
    ->selectRaw('concat("Tecnoparque nodo ", entidades.nombre) AS nombre_nodo')
    ->selectRaw('IF(tipo_articulacion = ' . Articulacion::IsGrupo() . ', "Grupo de Investigación", IF(tipo_articulacion = ' . Articulacion::IsEmpresa() . ', "Empresa", "Emprendedor(es)") ) AS tipo_articulacion')
    ->selectRaw('IF(articulaciones.estado = ' . Articulacion::IsInicio() . ', "Inicio", IF(articulaciones.estado = ' . Articulacion::IsEjecucion() . ', "Ejecución", "Cierre")) AS estado')
    ->selectRaw('IF(revisado_final = ' . ArticulacionProyecto::IsPorEvaluar() . ', "Por Evaluar", IF(revisado_final = ' . ArticulacionProyecto::IsAprobado() . ', "Aprobado", "No Aprobado")) AS revisado_final')
    ->selectRaw('IF(acc = 1, "Si", "No") AS acc')
    ->selectRaw('IF(informe_final = 1, "Si", "No") AS informe_final')
    ->selectRaw('IF(pantallazo = 1, "Si", "No") AS pantallazo')
    ->selectRaw('IF(acta_inicio = 1, "Si", "No") AS acta_inicio')
    ->selectRaw('IF(actas_seguimiento = 1, "Si", "No") AS actas_seguimiento')
    ->selectRaw('IF(acta_cierre = 1, "Si", "No") AS acta_cierre')
    ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'articulaciones.articulacion_proyecto_id')
    ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
    ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
    ->join('users', 'users.id', '=', 'gestores.user_id')
    ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
    ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
    ->join('tiposarticulaciones', 'tiposarticulaciones.id', '=', 'articulaciones.tipoarticulacion_id')
    ->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_cierre])
    ->where('gestores.id', $id)
    ->get();
  }

  /**
  * Consulta la cantidad de articulacion de un nodo, según el tipo de articulacion y el año
  * @param int $id Id del nodo
  * @param string $anho Año por el que se consultaran la cantidad de articulaciones
  * @param int $i Tipo de articulacion
  * @return Collection
  * @author dum
  */
  public function consultarCantidadDeArticulacionesPorTipoYNodoYAnho($id, $anho, $i)
  {
    return Articulacion::select('articulaciones.tipo_articulacion')
    ->selectRaw('count(articulaciones.id) AS cantidad')
    ->join('articulacion_proyecto', 'articulaciones.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
    ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
    ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
    ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
    ->where('nodos.id', $id)
    ->where('tipo_articulacion', $i)
    ->whereYear('fecha_cierre', $anho)
    ->groupBy('nodos.id', 'articulaciones.tipo_articulacion')
    ->get()
    ->last();
  }

  /**
  * Consulta la cantidad de tipos de articulacion por la línea tecnológica de un nodo
  * @param int $idnodo Id del nodo
  * @param int $idlinea Id de la línea tecnolóigica
  * @param int $tipo_articulacion Tipo de articulación
  * @param string $fecha_inicio
  * @param string $fecha_fin
  * @return Collection
  * @author dum
  */
  public function consultarCantidadDeArticulacionesPorLineaTecnologicaYFecha_Repository($idnodo, $idlinea, $tipo_articulacion, $fecha_inicio, $fecha_fin)
  {
    return Articulacion::select('articulaciones.tipo_articulacion')
    ->selectRaw('count(articulaciones.id) AS cantidad')
    ->join('articulacion_proyecto', 'articulaciones.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
    ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
    ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
    ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'gestores.lineatecnologica_id')
    ->join('lineastecnologicas_nodos', 'lineastecnologicas_nodos.linea_tecnologica_id', '=', 'lineastecnologicas.id')
    ->join('nodos', 'nodos.id', '=', 'lineastecnologicas_nodos.nodo_id')
    ->where('nodos.id', $idnodo)
    ->where('lineastecnologicas.id', $idlinea)
    ->where('tipo_articulacion', $tipo_articulacion)
    ->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin])
    ->groupBy('lineastecnologicas.id', 'articulaciones.tipo_articulacion', 'nodos.id')
    ->get()
    ->last();
  }

  /**
  * Consulta las cantidad de tipos de articulación por gestor
  * @param int $idgestor Id del gestor
  * @param int $tipo_articulacion Tipo de Articulacion (grupos, empresas, emprendedores)
  * @param string $fecha_inicio
  * @param string $fecha_fin
  * @return Collection
  */
  public function consultarCantidadDeArticulacionesPorTipoDeArticulacionYGestor($idgestor, $tipo_articulacion, $fecha_inicio, $fecha_fin)
  {
    return Articulacion::select('articulaciones.tipo_articulacion')
    ->selectRaw('concat(users.nombres, " ", users.apellidos) AS gestor')
    ->selectRaw('count(articulaciones.id) AS cantidad')
    ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'articulaciones.articulacion_proyecto_id')
    ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
    ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
    ->join('users', 'users.id', '=', 'gestores.user_id')
    ->where('gestores.id', $idgestor)
    ->where('tipo_articulacion', $tipo_articulacion)
    ->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin])
    ->groupBy('gestores.id', 'articulaciones.tipo_articulacion')
    ->get()
    ->last();
  }

  /**
  * Consulta los tipos de articulacion que tienen los gestores de un nodo
  * @param int $id Id del nodo
  * @return Collection
  */
  public function tiposArticulacionesPorGestorNodo($id)
  {
    return Articulacion::select('articulaciones.tipo_articulacion')
    ->selectRaw('concat(users.nombres, " ", users.apellidos) AS gestor')
    ->selectRaw('count(articulaciones.id) AS cantidad')
    ->join('articulacion_proyecto', 'articulacion_proyecto.id', 'articulaciones.articulacion_proyecto_id')
    ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
    ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
    ->join('users', 'users.id', '=', 'gestores.user_id')
    ->join('nodos', 'nodos.id', '=', 'gestores.nodo_id')
    ->where('gestores.id', $id)
    ->groupBy('gestores.id', 'articulaciones.tipo_articulacion')
    ->get();
  }

  /**
  * Modifica el revisado final de una articulación
  * @param Request $request
  * @param int $id Id de la articulación
  * @return boolean
  * @author dum
  */
  public function updateRevisadoFinalArticulacion($request, $id)
  {
    DB::beginTransaction();
    try {
      $articulacion = Articulacion::find($id);
      $articulacion->articulacion_proyecto()->update([
      'revisado_final' => $request['txtrevisado_final'],
      ]);
      DB::commit();
      return true;
    } catch (\Exception $e) {
      DB::rollback();
      return false;
    }
  }

  /**
  * Consulta las articulaciones de un nodo
  * @param int $id Id del nodo
  * @param string $anho Año para filtrar las articulaciones del nodo
  * @return Collection
  * @author dum
  */
  public function consultarArticulacionesDeUnNodo($id, $anho)
  {
    return Articulacion::select('codigo_actividad AS codigo_articulacion',
    'actividades.nombre',
    'articulaciones.id',
    'observaciones',
    'fecha_inicio',
    'fecha_cierre',
    'tiposarticulaciones.nombre AS tipoarticulacion')
    ->selectRaw('IF(tipo_articulacion = ' . Articulacion::IsGrupo() . ', "Grupo de Investigación", IF(tipo_articulacion = ' . Articulacion::IsEmpresa() . ', "Empresa", "Emprendedor(es)") ) AS tipo_articulacion')
    ->selectRaw('IF(articulaciones.estado = ' . Articulacion::IsInicio() . ', "Inicio", IF(articulaciones.estado = ' . Articulacion::IsEjecucion() . ', "Ejecución", "Cierre") ) AS estado')
    ->selectRaw('IF(revisado_final = ' . ArticulacionProyecto::IsPorEvaluar() . ', "Por Evaluar", IF(revisado_final = ' . ArticulacionProyecto::IsAprobado() . ', "Aprobado", "No Aprobado") ) AS revisado_final')
    ->selectRaw('CONCAT(users.documento, " - ", users.nombres, " ", users.apellidos) AS nombre_completo_gestor')
    // ->selectRaw('IF(articulaciones.estado = ' . Articulacion::IsCierre() . ', fecha_cierre, "La Articulación aún no se ha cerrado") AS fecha_cierre')
    ->selectRaw('IF(acta_inicio = 1, "Si", "No") AS acta_inicio')
    ->selectRaw('IF(tipo_articulacion = "Grupo de Investigación", IF(acc = 1, "Si", "No"), "No Aplica") AS acc')
    ->selectRaw('IF(actas_seguimiento = 1, "Si", "No") AS actas_seguimiento')
    ->selectRaw('IF(acta_cierre = 1, "Si", "No") AS acta_cierre')
    ->selectRaw('IF(tipo_articulacion != "Grupo de Investigación", IF(informe_final = 1, "Si", "No"), "No Aplica") AS informe_final')
    ->selectRaw('IF(tipo_articulacion != "Grupo de Investigación", IF(pantallazo = 1, "Si", "No"), "No Aplica") AS pantallazo')
    ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'articulaciones.articulacion_proyecto_id')
    ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
    ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
    ->join('nodos', 'nodos.id', '=', 'gestores.nodo_id')
    ->join('tiposarticulaciones', 'tiposarticulaciones.id', '=', 'articulaciones.tipoarticulacion_id')
    ->join('users', 'users.id', '=', 'gestores.user_id')
    ->where('nodos.id', $id)
    ->where('tipo_articulacion', '!=', Articulacion::IsEmpresa())
    ->where(function($q) use ($anho) {
      $q->where(function($query) use ($anho) {
        $query->whereYear('fecha_inicio', '=', $anho);
      })
      ->orWhere(function($query) use ($anho) {
        $query->whereYear('fecha_cierre', '=', $anho);
      });
    })
    ->get();
  }

  /**
  * Consulta los entregables de las articulaciones
  * @param int $id Id de la articulación
  * @return Collection
  * @author dum
  */
  public function consultaEntregablesDeUnaArticulacion($id)
  {
    return Articulacion::select(
    'acta_inicio',
    'acc',
    'actas_seguimiento',
    'acta_cierre',
    'informe_final',
    'pantallazo',
    'otros'
    )
    ->where('articulaciones.id', $id)
    ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'articulaciones.articulacion_proyecto_id')
    ->get();
  }

  /**
  * Modifica los datos de una articulación
  * @param Request $request
  * @param int $id Id de la articulación
  * @return boolean
  * @author dum
  */
  public function update($request, $id)
  {
    DB::beginTransaction();
    try {

      $articulacionConsultaId = Articulacion::find($id);

      if (request()->txtestado == Articulacion::IsCierre()) {
        $fechaCierre = request()->txtfecha_cierre;
      } else {
        $fechaCierre = null;
      }

      if (request()->group1 == Articulacion::IsGrupo()) {
        request()->entidad_id = Entidad::select('entidades.id')
        ->join('gruposinvestigacion', 'gruposinvestigacion.entidad_id', '=', 'entidades.id')
        ->where('gruposinvestigacion.id', request()->txtgrupo_id)->get()->last()->id;
      }

      if (request()->group1 == Articulacion::IsEmpresa()) {
        request()->entidad_id = Entidad::select('entidades.id')
        ->join('empresas', 'empresas.entidad_id', '=', 'entidades.id')
        ->where('empresas.id', request()->txtempresa_id)->get()->last()->id;
      }

      if (request()->group1 == Articulacion::IsEmprendedor()) {
        request()->entidad_id = Entidad::all()->where('nombre', 'No Aplica')->last()->id;
      }

      if (request()->txtestado == Articulacion::IsEjecucion()) {
        if ($articulacionConsultaId->estado == Articulacion::IsEjecucion()) {
          $fechaEjecucion = $articulacionConsultaId->fecha_ejecucion;
        } else {
          $fechaEjecucion = Carbon::now()->toDateString();
        }
      } else {
        $fechaEjecucion = null;
      }

      if ($articulacionConsultaId->tipo_articulacion == Articulacion::IsEmprendedor()) {
        // Método detach para eliminar los datos de la tabla articulacion_talento (pivot entre talentos y articulaciones)
        $articulacionConsultaId->articulacion_proyecto->talentos()->detach();
      }
      $articulacionConsultaId->update([
      'tipoarticulacion_id' => request()->txttipoarticulacion_id,
      'tipo_articulacion'   => request()->group1,
      'fecha_ejecucion'     => $fechaEjecucion,
      'observaciones'       => request()->txtobservaciones,
      'estado'              => request()->txtestado,
      ]);

      $articulacionConsultaId->articulacion_proyecto()->update([
      'entidad_id' => request()->entidad_id,
      ]);

      $articulacionConsultaId->articulacion_proyecto->actividad()->update([
      'nombre'       => request()->txtnombre,
      'fecha_inicio' => request()->txtfecha_inicio,
      'fecha_cierre' => $fechaCierre,
      ]);

      $articulacionConsultaId->emprendedores()->delete();
      // Registrar los emprendedores
      if (request()->group1 == Articulacion::IsEmprendedor()) {
        $syncData = array();
        foreach ($request->get('documento') as $id => $value) {
          $syncData[$id] = array('documento' => $value, 'nombres' => $request->get('nombres')[$id], 'email' => $request->get('email')[$id], 'contacto' => $request->get('contacto')[$id]);
        }
        $articulacionConsultaId->emprendedores()->createMany($syncData);
      }

      DB::commit();
      return true;
    } catch (Exception $e) {
      DB::rollback();
      return false;
    }
  }

  /**
  * Modifica los entregables de un articulación
  * @param Request $request
  * @param int $id Id de la articulación
  * @return boolean
  * @author dum
  */
  public function updateEntregablesArticulacion($request, $id)
  {
    DB::beginTransaction();
    try {
      $articulacion = Articulacion::findOrFail($id);
      $articulacion->update([
      "acc" => $request['entregable_acuerdo_confidencialidad_compromiso'],
      "informe_final" => $request['entregable_informe_final'],
      "pantallazo" => $request['entregable_encuesta_satisfaccion'],
      // "otros" => $request['entregable_otros']
      ]);

      $articulacion->articulacion_proyecto()->update([
      "acta_inicio" => $request['entregable_acta_inicio'],
      "actas_seguimiento" => $request['entregable_acta_seguimiento'],
      "acta_cierre" => $request['entregable_acta_cierre'],
      ]);

      DB::commit();
      return true;

    } catch (\Exception $e) {

      DB::rollback();
      return false;
    }

  }

  /**
  * Consulta información de una articulacio por id
  * @param int $id Id de la articulació
  * @return Collection
  * @author dum
  */
  public function consultarArticulacionPorId($id)
  {
    return Articulacion::select(
    'codigo_actividad AS codigo_articulacion',
    'actividades.nombre',
    'revisado_final',
    'observaciones',
    'articulaciones.id',
    'fecha_inicio',
    'fecha_cierre',
    'acta_inicio',
    'acc',
    'actas_seguimiento',
    'acta_cierre',
    'informe_final',
    'pantallazo',
    'otros',
    'tiposarticulaciones.nombre AS tipoArticulacion'
    )
    ->selectRaw('IF(tipo_articulacion = ' . Articulacion::IsGrupo() . ', "Grupo de Investigación", IF(tipo_articulacion = ' . Articulacion::IsEmpresa() . ', "Empresa",
    "Emprendedor") ) AS tipo_articulacion')
    ->selectRaw('IF(articulaciones.estado = ' . Articulacion::IsInicio() . ', "Inicio", IF(articulaciones.estado = ' . Articulacion::IsEjecucion() . ', "Ejecución", "Cierre") ) AS estado')
    ->selectRaw('IF(revisado_final = ' . ArticulacionProyecto::IsPorEvaluar() . ', "Por Evaluar", IF(revisado_final = ' . ArticulacionProyecto::IsAprobado() . ', "Aprobado",
    "No Aprobado") ) AS revisado_final')
    ->selectRaw('CONCAT(users.nombres, " ", users.apellidos) AS gestor')
    ->join('tiposarticulaciones', 'tiposarticulaciones.id', '=', 'articulaciones.tipoarticulacion_id')
    ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'articulaciones.articulacion_proyecto_id')
    ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
    ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
    ->join('users', 'users.id', '=', 'gestores.user_id')
    ->where('articulaciones.id', $id)
    ->get();
  }

  /**
  * Consulta las articulaciones de un gestor
  * @param int $id Id del gestor
  * @param string $anho Año para realizar el filtro
  * @return Collection
  * @author dum
  */
  public function consultarArticulacionesDeUnGestor($id, $anho)
  {
    return Articulacion::select('codigo_actividad AS codigo_articulacion',
    'actividades.nombre',
    'articulaciones.id',
    'observaciones',
    'fecha_inicio',
    'fecha_cierre',
    'tiposarticulaciones.nombre AS tipoarticulacion')
    ->selectRaw('IF(tipo_articulacion = ' . Articulacion::IsEmpresa() . ', "Empresa", "Emprendedor(es)") AS tipo_articulacion')
    ->selectRaw('IF(articulaciones.estado = ' . Articulacion::IsInicio() . ', "Inicio", IF(articulaciones.estado = ' . Articulacion::IsEjecucion() . ', "Ejecución", "Cierre") ) AS estado')
    ->selectRaw('IF(revisado_final = ' . ArticulacionProyecto::IsPorEvaluar() . ', "Por Evaluar", IF(revisado_final = ' . ArticulacionProyecto::IsAprobado() . ', "Aprobado", "No Aprobado") ) AS revisado_final')
    ->selectRaw('CONCAT(users.documento, " - ", users.nombres, " ", users.apellidos) AS nombre_completo_gestor')
    ->selectRaw('IF(acta_inicio = 1, "Si", "No") AS acta_inicio')
    ->selectRaw('IF(actas_seguimiento = 1, "Si", "No") AS actas_seguimiento')
    ->selectRaw('IF(tipo_articulacion = "Grupo de Investigación", IF(acc = 1, "Si", "No"), "No Aplica") AS acc')
    ->selectRaw('IF(acta_cierre = 1, "Si", "No") AS acta_cierre')
    ->selectRaw('IF(tipo_articulacion != "Grupo de Investigación", IF(informe_final = 1, "Si", "No"), "No Aplica") AS informe_final')
    ->selectRaw('IF(tipo_articulacion != "Grupo de Investigación", IF(pantallazo = 1, "Si", "No"), "No Aplica") AS pantallazo')
    ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'articulaciones.articulacion_proyecto_id')
    ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
    ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
    ->join('tiposarticulaciones', 'tiposarticulaciones.id', '=', 'articulaciones.tipoarticulacion_id')
    ->join('users', 'users.id', '=', 'gestores.user_id')
    ->where('actividades.gestor_id', $id)
    ->where('articulaciones.tipoarticulacion_id', '!=', Articulacion::IsEmpresa())
    ->whereYear('actividades.fecha_inicio', $anho)
    ->get();
  }

  public function consultarIntervencionesEmpresasDeUnGestor($id, $anho)
  {
    return Articulacion::select('codigo_actividad AS codigo_articulacion',
    'actividades.nombre',
    'articulaciones.id',
    'observaciones',
    'fecha_inicio',
    'fecha_cierre',
    'tiposarticulaciones.nombre AS tipoarticulacion')
    ->selectRaw('IF(tipo_articulacion = ' . Articulacion::IsEmpresa() . ', "Empresa", "Emprendedor(es)") AS tipo_articulacion')
    ->selectRaw('IF(articulaciones.estado = ' . Articulacion::IsInicio() . ', "Inicio", IF(articulaciones.estado = ' . Articulacion::IsEjecucion() . ', "Ejecución", "Cierre") ) AS estado')
    ->selectRaw('IF(revisado_final = ' . ArticulacionProyecto::IsPorEvaluar() . ', "Por Evaluar", IF(revisado_final = ' . ArticulacionProyecto::IsAprobado() . ', "Aprobado", "No Aprobado") ) AS revisado_final')
    ->selectRaw('CONCAT(users.documento, " - ", users.nombres, " ", users.apellidos) AS nombre_completo_gestor')
    // ->selectRaw('IF(articulaciones.estado = ' . Articulacion::IsCierre() . ', fecha_cierre, "La Articulación aún no se ha cerrado") AS fecha_cierre')
    ->selectRaw('IF(acta_inicio = 1, "Si", "No") AS acta_inicio')
    ->selectRaw('IF(actas_seguimiento = 1, "Si", "No") AS actas_seguimiento')
    ->selectRaw('IF(tipo_articulacion = "Grupo de Investigación", IF(acc = 1, "Si", "No"), "No Aplica") AS acc')
    ->selectRaw('IF(acta_cierre = 1, "Si", "No") AS acta_cierre')
    ->selectRaw('IF(tipo_articulacion != "Grupo de Investigación", IF(informe_final = 1, "Si", "No"), "No Aplica") AS informe_final')
    ->selectRaw('IF(tipo_articulacion != "Grupo de Investigación", IF(pantallazo = 1, "Si", "No"), "No Aplica") AS pantallazo')
    ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'articulaciones.articulacion_proyecto_id')
    ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
    ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
    ->join('tiposarticulaciones', 'tiposarticulaciones.id', '=', 'articulaciones.tipoarticulacion_id')
    ->join('users', 'users.id', '=', 'gestores.user_id')
    ->where('actividades.gestor_id', $id)
    ->where('articulaciones.tipoarticulacion_id', '!=', Articulacion::IsEmpresa())
    ->whereYear('actividades.fecha_inicio', $anho)
    ->get();
  }

  /**
  * Registra un nueva articulación en la base de datos
  * @param Request $request
  * @return boolean
  * @author dum
  */
  public function create($request)
  {
    
    DB::beginTransaction();
    try {
      $anho = Carbon::now()->isoFormat('YYYY');
      $tecnoparque = sprintf("%02d", auth()->user()->gestor->nodo_id);
      $linea = auth()->user()->gestor->lineatecnologica_id;
      $gestor = sprintf("%03d", auth()->user()->gestor->id);
      $idArticulacion = Articulacion::selectRaw('MAX(id+1) AS max')->get()->last();
      $idArticulacion->max == null ? $idArticulacion->max = 1 : $idArticulacion->max = $idArticulacion->max;
      $idArticulacion->max = sprintf("%04d", $idArticulacion->max);
      $fechaEjecucion =$request->txtfecha_inicio;
      
      if (request()->group1 == Articulacion::IsGrupo()) {
        $codigo = 'A' . $anho . '-' . $tecnoparque . $linea . $gestor . '-' . $idArticulacion->max;
       $request->entidad_id = Entidad::select('entidades.id')
        ->join('gruposinvestigacion', 'gruposinvestigacion.entidad_id', '=', 'entidades.id')
        ->where('gruposinvestigacion.id',$request->txtgrupo_id)->get()->last()->id;
      }

      if (request()->group1 == Articulacion::IsEmpresa()) {
        $codigo = 'INT' . $anho . '-' . $tecnoparque . $linea . $gestor . '-' . $idArticulacion->max;
       $request->entidad_id = Entidad::select('entidades.id')
        ->join('empresas', 'empresas.entidad_id', '=', 'entidades.id')
        ->where('empresas.id',$request->txtempresa_id)->get()->last()->id;
      }

      if (request()->group1 == Articulacion::IsEmprendedor()) {
        $codigo = 'A' . $anho . '-' . $tecnoparque . $linea . $gestor . '-' . $idArticulacion->max;
       $request->entidad_id = Entidad::all()->where('nombre', 'No Aplica')->last()->id;
      }

      if (request()->txtestado == Articulacion::IsEjecucion()) {
        $fechaEjecucion = Carbon::now()->toDateString();
      }

      $actividad = Actividad::create([
      'gestor_id' => auth()->user()->gestor->id,
      'nodo_id' => auth()->user()->gestor->nodo_id,
      'codigo_actividad' => $codigo,
      'nombre' =>$request->txtnombre,
      'fecha_inicio' =>$request->txtfecha_inicio,
      ]);

      $articulacion_proyecto = ArticulacionProyecto::create([
      'entidad_id'   =>$request->entidad_id,
      'actividad_id' => $actividad->id,
      ]);

      $articulacion = Articulacion::create([
      'articulacion_proyecto_id' => $articulacion_proyecto->id,
      'tipoarticulacion_id' =>$request->txttipoarticulacion_id,
      'tipo_articulacion' =>$request->group1,
      'fecha_ejecucion' => $fechaEjecucion,
      'observaciones' =>$request->txtobservaciones,
      'estado' => $request->txtestado,
      ]);

      // Registrar los emprendedores
      if ($request->group1 == Articulacion::IsEmprendedor()) {
        $syncData = array();
        foreach ($request->get('documento') as $id => $value) {
          $syncData[$id] = array('documento' => $value, 'nombres' => $request->get('nombres')[$id], 'email' => $request->get('email')[$id], 'contacto' => $request->get('contacto')[$id]);
        }
        $articulacion->emprendedores()->createMany($syncData);
      }

      DB::commit();
      return true;
    } catch (Exception $e) {
      DB::rollback();
      return false;
    }

  }

  /**
  * retorna query con las articulaciones en fase Inicio, En ejecución por usuarios
  * @return collection
  * @author devjul
  */
  public function getArticulacionesForUser(array $relations)
  {
    return Articulacion::articulacionesWithRelations($relations);
  }

}
