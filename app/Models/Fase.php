<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fase extends Model
{
  protected $table = 'fases';
  public $timestamps = false;

  const IS_INICIO = 1;
  const IS_PLANEACION = 2;
  const IS_EJECUCION = 3;
  const IS_CIERRE = 4;
  const IS_SUSPENDIDO = 5;
  const IS_FINALIZADO = 6;

  protected $fillable = [
    'nombre',
  ];

  // Retorno para las constantes del campo fase
  public static function IsInicio()
  {
    return self::IS_INICIO;
  }

  public static function IsPlaneacion()
  {
      return self::IS_PLANEACION;
  }
  public static function IsEjecucion()
  {
      return self::IS_EJECUCION;
  }

  public static function IsCierre()
  {
      return self::IS_CIERRE;
  }

  public static function IsSuspendido()
  {
      return self::IS_SUSPENDIDO;
  }

  public static function IsFinalizado()
  {
      return self::IS_FINALIZADO;
  }

  public function proyectos()
  {
      return $this->hasMany(Proyecto::class, 'fase_id', 'id');
  }

  public function articulacionespbt()
  {
      return $this->hasMany(ArticulacionPbt::class, 'fase_id', 'id');
  }

  public function archivomodel()
  {
      return $this->hasMany(ArchivoModel::class, 'fase_id', 'id');
  }

  public function articulaciones()
  {
      return $this->hasMany(Articulacion::class, 'fase_id', 'id');
  }

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

  public function roles_movimiento()
  {
      return $this->belongsToMany(Role::class, 'movimientos_actividades_users_roles')
          ->withTimestamps();
  }

  public function movimientos()
  {
    return $this->belongsToMany(Movimiento::class, 'movimientos_actividades_users_roles')
    ->withTimestamps();
  }

}
