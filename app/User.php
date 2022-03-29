<?php

namespace App;

use App\Http\Traits\UserTrait\UsersTrait;
use App\Models\{
    ActivationToken,
    Ciudad,
    Dinamizador,
    Eps,
    Etnia,
    Gestor,
    GradoEscolaridad,
    GrupoSanguineo,
    Infocenter,
    Ingreso,
    Ocupacion,
    Proyecto,
    Role,
    Movimiento,
    Talento,
    TipoDocumento,
    Contratista,
    ControlNotificaciones,
    UserNodo,
};
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Presenters\UserPresenter;

class User extends Authenticatable implements JWTSubject
{

    use  SoftDeletes, Notifiable, HasRoles,  UsersTrait;

    const IS_MASCULINO     = 1;
    const IS_FEMENINO      = 0;
    const IS_ACTIVE        = true;
    const IS_INACTIVE      = false;
    const IS_ADMINISTRADOR = "Administrador";
    const IS_DINAMIZADOR   = "Dinamizador";
    const IS_GESTOR        = "Experto";
    const IS_INFOCENTER    = "Infocenter";
    const IS_TALENTO       = "Talento";
    const IS_INGRESO       = "Ingreso";
    const IS_PROVEEDOR     = "Proveedor";
    const IS_DESARROLLADOR     = "Desarrollador";
    const IS_ARTICULADOR     = "Articulador";
    const IS_APOYO_TECNICO     = "Apoyo Técnico";

    protected $appends = ['nombre_completo'];

    protected $dates = [
        'ultimo_login',
        'fechanacimiento',
        'fecha_terminacion',
        'deleted_at'
    ];

