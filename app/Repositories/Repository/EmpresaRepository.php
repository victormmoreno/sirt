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

/**
    * Consulta las empresas asociadas como propietarias a proyecto
    *
    * @param string $fecha_inicio
    * @param string $fecha_cierre
    * @return Eloquent
    * @author dum
    **/
public function empresasPropietarias(string $fecha_inicio, string $fecha_cierre)
{
    return Empresa::select(
    'codigo_actividad',
    'nit',
    'codigo_ciiu',
    'entidades.nombre AS nombre_empresa',
    'fecha_creacion',
    'sectores.nombre AS nombre_sector',
    'email_entidad',
    'empresas.direccion',
    'tamanhos_empresas.nombre AS tamanho_empresa',
    'tipos_empresas.nombre AS tipo_empresa'
    )
    ->selectRaw('concat(ciudades.nombre, " - ", departamentos.nombre) AS ciudad')
    ->join('entidades', 'entidades.id', '=', 'empresas.entidad_id')
    ->join('propietarios', 'propietarios.propietario_id', '=', 'empresas.id')
    ->join('proyectos', 'proyectos.id', '=', 'propietarios.proyecto_id')
    ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id')
    ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
    ->join('sectores', 'sectores.id', '=', 'empresas.sector_id')
    ->join('ciudades', 'ciudades.id', '=', 'entidades.ciudad_id')
    ->join('departamentos', 'departamentos.id', '=', 'ciudades.departamento_id')
    ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
    ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
    ->leftJoin('tamanhos_empresas', 'tamanhos_empresas.id', '=', 'empresas.tamanhoempresa_id')
    ->leftJoin('tipos_empresas', 'tipos_empresas.id', '=', 'empresas.tipoempresa_id')
    ->where('entidades.nombre', '!=', 'No Aplica')
    ->where('propietarios.propietario_type', 'App\Models\Empresa')
    ->where(function($q) use ($fecha_inicio, $fecha_cierre) {
    $q->where(function($query) use ($fecha_inicio, $fecha_cierre) {
        $query->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_cierre]);
    })
    ->orWhere(function($query) use ($fecha_inicio, $fecha_cierre) {
        $query->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_cierre]);
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

    $empresa->entidad->ciudad_id     = $request->input('txtciudad_id_empresa');
    $empresa->entidad->nombre        = $request->input('txtnombre_empresa');
    $empresa->entidad->slug          = str_slug($request->input('txtnombre_empresa') . str_random(7), '-');
    $empresa->entidad->email_entidad = $request->input('txtemail_entidad');
    $empresa->entidad->update();
    $empresa->sector_id = $request->input('txtsector_empresa');
    $empresa->nit       = $request->input('txtnit_empresa');
    $empresa->direccion = $request->input('txtdireccion_empresa');
    $empresa->tipoempresa_id  = $request->input('txttipoempresa_id_empresa');
    $empresa->tamanhoempresa_id  = $request->input('txttamanhoempresa_id_empresa');
    $empresa->fecha_creacion  = $request->input('txtfecha_creacion_empresa');
    $empresa->codigo_ciiu  = $request->input('txtcodigo_ciiu_empresa');
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
        'ciudad_id'     => $request->input('txtciudad_id_empresa'),
        'nombre'        => $request->input('txtnombre_empresa'),
        'slug'          => str_slug($request->input('txtnombre_empresa') . str_random(7), '-'),
        'email_entidad' => $request->input('txtemail_entidad'),
    ]);

    $empresa = Empresa::create([
        'entidad_id' => $entidad->id,
        'sector_id'  => $request->input('txtsector_empresa'),
        'nit'        => $request->input('txtnit_empresa'),
        'direccion'  => $request->input('txtdireccion_empresa'),
        'tipoempresa_id'  => $request->input('txttipoempresa_id_empresa'),
        'tamanhoempresa_id'  => $request->input('txttamanhoempresa_id_empresa'),
        'fecha_creacion'  => $request->input('txtfecha_creacion_empresa'),
        'codigo_ciiu'  => $request->input('txtcodigo_ciiu_empresa'),
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

/**
    * Consulta los detalles de una empresa
    * @param $param Valor del parámetro por el que se va a filtrar
    * @param $field Nombre del campo por el que se va a filtrar
    * @return Builder
    * @author dum
    */
public function consultarDetallesDeUnaEmpresa($param, $field)
{
    return Empresa::where($field, $param)->with('sector', 'tipoempresa', 'tamanhoempresa', 'entidad', 'entidad.ciudad');
}

}
