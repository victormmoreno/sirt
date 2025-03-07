<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\AsesorieTrait\{AsesorieTrait, HasProject, HasArticulation, HasIdea, HasDevice, HasMaterial, HasUser};
use App\User;
use Illuminate\Support\Facades\DB;

class UsoInfraestructura extends Model
{
    use AsesorieTrait, HasProject, HasArticulation, HasIdea, HasDevice, HasMaterial, HasUser;

    const IS_PROYECTO     = 0;
    const IS_ARTICULACION = 1;
    const IS_IDEA          = 2;

    protected $table = 'usoinfraestructuras';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'asesorable_id',
        'asesorable_type',
        'codigo',
        'fecha',
        'descripcion',
        'compromisos',
        'estado',
    ];

    protected $dates = ['fecha'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'tipo_usoinfraestructura' => 'integer',
        'fecha'                   => 'date:Y-m-d',
        'descripcion'             => 'string',
        'compromisos'             => 'string',
        'estado'                  => 'boolean',
    ];



    public function scopeSelectAsesoria($query, $module){
        if ((!empty($module) && $module != null && $module != 'all')) {
            switch ($module){
                case class_basename(Proyecto::class):
                    return $query
                    ->select('usoinfraestructuras.id', 'usoinfraestructuras.codigo','usoinfraestructuras.fecha as fecha', 'entidades.nombre as nodo')
                        ->selectRaw("faseproyecto.nombre as fase, concat(proyectos.codigo_proyecto, ' - ', proyectos.nombre) as nombre, if(usoinfraestructuras.asesorable_type='App\\\Models\\\Proyecto', 'Proyecto', 'No registra') as tipo_asesoria,
                        GROUP_CONCAT(DISTINCT CONCAT(asesores.documento, ' - ', asesores.nombres, ' ', asesores.apellidos) SEPARATOR ';') as asesores,
                        GROUP_CONCAT(DISTINCT CONCAT(participants.documento, ' - ', participants.nombres, ' ', participants.apellidos) SEPARATOR ';') as participants,
                        sum(gestor_uso.asesoria_directa) as aseseria_directa, sum(gestor_uso.asesoria_indirecta) as asesoria_indirecta");
                    break;
                case class_basename(Articulation::class):
                    return $query->select('usoinfraestructuras.id', 'usoinfraestructuras.codigo','usoinfraestructuras.fecha', 'entidades.nombre as nodo')
                        ->selectRaw("fasearticulation.nombre as fase, concat(articulations.code, ' - ',articulations.name) as nombre, if(usoinfraestructuras.asesorable_type='App\\\Models\\\Articulation', 'Articulación', 'No registra') as tipo_asesoria,
                        GROUP_CONCAT(DISTINCT CONCAT(asesores.documento, ' - ', asesores.nombres, ' ', asesores.apellidos) SEPARATOR ';') as asesores,
                        GROUP_CONCAT(DISTINCT CONCAT(participants.documento, ' - ', participants.nombres, ' ', participants.apellidos) SEPARATOR ';') as participants,
                        sum( gestor_uso.asesoria_directa) as aseseria_directa, sum(gestor_uso.asesoria_indirecta) as asesoria_indirecta");
                    break;
                case class_basename(Idea::class):
                    return $query->select('usoinfraestructuras.id', 'usoinfraestructuras.codigo', 'usoinfraestructuras.fecha', 'entidades.nombre as nodo')
                        ->selectRaw("estadosidea.nombre as fase, concat(ideas.codigo_idea, ' - ',ideas.nombre_proyecto) as nombre, if(usoinfraestructuras.asesorable_type='App\\\Models\\\Idea', 'Idea', 'No registra') as tipo_asesoria,
                        GROUP_CONCAT(DISTINCT CONCAT(asesores.documento, ' - ', asesores.nombres, ' ', asesores.apellidos)  SEPARATOR ';') as asesores,
                        GROUP_CONCAT(DISTINCT CONCAT(participants.documento, ' - ', participants.nombres, ' ', participants.apellidos) SEPARATOR ';') as talentos,
                        sum(gestor_uso.asesoria_directa) as aseseria_directa, sum(gestor_uso.asesoria_indirecta) as asesoria_indirecta");
                    break;
                case class_basename(UsoInfraestructura::class):
                    return $query->select('usoinfraestructuras.id', 'usoinfraestructuras.codigo', 'usoinfraestructuras.descripcion as nombre', 'usoinfraestructuras.fecha')
                    ->selectRaw("GROUP_CONCAT(DISTINCT CONCAT(asesores.documento, ' - ', asesores.nombres, ' ', asesores.apellidos)  SEPARATOR ';') as asesores,
                        GROUP_CONCAT(DISTINCT CONCAT(participants.documento, ' - ', participants.nombres, ' ', participants.apellidos) SEPARATOR ';') as talentos,
                        sum(gestor_uso.asesoria_directa) as aseseria_directa, sum(gestor_uso.asesoria_indirecta) as asesoria_indirecta");
                    break;
                default:
                    return $query;
                    break;
            }
        }
        return "No registra";
    }


    /**
     * The query scope participants
     *
     * @return void
     */
    public function scopeAsesor($query, $module, $asesor = null)
    {
        if ((!empty($module) && $module != null && $module != 'all')) {
            if (!empty($asesor) && $asesor != null && $asesor != 'all') {
                switch ($module){
                    case class_basename(Proyecto::class):

                        if((session()->has('login_role') && session()->get('login_role') == User::IsTalento())){
                            return $query->where('uso_talentos.user_id', $asesor);
                        }
                        return $query->where('gestor_uso.asesor_id', $asesor);
                        break;
                    case class_basename(Articulation::class):
                        if((session()->has('login_role') && session()->get('login_role') == User::IsTalento())){
                            return $query->where('uso_talentos.user_id', $asesor);
                        }
                        return $query->where('gestor_uso.asesor_id', $asesor);
                        break;
                    case class_basename(Idea::class):
                        if((session()->has('login_role') && session()->get('login_role') == User::IsTalento())){
                            return $query->where('uso_talentos.user_id', $asesor);
                        }
                        return $query->where('gestor_uso.asesorable_id', $asesor);
                        break;
                    default:
                        return $query;
                        break;
                }
            }
            return $query;
        }
        return $query;
    }

    /**
     * The query scope participants
     *
     * @return void
     */
    public function scopeOnlyAsesor($query, $asesor = null)
    {
        if (!empty($asesor) && $asesor != null && $asesor != 'all') {
            return $query->where('gestor_uso.asesor_id', $asesor);
        }
        return $query;
    }

    /**
     * The query scope BetweenDate
     *
     * @return void
     */
    public function scopeBetweenDate($query, $start_date, $end_date)
    {
        if ((isset($start_date) && $start_date != null) || (isset($end_date) && $end_date != null) ){
            return $query->whereBetween('usoinfraestructuras.fecha', [$start_date, $end_date]);
        }
        return $query;
    }

    /**
     * The query scope node
     *
     * @return void
     */
    public function scopeNode($query, $module, $nodes)
    {
        if (isset($module) && $module != null && $module != 'all') {
            if (isset($nodes) && (!collect($nodes)->contains('all'))) {
                switch ($module){
                    case class_basename(Proyecto::class):
                        return $query->whereIn('proyectos.nodo_id', $nodes);
                        break;
                    case class_basename(Articulation::class):
                        return $query->whereIn('articulation_stages.node_id', $nodes);
                        break;
                    case class_basename(Idea::class):
                        return $query->whereIn('ideas.nodo_id', $nodes);
                        break;
                    default:
                        return $query;
                        break;
                }
            }
            return $query;
        }
        return $query;
    }

    public function scopeGroupedBy($query, $field_group) {
        if ($field_group == null || $field_group == '') {
            return $query->groupBy($field_group);
        }
        return $query;
    }

    /**
     * The query scope node
     *
     * @return void
     */
    public function scopeOnlyNode($query, $nodo, $bandera = true)
    {
        if (isset($nodo) && ($nodo != 'all' && $nodo != null && $nodo != 0)) {
            if ($bandera) {
                return $query->where('proyectos.nodo_id', $nodo);
            }
            return $query;
        }
        // if (isset($nodes) && (!collect($nodes)->contains('all'))) {
        //     return $query->whereIn('proyectos.nodo_id', $nodes);
        // }
        // if (request()->user()->getNodoUser() == null) {
        //     return $query->where('proyectos.nodo_id', $nodes);
        // }
        return $query;
    }

    public function scopeJoins($query, $module)
    {
        if ((!empty($module) && $module != null && $module != 'all')) {
            switch ($module){
                case class_basename(Proyecto::class):
                    return $this->getJoinWithProjects($query);
                    break;
                case class_basename(Articulation::class):
                    return $this->getJoinWithArticulations($query);
                    break;
                case class_basename(Idea::class):
                    return $this->getJoinWithIdeas($query);
                    break;
                case class_basename(UsoInfraestructura::class):
                    return $query;
                    break;
                default:
                    return $query;
                    break;
            }
        }
        return $query;
    }

    private function getJoinWithProjects($query){
        return $query
            ->join('proyectos', function ($join) {
                $join->on('proyectos.id', '=', 'usoinfraestructuras.asesorable_id')
                    ->where('usoinfraestructuras.asesorable_type', Proyecto::class);
            })->leftJoin('fases as faseproyecto', function ($join) {
                $join->on('faseproyecto.id', '=', 'proyectos.fase_id');
            })->join('nodos', function ($join) {
                $join->on('nodos.id', '=', 'proyectos.nodo_id');
            })
            ->leftJoin('entidades', function ($join) {
                $join->on('entidades.id', '=', 'nodos.entidad_id');
            });
    }

    private function getJoinWithArticulations($query){
        return $query
            ->join('articulations', function ($join) {
                $join->on('articulations.id', '=', 'usoinfraestructuras.asesorable_id')
                    ->where('usoinfraestructuras.asesorable_type', Articulation::class);
            })
            ->leftJoin('fases as fasearticulation', function ($join) {
                $join->on('fasearticulation.id', '=', 'articulations.phase_id');
            })
            ->join('articulation_stages', function ($join) {
                $join->on('articulation_stages.id', '=', 'articulations.articulation_stage_id');
            })->join('nodos', function ($join) {
                $join->on('nodos.id', '=', 'articulation_stages.node_id');
            })->join('entidades', function ($join) {
                $join->on('entidades.id', '=', 'nodos.entidad_id');
            });
    }

    private function getJoinWithIdeas($query){
        return $query
            ->join('ideas', function ($join) {
                $join->on('ideas.id', '=', 'usoinfraestructuras.asesorable_id')
                    ->where('usoinfraestructuras.asesorable_type', \App\Models\Idea::class);
            })->leftJoin('estadosidea as estadosidea', function ($join) {
                $join->on('estadosidea.id', '=', 'ideas.estadoidea_id');
            })->join('nodos', function ($join) {
                $join->on('nodos.id', '=', 'ideas.nodo_id');
            })
            ->leftJoin('entidades', function ($join) {
                $join->on('entidades.id', '=', 'nodos.entidad_id');
            });
    }







}
