<?php

namespace App;

use App\Http\Traits\UserTrait\UsersTrait;
use App\Models\{
    ActivationToken,
    Ciudad,
    Eps,
    Etnia,
    GradoEscolaridad,
    GrupoSanguineo,
    Ocupacion,
    Proyecto,
    Role,
    Movimiento,
    TipoDocumento,
    ControlNotificaciones,
    UserNodo
};
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Presenters\UserPresenter;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements JWTSubject
{

    use  SoftDeletes, Notifiable, HasRoles,  UsersTrait;

    /**
     * definition of constants to reference roles
     */

    const IS_MASCULINO      = 1;
    const IS_NO_BINARIO     = 2;
    const IS_FEMENINO       = 0;
    const IS_ACTIVE         = true;
    const IS_INACTIVE       = false;
    const IS_ACTIVADOR      = "Activador";
    const IS_ADMINISTRADOR  = "Administrador";
    const IS_DINAMIZADOR    = "Dinamizador";
    const IS_EXPERTO        = "Experto";
    const IS_INFOCENTER     = "Infocenter";
    const IS_TALENTO        = "Talento";
    const IS_INGRESO        = "Ingreso";
    const IS_PROVEEDOR      = "Proveedor";
    const IS_DESARROLLADOR  = "Desarrollador";
    const IS_ARTICULADOR    = "Articulador";
    const IS_APOYO_TECNICO  = "Apoyo Técnico";
    const IS_USUARIO        = "Usuario";

    /**
     * The accessors to append to the model's array form.
     * @var array
     */
    protected $appends = ['nombre_completo'];

    /**
     * The attributes that should be mutated to dates.
     * @var array
     */
    protected $dates = [
        'ultimo_login',
        'fechanacimiento',
        'fecha_terminacion',
        'deleted_at'
    ];

    public $items = null;

    /**
     * The attributes that are mass assignable.
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
        'celular',
        'telefono',
        'genero',
        'fechanacimiento',
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
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
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

    /**
     * Define a one-to-many relationship between users and control_notificaciones for notificaciones_remitidas.
     * @return HasMany
     */
    public function notificaciones_remitidas(): HasMany
    {
        return $this->hasMany(ControlNotificaciones::class, 'remitente_id', 'id');
    }

    /**
     * Define a one-to-many relationship between users and control_notificaciones for notificaciones_recibidas.
     * @return HasMany
     */
    public function notificaciones_recibidas(): HasMany
    {
        return $this->hasMany(ControlNotificaciones::class, 'receptor_id', 'id');
    }
    /**
     * Define a polymorphic many-to-many relationship between users and projects.
     * @return MorphToMany
     */
    public function proyectos(): MorphToMany
    {
        return $this->morphToMany(Proyecto::class, 'propietario')->withTimestamps();
    }

    /**
     * Define a one-to-many relationship between users and proyectos.
     * @return HasMany
     */
    public function asesoredts(): HasMany
    {
        return $this->hasMany(Edt::class, 'asesor_id', 'id');
    }

    /**
     * Define a one-to-many relationship between users and articulaciones.
     * @return HasMany
     */
    public function asesorarticulaciones(): HasMany
    {
        return $this->hasMany(\App\Models\Articulacion::class, 'asesor_id', 'id');
    }

    /**
     * Define an inverse one-to-one or many relationship between users and etnias.
     * @return BelongsTo
     */
    public function etnia(): BelongsTo
    {
        return $this->belongsTo(Etnia::class, 'etnia_id', 'id');
    }

    /**
     * Define a many-to-many relationship between users and proyectos.
     * @return BelongsToMany
     */
    public function proyecto_talento() : BelongsToMany
    {
        return $this->belongsToMany(Proyecto::class, 'proyecto_talento')
            ->withTimestamps()
            ->withPivot('talento_lider');
    }

    /**
     * Define a many-to-many relationship between users and movimientos.
     * @return BelongsToMany
     */
    public function movimientos()
    {
        return $this->belongsToMany(Movimiento::class, 'movimientos_actividades_users_roles')
            ->withTimestamps();
    }
    /**
     * Define a many-to-many relationship between users and roles and movimientos.
     * @return BelongsToMany
     */
    public function roles_movimientos(): BelongsToMany
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

    public function articulador()
    {
        return $this->hasOne(UserNodo::class, 'user_id', 'id')->where('role', User::IsArticulador());
    }

    public function apoyotecnico()
    {
        return $this->hasOne(UserNodo::class, 'user_id', 'id')->where('role', User::IsApoyoTecnico());
    }

    public function experto()
    {
        return $this->hasOne(UserNodo::class, 'user_id', 'id')->where('role', self::IsExperto());
    }

    public function dinamizador()
    {
        return $this->hasOne(UserNodo::class, 'user_id', 'id')->where('role', User::IsDinamizador());
    }

    public function infocenter()
    {
        return $this->hasOne(UserNodo::class, 'user_id', 'id')->where('role', User::IsInfocenter());
    }

    public function ingreso()
    {
        return $this->hasOne(UserNodo::class, 'user_id', 'id')->where('role', User::IsIngreso());
    }

    public function token()
    {
        return $this->hasOne(ActivationToken::class);
    }


    public function usoinfraestructuras()
    {
            return $this->morphToMany(UsoInfraestructura::class, 'asesorable', 'gestor_uso', 'usoinfraestructura_id')->withTimestamps()
            ->withPivot([
                'asesoria_directa',
                'asesoria_indirecta',
                'costo_asesoria',
            ]);
    }

    public function usoinfraestructura_talento()
    {
        return $this->belongsToMany(UsoInfraestructura::class, 'uso_talentos')
            ->withTimestamps();
    }

    public function scopeInfoUserRole($query, array $role = [], array $relations = [])
    {
        return $query->with($relations)
            ->role($role);
    }

    public function scopeInfoUserBuilder($query)
    {
        return $query
        ->join('model_has_roles', function ($join) {
            $join->on('users.id', '=', 'model_has_roles.model_id')
                ->where('model_has_roles.model_type', self::class);
        })
        ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
        ->join('tiposdocumentos', 'tiposdocumentos.id', '=', 'users.tipodocumento_id')
        ->join('gradosescolaridad', 'gradosescolaridad.id', '=', 'users.gradoescolaridad_id')
        ->join('gruposanguineos', 'gruposanguineos.id', '=', 'users.gruposanguineo_id')
        ->leftjoin('eps', 'eps.id', '=', 'users.eps_id')
        ->leftjoin('etnias', 'etnias.id', '=', 'users.etnia_id')
        ->join('ciudades as ciudad_residencia', 'ciudad_residencia.id', '=', 'users.ciudad_id')
        ->join('departamentos as departamento_residencia', 'departamento_residencia.id', '=', 'ciudad_residencia.departamento_id')
        ->join('ciudades as ciudad_expedicion', 'ciudad_expedicion.id', '=', 'users.ciudad_expedicion_id')
        ->join('departamentos as departamento_expedicion', 'departamento_expedicion.id', '=', 'ciudad_expedicion.departamento_id')
        ->leftjoin('ocupaciones_users', 'ocupaciones_users.user_id', '=', 'users.id')
        ->leftjoin('ocupaciones', 'ocupaciones.id', '=', 'ocupaciones_users.ocupacion_id')
        ->leftJoin('user_nodo', 'user_nodo.user_id', '=', 'users.id');
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

    public function scopeSelectUserFuncionario($query)
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
            'users.fechanacimiento',
            'users.nombres',
            'users.apellidos',
            'user_nodo.role'
        )
        ->selectRaw("CONCAT(users.nombres,' ',users.apellidos) as nombre_completo, GROUP_CONCAT(roles.name, ',') AS roles")
        ->join('tiposdocumentos', 'tiposdocumentos.id', '=', 'users.tipodocumento_id')
        ->groupBy('users.documento');
    }

    public function scopeConsultarFuncionarios($query, $nodo = null, $role = null, $linea = null)
    {
        return $this->SelectUserFuncionario()->FuncionarioJoin()->RoleFuncionario($role)->NodoFuncionario($nodo)->LineaNodo($linea);
    }

    public function scopeConsultarUsuarios($query)
    {
        return $query->select('users.documento', 'users.id')
            ->selectRaw('CONCAT(users.nombres, " ", users.apellidos) AS talento')
            ->join('model_has_roles', function ($join) {
                $join->on('users.id', '=', 'model_has_roles.model_id')
                    ->where('model_has_roles.model_type', self::class);
            })
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->whereIn('roles.name', [self::IsUsuario(), self::IsTalento()]);
    }

    public function scopeRole($query, $role)
    {
        if (!empty($role) && $role != null && $role != 'all') {
            return $query->where('roles.name', $role);
        }
        return $query;
    }

    public function scopeRoleFuncionario($query, $role)
    {
        if (!empty($role) && $role != null && $role != 'all') {
            return $query->where('roles.name', $role)->where('user_nodo.role', $role);
        }
        return $query;
    }

    public function scopeNodoFuncionario($query, $nodo)
    {
        if (!empty($nodo) && $nodo != null && $nodo != 'all') {
            return $query->where('user_nodo.nodo_id', $nodo);
        }
        return $query;
    }

    public function scopeLineaNodo($query, $linea)
    {
        if (!empty($linea) && $linea != null && $linea != 'all') {
            return $query->where('user_nodo.linea_id', $linea);
        }
        return $query;
    }

    public function scopeRoleIn($query, $role)
    {
        if (!empty($role) && $role != null && $role != 'all') {
            return $query->whereHas('roles', function ($subQuery) use ($role) {
                $subQuery->whereIn('name', $role);
            });
        }
        return $query;
    }

    public function scopeRoleQuery($query, $roles)
    {
        if (isset($roles) && (!collect($roles)->contains('all'))) {
            return $query->roleIn($roles);
        }
        return $query;
    }

    public function scopeUserQuery($query)
    {
        $query->join('tiposdocumentos', 'tiposdocumentos.id', '=', 'users.tipodocumento_id')
        ->join('model_has_roles', function ($join) {
            $join->on('users.id', '=', 'model_has_roles.model_id')
                ->where('model_has_roles.model_type', User::class);
        })
        ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
        ->leftJoin('user_nodo', function ($join) {
            $join->on('users.id', '=', 'user_nodo.user_id');
        })->leftJoin('nodos', function ($join) {
            $join->on('nodos.id', '=', 'user_nodo.nodo_id');
        })->leftJoin('entidades', function ($join) {
            $join->on('entidades.id', '=', 'nodos.entidad_id');
        });
    }

    public function scopeNodeQuery($query, $roles, $nodos)
    {
        return $query->where(function($query) use($roles, $nodos){
            if(collect($roles)->contains('all') && !isset($nodos)){
                return $query;
            }

            // if(!collect($roles)->contains('all') && isset($nodos)){
            //     return $query->OrWhereIn('user_nodo.nodo_id', $nodos);
            // }
            if( isset($roles) &&
                (collect($roles)->contains(User::IsActivador()) ||
                collect($roles)->contains(User::IsAdministrador()) ||
                collect($roles)->contains(User::IsDesarrollador()) ||
                collect($roles)->contains(User::IsUsuario()) ||
                collect($roles)->contains(User::IsTalento()))
            ){
                return $query;
            }
            if(isset($nodos)){
                if(collect($roles)->contains('all') || collect($nodos)->contains('all')){
                    return $query;
                }
                return $query->OrWhereIn('user_nodo.nodo_id', $nodos);
            }
            return $query;

        });
    }




    public function scopeNodoUserQuery($query, $roles = null, $nodos = null)
    {
        if ((!empty($roles) && !collect($roles)->contains('all') && (!collect($roles)->contains(User::IsTalento())) && !empty($nodos) &&  !collect($nodos)->contains('all'))) {
            if (collect($roles)->contains(User::IsDinamizador())) {
                return $query->join('user_nodo', function ($join) {
                    $join->on('users.id', '=', 'user_nodo.user_id')
                        ->where('user_nodo.role', User::IsDinamizador());
                })->join('nodos', function ($join) use ($nodos) {
                    $join->on('nodos.id', '=', 'user_nodo.nodo_id')
                        ->whereIn('nodos.id', $nodos);
                });
            }
            if (collect($roles)->contains(User::IsExperto())) {
                return $query->join('user_nodo', function ($join) {
                    $join->on('users.id', '=', 'user_nodo.user_id')
                        ->where('user_nodo.role', User::IsExperto());
                })->join('nodos', function ($join) use ($nodos) {
                    $join->on('nodos.id', '=', 'user_nodo.nodo_id')
                        ->whereIn('nodos.id', $nodos);
                });
            }
            if (collect($roles)->contains(User::IsArticulador())) {
                return $query->join('user_nodo', function ($join) {
                    $join->on('users.id', '=', 'user_nodo.user_id')
                        ->where('user_nodo.role', User::IsArticulador());
                })->join('nodos', function ($join) use ($nodos) {
                    $join->on('nodos.id', '=', 'user_nodo.nodo_id')
                        ->whereIn('nodos.id', $nodos);
                });
            }
            if (collect($roles)->contains(User::IsApoyoTecnico())) {
                return $query->join('user_nodo', function ($join) {
                    $join->on('users.id', '=', 'user_nodo.user_id')
                        ->where('user_nodo.role', User::IsApoyoTecnico());
                })->join('nodos', function ($join) use ($nodos) {
                    $join->on('nodos.id', '=', 'user_nodo.nodo_id')
                        ->whereIn('nodos.id', $nodos);
                });
            }
            if (collect($roles)->contains(User::IsInfocenter())) {
                return $query->join('user_nodo', function ($join) {
                    $join->on('users.id', '=', 'user_nodo.user_id')
                        ->where('user_nodo.role', User::IsInfocenter());
                })->join('nodos', function ($join) use ($nodos) {
                    $join->on('nodos.id', '=', 'user_nodo.nodo_id')
                        ->whereIn('nodos.id', $nodos);
                });
            }
            if (collect($roles)->contains(User::IsIngreso())) {
                return $query->join('user_nodo', function ($join) {
                    $join->on('users.id', '=', 'user_nodo.user_id')
                        ->where('user_nodo.role', User::IsIngreso());
                })->join('nodos', function ($join) use ($nodos) {
                    $join->on('nodos.id', '=', 'user_nodo.nodo_id')
                        ->whereIn('nodos.id', $nodos);
                });
            }
            return $query->leftJoin('user_nodo', function ($join) {
                $join->on('users.id', '=', 'user_nodo.user_id');;
            });
        }
        return $query;
    }

    public function scopeStateDeletedAt($query, $state)
    {
        if (!empty($state) && $state != null && $state != 'all') {
            if ($state == 'si') {
                $state = User::IsActive();
                return $query->where('users.estado', $state);
            } else {
                $state = User::IsInactive();
                return $query->where('users.estado', $state)->onlyTrashed();
            }
        }
        return $query->withTrashed();
    }


    public function scopeFuncionarioJoin($query)
    {
        return $query->join('model_has_roles', function ($join) {
            $join->on('users.id', '=', 'model_has_roles.model_id')
                ->where('model_has_roles.model_type', self::class);
        })
        ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
        ->join('user_nodo', 'user_nodo.user_id', '=', 'users.id');
    }




    public function getNodoUser()
    {
        switch(session()->get('login_role')){
            case $this->IsDinamizador():
                return $this->dinamizador->nodo_id;
            break;
            case $this->IsExperto():
                return $this->experto->nodo_id;
            break;
            case $this->IsArticulador():
                return $this->articulador->nodo_id;
            break;
            case $this->IsInfocenter():
                return $this->infocenter->nodo_id;
            break;
            case $this->IsApoyoTecnico():
                return $this->apoyotecnico->nodo_id;
            break;
            case $this->IsIngreso():
                return $this->ingreso->nodo_id;
            break;
            default:
                return null;
                break;
        }
    }

    public function getLineaUser()
    {
        if (session()->get('login_role') == $this->IsExperto() && isset($this->user_nodo->lineatecnologica_id)) {
            return $this->user_nodo->lineatecnologica_id;
        }
        return null;
    }

    public static function enableTalentsArticulacion($articulacion)
    {
        foreach ($articulacion->talentos as $value) {
            $value->user()->withTrashed()->first()->restore();
            $value->user()->withTrashed()->first()->update(['estado' => self::IsActive()]);
        }
    }

    public function present()
    {
        return new UserPresenter($this);
    }
}
