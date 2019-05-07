<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoVisitante extends Model
{
  protected $table = 'tipovisitante';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'nombre',
  ];
}
