<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fase extends Model
{
  protected $table = 'fases';
  public $timestamps = false;

  protected $fillable = [
    'nombre',
  ];

  public function proyectos()
  {
      return $this->hasMany(Proyecto::class, 'fase_id', 'id');
  }

  public function articulaciones()
  {
      return $this->hasMany(Articulacion::class, 'fase_id', 'id');
  }

}
