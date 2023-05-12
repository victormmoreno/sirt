<?php

namespace App\Repositories\Repository;

use App\Models\{Entidad, GrupoInvestigacion};
use Illuminate\Support\Facades\DB;

class GrupoInvestigacionRepository
{
    /**
     * Método para consultar grupos de investigación propietarios de propiedades intelectuales
     * @param string $fecha_inicio
     * @param string $fecha_cierre
     * @return Builder
     * @author dum
     **/
    public function gruposPropietarios(string $fecha_inicio, string $fecha_cierre)
    {
        return GrupoInvestigacion::select(
        'codigo_actividad',
        'codigo_grupo',
        'entidades.nombre AS nombre_grupo',
        'entidades.email_entidad',
        'institucion',
        'clasificacionescolciencias.nombre AS nombre_clasificacion',
        'entidad_nodo.nombre AS nodo_nombre'
        )
        ->selectRaw('concat(ciudades.nombre, " - ", departamentos.nombre) AS ciudad')
        ->selectRaw('if(tipogrupo = '.GrupoInvestigacion::IsInterno().', "SENA", "Externo") AS tipogrupo')
        ->join('entidades', 'entidades.id', '=', 'gruposinvestigacion.entidad_id')
        ->join('propietarios', 'propietarios.propietario_id', '=', 'gruposinvestigacion.id')
        ->join('proyectos', 'proyectos.id', '=', 'propietarios.proyecto_id')
        ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id')
        ->join('proyectos AS pp', 'pp.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
        ->join('fases', 'fases.id', '=', 'pp.fase_id')
        ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
        ->join('ciudades', 'ciudades.id', '=', 'entidades.ciudad_id')
        ->join('departamentos', 'departamentos.id', '=', 'ciudades.departamento_id')
        ->join('nodos', 'nodos.id', '=', 'pp.nodo_id')
        ->join('entidades AS entidad_nodo', 'entidad_nodo.id', '=', 'nodos.entidad_id')
        ->join('clasificacionescolciencias', 'clasificacionescolciencias.id', '=', 'gruposinvestigacion.clasificacioncolciencias_id')
        ->join('gestores', 'gestores.id', '=', 'pp.asesor_id')
        ->where('entidades.nombre', '!=', 'No Aplica')
        ->where('propietarios.propietario_type', 'App\Models\GrupoInvestigacion')
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
        });
    }

    // Modifica los datos de un grupo de investigación
    public function update($request, $grupo)
    {
        DB::transaction(function () use ($request, $grupo) {
            $grupo->entidad->ciudad_id     = $request->input('txtciudad_id');
            $grupo->entidad->nombre        = $request->input('txtnombre');
            $grupo->entidad->slug        = str_slug($request->input('nombre') . str_random(7), '-');
            $grupo->entidad->email_entidad = $request->input('txtemail_entidad');
            $grupo->entidad->update();
            $grupo->clasificacioncolciencias_id = $request->input('txtclasificacionclociencias_id');
            $grupo->codigo_grupo                = strtoupper($request->input('txtcodigo_grupo'));
            $grupo->tipogrupo                   = $request->input('txttipogrupo');
            $grupo->institucion                 = $request->input('txtinstitucion');
            $grupo->update();
            return $grupo;
        });
    }

    // Registra un grupo de investigación en la base de datos
    public function store($request)
    {
        DB::transaction(function () use ($request) {
            $entidad = Entidad::create([
            'ciudad_id'     => $request->input('txtciudad_id'),
            'nombre'        => $request->input('txtnombre'),
            'slug'          => str_slug($request->input('nombre') . str_random(7), '-'),
            'email_entidad' => $request->input('txtemail_entidad'),
            ]);

            return GrupoInvestigacion::create([
                'entidad_id'                  => $entidad->id,
                'clasificacioncolciencias_id' => $request->input('txtclasificacionclociencias_id'),
                'codigo_grupo'                => strtoupper($request->input('txtcodigo_grupo')),
                'tipogrupo'                   => $request->input('txttipogrupo'),
                'estado'                      => GrupoInvestigacion::IsActive(),
                'institucion'                 => $request->input('txtinstitucion'),
            ]);
        });
    }

    public function getAllGruposInvestigacionesForCiudad($ciudad)
    {
        return Entidad::allGrupoInvestigacionForCiudad($ciudad)->pluck('nombre', 'id');
    }

    public function getAllGruposInvestigacionDatatables($ciudad)
    {
        return Entidad::select(['entidades.id', 'entidades.nombre', 'gruposinvestigacion.institucion', 'gruposinvestigacion.codigo_grupo'])
        ->join('gruposinvestigacion', 'gruposinvestigacion.entidad_id', 'entidades.id')
        ->where('entidades.ciudad_id', '=', $ciudad)->get();
    }


}
