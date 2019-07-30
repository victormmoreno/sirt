<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharlaInformativa extends Model
{
  protected $table = 'charlasinformativas';

  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $fillable = [
    'nodo_id',
    'fecha',
    'encargado',
    'nro_asistentes',
    'observacion',
    'listado_asistentes',
    'evidencia_fotografica',
    'programacion'
  ];
}
