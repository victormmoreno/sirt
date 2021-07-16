<?php

namespace App\Repositories\Repository;

use App\Models\{Actividad, Articulacion, ArticulacionProyecto, Entidad, ArchivoArticulacionProyecto, UsoInfraestructura, Fase, Movimiento, Role};
use App\Repositories\Repository\UserRepository\DinamizadorRepository;
use App\Notifications\Articulacion\{ArticulacionAprobarInicio, ArticulacionAprobarPlaneacion, ArticulacionAprobarEjecucion, ArticulacionAprobarCierre, ArticulacionCierreAprobado, ArticulacionAprobarSuspendido, ArticulacionSuspendidoAprobado};
use Illuminate\Support\Facades\{DB, Notification, Session};
use Carbon\Carbon;
use App\User;

class ArticulacionRepository
{

  /**
   * Modifica los entregables de una articulación
   * @param Request $request
   * @param int $id Id del articulación
   * @return boolean
   * @author dum
   */
  public function updateEntregablesInicioArticulacionRepository($request, $id)
  {
    DB::beginTransaction();
    try {
      $acc = 1;
      $formulario_inicio = 1;

      if (!isset($request->txtacc)) {
        $acc = 0;
      }

      if (!isset($request->txtformulario_inicio)) {
        $formulario_inicio = 0;
      }

      $articulacion = Articulacion::find($id);

      $articulacion->update([
        'acc' => $acc
      ]);

      $articulacion->articulacion_proyecto->actividad()->update([
        'formulario_inicio' => $formulario_inicio
      ]);

      DB::commit();
      return true;
    } catch (\Exception $e) {
      DB::rollback();
      return false;
    }
  }

    /**
   * Modifica los entregables de la fase de cierre
   * 
   * @param Request $request
   * @param int $id Id del proyecto
   * @return boolean
   * @author dum
   */
  public function updateEntregableCierreArticulacionRepository($request, $id)
  {
    DB::beginTransaction();
    try {
      $informe_final = 1;
      $formulario_final = 1;
      $articulacion = Articulacion::findOrFail($id);
  
      if (!isset($request->txtinforme_final)) {
        $informe_final = 0;
      }
  
      if (!isset($request->txtformulario_final)) {
        $formulario_final = 0;
      }
  
      
      $articulacion->update([
        'informe_final' => $informe_final
      ]);
  
      $articulacion->articulacion_proyecto->actividad()->update([
        'formulario_final' => $formulario_final
      ]);
      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollback();
      return false;
    }
  }

    /**
   * Modifica los entregables de la fase de planeación de un proyecto
   * @param int $id Id del proyecto
   * @author dum
   * @return boolean
   * @author dum
   */
  public function updateEntregablesPlaneacionArticulacionRepository($request, $id)
  {
    DB::beginTransaction();
    try {

      $cronograma = 1;

      if (!isset($request->txtcronograma)) {
        $cronograma = 0;
      }


      $articulacion = Articulacion::findOrFail($id);

      $articulacion->articulacion_proyecto->actividad()->update([
        'cronograma' => $cronograma
      ]);

      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollback();
      return false;
    }
  }

    /**
   * Modifica los entregables de un proyecto en la fase de ejecución
   * 
   * @param Request $request
   * @param int $id Id de proyecto
   * @return boolean
   * @author dum
   */
  public function updateEntregablesEjecucionArticulacionRepository($request, $id)
  {
    DB::beginTransaction();
    try {
      $articulacion = Articulacion::findOrFail($id);
      $seguimiento = 1;

      if (!isset($request->txtseguimiento)) {
        $seguimiento = 0;
      }
      $articulacion->articulacion_proyecto->actividad()->update([
        'seguimiento' => $seguimiento
      ]);
      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollback();
      return false;
    }
  }

   /**
   * Modifica los datos de cierre de una articulación
   * 
   * @param Request $request
   * @param int $id Id de la articulación
   * @return boolean
   * @author dum
   */
  public function updateCierreArticulacionRepository($request, $id)
  {
    
    DB::beginTransaction();
    try {
      
      $articulacion = Articulacion::findOrFail($id);
      $productos_alcanzados = $request->txtproducto_alcanzado;
  
      DB::table('articulaciones_productos')->where('articulacion_id', $articulacion->id)->update(['logrado' => 0]);
  
      DB::table('articulaciones_productos')->where('articulacion_id', $articulacion->id)
      ->whereIn('producto_id', $productos_alcanzados)->update(['logrado' => 1]);

      $articulacion->update([
        'siguientes_investigaciones' => $request->txtsiguientes_investigaciones
      ]);

      $articulacion->articulacion_proyecto->actividad()->update([
        'conclusiones' => $request->txtconclusiones
      ]);

      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollback();
      return false;
    }
  }

