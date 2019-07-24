<?php

namespace App\Models;

use App\Http\Traits\EdtTrait\EdtTrait;
use Illuminate\Database\Eloquent\Model;

class Edt extends Model
{
  use EdtTrait;

  protected $table = 'edts';

  /**
   * Constante para el estado de la edt (Activo/Inactivo)
   * @var int
   */
  const IS_INACTIVE = 0;
  const IS_ACTIVE = 1;

  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $fillable = [
    'areaconocimiento_id',
    'gestor_id',
    'tipoedt_id',
    'codigo_edt',
    'nombre',
    'fecha_inicio',
    'fecha_fin',
    'observaciones',
    'empleados',
    'instructores',
    'aprendices',
    'publico',
    'estado',
    'fotografias',
    'listado_asistencia',
    'informe_final'
  ];

  /**
   * Relación muchos a muchos con la tabla de entidades
   * @return Eloquent
   */
  public function entidades()
  {
    return $this->belongsToMany(Entidad::class, 'edt_entidad')->withTimestamps();
  }

}
