<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Presenters\ArticulationPresenter;
use Illuminate\Support\Facades\Session;
use \App\Http\Traits\Encuesta\HasEnvioEncuesta as EncuestaTrait;

class Articulation extends Model
{

    use EncuestaTrait;

    const START_PHASE = "Inicio";
    const EXECUTION_PHASE = "Ejecución";
    const CLOSING_PHASE = "Cierre";
    const SUSPENDED_PHASE = "Suspendido";
    const CANCELED_PHASE = "Cancelado";
    const FINISHED_PHASE = "Finalizado";

    /**
     * The attributes that guarded.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_date'    => 'datetime',
        'end_date'    => 'datetime',
        'expected_end_date'    => 'datetime',
        'received_date'    => 'datetime',
    ];

    /**
     * The attributes that withCount.
     *
     * @var array
     */
    protected $withCount = ['users'];

    /**
     * The inverse relation one to much
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function articulationstage(){
        return $this->belongsTo(ArticulationStage::class, 'articulation_stage_id');
    }

    /**
     * The inverse relation one to much
     *
     * @return void
     */
    public function articulationsubtype(){
        return $this->belongsTo(ArticulationSubtype::class, 'articulation_subtype_id');
    }

    public function archivomodel()
    {
        return $this->morphMany(ArchivoModel::class, 'model');
    }


    public function users()
    {
        return $this->belongsToMany(\App\User::class, 'articulation_user', 'articulation_id', 'user_id');
    }

    public function asesorable()
    {
        return $this->morphMany(UsoInfraestructura::class, 'asesorable');
    }

    public function asesorias()
    {
        return $this->morphMany(UsoInfraestructura::class, 'asesorable');
    }

    /**
     * The relation one to much scope
     *
     * @return void
     */
    public function scope(){
        return $this->belongsTo(AlcanceArticulacion::class, 'scope_id');
    }

    public static function IsInicio() {
        return self::START_PHASE;
    }

    public static function IsEjecucion() {
        return self::EXECUTION_PHASE;
    }

    public static function IsCierre() {
        return self::CLOSING_PHASE;
    }

    public static function IsFinalizado() {
        return self::FINISHED_PHASE;
    }

    public static function IsSuspendido() {
        return self::SUSPENDED_PHASE;
    }

    public static function IsCancelado() {
        return self::CANCELED_PHASE;
    }


    /**
     * The relation one to much phase
     *
     * @return void
     */
    public function phase(){
        return $this->belongsTo(Fase::class, 'phase_id');
    }

    /**
     * Define an inverse one to many relationship between accompanient and node
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(\App\User::class, 'created_by', 'id');
    }

    public function traceability()
    {
        return $this->morphMany(HistorialEntidad::class, 'model');
    }

    /**
     * Define a polymorphic one-to-many relationship between articulationstage and ControlNotificaciones
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function notifications()
    {
        return $this->morphMany(ControlNotificaciones::class, 'notificable');
    }


    /**
     * asesor
     */
    public function getProgressAttribute(): int
    {
        $progress = 0;
        isset($this->phase) && $this->phase->nombre == Self::START_PHASE ? $progress = round((100/4)*1, 1) :
        (
            $this->phase->nombre == Self::EXECUTION_PHASE ? $progress = round((100/4)*2, 1) :
            (
                $this->phase->nombre == Self::CLOSING_PHASE ? $progress = round((100/4)*3, 1) :
                (
                    $this->phase->nombre == Self::FINISHED_PHASE ? $progress = round((100/4)*4, 1) :

                    ($this->phase->nombre == Self::SUSPENDED_PHASE ? $progress = 100 : $progress = 0)


                )
            )
        );
        return $progress;
    }

