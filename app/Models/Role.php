<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role AS RoleSpatie;
use App\User;

class Role extends RoleSpatie
{

  public function users_movimientos()
  {
    return $this->belongsToMany(User::class, 'movimientos_actividades_users_roles')
    ->withTimestamps();
  }

  public function movimientos()
  {
    return $this->belongsToMany(Movimiento::class, 'movimientos_actividades_users_roles')
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
}
