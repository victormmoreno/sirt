<?php

namespace App;

use App\Http\Traits\User\UsersTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\User\{HasRoles, HasAcessorsMutators};
use App\Http\Traits\User\MustCompleteTalentInformation;
use App\Http\Traits\User\MustCompleteOfficerInformation;
use App\Contracts\User\MustCompleteTalentInformation as CompleteTalentInformationContract;
use App\Contracts\User\MustCompleteOfficerInformation as CompleteOfficerInformationContract;

class User extends Authenticatable implements JWTSubject,
    CompleteTalentInformationContract, CompleteOfficerInformationContract
{

    use SoftDeletes,
        Notifiable,
        HasRoles,
        HasAcessorsMutators,
        UsersTrait,
        MustCompleteTalentInformation,
        MustCompleteOfficerInformation;

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
    const IS_DESARROLLADOR  = "Desarrollador";
    const IS_ARTICULADOR    = "Articulador";
    const IS_APOYO_TECNICO  = "Apoyo Técnico";
    const IS_USUARIO        = "Usuario";
    const IS_AUXILIAR        = "Auxiliar";

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
        'informacion_user_completed_at',
        'deleted_at',
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
        'informacion_user'
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
        'fechanacimiento'      => 'date:Y-m-d',
        'informacion_user'  => 'array',
    ];

    public function scopeInfoUserBuilder($query)
    {
        return $query
        ->join('model_has_roles', function ($join) {
            $join->on('users.id', '=', 'model_has_roles.model_id')
                ->where('model_has_roles.model_type', self::class);
        })
        ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
        ->leftjoin('tiposdocumentos', 'tiposdocumentos.id', '=', 'users.tipodocumento_id')
        ->leftjoin('gradosescolaridad', 'gradosescolaridad.id', '=', 'users.gradoescolaridad_id')
        ->leftjoin('gruposanguineos', 'gruposanguineos.id', '=', 'users.gruposanguineo_id')
        ->leftjoin('eps', 'eps.id', '=', 'users.eps_id')
        ->leftjoin('etnias', 'etnias.id', '=', 'users.etnia_id')
        ->leftjoin('ciudades as ciudad_residencia', 'ciudad_residencia.id', '=', 'users.ciudad_id')
        ->leftjoin('departamentos as departamento_residencia', 'departamento_residencia.id', '=', 'ciudad_residencia.departamento_id')
        ->leftjoin('ciudades as ciudad_expedicion', 'ciudad_expedicion.id', '=', 'users.ciudad_expedicion_id')
        ->leftjoin('departamentos as departamento_expedicion', 'departamento_expedicion.id', '=', 'ciudad_expedicion.departamento_id')
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
            'user_nodo.role',
            'user_nodo.honorarios'
        )
        ->selectRaw("CONCAT(users.nombres,' ',users.apellidos) as nombre_completo, GROUP_CONCAT(roles.name, ',') AS roles")
        ->selectRaw('GROUP_CONCAT(DISTINCT roles.name SEPARATOR "; ") as roles')
        ->join('tiposdocumentos', 'tiposdocumentos.id', '=', 'users.tipodocumento_id')
        ->orderBy('users.nombres', 'asc')
        ->groupBy('users.documento');
    }

    public function scopeConsultarFuncionarios($query, $nodo = null, $role = null, $linea = null)
    {
        return $this->SelectUserFuncionario()->FuncionarioJoin()->RoleFuncionario($role)->NodoFuncionario($nodo)->LineaNodo($linea);
    }

    public function scopeConsultarUsuarios($query)
    {
        return $query->select('users.documento', 'users.id', 'users.nombres', 'users.apellidos', 'users.estado', 'users.created_at')
            ->selectRaw('CONCAT(users.nombres, " ", users.apellidos) AS talento')
            ->join('model_has_roles', function ($join) {
                $join->on('users.id', '=', 'model_has_roles.model_id')
                    ->where('model_has_roles.model_type', self::class);
            })
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->whereIn('roles.name', [self::IsUsuario(), self::IsTalento()]);
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
        if (session()->get('login_role') == $this->IsExperto()) {
            return $this->experto->linea_id;
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
}