    /**
   * Cambia el estado de la articulación a Cierre y asigna un fecha de cierre a la articulación
   * @param Request $request
   * @param Articulacion $articulacion
   * @return boolean
   * @author dum
   */
  public function cerrarArticulacion($request, $articulacion)
  {
    
    DB::beginTransaction();
    try {
      
      $articulacion->articulacion_proyecto->actividad->movimientos()->attach(Movimiento::where('movimiento', 'Cerró')->first(), [
        'actividad_id' => $articulacion->articulacion_proyecto->actividad->id,
        'user_id' => auth()->user()->id,
        'fase_id' => Fase::where('nombre', 'Finalizado')->first()->id,
        'role_id' => Role::where('name', Session::get('login_role'))->first()->id
      ]);

      $articulacion->update([
        'fase_id' => Fase::where('nombre', 'Cierre')->first()->id
      ]);

      $articulacion->articulacion_proyecto->actividad()->update([
        'fecha_cierre' => $request->txtfecha_cierre
      ]);
      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollback();
      return false;
    }
  }

  /**
   * Cambia el estado de aprobacion_dinamizador, para permitirle al experto cerrar la artriculación
   */
  public function updateAprobacionDinamizador(int $id)
  {
    DB::beginTransaction();
    try {
      $articulacion = Articulacion::findOrFail($id);

      $articulacion->articulacion_proyecto->actividad->movimientos()->attach(Movimiento::where('movimiento', 'Aprobó')->first(), [
        'actividad_id' => $articulacion->articulacion_proyecto->actividad->id,
        'user_id' => auth()->user()->id,
        'fase_id' => Fase::where('nombre', 'Cierre')->first()->id,
        'role_id' => Role::where('name', Session::get('login_role'))->first()->id
      ]);

      Notification::send(User::find($articulacion->articulacion_proyecto->actividad->gestor->user->id), new ArticulacionCierreAprobado($articulacion));
      $articulacion->articulacion_proyecto->actividad()->update([
        'aprobacion_dinamizador' => 1
      ]);
      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollback();
      return false;
    }
  }


  public function setPostCierreArticulacionRepository(int $id)
  {
    DB::beginTransaction();
    try {
      $articulacion = Articulacion::findOrFail($id);
      
      $articulacion->articulacion_proyecto->actividad->movimientos()->attach(Movimiento::where('movimiento', 'Aprobó')->first(), [
        'actividad_id' => $articulacion->articulacion_proyecto->actividad->id,
        'user_id' => auth()->user()->id,
        'fase_id' => Fase::where('nombre', 'Ejecución')->first()->id,
        'role_id' => Role::where('name', Session::get('login_role'))->first()->id
      ]);

      $articulacion->articulacion_proyecto()->update([
        'aprobacion_dinamizador_ejecucion' => 1
      ]);
      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollback();
      return false;
    }
  }

    /**
   * Notifica al dinamizador para que apruebe la articulacion en la fase de inicio
   * 
   * @param int $id Id del proyecto
   * @return boolean
   * @author dum
   */
  public function notificarAlDinamziador_Inicio(int $id)
  {
    DB::beginTransaction();
    try {
      $dinamizadorRepository = new DinamizadorRepository;
      $articulacion = Articulacion::findOrFail($id);
      $dinamizadores = $dinamizadorRepository->getAllDinamizadoresPorNodo($articulacion->articulacion_proyecto->actividad->nodo_id)->get();
      Notification::send($dinamizadores, new ArticulacionAprobarInicio($articulacion));
      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollBack();
      return false;
    }
  }

