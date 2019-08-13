<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{

  protected $table = 'actividades';

  protected $casts = [
    'fecha_inicio'    => 'date:Y-m-d',
    'fecha_cierre'    => 'date:Y-m-d',
  ];

  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $fillable = [
    'gestor_id',
    'nodo_id',
    'codigo_actividad',
    'nombre',
    'fecha_inicio',
    'fecha_cierre'
  ];

}