    public $items = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tipodocumento_id',
        'gradoescolaridad_id',
        'gruposanguineo_id',
        'eps_id',
        'ciudad_id',
        'ciudad_expedicion_id',
        'nombres',
        'apellidos',
        'documento',
        'email',
        'barrio',
        'direccion',
        'telefono',
        'celular',
        'fechanacimiento',
        'genero',
        'mujerCabezaFamilia',
        'desplazadoPorViolencia',
        'estado',
        'institucion',
        'titulo_obtenido',
        'fecha_terminacion',
        'password',
        'estrato',
        'otra_eps',
        'otra_ocupacion',
        'etnia_id',
        'grado_discapacidad',
        'descripcion_grado_discapacidad',

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'tipodocumento_id'     => 'integer',
        'gradoescolaridad_id'  => 'integer',
        'gruposanguineo_id'    => 'integer',
        'eps_id'               => 'integer',
        'ciudad_id'            => 'integer',
        'ciudad_expedicion_id' => 'integer',
        'nombres'              => 'string',
        'apellidos'            => 'string',
        'documento'            => 'string',
        'estado'               => 'boolean',
        'email_verified_at'    => 'datetime',
        'fechanacimiento'      => 'date:Y-m-d',
    ];

    /*===========================================
    =            relaciones eloquent            =
    ===========================================*/

    public function notificaciones_remitidas()
    {
        return $this->hasMany(ControlNotificaciones::class, 'remitente_id', 'id');
    }

    public function notificaciones_recibidas()
    {
        return $this->hasMany(ControlNotificaciones::class, 'receptor_id', 'id');
    }

    public function proyectos()
    {
        return $this->morphToMany(Proyecto::class, 'propietario')->withTimestamps();
    }


    /**
     * Define a one-to-many relationship between users and proyectos.
     * @author devjul
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function asesoredts()
    {
        return $this->hasMany(Edt::class, 'asesor_id', 'id');
    }

    /**
     * Define a one-to-many relationship between users and articulaciones.
     * @author devjul
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function asesorarticulaciones()
    {
        return $this->hasMany(\App\Models\Articulacion::class, 'asesor_id', 'id');
    }

    /**
     * Define a one-to-many relationship between users and articulacion_pbts.
     * @author devjul
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function asesorarticulacionpbt()
    {
        return $this->hasMany(\App\Models\ArticulacionPbt::class, 'asesor_id', 'id');
    }

    public function etnia()
    {
        return $this->belongsTo(Etnia::class, 'etnia_id', 'id');
    }

    //relaciones muchos a muchos

    public function movimientos()
    {
        return $this->belongsToMany(Movimiento::class, 'movimientos_actividades_users_roles')
            ->withTimestamps();
    }

    public function roles_movimientos()
    {
        return $this->belongsToMany(Role::class, 'movimientos_actividades_users_roles')
            ->withTimestamps();
    }

    public function fases_movimientos()
    {
        return $this->belongsToMany(Fase::class, 'movimientos_actividades_users_roles')
            ->withTimestamps();
    }

    public function actividades_movimientos()
    {
        return $this->belongsToMany(Actividad::class, 'movimientos_actividades_users_roles')
            ->withTimestamps();
    }

    public function ocupaciones()
    {
        return $this->belongsToMany(Ocupacion::class, 'ocupaciones_users')
            ->withTimestamps();
    }

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_id', 'id');
    }

    public function ciudadexpedicion()
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_expedicion_id', 'id');
    }

    public function gradoEscolaridad()
    {
        return $this->belongsTo(GradoEscolaridad::class, 'gradoescolaridad_id', 'id');
    }

    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'tipodocumento_id', 'id');
    }

    public function grupoSanguineo()
    {
        return $this->belongsTo(GrupoSanguineo::class, 'gruposanguineo_id', 'id');
    }

    public function eps()
    {
        return $this->belongsTo(Eps::class, 'eps_id', 'id');
    }

    public function gestor()
    {
        return $this->hasOne(Gestor::class, 'user_id', 'id');
    }

    public function articulador()
    {
        return $this->hasOne(UserNodo::class, 'user_id', 'id')->where('role', User::IsArticulador());
    }

    public function apoyotecnico()
    {
        return $this->hasOne(UserNodo::class, 'user_id', 'id')->where('role', User::IsApoyoTecnico());
    }

    public function dinamizador()
    {
        return $this->hasOne(Dinamizador::class, 'user_id', 'id');
    }

    public function contratista()
    {
        return $this->hasOne(Contratista::class, 'user_id', 'id');
    }

    public function infocenter()
    {
        return $this->hasOne(Infocenter::class, 'user_id', 'id');
    }

    public function ingreso()
    {
        return $this->hasOne(Ingreso::class, 'user_id', 'id');
    }

    public function talento()
    {
        return $this->hasOne(Talento::class, 'user_id', 'id');
    }

    public function token()
    {
        return $this->hasOne(ActivationToken::class);
    }

    public function usoinfraestructuras()
    {
        // return $this->belongsToMany(UsoInfraestructura::class, 'gestor_uso', 'usoinfraestructura_id', 'gestor_id')
        //     ->withTimestamps()
        //     ->withPivot([
        //         'asesoria_directa',
        //         'asesoria_indirecta',
        //         'costo_asesoria',
        //     ]);

            return $this->morphToMany(UsoInfraestructura::class, 'asesorable', 'gestor_uso', 'usoinfraestructura_id')->withTimestamps()
            ->withPivot([
                'asesoria_directa',
                'asesoria_indirecta',
                'costo_asesoria',
            ]);
    }

    /*=====  End of relaciones eloquent  ======*/

    public function scopeInfoUserRole($query, array $role = [], array $relations = [])
    {

        return $query->with($relations)
            ->role($role);
    }

    public function scopeInfoUserDatatable($query)
    {
        return $query->select(
            'users.id',
            'tiposdocumentos.nombre as tipodocumento',
            'users.documento',
            'users.email',
            'users.direccion',
            'users.celular',
            'users.telefono',
            'users.estado',
            'users.fechanacimiento'
        )
            ->selectRaw("CONCAT(users.nombres,' ',users.apellidos) as nombre")
            ->Join('tiposdocumentos', 'tiposdocumentos.id', '=', 'users.tipodocumento_id');
    }

    public function scopeRole($query, $role)
    {
        if (!empty($role) && $role != null && $role != 'all') {
            return $query->whereHas('roles', function ($subQuery) use ($role) {
                $subQuery->where('name', $role);
            });
        }
        return $query;
    }

    public function scopeNodoUser($query, $role, $nodo)
    {
        if ((!empty($role) && $role != null && $role != 'all' && ($role != User::IsTalento() || $role != User::IsAdministrador())) && !empty($nodo) && $nodo != null && $nodo != 'all') {
            if ($role == User::IsDinamizador()) {
                return $query->whereHas('dinamizador.nodo', function ($subQuery) use ($nodo) {
                    $subQuery->where('id', $nodo);
                });
            }
            if ($role == User::IsGestor()) {
                return $query->whereHas('gestor.nodo', function ($subQuery) use ($nodo) {
                    $subQuery->where('id', $nodo);
                });
            }

            if ($role == User::IsArticulador()) {
                return $query->whereHas('articulador.nodo', function ($subQuery) use ($nodo) {
                    $subQuery->where('id', $nodo);
                });
            }

            if ($role == User::IsApoyoTecnico()) {
                return $query->whereHas('apoyotecnico.nodo', function ($subQuery) use ($nodo) {
                    $subQuery->where('id', $nodo);
                });
            }

            if ($role == User::IsInfocenter()) {
                return $query->whereHas('infocenter.nodo', function ($subQuery) use ($nodo) {
                    $subQuery->where('id', $nodo);
                });
            }

            if ($role == User::IsIngreso()) {
                return $query->whereHas('ingreso.nodo', function ($subQuery) use ($nodo) {
                    $subQuery->where('id', $nodo);
                });
            }
        }

        if (session()->get('login_role') == User::IsGestor()) {
            if ((!empty($role) && $role != null && $role != 'all' && $role == User::IsTalento()) && !empty($nodo) && $nodo != null && $nodo != 'all') {

                return $query->has('talento');
            }

            if ((!empty($role) && $role != null && $role != 'all' && $role == User::IsTalento()) && !empty($nodo) && $nodo != null && $nodo == 'all') {

                return $query->has('talento');
            }

            if ((!empty($role) && $role != null && $role == 'all') && !empty($nodo) && $nodo != null && $nodo != 'all') {

                return $query->has('talento')
                    ->orWhereHas('dinamizador.nodo', function ($subQuery) use ($nodo) {
                        $subQuery->where('id', $nodo);
                    })->orWhereHas('gestor.nodo', function ($subQuery) use ($nodo) {
                        $subQuery->where('id', $nodo);
                    })->orWhereHas('infocenter.nodo', function ($subQuery) use ($nodo) {
                        $subQuery->where('id', $nodo);
                    })->orWhereHas('ingreso.nodo', function ($subQuery) use ($nodo) {
                        $subQuery->where('id', $nodo);
                    });
            }
        } else {
            if ((!empty($role) && $role != null && $role != 'all' && $role == User::IsTalento()) && !empty($nodo) && $nodo != null && $nodo != 'all') {

                return $query->wherehas('talento.articulacionproyecto.proyecto.nodo', function ($query) use ($nodo) {
                    $query->where('id', $nodo);
                });
            }

            if ((!empty($role) && $role != null && $role != 'all' && $role == User::IsTalento()) && !empty($nodo) && $nodo != null && $nodo == 'all') {

                return $query->has('talento.articulacionproyecto.proyecto.nodo');
            }

            if ((!empty($role) && $role != null && $role == 'all') && !empty($nodo) && $nodo != null && $nodo != 'all') {

                return $query->wherehas('talento.articulacionproyecto.proyecto.nodo', function ($query) use ($nodo) {
                    $query->where('id', $nodo);
                })
                    ->orWhereHas('dinamizador.nodo', function ($subQuery) use ($nodo) {
                        $subQuery->where('id', $nodo);
                    })->orWhereHas('gestor.nodo', function ($subQuery) use ($nodo) {
                        $subQuery->where('id', $nodo);
                    })->orWhereHas('infocenter.nodo', function ($subQuery) use ($nodo) {
                        $subQuery->where('id', $nodo);
                    })->orWhereHas('ingreso.nodo', function ($subQuery) use ($nodo) {
                        $subQuery->where('id', $nodo);
                    });
            }
        }

        return $query;
    }

    public function scopeStateDeletedAt($query, $state)
    {
        if (!empty($state) && $state != null && $state != 'all') {
            if ($state == 'si') {
                $state = User::IsActive();
                return $query->where('estado', $state);
            } else {
                $state = User::IsInactive();
                return $query->where('estado', $state)->onlyTrashed();
            }
        }
        return $query->withTrashed();
    }

    public function scopeYearActividad($query, $role, $year, $nodo)
    {
        if (session()->get('login_role') != User::IsGestor()) {
            if ((!empty($role) && $role != null && $role != 'all' && $role == User::IsTalento()) && !empty($year) && $year != null && $year == 'all'  && (!empty($nodo) && $nodo != null && $nodo == 'all')) {
                return $query->has('talento.articulacionproyecto.actividad');
            }

            if ((!empty($role) && $role != null && $role != 'all' && $role == User::IsTalento()) && (!empty($year) && $year != null && $year != 'all') && (!empty($nodo) && $nodo != null && $nodo != 'all')) {
                return $query->wherehas('talento.articulacionproyecto.actividad', function ($query) use ($year, $nodo) {
                    $query->where(function ($subquery) use ($year) {
                        $subquery->whereYear('fecha_inicio', $year)->orWhereYear('fecha_cierre', $year);
                    })->where('nodo_id', $nodo);
                });
            }
            if ((!empty($role) && $role != null && $role != 'all' && $role == User::IsTalento()) && (!empty($year) && $year != null && $year != 'all') && (!empty($nodo) && $nodo != null && $nodo == 'all')) {
                return $query->wherehas('talento.articulacionproyecto.actividad', function ($query) use ($year) {
                    $query->whereYear('fecha_inicio', $year)->orWhereYear('fecha_cierre', $year);
                });
            }
            if ((!empty($role) && $role != null && $role != 'all' && $role == User::IsTalento()) && (!empty($year) && $year != null && $year == 'all') && (!empty($nodo) && $nodo != null && $nodo != 'all')) {
                return $query->wherehas('talento.articulacionproyecto.proyecto.nodo', function ($query) use ($nodo) {
                    $query->where('id', $nodo);
                });
            }
        }

        return $query;
    }

    public function scopeActivitiesTalento($query, $role, $year, $nodo)
    {

        if ((!empty($role) && $role != null && $role != 'all' && $role == User::IsTalento()) && !empty($year) && $year != null && $year == 'all'  && (!empty($nodo) && $nodo != null && $nodo == 'all')) {
            return $query->has('talento.articulacionproyecto.actividad');
        }

        if ((!empty($role) && $role != null && $role != 'all' && $role == User::IsTalento()) && (!empty($year) && $year != null && $year != 'all') && (!empty($nodo) && $nodo != null && $nodo != 'all')) {
            return $query->wherehas('talento.articulacionproyecto.actividad', function ($query) use ($year, $nodo) {
                $query->where(function ($subquery) use ($year) {
                    $subquery->whereYear('fecha_inicio', $year)->orWhereYear('fecha_cierre', $year);
                })->where('nodo_id', $nodo);
            });
        }
        if ((!empty($role) && $role != null && $role != 'all' && $role == User::IsTalento()) && (!empty($year) && $year != null && $year != 'all') && (!empty($nodo) && $nodo != null && $nodo == 'all')) {
            return $query->wherehas('talento.articulacionproyecto.actividad', function ($query) use ($year) {
                $query->whereYear('fecha_inicio', $year)->orWhereYear('fecha_cierre', $year);
            });
        }
        if ((!empty($role) && $role != null && $role != 'all' && $role == User::IsTalento()) && (!empty($year) && $year != null && $year == 'all') && (!empty($nodo) && $nodo != null && $nodo != 'all')) {
            return $query->wherehas('talento.articulacionproyecto.proyecto.nodo', function ($query) use ($nodo) {
                $query->where('id', $nodo);
            });
        }


        return $query;
    }

    public function isUserAdministrador(): bool
    {
        return (bool) $this->hasRole(User::IsAdministrador());
    }

    public function isUserDinamizador(): bool
    {
        return (bool) $this->hasRole(User::IsDinamizador()) && $this->dinamizador() != null;
    }

    public function isUserExperto(): bool
    {
        return (bool) $this->hasRole(User::IsGestor()) && $this->gestor() != null;
    }

    public function isUserArticulador(): bool
    {
        return (bool) $this->hasRole(User::IsArticulador()) && $this->articulador() != null;
    }

    public function isUserApoyoTecnico(): bool
    {
        return (bool) $this->hasRole(User::IsApoyoTecnico()) && $this->apoyotecnico() != null;
    }

    public function isUserIngreso(): bool
    {
        return (bool) $this->hasRole(User::IsIngreso()) && $this->ingreso() != null;
    }
    public function isUserInfocenter(): bool
    {
        return (bool) $this->hasRole(User::IsInfocenter()) && $this->infocenter() != null;
    }

    public function isUserTalento(): bool
    {
        return (bool) $this->hasRole(User::IsTalento()) && $this->talento() != null;
    }

    public function isAuthUser(): bool
    {
        return (bool) $this->documento == \Auth::user()->documento;
    }

    public static function enableTalentsArticulacion($articulacion)
    {
        foreach ($articulacion->talentos as $value) {
            $value->user()->withTrashed()->first()->restore();
            $value->user()->withTrashed()->first()->update(['estado' => User::IsActive()]);
        }
    }


    public function present()
    {
        return new UserPresenter($this);
    }
}
