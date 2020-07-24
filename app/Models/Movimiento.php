<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Movimiento extends Model
{
    protected $table = 'movimientos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'movimiento',
        'comentarios'
    ];

    public function actividades_movimientos()
    {
        return $this->belongsToMany(Actividad::class, 'movimientos_actividades_users_roles')
            ->withTimestamps();
    }

    public function users_movimientos()
    {
        return $this->belongsToMany(User::class, 'movimientos_actividades_users_roles')
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
}
