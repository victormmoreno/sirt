<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fase extends Model
{
  protected $table = 'fases';

  protected $fillable = [
    'nombre',
  ];
  
  public $timestamps = false;

  // Relación a la tabla de archivosarticulaciones
  public function archivosarticulaciones()
  {
    return $this->hasMany(ArchivoArticulacion::class, 'fase_id', 'id');
  }

}
