<?php

namespace App;

use App\Models\ActivationToken;
use App\Models\Ciudad;
use App\Models\Dinamizador;
use App\Models\Eps;
use App\Models\Gestor;
use App\Models\GradoEscolaridad;
use App\Models\GrupoSanguineo;
use App\Models\GrupoSanquineo;
use App\Models\Infocenter;
use App\Models\Ingreso;
use App\Models\Ocupacion;
use App\Models\Rols;
use App\Models\Talento;
use App\Models\TipoDocumento;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{

    use Notifiable, HasRoles;

    const IS_MASCULINO = 1;
    const IS_FEMENINO  = 0;
    const IS_ACTIVE    = true;
    const IS_INACTIVE  = false;
    // const ESTRATO = array(1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5', 6 => '6');

    // protected $appends = ['nombre_completo','apellidos','nombres'];
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
        'password',
        'estrato',
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

    public function getRouteKeyName()
    {
        return 'nombres'; // db column name
    }

    public static function IsMasculino()
    {
        return User::IS_MASCULINO;
    }
    public static function IsFemenino()
    {
        return User::IS_FEMENINO;
    }

    public static function IsActive()
    {
        return User::IS_ACTIVE;
    }
    public static function IsInactive()
    {
        return User::IS_INACTIVE;
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    /*==============================================
    =            mutador para el nombre            =
    ==============================================*/

    public function setNombresAttribute($nombres)
    {
        $this->attributes['nombres'] = strtolower($nombres);
        $this->attributes['nombres'] = ucfirst($nombres);
    }

    // public function getNombresAttribute()
    // {
    //     return ucfirst(strtolower($this->nombres));
    // }

    /*=====  End of mutador para el nombre  ======*/

    /*================================================
    =            mutador para el apellido            =
    ================================================*/

    public function setApellidosAttribute($apellidos)
    {
        $this->attributes['apellidos'] = strtolower($apellidos);
        $this->attributes['apellidos'] = ucfirst($apellidos);
    }

    // public function getApellidosAttribute()
    // {
    //     return ucfirst(strtolower($this->apellidos));
    // }

    /*=====  End of mutador para el apellido  ======*/

    public function getNombreCompletoAttribute()
    {
        return ucfirst(strtolower($this->nombres)) . ' ' . ucfirst(strtolower($this->apellidos));
    }

    /*===========================================
    =            relaciones eloquent            =
    ===========================================*/

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



    /*=====  End of relaciones eloquent  ======*/

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify((new ResetPasswordNotification($token))->onQueue('authentication'));
        // $this->notify((new ResetPasswordNotification($token))->onQueue('authentication')->delay(now()->addMinutes(10)));
        // \Notification::send($this, new ResetPasswordNotification($token));
    }

    public function activate()
    {
        $this->update(['estado' => true]);

        Auth::login($this);

        $this->token->delete();
    }

    public function token()
    {
        return $this->hasOne(ActivationToken::class);
    }

    public function generateToken()
    {
        $this->token()->create([
            'token' => str_random(60),
        ]);

        return $this;

    }

    /*================================================================
    =            metodo para generar contraseña aleatoria            =
    ================================================================*/
    public static function generatePasswordRamdom()
    {
        return str_random(9);
    }

    /*=====  End of metodo para generar contraseña aleatoria  ======*/

    public function scopeInfoUserNodo($query, $role, $nodo)
    {

        return $query->select(['users.id', 'users.documento', 'users.nombres', 'users.apellidos', 'users.email', 'users.direccion as user_direccion', 'users.telefono', 'users.celular', 'users.fechanacimiento', 'users.descripcion_ocupacion', 'users.estado', DB::raw("CONCAT('Tecnoparque Nodo ',nodos.nombre) as nombrenodo"), 'nodos.direccion as nodo_direccion'])
            ->join('nodos', 'nodos.id', '=', 'users.nodo_id')
            ->role($role)
            ->where('nodos.id', '=', $nodo);
    }

    /*=================================================================
    =            ejemplo para preguntar por fechas futuras            =
    =================================================================*/

    public function isUpdated()
    {
        return !is_null($this->updated_at) && $this->updated_at < today();
    }

    /*=====  End of ejemplo para preguntar por fechas futuras  ======*/

}
