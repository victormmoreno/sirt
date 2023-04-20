<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Presenters\ProyectoPresenter;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

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
     * Constantes para la fase de proyecto
     */
    const IS_INICIO = 'Inicio';
    const IS_PLANEACION = 'Planeación';
    const IS_EJECUCION = 'Ejecución';
    const IS_CIERRE = 'Cierre';
    const IS_FINALIZADO = 'Finalizado';
    const IS_SUSPENDIDO = 'Concluido sin finalizar';

    /**
     * Constante para el campo trl_obtenido
     * @var int
     * @author dum
     */
    const IS_TRL6_OBTENIDO = 0;
    const IS_TRL7_OBTENIDO = 1;
    const IS_TRL8_OBTENIDO = 2;

    /**
     * The attributes that should be cast to native types.
     * @var array
     */
    protected $casts = [
        'codigo_proyecto' => 'string',
        'nombre'           => 'string',
        'fecha_inicio'     => 'date:Y-m-d',
        'fecha_cierre'     => 'date:Y-m-d'
    ];

    /**
     * The attributes that are mass assignable.
     * @author dum
     * @var array
     */
    protected $fillable = [
        // 'articulacion_proyecto_id',
        'experto_id',
        'asesor_id',
        'nodo_id',
        'idea_id',
        'sublinea_id',
        'areaconocimiento_id',
        'fase_id',
        'codigo_proyecto',
        'nombre',
        'fecha_inicio',
        'fecha_cierre',
        'objetivo_general',
        'conclusiones',
        'formulario_inicio',
        'cronograma',
        'seguimiento',
        'formulario_final',
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
        'fabrica_productividad',
        'doc_titular',
        'trl_prototipo',
        'trl_pruebas',
        'trl_modelo',
        'trl_normatividad',
        'evidencia_trl'
    ];


    public static function IsInicio() {
        return self::IS_INICIO;
    }

    public static function IsPlaneacion() {
        return self::IS_PLANEACION;
    }

    public static function IsEjecucion() {
        return self::IS_EJECUCION;
    }

    public static function IsCierre() {
        return self::IS_CIERRE;
    }

    public static function IsFinalizado() {
        return self::IS_FINALIZADO;
    }

    public static function IsSuspendido() {
        return self::IS_SUSPENDIDO;
    }

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

    public function asesorias()
    {
        return $this->morphMany(UsoInfraestructura::class, 'asesorable');
    }

    public function notificaciones()
    {
        return $this->morphMany(ControlNotificaciones::class, 'notificable');
    }

    public function objetivos_especificos()
    {
        return $this->hasMany(ObjetivoEspecifico::class, 'proyecto_id', 'id');
    }

    /**
     * Relación muchos a muchos con la tabla de talentos
     * @return Eloquent
     * @author dum
     */
    public function talentos()
    {
        return $this->belongsToMany(User::class, 'proyecto_talento')
            ->withTimestamps()
            ->withTrashed()
            ->withPivot('talento_lider');
    }

    public function archivos()
    {
        return $this->morphMany(ArchivoModel::class, 'model');
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
        return $this->belongsTo(User::class, 'experto_id', 'id');
    }

    /**
     * The polymorfic relation much to much
     *
     * @return void
     */
    public function articulationables()
    {
        return $this->morphToMany(ArticulationStage::class, 'articulationable');
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

    public function scopeAsesor($query, $asesor)
    {
        if (!empty($asesor) && $asesor != null && $asesor != 'all') {
            return $query->where('asesor_id', $asesor);
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
     * Registra el control de una notificación de un proyecto
     *
     * @param int $receptor id del receptor de la notificacion
     * @param string $rol_receptor Nombre del rol que espera la notificación
     * @return ControlNotificacion
     * @author dum
     */
    public function registerNotifyProject($receptor, $rol_receptor, $fase = null)
    {
        $fase_conf = null;
        if ($fase == $this->IsSuspendido()) {
            $fase_conf = Fase::where('nombre', $this->IsSuspendido())->first()->id;
        } else {
            $fase_conf = $this->fase_id;
        }
        return $this->notificaciones()->create([
            'fase_id' => $fase_conf,
            'remitente_id' => auth()->user()->id,
            'rol_remitente_id' => Role::where('name', session()->get('login_role'))->first()->id,
            'receptor_id' => $receptor,
            'rol_receptor_id' => Role::where('name', $rol_receptor)->first()->id,
            'fecha_envio' => Carbon::now(),
            'fecha_aceptacion' => null
        ]);
    }

    /**
     * Retorna el talento lider de un proyecto
     *
     * @return Talento
     * @author dum
     **/
    public function getLeadTalent()
    {
        return $this->talentos()->wherePivot('talento_lider', 1)->first();
    }


    public function consultarNotificaciones()
    {
        return $this->with([
                'notificaciones',
                'notificaciones.fase',
                'notificaciones.remitente',
                'notificaciones.receptor',
                'notificaciones.rol_receptor',
                'notificaciones.rol_remitente'
            ]);
    }

    /**
     * Consulta el historico de una actividad
     * @param int $id Id de la activdad
     * @return Builder
     * @author dum
     */
    public static function consultarHistoricoProyecto($id) {
        return DB::table('movimientos_actividades_users_roles')->select('movimiento', 'fases.nombre AS fase', 'roles.name AS rol', 'comentarios', 'movimientos_actividades_users_roles.created_at')
        ->selectRaw('concat(nombres, " ", apellidos) AS usuario')
        ->where('proyecto_id', $id)
        ->join('movimientos', 'movimientos.id', 'movimientos_actividades_users_roles.movimiento_id')
        ->join('fases', 'fases.id', '=', 'movimientos_actividades_users_roles.fase_id')
        ->join('users', 'users.id', '=', 'movimientos_actividades_users_roles.user_id')
        ->join('roles', 'roles.id', '=', 'movimientos_actividades_users_roles.role_id')
        ->orderBy('movimientos_actividades_users_roles.created_at');
    }

    public function movimientos()
    {
        return $this->belongsToMany(Movimiento::class, 'movimientos_actividades_users_roles')
        ->withTimestamps();
    }

    public static function habilitarTalentos($proyecto)
    {
        foreach ($proyecto->talentos as $value) {
            $value->restore();
            $value->update(['estado' => 1]);
        }
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
