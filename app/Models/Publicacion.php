<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publicacion extends Model
{
  protected $table = 'publicaciones';

  protected $casts = [
    'fecha_inicio' => 'date_format:"Y-m-d"',
    'fecha_fin' => 'date_format:"Y-m-d"',
  ];

  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $fillable = [
    'user_id', // Llave foranea
    'role_id', // Llave foranea
    'codigo_publicacion',
    'titulo',
    'contenido',
    'fecha_inicio',
    'fecha_fin',
    'estado'
  ];

  /**
  * Constantes para el campo de estado
  */
  // Estado que indica que la publicación NO está activa
  const IS_INACTIVA = 0;
  // Estado que indica que la publicación está activa
  const IS_ACTIVA = 1;

  // Retorno para las constantes del campo estado_aprobacion
  public static function IsActiva()
  {
    return self::IS_ACTIVA;
  }

  public static function IsInactiva()
  {
    return self::IS_INACTIVA;
  }
}
