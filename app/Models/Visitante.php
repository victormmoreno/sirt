<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitante extends Model
{
  protected $table = 'visitantes';

  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $fillable = [
    'tipodocumento_id',
    'tipovisitante_id',
    'documento',
    'nombres',
    'apellidos',
    'email',
    'contacto',
    'estado'
  ];

  const IS_INACTIVE = 0;
  const IS_ACTIVE = 1;

  public static function IsActive()
  {
    return self::IS_ACTIVE;
  }

  public function IsInactive()
  {
    return self::IS_INACTIVE;
  }

  public function tipodocumento()
  {
    return $this->belongsTo(TipoDocumento::class, 'tipodocumento_id', 'id');
  }

  public function tipovisitante()
  {
    return $this->belongsTo(TipoVisitante::class, 'tipovisitante_id', 'id');
  }

}
