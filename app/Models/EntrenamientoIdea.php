<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntrenamientoIdea extends Model
{
  protected $table = 'entrenamiento_idea';

  protected $fillable = [
    'idea_id',
    'entrenamiento_id',
    'confirmacion',
    'canvas',
    'asistencia1',
    'asistencia2',
    'convocado_csibt',
  ];

}
