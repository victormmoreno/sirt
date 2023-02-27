<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Presenters\ArticulationStagePresenter;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class ArticulationStage extends Model
{
    /**
     * The constants for handling static or boolean values.
     * @const
     */
    const CONFIDENCIALITY_FORMAT_YES = 1;
    const CONFIDENCIALITY_FORMAT_NO = 0;
    const  STATUS_OPEN = 1;
    const  STATUS_CLOSE = 0;
    const  ENDORSEMENT_YES = 1;
    const  ENDORSEMENT_NO = 0;


    /**
     * The attributes that guarded.
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast to native types.
     * @var array
     */
    protected $casts = [
        'start_date'    => 'datetime',
        'end_date'    => 'datetime',
        'terms_verified_at'    => 'datetime',
    ];

    /**
     * The attributes that withCount.
     * @var array
     */
    protected $withCount = ['articulations'];

    /**
     * The relation one to much
     * @return  \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articulations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Articulation::class);
    }

    /**
     * Define a polymorphic, inverse many-to-many relationship articulationstage and project
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function projects()
    {
        return $this->morphedByMany(Proyecto::class, 'articulationable');
    }

    /**
     * Define a polymorphic, inverse many-to-many relationship articulationstage and sedes
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function sedes()
    {
        return $this->morphedByMany(Sede::class, 'articulationable');
    }

    /**
     * Define a polymorphic, inverse many-to-many relationship articulationstage and ideas
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function ideas()
    {
        return $this->morphedByMany(Idea::class, 'articulationable');
    }

    /**
     * Define a polymorphic, inverse one-to-one or many relationship.
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function articulationable()
    {
        return $this->morphTo();
    }

    /**
     * Define an inverse one to many relationship between articulationstage and node
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function node()
    {
        return $this->belongsTo(Nodo::class, 'node_id', 'id');
    }

    public function archivomodel()
    {
        return $this->morphMany(ArchivoModel::class, 'model');
    }


    /**
     * Define a polymorphic one-to-many relationship between articulationstage and ControlNotificaciones
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function notifications()
    {
        return $this->morphMany(ControlNotificaciones::class, 'notificable');
    }

    public static function IsAbierto() {
        return self::STATUS_OPEN;
    }

    public static function IsCerrado() {
        return self::STATUS_CLOSE;
    }

    /**
     * Define an inverse one to many relationship between accompanient and node
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function interlocutor()
    {
        return $this->belongsTo(\App\User::class, 'interlocutor_talent_id', 'id')->withTrashed();
    }

    /**
     * Define an inverse one to many relationship between accompanient and node
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(\App\User::class, 'created_by', 'id')->withTrashed();
    }


    public function traceability()
    {
        return $this->morphMany(HistorialEntidad::class, 'model');
    }

    /**
     * The query scope status
     *
     * @return void
     */
    public function scopestatus($query, $status)
    {
        if (isset($status) && $status != 'all' && $status != null) {
            return $query->where('status', $status);
        }
        return $query;
    }

    /**
     * The query scope node
     *
     * @return void
     */
    public function scopeNode($query, $nodes)
    {
        if (isset($nodes) && (!collect($nodes)->contains('all'))) {
            return $query->whereIn('node_id', $nodes);
        }
        return $query;
    }

    /**
     * The query scope node
     *
     * @return void
     */
    public function scopeYear($query, $years)
    {
        if (isset($years) && (!collect($years)->contains('all'))) {
            return $query->where(function ($q) use($years){
                $q->where(function ($subquery) use ($years) {
                    $subquery->whereIn(DB::raw('YEAR(articulation_stages.start_date)'),$years)
                        ->orWhereIn(DB::raw('YEAR(articulation_stages.end_date)'), $years)
                        ->orWhereIn(DB::raw('YEAR(articulations.start_date)'), $years)
                        ->orWhereIn(DB::raw('YEAR(articulations.end_date)'), $years);
                })
                ->orWhere(function ($query) {
                    $query->whereIn('fases.nombre', ['Inicio', 'Ejecución', 'Cierre']);
                });
            });
        }
        return $query;
    }


    /**
     * The query scope asesor
     *
     * @return void
     */
    public function scopeInterlocutorTalent($query, $talent)
    {
        if (!empty($talent) && $talent != null && $talent != 'all') {
            return
                $query->where('articulation_stages.interlocutor_talent_id', $talent)
                ->orWhereHas('articulations.users', function ($query) use($talent) {
                    return $query->where('users.id', $talent);
                });
        }
        return $query;
    }

    /**
     * Registra el control de una notificación
     *
     * @param int $receptor id del receptor de la notificacion
     * @param string $rol_receptor Nombre del rol que espera la notificación
     * @return ControlNotificacion
     */
    public function registerNotify($receptor, $rol_receptor, $fase = null, $descripcion = null)
    {
        return $this->notifications()->create([
            'fase_id' => $fase,
            'remitente_id' => auth()->user()->id,
            'rol_remitente_id' => Role::where('name', Session::get('login_role'))->first()->id,
            'receptor_id' => $receptor,
            'rol_receptor_id' => Role::where('name', $rol_receptor)->first()->id,
            'fecha_envio' => Carbon::now(),
            'fecha_aceptacion' => null,
            'descripcion' => $descripcion
        ]);
    }

    /**
     * Consulta la trazabilidad de la etapa de articulacion
     * @param $model
     * @return Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    public static function getTraceability($model) {
        return HistorialEntidad::query()
            ->select('historial_entidad.id','historial_entidad.comentarios', 'historial_entidad.descripcion', 'roles.name AS rol', 'historial_entidad.created_at', 'movimientos.movimiento as movimiento')
            ->selectRaw('concat(users.nombres, " ", users.apellidos) AS usuario')
            ->join('movimientos', 'movimientos.id', '=','historial_entidad.movimiento_id')
            ->join('users', 'users.id', '=', 'historial_entidad.user_id')
            ->join('roles', 'roles.id', '=', 'historial_entidad.role_id')
            ->orderBy('historial_entidad.created_at')
            ->where('historial_entidad.model_type', '=', ArticulationStage::class)
            ->where('historial_entidad.model_id', $model->id);
    }


    public function createTraceability($movimiento, $role, $comentario, $descripcion = null)
    {
        return $this->traceability()->create([
            'movimiento_id' => Movimiento::where('movimiento', $movimiento)->first()->id,
            'user_id' => auth()->user()->id,
            'role_id' => Role::where('name', $role)->first()->id,
            'comentarios' => $comentario,
            'descripcion' => $descripcion
        ]);
    }
    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'code';
    }
    /**
     * The presenter
     *
     * @return void
     */
    public function present()
    {
        return new ArticulationStagePresenter($this);
    }

}