    /**
   * Notifica al talento interlocutor para que apruebe la fase de planeación
   * 
   * @param int $id Id del proyecto
   * @return boolean
   * @author dum
   */
  public function notificarAlDinamizador_Planeacion(int $id)
  {
    DB::beginTransaction();
    try {
      $dinamizadorRepository = new DinamizadorRepository;
      $articulacion = Articulacion::findOrFail($id);
      $dinamizadores = $dinamizadorRepository->getAllDinamizadoresPorNodo($articulacion->articulacion_proyecto->actividad->nodo_id)->get();
      Notification::send($dinamizadores, new ArticulacionAprobarPlaneacion($articulacion));
      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollBack();
      return false;
    }
  }

  public function notificarAlDinamizador_Ejecucion(int $id)
  {
    DB::beginTransaction();
    try {
      $dinamizadorRepository = new DinamizadorRepository;
      $articulacion = Articulacion::findOrFail($id);
      $dinamizadores = $dinamizadorRepository->getAllDinamizadoresPorNodo($articulacion->articulacion_proyecto->actividad->nodo_id)->get();
      Notification::send($dinamizadores, new ArticulacionAprobarEjecucion($articulacion));
      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollBack();
      return false;
    }
  }

  /**
   * Notifica al dinamizador para que apruebe el proyecto en la fase de cierre
   * 
   * @param int $id Id del proyecto
   * @return boolean
   * @author dum
   */
  public function notificarAlDinamziador_Cierre(int $id)
  {
    DB::beginTransaction();
    try {
      $dinamizadorRepository = new DinamizadorRepository;
      $articulacion = Articulacion::findOrFail($id);
      $dinamizadores = $dinamizadorRepository->getAllDinamizadoresPorNodo($articulacion->articulacion_proyecto->actividad->nodo_id)->get();
      Notification::send($dinamizadores, new ArticulacionAprobarCierre($articulacion));
      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollBack();
      return false;
    }
  }

    /**
   * Notifica al dinamizador para que apruebe la articulación en la fase de suspendido
   * 
   * @param int $id Id de la articulación
   * @return boolean
   * @author dum
   */
  public function notificarAlDinamziador_Suspendido(int $id)
  {
    DB::beginTransaction();
    try {
      $dinamizadorRepository = new DinamizadorRepository;
      $articulacion = Articulacion::findOrFail($id);
      $dinamizadores = $dinamizadorRepository->getAllDinamizadoresPorNodo($articulacion->articulacion_proyecto->actividad->nodo_id)->get();
      Notification::send($dinamizadores, new ArticulacionAprobarSuspendido($articulacion));
      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollBack();
      return false;
    }
  }

    /** 
   * Cambia una articulación de fase
   * 
   * @param int $id Id del articulacion
   * @param string $fase nombre de la fase a la que se va a cambiar el articulacion
   * @return boolean
   * @author dum
   */
  public function updateFaseArticulacion($id, $fase)
  {
    DB::beginTransaction();
    try {
      
      $articulacion = Articulacion::findOrFail($id);

      $fase_aprobada = -1;
      if ($fase == 'Planeación') {
        $fase_aprobada = Fase::where('nombre', 'Inicio')->first()->id;
      } else {
        $fase_aprobada = Fase::where('nombre', 'Planeación')->first()->id;
      }
      
      $articulacion->articulacion_proyecto->actividad->movimientos()->attach(Movimiento::where('movimiento', 'Aprobó')->first(), [
        'actividad_id' => $articulacion->articulacion_proyecto->actividad->id,
        'user_id' => auth()->user()->id,
        'fase_id' => $fase_aprobada,
        'role_id' => Role::where('name', Session::get('login_role'))->first()->id
      ]);

      $articulacion->update([
        'fase_id' => Fase::where('nombre', $fase)->first()->id
      ]);

      DB::commit();
      return true;
    } catch (\Exception $e) {
      DB::rollback();
      return false;
    }
  }

    /**
   * Reversa la fase de una articulación a Inicio
   *
   * @param int $id Id de la articulación
   * @return boolean
   * @author dum
   **/
  public function reversarArticulacion(int $id)
  {
    DB::beginTransaction();
    try {

      $articulacion = Articulacion::findOrFail($id);

      $articulacion->articulacion_proyecto->actividad->movimientos()->attach(Movimiento::where('movimiento', 'Reversó')->first(), [
        'actividad_id' => $articulacion->articulacion_proyecto->actividad->id,
        'user_id' => auth()->user()->id,
        'fase_id' => $articulacion->fase_id,
        'role_id' => Role::where('name', Session::get('login_role'))->first()->id
      ]);

      $articulacion->update([
        'fase_id' => Fase::where('nombre', 'Inicio')->first()->id
      ]);

      $articulacion->articulacion_proyecto()->update([
        'aprobacion_dinamizador_ejecucion' => 0,
        'aprobacion_dinamizador_suspender' => 0
      ]);

      $articulacion->articulacion_proyecto->actividad()->update([
        'aprobacion_dinamizador' => 0
      ]);

      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollBack();
      return false;
    }
  }


