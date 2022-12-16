<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\Proyecto;
use App\Models\Articulation;
use App\Models\Idea;
use App\Presenters\UsoInfraestructuraPresenter;
use Illuminate\Database\Eloquent\Builder;

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
        return $this->belongsToMany(Talento::class, 'uso_talentos', 'usoinfraestructura_id', 'talento_id')
            ->withTimestamps();
    }


    public function usogestores()
    {
        return $this->morphedByMany(User::class, 'asesorable', 'gestor_uso', 'usoinfraestructura_id')->withTimestamps()
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

    public function scopeNodoAsesoria($query, $nodo)
    {
        if (isset($nodo) && $nodo != null && $nodo != 'all') {
            $query->whereHasMorph(
                'asesorable',
                [ \App\Models\Proyecto::class, \App\Models\Idea::class],
                function (Builder $subquery) use($nodo) {
                    $subquery->where('nodo_id', $nodo);
                }
            )->orWhereHasMorph(
                'asesorable',
                [ \App\Models\Articulation::class],
                function (Builder $subquery) use($nodo) {
                    $subquery->whereHas('articulationstage', function ($query) use ($nodo) {
                        $query->where('node_id', $nodo);
                    });
                }
            );
        }
        return $query;
    }
    public function scopeSelectAsesoria($query, $module){
        if ((!empty($module) && $module != null && $module != 'all')) {
            switch ($module){
                case class_basename(Proyecto::class):
                    return $query->select('usoinfraestructuras.id', 'usoinfraestructuras.fecha')
                                    ->selectRaw("concat(actividades.codigo_actividad, ' - ', actividades.nombre) as nombre, if(usoinfraestructuras.asesorable_type='App\\\Models\\\Proyecto', 'Proyecto', 'No registra') as tipo_asesoria, sum(gestor_uso.asesoria_directa) as aseseria_directa, sum(gestor_uso.asesoria_indirecta) as asesoria_indirecta, GROUP_CONCAT(DISTINCT CONCAT(asesores.documento, ' - ', asesores.nombres, ' ', asesores.apellidos) SEPARATOR ';') as asesores");
                    break;
                case class_basename(Articulation::class):
                    return $query->select('usoinfraestructuras.id', 'usoinfraestructuras.fecha')
                        ->selectRaw("concat(articulations.code, ' - ',articulations.name) as nombre, if(usoinfraestructuras.asesorable_type='App\\\Models\\\Articulation', 'Articulación', 'No registra') as tipo_asesoria, sum(gestor_uso.asesoria_directa) as aseseria_directa, sum(gestor_uso.asesoria_indirecta) as asesoria_indirecta, GROUP_CONCAT(DISTINCT CONCAT(asesores.documento, ' - ', asesores.nombres, ' ', asesores.apellidos) SEPARATOR ';') as asesores");
                    break;
                case class_basename(Idea::class):
                    return $query->select('usoinfraestructuras.id', 'usoinfraestructuras.fecha')
                        ->selectRaw("concat(ideas.codigo_idea, ' - ',ideas.nombre_proyecto) as nombre, if(usoinfraestructuras.asesorable_type='App\\\Models\\\Idea', 'Idea', 'No registra') as tipo_asesoria, sum(gestor_uso.asesoria_directa) as aseseria_directa, sum(gestor_uso.asesoria_indirecta) as asesoria_indirecta, GROUP_CONCAT(DISTINCT CONCAT(asesores.documento, ' - ', asesores.nombres, ' ', asesores.apellidos)  SEPARATOR ';') as asesores");
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
        if ((!empty($module) && $module != null && $module != 'all')) {
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



    public function scopeAsesoria($query, $actividad, $user)
    {   if ((session()->has('login_role') && session()->get('login_role') == User::IsArticulador()) && (!empty($user) && $user != null && $user != 'all')) {
            if ((!empty($actividad) && $actividad != null && $actividad != 'all')) {
                $query->whereHasMorph(
                    'asesorable',
                    [\App\Models\Articulation::class, \App\Models\Idea::class],
                    function (Builder $subquery) use($actividad, $user) {
                        return $subquery->where('id', $actividad)
                        ->orWhereHas('asesor', function ($subquery) use ($user) {
                            $subquery->where('id', $user);
                        });
                    }
                )->whereHasMorph('asesorable', [\App\Models\Articulation::class, \App\Models\Idea::class]);
            } elseif ((!empty($actividad) && $actividad != null && $actividad == 'all')) {
                $query->whereHasMorph(
                    'asesorable.asesor',
                    [\App\Models\ArticulacionPbt::class, \App\Models\Idea::class],
                    function (Builder $subquery) use( $user) {
                        return $subquery->where('id', $user);
                    }
                )->whereHasMorph('asesorable', [\App\Models\Articulation::class, \App\Models\Idea::class]);

            }
        }
        else if ((session()->has('login_role') && session()->get('login_role') == User::IsGestor()) && (!empty($user) && $user != null && $user != 'all')) {
            if ((!empty($actividad) && $actividad != null && $actividad != 'all')) {
                $query->whereHasMorph(
                    'asesorable',
                    [ \App\Models\Proyecto::class],
                    function (Builder $subquery) use($actividad, $user) {
                        return $subquery->whereHas('articulacion_proyecto.actividad', function($q) use($actividad){
                            $q->where('id', $actividad);
                        })
                        ->whereHas('asesor.user', function ($subquery) use ($user) {
                            $subquery->where('id', $user);
                        });
                    }
                )->whereHasMorph('asesorable', \App\Models\Proyecto::class);
            } elseif ((!empty($actividad) && $actividad != null && $actividad == 'all')) {
                $query->whereHasMorph(
                    'asesorable',
                    [ \App\Models\Proyecto::class],
                    function (Builder $subquery) use( $user) {
                        return $subquery->whereHas('asesor.user', function ($subquery) use ($user) {
                            $subquery->where('id', $user);
                        });
                    }
                )->whereHasMorph('asesorable', \App\Models\Proyecto::class);
            }
        } else if ((session()->has('login_role') && session()->get('login_role') == User::IsTalento()) && (!empty($user) && $user != null && $user != 'all')) {
            if ((!empty($actividad) && $actividad != null && $actividad != 'all')) {
                return $query->whereHas(
                    'usotalentos.user',
                    function (Builder $query) use($user) {
                        return $query->where('id', $user);
                    }
                )->whereHasMorph('asesorable', \App\Models\Proyecto::class);
            } elseif ((!empty($actividad) && $actividad != null && $actividad == 'all')) {
                return $query->whereHas('usotalentos.user',  function ($subquery) use ($user) {
                    $subquery->where('id', $user);
                })->whereHasMorph('asesorable', \App\Models\Proyecto::class);
            } elseif ((!empty($actividad) && $actividad == null && $actividad != 'all')) {
                return $query->whereHas('usotalentos.user',  function ($subquery) use ($user) {
                    $subquery->where('id', $user);
                })->whereHasMorph('asesorable', \App\Models\Proyecto::class);
            }
        }
        return $query;
    }

    public function scopeAsesor($query, $asesor = null)
    {
        if (!empty($asesor) && $asesor != null && $asesor == 'all') {
            return $query->whereHasMorph(
                'asesorable',
                [ \App\Models\Proyecto::class, \App\Models\Articulation::class, \App\Models\Idea::class]
            );
        }

        if ((!empty($asesor) && $asesor != null && $asesor != 'all')) {

            if((session()->has('login_role') && session()->get('login_role') == User::IsArticulador())){
                return $query->whereHas(
                    'usogestores',
                    function (Builder $query) use($asesor) {
                        return $query->where('users.id', $asesor);
                    }
                )->whereHasMorph('asesorable', [\App\Models\Articulation::class, \App\Models\Idea::class]);
            }
            if((session()->has('login_role') && (session()->get('login_role') == User::IsApoyoTecnico() || session()->get('login_role') == User::IsGestor()))){
                return $query->whereHas(
                    'usogestores',
                    function (Builder $query) use($asesor) {
                        return $query->where('users.id', $asesor);
                    }
                )->whereHasMorph('asesorable', \App\Models\Proyecto::class);
            }
            return $query->whereHas(
                'usogestores',
                function (Builder $query) use($asesor) {
                    return $query->where('users.id', $asesor);
                }
            );
        }
        return $query;
    }

    private function getLeftJoinWithModules($query){
        return $query
            ->leftJoin('proyectos', function ($join) {
                $join->on('proyectos.id', '=', 'usoinfraestructuras.asesorable_id')
                    ->where('usoinfraestructuras.asesorable_type', Proyecto::class);
            })->leftJoin('articulacion_proyecto', function ($join) {
                $join->on('articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id');
            })->leftJoin('actividades', function ($join)  {
                $join->on('actividades.id', '=', 'articulacion_proyecto.actividad_id');
            })->leftJoin('articulations', function ($join) {
                $join->on('articulations.id', '=', 'usoinfraestructuras.asesorable_id')
                    ->where('usoinfraestructuras.asesorable_type', Articulation::class);
            })->leftJoin('articulation_stages', function ($join) {
                $join->on('articulation_stages.id', '=', 'articulations.articulation_stage_id');
            })->leftJoin('ideas', function ($join) {
                    $join->on('ideas.id', '=', 'usoinfraestructuras.asesorable_id')
                        ->where('usoinfraestructuras.asesorable_type', Idea::class);
            })
            ->join('gestor_uso', function ($join) {
                $join->on('gestor_uso.usoinfraestructura_id', '=', 'usoinfraestructuras.id')
                    ->where('gestor_uso.asesorable_type', User::class);
            })
            ->join('users as asesores', function ($join) {
                $join->on('asesores.id', '=', 'gestor_uso.asesorable_id');
            });
    }

    private function getJoinWithProjects($query){
        return $query
            ->join('proyectos', function ($join) {
                $join->on('proyectos.id', '=', 'usoinfraestructuras.asesorable_id')
                    ->where('usoinfraestructuras.asesorable_type', Proyecto::class);
            })->join('articulacion_proyecto', function ($join) {
                $join->on('articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id');
            })->join('actividades', function ($join)  {
                $join->on('actividades.id', '=', 'articulacion_proyecto.actividad_id');
            })->join('gestor_uso', function ($join) {
                $join->on('gestor_uso.usoinfraestructura_id', '=', 'usoinfraestructuras.id')
                    ->where('gestor_uso.asesorable_type', User::class);
            })
            ->join('users as asesores', function ($join) {
                $join->on('asesores.id', '=', 'gestor_uso.asesorable_id');
            });
    }

    private function getJoinWithArticulations($query){
        return $query
            ->join('articulations', function ($join) {
                $join->on('articulations.id', '=', 'usoinfraestructuras.asesorable_id')
                    ->where('usoinfraestructuras.asesorable_type', Articulation::class);
            })
            ->join('articulation_stages', function ($join) {
                $join->on('articulation_stages.id', '=', 'articulations.articulation_stage_id');
            })->join('gestor_uso', function ($join) {
                $join->on('gestor_uso.usoinfraestructura_id', '=', 'usoinfraestructuras.id')
                    ->where('gestor_uso.asesorable_type', User::class);
            })
            ->join('users as asesores', function ($join) {
                $join->on('asesores.id', '=', 'gestor_uso.asesorable_id');
            });
    }
    private function getJoinWithIdeas($query){
        return $query
            ->join('ideas', function ($join) {
                $join->on('ideas.id', '=', 'usoinfraestructuras.asesorable_id')
                    ->where('usoinfraestructuras.asesorable_type', \App\Models\Idea::class);
            })->join('gestor_uso', function ($join) {
                $join->on('gestor_uso.usoinfraestructura_id', '=', 'usoinfraestructuras.id')
                    ->where('gestor_uso.asesorable_type', User::class);
            })
            ->join('users as asesores', function ($join) {
                $join->on('asesores.id', '=', 'gestor_uso.asesorable_id');
            });
    }

    public function scopeYearAsesoriaQuery($query, $module, $year)
    {
        if ((!empty($module) && $module != null && $module != 'all')) {
            if((!empty($year) && $year != null && $year != 'all')){
                switch ($module){
                    case class_basename(Proyecto::class):
                        return $query
                            ->whereYear('usoinfraestructuras.fecha', $year);
                            //->orWhereYear('actividades.fecha_inicio', $year)
                            //->orWhereYear('actividades.fecha_cierre', $year);
                        break;
                    case class_basename(Articulation::class):
                        return $query
                            ->whereYear('usoinfraestructuras.fecha', $year)
                            ->orWhereYear('articulations.start_date', $year)
                            ->orWhereYear('articulations.end_date', $year);
                        break;
                    case class_basename(Idea::class):
                        return $query
                            ->whereYear('usoinfraestructuras.fecha', $year);
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
        return  $this->getLeftJoinWithModules($query);

    }

    public function scopeYearAsesoria($query, $year)
    {
        if (!empty($year) && $year != null && $year == 'all') {
            return $query->whereHasMorph(
                'asesorable',
                [ \App\Models\Proyecto::class, \App\Models\Articulation::class, \App\Models\Idea::class]
            );
        }

        if ((!empty($year) && $year != null && $year != 'all')) {
            $query->whereHasMorph(
                'asesorable',
                [ \App\Models\Proyecto::class,  \App\Models\Idea::class],
                function (Builder $subquery) use($year) {
                    return $subquery->whereYear('fecha', $year)->orWhereYear('created_at', $year);
                }
            )->orWhereHasMorph(
                'asesorable',
                [ \App\Models\Articulation::class],
                function (Builder $subquery) use($year) {
                    return $subquery->whereYear('start_date', $year)->orWhereYear('created_at', $year);
                }
            );
        }
        return $query;
    }

    public function present()
    {
        return new UsoInfraestructuraPresenter($this);
    }
}
