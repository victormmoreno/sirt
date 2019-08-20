<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticulacionProyecto extends Model
{

  //Constatens del campo revisado_final
  const IS_POREVALUAR = 0;
  const IS_APROBADO   = 1;
  const IS_NOAPROBADO = 2;

  // Retorno para las constantes del campo revisado_final
  public static function IsPorEvaluar()
  {
      return self::IS_POREVALUAR;
  }

  public static function IsAprobado()
  {
      return self::IS_APROBADO;
  }

  public static function IsNoAprobado()
  {
      return self::IS_NOAPROBADO;
  }

  protected $table = 'articulacion_proyecto';
  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $fillable = [
    'entidad_id',
    'actividad_id',
    'revisado_final',
    'acta_inicio',
    'actas_seguimiento',
    'acta_cierre'
  ];

  /**
  * Relación muchos a muchos con la tabla de talentos
  * @return Eloquent
  */
  public function talentos()
  {
    return $this->belongsToMany(Talento::class, 'articulacion_proyecto_talento')
    ->withTimestamps()
    ->withPivot('talento_lider');
  }

  public function actividad()
  {
      return $this->belongsTo(Actividad::class, 'actividad_id', 'id');
  }

  public function proyecto()
  {
      return $this->hasOne(Proyecto::class, 'articulacion_proyecto_id', 'id');
  }

  public function articulacion()
  {
      return $this->hasOne(Articulacion::class, 'articulacion_proyecto_id', 'id');
  }

  public function entidad()
  {
      return $this->belongsTo(Entidad::class, 'entidad_id', 'id');
  }

}
