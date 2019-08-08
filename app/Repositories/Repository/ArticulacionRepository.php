<?php

namespace App\Repositories\Repository;

use Illuminate\Support\Facades\{DB};
use App\Models\{ArchivoArticulacion, Articulacion, Entidad, Talento};
use Carbon\Carbon;

class ArticulacionRepository
{

/**
 * Consulta la cantidad de articulacion de un nodo, según el tipo de articulacion y el año
 * @param int $id Id del nodo
 * @param string $anho Año por el que se consultaran la cantidad de articulaciones
 * @param int $i Tipo de articulacion
 * @return Collection
 * @author Victor Manuel Moreno Vega
 */
public function consultarCantidadDeArticulacionesPorTipoYNodoYAnho($id, $anho, $i)
{
  return Articulacion::select('articulaciones.tipo_articulacion')
  ->selectRaw('count(articulaciones.id) AS cantidad')
  ->join('gestores', 'gestores.id', '=', 'articulaciones.gestor_id')
  ->join('nodos', 'nodos.id', '=', 'gestores.nodo_id')
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
   * @author Victor Manuel Moreno Vega
   */
  public function consultarCantidadDeArticulacionesPorLineaTecnologicaYFecha_Repository($idnodo, $idlinea, $tipo_articulacion, $fecha_inicio, $fecha_fin)
  {
    return Articulacion::select('articulaciones.tipo_articulacion')
    ->selectRaw('count(articulaciones.id) AS cantidad')
    ->join('gestores', 'gestores.id', '=', 'articulaciones.gestor_id')
    ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'gestores.lineatecnologica_id')
    ->join('lineastecnologicas_nodos', 'lineastecnologicas_nodos.linea_tecnologica_id', '=', 'lineastecnologicas.id')
    ->join('nodos', 'nodos.id', '=', 'lineastecnologicas_nodos.nodo_id')
    ->where('lineastecnologicas.id', $idlinea)
    ->where('nodos.id', $idnodo)
    ->where('tipo_articulacion', $tipo_articulacion)
    ->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin])
    ->groupBy('lineastecnologicas.id', 'articulaciones.tipo_articulacion')
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
    ->join('gestores', 'gestores.id', '=', 'articulaciones.gestor_id')
    ->join('users', 'users.id', '=', 'gestores.user_id')
    ->join('nodos', 'nodos.id', '=', 'gestores.nodo_id')
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
    ->join('gestores', 'gestores.id', '=', 'articulaciones.gestor_id')
    ->join('users', 'users.id', '=', 'gestores.user_id')
    ->join('nodos', 'nodos.id', '=', 'gestores.nodo_id')
    ->where('gestores.id', $id)
    ->groupBy('gestores.id', 'articulaciones.tipo_articulacion')
    ->get();
  }

  // Cambia el revisado final de una articulación
  public function updateRevisadoFinalArticulacion($request, $id)
  {
    return Articulacion::where('id', $id)
    ->update([
      "revisado_final" => $request['txtrevisado']
    ]);
  }


  // Consulta las articulaciones de un nodo
  public function consultarArticulacionesDeUnNodo($id)
  {
    return Articulacion::select('codigo_articulacion', 'articulaciones.nombre', 'articulaciones.id')
    ->selectRaw('IF(tipo_articulacion = '.Articulacion::IsGrupo().', "Grupo de Investigación", IF(tipo_articulacion = '.Articulacion::IsEmpresa().', "Empresa", "Emprendedor(es)") ) AS tipo_articulacion')
    ->selectRaw('IF(articulaciones.estado = '.Articulacion::IsInicio().', "Inicio", IF(articulaciones.estado = '.Articulacion::IsEjecucion().', "Ejecución", "Cierre") ) AS estado')
    ->selectRaw('IF(revisado_final = '.Articulacion::IsPorEvaluar().', "Por Evaluar", IF(revisado_final = '.Articulacion::IsAprobado().', "Aprobado", "No Aprobado") ) AS revisado_final')
    ->selectRaw('CONCAT(users.documento, " - ", users.nombres, " ", users.apellidos) AS nombre_completo_gestor')
    ->join('gestores', 'gestores.id', '=', 'articulaciones.gestor_id')
    ->join('nodos', 'nodos.id', '=', 'gestores.nodo_id')
    ->join('users', 'users.id', '=', 'gestores.user_id')
    ->where('nodos.id', $id)
    ->get();
  }

  // Consulta los entregables de una articulación
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
    ->where('id', $id)
    ->get();
  }

  // Modifica un articulación
  public function update($request,  $id)
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

      if (request()->group1 == Articulacion::IsEmprendedor())
      request()->entidad_id = Entidad::all()->where('nombre', 'No Aplica')->last()->id;

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
        $articulacionConsultaId->talentos()->detach();
      }
      $articulacionConsultaId->update([
        'entidad_id' => request()->entidad_id,
        'tipoarticulacion_id' => request()->txttipoarticulacion_id,
        'gestor_id' => auth()->user()->gestor->id,
        'nombre' => request()->txtnombre,
        'tipo_articulacion' => request()->group1,
        'fecha_inicio' => request()->txtfecha_inicio,
        'fecha_ejecucion' => $fechaEjecucion,
        'fecha_cierre' => $fechaCierre,
        'observaciones' => request()->txtobservaciones,
        'estado' => request()->txtestado,
      ]);

      if (request()->group1 == Articulacion::IsEmprendedor()) {
        $syncData = array();
        foreach($request->get('talentos') as $id => $value){
          if ($value == request()->get('radioTalentoLider')) {
            $syncData[$id] = array('talento_lider' => 1, 'talento_id' => $value);
          } else {
            $syncData[$id] = array('talento_lider' => 0, 'talento_id' => $value);
          }
        }
        $articulacionConsultaId->talentos()->sync($syncData);
      }
      DB::commit();
      return true;
    } catch (Exception $e) {
      DB::rollback();
      return false;
    }
  }

  // Consulta los datos de la tabla intermedia entre talentos y articulacion (articulacion_talento)
  public function consultarArticulacionTalento($id)
  {
    return Articulacion::select('articulacion_talento.talento_lider', 'articulacion_talento.talento_id')
    ->selectRaw('concat(users.documento, " - ", users.nombres, " ", users.apellidos) AS talento')
    ->join('articulacion_talento', 'articulacion_talento.articulacion_id', '=', 'articulaciones.id')
    ->join('talentos', 'articulacion_talento.talento_id', '=', 'talentos.id')
    ->join('users', 'users.id', '=', 'talentos.user_id')
    ->where('articulaciones.id', $id)
    ->get();
  }

  // Modifica los entregables de una articulación (Solo se actualizan los checkbox, los archivos se suben en tiempo real con ajax)
  public function updateEntregablesArticulacion($request, $id)
  {
    return Articulacion::where('id', $id)
    ->update([
      "acta_inicio" => $request['entregable_acta_inicio'],
      "acc" => $request['entregable_acuerdo_confidencialidad_compromiso'],
      "actas_seguimiento" => $request['entregable_acta_seguimiento'],
      "acta_cierre" => $request['entregable_acta_cierre'],
      "informe_final" => $request['entregable_informe_final'],
      "pantallazo" => $request['entregable_encuesta_satisfaccion'],
      "otros" => $request['entregable_otros'],
    ]);
  }

  // Consulta una articulación por id
  public function consultarArticulacionPorId($id)
  {
    return Articulacion::select(
      'codigo_articulacion',
      'articulaciones.nombre',
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
    ->selectRaw('IF(tipo_articulacion = '.Articulacion::IsGrupo().', "Grupo de Investigación", IF(tipo_articulacion = '.Articulacion::IsEmpresa().', "Empresa",
    "Emprendedor") ) AS tipo_articulacion')
    ->selectRaw('IF(articulaciones.estado = '.Articulacion::IsInicio().', "Inicio", IF(articulaciones.estado = '.Articulacion::IsEjecucion().', "Ejecución", "Cierre") ) AS estado')
    ->selectRaw('IF(revisado_final = '.Articulacion::IsPorEvaluar().', "Por Evaluar", IF(revisado_final = '.Articulacion::IsAprobado().', "Aprobado",
    "No Aprobado") ) AS revisado_final')
    ->selectRaw('CONCAT(users.nombres, " ", users.apellidos) AS gestor')
    ->join('tiposarticulaciones', 'tiposarticulaciones.id', '=', 'articulaciones.tipoarticulacion_id')
    ->join('gestores', 'gestores.id', '=', 'articulaciones.gestor_id')
    ->join('users', 'users.id', '=', 'gestores.user_id')
    ->where('articulaciones.id', $id)
    ->get();
  }


  // Consulta las articulaciones de un gestor
  public function consultarArticulacionesDeUnGestor($id)
  {
    return Articulacion::select('codigo_articulacion', 'articulaciones.nombre', 'articulaciones.id')
    ->selectRaw('IF(tipo_articulacion = '.Articulacion::IsGrupo().', "Grupo de Investigación", IF(tipo_articulacion = '.Articulacion::IsEmpresa().', "Empresa", "Emprendedor(es)") ) AS tipo_articulacion')
    ->selectRaw('IF(articulaciones.estado = '.Articulacion::IsInicio().', "Inicio", IF(articulaciones.estado = '.Articulacion::IsEjecucion().', "Ejecución", "Cierre") ) AS estado')
    ->selectRaw('IF(revisado_final = '.Articulacion::IsPorEvaluar().', "Por Evaluar", IF(revisado_final = '.Articulacion::IsAprobado().', "Aprobado", "No Aprobado") ) AS revisado_final')
    ->selectRaw('CONCAT(users.documento, " - ", users.nombres, " ", users.apellidos) AS nombre_completo_gestor')
    ->join('gestores', 'gestores.id', '=', 'articulaciones.gestor_id')
    ->join('users', 'users.id', '=', 'gestores.user_id')
    ->where('articulaciones.gestor_id', $id)
    ->get();
  }

  // Crea un articulación
  public function create($request)
  {
    // dd($request->get('talentos'));

    // dd($request->get('radioTalentoLider'));
    DB::beginTransaction();
    try {
      $anho = Carbon::now()->isoFormat('YYYY');
      $tecnoparque = sprintf("%02d", auth()->user()->gestor->nodo_id);
      $linea = auth()->user()->gestor->lineatecnologica_id;
      $gestor = sprintf("%03d", auth()->user()->gestor->id);
      $idArticulacion = Articulacion::selectRaw('MAX(id+1) AS max')->get()->last();
      $idArticulacion->max == null ? $idArticulacion->max = 1 : $idArticulacion->max = $idArticulacion->max;
      $idArticulacion->max = sprintf("%04d", $idArticulacion->max);
      $fechaEjecucion = request()->txtfecha_inicio;

      // dd($anho);
      $codigo = 'A'. $anho . '-' . $tecnoparque . $linea . $gestor . '-' . $idArticulacion->max;
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

      if (request()->group1 == Articulacion::IsEmprendedor())
      request()->entidad_id = Entidad::all()->where('nombre', 'No Aplica')->last()->id;

      if (request()->txtestado == Articulacion::IsEjecucion()) {
        $fechaEjecucion = Carbon::now()->toDateString();
      }
      $articulacion = Articulacion::create([
        'entidad_id' => request()->entidad_id,
        'tipoarticulacion_id' => request()->txttipoarticulacion_id,
        'gestor_id' => auth()->user()->gestor->id,
        'codigo_articulacion' => $codigo,
        'nombre' => request()->txtnombre,
        'tipo_articulacion' => request()->group1,
        'fecha_inicio' => request()->txtfecha_inicio,
        'fecha_ejecucion' => $fechaEjecucion,
        'observaciones' => request()->txtobservaciones,
        'estado' => request()->txtestado,
      ]);

      if (request()->group1 == Articulacion::IsEmprendedor()) {
        $syncData = array();
        foreach($request->get('talentos') as $id => $value){
          if ($value == request()->get('radioTalentoLider')) {
            $syncData[$id] = array('talento_lider' => 1, 'talento_id' => $value);
          } else {
            $syncData[$id] = array('talento_lider' => 0, 'talento_id' => $value);
          }
        }
        $articulacion->talentos()->sync($syncData, false);
      }

      DB::commit();
      return true;
    } catch (Exception $e) {
      DB::rollback();
      return false;
    }

  }

}
