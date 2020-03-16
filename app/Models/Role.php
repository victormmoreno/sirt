<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role AS RoleSpatie;
use App\User;

class Role extends RoleSpatie
{
  /**
   * Relación a la tabla users
   * @return Eloquent
   * @author dum
   */
  public function users_aprobacion()
  {
    return $this->belongsToMany(User::class, 'aprobaciones')
    ->withTimestamps()
    ->withPivot('aprobacion');
  }

  /**
   * Relación a la tabla proyectos
   * @return Eloquent
   * @author dum
   */
  public function proyectos()
  {
    return $this->belongsToMany(Proyecto::class, 'aprobaciones')
    ->withTimestamps()
    ->withPivot('aprobacion');
  }

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
