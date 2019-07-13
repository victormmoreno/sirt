<?php

namespace App\Repositories\Repository;

use App\Models\{GrupoInvestigacion, ClasificacionColciencias, Entidad};
use Illuminate\Support\Facades\DB;

class GrupoInvestigacionRepository
{

  // Consulta los contactos que tiene el nodo con las empresas
  public function consultarContactosPorNodoDeUnGrupo($identidad, $idnodo)
  {
    return GrupoInvestigacion::select(
      'contactosentidades.nombres_contacto',
      'contactosentidades.correo_contacto',
      'contactosentidades.telefono_contacto',
      'nodos.nombre AS nodo',
      'nodos.id'
      )
      ->join('entidades', 'entidades.id', '=', 'gruposinvestigacion.entidad_id')
      ->join('contactosentidades', 'contactosentidades.entidad_id', '=', 'entidades.id')
      ->join('nodos', 'nodos.id', '=', 'contactosentidades.nodo_id')
      ->where('nodos.id', $idnodo)
      ->where('entidades.id', $identidad)
      ->groupBy('contactosentidades.id')
      ->get();
  }
  // Consulta los detalles de una empresa
  public function consultarDetalleDeUnGrupoDeInvestigacion($id)
  {
    return GrupoInvestigacion::select(
      'codigo_grupo',
      'entidades.nombre AS nombre_grupo',
      'email_entidad AS correo_grupo',
      'institucion',
      'clasificacionescolciencias.nombre AS nombre_clasificacion',
      'nombres_contacto',
      'correo_contacto',
      'telefono_contacto'
      )
    ->selectRaw('CONCAT(ciudades.nombre, " - ", departamentos.nombre) AS ciudad')
    ->selectRaw('IF(tipogrupo = 0, "Externo", "Interno") AS tipogrupo')
    ->join('entidades', 'entidades.id', '=', 'gruposinvestigacion.entidad_id')
    ->join('ciudades', 'ciudades.id', '=', 'entidades.ciudad_id')
    ->join('departamentos', 'departamentos.id', '=', 'ciudades.departamento_id')
    ->join('clasificacionescolciencias', 'clasificacionescolciencias.id', '=', 'gruposinvestigacion.clasificacioncolciencias_id')
    ->where('gruposinvestigacion.id', $id)
    ->get()
    ->last();
  }

  // Modifica los datos de un grupo de investigación
  public function update($request, $grupo)
  {
    DB::transaction(function () use ($request, $grupo) {
      $grupo->entidad->ciudad_id = $request->input('txtciudad_id');
      $grupo->entidad->nombre = $request->input('txtnombre');
      $grupo->entidad->email_entidad = $request->input('txtemail_entidad');
      $grupo->entidad->update();
      $grupo->clasificacioncolciencias_id = $request->input('txtclasificacionclociencias_id');
      $grupo->codigo_grupo = strtoupper($request->input('txtcodigo_grupo'));
      $grupo->tipogrupo = $request->input('txttipogrupo');
      $grupo->institucion = $request->input('txtinstitucion');
      // $grupo->nombres_contacto = $request->input('txtnombres_contacto');
      // $grupo->correo_contacto = $request->input('txtcorreo_contacto');
      // $grupo->telefono_contacto = $request->input('txttelefono_contacto');
      $grupo->update();
      return $grupo;
    });
  }

  // Registra un grupo de investigación en la base de datos
  public function store($request)
  {
    DB::transaction(function () use ($request) {
      $entidad = Entidad::create([
        'ciudad_id' => $request->input('txtciudad_id'),
        'nombre' => $request->input('txtnombre'),
        'email_entidad' => $request->input('txtemail_entidad'),
      ]);

      return GrupoInvestigacion::create([
        'entidad_id' => $entidad->id,
        'clasificacioncolciencias_id' => $request->input('txtclasificacionclociencias_id'),
        'codigo_grupo' => strtoupper($request->input('txtcodigo_grupo')),
        'tipogrupo' => $request->input('txttipogrupo'),
        'estado' => GrupoInvestigacion::IsActive(),
        'institucion' => $request->input('txtinstitucion'),
        // 'nombres_contacto' => $request->input('txtnombres_contacto'),
        // 'correo_contacto' => $request->input('txtcorreo_contacto'),
        // 'telefono_contacto' => $request->input('txttelefono_contacto'),
      ]);
    });
  }

  /*===============================================================================
  =            metodo para consultar todos los grupos de investigacion            =
  ===============================================================================*/
  
  public function getAllGruposInvestigacionesForCiudad($ciudad)
  {
     return Entidad::allGrupoInvestigacionForCiudad($ciudad)->pluck('nombre','id');
  }
  
  
  /*=====  End of metodo para consultar todos los grupos de investigacion  ======*/

  /*==============================================================================================
  =            metodo para mostrar grupos de investigaciones por ciudad en datatables            =
  ==============================================================================================*/
  
  
  public function getAllGruposInvestigacionDatatables($ciudad)
  {
    return Entidad::select(['entidades.id','entidades.nombre','gruposinvestigacion.institucion','gruposinvestigacion.codigo_grupo'])
                ->join('gruposinvestigacion','gruposinvestigacion.entidad_id','entidades.id')
                ->where('entidades.ciudad_id','=',$ciudad)->get();
  }
  /*=====  End of metodo para mostrar grupos de investigaciones por ciudad en datatables  ======*/
  
  

}
