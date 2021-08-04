<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\ArticulacionPbt;
use App\Presenters\ProyectoPresenter;

class Proyecto extends Model
{

    /**
     * the table name
     * @var string
     * @author dum
     */
    protected $table = 'proyectos';

    /**
     * Constant for the expected trl_field
     * @var int
     * @author dum
     */
    // Estado que indica que el trl esperado es 6
    const IS_TRL6_ESPERADO = 0;
    // Estado que indica que el trl esperado es 7 u 8
    const IS_TRL7_8_ESPERADO = 1;

    /**
     * Constante para el campo trl_obtenido
     * @var int
     * @author dum
     */
    const IS_TRL6_OBTENIDO = 0;
    const IS_TRL7_OBTENIDO = 1;
    const IS_TRL8_OBTENIDO = 2;

    /**
     * The attributes that are mass assignable.
     * @author dum
     * @var array
     */
    protected $fillable = [
        'articulacion_proyecto_id',
        'asesor_id',
        'nodo_id',
        'idea_id',
        'sublinea_id',
        'areaconocimiento_id',
        'economia_naranja',
        'art_cti',
        'nom_act_cti',
        'diri_ar_emp',
        'reci_ar_emp',
        'acc',
        'manual_uso_inf',
        'estado_arte',
        'alcance_proyecto',
        'tipo_economianaranja',
        'dirigido_discapacitados',
        'tipo_discapacitados',
        'otro_areaconocimiento',
        'trl_esperado',
        'trl_obtenido',
        'fase_id',
        'fabrica_productividad',
        'doc_titular',
        'trl_prototipo',
        'trl_pruebas',
        'trl_modelo',
        'trl_normatividad',
        'evidencia_trl'
    ];
    /**
     * returns the obtained trl
     * @author dum
     * @return int
     */
    public static function IsTrl6Obtenido()
    {
        return self::IS_TRL6_OBTENIDO;
    }

    /**
     * returns the obtained trl
     * @author dum
     * @return int
     */
    public static function IsTrl7Obtenido()
    {
        return self::IS_TRL7_OBTENIDO;
    }
    /**
     * returns the obtained trl
     * @author dum
     * @return int
     */
    public static function IsTrl8Obtenido()
    {
        return self::IS_TRL8_OBTENIDO;
    }
    /**
     * returns the obtained trl
     * @author dum
     * @return int
     */
    public static function IsTrl6Esperado()
    {
        return self::IS_TRL6_ESPERADO;
    }

    /**
     * returns the obtained trl
     * @author dum
     * @return int
     */
    public static function IsTrl78Esperado()
    {
        return self::IS_TRL7_8_ESPERADO;
    }

    /**
     * Define a polymorphic, inverse many-to-many relationship between projects and sedes
     * @author dum
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function sedes()
    {
        return $this->morphedByMany(Sede::class, 'propietario')->withTimestamps();
    }

    /**
     * Define an inverse one-to-one or many relationship between projects and users
     * @author devjul
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function asesor()
    {
        return $this->belongsTo(Gestor::class, 'asesor_id', 'id');
    }

    /**
     * Define an inverse one-to-one or many relationship between projects and node
     * @author devjul
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nodo()
    {
        return $this->belongsTo(Nodo::class, 'nodo_id', 'id');
    }

    /**
     * Define a polymorphic, inverse many-to-many relationship between projects and grupos de investigacion
     * @author dum
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function gruposinvestigacion()
    {
        return $this->morphedByMany(GrupoInvestigacion::class, 'propietario')->withTimestamps();
    }

    /**
     * Define a polymorphic, inverse many-to-many relationship between projects and users
     * @author dum
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function users_propietarios()
    {
        return $this->morphedByMany(User::class, 'propietario')->withTimestamps()->withTrashed();
    }

    /**
     * Define a polymorphic, inverse many-to-many relationship between proyectos and articulacion_pbt
     * @author dum
     * @return \Illuminate\Database\Eloquent\Relations\morphOne
     */
    public function articulacion()
    {
        return $this->morphOne(ArticulacionPbt::class,'articulable');
    }

    /**
     * Define an inverse one-to-one or many relationship between projects and users
     * @author dum
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function areaconocimiento()
    {
        return $this->belongsTo(AreaConocimiento::class, 'areaconocimiento_id', 'id');
    }

    /**
     * Define an inverse one-to-one or many relationship between projects and fases
     * @author dum
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fase()
    {
        return $this->belongsTo(Fase::class, 'fase_id', 'id');
    }

    /**
     * Define an inverse one-to-one or many relationship between projects and sublinea
     * @author dum
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sublinea()
    {
        return $this->belongsTo(Sublinea::class, 'sublinea_id', 'id');
    }

    /**
     * Define an inverse one-to-one or many relationship between projects and ideas
     * @author dum
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function idea()
    {
        return $this->belongsTo(Idea::class, 'idea_id', 'id');
    }

    public function usoinfraestructuras()
    {
        return $this->morphMany(UsoInfraestructura::class, 'asesorable');
    }

    /**
     * Define an inverse one-to-one or many relationship between projects and articulacion_proyecto
     * @author dum
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function articulacion_proyecto()
    {
        return $this->belongsTo(ArticulacionProyecto::class, 'articulacion_proyecto_id', 'id');
    }

    /**
     * Define a one-to-one relationship between projects and articulacionpbt
     * @author dum
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    // public function articulacionpbt()
    // {
    //     return $this->hasOne(ArticulacionPbt::class, 'proyecto_id', 'id');
    // }

    public function scopeEstadoOfProjects($query, array $relations, array $estado = [])
    {
        return $query->with($relations)->whereHas(
            'estadoproyecto',
            function ($query) use ($estado) {
                $query->whereIn('nombre', $estado);
            }
        );
    }

    public function scopeNodo($query, $nodo)
    {
        if (!empty($nodo) && $nodo != null && $nodo != 'all') {
            return $query->where('nodo_id', $nodo);
        }
        return $query;
    }

    public function scopeStarEndDate($query, $year)
    {
        if (!empty($year) && $year != null && $year != 'all') {
            return $query->whereHas('articulacion_proyecto.actividad', function ($subQuery) use ($year) {
                $subQuery->whereYear('fecha_inicio', $year)->orWhereYear('fecha_cierre', $year);
            });
        }
        return $query;
    }

    public function scopeFase($query, $fase)
    {
        if (!empty($fase) && $fase != 'all' && $fase != null) {
            return $query->where('fase_id', $fase);
        }
        return $query;
    }

    public function scopeProyectosGestor($query)
    {
        return $query->with(['articulacion_proyecto.actividad'])
            ->where(function($subquery){
                $subquery->where('fase_id', Fase::IsInicio())
                ->orwhere('fase_id', Fase::IsPlaneacion())
                ->orwhere('fase_id', Fase::IsEjecucion());
            })->get()
            ->pluck('articulacion_proyecto.actividad.nombre','articulacion_proyecto.actividad.codigo_actividad' );
    }

    /**
     * returns an instance of the ProjectPresenter class
     * @author dum
     * @return void
     */
    public function present()
    {
        return new ProyectoPresenter($this);
    }
}