    /**
     * Retorna el query que muestra la información de la articulación
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function scopeFindById($query, $id)
    {
        $query->select(
            'articulations.*', 'articulation_stages.code as articulation_stage_code',
            'articulation_stages.id as articulation_stages_id','articulation_stages.start_date as articulation_stages_start_date','articulation_stages.end_date as articulation_stages_end_date','articulation_stages.name as articulation_stages_name','articulation_stages.description as articulation_stages_description', 'articulation_stages.scope as articulation_stages_scope', 'articulation_stages.expected_results as articulation_stages_expected_results','fases.nombre as fase',
            'entidades.nombre as nodo', 'proyectos.codigo_proyecto', 'ciudades.nombre AS node_city', 'departamentos.nombre AS node_province',
            'nodos.direccion AS node_addresss', 'regionales.nombre AS node_province_name', 'entidad_centro.nombre AS node_center',
            'proyectos.nombre as nombre_proyecto', 'interlocutor.documento', 'interlocutor.nombres',
            'interlocutor.apellidos', 'interlocutor.email'
        )
        ->selectRaw("if(articulationables.articulationable_type = 'App\\\Models\\\Proyecto', 'Proyecto', 'No registra') as articulation_type, if(articulation_stages.status = 1,'Abierta', 'Cerrada') as articulation_stages_status")
        ->leftJoin('articulation_stages', 'articulation_stages.id', '=', 'articulations.articulation_stage_id')
        ->join('nodos', 'nodos.id', '=', 'articulation_stages.node_id')
        ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
        ->join('centros','centros.id', '=', 'nodos.centro_id')
        ->join('entidades AS entidad_centro', 'entidad_centro.id', '=', 'centros.entidad_id')
        ->join('regionales','regionales.id', '=', 'centros.regional_id')
        ->join('ciudades', 'ciudades.id', '=', 'entidades.ciudad_id')
        ->join('departamentos', 'departamentos.id', '=', 'ciudades.departamento_id')
        ->leftJoin('fases', 'fases.id', '=', 'articulations.phase_id')
        ->leftJoin('articulationables', function($q) {
            $q->on('articulationables.articulation_stage_id', '=', 'articulation_stages.id');
            $q->where('articulationables.articulationable_type', '=', 'App\Models\Proyecto');
        })
        ->leftJoin('proyectos', 'proyectos.id', '=', 'articulationables.articulationable_id')
        ->leftJoin('users as interlocutor', 'interlocutor.id', '=', 'articulation_stages.interlocutor_talent_id')
        ->where('articulations.id', $id);
    }

    /**
     * The query scope status
     *
     * @return void
     */
    public function scopeArticulationStageStatus($query, $status)
    {
        if (isset($status) && $status != 'all' && $status != null) {
            return $query->whereHas('articulationstage', function ($subquery) use ($status) {
                $subquery->where('status', $status);
            });
        }
        return $query;
    }

    /**
     * The query scope node
     *
     * @return void
     */
    public function scopeArticulationStageYear($query, $year)
    {
        if (!empty($year) && $year != null && $year != 'all') {
            return $query
                ->WhereHas('articulationstage', function ($subquery) use ($year) {
                $subquery->whereYear('articulation_stages.start_date', $year)
                    ->orWhereYear('articulation_stages.end_date', $year);
            });
        }
        return $query;
    }

    /**
     * The query scope node
     *
     * @return void
     */
    public function scopeYear($query, $year)
    {
        if (!empty($year) && $year != null && $year != 'all') {
            return $query->orWhereYear('articulations.start_date', $year)
                    ->orWhereYear('articulations.end_date', $year);
        }
        return $query;
    }

    /**
     * The query scope node
     *
     * @return void
     */
    public function scopeArticulationStageNode($query, $node)
    {
        if (!empty($node) && $node != null && $node != 'all') {
            return $query->whereHas('articulationstage', function ($subquery) use ($node) {
                $subquery->where('node_id', $node);
            });
        }
        return $query;
    }
    /**
     * The query scope node
     *
     * @return void
     */
    public function scopeArticulationStageInterlocutorTalent($query, $talent)
    {
        if (!empty($talent) && $talent != null && $talent != 'all') {
            return $query->whereHas('articulationstage', function ($query) use($talent) {
                    return $query->where('interlocutor_talent_id', $talent);
                })->orWhereHas('users', function ($query) use($talent) {
                    return $query->where('users.id', $talent);
                });
        }
        return $query;
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
     * Consulta la trazabilidad de la fase de articulacion
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
            ->where('historial_entidad.model_type', '=', Articulation::class)
            ->where('historial_entidad.model_id', $model->id);
    }

    /**
     * Registra el control de una notificación
     *
     * @param int $receptor id del receptor de la notificacion
     * @param string $rol_receptor Nombre del rol que espera la notificación

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
        return new ArticulationPresenter($this);
    }
}
