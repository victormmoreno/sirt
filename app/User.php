<?php

namespace App;

use App\Http\Traits\UserTrait\UsersTrait;
use App\Models\ActivationToken;
use App\Models\Ciudad;
use App\Models\Dinamizador;
use App\Models\Eps;
use App\Models\Gestor;
use App\Models\GradoEscolaridad;
use App\Models\GrupoSanguineo;
use App\Models\Infocenter;
use App\Models\Ingreso;
use App\Models\Ocupacion;
use App\Models\Rols;
use App\Models\Talento;
use App\Models\TipoDocumento;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{

    use Notifiable, HasRoles, UsersTrait;

    const IS_MASCULINO     = 1;
    const IS_FEMENINO      = 0;
    const IS_ACTIVE        = true;
    const IS_INACTIVE      = false;
    const IS_ADMINISTRADOR = "Administrador";
    const IS_DINAMIZADOR   = "Dinamizador";
    const IS_GESTOR        = "Gestor";
    const IS_INFOCENTER    = "Infocenter";
    const IS_TALENTO       = "Talento";
    const IS_INGRESO       = "Ingreso";
    const IS_PROVEEDOR     = "Proveedor";

    protected $appends = ['nombre_completo'];

    protected $dates = [
        'ultimo_login',
        'fechanacimiento',
        'fecha_terminacion',
    ];

    public $items = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rol_id',
        'tipodocumento_id',
        'gradoescolaridad_id',
        'gruposanguineo_id',
        'eps_id',
        'ciudad_id',
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
        'estado',
        'institucion',
        'titulo_obtenido',
        'fecha_terminacion',
        'password',
        'estrato',
        'otra_eps',
        'otra_ocupacion',
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
        'email_verified_at' => 'datetime',
        'fechanacimiento'   => 'date:Y-m-d',
    ];

    /*===========================================
    =            relaciones eloquent            =
    ===========================================*/
    public function users()
    {
        return $this->hasMany(User::class, 'rol_id', 'id');
    }

    //relaciones muchos a muchos

    public function ocupaciones()
    {
        return $this->belongsToMany(Ocupacion::class, 'ocupaciones_users')
            ->withTimestamps();

    }

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_id', 'id');
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

    public function dinamizador()
    {
        return $this->hasOne(Dinamizador::class, 'user_id', 'id');
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

    /*=====  End of relaciones eloquent  ======*/

    public function scopeInfoUserRole($query,array $role = [] , array $relations = [])
    {

        return $query->with($relations)
            ->role($role);
            
    }


    /*==============================================================================
    =            scope para mostrar informacion relevante en datatables            =
    ==============================================================================*/

    public function scopeInfoUserDatatable($query)
    {
        return $query->select('users.id', 'tiposdocumentos.nombre as tipodocumento', 'users.documento', 'users.email', 'users.direccion', 'users.celular', 'users.telefono', 'users.estado')
            ->selectRaw("CONCAT(users.nombres,' ',users.apellidos) as nombre")
            ->Join('tiposdocumentos', 'tiposdocumentos.id', '=', 'users.tipodocumento_id');
    }

    /*=====  End of scope para mostrar informacion relevante en datatables  ======*/





}
