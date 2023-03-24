<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IngresoVisitante extends Model
{
  protected $table = 'ingresos_visitantes';

  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $fillable = [
    'visitante_id',
    'nodo_id',
    'user_id',
    'servicio_id',
    'fecha_ingreso',
    'hora_salida',
    'quien_autoriza',
    'descripcion'
  ];
}
