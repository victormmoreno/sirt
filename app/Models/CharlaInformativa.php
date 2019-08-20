<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharlaInformativa extends Model
{

  /**
   * Constantes para el modelo de charlasinformativas
   */
  const IS_ACTIVE = 1;
  const IS_INACTIVE = 0;
  /**
   * Retorno de la constante IS_ACTIVE
   * @return int
   */
  public static function IsActive()
  {
    return self::IS_ACTIVE;
  }

  /**
   * Retorno de la constante IS_INACTIVE
   * @return int
   */
  public static function IsInactive()
  {
    return self::IS_INACTIVE;
  }

  protected $table = 'charlasinformativas';

  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $fillable = [
    'nodo_id',
    'codigo_charla',
    'fecha',
    'encargado',
    'nro_asistentes',
    'observacion',
    'listado_asistentes',
    'evidencia_fotografica',
    'programacion'
  ];

  public function rutamodel()
  {
    return $this->morphMany(RutaModel::class, 'model');
  }
}
