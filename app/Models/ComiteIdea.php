<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComiteIdea extends Model
{
  protected $table = 'comite_idea';

  protected $casts = [
    'hora'  => 'datetime:H-i',
  ];

  protected $fillable = [
    'idea_id',
    'comite_id',
    'hora',
    'admitido',
    'asistencia',
    'observaciones',
  ];

}
