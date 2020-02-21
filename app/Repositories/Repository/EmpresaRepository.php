<?php

namespace App\Repositories\Repository;

use App\Models\{Empresa, Entidad};
use Illuminate\Support\Facades\DB;

class EmpresaRepository
{

  /**
   * Consulta las empresas asociadas a proyectos, articulaciones y edts
   * @param string $fecha_inicio Primera fecha para realizar el filtro
   * @param string $fecha_fin Segunda fecha para realizar el filtro
   * @return Builder
   * @author dum
   */
  public function consultarEmpresasAsociadosAServicios($fecha_inicio, $fecha_fin)
  {
    return Empresa::select('nit',
    'entidades.nombre',
    'codigo_actividad')
    ->join('entidades', 'entidades.id', '=', 'empresas.entidad_id')
    ->join('articulacion_proyecto', 'articulacion_proyecto.entidad_id', '=', 'entidades.id')
    ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
    ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
    ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
    ->where('entidades.nombre', '!=', 'No Aplica')
    ->where(function($q) use ($fecha_inicio, $fecha_fin) {
      $q->where(function($query) use ($fecha_inicio, $fecha_fin) {
        $query->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin]);
      })
      ->orWhere(function($query) use ($fecha_inicio, $fecha_fin) {
        $query->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin]);
      });
    });
  }

  // Consulta los contactos que tiene el nodo con las empresas
  public function consultarContactosPorNodoDeUnaEmpresa($identidad, $idnodo)
  {
    return Empresa::select('contactosentidades.nombres_contacto',
    'contactosentidades.correo_contacto',
    'contactosentidades.telefono_contacto',
    'nodo.nombre AS nodo')
    ->join('entidades', 'entidades.id', '=', 'empresas.entidad_id')
    ->join('contactosentidades', 'contactosentidades.entidad_id', '=', 'entidades.id')
    ->join('nodos', 'nodos.id', '=', 'contactosentidades.nodo_id')
    ->join('entidades AS nodo', 'nodo.id', '=', 'nodos.entidad_id')
    ->where('nodos.id', $idnodo)
    ->where('entidades.id', $identidad)
    ->groupBy('contactosentidades.id')
    ->get();
  }

  // Modifica los datos de una empresa
  public function update($request, $empresa)
  {
    DB::beginTransaction();
    try {

      $empresa->entidad->ciudad_id     = $request->input('txtciudad_id');
      $empresa->entidad->nombre        = $request->input('nombre');
      $empresa->entidad->slug          = str_slug($request->input('nombre') . str_random(7), '-');
      $empresa->entidad->email_entidad = $request->input('email_entidad');
      $empresa->entidad->update();
      $empresa->sector_id = $request->input('txtsector');
      $empresa->nit       = $request->input('nit');
      $empresa->direccion = $request->input('direccion');
      $empresa->tipoempresa_id  = $request->input('txttipoempresa_id');
      $empresa->tamanhoempresa_id  = $request->input('txttamanhoempresa_id');
      $empresa->fecha_creacion  = $request->input('fecha_creacion');
      $empresa->codigo_ciiu  = $request->input('codigo_ciiu');
      $empresa->update();
      DB::commit();
      return $empresa;
    } catch (Exception $e) {
      DB::rollback();
    }

  }

  // Registra una empresa en la base de datos
  public function store($request)
  {
    DB::beginTransaction();
    try {

      $entidad = Entidad::create([
      'ciudad_id'     => $request->input('txtciudad_id'),
      'nombre'        => $request->input('nombre'),
      'slug'          => str_slug($request->input('nombre') . str_random(7), '-'),
      'email_entidad' => $request->input('email_entidad'),
      ]);

      $empresa = Empresa::create([
      'entidad_id' => $entidad->id,
      'sector_id'  => $request->input('txtsector'),
      'nit'        => $request->input('nit'),
      'direccion'  => $request->input('direccion'),
      'tipoempresa_id'  => $request->input('txttipoempresa_id'),
      'tamanhoempresa_id'  => $request->input('txttamanhoempresa_id'),
      'fecha_creacion'  => $request->input('fecha_creacion'),
      'codigo_ciiu'  => $request->input('codigo_ciiu'),
      ]);

      DB::commit();
      return $empresa;
    } catch (Exception $e) {
      DB::rollback();
    }

  }

  // Consulta las empresas de la red de tecnoparque
  public function consultarEmpresasDeRedTecnoparque()
  {
    return Empresa::select('nit',
    'direccion',
    'entidades.nombre AS nombre_empresa',
    'empresas.id',
    'sectores.nombre AS sector_empresa',
    'entidades.id AS id_entidad')
    ->selectRaw('CONCAT(ciudades.nombre, " - ", departamentos.nombre) AS ciudad')
    ->join('entidades', 'entidades.id', '=', 'empresas.entidad_id')
    ->join('sectores', 'sectores.id', '=', 'empresas.sector_id')
    ->join('ciudades', 'ciudades.id', '=', 'entidades.ciudad_id')
    ->join('departamentos', 'departamentos.id', '=', 'ciudades.departamento_id')
    ->get();
  }

  // Consulta los detalles de una empresa
  public function consultarDetallesDeUnaEmpresa($id)
  {
    return Empresa::select('nit',
    'direccion',
    'entidades.nombre AS nombre_empresa',
    'empresas.id',
    'empresas.entidad_id',
    'email_entidad')
    ->selectRaw('CONCAT(ciudades.nombre, " - ", departamentos.nombre) AS ciudad')
    ->join('entidades', 'entidades.id', '=', 'empresas.entidad_id')
    ->join('sectores', 'sectores.id', '=', 'empresas.sector_id')
    ->join('ciudades', 'ciudades.id', '=', 'entidades.ciudad_id')
    ->join('departamentos', 'departamentos.id', '=', 'ciudades.departamento_id')
    ->where('empresas.id', $id)
    ->get()
    ->last();
  }

}
