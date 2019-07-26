<?php

namespace App\Repositories\Repository;

use App\Models\{GrupoInvestigacion, Empresa, Entidad, Tecnoacademia, Nodo, Centro};
use Illuminate\Support\Facades\DB;

class EntidadRepository
{
  /**
   * Busca un grupos de investigación por el id de la entidad (tabla entidades)
   *
   * @param int $id, Id de la tabla entidad con el que se consultará la entidad
   * @return return object
   */
  public function consultarGrupoInvestigacionEntidadRepository($id)
  {
    return GrupoInvestigacion::select('entidades.nombre', 'gruposinvestigacion.codigo_grupo')
    ->join('entidades', 'entidades.id', '=','gruposinvestigacion.entidad_id')
    ->where('entidades.id', $id)
    ->get()
    ->last();
  }

  /**
   * Consulta la información de una tecnoacademia por el id de la entidad
   *
   * @param int $id, Id de la tabla entidad con el que se consultará la entidad
   * @return return object
   */
  public function consultarTecnoacademiaEntidadRepository($id)
  {
    return Tecnoacademia::select('entidades.nombre')
    ->selectRaw('concat(centros.codigo_centro, " - ", ecentro.nombre) AS centro_formacion')
    ->join('entidades', 'entidades.id', '=', 'tecnoacademias.entidad_id')
    ->join('centros', 'centros.id', '=', 'tecnoacademias.centro_id')
    ->join('entidades AS ecentro', 'ecentro.id', '=', 'centros.entidad_id')
    ->where('entidades.id', $id)
    ->get()
    ->last();
  }

  /**
   * Consulta la información de una empresa por el id de la entidad
   *
   * @param int $id, Id de la tabla entidad con el que se consultará la entidad
   * @return return object
   */
  public function consultarEmpresaEntidadRepository($id)
  {
    return Empresa::select('entidades.nombre', 'empresas.nit', 'empresas.entidad_id')
    ->join('entidades', 'entidades.id', '=', 'empresas.entidad_id')
    ->where('entidades.id', $id)
    ->get()
    ->last();
  }

  /**
   * Consulta la inforamción del nodo por el id de la entidad
   *
   * @param int $id, Id de la tabla entidad con el que se consultará la entidad
   * @return return object
   */
  public function consultarNodoEntidadRepository($id)
  {
    return Nodo::select('entidades.nombre')
    ->selectRaw('CONCAT(centros.codigo_centro, " - ", ecentro.nombre) AS centro')
    ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
    ->join('centros', 'centros.id', '=', 'nodos.entidad_id')
    ->join('entidades AS ecentro', 'ecentro.id', '=', 'centros.entidad_id')
    ->where('entidades.id', $id)
    ->get()
    ->last();
  }

  /**
   * Consulta la información del centro de formación por el id de la entidad
   *
   * @param int $id, Id de la tabla entidad con el que se consultará la entidad
   * @return return object
   */
  public function consultarCentroFormacionEntidadRepository($id)
  {
    return Centro::select('centros.codigo_centro', 'entidades.nombre')
    ->join('entidades', 'entidades.id', '=', 'centros.entidad_id')
    ->where('entidades.id', $id)
    ->get()
    ->last();
  }
}
