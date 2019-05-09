<?php

namespace App;

use App\User;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasRoles;

    protected $appends = ['nombre_completo'];

    protected $dates = [
        'fechanacimiento',
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

    // public function setPasswordAttribute($password)
    // {
    //     $this->attributes['password'] = bcrypt($password);
    // }

    public function setLastnameAttribute($nombres)
    {
        $this->attributes['nombres'] = ucfirst($nombres);
    }

    public function getNombreCompletoAttribute()
    {
        return $this->nombres . ' ' . $this->apellidos;
    }

    public function estrato()
    {
        return $this->belongsTo(Estrato::class, 'estrato_id', 'id');
    }

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

}