    /**
   * Cambia el experto de un proyecto
   *
   * @param Request $request
   * @param int $id id del proyecto
   * @return boolean
   * @author dum
   **/
  public function updateGestor($request, $id)
  {
    DB::beginTransaction();
    try {
      $articulacion = Articulacion::findOrFail($id);

      if ($articulacion->articulacion_proyecto->actividad->gestor_id != $request->txtgestor_id) {
        $articulacion->articulacion_proyecto->actividad->movimientos()->attach(Movimiento::where('movimiento', 'Cambió')->first(), [
          'actividad_id' => $articulacion->articulacion_proyecto->actividad->id,
          'user_id' => auth()->user()->id,
          'fase_id' => $articulacion->fase_id,
          'role_id' => Role::where('name', Session::get('login_role'))->first()->id
        ]);
      }


      $articulacion->articulacion_proyecto->actividad()->update([
        'gestor_id' => $request->txtgestor_id 
      ]);

      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollBack();
      return false;
    }
  }

    /**
   * Suspende una articulación
   * @param Request $request 
   * @param int $id Id de la articulación
   * @return boolean
   * @author dum
   **/
  public function suspenderArticulacion($request, $articulacion)
  {
    DB::beginTransaction();
    try {
      $articulacion->update([
        'fase_id' => Fase::where('nombre', 'Suspendido')->first()->id
      ]);

      $articulacion->articulacion_proyecto->actividad()->update([
        'fecha_cierre' => $request->txtfecha_cierre
      ]);
      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollBack();
      return false;
    }
  }

    /**
   * Cambia el estado de aprobacion_dinamizador_suspender para que el experto pueda suspender una articulación
   * @param int $id
   * @return boolean
   * @author dum
   **/
  public function updateAprobacionSuspendido(int $id)
  {
    DB::beginTransaction();
    try {
      $articulacion = Articulacion::findOrFail($id);
      $articulacion->articulacion_proyecto()->update([
        'aprobacion_dinamizador_suspender' => 1
      ]);
      Notification::send(User::findOrFail($articulacion->articulacion_proyecto->actividad->gestor->user->id), new ArticulacionSuspendidoAprobado($articulacion));
      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollback();
      return false;
    }
  }

