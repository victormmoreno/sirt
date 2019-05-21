<?php

namespace App;

use App\Models\ActivationToken;
use App\Models\DinamizadorInfocenter;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasRoles;

    protected $appends = ['nombre_completo'];



    protected $dates = [
        'ultimo_login',
        'fechanacimiento'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'documento',
        'nombres',
        'apellidos',
        'email',
        'direccion',
        'telefono',
        'celular',
        'fechanacimiento',
        'descripcion_ocupacion',
        'password',
        'estado',
        'genero_id',
        'tipodocumento_id',
        'ciudad_id',
        'rol_id',
        'ocupacion_id',
        'estrato_id',
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
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function setNombresAttribute($nombres)
    {
        $this->attributes['nombres'] = ucfirst($nombres);
    }

    public function setApellidosAttribute($apellidos)
    {
        $this->attributes['apellidos'] = ucfirst($apellidos);
    }

    
    

    public function getNombreCompletoAttribute()
    {
        return ucfirst($this->nombres) . ' ' . ucfirst($this->apellidos);
    }

    /*===========================================
    =            relaciones eloquent            =
    ===========================================*/
    
    public function estrato()
    {
        return $this->belongsTo(Estrato::class, 'estrato_id', 'id');
    }

     public function dinamizadorInfocenters()
    {
        return $this->hasMany(DinamizadorInfocenter::class, 'user_id', 'id');
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

}
