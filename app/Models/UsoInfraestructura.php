<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\Proyecto;
use App\Models\Articulation;
use App\Models\Idea;
use App\Presenters\UsoInfraestructuraPresenter;
use Illuminate\Support\Facades\DB;

class UsoInfraestructura extends Model
{
    protected $table = 'usoinfraestructuras';

    const IS_PROYECTO     = 0;
    const IS_ARTICULACION = 1;
    const IS_IDEA          = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'asesorable_id',
        'asesorable_type',
        'tipo_usoinfraestructura',
        'fecha',
        'descripcion',
        'compromisos',
        'estado',
    ];

    protected $dates = [
        'fecha',
    ];

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

    public static function IsProyecto()
    {
        return self::IS_PROYECTO;
    }

    public static function IsArticulacion()
    {
        return self::IS_ARTICULACION;
    }

    public static function IsIdea()
    {
        return self::IS_IDEA;
    }

    public function asesorable()
    {
        return $this->morphTo();
    }


    public function actividad()
    {
        return $this->belongsTo(Actividad::class, 'actividad_id', 'id');
    }

    public function usoequipos()
    {
        return $this->belongsToMany(Equipo::class, 'equipo_uso', 'usoinfraestructura_id', 'equipo_id')
            ->withTimestamps()
            ->withPivot([
                'tiempo',
                'costo_equipo',
                'costo_administrativo',
            ]);
    }

    public function usomateriales()
    {
        return $this->belongsToMany(Material::class, 'material_uso', 'usoinfraestructura_id', 'material_id')
            ->withTimestamps()
            ->withPivot([
                'costo_material',
                'unidad',
            ]);
    }

    public function usotalentos()
    {
        return $this->belongsToMany(Talento::class, 'uso_talentos', 'usoinfraestructura_id', 'user_id')
            ->withTimestamps();
    }


    public function usogestores()
    {
        return $this->belongsToMany(User::class, 'gestor_uso', 'usoinfraestructura_id', 'asesor_id')->withTimestamps()
        ->withPivot([
            'asesoria_directa',
            'asesoria_indirecta',
            'costo_asesoria',
        ])->withTrashed();
    }

    public function setDescripcionAttribute($descripcion)
    {
        $this->attributes['descripcion'] = ucwords(mb_strtolower(trim($descripcion), 'UTF-8'));
    }

    public function getDescripcionAttribute($descripcion)
    {
        return ucwords(strtolower(trim($descripcion)));
    }

    /**
     * Elimina los datos de material_uso
     *
     * @param Collection $data
     * @return void
     */
    public static function deleteUsoMateriales($data)
    {
        foreach ($data->usoinfraestructuras as $key => $value) {
            $value->usomateriales()->sync([]);
        }
    }


    /**
     * Elimina los datos de uso_talento
     *
     * @param Collection $data
     * @return void
     */
    public static function deleteUsoTalentos($data)
    {
        foreach ($data->usoinfraestructuras as $key => $value) {
            $value->usotalentos()->sync([]);
        }
    }

    /**
     * Elimina los datos de equipo_uso
     *
     * @param Collection $data
     * @return void
     */
    public static function deleteUsoEquipos($data)
    {
        foreach ($data->usoinfraestructuras as $key => $value) {
            $value->usoequipos()->sync([]);
        }
    }

    /**
     * Elimina los datos de gestor_uso
     *
     * @param Collection $data
     * @return void
     */
    public static function deleteUsoGestores($data)
    {
        foreach ($data->usoinfraestructuras as $key => $value) {
            $value->usogestores()->sync([]);
        }
    }

    public static function TipoUsoInfraestructura($tipo_usoinfraestructura)
    {
        if ($tipo_usoinfraestructura == self::IsProyecto()) {
            return 'Proyecto ';
        } else if ($tipo_usoinfraestructura == self::IsArticulacion()) {
            return 'Articulación ';
        } else {
            return 'No registra';
        }
    }

    public function scopeUsoInfraestructuraWithRelations($query, array $relations)
    {
        return $query->with($relations);
    }


    public function scopeSelectAsesoria($query, $module){
        if ((!empty($module) && $module != null && $module != 'all')) {
            switch ($module){
                case class_basename(Proyecto::class):
                    return $query
                    ->select('usoinfraestructuras.id', 'usoinfraestructuras.fecha as fecha', 'entidades.nombre as nodo')
                        ->selectRaw("faseproyecto.nombre as fase, concat(proyectos.codigo_proyecto, ' - ', proyectos.nombre) as nombre, if(usoinfraestructuras.asesorable_type='App\\\Models\\\Proyecto', 'Proyecto', 'No registra') as tipo_asesoria,
                        GROUP_CONCAT(DISTINCT CONCAT(asesores.documento, ' - ', asesores.nombres, ' ', asesores.apellidos) SEPARATOR ';') as asesores,
                        GROUP_CONCAT(DISTINCT CONCAT(talents.documento, ' - ', talents.nombres, ' ', talents.apellidos) SEPARATOR ';') as talentos,
                        GROUP_CONCAT(DISTINCT CONCAT(equipos.referencia, ' - ', equipos.nombre) SEPARATOR ';') as equipos,
                        GROUP_CONCAT(DISTINCT CONCAT(materiales.codigo_material, ' - ', materiales.nombre) SEPARATOR ';') as materiales,
                        sum(gestor_uso.asesoria_directa) as aseseria_directa, sum(gestor_uso.asesoria_indirecta) as asesoria_indirecta");
                    break;
                case class_basename(Articulation::class):
                    return $query->select('usoinfraestructuras.id', 'usoinfraestructuras.fecha', 'entidades.nombre as nodo')
                        ->selectRaw("fasearticulation.nombre as fase, concat(articulations.code, ' - ',articulations.name) as nombre, if(usoinfraestructuras.asesorable_type='App\\\Models\\\Articulation', 'Articulación', 'No registra') as tipo_asesoria,
                        sum( gestor_uso.asesoria_directa) as aseseria_directa, sum(gestor_uso.asesoria_indirecta) as asesoria_indirecta,
                        GROUP_CONCAT(DISTINCT CONCAT(asesores.documento, ' - ', asesores.nombres, ' ', asesores.apellidos) SEPARATOR ';') as asesores,
                        GROUP_CONCAT(DISTINCT CONCAT(talents.documento, ' - ', talents.nombres, ' ', talents.apellidos) SEPARATOR ';') as talentos,
                        GROUP_CONCAT(DISTINCT CONCAT(equipos.referencia, ' - ', equipos.nombre) SEPARATOR ';') as equipos,
                        GROUP_CONCAT(DISTINCT CONCAT(materiales.codigo_material, ' - ', materiales.nombre) SEPARATOR ';') as materiales");
                    break;
                case class_basename(Idea::class):
                    return $query->select('usoinfraestructuras.id', 'usoinfraestructuras.fecha', 'entidades.nombre as nodo')
                        ->selectRaw("estadosidea.nombre as fase, concat(ideas.codigo_idea, ' - ',ideas.nombre_proyecto) as nombre, if(usoinfraestructuras.asesorable_type='App\\\Models\\\Idea', 'Idea', 'No registra') as tipo_asesoria,
                        sum(gestor_uso.asesoria_directa) as aseseria_directa, sum(gestor_uso.asesoria_indirecta) as asesoria_indirecta,
                        GROUP_CONCAT(DISTINCT CONCAT(asesores.documento, ' - ', asesores.nombres, ' ', asesores.apellidos)  SEPARATOR ';') as asesores,
                        GROUP_CONCAT(DISTINCT CONCAT(talents.documento, ' - ', talents.nombres, ' ', talents.apellidos) SEPARATOR ';') as talentos,
                        GROUP_CONCAT(DISTINCT CONCAT(equipos.referencia, ' - ', equipos.nombre) SEPARATOR ';') as equipos,
                        GROUP_CONCAT(DISTINCT CONCAT(materiales.codigo_material, ' - ', materiales.nombre) SEPARATOR ';') as materiales");
                    break;
                default:
                    return "No registra";
                    break;
            }
        }
        return "No registra";
    }
    public function scopeNodoAsesoriaQuery($query, $module, $nodo)
    {
        if (isset($module) && $module != null && $module != 'all') {
            if (isset($nodo) && $nodo != null && $nodo != 'all') {
                switch ($module){
                    case class_basename(Proyecto::class):
                        return $query->where('proyectos.nodo_id', $nodo);
                        break;
                    case class_basename(Articulation::class):
                        return $query->where('articulation_stages.node_id', $nodo);
                        break;
                    case class_basename(Idea::class):
                        return $query->where('ideas.nodo_id', $nodo);
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



    public function scopeAsesorQuery($query, $module, $asesor = null)
    {

        if ((!empty($module) && $module != null && $module != 'all')) {
            if (!empty($asesor) && $asesor != null && $asesor != 'all') {
                switch ($module){
                    case class_basename(Proyecto::class):
                        if((session()->has('login_role') && session()->get('login_role') == User::IsTalento())){
                            return $query->where('talents.id', $asesor);
                        }
                        return $query->where('gestor_uso.asesor_id', $asesor);
                        break;
                    case class_basename(Articulation::class):
                        if((session()->has('login_role') && session()->get('login_role') == User::IsTalento())){
                            return $query->where('talents.id', $asesor);
                        }
                        return $query->where('gestor_uso.asesor_id', $asesor);
                        break;
                    case class_basename(Idea::class):
                        if((session()->has('login_role') && session()->get('login_role') == User::IsTalento())){
                            return $query->where('talents.id', $asesor);
                        }
                        return $query->where('gestor_uso.asesor_id', $asesor);
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

    private function getJoinWithProjects($query){
        return $query
            ->join('proyectos', function ($join) {
                $join->on('proyectos.id', '=', 'usoinfraestructuras.asesorable_id')
                    ->where('usoinfraestructuras.asesorable_type', Proyecto::class);
            })->leftJoin('fases as faseproyecto', function ($join) {
                $join->on('faseproyecto.id', '=', 'proyectos.fase_id');
            })->leftJoin('gestor_uso', function ($join) {
                $join->on('gestor_uso.usoinfraestructura_id', '=', 'usoinfraestructuras.id');
            })
            ->leftJoin('users as asesores', function ($join) {
                $join->on('asesores.id', '=', 'gestor_uso.asesor_id');
            })->leftJoin('uso_talentos', function ($join) {
                $join->on('uso_talentos.usoinfraestructura_id', '=', 'usoinfraestructuras.id');
            })->leftJoin('users as talents', function ($join) {
                $join->on('talents.id', '=', 'uso_talentos.user_id');
            })->join('nodos', function ($join) {
                $join->on('nodos.id', '=', 'proyectos.nodo_id');
            })
            ->leftJoin('entidades', function ($join) {
                $join->on('entidades.id', '=', 'nodos.entidad_id');
            })->leftJoin('equipo_uso', function ($join) {
                $join->on('equipo_uso.usoinfraestructura_id', '=', 'usoinfraestructuras.id');
            })->leftJoin('equipos', function ($join) {
                $join->on('equipos.id', '=', 'equipo_uso.equipo_id');
            })->leftJoin('material_uso', function ($join) {
                $join->on('material_uso.usoinfraestructura_id', '=', 'usoinfraestructuras.id');
            })->leftJoin('materiales', function ($join) {
                $join->on('materiales.id', '=', 'material_uso.material_id');
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
            })->join('gestor_uso', function ($join) {
                $join->on('gestor_uso.usoinfraestructura_id', '=', 'usoinfraestructuras.id');
            })
            ->leftJoin('users as asesores', function ($join) {
                $join->on('asesores.id', '=', 'gestor_uso.asesor_id');
            })->leftJoin('uso_talentos', function ($join) {
                $join->on('uso_talentos.usoinfraestructura_id', '=', 'usoinfraestructuras.id');
            })->leftJoin('users as talents', function ($join) {
                $join->on('talents.id', '=', 'uso_talentos.user_id');
            })->join('nodos', function ($join) {
                $join->on('nodos.id', '=', 'articulation_stages.node_id');
            })
            ->leftJoin('entidades', function ($join) {
                $join->on('entidades.id', '=', 'nodos.entidad_id');
            })->leftJoin('equipo_uso', function ($join) {
                $join->on('equipo_uso.usoinfraestructura_id', '=', 'usoinfraestructuras.id');
            })->leftJoin('equipos', function ($join) {
                $join->on('equipos.id', '=', 'equipo_uso.equipo_id');
            })->leftJoin('material_uso', function ($join) {
                $join->on('material_uso.usoinfraestructura_id', '=', 'usoinfraestructuras.id');
            })->leftJoin('materiales', function ($join) {
                $join->on('materiales.id', '=', 'material_uso.material_id');
            });
    }
    private function getJoinWithIdeas($query){
        return $query
            ->join('ideas', function ($join) {
                $join->on('ideas.id', '=', 'usoinfraestructuras.asesorable_id')
                    ->where('usoinfraestructuras.asesorable_type', \App\Models\Idea::class);
            })->leftJoin('estadosidea as estadosidea', function ($join) {
                $join->on('estadosidea.id', '=', 'ideas.estadoidea_id');
            })->join('gestor_uso', function ($join) {
                $join->on('gestor_uso.usoinfraestructura_id', '=', 'usoinfraestructuras.id');
            })
            ->leftJoin('users as asesores', function ($join) {
                $join->on('asesores.id', '=', 'gestor_uso.asesor_id');
            })->leftJoin('uso_talentos', function ($join) {
                $join->on('uso_talentos.usoinfraestructura_id', '=', 'usoinfraestructuras.id');
            })->leftJoin('users as talents', function ($join) {
                $join->on('talents.id', '=', 'uso_talentos.user_id');
            })->join('nodos', function ($join) {
                $join->on('nodos.id', '=', 'ideas.nodo_id');
            })
            ->leftJoin('entidades', function ($join) {
                $join->on('entidades.id', '=', 'nodos.entidad_id');
            })->leftJoin('equipo_uso', function ($join) {
                $join->on('equipo_uso.usoinfraestructura_id', '=', 'usoinfraestructuras.id');
            })->leftJoin('equipos', function ($join) {
                $join->on('equipos.id', '=', 'equipo_uso.equipo_id');
            })->leftJoin('material_uso', function ($join) {
                $join->on('material_uso.usoinfraestructura_id', '=', 'usoinfraestructuras.id');
            })->leftJoin('materiales', function ($join) {
                $join->on('materiales.id', '=', 'material_uso.material_id');
            });
    }

    public function scopeYearAsesoriaQuery($query, $module, $year)
    {
        if ((!empty($module) && $module != null && $module != 'all')) {
            if((!empty($year) && $year != null && $year != 'all')){
                switch ($module){
                    case class_basename(Proyecto::class):
                        return $query->where(function($subquery) use($year){
                            $subquery->whereYear('usoinfraestructuras.fecha', $year);
                            // ->orWhereYear('usoinfraestructuras.created_at', $year)
                            // ->orWhereYear('usoinfraestructuras.updated_at', $year);
                        });
                            //->orWhereYear('actividades.fecha_inicio', $year)
                            //->orWhereYear('actividades.fecha_cierre', $year);
                        break;
                    case class_basename(Articulation::class):
                        return $query->where(function($subquery) use($year){
                            $subquery->whereYear('usoinfraestructuras.fecha', $year);
                            // ->orWhereYear('usoinfraestructuras.created_at', $year)
                            // ->orWhereYear('usoinfraestructuras.updated_at', $year);
                        });
                            // ->orWhereYear('articulations.start_date', $year)
                            // ->orWhereYear('articulations.end_date', $year);
                        break;
                    case class_basename(Idea::class):
                        return $query->where(function($subquery) use($year){
                            $subquery->whereYear('usoinfraestructuras.fecha', $year);
                            // ->orWhereYear('usoinfraestructuras.created_at', $year)
                            // ->orWhereYear('usoinfraestructuras.updated_at', $year);
                        });
                        break;
                    default:
                        return $query;
                        break;
                }
            }
            return $query;
        }
        return  $query;
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
                default:
                    return $query;
                    break;
            }
        }

    }

    public function present()
    {
        return new UsoInfraestructuraPresenter($this);
    }
}