  /**
   * Consulta información de las articulaciones
   *
   * @param string $fecha_inicio
   * @param string $fecha_cierre
   * @return type
   * @throws conditon
   **/
  public function consultarArticulaciones_repository(string $fecha_inicio = '', string $fecha_cierre = '')
  {
    return Articulacion::select(
      'n.nombre AS nodo',
      'lineastecnologicas.nombre AS nombre_linea',
      'actividades.codigo_actividad',
      'actividades.nombre',
      'fecha_inicio',
      'fases.nombre AS nombre_fase'
    )
    ->selectRaw('GROUP_CONCAT(productos.nombre SEPARATOR ",") AS producto_a_alcanzar')
    ->selectRaw('concat(users.documento, " - ", users.nombres, " ", users.apellidos) AS gestor')
    ->selectRaw('if(fases.nombre = "Cierre" || fases.nombre = "Suspendido", fecha_cierre, "La articulación no se ha cerrado") AS fecha_cierre')
    ->selectRaw('concat(entidades.nombre, " - ", gruposinvestigacion.codigo_grupo) AS grupo')
    ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'articulaciones.articulacion_proyecto_id')
    ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
    ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
    ->join('entidades AS n', 'n.id', '=', 'nodos.entidad_id')
    ->join('fases', 'fases.id', '=', 'articulaciones.fase_id')
    ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
    ->join('entidades', 'entidades.id', '=', 'articulacion_proyecto.entidad_id')
    ->join('gruposinvestigacion', 'gruposinvestigacion.entidad_id', '=', 'entidades.id')
    ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'gestores.lineatecnologica_id')
    ->join('users', 'users.id', '=', 'gestores.user_id')
    ->leftJoin('articulaciones_productos', 'articulaciones_productos.articulacion_id', '=', 'articulaciones.id')
    ->leftJoin('productos', 'productos.id', '=', 'articulaciones_productos.producto_id')
    ->where(function($q) use ($fecha_inicio, $fecha_cierre) {
      $q->where(function($query) use ($fecha_inicio, $fecha_cierre) {
        $query->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_cierre]);
      })
      ->orWhere(function($query) use ($fecha_inicio, $fecha_cierre) {
        $query->where(function($query) use ($fecha_inicio, $fecha_cierre) {
        $query->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_cierre]);
        $query->orWhere(function ($query) {
          $query->whereIn('fases.nombre', ['Inicio', 'Planeación', 'Ejecución', 'Cierre']);
        });
        });
        });
    })
    ->groupBy('codigo_actividad', 'actividades.nombre')
    ->orderBy('n.nombre');
  }

  /**
   * Método que retorna el directorio de los archivos que tiene una articulación en el servidor
   * @param int $id Id de la articulacion_proyecto
   * @return mixed
   * @author dum
   */
  // private function returnDirectoryArticulacionFiles($id)
  // {
  //   // consulta los archivos de una articulacion_proyecto (registro de la base de datos)
  //   $tempo = ArchivoArticulacionProyecto::where('articulacion_proyecto_id', $id)->first();
  //   if ($tempo == null) {
  //     return false;
  //   } else {
  //     // Función para dividir la cadena en un array (Partiendolos con el delimitador /)
  //     $route = preg_split("~/~", $tempo->ruta, 9);
  //     // Extrae el último elemento del array
  //     array_pop($route);
  //     // Une el array en un string, dicho string se separa por /
  //     $route = implode("/", $route);
  //     // Reemplaza storage por public en la routa
  //     $route = str_replace('storage', 'public', $route);
  //     // Retorna el directorio de los archivos de la articulación
  //     return $route;
  //   }

  // }

  /**
   * Elimina una articulación de la base de datos y sus anexo
   *
   * @param int $id Id de la articulación
   * @return boolean
   * @author dum
   */
  // public function eliminarArticulacion_Repository(int $id)
  // {
  //   DB::beginTransaction();
  //   try {
  //     $articulacion = Articulacion::find($id);
  //     $padre = $articulacion->articulacion_proyecto->actividad;
  //     // Se usa el método sync sin nada para eliminar los datos de las relaciones muchos a muchos
  //     // Elimina los datos de la tabla articulacion_proyecto_talento relacionados con la articulacion
  //     $articulacion->articulacion_proyecto->talentos()->sync([]);
  //     // Elimina los emprendedores de la articulación
  //     $articulacion->emprendedores()->delete();
  //     // Elimina el registro de la tabla de proyecto
  //     $padre->articulacion_proyecto->articulacion()->delete();
  //     // Directorio del proyecto
  //     $directory = $this->returnDirectoryArticulacionFiles($padre->articulacion_proyecto->id);
  //     if ($directory != false) {
  //       // Elimina los archivos del servidor
  //       \Storage::deleteDirectory($directory);
  //       // Elimina los registros de la tabla de archivos_articulacion_proyecto
  //       ArchivoArticulacionProyecto::where('articulacion_proyecto_id', $padre->articulacion_proyecto->id)->delete();
  //     }
  //     // Elimina el registro de la tabla la tabla de articulacion_proyecto
  //     $padre->articulacion_proyecto()->delete();
  //     // Elimina los registros de la tabla material_uso
  //     UsoInfraestructura::deleteUsoMateriales($padre);
  //     // Elimina los registros de la tabla uso_talentos
  //     UsoInfraestructura::deleteUsoTalentos($padre);
  //     // Elimina los registros de la tabla gestor_uso
  //     UsoInfraestructura::deleteUsoGestores($padre);
  //     // Elimina los registros de la tabla equipo_uso
  //     UsoInfraestructura::deleteUsoEquipos($padre);
  //     // Elimina los registros de la tabla usoinfraestructuras
  //     $padre->usoinfraestructuras()->delete();
  //     // Elimina la tabla de actividades
  //     $padre->delete();
  //     DB::commit();
  //     return true;
  //   } catch (\Exception $e) {
  //     DB::rollback();
  //     return false;
  //   }

  // }

  /**
   * Consulta articulaciones finalizadas entre dos fechas (de cierre)
   * @param string $field Campo de fecha por el que se va a filtrar
   * @param string $fecha_inicio Primera fecha para realizar el filtro
   * @param string $fecha_fin Segunda fecha para realizar el filtro
   * @return Builder
   */
  public function consultarArticulacionesEntreFecha_Repository(string $field, string $fecha_inicio, string $fecha_fin)
  {
    return Articulacion::selectRaw('COUNT(articulaciones.id) AS cantidad')
    ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'articulaciones.articulacion_proyecto_id')
    ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
    ->join('gestores AS g', 'g.id', '=', 'actividades.gestor_id')
    ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
    ->join('fases', 'fases.id', '=', 'articulaciones.fase_id')
    ->whereBetween($field, [$fecha_inicio, $fecha_fin]);
  }

    /**
   * Consulta cantidad de articulaciones por fase
   * @param string $fase Fase que se va a filtrar
   * @return Builder
   * @author dum
   **/
  public function consultarArticulacionesFase(string $fase)
  {
    return Articulacion::selectRaw('COUNT(articulaciones.id) AS cantidad')
    ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'articulaciones.articulacion_proyecto_id')
    ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
    ->join('gestores AS g', 'g.id', '=', 'actividades.gestor_id')
    ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
    ->join('fases', 'fases.id', '=', 'articulaciones.fase_id')
    ->where('fases.nombre', $fase)
    ->where(function ($q) {
      $q->where(function ($query) {
        $query->whereYear('actividades.fecha_cierre', Carbon::now()->isoFormat('YYYY'));
      })
        ->orWhere(function ($query) {
          $query->whereYear('actividades.fecha_inicio', Carbon::now()->isoFormat('YYYY'));
        });
    });
  }

  /**
  * Cambia el experto que está asociado a una articulación
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
    'fecha_inicio',
    'fases.nombre AS nombre_fase',
    'entidades.nombre AS nombre_nodo',
    'actividades.id AS actividad_id',
    'fecha_cierre')
    ->selectRaw('CONCAT(users.documento, " - ", users.nombres, " ", users.apellidos) AS nombre_completo_gestor')
    ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'articulaciones.articulacion_proyecto_id')
    ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
    ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
    ->join('nodos', 'nodos.id', '=', 'gestores.nodo_id')
    ->join('fases', 'fases.id', '=', 'articulaciones.fase_id')
    ->join('users', 'users.id', '=', 'gestores.user_id')
    ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
    ->where('nodos.id', $id)
    ->where('tipo_articulacion', Articulacion::IsGrupo())
    ->where(function ($q) use ($anho) {
      $q->where(function ($query) use ($anho) {
        $query->whereYear('actividades.fecha_cierre', '=', $anho)
        ->whereIn('fases.nombre', ['Cierre', 'Suspendido']);
      })
        ->orWhere(function ($query) {
          $query->whereIn('fases.nombre', ['Inicio', 'Planeación', 'Ejecución']);
        });
    });
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

      $articulacion = Articulacion::findOrFail($id);

      $entidad_id = Entidad::select('entidades.id')
      ->join('gruposinvestigacion', 'gruposinvestigacion.entidad_id', '=', 'entidades.id')
      ->where('gruposinvestigacion.id', request()->txtgrupo_id)->get()->last()->id;
      
      $articulacion->update([
      'acuerdos' => request()->txtacuerdos,
      'alcance_articulacion' => request()->txtalcance_articulacion
      ]);

      $articulacion->articulacion_proyecto()->update([
      'entidad_id'   => $entidad_id
      ]);


      $articulacion->articulacion_proyecto->actividad()->update([
      'nombre' => request()->txtnombre,
      ]);
      
      $articulacion->productos()->sync(request()->productos, true);

      $syncData = array();
      $syncData = $this->arraySyncTalentosDeUnaArticulacion($request);
      $articulacion->articulacion_proyecto->talentos()->sync($syncData, true);

      ArticulacionProyecto::habilitarTalentos($articulacion->articulacion_proyecto);

      DB::commit();
      return true;
    } catch (Exception $e) {
      DB::rollback();
      return false;
    }
  }

  /**
  * Consulta las articulaciones de un gestor
  * @param string $anho Año para realizar el filtro
  * @return Collection
  * @author dum
  */
  public function consultarArticulacionesDeUnGestor($anho)
  {
    return Articulacion::select('codigo_actividad AS codigo_articulacion',
    'actividades.nombre',
    'articulaciones.id',
    'fecha_inicio',
    'fases.nombre AS nombre_fase',
    'actividades.id AS actividad_id',
    'fecha_cierre')
    ->selectRaw('CONCAT(users.documento, " - ", users.nombres, " ", users.apellidos) AS nombre_completo_gestor')
    ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'articulaciones.articulacion_proyecto_id')
    ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
    ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
    ->join('fases', 'fases.id', '=', 'articulaciones.fase_id')
    ->join('users', 'users.id', '=', 'gestores.user_id')
    ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
    ->where('tipo_articulacion', Articulacion::IsGrupo())
    ->where(function ($q) use ($anho) {
      $q->where(function ($query) use ($anho) {
        $query->whereYear('actividades.fecha_cierre', '=', $anho)
        ->whereIn('fases.nombre', ['Cierre', 'Suspendido']);
      })
        ->orWhere(function ($query) {
          $query->whereIn('fases.nombre', ['Inicio', 'Planeación', 'Ejecución']);
        });
    });
  }

  /**
   * Genera un código para la articulación
   *
   * @return string
   * @author dum
   **/
  public function generarCodigoArticulacion()
  {
    $anho = Carbon::now()->isoFormat('YYYY');
    $tecnoparque = sprintf("%02d", auth()->user()->gestor->nodo_id);
    $linea = auth()->user()->gestor->lineatecnologica_id;
    $gestor = sprintf("%03d", auth()->user()->gestor->id);
    $idArticulacion = Articulacion::selectRaw('MAX(id+1) AS max')->get()->last();
    $idArticulacion->max == null ? $idArticulacion->max = 1 : $idArticulacion->max = $idArticulacion->max;
    $idArticulacion->max = sprintf("%04d", $idArticulacion->max);

    $codigo = 'A' . $anho . '-' . $tecnoparque . $linea . $gestor . '-' . $idArticulacion->max;

    return $codigo;
  }

  private function arraySyncTalentosDeUnaArticulacion($request)
  {
    $syncData = array();
    foreach ($request->get('talentos') as $id => $value) {
      if ($value == request()->get('radioTalentoLider')) {
        $syncData[$id] = array('talento_lider' => 1, 'talento_id' => $value);
      } else {
        $syncData[$id] = array('talento_lider' => 0, 'talento_id' => $value);
      }
    }
    return $syncData;
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
      $codigo = $this->generarCodigoArticulacion();
      $entidad_id = Entidad::select('entidades.id')
      ->join('gruposinvestigacion', 'gruposinvestigacion.entidad_id', '=', 'entidades.id')
      ->where('gruposinvestigacion.id', request()->txtgrupo_id)->get()->last()->id;

      $actividad = Actividad::create([
      'gestor_id' => auth()->user()->gestor->id,
      'nodo_id' => auth()->user()->gestor->nodo_id,
      'codigo_actividad' => $codigo,
      'nombre' => request()->txtnombre,
      'fecha_inicio' => Carbon::now()->isoFormat('YYYY-MM-DD'),
      ]);

      $articulacion_proyecto = ArticulacionProyecto::create([
      'entidad_id'   => $entidad_id,
      'actividad_id' => $actividad->id,
      ]);

      $articulacion = Articulacion::create([
      'articulacion_proyecto_id' => $articulacion_proyecto->id,
      'tipo_articulacion' => 0,
      'fase_id' => Fase::where('nombre', 'Inicio')->first()->id,
      'acuerdos' => request()->txtacuerdos,
      'alcance_articulacion' => request()->txtalcance_articulacion
      ]);
      
      // dd(request()->productos);
      $articulacion->productos()->sync(request()->productos);

      $syncData = array();
      $syncData = $this->arraySyncTalentosDeUnaArticulacion($request);
      $articulacion_proyecto->talentos()->sync($syncData, false);

      ArticulacionProyecto::habilitarTalentos($articulacion_proyecto);

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
