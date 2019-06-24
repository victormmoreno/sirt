<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchivoArticulacion extends Model
{
  protected $table = 'archivosarticulaciones';

  protected $fillable = [
      'fase_id',
      'articulacion_id',
      'ruta',
  ];

  // Relacion a la tabla de fases
  public function fase()
  {
      return $this->belongsTo(Fase::class, 'fase_id', 'id');
  }

  // Relacion a la tabla de articulaciones
  public function articulacion()
  {
      return $this->belongsTo(Fase::class, 'articulacion_id', 'id');
  }
  
}
