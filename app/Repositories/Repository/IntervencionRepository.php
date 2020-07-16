<?php

namespace App\Repositories\Repository;

use App\Models\{Articulacion, ArticulacionProyecto};
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class IntervencionRepository
{
    /**
     * Consulta las intervenciones a empresas de un nodo
     * @param int $id Id del nodo
     * @param string $anho Año para filtrar las intervenciones a empresas del nodo
     * @return Collection
     * @author devjul
     */
    public function consultarIntervencionesAEmpresasDeUnNodo($id, $anho)
    {
        return Articulacion::select(
            'codigo_actividad AS codigo_articulacion',
            'actividades.nombre',
            'articulaciones.id',
            'observaciones',
            'fecha_inicio',
            'fecha_cierre',
            'tiposarticulaciones.nombre AS tipoarticulacion'
        )
            ->selectRaw('IF(tipo_articulacion = ' . Articulacion::IsEmpresa() . ', "Empresa", "No Aplica") AS tipo_articulacion')
            ->selectRaw('IF(articulaciones.estado = ' . Articulacion::IsInicio() . ', "Inicio", IF(articulaciones.estado = ' . Articulacion::IsEjecucion() . ', "Ejecución", "Cierre") ) AS estado')
            ->selectRaw('IF(revisado_final = ' . ArticulacionProyecto::IsPorEvaluar() . ', "Por Evaluar", IF(revisado_final = ' . ArticulacionProyecto::IsAprobado() . ', "Aprobado", "No Aprobado") ) AS revisado_final')
            ->selectRaw('CONCAT(users.documento, " - ", users.nombres, " ", users.apellidos) AS nombre_completo_gestor')
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
            ->where('tipo_articulacion', Articulacion::IsEmpresa())
            ->where(function ($q) use ($anho) {
                $q->where(function ($query) use ($anho) {
                    $query->whereYear('fecha_inicio', '=', $anho);
                })
                    ->orWhere(function ($query) use ($anho) {
                        $query->whereYear('fecha_cierre', '=', $anho);
                    });
            })
            ->get();
    }


    /**
     * Consulta las articulaciones de un gestor
     * @param int $id Id del gestor
     * @param string $anho Año para realizar el filtro
     * @return Collection
     * @author dum
     */
    public function consultarIntervencionesDeUnGestor($id, $anho)
    {
        return Articulacion::select(
            'codigo_actividad AS codigo_articulacion',
            'actividades.nombre',
            'articulaciones.id',
            'observaciones',
            'fecha_inicio',
            'fecha_cierre',
            'tiposarticulaciones.nombre AS tipoarticulacion'
        )
            ->selectRaw('IF(tipo_articulacion = ' . Articulacion::IsEmpresa() . ', "Empresa", "No Aplica") AS tipo_articulacion')
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
            ->where('tipo_articulacion', Articulacion::IsEmpresa())
            ->whereYear('fecha_inicio', $anho)
            ->get();
    }


    /**
     * Consulta información de una articulacio por id
     * @param int $id Id de la articulació
     * @return Collection
     * @author dum
     */
    public function consultarIntervencionPorId($id)
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
}
