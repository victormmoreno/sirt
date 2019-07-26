<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchivoEntrenamiento extends Model
{
  protected $table = 'archivosentrenamiento';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'entrenamiento_id',
      'ruta',
  ];
}
