<?php

namespace App;

use App\Http\Traits\UsersTrait;
use App\Models\{ActivationToken,Ciudad,Dinamizador,Eps,Gestor,GradoEscolaridad,GrupoSanguineo,Infocenter,Ingreso,Ocupacion,Rols,Talento,TipoDocumento};

use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{

    use Notifiable, HasRoles, UsersTrait;

    const IS_MASCULINO = 1;
    const IS_FEMENINO  = 0;
    const IS_ACTIVE    = true;
    const IS_INACTIVE  = false;
    const IS_ADMINISTRADOR = "Administrador";
    const IS_DINAMIZADOR = "Dinamizador";
    const IS_GESTOR = "Gestor";
    const IS_INFOCENTER = "Infocenter";
    const IS_TALENTO = "Talento";
    const IS_INGRESO = "Ingreso";
    const IS_PROVEEDOR = "Proveedor";

    
    protected $appends = ['nombre_completo'];

    protected $dates = [
        'ultimo_login',
        'fechanacimiento',
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

    public function rol()
    {
        return $this->belongsTo(Rols::class, 'rol_id', 'id');
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


    public function scopeInfoUserNodo($query, $role, $nodo)
    {

        return $query->select(['users.id', 'users.documento', 'users.nombres', 'users.apellidos', 'users.email', 'users.direccion as user_direccion', 'users.telefono', 'users.celular', 'users.fechanacimiento', 'users.descripcion_ocupacion', 'users.estado', DB::raw("CONCAT('Tecnoparque Nodo ',nodos.nombre) as nombrenodo"), 'nodos.direccion as nodo_direccion'])
            ->join('nodos', 'nodos.id', '=', 'users.nodo_id')
            ->role($role)
            ->where('nodos.id', '=', $nodo);
    }

}
